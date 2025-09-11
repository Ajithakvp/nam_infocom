<?php
include("config.php");
global $filegrupSettingxmlPath;

// Remove JSON header if you want plain response
header("Content-Type: text/plain; charset=UTF-8");


// Collect POST data safely
$conference  = $_POST['addconference'] ?? '';
$callType    = $_POST['addcallType'] ?? '';
$groupName   = $_POST['addgroupName'] ?? '';
$groupNumber = $_POST['addgroupNumber'] ?? '';
$admin       = $_POST['addAdmin'] ?? '';
$users       = $_POST['addusers'] ?? [];


// Get current time with microseconds
$micro_time = microtime(true);

// Format date (without milliseconds first)
$date = date("Y-m-d H:i:s", (int)$micro_time);

// Extract milliseconds (3 digits)
$milliseconds = sprintf("%03d", ($micro_time - floor($micro_time)) * 1000);

// Final output
$formatted = $date . "." . $milliseconds;




// Convert array of users to string (comma separated)
if (is_array($users)) {
    $users = implode(",", $users);
} else {
    $users = trim($users); // single value string
}


$sqlgrpnamechk = "SELECT * FROM public.group_setting WHERE group_name='$groupName'";
$resgrpnamechk = pg_query($con, $sqlgrpnamechk);
if (pg_num_rows($resgrpnamechk) > 0) {
    echo "Group Name Already Entered , Please Change the Group Name";
    exit;
}


$sqlgrpnochk = "SELECT * FROM public.group_setting WHERE group_number='$groupNumber'";
$resgrpnochk = pg_query($con, $sqlgrpnochk);
if (pg_num_rows($resgrpnochk) > 0) {
    echo "Group Number Already Entered , Please Change the Group Number";
    exit;
}



// Example Insert (adjust table/columns)
$sql = "INSERT INTO public.group_setting (conference, calltype, group_name, group_number, moderate, user_details,action_date) 
        VALUES ('$conference', '$callType', '$groupName', '$groupNumber', '$admin', '$users','$formatted')";
