<?php
require_once('../config.php');
$Mobile_Number = $_REQUEST['Mobile_Number'];
$Latitude = $_REQUEST['Latitude'];
$Longitude = $_REQUEST['Longitude'];
$Name = $_REQUEST['Name'];
$Department = $_REQUEST['Department'];
$action_date = date("Y-m-d H:i:s");


$sqlchk = "SELECT * FROM public.gps_details WHERE mobile_number='$Mobile_Number'";
$reschk = pg_query($con, $sqlchk);

if (pg_num_rows($reschk) > 0) {
    $sqlup = "UPDATE public.gps_details SET latitude='$Latitude', longitude='$Longitude', name='$Name', department='$Department',action_date='$action_date' WHERE mobile_number='$Mobile_Number'";
    $result = pg_query($con, $sqlup);
    if ($result) {
        echo json_encode(array("status" => "success", "message" => "Data updated successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => pg_last_error($con)));
    }
    exit;
} else {

    $sql = "INSERT INTO public.gps_details(mobile_number, latitude, longitude, name, department,action_date) VALUES ('$Mobile_Number', '$Latitude', '$Longitude', '$Name', '$Department','$action_date')";
    $result = pg_query($con, $sql);
    if ($result) {
        echo json_encode(array("status" => "success", "message" => "Data inserted successfully"));
    } else {
        echo json_encode(array("status" => "error", "message" => pg_last_error($con)));
    }
}
