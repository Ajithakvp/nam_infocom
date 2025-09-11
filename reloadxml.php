<?php
$host = '0.0.0.0';   // ✅ Use IPv4 loopback
$port = 8021;
$password = 'ClueCon';

$fp = fsockopen($host, $port, $errno, $err, 5);
if (!$fp) {
    die("Unable to connect: $err ($errno)");
}

fwrite($fp, "auth $password\n\n");
fwrite($fp, "api reloadxml\n\n");
fclose($fp);

//echo "Reloaded XML successfully.";
?>
