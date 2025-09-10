<?php
$groupname = 'Test Audio 1';
$groupno   = '5006';

// Detect OS and set path
if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
    $filePath = "C:/Program Files/FreeSWITCH/conf/dialplan/default.xml";
} else {
    $filePath = "/usr/local/freeswitch/conf/dialplan/default.xml";
}

// Load file contents safely
$xmlContent = @file_get_contents($filePath);
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

// Pattern: match the <extension name="unloop"> ... </extension>
$pattern = '/(<extension\s+name="unloop">.*?<\/extension>)/is';

// Insert new extension immediately after unloop block
$updatedContent = preg_replace($pattern, "$1\n$newExtension", $xmlContent, 1);

if ($updatedContent === null) {
    die("❌ Regex error while inserting extension.");
}

// Try to save file
if (@file_put_contents($filePath, $updatedContent) !== false) {
    echo "✅ Success: Extension added!";
} else {
    echo "❌ Failed to save file. Permission denied?";
    
    // Try auto-fixing permissions based on OS
    if (strtoupper(substr(PHP_OS, 0, 3)) === 'WIN') {
        exec('icacls "' . dirname($filePath) . '" /grant Everyone:(F) /T /C', $out, $res);
        echo $res === 0 ? " (Permissions updated, try again)" : " (Permission update failed)";
    } else {
        exec("chmod -R 777 " . escapeshellarg(dirname($filePath)), $out, $res);
        echo $res === 0 ? " (Permissions updated, try again)" : " (Permission update failed)";
    }
}
