<?php
include("config.php");
global $filegrupSettingxmlPath;


// Collect POST data safely
$id  = $_POST['id'];
$groupName  = trim($_POST['groupName']);


$sql = "DELETE FROM public.group_setting
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
            echo "Deleted Successfully!";
        }
    }
} else {
    echo "Unable to delete. Please try again !";
}
