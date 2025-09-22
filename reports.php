<?php include("config.php");
include("chksession.php");
?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Reports</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />

  <!-- Bootstrap 5 CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <link rel="stylesheet" href="assets/css/jquery-ui-timepicker-addon.min.css">


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
              <input type="number" class="form-control" id="editMobno" placeholder="Enter Mobile Number">
            </div>
            <div class="col-auto">
              <label for="reportTypeid" class="form-label">Report Type</label>
              <select id="reportTypeid" class="form-control">
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

  <script src="assets/js/jquery-ui-timepicker-addon.min.js"></script>


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
      var today = new Date();

      // Start of day (00:00:00) and End of day (23:59:59)
      var startOfDay = new Date(today.getFullYear(), today.getMonth(), today.getDate(), 0, 0, 0);
      var endOfDay = new Date(today.getFullYear(), today.getMonth(), today.getDate(), 23, 59, 59);

      // Common settings
      var options = {
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm:ss",
        changeMonth: true,
        changeYear: true,
        maxDate: today
      };

      // Start DateTime
      $("#editStartdate").datetimepicker($.extend({}, options, {
        onClose: function(selectedDate) {
          var startDate = $(this).datetimepicker("getDate");
          if (startDate) {
            startDate.setHours(0, 0, 0, 0); // 00:00:00
            $(this).datetimepicker("setDate", startDate);
            $("#editEnddate").datetimepicker("option", "minDate", startDate);
          }
        }
      })).datetimepicker("setDate", startOfDay);

      // End DateTime
      $("#editEnddate").datetimepicker($.extend({}, options, {
        onClose: function(selectedDate) {
          var startDate = $("#editStartdate").datetimepicker("getDate");
          var endDate = $(this).datetimepicker("getDate");

          if (endDate) {
            // Set time to 23:59:59
            endDate.setHours(23, 59, 59, 0);

            // Use setTimeout to avoid overriding by picker
            var self = $(this);
            setTimeout(function() {
              self.datetimepicker("setDate", endDate);
            }, 1);
          }

          if (startDate && endDate && endDate < startDate) {
            alert("End date cannot be earlier than Start date.");
            $(this).val("");
          }
        }
      })).datetimepicker("setDate", endOfDay);
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

      // declare table in outer scope
      let table;

      // fetch and render table
      $("#submitBtn").on("click", function() {
        const startDate = $("#editStartdate").val();
        const endDate = $("#editEnddate").val();
        const mobileNo = $("#editMobno").val();
        const reportType = $("#reportTypeid").val();
        const callType = $("#callTypeid").val();

        if (reportType === "") {
          alert("Please Select Report Type...");
          return;
        }

        if (startDate === "" || endDate === "") {
          alert("Please select both Start Date and End Date.");
          return;
        }

        if (new Date(startDate) > new Date(endDate)) {
          alert("Start Date cannot be later than End Date.");
          return;
        }

        let title = "";
        if (reportType === "1") {
          title =
            "Call Details Report" +
            (mobileNo ? " for " + mobileNo : "") +
            " from " +
            startDate +
            " to " +
            endDate + " Call Type : " + (callType ? $("#callTypeid option:selected").text() : "ALL");
        } else if (reportType === "2") {
          title =
            "PBX Report" +
            (mobileNo ? " for " + mobileNo : "") +
            " from " +
            startDate +
            " to " +
            endDate + " Call Type : " + (callType ? $("#callTypeid option:selected").text() : "ALL");
        } else if (reportType === "3") {
          title =
            "MobiWeb Report" +
            (mobileNo ? " for " + mobileNo : "") +
            " from " +
            startDate +
            " to " +
            endDate + " Call Type : " + (callType ? $("#callTypeid option:selected").text() : "ALL");
        }

        $.ajax({
          url: "getreportdetails.php",
          type: "POST",
          data: {
            start_date: startDate,
            end_date: endDate,
            mobile_no: mobileNo,
            report_type: reportType,
            call_type: callType,
          },
          success: function(html) {
            // server MUST return a table with id="example" and full <thead> of all columns
            $("#report_details").html(html);

            // destroy if initialized
            if ($.fn.DataTable.isDataTable("#example")) {
              $("#example").DataTable().destroy();
              $("#example").empty(); // optional: ensure clean
            }

            // Initialize DataTable and ensure _all_ columns are exported
            table = $("#example").DataTable({
              destroy: true,
              responsive: true,
              pageLength: 10,
              lengthMenu: [5, 10, 25, 50],
              dom: "Bfrtip",
              buttons: [{
                  extend: "print",
                  title: "Report",
                  messageTop: "Generated on: " + new Date().toLocaleString(),
                  exportOptions: {
                    columns: function(idx, data, node) {
                      return true; // ✅ ensures all columns (visible + hidden) are exported
                    },
                  },
                },
                {
                  extend: "excelHtml5",
                  title: title,
                  exportOptions: {
                    columns: function(idx, data, node) {
                      return true; // ✅ ensures all columns are exported
                    },
                  },
                  action: function(e, dt, button, config) {
                    if (dt.data().count() === 0) {
                      alert("⚠️ No data available!");
                      return; // ❌ stop export
                    }

                    // ✅ Call the original action if data exists
                    $.fn.dataTable.ext.buttons.excelHtml5.action.call(
                      this,
                      e,
                      dt,
                      button,
                      config
                    );
                  },
                },
              ],
            });

            // Hide default Buttons UI if you prefer only custom triggers:
            table.buttons().container().hide();
          },
          error: function(xhr, status, error) {
            alert("Error: " + error);
          },
        });
      });

      // custom triggers
      $(document).on("click", "#customPrint", function() {
        if (table) table.button(".buttons-print").trigger();
        else alert("Please load report first (click Submit).");
      });

      $(document).on("click", "#customExcel", function() {
        if (table) table.button(".buttons-excel").trigger();
        else alert("Please load report first (click Submit).");
      });


      // reset:
      $("#resetBtn").on('click', function() {
        location.reload();
      });
    });
  </script>
</body>

</html>