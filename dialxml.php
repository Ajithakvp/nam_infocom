<?php
$groupname = 'Test Audio';
$groupno   = '5006';

// Path to FreeSWITCH dialplan file
$filePath = "C:/Program Files/FreeSWITCH/conf/dialplan/default.xml";

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
