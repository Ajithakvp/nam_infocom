<?php
include("config.php");
global $filegrupSettingxmlPath;

// Collect POST data safely
$id  = $_POST['editId'] ?? '';
$conference  = $_POST['editconference'] ?? '';
$callType    = $_POST['editcallType'] ?? '';
$groupName   = $_POST['editgroupName'] ?? '';
$groupNumber = $_POST['editgroupNumber'] ?? '';
$admin       = $_POST['editAdmin'] ?? '';
$users       = $_POST['editusers'] ?? [];

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

$sqlupchk = "SELECT * FROM public.group_setting WHERE group_number='$groupNumber' AND group_name='$groupName' AND conference='$conference' AND user_details='$users' AND calltype='$callType' AND moderate='$admin' AND id='$id'";
$resupchk = pg_query($con, $sqlupchk);
if (pg_num_rows($resupchk) > 0) {
    echo "No changes made";
    exit;
} else {

    $sqlgrpnochk = "SELECT * FROM public.group_setting WHERE group_number='$groupNumber' AND id NOT IN('$id')";
    $resgrpnochk = pg_query($con, $sqlgrpnochk);
    if (pg_num_rows($resgrpnochk) > 0) {
        echo "Group Number Already Entered , Please Change the Group Number";
        exit;
    }
}


// Example Insert (adjust table/columns)
$sql = "UPDATE public.group_setting
	SET group_number='$groupNumber', action_date='$formatted',  group_name='$groupName', conference='$conference', user_details='$users', calltype='$callType', moderate='$admin'
	WHERE id='$id'";

$res = pg_query($con, $sql);
if ($res) {


    $groupname = $groupName;
    $filePath  = $filegrupSettingxmlPath;

    if (!file_exists($filePath)) {
        die("❌ File not found: $filePath\n");
    }

    // helper to build XPath literal safely
    function xpath_literal(string $s): string
    {
        if (strpos($s, "'") === false) {
            return "'" . $s . "'";
        }
        $parts = explode("'", $s);
        $pieces = [];
        foreach ($parts as $i => $part) {
            $pieces[] = "'" . $part . "'";
            if ($i !== count($parts) - 1) $pieces[] = "\"'\"";
        }
        return "concat(" . implode(",", $pieces) . ")";
    }

    libxml_use_internal_errors(true);
    $dom = new DOMDocument();
    $dom->preserveWhiteSpace = false;
    $dom->formatOutput = true;

    if (!$dom->load($filePath)) {
        die("❌ Failed to load XML file.\n");
    }

    $xpath = new DOMXPath($dom);
    $nameLiteral = xpath_literal($groupname);
    $query = "//extension[@name = $nameLiteral]";
    $nodes = $xpath->query($query);

    if ($nodes === false || $nodes->length === 0) {
        die("⚠️ No <extension> found with name \"$groupname\".\n");
    }

    $removed = 0;
    foreach (iterator_to_array($nodes) as $node) {
        $parent = $node->parentNode;
        if ($parent) {
            $parent->removeChild($node);
            $removed++;
        }
    }

    if ($removed > 0) {
        if ($dom->save($filePath)) {

            if ($conference == "Audio" && $callType == "Dial-IN") {

                $groupname = $_POST['editgroupName'];
                $groupno   = $_POST['editgroupNumber'];

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
                }
                if ($updatedContent === $xmlContent) {
                    die("❌ Could not find <extension name=\"unloop\"> in file.");
                }

                // Backup old file
                if (!copy($filePath, $filePath . ".bak")) {
                    die("⚠️ Backup failed, aborting update.");
                }

                // Write updated file
                if (file_put_contents($filePath, $updatedContent) === false) {
                    die("❌ Failed to update XML file. Try running PHP as Administrator.");
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
                }
            } else {
                echo "❌ Could not save file.";
            }
        } else {
            echo "❌ Could not save file.";
        }
    } else {
        echo "❌ Could not save file.";
    }
} else {
    echo "0";
}
