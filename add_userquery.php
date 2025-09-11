<?php
include("config.php");
global $fileadduserxmlpath;

// Collect POST safely
$addfirstName       = trim($_POST['addfirstName'] ?? '');
$addlastName        = trim($_POST['addlastName'] ?? '');
$addemail           = trim($_POST['addemail'] ?? '');
$addmobileNo        = trim($_POST['addmobileNo'] ?? '');
$addcountry         = trim($_POST['addcountry'] ?? '');
$adduserId          = trim($_POST['adduserId'] ?? '');
$addpassword        = trim($_POST['addpassword'] ?? '');
$addtimezone        = trim($_POST['addtimezone'] ?? '');
$addgroupId         = trim($_POST['addgroupId'] ?? '');
$addpbxNo           = trim($_POST['addpbxNo'] ?? '');
$addcompanyName     = trim($_POST['addcompanyName'] ?? '');
$adddesignation     = trim($_POST['adddesignation'] ?? '');
$addaddress         = trim($_POST['addaddress'] ?? '');
$addcity            = trim($_POST['addcity'] ?? '');
$addstate           = trim($_POST['addstate'] ?? '');
$addareaCode        = trim($_POST['addareaCode'] ?? '');
$addresidenceNumber = trim($_POST['addresidenceNumber'] ?? '');
$addextensionNo     = trim($_POST['addextensionNo'] ?? '');
$addprofile         = trim($_POST['addprofile'] ?? '');
$addipPhoneNo       = trim($_POST['addipPhoneNo'] ?? '');
$addmobion          = trim($_POST['addmobion'] ?? null);
$addmobiweb         = trim($_POST['addmobiweb'] ?? '');
$addcountrycode     = trim($_POST['addcountrycode'] ?? '');

// -------------------------
// DATE CALCULATIONS
// -------------------------
$activated_date = date("Y-m-d");                      // today
// $days_of_validity = 365;                              // 1 year validity (change if needed)
// $expiry_date = date("Y-m-d", strtotime("+$days_of_validity days"));
$days_of_validity = 0;
$expiry_date = null;


// Action date (insert time)
$action_date = date("Y-m-d H:i:s");

// -------------------------
// TIMEZONE CALCULATIONS
// -------------------------
$timedifference = null;
$gmtsign = null;

// Example: "UTC+05:30"
// if (preg_match('/UTC([+-])(\d{2}):?(\d{2})?/', $addtimezone, $m)) {
//     $gmtsign = $m[1];
//     $hours   = intval($m[2]);
//     $minutes = isset($m[3]) ? intval($m[3]) : 0;
//     $timedifference = sprintf("%02d:%02d", $hours, $minutes);
// }

// -------------------------
// Default Flags
// -------------------------
$status      = 1;
$email_sent  = 1;
$sms_sent    = 1;
$daylightsaving = 1;

$sqlsubscribeidchk = "SELECT * FROM public.subscriber_profile WHERE subscriber_id='$adduserId' ORDER BY id ASC";
$ressubidchk = pg_query($con, $sqlsubscribeidchk);
if (pg_num_rows($ressubidchk) > 0) {
    echo "Already added this User ID,Please Correct the User ID";
    exit;
}


$sqlmblchk = "SELECT * FROM public.subscriber_profile WHERE mobile_no='$addmobileNo' ORDER BY id ASC";
$resmblchk = pg_query($con, $sqlmblchk);
if (pg_num_rows($resmblchk) > 0) {
    echo "Already added this Mobile No,Please Correct the Mobile No";
    exit;
}
if ($addpbxNo != "") {
    $sqlpbxnochk = "SELECT * FROM public.subscriber_profile WHERE (mobion ='$addpbxNo' OR  mobiweb ='$addpbxNo' OR pbx ='$addpbxNo' OR ipphoneno ='$addpbxNo')  ORDER BY id ASC";
    $respbxnochk = pg_query($con, $sqlpbxnochk);
    if (pg_num_rows($respbxnochk) > 0) {
        echo "Already added this Number, Please Change the PBX NO field";
        exit;
    }
}
if ($addmobion != "") {

    $sqlmbionchk = "SELECT * FROM public.subscriber_profile WHERE (mobion ='$addmobion' OR  mobiweb ='$addmobion' OR pbx ='$addmobion' OR ipphoneno ='$addmobion')  ORDER BY id ASC";
    $resmbionchk = pg_query($con, $sqlmbionchk);
    if (pg_num_rows($resmbionchk) > 0) {
        echo "Already added this Number ,Please Change the Mobion Field";
        exit;
    }
}

if ($addmobiweb != "") {
    $sqlmbiwebchk = "SELECT * FROM public.subscriber_profile WHERE (mobion ='$addmobiweb' OR  mobiweb ='$addmobiweb' OR pbx ='$addmobiweb' OR ipphoneno ='$addmobiweb')  ORDER BY id ASC";
    $resmbiwebchk = pg_query($con, $sqlmbiwebchk);
    if (pg_num_rows($resmbiwebchk) > 0) {
        echo "Already added this Number ,Please Change the MobiWeb Field";
        exit;
    }
}
if ($addipPhoneNo != "") {
    $sqliphnochk = "SELECT * FROM public.subscriber_profile WHERE (mobion ='$addipPhoneNo' OR  mobiweb ='$addipPhoneNo' OR pbx ='$addipPhoneNo' OR ipphoneno ='$addipPhoneNo')  ORDER BY id ASC";
    $resiphnochk = pg_query($con, $sqliphnochk);
    if (pg_num_rows($resiphnochk) > 0) {
        echo "Already added this Number ,Please Change the IP Phone No Field";
        exit;
    }
}



