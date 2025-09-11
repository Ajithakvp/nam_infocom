<?php

session_start();
$configFile = __DIR__ . '/allconfig.txt';

// Parse key-value pairs
$config = parse_ini_file($configFile);

if (!$config) {
    die("Error: Unable to load configuration file.");
}
if ($config['ERROR_LOG'] == "1") {
    require_once "error_logger.php"; // include logger
}


// $host = "localhost";
// $port = "5432";        // Default PostgreSQL port
// $db   = "nam_info_test";     // Database name
// $user = "postgres";    // PostgreSQL username
// $pass = "admin";       // PostgreSQL password



$host = $config['DB_HOST'];
$user = $config['DB_USER'];
$pass = $config['DB_PASS'];
$db = $config['DB_NAME'];
$port = $config['DB_PORT'];


// First connect to the default 'postgres' database to check/create DB
$con = pg_connect("host=$host port=$port dbname=postgres user=$user password=$pass");

if (!$con) {
    die("Connection to PostgreSQL failed: " . pg_last_error());
    logError("Query failed: " . pg_last_error($con));
}

// Step 1: Check if DB exists
$res = pg_query($con, "SELECT 1 FROM pg_database WHERE datname='$db'");
if (!$res) {
    die("Error checking database: " . pg_last_error());
}

if (pg_num_rows($res) == 0) {
    $createDb = pg_query($con, "CREATE DATABASE \"$db\" OWNER $user");
    if (!$createDb) {
        die("Error creating database: " . pg_last_error());
        logError("Query failed: " . pg_last_error($con));
    } else {
        //echo "Database '$db' created successfully.<br>";
    }
} else {
    //echo "Database '$db' already exists.<br>";
}

pg_close($con);

// Reconnect to target DB
$con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass");
if (!$con) {
    die("Connection to target DB failed: " . pg_last_error());
    logError("Query failed: " . pg_last_error($con));
}



// Step 2: Check if table exists
$tableName = "subscriber_profile";   // corrected
$res = pg_query($con, "
    SELECT EXISTS (
        SELECT FROM information_schema.tables 
        WHERE table_schema='public' AND table_name='$tableName'
    );
");

if (!$res) {
    die("Error checking table: " . pg_last_error());
    logError("Query failed: " . pg_last_error($con));
}

$row = pg_fetch_row($res);
if ($row[0] === 't') {
    //echo "Table '$tableName' already exists.<br>";
} else {
    // Create table with PRIMARY KEY and auto-increment
    $createTable = "
    CREATE TABLE public.subscriber_profile (
        id SERIAL PRIMARY KEY,
        first_name VARCHAR(100),
        last_name VARCHAR(100),
        subscriber_id VARCHAR(50),
        country_code VARCHAR(10),
        mobile_no VARCHAR(50),
        subscriber_password VARCHAR(255),
        activated_date TIMESTAMP,
        expiry_date TIMESTAMP,
        res_no VARCHAR(50),
        email VARCHAR(255),
        company_name VARCHAR(255),
        addr_1 VARCHAR(255),
        addr_2 VARCHAR(255),
        city VARCHAR(100),
        state VARCHAR(100),
        country VARCHAR(100),
        designation VARCHAR(100),
        area_code VARCHAR(50),
        office_no VARCHAR(50),
        extension_no VARCHAR(50),
        email_notification_sent VARCHAR(10),
        sms_notification_sent VARCHAR(10),
        groupid VARCHAR(50),
        smssent INTEGER,
        profile VARCHAR(50),
        pbx VARCHAR(50),
        status INTEGER,
        timezone VARCHAR(50),
        timedifference VARCHAR(50),
        gmtsign VARCHAR(10),
        daylightsaving INTEGER,
        dststartmonth VARCHAR(20),
        dststartdate VARCHAR(20),
        dstendmonth VARCHAR(20),
        dstenddate VARCHAR(20),
        imsino VARCHAR(100),
        ipphoneno VARCHAR(100),
        mobileuser INTEGER,
        landlineuser INTEGER,
        ipphoneuser INTEGER,
        mobionuser INTEGER,
        license_type VARCHAR(50),
        days_of_validity VARCHAR(50),
        action_date TIMESTAMP,
        mobion VARCHAR(50),
        mobiweb VARCHAR(50)
    );

    ALTER TABLE public.subscriber_profile OWNER TO $user;
    ";

    $create = pg_query($con, $createTable);
    if (!$create) {
        die("Error creating table: " . pg_last_error());
    } else {
        //echo "Table '$tableName' created successfully.<br>";
    }
}

// Step 3: Insert initial Admin row if not exists
$checkAdmin = pg_query($con, "SELECT 1 FROM subscriber_profile WHERE subscriber_id='admin'");
if (pg_num_rows($checkAdmin) == 0) {
    $insert = pg_query($con, "
        INSERT INTO subscriber_profile (
            first_name, last_name, subscriber_id, subscriber_password, profile, smssent, status
        ) VALUES (
            NULL, NULL, 'admin', 'admin', 'Admin', 0, 0
        );
    ");
    if (!$insert) {
        die("Error inserting initial data: " . pg_last_error());
        logError("Query failed: " . pg_last_error($con));
    } else {
        //echo "Initial Admin record inserted.<br>";
    }
} else {
    //echo "Admin record already exists.<br>";
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
