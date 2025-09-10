<?php
$msg = "";

function tablecheck($con, $tablename)
{
    global $msg; // Make $msg accessible inside the function

    // Prepare the query to check table existence
    $checkTable = "SELECT to_regclass('public." . pg_escape_string($tablename) . "')";
    $checkResult = pg_query($con, $checkTable);

    if (!$checkResult) {
        // Query failed
        $msg = '<div style="
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            text-align: center;
        ">
            <label style="
                font-size: 16px;
                color: #333;
            ">
                Error checking table <strong>' . htmlspecialchars($tablename) . '</strong>.
            </label>
        </div>';
        return 0;
    }

    $checkRow = pg_fetch_row($checkResult);

    if ($checkRow[0] === null) {
        // Table does not exist
        $msg = '<div style="
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            text-align: center;
        ">
            <label style="
                font-size: 16px;
                color: #333;
            ">
                No Table Found in Database: <strong>' . htmlspecialchars($tablename) . '</strong>.<br>
                Please go to the <strong>DB Creation Menu</strong> and click the <strong>DB Creation Button</strong> to create all tables.
            </label>
        </div>';
        return 0;
    } else {
        // Table exists
        $msg = ""; // No message needed
        return 1;
    }
}

// Example usage
// tablecheck($con, "subscriber");
// echo $msg;
?>