// -------------------------
// SQL INSERT using pg_query_params (SAFE)
// -------------------------
$sql = "INSERT INTO public.subscriber_profile
(first_name, last_name, subscriber_id, country_code, mobile_no, subscriber_password,
 activated_date, expiry_date, res_no, email, company_name, addr_1, addr_2, city, state, country, designation,
 area_code, office_no, extension_no, email_notification_sent, sms_notification_sent, groupid, smssent,
 profile, pbx, status, timezone, timedifference, gmtsign, daylightsaving,
 dststartmonth, dststartdate, dstendmonth, dstenddate, imsino, ipphoneno,
 mobileuser, landlineuser, ipphoneuser, mobionuser, license_type, days_of_validity,
 action_date, mobion, mobiweb)
VALUES
($1,$2,$3,$4,$5,$6,
 $7,$8,$9,$10,$11,$12,$13,$14,$15,$16,$17,
 $18,$19,$20,$21,$22,$23,$24,
 $25,$26,$27,$28,$29,$30,$31,
 $32,$33,$34,$35,$36,$37,
 $38,$39,$40,$41,$42,$43,
 $44,$45,$46)";

$params = [
    $addfirstName,          // $1
    $addlastName,           // $2
    $adduserId,             // $3 subscriber_id
    $addcountrycode,        // $4
    $addmobileNo,           // $5
    $addpassword, // $6
    $activated_date,        // $7
    $expiry_date,           // $8
    $addresidenceNumber,    // $9
    $addemail,              // $10
    $addcompanyName,        // $11
    $addaddress,            // $12
    null,                   // $13 addr_2
    $addcity,               // $14
    $addstate,              // $15
    $addcountry,            // $16
    $adddesignation,        // $17
    $addareaCode,           // $18
    null,                   // $19 office_no
    $addextensionNo,        // $20
    $email_sent,            // $21
    $sms_sent,              // $22
    $addgroupId,            // $23
    $sms_sent,              // $24  ✅ FIXED (exists now!)
    $addprofile,            // $25
    $addpbxNo,              // $26
    $status,                // $27
    $addtimezone,           // $28
    $timedifference,        // $29
    $gmtsign,               // $30
    $daylightsaving,        // $31
    null,                   // $32 dststartmonth
    null,                   // $33 dststartdate
    null,                   // $34 dstendmonth
    null,                   // $35 dstenddate
    null,                   // $36 imsino
    $addipPhoneNo,          // $37
    null,                    // $38 mobileuser
    null,                    // $39 landlineuser
    null,                    // $40 ipphoneuser
    null,             // $41 mobionuser
    null,             // $42 license_type
    $days_of_validity,      // $43
    $action_date,           // $44
    $addmobion,             // $45 mobion
    $addmobiweb             // $46 mobiweb
];


$res = pg_query_params($con, $sql, $params);

if ($res) {
    // Example dynamic values
    $user_id  = $adduserId;
    $password = $addpassword;

    // Create <include> as root
    $xml = new SimpleXMLElement('<include/>');

    // Add <user>
    $user = $xml->addChild('user');
    $user->addAttribute('id', $user_id);

    // Add <params>
    $params = $user->addChild('params');
    $param1 = $params->addChild('param');
    $param1->addAttribute('name', 'password');
    $param1->addAttribute('value', $password);

    $param2 = $params->addChild('param');
    $param2->addAttribute('name', 'vm-password');
    $param2->addAttribute('value', $user_id);

    // Add <variables>
    $variables = $user->addChild('variables');

    $vars = [
        "toll_allow" => "domestic,international,local",
        "accountcode" => $user_id,
        "user_context" => "default",
        "effective_caller_id_name" => $user_id,
        "effective_caller_id_number" => $user_id,
        "outbound_caller_id_name" => "\$\${outbound_caller_name}",
        "outbound_caller_id_number" => "\$\${outbound_caller_id}",
        "callgroup" => "techsupport"
    ];

    foreach ($vars as $name => $value) {
        $var = $variables->addChild('variable');
        $var->addAttribute('name', $name);
        $var->addAttribute('value', $value);
    }

    // Format XML with DOM
    $dom = dom_import_simplexml($xml)->ownerDocument;
    $dom->formatOutput = true;
    $xmlString = $dom->saveXML();

    // Path to FreeSWITCH user directory
    $folder = $fileadduserxmlpath;

    // Ensure folder exists
    if (!is_dir($folder)) {
        die("Directory not found: $folder");
    }

    // File path (one file per user)
    $filePath = $folder . "/" . $user_id . ".xml";

    // Write XML file
    if (file_put_contents($filePath, $xmlString)) {
        echo "1";
    } else {
        echo "❌ Failed to create file. Try running PHP as Administrator.";
        logError("Query failed: " . pg_last_error($con));
    }
} else {
    echo "❌ Error: " . pg_last_error($con);
    logError("Query failed: " . pg_last_error($con));
}
