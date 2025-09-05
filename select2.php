<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi Select Dropdown</title>

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet">

    <style>
        /* Tag style */
        .select2-container--default .select2-selection--multiple {
            background: #f8f9fa;
            border: 2px solid #0d6efd;
            border-radius: 10px;
            padding: 4px;
            min-height: 50px;
        }

        /* Tag (choice) style */
        .select2-container--default .select2-selection__choice {
            background-color: skyblue !important;
            border: none !important;
            border-radius: 10px !important;
            color: white !important;
            font-weight: 600;
            padding: 6px 12px;
        }

        /* Close (×) icon style */
        .select2-container--default .select2-selection__choice__remove {
            color: white !important;
            margin-right: 6px;
            font-size: 16px;
            background-color: red !important;
            font-weight: bold;
        }

        /* Dropdown styling */
        .select2-container--default .select2-results__option--highlighted {
            background-color: #0d6efd !important;
            color: white !important;
        }
    </style>
</head>

<body class="p-5">

    <div class="container">
        <h4 class="mb-3">Select Users</h4>
        <select id="users" class="form-control" multiple="multiple">
            <option value="all">Select All</option>
            <option value="ashok">Ashok Rajan</option>
            <option value="madhan">Madhan Anandan</option>
            <option value="kiran">Kiran Kumar</option>
            <option value="ajith">Ajith Kumar</option>
            <option value="arun">Arun Kumar</option>
        </select>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#users').select2({
                placeholder: "Search or select users",
                allowClear: true,
                closeOnSelect: false
            });

            // Handle "Select All"
            $('#users').on('select2:select', function(e) {
                if (e.params.data.id === "all") {
                    $("#users > option").prop("selected", "selected"); // select all
                    $("#users").trigger("change");
                }
            });

            // Handle "Deselect All"
            $('#users').on('select2:unselect', function(e) {
                if (e.params.data.id === "all") {
                    $("#users > option").prop("selected", false); // unselect all
                    $("#users").trigger("change");
                }
            });
        });
    </script>

</body>

</html>