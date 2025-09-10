<?php include("config.php");
include("chksession.php");

include("check_table.php");
$ctbl = tablecheck($con, "group_setting"); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Group Settings</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />

  <!-- Bootstrap 5 CSS FIRST -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables CSS -->
  <link href="assets/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="assets/css/responsive.bootstrap5.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <!-- Select2 CSS + Bootstrap-ish theme -->
  <link href="assets/css/select2.min.css" rel="stylesheet" />
  <!-- Theme made for Bootstrap (v4 theme also works fine with v5) -->
  <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="assets/css/styles.min.css" />

  <style>
    /* Main select box */
    .modal-content {
      border-radius: 12px;
      box-shadow: 0 8px 30px rgba(0, 0, 0, 0.18);
    }

    .select2-container--open .select2-dropdown,
    .select2-container--open {
      z-index: 2100 !important;
    }

    .select2-container .select2-selection--single,
    .select2-container--default .select2-selection--multiple {
      border-radius: 8px;
      min-height: 45px;
      border: 1px solid #ced4da;
      padding: 4px;
      display: flex;
      flex-wrap: wrap;
      gap: 4px;
    }

    /* Selected tags (chips) */
    .select2-container--default .select2-selection--multiple .select2-selection__choice {
      background-color: #0d6efd;
      border: none;
      border-radius: 16px;
      padding: 4px 10px 4px 6px;
      font-size: 14px;
      color: #fff;
      display: inline-flex;
      align-items: center;
      white-space: nowrap;
    }

    /* Fix the "x" icon inside selected tags */
    .select2-container--default .select2-selection--multiple .select2-selection__choice__remove {
      color: #fff !important;
      margin-right: 6px;
      font-size: 14px;
      font-weight: bold;
      cursor: pointer;
      position: relative;
      top: 0;
    }

    /* Dropdown item container */
    .user-option {
      display: flex;
      align-items: flex-start;
      gap: 8px;
      padding: 6px;
    }

    .user-checkbox {
      margin-top: 3px;
    }

    .user-info {
      display: flex;
      flex-direction: column;
    }

    .user-name {
      font-weight: 600;
      color: #000;
      font-size: 14px;
    }

    .user-phone {
      font-size: 12px;
      color: #6c757d;
    }

    /* Highlight on hover */
    .select2-results__option--highlighted {
      background-color: #f0f0f0 !important;
      color: #000 !important;
    }

    /* Search box inside dropdown */
    .select2-container .select2-search--inline .select2-search__field {
      margin-top: 4px;
      font-size: 14px;
    }

    /* Force search box visible + cursor */
    .select2-container--default .select2-search--dropdown .select2-search__field {
      display: block !important;
      width: 100% !important;
      padding: 6px 8px !important;
      font-size: 14px !important;
      color: #000 !important;
    }
  </style>
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>

    <div class="body-wrapper">
      <!-- Header -->
      <?php include("header.php"); ?>

      <div class="container-fluid">
        <?php if ($ctbl) { ?>

          <!-- Top Bar -->
          <div class="top-bar mb-3 d-flex justify-content-end">
            <button class="btn btn-primary add-btn"><i class="fa fa-plus"></i> Add Group</button>
          </div>

          <!-- Table -->
          <div class="table-responsive">
            <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
              <thead>
                <tr>
                  <th>Action</th>
                  <th>Conference</th>
                  <th>Group Name</th>
                  <th>Group Number</th>
                  <th>Call Type</th>
                  <th>Moderate</th>
                  <th>View</th>
                </tr>
              </thead>
              <tbody>
                <?php
                $sql = "SELECT * FROM public.group_setting ORDER BY id DESC";
                $res = pg_query($con, $sql);
                if ($res && pg_num_rows($res) > 0) {
                  while ($row = pg_fetch_array($res)) {
                    $id = $row['id'];
                ?>
                    <tr data-id="<?php echo htmlspecialchars($id); ?>">
                      <td class="action-icons">
                        <i class="fa-regular fa-edit text-primary me-3 edit-btn" style="font-size:20px; cursor:pointer;"></i>
                        <i class="fa-regular fa-trash-alt text-danger delete-btn" style="font-size:20px; cursor:pointer;"></i>
                      </td>
                      <td><?php echo htmlspecialchars($row['conference']); ?></td>
                      <td><?php echo htmlspecialchars($row['group_name']); ?></td>
                      <td><?php echo htmlspecialchars($row['group_number']); ?></td>
                      <td><?php echo htmlspecialchars($row['calltype']); ?></td>
                      <td><?php echo htmlspecialchars($row['moderate']); ?></td>
                      <td>
                        <button class="btn btn-sm btn-primary" onclick="callviewinfo('<?php echo htmlspecialchars($id); ?>')">Info</button>
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
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Update Group</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editform">
            <div class="row g-3">
              <input type="hidden" id="editId" name="editId">

              <!-- Conference -->
              <div class="col-md-6">
                <label for="editconference" class="form-label">Conference</label>
                <select id="editconference" name="editconference" class="form-select select2" required>
                  <option value="Video">Video</option>
                  <option value="Audio">Audio</option>
                </select>
              </div>

              <!-- Call Type -->
              <div class="col-md-6">
                <label for="editcallType" class="form-label">Call Type</label>
                <select id="editcallType" name="editcallType" class="form-select select2" required>
                  <option value="Dial-OUT">Dial-OUT</option>
                  <option value="Dial-IN">Dial-IN</option>
                </select>
              </div>

              <!-- Group Name -->
              <div class="col-md-6">
                <label for="editgroupName" class="form-label">Group Name</label>
                <input type="text" class="form-control" id="editgroupName" name="editgroupName" required disabled>
              </div>

              <!-- Group Number -->
              <div class="col-md-6">
                <label for="editgroupNumber" class="form-label">Group Number</label>
                <input type="text" class="form-control" id="editgroupNumber" name="editgroupNumber" required>
              </div>

              <!-- Admin (single select) -->
              <div class="col-md-6" id="adminWrapper">
                <label for="editAdmin" class="form-label">Add Admin</label>
                <?php $sqleditadmin = "SELECT * FROM public.subscriber_profile WHERE  subscriber_id NOT IN('admin') ORDER BY id ASC";
                $reseditadmin = pg_query($con, $sqleditadmin); ?>
                <select id="editAdmin" name="editAdmin" class="form-select select2" data-live-search="true">
                  <?php if (pg_num_rows($reseditadmin) > 0) {

                    while ($roweditadmin = pg_fetch_array($reseditadmin)) {
                  ?>
                      <option value="<?php echo $roweditadmin['first_name'] . " - " . $roweditadmin['mobile_no'];  ?>"><?php echo $roweditadmin['first_name'] . " - " . $roweditadmin['mobile_no'];  ?></option>

                  <?php
                    }
                  } ?>

                </select>
              </div>

              <!-- edit Users (multi select) -->
              <div class="col-md-6">
                <label for="edituserSelect" class="form-label">Add User</label>
                <?php $sqledituser = "SELECT * FROM public.subscriber_profile WHERE subscriber_id NOT IN('admin') ORDER BY id ASC";
                $resedituser = pg_query($con, $sqledituser); ?>
                <select id="edituserSelect" name="editusers[]" class="form-control" multiple="multiple" required>
                  <?php if (pg_num_rows($resedituser) > 0) {

                    while ($rowedituser = pg_fetch_array($resedituser)) {
                  ?>
                      <option data-name="<?php echo $rowedituser['first_name'];  ?>" data-phone="<?php echo $rowedituser['mobile_no'];  ?>" value="<?php echo $rowedituser['first_name'] . " - " . $rowedituser['mobile_no'];  ?>"><?php echo $rowedituser['first_name'] . " - " . $rowedituser['mobile_no'];  ?></option>

                  <?php
                    }
                  } ?>

                </select>
              </div>

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="submit" class="btn btn-primary" id="saveEdit">Update</button>
        </div>
      </div>
    </div>
  </div>


  <!-- Add Modal -->
  <div class="modal fade" id="addModalgrp" tabindex="-1" aria-labelledby="addModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="addModalLabel">Add Group</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closegrp"></button>
        </div>
        <div class="modal-body">
          <form id="addForm">
            <div class="row g-3">

              <!-- Conference -->
              <div class="col-md-6">
                <label for="addconference" class="form-label">Conference</label>
                <select id="addconference" name="addconference" class="form-select select2" required>
                  <option value="Video">Video</option>
                  <option value="Audio">Audio</option>
                </select>
              </div>

              <!-- Call Type -->
              <div class="col-md-6">
                <label for="addcallType" class="form-label">Call Type</label>
                <select id="addcallType" name="addcallType" class="form-select select2" required>
                  <option value="Dial-OUT">Dial-OUT</option>
                  <option value="Dial-IN">Dial-IN</option>
                </select>
              </div>

              <!-- Group Name -->
              <div class="col-md-6">
                <label for="addgroupName" class="form-label">Group Name</label>
                <input type="text" class="form-control" id="addgroupName" name="addgroupName" required>
              </div>

              <!-- Group Number -->
              <div class="col-md-6">
                <label for="addgroupNumber" class="form-label">Group Number</label>
                <input type="text" class="form-control" id="addgroupNumber" name="addgroupNumber" required>
              </div>

              <!-- Admin (single select) -->
              <div class="col-md-6" id="adminWrapper">
                <label for="addAdmin" class="form-label">Add Admin</label>
                <?php $sqladdadmin = "SELECT * FROM public.subscriber_profile WHERE  subscriber_id NOT IN('admin') ORDER BY id ASC";
                $resaddadmin = pg_query($con, $sqladdadmin); ?>
                <select id="addAdmin" name="addAdmin" class="form-select select2" data-live-search="true">
                  <option value="">Add Admin</option>
                  <?php if (pg_num_rows($resaddadmin) > 0) {

                    while ($rowaddadmin = pg_fetch_array($resaddadmin)) {
                  ?>
                      <option value="<?php echo $rowaddadmin['first_name'] . " - " . $rowaddadmin['mobile_no'];  ?>"><?php echo $rowaddadmin['first_name'] . " - " . $rowaddadmin['mobile_no'];  ?></option>

                  <?php
                    }
                  } ?>

                </select>
              </div>

              <!-- Add Users (multi select) -->
              <div class="col-md-6">
                <label for="adduserSelect" class="form-label">Add User</label>
                <?php $sqladduser = "SELECT * FROM public.subscriber_profile WHERE  subscriber_id NOT IN('admin') ORDER BY id ASC";
                $resadduser = pg_query($con, $sqladduser); ?>
                <select id="adduserSelect" name="addusers[]" class="form-control" multiple="multiple" required>
                  <?php if (pg_num_rows($resadduser) > 0) {

                    while ($rowadduser = pg_fetch_array($resadduser)) {
                  ?>
                      <option data-name="<?php echo $rowadduser['first_name'];  ?>" data-phone="<?php echo $rowadduser['mobile_no'];  ?>" value="<?php echo $rowadduser['first_name'] . " - " . $rowadduser['mobile_no'];  ?>"><?php echo $rowadduser['first_name'] . " - " . $rowadduser['mobile_no'];  ?></option>

                  <?php
                    }
                  } ?>

                </select>
              </div>

            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" id="cancelgrp">Cancel</button>
          <button type="submit" class="btn btn-primary" form="addForm">Add</button>
        </div>
      </div>
    </div>
  </div>


  <!-- View Modal -->
  <div class="modal fade" id="viewModaluser" tabindex="-1" aria-labelledby="viewModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-lg">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="viewModalLabel">User Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <div id="viewuserdetails"></div>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete Group</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <strong id="deleteUserName"></strong>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Core JS (order matters) -->
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <!-- Select2 JS -->
  <script src="assets/js/select2.min.js"></script>



  <!-- App scripts -->
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>

  <!-- Bootstrap JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- DataTables JS -->
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/dataTables.responsive.min.js"></script>
  <script src="assets/js/responsive.bootstrap5.min.js"></script>

  <script>
    $(document).ready(function() {

      // Restrict to numbers only
      $("#addgroupNumber, #editgroupNumber").on("input", function() {
        this.value = this.value.replace(/[^0-9]/g, ""); // only numbers
        if (this.value.length > 4) {
          this.value = this.value.slice(0, 4); // max 4 digits
        }

        if (this.value.length === 4) {
          let prefix = this.id.startsWith("add") ? "add" : "edit";
          validateGroupNumber(prefix, false); // silent check (no alert on input)
        }
      });

      // ---- Validation Function ----
      function validateGroupNumber(prefix, showAlert = true) {
        let val = $("#" + prefix + "groupNumber").val();
        if (val.length !== 4) return false; // don’t validate until 4 digits entered

        let num = parseInt(val, 10);
        let conference = $("#" + prefix + "conference").val();
        let callType = $("#" + prefix + "callType").val();

        if (conference === "Audio") {
          if (num < 5000 || num > 5999) {
            if (showAlert) alert("For Audio, Group Number must be 5000–5999.");
            return false;
          }
        } else if (conference === "Video") {
          if (callType === "Dial-IN" && (num < 3000 || num > 3499)) {
            if (showAlert) alert("For Video + Dial-IN, Group Number must be 3000–3499.");
            return false;
          }
          if (callType === "Dial-OUT" && (num < 3500 || num > 3999)) {
            if (showAlert) alert("For Video + Dial-OUT, Group Number must be 3500–3999.");
            return false;
          }
        }
        return true;
      }

      // Update form UI rules
      function updateFormRules(prefix) {
        let conference = $("#" + prefix + "conference").val();
        let callType = $("#" + prefix + "callType").val();

        if (conference === "Audio") {
          $("#" + prefix + "callType").val("Dial-IN").prop("disabled", true);
          $("#" + prefix + "Admin").closest(".col-md-6").hide();
          $("#" + prefix + "Admin").val(null).trigger('change');
          $("#addgroupNumber, #editgroupNumber").attr("placeholder", "5000 - 5999 Series");

        } else if (conference === "Video") {
          $("#" + prefix + "callType").prop("disabled", false);
          if (callType === "Dial-IN") {
            $("#" + prefix + "Admin").closest(".col-md-6").hide();
            $("#" + prefix + "Admin").val(null).trigger('change');

            $("#addgroupNumber, #editgroupNumber").attr("placeholder", "3000 – 3499 Series");

          } else if (callType === "Dial-OUT") {
            $("#" + prefix + "Admin").closest(".col-md-6").show();
            $("#addgroupNumber, #editgroupNumber").attr("placeholder", "3500 – 3999 Series");

          }
        }
      }

      // Validate group number
      function validateGroupNumber(prefix) {
        let val = $("#" + prefix + "groupNumber").val();
        if (!/^\d{4}$/.test(val)) {
          alert("Group Number must be exactly 4 digits.");
          $("#" + prefix + "groupNumber").val("");
          return false;
        }

        let num = parseInt(val, 10);
        let conference = $("#" + prefix + "conference").val();
        let callType = $("#" + prefix + "callType").val();

        if (conference === "Audio") {
          if (num < 5000 || num > 5999) {
            alert("For Audio, Group Number must be between 5000–5999.");
            $("#" + prefix + "groupNumber").val("");
            $("#addgroupNumber, #editgroupNumber").attr("placeholder", "5000 - 5999 Series");
            return false;
          }
        } else if (conference === "Video") {
          if (callType === "Dial-IN" && (num < 3000 || num > 3499)) {
            alert("For Video + Dial-IN, Group Number must be between 3000–3499.");
            $("#" + prefix + "groupNumber").val("");
            $("#addgroupNumber, #editgroupNumber").attr("placeholder", "3000 – 3499 Series");

            return false;
          }
          if (callType === "Dial-OUT" && (num < 3500 || num > 3999)) {
            alert("For Video + Dial-OUT, Group Number must be between 3500–3999.");
            $("#addgroupNumber, #editgroupNumber").attr("placeholder", "3500 – 3999 Series");
            $("#" + prefix + "groupNumber").val("");
            return false;
          }
        }
        return true;
      }

      // Event bindings
      $("#addconference, #addcallType").on("change", function() {
        updateFormRules("add");
        $("#addgroupNumber").val(""); // reset on change
      });

      $("#editconference, #editcallType").on("change", function() {
        updateFormRules("edit");
        //$("#editgroupNumber").val(""); // reset on change
      });

      // Placeholder


      // Add form submit
      $("#addForm").on("submit", function(e) {
        e.preventDefault();

        if (!validateGroupNumber("add")) return;

        if (!this.checkValidity()) {
          this.reportValidity();
          return;
        }

        if ($("#addcallType").val() === "Dial-OUT" && !$("#addAdmin").val()) {
          alert("Select the Add Admin");
          return;
        }

        let callType = $("#addcallType").val();
        let selectedUsers = $("#adduserSelect").val() || [];
        let userCount = selectedUsers.length;

        let min = 0,
          max = 0;
        if (callType === "Dial-IN") {
          min = 2;
          max = 5;
        } else if (callType === "Dial-OUT") {
          min = 2;
          max = 9;
        }



        if (userCount < min || userCount > max) {
          alert(callType + " requires between " + min + " and " + max + " users.");
          return;
        }

        // Collect data using serialize()
        let formData = $(this).serialize();

        // Add disabled fields manually
        $(this).find(":input:disabled[name]").each(function() {
          formData += "&" + encodeURIComponent(this.name) + "=" + encodeURIComponent($(this).val());
        });

        $.ajax({
          url: "add_groupsettings.php",
          type: "POST",
          data: formData,
          success: function(response) {
            console.log(response);

            if (response.trim() === "success") {
              alert("✅ Group Added Successfully!");
              $("#addModalgrp").modal("hide");
              location.reload();
            } else {
              alert("❌ Error: " + response);
            }
          },
          error: function(xhr, status, error) {
            console.log("⚠️ Server error! (" + xhr.status + " " + error + ")");
          }
        });
      });


      // Edit form save
      $("#saveEdit").on("click", function(e) {
        e.preventDefault(); // Prevents the default form submission behavior

        // You can move the form validation here if you prefer
        // The previous code had it in the 'submit' handler

        // Check for validation errors before proceeding
        if (!validateGroupNumber("edit")) {
          return;
        }

        if ($("#editcallType").val() === "Dial-OUT" && !$("#editAdmin").val()) {
          alert("Select the Add Admin");
          return;
        }

        // Collect data using serialize()
        let formData = $("#editform").serialize();

        // Include the disabled `editgroupName` field in the serialized data
        $("#editform :input:disabled[name]").each(function() {
          formData += "&" + encodeURIComponent(this.name) + "=" + encodeURIComponent($(this).val());
        });

        // Debugging: Log the serialized data to the console
        console.log(formData);

        // AJAX call to submit the form data
        $.ajax({
          url: "edit_groupsettings.php",
          type: "POST",
          data: formData,
          success: function(response) {
            console.log(response);
            if (response.trim() === "success") {
              alert("✅ Group Updated Successfully!");
              $("#editModal").modal("hide");
              location.reload();
            } else {
              alert("⚠️" + response);
            }
          },
          error: function(xhr, status, error) {
            console.log("⚠️ Server error! (" + xhr.status + " " + error + ")");
          },
        });
      });


      // Init rules
      updateFormRules("add");
      updateFormRules("edit");
    });
  </script>



  <script>
    $(document).ready(function() {
      // DataTable
      $('#example').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50]
      });

      // Add button -> open modal and init Select2
      $('.add-btn').on('click', function() {
        const modalEl = document.getElementById('addModalgrp');
        const addModal = new bootstrap.Modal(modalEl);
        addModal.show();

        // Init when shown (ensures correct parent & sizes)
        $('#addModalgrp').one('shown.bs.modal', function() {
          initModalSelect2($('#addModalgrp'));
        }).one('hidden.bs.modal', function() {
          // Optional: clean up on close
          $('#addModalgrp .select2').each(function() {
            if ($(this).hasClass('select2-hidden-accessible')) {
              $(this).select2('destroy');
            }
          });
        });
      });

      // Edit button
      $('#example').on('click', '.edit-btn', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');

        // Save hidden id for updating
        $('#editId').val(id);

        console.log(row.find('td:eq(3)').text().trim());
        // Fill modal inputs
        $('#editconference').val(row.find('td:eq(1)').text().trim()).trigger('change');
        $('#editgroupName').val(row.find('td:eq(2)').text().trim());
        $('#editgroupNumber').val(row.find('td:eq(3)').text().trim());
        $('#editcallType').val(row.find('td:eq(4)').text().trim()).trigger('change');
        $('#editAdmin').val(row.find('td:eq(5)').text().trim()).trigger('change');

        // 🔹 If users list is stored separately (not in table cell), fetch via AJAX
        $.ajax({
          url: "fetch_group_users.php", // create this PHP to return users by group id
          type: "POST",
          data: {
            id: id
          },
          dataType: "json",
          success: function(response) {
            console.log(response);
            let users = [];

            if (response.length > 0) {
              users = response[0].split(","); // convert to array
            }

            $('#edituserSelect').val(users).trigger('change');
          }
        });

        // Open modal
        const editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
      });


      // Delete button
      $('#example').on('click', '.delete-btn', function() {
        const row = $(this).closest('tr');
        const id = row.data('id');
        const groupName = row.find('td:eq(2)').text();
        $('#deleteUserName').text(groupName);
        $('#confirmDelete').data('id', id);
        $('#confirmDelete').data('groupName', groupName);


        const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();

      });

      // When confirm delete is clicked
      $('#confirmDelete').on('click', function() {
        const id = $(this).data('id'); // retrieve id back
        const groupName = $(this).data('groupName'); // retrieve id back


        $.ajax({
          url: "delete_groupsettings.php",
          type: "POST",
          data: {
            id: id,
            groupName: groupName
          },
          success: function(response) {
            // Remove row from table if delete is successful
            alert(response);
            location.reload();
            // Hide modal
            const deleteModalEl = document.getElementById('deleteModal');
            const deleteModal = bootstrap.Modal.getInstance(deleteModalEl);
            deleteModal.hide();
          }
        });
      });


    });

    // View info
    function callviewinfo(id) {
      const viewModal = new bootstrap.Modal(document.getElementById('viewModaluser'));
      viewModal.show();
      $.ajax({
        url: "getgrpviewlist.php",
        type: "POST",
        data: {
          id: id
        },
        success: function(response) {
          $("#viewuserdetails").html(response);
        },
        error: function() {
          alert("Error connecting to server!");
        }
      });
    }

    function calldeleteinfo(id) {

    }
  </script>
  <script>
    $(document).ready(function() {


      //multiple Select2 User

      function createUserFormatter(selectId) {
        return function formatUser(user) {
          if (!user.id) return user.text;
          var name = $(user.element).data('name');
          var phone = $(user.element).data('phone');

          // check if already selected
          var selectedValues = $('#' + selectId).val() || [];
          var isChecked = selectedValues.includes(user.id.toString()) ? "checked" : "";

          // create option element
          var $option = $(
            '<div class="user-option" style="display:flex;align-items:center;cursor:pointer;">' +
            '<input type="checkbox" class="user-checkbox" data-id="' + user.id + '" ' + isChecked + ' style="margin-right:8px;" />' +
            '<div class="user-info" style="flex:1;">' +
            '<div class="user-name">' + name + '</div>' +
            '<div class="user-phone">' + phone + '</div>' +
            '</div>' +
            '</div>'
          );

          // unified toggle function
          function toggleSelection(checkbox, id) {
            if (checkbox.prop("checked")) {
              var values = $('#' + selectId).val() || [];
              if (!values.includes(id)) {
                values.push(id);
                $('#' + selectId).val(values).trigger("change");
              }
            } else {
              var values = ($('#' + selectId).val() || []).filter(v => v !== id);
              $('#' + selectId).val(values).trigger("change");
            }
          }

          // checkbox click
          $option.find("input[type=checkbox]").on("click", function(e) {
            e.stopPropagation();
            var $cb = $(this);
            toggleSelection($cb, $cb.data("id").toString());
          });

          // user-info click
          $option.find(".user-info").on("click", function(e) {
            e.stopPropagation();
            var $cb = $option.find("input[type=checkbox]");
            $cb.prop("checked", !$cb.prop("checked"));
            toggleSelection($cb, $cb.data("id").toString());
          });

          return $option;
        };
      }

      // 🔹 For Add Modal
      $('#adduserSelect').select2({
        placeholder: "Add User",
        templateResult: createUserFormatter("adduserSelect"),
        templateSelection: function(user) {
          if (!user.id) return user.text;
          return user.text;
        },
        allowClear: true,
        closeOnSelect: false,
        width: '100%',
        dropdownParent: $('#addModalgrp')
      });

      // 🔹 For Edit Modal
      $('#edituserSelect').select2({
        placeholder: "Edit User",
        templateResult: createUserFormatter("edituserSelect"),
        templateSelection: function(user) {
          if (!user.id) return user.text;
          return user.text;
        },
        allowClear: true,
        closeOnSelect: false,
        width: '100%',
        dropdownParent: $('#editModal')
      });


      // ---- Single select2 (Admin) ----
      function formatadmin(user) {
        if (!user.id) return user.text;
        let parts = user.text.split(" - ");
        let name = parts[0] || "";
        let phone = parts[1] || "";
        return $(
          '<div class="user-option">' +
          '<div class="user-info">' +
          '<div class="user-name">' + name + '</div>' +
          '<div class="user-phone">' + phone + '</div>' +
          '</div>' +
          '</div>'
        );
      }

      function formatUserSelection(user) {
        return user.text || user.id;
      }

      $('#addAdmin').select2({
        placeholder: "Select an Admin",
        allowClear: true,
        width: '100%',
        templateResult: formatadmin,
        templateSelection: formatUserSelection,
        minimumResultsForSearch: 0, // always enable search
        dropdownParent: $('#addModalgrp')
      });

      $('#editAdmin').select2({
        placeholder: "Select an Admin",
        allowClear: true,
        width: '100%',
        templateResult: formatadmin,
        templateSelection: formatUserSelection,
        minimumResultsForSearch: 0,
        dropdownParent: $('#editModal')
      });

    });
  </script>

  <script>
    document.getElementById("cancelgrp").addEventListener("click", function() {
      location.reload();
    });

    document.getElementById("closegrp").addEventListener("click", function() {
      location.reload();
    });
  </script>

</body>

</html>