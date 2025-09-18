<?php
require_once('../config.php');


// Read values safely (NULL if not provided)
$Subscriber_ID           = $_REQUEST['Subscriber_ID'];
$Call_Ref_ID             = $_REQUEST['Call_Ref_ID'];
$Calling_Number          = $_REQUEST['Calling_Number'];
$Called_Number           = $_REQUEST['Called_Number'];
$Call_Type               = $_REQUEST['Call_Type'];
$Call_Offer_Time         = $_REQUEST['Call_Offer_Time'];
$Call_Connected_Time     = $_REQUEST['Call_Connected_Time'];
$Call_disConnected_Time  = $_REQUEST['Call_disConnected_Time'];
$Call_Duration           = $_REQUEST['Call_Duration'];
$Disconnected_Reason     = $_REQUEST['Disconnected_Reason'];
$calltype                = $_REQUEST['calltype'];
$Calling_No_Ip           = $_REQUEST['Calling_No_Ip'];
$Called_No_Ip            = $_REQUEST['Called_No_Ip'];
$IMEI_NO                 = $_REQUEST['IMEI_NO'];
$IMSI_NO                 = $_REQUEST['IMSI_NO'];
$Network_Mode            = $_REQUEST['Network_Mode'];
$Calling_Number_City     = $_REQUEST['Calling_Number_City'];
$Called_Number_City      = $_REQUEST['Called_Number_City'];
$Calling_Number_Country  = $_REQUEST['Calling_Number_Country'];
$Called_Number_Country   = $_REQUEST['Called_Number_Country'];
$CAS_EXPORT_F            = $_REQUEST['CAS_EXPORT_F'];
$BWinMB                  = $_REQUEST['BWinMB'];
$filename                = $_REQUEST['filename'];
$filesize                = $_REQUEST['filesize'];
$IM_Message_TIME         = $_REQUEST['IM_Message_TIME'];
$Reason                  = $_REQUEST['Reason'];
$groupid                 = $_REQUEST['groupid'];
$missedcallstatus        = $_REQUEST['missedcallstatus'];
$callednumbernetworkmode = $_REQUEST['callednumbernetworkmode'];
$conferenceid            = $_REQUEST['conferenceid'];
$message                 = $_REQUEST['message'];
$Encryption              = $_REQUEST['Encryption'];
$Groupname               = $_REQUEST['Groupname'];


if ($Network_Mode == "") {
    $Network_Mode = '0';
}
if ($missedcallstatus == "") {
    $missedcallstatus = '0';
}

if ($callednumbernetworkmode == "") {
    $callednumbernetworkmode = '0';
}

if ($Encryption == "") {
    $Encryption = '0';
}


if ($Call_Offer_Time == "") {
    $Call_Offer_Time = "0000-00-00 00:00:00";
}

if ($Call_Connected_Time == "") {
    $Call_Connected_Time = "0000-00-00 00:00:00";
}

if ($Call_disConnected_Time == "") {
    $Call_disConnected_Time = "0000-00-00 00:00:00";
}

if ($IM_Message_TIME == "") {
    $IM_Message_TIME = "0000-00-00 00:00:00";
}

$sql = "INSERT INTO public.call_details_fs(
    subscriber_id, call_ref_id, calling_number, called_number, call_type, 
    call_offer_time, call_connected_time, call_disconnected_time, call_duration, disconnected_reason, 
    calltype, calling_no_ip, called_no_ip, imei_no, imsi_no, 
    network_mode, calling_number_city, called_number_city, calling_number_country, called_number_country, 
    cas_export_f, bwinmb, filename, filesize, im_message_time,
    reason, groupid, missedcallstatus, callednumbernetworkmode, conferenceid,
    message, encryption, groupname
) VALUES (
    '$Subscriber_ID', '$Call_Ref_ID', '$Calling_Number', '$Called_Number', '$Call_Type',
    '$Call_Offer_Time', '$Call_Connected_Time', '$Call_disConnected_Time', '$Call_Duration', '$Disconnected_Reason',
    '$calltype', '$Calling_No_Ip', '$Called_No_Ip', '$IMEI_NO', '$IMSI_NO',
    '$Network_Mode', '$Calling_Number_City', '$Called_Number_City', '$Calling_Number_Country', '$Called_Number_Country',
    '$CAS_EXPORT_F', '$BWinMB', '$filename', '$filesize', '$IM_Message_TIME',
    '$Reason', '$groupid', '$missedcallstatus', '$callednumbernetworkmode', '$conferenceid',
    '$message', '$Encryption', '$Groupname'
)";
$result = pg_query($con, $sql);

if ($result) {
    echo json_encode(["status" => "success", "message" => "Data inserted successfully"]);
} else {
    // Log the error, but return safe JSON
    // error_log(pg_last_error($con));
    echo json_encode(["status" => "error", "message" => "Database insert failed"]);
}
