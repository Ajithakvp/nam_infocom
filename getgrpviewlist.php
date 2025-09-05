<?php

include("config.php");

$id = $_REQUEST['id'];

$sql = "SELECT * FROM public.group_setting where id='$id' ORDER BY id ASC ";
$res = pg_query($con, $sql);
if (pg_num_rows($res) > 0) {
    $row = pg_fetch_array($res);

    $exp = explode(",", $row['user_details']);
?>

    <div class="table-responsive">
        <table class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>User Name</th>
                    <th>Phone Number</th>
                </tr>
            </thead>
            <tbody>
                <?php
                for ($i = 0; $i < count($exp); $i++) {
                    $data = explode("-", $exp[$i]);
                    $name = trim($data[0]);
                    $mblno = trim($data[1]);
                ?>
                    <tr>
                        <td><?php echo $name; ?></td>
                        <td><?php echo $mblno; ?></td>
                    </tr>
                <?php
                }
                ?>
            </tbody>
        </table>
    </div>
<?php

}

?>