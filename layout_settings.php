<?php include("config.php");
include("chksession.php");
include("check_table.php");
$ctbl = tablecheck($con, "conference_layouts"); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Layout Settings</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
    <link rel="stylesheet" href="assets/css/styles.min.css" />
    <style>
        table {
            margin-top: 30px;
        }

        th {
            background-color: #808080;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>

<body>
    <!--  Body Wrapper -->
    <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
        data-sidebar-position="fixed" data-header-position="fixed">
        <!-- Sidebar Start -->
        <?php include("sidebar.php"); ?>
        <!--  Sidebar End -->
        <!--  Main wrapper -->
        <div class="body-wrapper">
            <!--  Header Start -->
            <?php include("header.php"); ?>

            <!--  Header End -->
            <div class="container-fluid">
                <?php if ($ctbl) { ?>

                    <div class="d-flex justify-content-center align-items-center gap-3 mb-4">
                        <!-- Dropdown -->
                        <select id="screenLayoutid" class="form-select w-auto">
                            <option value="" disabled selected hidden>Select Option</option>
                            <?php $sql = "SELECT * FROM public.conference_layouts ORDER BY id ASC";
                            $res = pg_query($con, $sql);
                            if (pg_num_rows($res) > 0) {
                                while ($row = pg_fetch_array($res)) {
                            ?>
                                    <option value="<?php echo $row['layoutname'] ?>"><?php echo $row['layoutname']; ?></option>

                            <?php

                                }
                            } ?>

                        </select>

                        <!-- Buttons -->
                        <button class="btn btn-primary btn-update">Update</button>
                        <button class="btn btn-danger btn-cancel">Cancel</button>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered text-center mt-4">
                            <thead>
                                <tr>
                                    <th style=" background-color:#D3D3D3;font-weight: bold;text-transform: uppercase;">Screen Layout</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM public.layout_setting ORDER BY id ASC";
                                $res = pg_query($con, $sql);
                                if (pg_num_rows($res) > 0) {
                                    $row = pg_fetch_array($res);
                                    echo "<tr><td>" . $row['layoutnumber'] . "</td></tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                <?php } else {
                    echo $msg;
                } ?>
            </div>
        </div>
    </div>
    <script src="assets/js/jquery-3.6.0.min.js"></script>
    <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/app.min.js"></script>

    <script>
        $(document).ready(function() {

            // Update button click
            $(".btn-update").click(function() {
                let selectedVal = $("#screenLayoutid").val();

                if (!selectedVal) {
                    alert("⚠️ Please select an option before updating.");
                    return;
                }

                // AJAX request
                $.ajax({
                    url: "update_layout.php",
                    type: "POST",
                    data: {
                        layout_val: selectedVal
                    },
                    success: function(response) {
                        alert(response);
                        location.reload();
                    },
                    error: function() {
                        alert("❌ Error while updating.");
                    }
                });
            });

            // Cancel button click (reset dropdown)
            $(".btn-cancel").click(function() {
                $("#screenLayoutid").val(""); // resets to default hidden option
            });

        });
    </script>

</body>

</html>