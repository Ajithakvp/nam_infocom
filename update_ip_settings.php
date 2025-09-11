<?php
include("config.php");
global $fileipsettingxmlPath;

if (isset($_POST['iptype'], $_POST['ipaddress'], $_POST['ip_id'])) {
    $iptype   = $_POST['iptype'];
    $ipaddress  = $_POST['ipaddress'];
    $ip_id    = $_POST['ip_id'];

    $sqlupchk = "SELECT * FROM public.ip_setting WHERE ip_address = '$ipaddress' AND id = '$ip_id'";
    $resupchk = pg_query($con, $sqlupchk);
    if (pg_num_rows($resupchk) > 0) {
        echo "No changes made";
        exit;
    }

    // Update query
    $sql = "UPDATE public.ip_setting 
            SET ip_address = '$ipaddress' 
            WHERE id = '$ip_id'";
    $result = pg_query($con, $sql);

    if ($result) {

        $ipname    = $_POST['iptype']; // from form
        $ip_add    = $_POST['ipaddress'];

        // Path to FreeSWITCH XML
        $filePath = $fileipsettingxmlPath;

        // Load XML as DOM
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        if (!$dom->load($filePath)) {
            die("❌ Failed to load XML file: $filePath");
        }

        // Decide which params to update
        if ($ipname === "External_Rtp_IP & Sip_IP") {
            $targets = ["ext-rtp-ip", "ext-sip-ip"];
        } elseif ($ipname === "Internal_Rtp_IP & Sip_IP") {
            $targets = ["rtp-ip", "sip-ip"];
        } else {
            die("❌ Invalid ipname. Use 'External_Rtp_IP & Sip_IP' or 'Internal_Rtp_IP & Sip_IP'.");
        }

        // XPath to find params
        $xpath = new DOMXPath($dom);

        foreach ($targets as $t) {
            $nodes = $xpath->query("//param[@name='$t']");
            foreach ($nodes as $node) {
                if ($node instanceof DOMElement) {   // ✅ ensure it's an element
                    $node->setAttribute("value", $ip_add);
                }
            }
        }

        // Save back to file
        if ($dom->save($filePath)) {
            echo "✅ Updated $ipname with IP: $ip_add";
            include("reloadxml.php");
        } else {
            echo "❌ Failed to save XML. Run PHP/Apache as Administrator.";
            logError(pg_last_error($con));
        }
    } else {
        echo "Update failed!";
        logError(pg_last_error($con));
    }
}
