<?php include("config.php");
include("chksession.php");

include("check_table.php");
$ctbl = tablecheck($con, "ip_setting"); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>IP Settings</title>
    <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />

    <!-- Bootstrap CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


    <!-- DataTables CSS -->
    <link href="assets/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="assets/css/responsive.bootstrap5.min.css" rel="stylesheet">



    <link rel="stylesheet" href="assets/css/styles.min.css" />
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
                <!--  Row 1 -->

                <?php if ($ctbl) { ?>

                    <!--  Row 1 -->
                    <div class="table-responsive">
                        <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                            <thead>
                                <tr>

                                    <th>IP Type</th>
                                    <th>IP Address</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "SELECT * FROM public.ip_setting ORDER BY id ASC";
                                $res = pg_query($con, $sql);
                                if (pg_num_rows($res) > 0) {
                                    while ($row = pg_fetch_array($res)) {
                                ?>
                                        <tr>
                                            <td><?php echo $row['ip_name']; ?></td>
                                            <td><?php echo $row['ip_address']; ?></td>
                                            <td class="action-icons">
                                                <i class="fa-regular fa-edit text-primary me-3" data-id="<?php echo $row['id']; ?>"
                                                    style="font-size:20px; cursor:pointer;"></i>

                                            </td>
                                        </tr>

                                <?php
                                    }
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

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update IP Setting</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="editFirstname" class="form-label">IP Type</label>
                            <input type="text" class="form-control" id="editFirstname" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="editLastname" class="form-label">IP Address</label>
                            <input type="text" class="form-control" id="editLastname" maxlength="15">
                            <span id="editLastnameError" style="color:red;display:none;font-size:14px;"></span>

                        </div>

                        <input type="hidden" id="ip_id">


                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveEdit">Update</button>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/libs/jquery/dist/jquery.min.js"></script>
    <script src="assets/js/sidebarmenu.js"></script>
    <script src="assets/js/app.min.js"></script>



    <!-- Bootstrap JS -->
    <script src="assets/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="assets/js/jquery.dataTables.min.js"></script>
    <script src="assets/js/dataTables.bootstrap5.min.js"></script>
    <script src="assets/js/dataTables.responsive.min.js"></script>
    <script src="assets/js/responsive.bootstrap5.min.js"></script>


    <!-- Custom JS -->
    <script>
        $(document).ready(function() {

            $("#editLastname").on("input", function() {
                // Remove all invalid characters (anything except digits or dot)
                this.value = this.value.replace(/[^0-9.]/g, "");

                let original = this.value.trim();
                let $field = $(this);
                let id = this.id;

                // IPv4 regex: Matches partial segments for live feedback
                const ipv4Partial = /^(25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)?(\.(25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)?){0,3}$/;

                // Full IPv4 regex: Matches a complete valid IPv4 address
                const ipv4Full = /^(25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)(\.(25[0-5]|2[0-4]\d|1\d{2}|[1-9]?\d)){3}$/;

                if (!ipv4Partial.test(original)) {
                    // Invalid characters or bad structure
                    $("#" + id + "Error").text("Use only digits and dots.").show();
                    $field.css("border-color", "red");
                    $("#saveEdit").prop("disabled", true);
                } else if (ipv4Full.test(original)) {
                    // Fully valid IPv4 address
                    $("#" + id + "Error").hide();
                    $field.css("border-color", "green");
                    $("#saveEdit").prop("disabled", false);
                } else {
                    // Partial but valid structure (e.g., "192." or "10.0")
                    $("#" + id + "Error").text("Continue entering a valid IP address.").show();
                    $field.css("border-color", "orange");
                    $("#saveEdit").prop("disabled", true);
                }
            });




            // Initialize DataTable
            $('#example').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
            });

            $('#example').on('click', 'td.action-icons .fa-edit', function() {
                let id = $(this).data('id');
                console.log("Clicked ID:", id);
                rowToEdit = $(this).closest('tr');
                $('#editFirstname').val(rowToEdit.find('td:eq(0)').text());
                $('#editLastname').val(rowToEdit.find('td:eq(1)').text());
                $('#ip_id').val(id);


                let editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });



            $('#saveEdit').on('click', function() {
                var iptype = $('#editFirstname').val().trim();
                var ipaddress = $('#editLastname').val().trim();
                var ip_id = $('#ip_id').val();

                // ✅ Validation
                if (iptype === "") {
                    alert("⚠️ Please enter IP TYPE");
                    $('#editFirstname').focus();
                    return;
                }
                if (ipaddress === "") {
                    alert("⚠️ Please enter IP Address");
                    $('#editLastname').focus();
                    return;
                }
                if (ip_id === "" || ip_id === undefined) {
                    alert("⚠️ Invalid IP ID");
                    return;
                }

                // ✅ AJAX request
                $.ajax({
                    url: "update_ip_settings.php",
                    type: "POST",
                    data: {
                        iptype: iptype,
                        ipaddress: ipaddress,
                        ip_id: ip_id
                    },
                    success: function(response) {
                        // handle server response
                        alert(response);
                        // you can also close modal or reload table here
                        $('#editModal').modal('hide');
                        location.reload();
                    },
                    error: function() {
                        alert("❌ Error while updating data.");
                    }
                });
            });

        });
    </script>
</body>

</html>