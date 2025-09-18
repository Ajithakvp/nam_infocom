<?php
require_once('../config.php');
$Mobile_Number = $_REQUEST['mobileNumber'];
$sqlchk = "SELECT * FROM public.gps_details WHERE mobile_number='$Mobile_Number'";
$reschk = pg_query($con, $sqlchk);
if (pg_num_rows($reschk) == 0) {
    echo json_encode(array("status" => "error", "message" => "No record found"));
    exit;
}
$sql = "DELETE FROM public.gps_details WHERE mobile_number='$Mobile_Number'";
$result = pg_query($con, $sql);
if ($result) {
    echo json_encode(array("status" => "success", "message" => "Record deleted successfully"));
} else {
    echo json_encode(array("status" => "error", "message" => pg_last_error($con)));
}
