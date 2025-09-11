<?php
include("config.php");
include("chksession.php");
global $db_backup_path;


$message = ""; // Initialize message
if (isset($_POST['create_db'])) {

  $res = pg_query($con, "SELECT 1 FROM pg_database WHERE datname='$db'");
  if (pg_num_rows($res) == 0) {
    $createDb = pg_query($con, "CREATE DATABASE \"$db\" OWNER $user");
    if (!$createDb) die("Error creating DB: " . pg_last_error());
    echo "Database '$db' created.<br>";
  } else {
    echo "Database '$db' already exists.<br>";
  }
  pg_close($con);

  // Step 2: Reconnect to target DB
  $con = pg_connect("host=$host port=$port dbname=$db user=$user password=$pass");
  if (!$con) die("Connection to target DB failed: " . pg_last_error());

  // Helper functions
  function tableExists($con, $table)
  {
    $res = pg_query($con, "
        SELECT EXISTS (
            SELECT FROM information_schema.tables 
            WHERE table_schema='public' AND table_name='$table'
        );
    ");
    $row = pg_fetch_row($res);
    return $row[0] === 't';
  }

  // Step 3: Define ALL 21 table schemas
  $tables = [
    "subscriber" => "
CREATE TABLE public.subscriber (
    subscriber_id character varying(50) NOT NULL,
    password character varying(50) NOT NULL,
    action_date timestamp without time zone,
    id bigint NOT NULL
);",

    "group_setting" => "
CREATE TABLE public.group_setting (
    group_number VARCHAR(50),
    action_date TIMESTAMP,
    id SERIAL PRIMARY KEY,
    group_name VARCHAR(100),
    conference VARCHAR(100),
    user_details VARCHAR(4000),
    calltype VARCHAR(100),
    moderate VARCHAR(1000)
);",

    "ip_setting" => "
CREATE TABLE public.ip_setting (
    ip_name VARCHAR(50),
    ip_address VARCHAR(50),
    action_date TIMESTAMP,
    id BIGINT PRIMARY KEY
);",

    "layout_setting" => "
CREATE TABLE public.layout_setting (
    layoutnumber VARCHAR(50),
    action_date TIMESTAMP,
    id BIGINT PRIMARY KEY
);",

    "agent_subscriber_profile" => "
CREATE TABLE public.agent_subscriber_profile (
    id BIGINT PRIMARY KEY,
    first_name VARCHAR(50),
    last_name VARCHAR(50),
    subscriber_id VARCHAR(50),
    country_code VARCHAR(50),
    mobile_no VARCHAR(50),
    subscriber_password VARCHAR(50),
    activated_date TIMESTAMP,
    expiry_date TIMESTAMP,
    res_no VARCHAR(50),
    email VARCHAR(50),
    company_name VARCHAR(50),
    addr_1 VARCHAR(50),
    addr_2 VARCHAR(50),
    city VARCHAR(50),
    state VARCHAR(50),
    country VARCHAR(50),
    designation VARCHAR(50),
    area_code VARCHAR(50),
    office_no VARCHAR(50),
    extension_no VARCHAR(50),
    email_notification_sent VARCHAR(50),
    sms_notification_sent VARCHAR(50),
    groupid VARCHAR(50),
    smssent BOOLEAN,
    profile VARCHAR(50),
    pbx VARCHAR(50),
    status INTEGER,
    timezone VARCHAR(100),
    timedifference DOUBLE PRECISION,
    gmtsign BOOLEAN,
    daylightsaving BOOLEAN,
    dststartmonth VARCHAR(10),
    dststartdate VARCHAR(10),
    dstendmonth VARCHAR(10),
    dstenddate VARCHAR(10),
    imsino VARCHAR(150),
    ipphoneno VARCHAR(50),
    mobileuser BOOLEAN,
    landlineuser BOOLEAN,
    ipphoneuser BOOLEAN,
    mobionuser BOOLEAN,
    license_type VARCHAR(30),
    days_of_validity VARCHAR(5),
    action_date TIMESTAMP
);",

    "agent_contacts" => "
CREATE TABLE public.agent_contacts (
    contactid SERIAL PRIMARY KEY,
    firstname VARCHAR(50) NOT NULL,
    lastname VARCHAR(50) NOT NULL,
    email VARCHAR(100),
    phonenumber VARCHAR(20),
    address VARCHAR(255),
    city VARCHAR(100),
    state VARCHAR(100),
    zipcode VARCHAR(20),
    createddate TIMESTAMP DEFAULT now()
);",

    "chats" => "
CREATE TABLE public.chats (
    chatid SERIAL PRIMARY KEY,
    senderid INTEGER NOT NULL,
    receiverid INTEGER NOT NULL,
    message TEXT NOT NULL,
    sentat TIMESTAMP DEFAULT now(),
    isread BOOLEAN DEFAULT false,
    attachment BYTEA,
    attachmentname VARCHAR(255),
    attachmenttype VARCHAR(100),
    ftp_url TEXT,
    attachmentsize VARCHAR(100)
);",

    "agent_useractivity" => "
CREATE TABLE public.agent_useractivity (
    id SERIAL PRIMARY KEY,
    subscriber_id VARCHAR(100) NOT NULL,
    mobile_no VARCHAR(100) NOT NULL,
    action VARCHAR(100) NOT NULL,
    regstatus TEXT NOT NULL,
    \"timestamp\" TIMESTAMP DEFAULT now()
);",

    "agent_cdr" => "
CREATE TABLE public.agent_cdr (
    id SERIAL PRIMARY KEY,
    callid VARCHAR(100),
    fromnumber VARCHAR(50),
    tonumber VARCHAR(50),
    callstarttime TIMESTAMP,
    callendtime TIMESTAMP,
    callduration VARCHAR(50),
    calltype VARCHAR(50),
    calldirection VARCHAR(50),
    callstatus VARCHAR(50),
    recordingurl VARCHAR(255),
    notes TEXT,
    fromcountry VARCHAR(20),
    tocountry VARCHAR(20),
    filename VARCHAR(100),
    call_types VARCHAR(100)
);",

    "click2call_cdr" => "
CREATE TABLE public.click2call_cdr (
    id SERIAL PRIMARY KEY,
    callid VARCHAR(100),
    fromnumber VARCHAR(50),
    tonumber VARCHAR(50),
    callstarttime TIMESTAMP,
    callendtime TIMESTAMP,
    callduration VARCHAR(50),
    calltype VARCHAR(50),
    callstatus VARCHAR(50),
    recordingurl VARCHAR(255),
    notes TEXT,
    fromcountry VARCHAR(20),
    tocountry VARCHAR(20),
    filename VARCHAR(100)
);",

    "conference_layouts" => "
CREATE TABLE public.conference_layouts (
    id BIGINT PRIMARY KEY,
    layoutname VARCHAR(50),
    action_date TIMESTAMP
);",

    "mobiweb_cdr" => "
CREATE TABLE public.mobiweb_cdr (
    id SERIAL PRIMARY KEY,
    callid VARCHAR(100),
    fromnumber VARCHAR(50),
    tonumber VARCHAR(50),
    callstarttime TIMESTAMP,
    callendtime TIMESTAMP,
    callduration VARCHAR(50),
    calltype VARCHAR(50),
    calldirection VARCHAR(50),
    callstatus VARCHAR(50),
    recordingurl VARCHAR(255),
    notes TEXT,
    fromcountry VARCHAR(20),
    tocountry VARCHAR(20),
    filename VARCHAR(100),
    call_types VARCHAR(100)
);",

    "pbx_cdr" => "
CREATE TABLE public.pbx_cdr (
    id SERIAL PRIMARY KEY,
    call_reference_no VARCHAR(50),
    from_number VARCHAR(50),
    to_number VARCHAR(50),
    dialed_time TIMESTAMP,
    call_connected_time TIMESTAMP,
    call_disconnected_time TIMESTAMP,
    status VARCHAR(50)
);",

    "pbx_fs" => "
CREATE TABLE public.pbx_fs (
    id SERIAL PRIMARY KEY,
    name VARCHAR(100),
    designation VARCHAR(100),
    country VARCHAR(50),
    extension_number VARCHAR(100)
);",

    "call_details_fs" => "
CREATE TABLE public.call_details_fs (
    id SERIAL PRIMARY KEY,
    subscriber_id VARCHAR(50),
    call_ref_id VARCHAR(50),
    calling_number VARCHAR(50),
    called_number VARCHAR(50),
    call_type VARCHAR(20),
    call_offer_time TIMESTAMP,
    call_connected_time TIMESTAMP,
    call_disconnected_time TIMESTAMP,
    call_duration VARCHAR(10),
    calling_no_ip VARCHAR(50),
    called_no_ip VARCHAR(50),
    imei_no VARCHAR(50),
    imsi_no VARCHAR(50),
    disconnected_reason VARCHAR(100),
    network_mode INTEGER,
    calling_number_city VARCHAR(100),
    called_number_city VARCHAR(100),
    calling_number_country VARCHAR(100),
    called_number_country VARCHAR(100),
    cas_export_f VARCHAR(1),
    bwinmb VARCHAR(20),
    calltype VARCHAR(2),
    filename VARCHAR(250),
    filesize VARCHAR(10),
    im_message_time TIMESTAMP,
    reason VARCHAR(50),
    groupid VARCHAR(50),
    missedcallstatus INTEGER,
    callednumbernetworkmode INTEGER,
    conferenceid VARCHAR(50),
    message TEXT,
    encryption INTEGER,
    groupname VARCHAR(100)
);",

    "gps_details" => "
CREATE TABLE public.gps_details (
    id SERIAL PRIMARY KEY,
    mobile_number VARCHAR(20),
    latitude TEXT,
    longitude TEXT,
    name VARCHAR(1000),
    action_date TIMESTAMP,
    department VARCHAR(100)
);",

    "takeconference_list" => "
CREATE TABLE public.takeconference_list (
    id SERIAL PRIMARY KEY,
    from_number character varying(15),
    to_number character varying(4000),
    conferenceid character varying(50),
    action_date timestamp without time zone
);",

    "port_setting" => "
CREATE TABLE public.port_setting (
    id SERIAL PRIMARY KEY,
    portnumber VARCHAR(50),
    portname VARCHAR(50),
    action_date TIMESTAMP
);",

    "registrationnumbers" => "
CREATE TABLE public.registrationnumbers (
    number integer NOT NULL,
    status character varying(20) NOT NULL,
    lastupdated timestamp without time zone DEFAULT now(),
    CONSTRAINT registrationnumbers_status_check CHECK (((status)::text = ANY ((ARRAY['Registered'::character varying, 'Unregistered'::character varying])::text[])))
);",

    "t_registered" => "
CREATE TABLE public.t_registered (
    skey bigint,
    namealias character varying(300),
    nameoriginal character varying(300),
    urlalias character varying(300),
    urloriginal character varying(300),
    acceptpattern character varying(300),
    requester character varying(100),
    expires bigint,
    priority integer,
    timeupdate bigint,
    expirestime bigint,
    mappedport character varying(100),
    awake integer,
    useragent character varying(300),
    param character varying(300)
);"

  ];

  // Step 4: Create all tables
  foreach ($tables as $name => $ddl) {
    if (!tableExists($con, $name)) {
      $create = pg_query($con, $ddl);
      if ($create) {




        $message = '<div style="
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            text-align: center;
        ">
            <label style="
                font-size: 16px;
                color: #333;
            ">
               <strong>All Table created successfully.</strong>
            </label>
        </div>';
      } else {
        $message =  "Error creating table '$name': " . pg_last_error() . "<br>";
      }
    } else {
      $message =  "All Table  already exists.<br>";
    }
  }



  /**
   * Helper function to insert defaults if table is empty
   */
  function insert_defaults($con, $table, $sql)
  {
    $check = pg_query($con, "SELECT 1 FROM {$table} LIMIT 1");
    if (!$check) {
      die("Error checking {$table}: " . pg_last_error($con));
    }
    if (pg_num_rows($check) == 0) {
      $insert = pg_query($con, $sql);
      if (!$insert) {
        die("Error inserting into {$table}: " . pg_last_error($con));
      } else {
        //echo "{$table} default values inserted.<br>";
      }
    } else {
      //echo "{$table} already has data.<br>";
    }
  }

  /** --------------------------
   *  Insert default data
   *  -------------------------- */

  // conference_layouts defaults
  insert_defaults($con, "conference_layouts", "
    INSERT INTO conference_layouts (layoutname, action_date, id) VALUES
    ('1x1', NULL, '1'),
    ('1x2', NULL, '2'),
    ('2x1', NULL, '3'),
    ('2x1-zoom', NULL, '4'),
    ('3x1-zoom', NULL, '5'),
    ('5-grid-zoom', NULL, '6'),
    ('3x2-zoom', NULL, '7'),
    ('7-grid-zoom', NULL, '8'),
    ('4x2-zoom', NULL, '9'),
    ('1x1+2x1', NULL, '10'),
    ('2x2', NULL, '11'),
    ('3x3', NULL, '12'),
    ('4x4', NULL, '13'),
    ('5x5', NULL, '14'),
    ('6*6', NULL, '15'),
    ('8*8', NULL, '16')
");

  // ip_setting defaults
  insert_defaults($con, "ip_setting", "
    INSERT INTO ip_setting (ip_name, ip_address, action_date, id) VALUES
    ('External_Rtp_IP & Sip_IP', '10.185.13.35', NULL, '5'),
    ('Internal_Rtp_IP & Sip_IP', '10.185.13.38', NULL, '6')
");

  // layout_setting defaults
  insert_defaults($con, "layout_setting", "
    INSERT INTO layout_setting (layoutnumber, action_date, id) VALUES
    ('7-grid-zoom', NULL, '1')
");

  // port_setting defaults
  insert_defaults($con, "port_setting", "
    INSERT INTO port_setting (portnumber, portname, action_date, id) VALUES
    ('508', 'Internal_Sip_Port', NULL, '4'),
    ('509', 'Internal_Tls_Port', NULL, '2'),
    ('600', 'WSS_Port', NULL, '5'),
    ('511', 'External_Sip_Port', NULL, '3'),
    ('517', 'External_Tls_port', NULL, '1')
");

  // registrationnumbers defaults
  insert_defaults($con, "registrationnumbers", "
    INSERT INTO registrationnumbers (number, status, lastupdated) VALUES
    ('1233', 'Unregistered', '2025-12-07 00:00:00')
");

  // subscriber defaults
  insert_defaults($con, "subscriber", "
    INSERT INTO subscriber (subscriber_id, password, action_date, id) VALUES
    ('Default', 'Naminfocom@1234589', NULL, '1')
");
}

if (isset($_POST['backup_db'])) {

  $backupFile = $db . "_backup_" . date("Y-m-d_H-i-s") . ".sql";
  $backupDir  = __DIR__ . "/" . $db_backup_path;
  $backupPath = $backupDir . "/" . $backupFile;

  if (!is_dir($backupDir) && !mkdir($backupDir, 0777, true)) {
    http_response_code(500);
    die("Failed to create backup directory");
  }

  $sqlDump  = "-- PostgreSQL Backup of database: $db\n";
  $sqlDump .= "-- Generated on " . date("Y-m-d H:i:s") . "\n\n";
  $sqlDump .= "SET client_encoding = 'UTF8';\n";
  $sqlDump .= "SET standard_conforming_strings = on;\n";
  $sqlDump .= "SET check_function_bodies = false;\n";
  $sqlDump .= "SET client_min_messages = warning;\n\n";

  $tablesRes = pg_query($con, "
        SELECT tablename 
        FROM pg_tables 
        WHERE schemaname = 'public'
        ORDER BY tablename
    ");
  if (!$tablesRes) {
    http_response_code(500);
    die(pg_last_error($con));
  }

  $tables = [];
  while ($row = pg_fetch_assoc($tablesRes)) {
    $tables[] = $row['tablename'];
  }

  foreach ($tables as $table) {
    $sqlDump .= "\n-- ----------------------------\n";
    $sqlDump .= "-- Table structure for \"$table\"\n";
    $sqlDump .= "-- ----------------------------\n";
    $sqlDump .= "DROP TABLE IF EXISTS \"$table\" CASCADE;\n";

    $colsRes = pg_query($con, "
            SELECT column_name, data_type, character_maximum_length, is_nullable, column_default
            FROM information_schema.columns
            WHERE table_schema = 'public' AND table_name = '$table'
            ORDER BY ordinal_position
        ");

    $colDefs = [];
    while ($col = pg_fetch_assoc($colsRes)) {
      $line = "\"{$col['column_name']}\" {$col['data_type']}";
      if ($col['character_maximum_length']) {
        $line .= "({$col['character_maximum_length']})";
      }
      if ($col['column_default']) {
        $line .= " DEFAULT {$col['column_default']}";
      }
      if ($col['is_nullable'] === "NO") {
        $line .= " NOT NULL";
      }
      $colDefs[] = $line;
    }
    $sqlDump .= "CREATE TABLE \"$table\" (\n    " . implode(",\n    ", $colDefs) . "\n);\n\n";

    $sqlDump .= "-- Dumping data for \"$table\"\n";
    $dataRes = pg_query($con, "SELECT * FROM \"$table\"");
    while ($row = pg_fetch_assoc($dataRes)) {
      $columns = array_keys($row);
      $values  = array_map(function ($val) use ($con) {
        if ($val === null) return "NULL";
        return "'" . pg_escape_string($con, $val) . "'";
      }, array_values($row));

      $sqlDump .= "INSERT INTO \"$table\" (\"" . implode("\",\"", $columns) . "\") VALUES (" . implode(",", $values) . ");\n";
    }
    $sqlDump .= "\n";
  }

  if (file_put_contents($backupPath, $sqlDump)) {
    $message = '<div style="
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            text-align: center;
        ">
            <label style="
                font-size: 16px;
                color: #333;
            ">
               <strong> Backup Path : ' . $backupPath . ' - Backup created successfully..</strong>
            </label>
        </div>';
  } else {
    http_response_code(500);
    $message = '<div style="
            border: 1px solid #ccc;
            border-radius: 12px;
            padding: 20px;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            max-width: 600px;
            margin: 20px auto;
            font-family: Arial, sans-serif;
            text-align: center;
        ">
            <label style="
                font-size: 16px;
                color: #333;
            ">
               <strong> Backup Path : ' . $backupPath . ' - Backup created Failure..</strong>
            </label>
        </div>';
  }
}


?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DB Backup</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <?php include("sidebar.php"); ?>
    <div class="body-wrapper">
      <?php include("header.php"); ?>
      <div class="container-fluid">
        <div class="table-responsive">
          <form method="post">
            <table class="table table-bordered text-center mt-4">
              <thead>
                <tr>
                  <th>
                    <button class="btn btn-primary" type="submit" name="create_db">
                      <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;DB Creation
                    </button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <button class="btn btn-primary" type="submit" name="backup_db">
                      <i class="fa fa-cloud-upload"></i> &nbsp;&nbsp;DB Backup (SQL)
                    </button>
                    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>

</body>

</html>