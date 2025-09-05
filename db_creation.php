<?php
include("config.php");

$message = ""; // Initialize message

if (isset($_POST['backup'])) {

  // $host = "localhost";
  // $port = "5432";        
  // $db   = "nam_info";    
  // $user = "postgres";    
  // $pass = "admin";       

  // Backup file path with timestamp
  $timestamp = date('Y-m-d_H-i-s');
  $backup_file = __DIR__ . "/db_backup/backup_{$timestamp}.sql";  // SQL file instead of .backup

  // Path to pg_dump.exe
  $pg_dump_path = "\"E:\\Psql\\bin\\pg_dump.exe\"";

  // Set password in environment (important on Windows)
  putenv("PGPASSWORD={$pass}");

  // Build command for plain SQL format (-F p or just no -F)
  $command = "{$pg_dump_path} -h {$host} -p {$port} -U {$user} -F p -b -v -f \"{$backup_file}\" {$db}";

  // Execute command
  $output = [];
  $return_var = 0;
  exec($command . " 2>&1", $output, $return_var); // 2>&1 captures errors too

  if ($return_var === 0) {
    $message = "✅ Backup successful! File: <a href='db_backup/backup_{$timestamp}.sql' download>Download</a>";
  } else {
    $message = "❌ Backup failed!<br>Command: {$command}<br>Output:<br>" . implode("<br>", $output);
  }
}


if (isset($_POST['create_db'])) {
  // New database name (auto timestamped)
  $new_db = "nam_info_" . date('Ymd_His');

  // Path to PostgreSQL tools
  $createdb_path = "\"E:\\Psql\\bin\\createdb.exe\"";
  $psql_path     = "\"E:\\Psql\\bin\\psql.exe\"";

  // Path to your SQL dump file (the one you uploaded/backed up)
  $sql_file = __DIR__ . "/db_creation/dbcreate.sql";

  // Set password in environment
  putenv("PGPASSWORD={$pass}");

  // Step 1: Create empty DB
  $command1 = "{$createdb_path} -h {$host} -p {$port} -U {$user} {$new_db}";
  exec($command1 . " 2>&1", $output1, $ret1);

  if ($ret1 !== 0) {
    $message = "❌ Database creation failed!<br>Command: {$command1}<br>Output:<br>" . implode("<br>", $output1);
  } else {
    // Step 2: Import SQL into new DB
    $command2 = "{$psql_path} -h {$host} -p {$port} -U {$user} -d {$new_db} -f \"{$sql_file}\"";
    exec($command2 . " 2>&1", $output2, $ret2);

    if ($ret2 === 0) {
      $message = "✅ Database <b>{$new_db}</b> created and tables imported successfully!";
    } else {
      $message = "⚠️ Database created but import failed!<br>Command: {$command2}<br>Output:<br>" . implode("<br>", $output2);
    }
  }
}



?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DB Backup</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
  <link rel="stylesheet" href="assets/css/styles.min.css" />
</head>

<body>
  <div class="page-wrapper" id="main-wrapper" data-layout="vertical" data-navbarbg="skin6" data-sidebartype="full"
    data-sidebar-position="fixed" data-header-position="fixed">
    <?php include("sidebar.php"); ?>
    <div class="body-wrapper">
      <?php include("header.php"); ?>
      <div class="container-fluid">
        <div class="table-responsive">
          <form method="post">
            <table class="table table-bordered text-center mt-4">
              <thead>
                <tr>
                  <th>
                    <button class="btn btn-primary" type="submit" name="create_db">
                      <i class="fa fa-plus-circle"></i>&nbsp;&nbsp;DB Creation
                    </button>
                  </th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <td>
                    <button class="btn btn-primary" type="submit" name="backup">
                      <i class="fa fa-cloud-upload"></i> &nbsp;&nbsp;DB Backup (SQL)
                    </button>
                    <?php if (!empty($message)) echo "<p>$message</p>"; ?>
                  </td>
                </tr>
              </tbody>
            </table>
          </form>
        </div>
      </div>
    </div>
  </div>

  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>
</body>

</html>