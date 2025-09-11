<?php
include("config.php");

// Allow cross-browser POST handling
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {

    // Ensure variables exist
    if (!isset($db) || !isset($con)) {
        http_response_code(500);
        die("Database config missing");
    }

    $backupFile = $db . "_backup_" . date("Y-m-d_H-i-s") . ".sql";
    $backupDir  = __DIR__ . "/db_backup";
    $backupPath = $backupDir . "/" . $backupFile;

    if (!is_dir($backupDir) && !mkdir($backupDir, 0777, true)) {
        http_response_code(500);
        die("Failed to create backup directory");
    }

    $sqlDump  = "-- PostgreSQL Backup of database: $db\n";
    $sqlDump .= "-- Generated on " . date("Y-m-d H:i:s") . "\n\n";
    $sqlDump .= "SET client_encoding = 'UTF8';\n";
    $sqlDump .= "SET standard_conforming_strings = on;\n";
    $sqlDump .= "SET check_function_bodies = false;\n";
    $sqlDump .= "SET client_min_messages = warning;\n\n";

    $tablesRes = pg_query($con, "
        SELECT tablename 
        FROM pg_tables 
        WHERE schemaname = 'public'
        ORDER BY tablename
    ");
    if (!$tablesRes) {
        http_response_code(500);
        die(pg_last_error($con));
    }

    $tables = [];
    while ($row = pg_fetch_assoc($tablesRes)) {
        $tables[] = $row['tablename'];
    }

    foreach ($tables as $table) {
        $sqlDump .= "\n-- ----------------------------\n";
        $sqlDump .= "-- Table structure for \"$table\"\n";
        $sqlDump .= "-- ----------------------------\n";
        $sqlDump .= "DROP TABLE IF EXISTS \"$table\" CASCADE;\n";

        $colsRes = pg_query($con, "
            SELECT column_name, data_type, character_maximum_length, is_nullable, column_default
            FROM information_schema.columns
            WHERE table_schema = 'public' AND table_name = '$table'
            ORDER BY ordinal_position
        ");

        $colDefs = [];
        while ($col = pg_fetch_assoc($colsRes)) {
            $line = "\"{$col['column_name']}\" {$col['data_type']}";
            if ($col['character_maximum_length']) {
                $line .= "({$col['character_maximum_length']})";
            }
            if ($col['column_default']) {
                $line .= " DEFAULT {$col['column_default']}";
            }
            if ($col['is_nullable'] === "NO") {
                $line .= " NOT NULL";
            }
            $colDefs[] = $line;
        }
        $sqlDump .= "CREATE TABLE \"$table\" (\n    " . implode(",\n    ", $colDefs) . "\n);\n\n";

        $sqlDump .= "-- Dumping data for \"$table\"\n";
        $dataRes = pg_query($con, "SELECT * FROM \"$table\"");
        while ($row = pg_fetch_assoc($dataRes)) {
            $columns = array_keys($row);
            $values  = array_map(function ($val) use ($con) {
                if ($val === null) return "NULL";
                return "'" . pg_escape_string($con, $val) . "'";
            }, array_values($row));

            $sqlDump .= "INSERT INTO \"$table\" (\"" . implode("\",\"", $columns) . "\") VALUES (" . implode(",", $values) . ");\n";
        }
        $sqlDump .= "\n";
    }

    if (file_put_contents($backupPath, $sqlDump)) {
        echo "1"; // Success
    } else {
        http_response_code(500);
        echo "0"; // Failure
    }
    exit;
}

http_response_code(400);
echo "Invalid request";
