<?php
session_start();
$host = "localhost";
$port = "5432";        // Default PostgreSQL port
$db   = "nam_info";     // Database name
$user = "postgres";    // PostgreSQL username
$pass = "admin"; // PostgreSQL password

// Connection string
$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass");

if (!$con) {
    die("Connection failed: " . pg_last_error());
}
// else {
//     echo "Connected successfully";
// }
date_default_timezone_set('Asia/Kolkata');

//Windows Freeswitch Xml Path Location
$fileadduserxmlpath = "C:/Program Files/FreeSWITCH/conf/directory/default";
$filesubidxmlPath = "C:/Program Files/FreeSWITCH/conf/vars.xml";
$fileipsettingxmlPath = "C:/Program Files/FreeSWITCH/conf/sip_profiles/internal.xml";
$fileportsettingxmlPath = "C:/Program Files/FreeSWITCH/conf/vars.xml";
$filelayoutsetxmlPath = "C:\\Program Files\\FreeSWITCH\\conf\\autoload_configs\\conference.conf.xml";
$filegrupSettingxmlPath = "C:/Program Files/FreeSWITCH/conf/dialplan/default.xml";