$res = pg_query($con, $sql);
if ($res) {
    if ($conference == "Audio" && $callType == "Dial-IN") {

        $groupname = $_POST['addgroupName'];
        $groupno   = $_POST['addgroupNumber'];

        // Path to FreeSWITCH dialplan file
        $filePath = $filegrupSettingxmlPath;

        // Load file contents
        $xmlContent = file_get_contents($filePath);
        if ($xmlContent === false) {
            die("❌ Failed to read file: $filePath");
        }

        // Build new extension block
        $newExtension = <<<XML
  <extension name="$groupname">
    <condition field="destination_number" expression="^$groupno$">
      <action application="answer"/>
      <action application="set" data="conference_auto_record=\${recordings_dir}/audio_conf\${strftime(%Y-%m-%d_%H-%M-%S)}.wav"/>
      <action application="conference" data="$groupno@default+flags{record}"/>
    </condition>
  </extension>

XML;

        // Pattern: find </extension> that closes the "unloop" extension
        $pattern = '/(<extension\s+name="unloop">.*?<\/extension>)/is';

        // Insert new extension immediately after unloop block
        $replacement = "$1\n$newExtension";

        $updatedContent = preg_replace($pattern, $replacement, $xmlContent, 1);

        if ($updatedContent === null) {
            die("❌ Regex error while inserting extension.");
        }

        // Save file back
        if (file_put_contents($filePath, $updatedContent)) {
            echo "success";
        } else {
            echo "❌ Failed to save file.";
        }
    } else if ($conference == "Video" && $callType == "Dial-IN") {

        // Variables
        $group_name   = $groupName;
        $group_number = $groupNumber;
        $userlist     = explode(",", $users);

        $Addusernumber = [];
        foreach ($userlist as $u) {
            // Split by "-" and take the phone part
            $parts = explode("-", $u);
            if (count($parts) == 2) {
                $Addusernumber[] = trim($parts[1]);
            }
        }
        $Adduser = $Addusernumber; // multiple numbers

        // Path to FreeSWITCH dialplan
        $filePath = $filegrupSettingxmlPath;

        // Read file
        $xmlContent = file_get_contents($filePath);
        if ($xmlContent === false) {
            die("❌ Failed to read XML file.");
            logError(pg_last_error($con));
        }

        // Build the new extension block
        $newExtension  = "\n<extension name=\"$group_name\">\n";
        $newExtension .= "    <condition field=\"destination_number\" expression=\"^$group_number$\">\n";
        $newExtension .= "        <action application=\"answer\" />\n";
        $newExtension .= "        <action application=\"set\" data=\"conference_auto_outcall_timeout=5\" />\n";
        $newExtension .= "        <action application=\"set\" data=\"conference_auto_outcall_caller_id_name=\$\${effective_caller_id_name}\" />\n";
        $newExtension .= "        <action application=\"set\" data=\"conference_auto_outcall_caller_id_number=\$\${effective_caller_id_number}\" />\n";
        $newExtension .= "        <action application=\"set\" data=\"conference_auto_outcall_profile=default\" />\n";
        $newExtension .= "        <action application=\"set\" data=\"conference_auto_outcall_prefix={sip_auto_answer=true,execute_on_answer='bind_meta_app 2 a s1 transfer::intercept:\${uuid} inline'}\" />\n";
        $newExtension .= "        <action application=\"set\" data=\"conference_auto_outcall_timeout=60\" />\n";

        // Add multiple users dynamically
        foreach ($Adduser as $user) {
            $newExtension .= "        <action application=\"conference_set_auto_outcall\" data=\"user/$user\" />\n";
        }

        $newExtension .= "        <action application=\"conference\" data=\"{$group_number}@default\" />\n";
        $newExtension .= "    </condition>\n";
        $newExtension .= "</extension>\n";

        // Pattern: match <extension name="unloop"> ... </extension>
        $pattern = '/(<extension\s+name="unloop"[^>]*>.*?<\/extension>)/is';

        // Insert new extension immediately after unloop block
        $updatedContent = preg_replace($pattern, "$1\n$newExtension", $xmlContent, 1);

        if ($updatedContent === null) {
            die("❌ Regex error while inserting extension.");
            logError(pg_last_error($con));
        }
        if ($updatedContent === $xmlContent) {
            die("❌ Could not find <extension name=\"unloop\"> in file.");
            logError(pg_last_error($con));
        }

        // Backup old file
        if (!copy($filePath, $filePath . ".bak")) {
            die("⚠️ Backup failed, aborting update.");
            logError(pg_last_error($con));
        }

        // Write updated file
        if (file_put_contents($filePath, $updatedContent) === false) {
            die("❌ Failed to update XML file. Try running PHP as Administrator.");
            logError(pg_last_error($con));
        } else {
            echo "success";
        }
    } else if ($conference == "Video" && $callType == "Dial-OUT") {

        $group_name   = $groupName;
        $group_number = $groupNumber;
        $exp          = explode("-", $admin);
        $Admin        = trim($exp[1]);
        $userlist     = explode(",", $users);

        $Addusernumber = [];
        foreach ($userlist as $u) {
            $parts = explode("-", $u);
            if (count($parts) == 2) {
                $Addusernumber[] = trim($parts[1]);
            }
        }
        $Adduser = $Addusernumber;

        $filePath = $filegrupSettingxmlPath;

        // Load XML
        $dom = new DOMDocument();
        $dom->preserveWhiteSpace = false;
        $dom->formatOutput = true;

        if (!$dom->load($filePath)) {
            die("❌ Failed to load XML file: $filePath");
            logError(pg_last_error($con));
        }

        // Create <extension>
        $ext = $dom->createElement("extension");
        $ext->setAttribute("name", $group_name);

        // Outer condition (destination_number)
        $condMain = $dom->createElement("condition");
        $condMain->setAttribute("field", "destination_number");
        $condMain->setAttribute("expression", "^{$group_number}$");

        // Admin condition
        $condAdmin = $dom->createElement("condition");
        $condAdmin->setAttribute("field", "caller_id_number");
        $condAdmin->setAttribute("expression", "^{$Admin}$");

        // Moderator actions
        $actions = [
            ["answer", ""],
            ["set", "conference_auto_outcall_timeout=5"],
            ["send_display", "Video Conference|$\${effective_caller_id_name}"],
            ["set", "conference_auto_outcall_caller_id_name=$\${effective_caller_id_name}"],
            ["set", "conference_auto_outcall_caller_id_number=$\${effective_caller_id_number}"],
            ["set", "conference_auto_outcall_profile=default"],
            ["set", "conference_auto_outcall_prefix={sip_auto_answer=true}"],
        ];
        foreach ($actions as [$app, $data]) {
            $act = $dom->createElement("action");
            $act->setAttribute("application", $app);
            if ($data !== "") {
                $act->setAttribute("data", $data);
            }
            $condAdmin->appendChild($act);
        }

        // Add dynamic users
        foreach ($Adduser as $user) {
            $act = $dom->createElement("action");
            $act->setAttribute("application", "conference_set_auto_outcall");
            $act->setAttribute("data", "sofia/gateway/brekeke_gateway/{$user}");
            $condAdmin->appendChild($act);
        }

        // Final moderator actions
        $act = $dom->createElement("action");
        $act->setAttribute("application", "set");
        $act->setAttribute("data", "conference_member_flags=join-vid-floor");
        $condAdmin->appendChild($act);

        $act = $dom->createElement("action");
        $act->setAttribute("application", "conference");
        $act->setAttribute("data", "{$group_number}@video-mcu-stereo");
        $condAdmin->appendChild($act);

        // Reject unauthorized users
        $condReject = $dom->createElement("condition");
        $condReject->setAttribute("field", "\${caller_id_number}");
        $condReject->setAttribute("expression", "^(?!{$Admin}).*$");

        $rejectAct = $dom->createElement("action");
        $rejectAct->setAttribute("application", "hangup");
        $rejectAct->setAttribute("data", "CALL_REJECTED");
        $condReject->appendChild($rejectAct);

        // Build hierarchy
        $condMain->appendChild($condAdmin);
        $condMain->appendChild($condReject);
        $ext->appendChild($condMain);

        // Insert after <extension name="unloop"> if exists
        $xpath = new DOMXPath($dom);
        $unloopNodes = $xpath->query("//extension[@name='unloop']");
        if ($unloopNodes->length > 0) {
            $unloop = $unloopNodes->item(0);
            if ($unloop->parentNode !== null) {
                if ($unloop->nextSibling) {
                    $unloop->parentNode->insertBefore($ext, $unloop->nextSibling);
                } else {
                    $unloop->parentNode->appendChild($ext);
                }
            }
        } else {
            // fallback: append to last context
            $contexts = $xpath->query("//context[last()]");
            if ($contexts->length > 0) {
                $contexts->item(0)->appendChild($ext);
            }
        }

        // Backup original file
        copy($filePath, $filePath . ".bak");

        // Save
        if ($dom->save($filePath)) {
            echo "success";
        } else {
            echo "❌ Failed to save file.";
            logError("Failed to save file " . pg_last_error($con));
        }
    }
} else {
    logError("Query failed: " . pg_last_error($con));


    echo "0";
}
