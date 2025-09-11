<?php
include "config.php";
global $fileadduserxmlpath;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['editId'];
    $first = $_POST['editfirstName'];
    $last = $_POST['editlastName'];
    $email = $_POST['editemail'];
    $mobile = $_POST['editmobileNo'];
    $country = $_POST['editcountry'];
    $userid = $_POST['edituserId'];
    $password = $_POST['editpassword'];
    $timezone = $_POST['edittimezone'];
    $groupid = $_POST['editgroupId'];
    $pbx = $_POST['editpbxNo'];
    $company = $_POST['editcompanyName'];
    $designation = $_POST['editdesignation'];
    $address = $_POST['editaddress'];
    $city = $_POST['editcity'];
    $state = $_POST['editstate'];
    $area = $_POST['editareaCode'];
    $residence = $_POST['editresidenceNumber'];
    $profile = $_POST['editprofile'];
    $ipphone = $_POST['editipPhoneNo'];
    $mobion = $_POST['editmobion'];
    $mobiweb = $_POST['editmobiweb'];


    // Function to check if a number already exists in the database
    function checkExistingNumber($con, $number, $field_name)
    {
        if ($number !== "" && $number !== "0") {
            $sql = "SELECT 1 FROM public.subscriber_profile WHERE (mobion = $1 OR mobiweb = $1 OR pbx = $1 OR ipphoneno = $1) LIMIT 1";
            $result = pg_query_params($con, $sql, array($number));
            if ($result && pg_num_rows($result) > 0) {
                echo "Already added this Number, Please change the {$field_name} field";
                exit;
            }
        }
    }





    //-------------------------------
    // Verify Sql Duplicate
    //-------------------------------
    $versql = "SELECT id FROM public.subscriber_profile WHERE first_name=$1 AND last_name=$2 AND email=$3 AND mobile_no=$4 AND country=$5 AND 
              subscriber_id=$6 AND subscriber_password=$7 AND timezone=$8 AND groupid=$9 AND pbx=$10 AND 
              company_name=$11 AND designation=$12 AND addr_1=$13 AND city=$14 AND state=$15 AND area_code=$16 AND 
              res_no=$17 AND profile=$18 AND ipphoneno=$19 AND mobion=$20 AND mobiweb=$21";

    $chkparams = [
        $first,
        $last,
        $email,
        $mobile,
        $country,
        $userid,
        $password,
        $timezone,
        $groupid,
        $pbx,
        $company,
        $designation,
        $address,
        $city,
        $state,
        $area,
        $residence,
        $profile,
        $ipphone,
        $mobion,
        $mobiweb
    ];

    $verres = pg_query_params($con, $versql, $chkparams);
    if (pg_num_rows($verres) > 0) {
        echo "No changes made";
        exit;
    } else {
        // Check each field
        checkExistingNumber($con, $pbx, 'PBX');
        checkExistingNumber($con, $mobion, 'Mobion');
        checkExistingNumber($con, $mobiweb, 'MobiWeb');
        checkExistingNumber($con, $ipphone, 'IP Phone');
    }

    $sql = "UPDATE public.subscriber_profile SET
              first_name=$1,last_name=$2,email=$3,mobile_no=$4,country=$5,
              subscriber_id=$6,subscriber_password=$7,timezone=$8,groupid=$9,pbx=$10,
              company_name=$11,designation=$12,addr_1=$13,city=$14,state=$15,area_code=$16,
              res_no=$17,profile=$18,ipphoneno=$19,mobion=$20,mobiweb=$21
            WHERE id=$22";

    $params = [
        $first,
        $last,
        $email,
        $mobile,
        $country,
        $userid,
        $password,
        $timezone,
        $groupid,
        $pbx,
        $company,
        $designation,
        $address,
        $city,
        $state,
        $area,
        $residence,
        $profile,
        $ipphone,
        $mobion,
        $mobiweb,
        $id
    ];

    $res = pg_query_params($con, $sql, $params);

    if ($res) {


        $user_id = $userid;  // <- replace with dynamic value
        $folder  = $fileadduserxmlpath;

        // Ensure folder exists
        if (!is_dir($folder)) {
            die("❌ Directory not found: $folder\n");
        }

        $filePath = $folder . "/" . $user_id . ".xml";

        if (!file_exists($filePath)) {
            die("⚠️ User file not found: $filePath\n");
        }

        // Try deleting the file
        if (@unlink($filePath)) {


            $user_id  = $userid;
            $password = $password;

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
            $folder = "C:/Program Files/FreeSWITCH/conf/directory/default";

            // Ensure folder exists
            if (!is_dir($folder)) {
                die("Directory not found: $folder");
            }

            // File path (one file per user)
            $filePath = $folder . "/" . $user_id . ".xml";

            // Write XML file
            if (file_put_contents($filePath, $xmlString)) {
                echo "✅ User updated successfully!";
            } else {
                echo "❌ Failed to create file. Try running PHP as Administrator.";
                logError(pg_last_error($con));
            }
        } else {
            die("❌ Failed to delete file. Check permissions.\n");
            logError(pg_last_error($con));
        }
    } else {
        echo "Error: " . pg_last_error($con);
        logError(pg_last_error($con));
    }
}
