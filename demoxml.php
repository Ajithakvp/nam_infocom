<?php
// Example dynamic values
$user_id  = "1001";
$password = "secret123";

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
$filePath = $folder . "/user_" . $user_id . ".xml";

// Write XML file
if (file_put_contents($filePath, $xmlString)) {
    echo "✅ XML file created: " . $filePath;
} else {
    echo "❌ Failed to create file. Try running PHP as Administrator.";
}
