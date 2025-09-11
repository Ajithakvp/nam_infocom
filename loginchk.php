<?php
include("config.php");

$username = $_REQUEST['username'];
$password = $_REQUEST['password'];

$sql = "SELECT * FROM public.subscriber_profile 
            WHERE subscriber_id = '$username'
              AND subscriber_password = '$password'
            ORDER BY id ASC";

$res = pg_query($con, $sql);


if ($res && pg_num_rows($res) > 0) {
  $row = pg_fetch_array($res);
  if (empty($row['first_name'])) {
    $_SESSION['username'] = strtoupper($row['subscriber_id']);
  } else {
    $_SESSION['username'] = strtoupper($row['first_name'] . " " . $row['last_name']);
  }
  $_SESSION['type'] = strtolower($row['profile']);
  $_SESSION['subscriber_id'] = strtolower($row['subscriber_id']);

  echo "success";
} else {
  echo "0";
  logError(pg_last_error($con));
}
