<?php
include("config.php");

$start_date = $_REQUEST['start_date'];
$end_date = $_REQUEST['end_date'];
$mobile_no = $_REQUEST['mobile_no'];
$report_type = $_REQUEST['report_type'];
$call_type = $_REQUEST['call_type'];

if ($start_date != "") {
    $datechk = " AND call_connected_time::date BETWEEN '" . $start_date . "' AND '" . $end_date . "'";
} else {
    $datechk = "";
}


if ($mobile_no != "") {
    $mbnchk = " AND Subscriber_id= '" . $mobile_no . "'";
} else {
    $mbnchk = "";
}

if ($call_type == "ALL" || $call_type == "") {

    $ctypechk = " ";
} else {
    $ctypechk = "AND calltype='" . $call_type . "'";
}


if ($report_type == "1") {
?>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>

                    <th>User ID</th>
                    <th>Call Reference ID</th>
                    <th>Calling Number</th>
                    <th>Called Number</th>
                    <th>Call Type</th>
                    <th>Call Offer Time</th>
                    <th>Call Connected Time</th>
                    <th>Call Disconnected Time</th>
                    <th>Call Duration</th>
                    <th>Disconnected Reason</th>
                    <th>Call Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                 $sql = "SELECT 
                *,
                CASE calltype
                WHEN '1' THEN 'Audio'
                WHEN '2' THEN 'Video'
                WHEN '3' THEN 'IM'
                WHEN '4' THEN 'File Share'
                WHEN '5' THEN 'Audio_Conference'
                WHEN '6' THEN 'Video_Conference'
                END AS calltype_name
                FROM public.call_details_fs
                WHERE call_type NOT IN('PBX') $datechk $mbnchk $ctypechk";

                $res = pg_query($con, $sql);
                if (pg_num_rows($res)) {
                    while ($row = pg_fetch_array($res)) {
                ?>
                        <tr>
                            <td><?php echo $row['subscriber_id']; ?></td>
                            <td><?php echo $row['call_ref_id']; ?></td>
                            <td><?php echo $row['calling_number']; ?></td>
                            <td><?php echo $row['called_number']; ?></td>
                            <td><?php echo $row['call_type']; ?></td>
                            <td><?php echo $row['call_offer_time']; ?></td>
                            <td><?php echo $row['call_connected_time']; ?></td>
                            <td><?php echo $row['call_disconnected_time']; ?></td>
                            <td><?php echo $row['call_duration']; ?></td>
                            <td><?php echo $row['disconnected_reason']; ?></td>
                            <td><?php echo $row['calltype_name']; ?></td>

                        </tr>
                <?php
                    }
                }

                ?>

            </tbody>
        </table>
    </div>

<?php
} else if ($report_type == "2") {
?>
    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>

                    <th>User ID</th>
                    <th>Call Reference ID</th>
                    <th>Calling Number</th>
                    <th>Called Number</th>
                    <th>Call Type</th>
                    <th>Call Offer Time</th>
                    <th>Call Connected Time</th>
                    <th>Call Disconnected Time</th>
                    <th>Call Duration</th>
                    <th>Disconnected Reason</th>
                    <th>Call Type</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT 
                *,
                CASE calltype
                WHEN '1' THEN 'Audio'
                WHEN '2' THEN 'Video'
                WHEN '3' THEN 'IM'
                WHEN '4' THEN 'File Share'
                WHEN '5' THEN 'Audio_Conference'
                WHEN '6' THEN 'Video_Conference'
                END AS calltype_name
                FROM public.call_details_fs
                WHERE call_type IN('PBX') $datechk $mbnchk $ctypechk";
                $res = pg_query($con, $sql);
                if (pg_num_rows($res)) {
                    while ($row = pg_fetch_array($res)) {
                ?>
                        <tr>
                            <td><?php echo $row['subscriber_id']; ?></td>
                            <td><?php echo $row['call_ref_id']; ?></td>
                            <td><?php echo $row['calling_number']; ?></td>
                            <td><?php echo $row['called_number']; ?></td>
                            <td><?php echo $row['call_type']; ?></td>
                            <td><?php echo $row['call_offer_time']; ?></td>
                            <td><?php echo $row['call_connected_time']; ?></td>
                            <td><?php echo $row['call_disconnected_time']; ?></td>
                            <td><?php echo $row['call_duration']; ?></td>
                            <td><?php echo $row['disconnected_reason']; ?></td>
                            <td><?php echo $row['calltype_name']; ?></td>

                        </tr>
                <?php
                    }
                }

                ?>

            </tbody>
        </table>
    </div>

<?php

} else if ($report_type == "3") {

    if ($start_date != "") {
        $datechk = " AND callstarttime BETWEEN '" . $start_date . "' AND '" . $end_date . "'";
    } else {
        $datechk = "";
    }


    if ($mobile_no != "") {
        $mbnchk = " AND fromnumber= '" . $mobile_no . "'";
    } else {
        $mbnchk = "";
    }


    if ($call_type == "ALL" || $call_type == "") {

        $ctypechk = "";
    } else {

        if ($call_type == "1") {
            $calltypename = 'audio';
        } else if ($call_type == "2") {
            $calltypename = 'video';
        } else if ($call_type == "3") {
            $calltypename = 'im';
        } else if ($call_type == "4") {
            $calltypename = 'file share';
        } else if ($call_type == "5") {
            $calltypename = 'audio_conference';
        } else if ($call_type == "6") {
            $calltypename = 'video_conference';
        }
        $ctypechk = "AND calltype='" . $calltypename . "'";
    }


?>

    <div class="table-responsive">
        <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>

                    <th>Call Ref ID</th>
                    <th>From Number</th>
                    <th>To Number</th>
                    <th>Call Start Time</th>
                    <th>Call End Time</th>
                    <th>Call Duration</th>
                    <th>Call Type</th>
                    <th>Call Direction</th>
                    <th>Call Status</th>
                    <th>Call Option</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM public.mobiweb_cdr WHERE fromnumber !='' $datechk $mbnchk $ctypechk";
                $res = pg_query($con, $sql);
                if (pg_num_rows($res)) {
                    while ($row = pg_fetch_array($res)) {
                ?>
                        <tr>
                            <td><?php echo $row['callid']; ?></td>
                            <td><?php echo $row['fromnumber']; ?></td>
                            <td><?php echo $row['tonumber']; ?></td>
                            <td><?php echo $row['callstarttime']; ?></td>
                            <td><?php echo $row['callendtime']; ?></td>
                            <td><?php echo $row['callduration']; ?></td>
                            <td><?php echo $row['calltype']; ?></td>
                            <td><?php echo $row['calldirection']; ?></td>
                            <td><?php echo $row['callstatus']; ?></td>
                            <td><?php echo $row['call_types']; ?></td>

                        </tr>
                <?php
                    }
                }

                ?>

            </tbody>
        </table>
    </div>

<?php

}
?>