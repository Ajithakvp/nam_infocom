<?php include("config.php"); ?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />

  <!-- Bootstrap 5 CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- DataTables CSS -->
  <link href="assets/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="assets/css/responsive.bootstrap5.min.css" rel="stylesheet">
  <link href="assets/css/buttons.dataTables.min.css" rel="stylesheet">

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">

  <!-- Select2 CSS -->
  <link href="assets/css/select2.min.css" rel="stylesheet" />
  <link href="https://cdn.jsdelivr.net/npm/@ttskch/select2-bootstrap4-theme@1.6.2/dist/select2-bootstrap4.min.css" rel="stylesheet" />

  <!-- jQuery UI CSS -->
  <link rel="stylesheet" href="assets/css/jquery-ui.css">

  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <!-- Wrapper -->
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6"
    data-sidebartype="full" data-sidebar-position="fixed" data-header-position="fixed">

    <!-- Sidebar -->
    <?php include("sidebar.php"); ?>

    <!-- Main Wrapper -->
    <div class="body-wrapper">
      <!-- Header -->
      <?php include("header.php"); ?>

      <div class="container-fluid">
        <div class="container mt-3">
          <div class="row g-3 align-items-end">
            <div class="col-auto">
              <label for="editStartdate" class="form-label">From Date</label>
              <input type="text" class="form-control" id="editStartdate" placeholder="Enter Start Date">
            </div>
            <div class="col-auto">
              <label for="editEnddate" class="form-label">To Date</label>
              <input type="text" class="form-control" id="editEnddate" placeholder="Enter End Date">
            </div>
            <div class="col-auto">
              <label for="editMobno" class="form-label">Mobile No</label>
              <input type="text" class="form-control" id="editMobno" placeholder="Enter Mobile Number">
            </div>
            <div class="col-auto">
              <label for="reportTypeid" class="form-label">Report Type</label>
              <select id="reportTypeid" class="form-control">
                <option value="">Select Report Type</option>
                <option value="1">Call Details</option>
                <option value="2">PBX</option>
                <option value="3">MobiWeb</option>
              </select>
            </div>
            <div class="col-auto" id="callTypeWrapper">
              <label for="callTypeid" class="form-label">Call Type</label>
              <select id="callTypeid" class="form-control" style="width: 200px;">
                <option value="">ALL</option>
                <option value="1">Audio</option>
                <option value="2">Video</option>
                <option value="3">IM</option>
                <option value="4">File Share</option>
                <option value="5">Audio Conference</option>
                <option value="6">Video Conference</option>
              </select>
            </div>
          </div>

          <!-- Buttons -->
          <div class="text-center mt-4">
            <button class="btn btn-primary" id="submitBtn">Submit</button>
            <button class="btn btn-danger" id="resetBtn">Cancel</button>
            <!-- Custom buttons -->
            <button id="customPrint" class="btn btn-warning" style="display: none;">Print</button>
            <button id="customExcel" class="btn btn-success">Dowload Report</button>
          </div>
        </div>
        <br>

        <!-- Table Results -->
        <div id="report_details"></div>
      </div>
    </div>
  </div>

  <!-- Core JS -->
  <script src="assets/js/jquery-3.6.0.min.js"></script>
  <script src="assets/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/jquery-ui.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>


  <!-- DataTables JS -->
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/dataTables.responsive.min.js"></script>
  <script src="assets/js/responsive.bootstrap5.min.js"></script>

  <!-- Buttons -->
  <script src="assets/js/dataTables.buttons.min.js"></script>
  <script src="assets/js/buttons.bootstrap5.min.js"></script>
  <script src="assets/js/buttons.print.min.js"></script>
  <script src="assets/js/buttons.html5.min.js"></script>
  <script src="assets/js/jszip.min.js"></script>

  <script>
    $(function() {
      $("#editStartdate, #editEnddate").datepicker({
        dateFormat: "yy-mm-dd",
        changeMonth: true,
        changeYear: true
      });
    });

    let table = null;

    $(document).ready(function() {
      // toggle
      function toggleCallType() {
        var reportType = $("#reportTypeid").val();
        if (reportType == "2") $("#callTypeWrapper").hide();
        else $("#callTypeWrapper").show();
      }
      toggleCallType();
      $("#reportTypeid").change(toggleCallType);

      // fetch and render table
      $("#submitBtn").on("click", function() {
        const startDate = $("#editStartdate").val();
        const endDate = $("#editEnddate").val();
        const mobileNo = $("#editMobno").val();
        const reportType = $("#reportTypeid").val();
        const callType = $("#callTypeid").val();

        if (reportType == "") {
          alert("Please Select Report Type...");
          return;
        }

        $.ajax({
          url: 'getreportdetails.php',
          type: 'POST',
          data: {
            start_date: startDate,
            end_date: endDate,
            mobile_no: mobileNo,
            report_type: reportType,
            call_type: callType
          },
          success: function(html) {
            // server MUST return a table with id="example" and full <thead> of all columns
            $("#report_details").html(html);

            // destroy if initialized
            if ($.fn.DataTable.isDataTable('#example')) {
              $('#example').DataTable().destroy();
              $('#example').empty(); // optional: ensure clean
              // re-insert returned HTML: already done by server
            }

            // Initialize DataTable and ensure _all_ columns are exported
            table = $('#example').DataTable({
              destroy: true,
              responsive: true,
              pageLength: 10,
              lengthMenu: [5, 10, 25, 50],
              dom: 'Bfrtip',
              buttons: [{
                  extend: 'print',
                  title: 'Report',
                  messageTop: 'Generated on: ' + new Date().toLocaleString(),
                  exportOptions: {
                    columns: function(idx, data, node) {
                      return true; // ✅ ensures all columns (visible + hidden) are exported
                    }
                  }
                },
                {
                  extend: 'excelHtml5',
                  title: 'Report',
                  exportOptions: {
                    columns: function(idx, data, node) {
                      return true; // ✅ ensures all columns are exported
                    }
                  }
                }
              ]
            });


            // Hide default Buttons UI if you prefer only custom triggers:
            table.buttons().container().hide();
          },
          error: function(xhr, status, error) {
            alert("Error: " + error);
          }
        });
      });

      // custom triggers:
      $(document).on('click', '#customPrint', function() {
        if (table) table.button('.buttons-print').trigger();
        else alert('Please load report first (click Submit).');
      });
      $(document).on('click', '#customExcel', function() {
        if (table) table.button('.buttons-excel').trigger();
        else alert('Please load report first (click Submit).');
      });

      // reset:
      $("#resetBtn").on('click', function() {
        $("#editStartdate,#editEnddate,#editMobno,#reportTypeid,#callTypeid").val('');
        $("#report_details").html('');
        if (table) {
          table.destroy();
          table = null;
        }
      });
    });
  </script>
</body>

</html>