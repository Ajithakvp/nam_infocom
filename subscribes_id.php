<?php include("config.php"); ?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Subscribes ID</title>
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

                <!--  Row 1 -->
                <div class="table-responsive">
                    <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
                        <thead>
                            <tr>

                                <th>User Name</th>
                                <th>Password</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $sql = "SELECT * FROM public.subscriber ORDER BY id ASC";
                            $res = pg_query($con, $sql);
                            if (pg_num_rows($res) > 0) {
                                while ($row = pg_fetch_array($res)) {
                            ?>
                                    <tr>

                                        <td><?php echo $row['subscriber_id']; ?></td>
                                        <td><?php echo $row['password']; ?></td>
                                        <td class="action-icons">
                                            <i class="fa-regular fa-edit text-primary me-3"
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

            </div>
        </div>
    </div>

    <!-- Edit Modal -->
    <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel">Update Subscribe ID</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editForm">
                        <div class="mb-3">
                            <label for="editFirstname" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="editFirstname">

                        </div>
                        <div class="mb-3">
                            <label for="editLastname" class="form-label">Password</label>
                            <input type="text" class="form-control" id="editLastname">
                            <span id="lastnameError" style="color:red;display:none;font-size:14px;"></span>

                        </div>

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


            // Initialize DataTable
            $('#example').DataTable({
                responsive: true,
                pageLength: 10,
                lengthMenu: [5, 10, 25, 50],
            });

            let rowToEdit = null;

            // Click on edit icon
            $('#example').on('click', 'td.action-icons .fa-edit', function() {
                rowToEdit = $(this).closest('tr');

                // Fill modal fields
                $('#editFirstname').val(rowToEdit.find('td:eq(0)').text());
                $('#editLastname').val(rowToEdit.find('td:eq(1)').text());

                // Reset validation + disable button initially
                $("#lastnameError").hide();
                $("#editLastname").css("border-color", "");
                $("#saveEdit").prop("disabled", false);

                // Show modal
                let editModal = new bootstrap.Modal(document.getElementById('editModal'));
                editModal.show();
            });

            // Validation (bind once)
            $("#editLastname").on("input", function() {
                var value = $(this).val().trim();
                var regex = /^[a-zA-Z0-9!@#$%^&*(),.?":{}|<>_\- ]+$/; // alpha, numeric, special chars
                var error = "";

                if (value.length < 5 || value.length > 50) {
                    error = "Must be between 5 and 50 characters.";
                } else if (!regex.test(value)) {
                    error = "Only alphanumeric and special characters allowed.";
                }

                if (error) {
                    $("#lastnameError").text(error).show();
                    $(this).css("border-color", "red");
                    $("#saveEdit").prop("disabled", true); // disable button
                } else {
                    $("#lastnameError").hide();
                    $(this).css("border-color", "green");
                    $("#saveEdit").prop("disabled", false); // enable button
                }
            });




        });




        $('#saveEdit').on('click', function() {
            var username = $('#editFirstname').val().trim();
            var password = $('#editLastname').val().trim();

            // ✅ Validation
            if (username === "") {
                alert("⚠️ Please enter User Name");
                $('#editFirstname').focus();
                return;
            }
            if (password === "") {
                alert("⚠️ Please enter Password");
                $('#editLastname').focus();
                return;
            }


            // ✅ AJAX request
            $.ajax({
                url: "update_subscribeid.php",
                type: "POST",
                data: {
                    username: username,
                    passwordstr: password
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
    </script>
</body>

</html>