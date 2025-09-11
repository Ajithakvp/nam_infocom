<?php
include("config.php");
global $fileportsettingxmlPath;

if (isset($_POST['port_id'], $_POST['portname'], $_POST['portno'])) {
    $port_id   = $_POST['port_id'];
    $portname  = $_POST['portname'];
    $portno    = $_POST['portno'];

    $sqlupchk = "SELECT * FROM public.port_setting WHERE portnumber = '$portno' AND id = '$port_id'";
    $resupchk = pg_query($con, $sqlupchk);
    if (pg_num_rows($resupchk) > 0) {
        echo "No changes made";
        exit;
    }

    // Update query
    $sql = "UPDATE public.port_setting 
            SET  portnumber = '$portno' 
            WHERE id = '$port_id'";
    $result = pg_query($con, $sql);

    if ($result) {


        // Path to vars.xml
        $filePath = $fileportsettingxmlPath;

        // Parameter name and new value
        $pname   = strtolower($portname);
        $newPort = $portno; // your new port number

        // Load file into DOM
        $xml = new DOMDocument();
        $xml->preserveWhiteSpace = false;
        $xml->formatOutput = true;

        if (!$xml->load($filePath)) {
            die("❌ Failed to load vars.xml");
        }

        // Find all <X-PRE-PROCESS> nodes
        $updated = false;
        $nodes = $xml->getElementsByTagName("X-PRE-PROCESS");

        foreach ($nodes as $node) {
            $cmd  = $node->getAttribute("cmd");
            $data = $node->getAttribute("data");

            // Match external_sip_port=xxxx
            if ($cmd === "set" && strpos($data, $pname . "=") === 0) {
                $node->setAttribute("data", $pname . "=" . $newPort);
                $updated = true;
                break;
            }
        }

        if ($updated) {
            // Backup old file
            copy($filePath, $filePath . ".bak");

            // Save updated XML
            if ($xml->save($filePath)) {
                echo "Record updated (Port NO: $portno)";
            } else {
                echo "❌ Failed to save vars.xml (check permissions)";
                logError(pg_last_error($con));
            }
        } else {
            echo "⚠ $pname not found in vars.xml";
            logError(pg_last_error($con));
        }
    } else {
        echo "Update failed!";
        logError(pg_last_error($con));
    }
}
