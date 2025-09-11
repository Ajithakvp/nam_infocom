<?php
include("config.php");
// File name
if (isset($_POST['action'])) {
    $backupFile = $db . "_backup_" . date("Y-m-d_H-i-s") . ".sql";
    $backupDir  = __DIR__ . "/db_backup";   // Folder to store backups
    $backupPath = $backupDir . "/" . $backupFile;

    // Ensure folder exists
    if (!is_dir($backupDir)) {
        mkdir($backupDir, 0777, true);
    }

    // Start SQL dump
    $sqlDump = "-- PostgreSQL Backup of database: $db\n";
    $sqlDump .= "-- Generated on " . date("Y-m-d H:i:s") . "\n\n";
    $sqlDump .= "SET client_encoding = 'UTF8';\n";
    $sqlDump .= "SET standard_conforming_strings = on;\n";
    $sqlDump .= "SET check_function_bodies = false;\n";
    $sqlDump .= "SET client_min_messages = warning;\n\n";

    // Step 1: Get all tables in public schema
    $tablesRes = pg_query($con, "
    SELECT tablename 
    FROM pg_tables 
    WHERE schemaname = 'public'
    ORDER BY tablename
");
    $tables = [];
    while ($row = pg_fetch_assoc($tablesRes)) {
        $tables[] = $row['tablename'];
    }

    // Step 2: Loop tables
    foreach ($tables as $table) {
        $sqlDump .= "\n-- ----------------------------\n";
        $sqlDump .= "-- Table structure for \"$table\"\n";
        $sqlDump .= "-- ----------------------------\n";

        // Drop table if exists
        $sqlDump .= "DROP TABLE IF EXISTS \"$table\" CASCADE;\n";

        // Get columns
        $colsRes = pg_query($con, "
        SELECT column_name, data_type, character_maximum_length, is_nullable, column_default
        FROM information_schema.columns
        WHERE table_schema = 'public' AND table_name = '$table'
        ORDER BY ordinal_position
    ");

        $colDefs = [];
        while ($col = pg_fetch_assoc($colsRes)) {
            $line = '"' . $col['column_name'] . '" ' . $col['data_type'];

            if ($col['character_maximum_length']) {
                $line .= "(" . $col['character_maximum_length'] . ")";
            }
            if ($col['column_default']) {
                $line .= " DEFAULT " . $col['column_default'];
            }
            if ($col['is_nullable'] === "NO") {
                $line .= " NOT NULL";
            }
            $colDefs[] = $line;
        }

        $sqlDump .= "CREATE TABLE \"$table\" (\n    " . implode(",\n    ", $colDefs) . "\n);\n\n";

        // Step 3: Dump data
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

    pg_close($con);

    // Step 3.5: Save backup file in directory
    file_put_contents($backupPath, $sqlDump);

    // Step 4: Send to browser for download
    header('Content-Type: application/sql');
    header('Content-Disposition: attachment; filename="' . $backupFile . '"');
    header('Pragma: no-cache');
    header('Expires: 0');

    echo $sqlDump;
}
