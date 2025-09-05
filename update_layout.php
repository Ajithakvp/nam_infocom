<?php
include("config.php");
global $filelayoutsetxmlPath;

if (isset($_POST['layout_val'])) {
    $layout_val = $_POST['layout_val'];

    $sqlupchk = "SELECT * FROM public.layout_setting WHERE layoutnumber = '$layout_val' AND id = '1'";
    $resupchk = pg_query($con, $sqlupchk);
    if (pg_num_rows($resupchk) > 0) {
        echo "No changes made";
        exit;
    }

    // Example update query (adjust as needed)
    $sql = "UPDATE public.layout_setting SET layoutnumber = '$layout_val' WHERE id='1'";
    $result = pg_query($con, $sql);

    if ($result) {

        $filePath = $filelayoutsetxmlPath;
        $valgrid  = $layout_val; // new value you want

        // Load XML safely
        $xml = simplexml_load_file($filePath);
        if ($xml === false) {
            die("❌ Failed to load XML file. Check path or permissions.");
        }

        $updated = false;

        // Search recursively for all <profile>
        $profiles = $xml->xpath("//profile[@name='video-mcu-stereo']");

        if ($profiles && count($profiles) > 0) {
            foreach ($profiles as $profile) {
                $found = false;

                foreach ($profile->param as $param) {
                    if ((string)$param['name'] === "video-layout-name") {
                        $param['value'] = $valgrid; // update
                        $found = true;
                        $updated = true;
                        break;
                    }
                }

                if (!$found) {
                    $newParam = $profile->addChild("param");
                    $newParam->addAttribute("name", "video-layout-name");
                    $newParam->addAttribute("value", $valgrid);
                    $updated = true;
                }
            }
        }

        // Save back to file
        if ($updated) {
            $result = $xml->asXML();
            if ($result === false) {
                die("❌ XML conversion failed.");
            }
            if (file_put_contents($filePath, $result) === false) {
                die("❌ Failed to save XML. Run Apache/PHP with Administrator rights.");
            }
            echo "✅ Update Successfully " . $layout_val;
        } else {
            echo "⚠️ Profile 'video-mcu-stereo' not found in XML.";
        }
    } else {
        echo " ❌ Update failed!";
    }
}
