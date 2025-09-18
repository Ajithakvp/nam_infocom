<?php
require_once('../config.php');

$sql = "SELECT * FROM public.subscriber_profile  WHERE subscriber_id !='admin' ORDER BY id ASC ";
$result = pg_query($con, $sql);
if (!$result) {
    echo json_encode(array("status" => "error", "message" => pg_last_error($con)));
    exit;
}
if (pg_num_rows($result) == 0) {
    echo json_encode(array("status" => "error", "message" => "No data found"));
    exit;
}
$data = array();
while ($row = pg_fetch_assoc($result)) {
    $data[] = $row;
}
echo json_encode(array("status" => "success", "data" => $data));
