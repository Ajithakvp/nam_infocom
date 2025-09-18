<?php
require_once('../config.php');
$number = $_REQUEST['Number'];
$escaped = pg_escape_string($con, $number);

$sql = "SELECT * 
        FROM public.group_setting 
        WHERE user_details LIKE '%$escaped%' 
           OR moderate LIKE '%$escaped%' 
        ORDER BY id ASC";
$result = pg_query($con, $sql);
if (!$result) {
    echo json_encode(array("status" => "error", "message" => pg_last_error($con)));
    exit;
}
if (pg_num_rows($result) == 0) {
    echo json_encode(array("status" => "error", "message" => "No group settings found"));
    exit;
}
$data = array();
while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode(array("status" => "success", "data" => $data));
