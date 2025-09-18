<?php 
require_once('../config.php');
$regnumber = $_REQUEST['regnumber'];
$sql = "SELECT * FROM public.gps_details WHERE mobile_number='$regnumber'";
$result = pg_query($con, $sql); 
if (pg_num_rows($result) > 0) {
    $data = array();
    while ($row = pg_fetch_assoc($result)) {
        $data[] = $row;
    }
    echo json_encode(array("status" => "success", "data" => $data));
} else {
    echo json_encode(array("status" => "error", "message" => "No records found"));
}

?>