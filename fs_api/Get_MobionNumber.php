<?php

require_once('../config.php');

$sql = "SELECT first_name,last_name,mobile_no FROM public.subscriber_profile WHERE subscriber_id !='admin' ORDER BY id ASC ";
$result = pg_query($con, $sql);
if (pg_num_rows($result) > 0) {
    $rows = array();
    while ($row = pg_fetch_assoc($result)) {
        $data = array();
        $data['Name'] = $row['first_name'] . ' ' . $row['last_name'];
        $data['mobile_no'] = $row['mobile_no'];
        $rows[] = $data;
    }
    echo json_encode(array("status" => "success", "data" => $rows));
} else {
    echo json_encode(array("status" => "error", "message" => "No records found"));
}
