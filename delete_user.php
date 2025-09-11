<?php
include("config.php"); // your DB connection
global $fileadduserxmlpath;

if (isset($_POST['id'])) {
    $id = intval($_POST['id']); // sanitize
    $userid = trim($_POST['user_id']);


    $sql = "DELETE FROM public.subscriber_profile WHERE id = $id";
    $result = pg_query($con, $sql);

    if ($result) {


        $user_id = $userid;  // <- replace with dynamic value
        $folder  = $fileadduserxmlpath;

        // Ensure folder exists
        if (!is_dir($folder)) {
            die("❌ Directory not found: $folder\n");
        }

        $filePath = $folder . "/" . $user_id . ".xml";

        if (!file_exists($filePath)) {
            die("⚠️ User file not found: $filePath\n");
        }

        // Try deleting the file
        if (@unlink($filePath)) {
            echo "success";
            include("reloadxml.php");
        } else {
            die("❌ Failed to delete file. Check permissions.\n");
        }
    } else {
        echo "error";
        logError("Query failed: " . pg_last_error($con));
    }
} else {
    echo "error";
    logError("Query failed: " . pg_last_error($con));
}
