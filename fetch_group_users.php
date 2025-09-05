<?php
include("config.php");
$id = $_POST['id'] ?? 0;

$sql = "SELECT * FROM public.group_setting WHERE id=$id";
$result = pg_query($con, $sql);

$users = [];
if ($result && pg_num_rows($result) > 0) {
    while ($row = pg_fetch_assoc($result)) {
        $users[] = $row['user_details'];
    }
}
echo json_encode($users);
