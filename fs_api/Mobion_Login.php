<?php
require_once('../config.php');
$username = $_REQUEST['UserName'];
$password = $_REQUEST['Password'];
$sql = "SELECT * FROM public.subscriber_profile WHERE subscriber_id='$username' AND subscriber_password='$password'";
$result = pg_query($con, $sql);
if (pg_num_rows($result) > 0) {
    $row = pg_fetch_assoc($result);
    echo json_encode(array("status" => "success", "data" => $row));
} else {
    echo json_encode(array("status" => "error", "message" => "Invalid username or password"));
}
