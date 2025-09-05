<?php
include("config.php");
global $filesubidxmlPath;

if (isset($_POST['username'], $_POST['passwordstr'])) {
    $username   = $_POST['username'];
    $passwordstr  = $_POST['passwordstr'];

    $sqlupchk = "SELECT * FROM public.subscriber WHERE subscriber_id = '$username' AND password = '$passwordstr'";
    $resupchk = pg_query($con, $sqlupchk);
    if (pg_num_rows($resupchk) > 0) {
        echo "No changes made";
        exit;
    }

    // Update query
    $sql = "UPDATE public.subscriber 
            SET subscriber_id = '$username', password = '$passwordstr' 
            WHERE id = '1'";
    $result = pg_query($con, $sql);

    if ($result) {

        $password = $_POST['passwordstr']; // new password from form

        // Path to FreeSWITCH vars.xml
        $filePath = $filesubidxmlPath;

        // Load XML
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        if (!$dom->load($filePath)) {
            die("❌ Failed to load XML file: $filePath");
        }

        // XPath search
        $xpath = new DOMXPath($dom);
        $nodes = $xpath->query("//X-PRE-PROCESS[@cmd='set']");

        foreach ($nodes as $node) {
            if ($node instanceof DOMElement) {
                $dataAttr = $node->getAttribute("data");

                // Check if it starts with default_password=
                if (strpos($dataAttr, "default_password=") === 0) {
                    $node->setAttribute("data", "default_password=" . $password);
                }
            }
        }

        // Save file
        if ($dom->save($filePath)) {
            echo "✅ Updated Successfully !";
        } else {
            echo "❌ Failed to save vars.xml. Run PHP/Apache as Administrator.";
        }
    } else {
        echo "Update failed!";
    }
}
