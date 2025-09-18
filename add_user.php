<?php
//include("auth_check.php"); // protect page
include("config.php");
include("chksession.php");

// Prevent browser caching of this page
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

?>
<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <!-- Stop caching so a cached copy can't appear via Back -->
  <meta http-equiv="Cache-Control" content="no-store, no-cache, must-revalidate, max-age=0">
  <meta http-equiv="Pragma" content="no-cache">
  <meta http-equiv="Expires" content="0">
  <title>Add User</title>
  <link rel="shortcut icon" type="image/png" href="assets/images/logos/favicon.png" />
  <!-- Bootstrap CSS -->
  <link href="assets/css/bootstrap.min.css" rel="stylesheet">

  <!-- Select2 CSS -->
  <link href="assets/css/select2.min.css" rel="stylesheet" />

  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">


  <!-- <link rel="stylesheet" href="assets/css/all.min.css"> -->
  <!-- DataTables CSS -->
  <link href="assets/css/dataTables.bootstrap5.min.css" rel="stylesheet">
  <link href="assets/css/responsive.bootstrap5.min.css" rel="stylesheet">
  <link rel="stylesheet" href="assets/css/styles.min.css" />

  <style>
    /* -------------------------
       Modal / layout fixes
       ------------------------- */
    /* Allow dropdown to escape modal-body clipping */
    .modal {
      overflow: visible !important;
    }

    /* Make modal-body scrollable (so dropdown can appear outside the scroll area) */
    .modal .modal-body {
      max-height: calc(100vh - 220px);
      overflow: auto;
    }

    /* -------------------------
       Select2 core fixes
       ------------------------- */
    .select2-container {
      width: 100% !important;
      z-index: 2000 !important;
      /* above modal */
    }

    /* ensure dropdown itself sits visually above modal/backdrop */
    .select2-dropdown {
      z-index: 3000 !important;
      position: absolute !important;
      transform: none !important;
      /* avoid transform-based offset issues */
    }

    /* open state: disable extra transforms to keep positioning predictable */
    .select2-container--open .select2-dropdown {
      transform: none !important;
    }

    /* Select box look */
    .select2-container .select2-selection--single {
      min-height: 42px !important;
      padding: 6px 12px !important;
      border-radius: .375rem !important;
      border: 1px solid #ced4da !important;
      display: flex !important;
      align-items: center !important;
      background: #fff !important;
      font-size: 14px !important;
      box-shadow: none !important;
      width: 100% !important;
    }

    .select2-selection__rendered {
      display: flex !important;
      align-items: center !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      white-space: nowrap !important;
    }

    .select2-selection__arrow {
      right: 8px !important;
    }

    /* Results list */
    .select2-results__options {
      max-height: 260px !important;
      overflow-y: auto !important;
      -webkit-overflow-scrolling: touch !important;
      padding: 0 !important;
      margin: 0 !important;
    }

    .select2-results__option {
      padding: 8px 12px !important;
      font-size: 14px !important;
      white-space: nowrap !important;
      overflow: hidden !important;
      text-overflow: ellipsis !important;
      display: block !important;
      cursor: pointer !important;
    }

    .select2-container--default .select2-results__option--highlighted[aria-selected] {
      background-color: #0d6efd !important;
      color: #fff !important;
    }

    /* Flag + text layout inside each option */
    .country-option {
      display: flex;
      align-items: center;
    }

    .flag-img,
    .select2-selection__rendered img {
      width: 20px;
      height: 14px;
      object-fit: cover;
      margin-right: 8px;
      border: 1px solid #ddd;
      border-radius: 2px;
    }

    /* -------------------------
       Responsive tweaks
       ------------------------- */
    @media (max-width: 576px) {
      .select2-container .select2-selection--single {
        min-height: 38px !important;
        font-size: 13px !important;
        padding: 4px 10px !important;
      }

      .select2-results__option {
        font-size: 12px !important;
        padding: 6px 10px !important;
      }

      .flag-img {
        width: 16px;
        height: 12px;
        margin-right: 6px;
      }
    }

    @media (min-width: 577px) and (max-width: 991px) {
      .select2-container .select2-selection--single {
        min-height: 40px !important;
        font-size: 13px !important;
      }

      .select2-results__option {
        font-size: 13px !important;
      }

      .flag-img {
        width: 18px;
        height: 13px;
      }
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
        <!-- Top Bar -->
        <?php if ($_SESSION['type'] == 'admin') { ?>

          <div class="top-bar mb-3 d-flex justify-content-end">
            <button class="btn btn-primary add-btn"><i class='fa fa-plus'></i> Add User</button>
          </div>
        <?php } ?>

        <!--  Row 1 -->
        <div class="table-responsive">
          <table id="example" class="table table-striped table-bordered nowrap" style="width:100%">
            <thead>
              <tr>
                <?php
                if ($_SESSION['type'] == 'admin') { ?>
                  <th>Action</th>
                <?php } ?>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Country</th>
                <th>Mobile No</th>
                <th>User ID</th>
                <th>Password</th>
                <th>Timezone</th>
                <th>Email ID</th>
                <th>Group ID</th>
                <th>PBX No</th>
                <th>Company Name</th>
                <th>Designation</th>
                <th>Address</th>
                <th>City </th>
                <th>State</th>
                <th>Area Code</th>
                <th>Residence Number</th>
                <th>Extension Number</th>
                <th>Profile</th>
                <th>IP Phone No</th>
                <th>Mobion</th>
                <th>Mobiweb</th>
              </tr>
            </thead>
            <tbody>

              <?php
              if ($_SESSION['type'] == 'admin') {
                $sql = "SELECT * FROM public.subscriber_profile WHERE subscriber_id NOT IN ('admin') ORDER BY id DESC";
              } else {
                $sql = "SELECT * FROM public.subscriber_profile WHERE subscriber_id IN ('" . $_SESSION['subscriber_id'] . "') ORDER BY id DESC";
              }
              $res = pg_query($con, $sql);
              if (pg_num_rows($res) > 0) {
                while ($row = pg_fetch_array($res)) {
              ?>
                  <tr>
                    <?php
                    if ($_SESSION['type'] == 'admin') { ?>
                      <td class="action-icons">
                        <i class="fa-regular fa-edit text-primary me-3 editBtn" style="font-size:20px; cursor:pointer;" data-id="<?php echo $row['id']; ?>"
                          data-firstname="<?php echo $row['first_name']; ?>"
                          data-lastname="<?php echo $row['last_name']; ?>"
                          data-email="<?php echo $row['email']; ?>"
                          data-mobile="<?php echo $row['mobile_no']; ?>"
                          data-country="<?php echo $row['country']; ?>"
                          data-userid="<?php echo $row['subscriber_id']; ?>"
                          data-password="<?php echo $row['subscriber_password']; ?>"
                          data-timezone="<?php echo $row['timezone']; ?>"
                          data-groupid="<?php echo $row['groupid']; ?>"
                          data-pbx="<?php echo $row['pbx']; ?>"
                          data-company="<?php echo $row['company_name']; ?>"
                          data-designation="<?php echo $row['designation']; ?>"
                          data-address="<?php echo $row['addr_1']; ?>"
                          data-city="<?php echo $row['city']; ?>"
                          data-state="<?php echo $row['state']; ?>"
                          data-area="<?php echo $row['area_code']; ?>"
                          data-residence="<?php echo $row['res_no']; ?>"
                          data-ext="<?php echo $row['extension_no']; ?>"
                          data-profile="<?php echo $row['profile']; ?>"
                          data-ipphone="<?php echo $row['ipphoneno']; ?>"
                          data-mobion="<?php echo $row['mobion']; ?>"
                          data-mobiweb="<?php echo $row['mobiweb']; ?>"></i>
                        <i class="fa-regular fa-trash-alt text-danger deleteUser"
                          style="font-size:20px; cursor:pointer;"
                          data-id="<?php echo $row['id']; ?>"
                          data-name="<?php echo $row['first_name']; ?>"
                          data-userid="<?php echo $row['subscriber_id']; ?>">
                        </i>
                      </td>
                    <?php } ?>
                    <td><?php echo $row['first_name']; ?></td>
                    <td><?php echo $row['last_name']; ?></td>
                    <td><?php echo $row['country']; ?></td>
                    <td><?php echo $row['mobile_no']; ?></td>
                    <td><?php echo $row['subscriber_id']; ?></td>
                    <td><?php echo $row['subscriber_password']; ?></td>
                    <td><?php echo $row['timezone']; ?></td>
                    <td><?php echo $row['email']; ?></td>
                    <td><?php echo $row['groupid']; ?></td>
                    <td><?php echo $row['pbx']; ?></td>
                    <td><?php echo $row['company_name']; ?></td>
                    <td><?php echo $row['designation']; ?></td>
                    <td><?php echo $row['addr_1']; ?></td>
                    <td><?php echo $row['city']; ?></td>
                    <td><?php echo $row['state']; ?></td>
                    <td><?php echo $row['area_code']; ?></td>
                    <td><?php echo $row['res_no']; ?></td>
                    <td><?php echo $row['extension_no']; ?></td>
                    <td><?php echo $row['profile']; ?></td>
                    <td><?php echo $row['ipphoneno']; ?></td>
                    <td><?php echo $row['mobion']; ?></td>
                    <td><?php echo $row['mobiweb']; ?></td>
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

  <!-- ADD Modal -->
  <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl"> <!-- Extra large modal -->
      <div class="modal-content">

        <div class="modal-header">
          <h5 class="modal-title" id="addUserLabel">Add User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" id="closeaddUser" aria-label="Close"></button>
        </div>

        <div class="modal-body">
          <form id="addUserForm">
            <div class="row g-3">

              <!-- First Column -->
              <div class="col-md-3">
                <label for="addfirstName" class="form-label">First Name <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="addfirstName" name="addfirstName" placeholder="Firstname" maxlength="100"
                  required>
              </div>

              <div class="col-md-3">
                <label for="addlastName" class="form-label">Last Name <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="addlastName" name="addlastName" placeholder="Lastname" maxlength="100" required>
              </div>

              <div class="col-md-3">
                <label for="addemail" class="form-label">Email</label>
                <input type="email" class="form-control" id="addemail" name="addemail" placeholder="Email" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="addmobileNo" class="form-label">Mobile No <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="addmobileNo" name="addmobileNo" placeholder="MobileNo" maxlength="15" required>
                <span id="addmobileNoError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="addcountry" class="form-label">Country <span class="text-danger" style="font-size: large;">*</span></label>
                <select id="addcountry" name="addcountry" class="form-select" style="width: 100%;" required>
                  <option value="">--Select country--</option>
                </select>
              </div>

              <div class="col-md-3">
                <label for="addcountrycode" class="form-label">Country Code <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="addcountrycode" name="addcountrycode" placeholder="Country Code" maxlength="50" required readonly>
                <!-- <span id="userIdError" style="color:red;display:none;font-size:14px;"></span> -->

              </div>

              <!-- 
              <input type="hidden" id="addcountrycode" /> -->

              <div class="col-md-3">
                <label for="adduserId" class="form-label">User ID <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="adduserId" name="adduserId" placeholder="UserId" maxlength="50" required>
                <span id="userIdError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="addpassword" class="form-label">Password <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="password" class="form-control" id="addpassword" name="addpassword" placeholder="Password" maxlength="50"
                  required>
                <span id="passwordError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="addtimezone" class="form-label">Timezone <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="addtimezone" name="addtimezone" placeholder="Timezone" required readonly>
              </div>

              <div class="col-md-3">
                <label for="addgroupId" class="form-label">Group ID</label>
                <input type="text" class="form-control" id="addgroupId" name="addgroupId" placeholder="GroupID" maxlength="50">
              </div>

              <div class="col-md-3">
                <label for="addpbxNo" class="form-label">PBX No</label>
                <input type="text" class="form-control" id="addpbxNo" name="addpbxNo" placeholder="PBX No" maxlength="20">
              </div>

              <div class="col-md-3">
                <label for="addcompanyName" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="addcompanyName" name="addcompanyName" placeholder="CompanyName" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="adddesignation" class="form-label">Designation</label>
                <input type="text" class="form-control" id="adddesignation" name="adddesignation" placeholder="Designation" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="addaddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="addaddress" name="addaddress" placeholder="Address" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="addcity" class="form-label">City <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="addcity" name="addcity" placeholder="City" required maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="addstate" class="form-label">State</label>
                <input type="text" class="form-control" id="addstate" name="addstate" placeholder="State" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="addareaCode" class="form-label">Area Code</label>
                <input type="text" class="form-control" id="addareaCode" name="addareaCode" placeholder="AreaCode" maxlength="20">
              </div>

              <div class="col-md-3">
                <label for="addresidenceNumber" class="form-label">Residence Number</label>
                <input type="text" class="form-control" id="addresidenceNumber" name="addresidenceNumber"
                  placeholder="Residencenumber" maxlength="20">
                <span id="addresidenceNumberError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="addextensionNo" class="form-label">Extension No</label>
                <input type="text" class="form-control" id="addextensionNo" name="addextensionNo" placeholder="ExtensionNo" maxlength="20">
                <span id="addextensionNoError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="addprofile" class="form-label">Profile</label>
                <select id="addprofile" name="addprofile" class="form-select">
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>


              <div class="col-md-3">
                <label for="addipPhoneNo" class="form-label">IP Phone No</label>
                <input type="text" class="form-control" id="addipPhoneNo" name="addipPhoneNo" placeholder="IPPhoneNo" maxlength="20">
                <span id="addipPhoneNoError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="addmobion" class="form-label">Mobion</label>
                <input type="text" class="form-control" id="addmobion" name="addmobion" placeholder="Mobion" maxlength="20">
              </div>

              <div class="col-md-3">
                <label for="addmobiweb" class="form-label">Mobiweb</label>
                <input type="text" class="form-control" id="addmobiweb" name="addmobiweb" placeholder="Mobiweb" maxlength="20">
              </div>

            </div>
          </form>
        </div>

        <div class="modal-footer">
          <button type="button" class="btn btn-primary" id="submitAddUser">Add</button>
          <button type="button" class="btn btn-secondary" id="cancelAddUser" data-bs-dismiss="modal">Cancel</button>
        </div>

      </div>
    </div>
  </div>



  <!-- Edit Modal -->
  <div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
    <div class="modal-dialog modal-xl">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="editModalLabel">Edit User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          <form id="editForm">
            <div class="row g-3">

              <!-- First Column -->
              <div class="col-md-3">
                <label for="editfirstName" class="form-label">First Name <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="editfirstName" name="editfirstName" placeholder="Firstname" maxlength="100"
                  required>
              </div>

              <div class="col-md-3">
                <label for="editlastName" class="form-label">Last Name <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="editlastName" name="editlastName" placeholder="Lastname" required maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="editemail" class="form-label">Email</label>
                <input type="email" class="form-control" id="editemail" name="editemail" placeholder="Email" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="editmobileNo" class="form-label">Mobile No <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="editmobileNo" name="editmobileNo" placeholder="MobileNo" required maxlength="15">
                <span id="editmobileNoError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="editcountry" class="form-label">Country <span class="text-danger" style="font-size: large;">*</span></label>
                <select id="editcountry" name="editcountry" class="form-select" style="width: 100%;" required>
                  <option value="">--Select country--</option>
                </select>
              </div>

              <div class="col-md-3">
                <label for="editcountrycode" class="form-label">Country Code <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="editcountrycode" name="editcountrycode" placeholder="Country Code" maxlength="50" required readonly>
                <!-- <span id="userIdError" style="color:red;display:none;font-size:14px;"></span> -->

              </div>
              <!-- <input type="hidden" id="editcountrycode" /> -->

              <div class="col-md-3">
                <label for="edituserId" class="form-label">User ID <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="edituserId" name="edituserId" placeholder="UserId" required disabled maxlength="50">
              </div>

              <div class="col-md-3">
                <label for="editpassword" class="form-label">Password <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="password" class="form-control" id="editpassword" name="editpassword" placeholder="Password" maxlength="50"
                  required>
              </div>

              <div class="col-md-3">
                <label for="edittimezone" class="form-label">Timezone <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="edittimezone" name="edittimezone" placeholder="Timezone" required readonly>
              </div>

              <div class="col-md-3">
                <label for="editgroupId" class="form-label">Group ID</label>
                <input type="text" class="form-control" id="editgroupId" name="editgroupId" placeholder="GroupID" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="editpbxNo" class="form-label">PBX No</label>
                <input type="text" class="form-control" id="editpbxNo" name="editpbxNo" placeholder="PBXNo" maxlength="20">
              </div>

              <div class="col-md-3">
                <label for="editcompanyName" class="form-label">Company Name</label>
                <input type="text" class="form-control" id="editcompanyName" name="editcompanyName" placeholder="CompanyName" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="editdesignation" class="form-label">Designation</label>
                <input type="text" class="form-control" id="editdesignation" name="editdesignation" placeholder="Designation" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="editaddress" class="form-label">Address</label>
                <input type="text" class="form-control" id="editaddress" name="editaddress" placeholder="Address" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="editcity" class="form-label">City <span class="text-danger" style="font-size: large;">*</span></label>
                <input type="text" class="form-control" id="editcity" name="editcity" placeholder="City" required maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="editstate" class="form-label">State</label>
                <input type="text" class="form-control" id="editstate" name="editstate" placeholder="State" maxlength="100">
              </div>

              <div class="col-md-3">
                <label for="editareaCode" class="form-label">Area Code</label>
                <input type="text" class="form-control" id="editareaCode" name="editareaCode" placeholder="AreaCode" maxlength="20">
              </div>

              <div class="col-md-3">
                <label for="editresidenceNumber" class="form-label">Residence Number</label>
                <input type="text" class="form-control" id="editresidenceNumber" name="editresidenceNumber"
                  placeholder="Residencenumber" maxlength="20">
                <span id="editresidenceNumberError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="editextensionNo" class="form-label">Extension No</label>
                <input type="text" class="form-control" id="editextensionNo" name="editextensionNo" placeholder="ExtensionNo" maxlength="20">
                <span id="editextensionNoError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="editprofile" class="form-label">Profile</label>
                <select id="editprofile" name="editprofile" class="form-select">
                  <option value="user">User</option>
                  <option value="admin">Admin</option>
                </select>
              </div>

              <div class="col-md-3">
                <label for="editipPhoneNo" class="form-label">IP Phone No</label>
                <input type="text" class="form-control" id="editipPhoneNo" name="editipPhoneNo" placeholder="IPPhoneNo" maxlength="20">
                <span id="editipPhoneNoError" style="color:red;display:none;font-size:14px;"></span>

              </div>

              <div class="col-md-3">
                <label for="editmobion" class="form-label">Mobion</label>
                <input type="text" class="form-control" id="editmobion" name="editmobion" placeholder="Mobion" maxlength="20">
              </div>

              <div class="col-md-3">
                <label for="editmobiweb" class="form-label">Mobiweb</label>
                <input type="text" class="form-control" id="editmobiweb" name="editmobiweb" placeholder="Mobiweb" maxlength="20">
              </div>
            </div>
            <!-- Add more fields as needed -->
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="saveEdit">Save Changes</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Delete Confirmation Modal -->
  <div class="modal fade" id="deleteModal" tabindex="-1" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Delete User</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
          Are you sure you want to delete <span id="deleteUserName"></span>?
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-danger" id="confirmDelete">Delete</button>
        </div>
      </div>
    </div>
  </div>
  <script src="assets/libs/jquery/dist/jquery.min.js"></script>
  <script src="assets/js/sidebarmenu.js"></script>
  <script src="assets/js/app.min.js"></script>


  <!-- Bootstrap JS -->
  <script src="assets/js/bootstrap.bundle.min.js"></script>

  <!-- Select2 JS -->
  <script src="assets/js/select2.min.js"></script>


  <!-- DataTables JS -->
  <script src="assets/js/jquery.dataTables.min.js"></script>
  <script src="assets/js/dataTables.bootstrap5.min.js"></script>
  <script src="assets/js/dataTables.responsive.min.js"></script>
  <script src="assets/js/responsive.bootstrap5.min.js"></script>


  <!-- Custom JS -->
  <script>
    $(document).ready(function() {
      let rowToEdit;

      $('.add-btn').on('click', function() {
        let addModal = new bootstrap.Modal(document.getElementById('addUserModal'));
        addModal.show();
        $("#adduserId").css("border-color", "");
        $("#addpassword").css("border-color", "");

        $("#passwordError").hide();
        $("#userIdError").hide();


      });

      $("#editipPhoneNo, #addipPhoneNo, #editextensionNo, #addextensionNo, #editresidenceNumber, #addresidenceNumber, #editmobileNo, #addmobileNo").on("input", function() {
        // Strip non-numeric characters
        let original = this.value;
        this.value = this.value.replace(/[^0-9]/g, "");

        let $field = $(this);
        let id = this.id;

        if (this.value !== original) {
          // Show error if any non-numeric was removed
          $("#" + id + "Error").text("Please enter only numeric values.").show();
          $field.css("border-color", "red");
        } else {
          // Hide error when only digits
          $("#" + id + "Error").hide();
          $field.css("border-color", "green");
        }
      });


      // $("#editipPhoneNo, #addipPhoneNo,#editextensionNo,#addextensionNo,#editresidenceNumber,#addresidenceNumber,#editmobileNo,#addmobileNo").on("input", function() {
      //   this.value = this.value.replace(/[^0-9]/g, "");

      // });

      function validateadduseridForm() {
        let userValid = false;

        // Validate User ID (numbers only, length 4–50)
        let userId = $("#adduserId").val().trim();
        let userRegex = /^[0-9]+$/;
        if (userId.length < 4 || userId.length > 50) {
          $("#userIdError").text("User ID must be 4–50 digits.").show();
          $("#adduserId").css("border-color", "red");
          userValid = false;
        } else if (!userRegex.test(userId)) {
          $("#userIdError").text("User ID must contain only numbers.").show();
          $("#adduserId").css("border-color", "red");
          userValid = false;
        } else {
          $("#userIdError").hide();
          $("#adduserId").css("border-color", "green");
          userValid = true;
        }


        // Enable/Disable Submit
        if (userValid) {
          $("#saveUser").prop("disabled", false);
        } else {
          $("#saveUser").prop("disabled", true);
        }
      }


      function validatepassForm() {
        let passValid = false;



        // Validate Password (alphanumeric + special chars, length 4–50)
        let password = $("#addpassword").val().trim();
        let passRegex = /^[a-zA-Z0-9!@#$%^&*(),.?":{}|<>_\- ]+$/;
        if (password.length < 4 || password.length > 50) {
          $("#passwordError").text("Password must be 4–50 characters.").show();
          $("#addpassword").css("border-color", "red");
          passValid = false;
        } else if (!passRegex.test(password)) {
          $("#passwordError").text("Password can contain letters, numbers, and special characters.").show();
          $("#addpassword").css("border-color", "red");
          passValid = false;
        } else {
          $("#passwordError").hide();
          $("#addpassword").css("border-color", "green");
          passValid = true;
        }

        // Enable/Disable Submit
        if (passValid) {
          $("#saveUser").prop("disabled", false);
        } else {
          $("#saveUser").prop("disabled", true);
        }
      }

      // Run validation on input
      $("#addpassword").on("input", validatepassForm);
      $("#adduserId").on("input", validateadduseridForm);



      // Initialize DataTable
      $('#example').DataTable({
        responsive: true,
        pageLength: 10,
        lengthMenu: [5, 10, 25, 50],

      });

      // Edit icon click (only inside table)
      $('#example').on('click', 'td.action-icons .fa-edit', function() {
        let editModal = new bootstrap.Modal(document.getElementById('editModal'));
        editModal.show();
      });








      // Open modal when trash icon clicked
      let rowToDelete = null;
      let deleteUserId = null;
      let user_id = null;
      $('#example').on('click', '.deleteUser', function() {
        rowToDelete = $(this).closest('tr');
        deleteUserId = $(this).data('id'); // user id from DB
        let userName = $(this).data('name'); // first name
        user_id = $(this).data('userid'); // first name

        $('#deleteUserName').text(userName);

        let deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
        deleteModal.show();
      });

      // Confirm delete
      $('#confirmDelete').on('click', function() {
        if (deleteUserId != "" && user_id != "") {
          $.ajax({
            url: 'delete_user.php',
            type: 'POST',
            data: {
              id: deleteUserId,
              user_id: user_id

            },
            success: function(response) {
              console.log(response.trim());
              if (response.trim() === "success") {
                location.reload();
              } else {
                alert("❌ Error deleting user!");
              }
            },
            error: function() {
              alert("❌ Server error!");
            }
          });
        }

        // Close modal
        let modalEl = document.getElementById('deleteModal');
        let modal = bootstrap.Modal.getInstance(modalEl);
        modal.hide();
      });



      $("#submitAddUser").on("click", function() {
        let form = $("#addUserForm")[0];

        if (!form.checkValidity()) {
          form.reportValidity(); // Show native HTML5 errors
          return;
        }

        let formData = $("#addUserForm").serialize();

        console.log(...formData); // Debug


        $.ajax({
          url: "add_userquery.php",
          type: "POST",
          data: formData,
          success: function(response) {

            if (response.trim() == "1") {
              alert("✅ User added successfully!");
              location.reload();
            } else {
              alert(response);
            }

          },
          error: function() {
            alert(" ❌ Error adding user. Try again");
          }
        });
      });

    });
  </script>
  <script type="text/javascript">
    // Prevent back button
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
      history.pushState(null, null, location.href);
    };
  </script>


  <script>
    (function() {
      // Push two states so the first Back press stays on the page
      const push = () => history.pushState({
        trap: true
      }, "", location.href);
      push(); // state #1
      push(); // state #2

      // Whenever the user tries Back/Forward, immediately re-push a state
      window.addEventListener("popstate", function(e) {
        push();
      });

      // If the page was restored from the back/forward cache, force a reload
      window.addEventListener("pageshow", function(e) {
        const nav = (performance.getEntriesByType && performance.getEntriesByType("navigation")[0]) || {};
        if (e.persisted || nav.type === "back_forward") {
          location.reload(); // with no-store headers, this won’t show a stale page
        }
      });

      // OPTIONAL: uncomment to show a native “Leave site?” confirm on any navigation
      // window.addEventListener("beforeunload", function (e) {
      //   e.preventDefault();
      //   e.returnValue = "";
      // });
    })();
  </script>


  <script>
    const countries = [{
        name: "India",
        code: "+91",
        timezone: "UTC+05:30",
        flag: "https://flagcdn.com/in.svg"
      },
      {
        name: "United States",
        code: "+1",
        timezone: "UTC−05:00",
        flag: "https://flagcdn.com/us.svg"
      },
      {
        name: "United Kingdom",
        code: "+44",
        timezone: "UTC+00:00",
        flag: "https://flagcdn.com/gb.svg"
      },
      {
        name: "Australia",
        code: "+61",
        timezone: "UTC+10:00",
        flag: "https://flagcdn.com/au.svg"
      },
      {
        name: "Canada",
        code: "+1",
        timezone: "UTC−05:00",
        flag: "https://flagcdn.com/ca.svg"
      },
      {
        name: "Germany",
        code: "+49",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/de.svg"
      },
      {
        name: "France",
        code: "+33",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/fr.svg"
      },
      {
        name: "Brazil",
        code: "+55",
        timezone: "UTC−03:00",
        flag: "https://flagcdn.com/br.svg"
      },
      {
        name: "Japan",
        code: "+81",
        timezone: "UTC+09:00",
        flag: "https://flagcdn.com/jp.svg"
      },
      {
        name: "China",
        code: "+86",
        timezone: "UTC+08:00",
        flag: "https://flagcdn.com/cn.svg"
      },
      {
        name: "Russia",
        code: "+7",
        timezone: "UTC+03:00 to UTC+12:00",
        flag: "https://flagcdn.com/ru.svg"
      },
      {
        name: "South Africa",
        code: "+27",
        timezone: "UTC+02:00",
        flag: "https://flagcdn.com/za.svg"
      },
      {
        name: "Mexico",
        code: "+52",
        timezone: "UTC−06:00",
        flag: "https://flagcdn.com/mx.svg"
      },
      {
        name: "Italy",
        code: "+39",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/it.svg"
      },
      {
        name: "Spain",
        code: "+34",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/es.svg"
      },
      {
        name: "Netherlands",
        code: "+31",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/nl.svg"
      },
      {
        name: "Sweden",
        code: "+46",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/se.svg"
      },
      {
        name: "Norway",
        code: "+47",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/no.svg"
      },
      {
        name: "Denmark",
        code: "+45",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/dk.svg"
      },
      {
        name: "Switzerland",
        code: "+41",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/ch.svg"
      },
      {
        name: "Belgium",
        code: "+32",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/be.svg"
      },
      {
        name: "Austria",
        code: "+43",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/at.svg"
      },
      {
        name: "Ireland",
        code: "+353",
        timezone: "UTC+00:00",
        flag: "https://flagcdn.com/ie.svg"
      },
      {
        name: "New Zealand",
        code: "+64",
        timezone: "UTC+12:00",
        flag: "https://flagcdn.com/nz.svg"
      },
      {
        name: "Singapore",
        code: "+65",
        timezone: "UTC+08:00",
        flag: "https://flagcdn.com/sg.svg"
      },
      {
        name: "Malaysia",
        code: "+60",
        timezone: "UTC+08:00",
        flag: "https://flagcdn.com/my.svg"
      },
      {
        name: "Thailand",
        code: "+66",
        timezone: "UTC+07:00",
        flag: "https://flagcdn.com/th.svg"
      },
      {
        name: "Indonesia",
        code: "+62",
        timezone: "UTC+07:00 to UTC+09:00",
        flag: "https://flagcdn.com/id.svg"
      },
      {
        name: "Philippines",
        code: "+63",
        timezone: "UTC+08:00",
        flag: "https://flagcdn.com/ph.svg"
      },
      {
        name: "Pakistan",
        code: "+92",
        timezone: "UTC+05:00",
        flag: "https://flagcdn.com/pk.svg"
      },
      {
        name: "Bangladesh",
        code: "+880",
        timezone: "UTC+06:00",
        flag: "https://flagcdn.com/bd.svg"
      },
      {
        name: "Sri Lanka",
        code: "+94",
        timezone: "UTC+05:30",
        flag: "https://flagcdn.com/lk.svg"
      },
      {
        name: "Nepal",
        code: "+977",
        timezone: "UTC+05:45",
        flag: "https://flagcdn.com/np.svg"
      },
      {
        name: "Afghanistan",
        code: "+93",
        timezone: "UTC+04:30",
        flag: "https://flagcdn.com/af.svg"
      },
      {
        name: "Iran",
        code: "+98",
        timezone: "UTC+03:30",
        flag: "https://flagcdn.com/ir.svg"
      },
      {
        name: "Turkey",
        code: "+90",
        timezone: "UTC+03:00",
        flag: "https://flagcdn.com/tr.svg"
      },
      {
        name: "Saudi Arabia",
        code: "+966",
        timezone: "UTC+03:00",
        flag: "https://flagcdn.com/sa.svg"
      },
      {
        name: "United Arab Emirates",
        code: "+971",
        timezone: "UTC+04:00",
        flag: "https://flagcdn.com/ae.svg"
      },
      {
        name: "Israel",
        code: "+972",
        timezone: "UTC+02:00",
        flag: "https://flagcdn.com/il.svg"
      },
      {
        name: "Egypt",
        code: "+20",
        timezone: "UTC+02:00",
        flag: "https://flagcdn.com/eg.svg"
      },
      {
        name: "Nigeria",
        code: "+234",
        timezone: "UTC+01:00",
        flag: "https://flagcdn.com/ng.svg"
      },
      {
        name: "Kenya",
        code: "+254",
        timezone: "UTC+03:00",
        flag: "https://flagcdn.com/ke.svg"
      },
      {
        name: "Argentina",
        code: "+54",
        timezone: "UTC−03:00",
        flag: "https://flagcdn.com/ar.svg"
      }
    ];

    // Format for dropdown list
    function formatCountry(country) {
      if (!country.id) return country.text; // For placeholder
      const data = countries.find(c => c.name === country.text);
      if (!data) return country.text;

      return $(`<span><img class="flag-img" src="${data.flag}"/> ${data.name} (${data.code})</span>`);
    }

    // Format for selected item (simplified to avoid rendering issues)
    function formatCountrySelection(country) {
      if (!country.id) return country.text;
      const data = countries.find(c => c.name === country.text);
      if (!data) return country.text;

      return $(`<span><img class="flag-img" src="${data.flag}"/> ${data.name}</span>`);
    }

    // Add User Modal


    $('#addUserModal #addcountry').select2({
      dropdownParent: $('#addUserModal'),
      data: countries.map(c => ({
        id: c.name,
        text: c.name
      })), // load from array
      templateResult: formatCountry,
      templateSelection: formatCountrySelection,
      placeholder: "--Select country--",
      allowClear: true
    });


    // Edit User Modal
    $('#editModal #editcountry').select2({
      dropdownParent: $('#editModal'),
      data: countries.map(c => ({
        id: c.name,
        text: c.name
      })), // load from array
      templateResult: formatCountry,
      templateSelection: formatCountrySelection,
      placeholder: "--Select country--",
      allowClear: true
    });

    $('#addcountry').on('change', function() {
      const selectedName = $(this).val();
      const country = countries.find(c => c.name === selectedName);
      if (country) {
        $('#addtimezone').val(country.timezone);
        $('#addcountrycode').val(country.code);


      } else {
        $('#addtimezone').val('');
        $('#addcountrycode').val('');

      }
    });

    $('#editcountry').on('change', function() {
      const selectedName = $(this).val();
      const country = countries.find(c => c.name === selectedName);
      if (country) {
        $('#edittimezone').val(country.timezone);
        $('#editcountrycode').val(country.code);


      } else {
        $('#edittimezone').val('');
        $('#editcountrycode').val('');

      }
    });
  </script>

  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const editButtons = document.querySelectorAll(".editBtn");

      editButtons.forEach(btn => {
        btn.addEventListener("click", function() {
          // Normal fields
          document.getElementById("editfirstName").value = this.dataset.firstname;
          document.getElementById("editlastName").value = this.dataset.lastname;
          document.getElementById("editemail").value = this.dataset.email;
          document.getElementById("editmobileNo").value = this.dataset.mobile;
          document.getElementById("edituserId").value = this.dataset.userid;
          document.getElementById("editpassword").value = this.dataset.password;
          document.getElementById("edittimezone").value = this.dataset.timezone;
          document.getElementById("editgroupId").value = this.dataset.groupid;
          document.getElementById("editpbxNo").value = this.dataset.pbx;
          document.getElementById("editcompanyName").value = this.dataset.company;
          document.getElementById("editdesignation").value = this.dataset.designation;
          document.getElementById("editaddress").value = this.dataset.address;
          document.getElementById("editcity").value = this.dataset.city;
          document.getElementById("editstate").value = this.dataset.state;
          document.getElementById("editareaCode").value = this.dataset.area;
          document.getElementById("editresidenceNumber").value = this.dataset.residence;
          document.getElementById("editextensionNo").value = this.dataset.ext;
          document.getElementById("editprofile").value = this.dataset.profile;
          document.getElementById("editipPhoneNo").value = this.dataset.ipphone;
          document.getElementById("editmobion").value = this.dataset.mobion;
          document.getElementById("editmobiweb").value = this.dataset.mobiweb;

          // ✅ Country (Select2 fix)
          $('#editcountry').val(this.dataset.country).trigger("change");

          // Hidden ID
          if (!document.getElementById("editId")) {
            let hiddenId = document.createElement("input");
            hiddenId.type = "hidden";
            hiddenId.id = "editId";
            hiddenId.name = "editId";
            document.getElementById("editForm").appendChild(hiddenId);
          }
          document.getElementById("editId").value = this.dataset.id;
        });
      });
    });


    document.getElementById("saveEdit").addEventListener("click", function() {
      const form = document.getElementById("editForm");
      if (!form.checkValidity()) {
        form.reportValidity(); // Show native HTML5 errors
        return;
      }

      const formData = new FormData(form);
      // Add disabled inputs manually
      $("#editForm :input:disabled[name]").each(function() {
        formData.append(this.name, $(this).val());
      });

      console.log(...formData); // Debug

      fetch("update_userquery.php", {
          method: "POST",
          body: formData
        })
        .then(res => res.text())
        .then(data => {
          alert(data); // Show response from server
          location.reload(); // Reload table after update
        })
        .catch(err => console.error(err));
    });
  </script>

  <script>
    document.getElementById("cancelAddUser").addEventListener("click", function() {
      location.reload();
    });

    document.getElementById("closeaddUser").addEventListener("click", function() {
      location.reload();
    });
  </script>



  <script>
    const ipPhoneInput = document.getElementById('addipPhoneNo');
    const mobionInput = document.getElementById('addmobion');
    const mobiwebInput = document.getElementById('addmobiweb');
    const pbxnoInput = document.getElementById('addpbxNo');

    const allInputs = [ipPhoneInput, mobionInput, mobiwebInput, pbxnoInput];

    // Validate for exact duplicates only
    function validateUniqueValues(currentInput) {
      const currentValue = currentInput.value.trim();
      if (currentValue === '') return; // skip empty entries

      allInputs.forEach(input => {
        if (input !== currentInput && input.value.trim() === currentValue) {
          // Identify which field already has the value
          let fieldName = '';
          switch (input.name) {
            case 'addipPhoneNo':
              fieldName = 'IP Phone No';
              break;
            case 'addmobion':
              fieldName = 'Mobion';
              break;
            case 'addmobiweb':
              fieldName = 'Mobiweb';
              break;
            case 'addpbxNo':
              fieldName = 'PBX No';
              break;
          }
          alert(`Value "${currentValue}" has already been entered in the ${fieldName} field.`);
          currentInput.value = ''; // clear duplicate
        }
      });
    }

    // Validate only after the user leaves the input
    allInputs.forEach(input => {
      input.addEventListener('blur', () => validateUniqueValues(input));
    });
  </script>

  <script>
    // robust duplicate-check for the "edit" fields (alerts on blur, exact match only)
    document.addEventListener('DOMContentLoaded', () => {
      const ids = ['editipPhoneNo', 'editmobion', 'editmobiweb', 'editpbxNo'];
      // grab elements, ignore missing ones
      const inputs = ids.map(id => document.getElementById(id)).filter(Boolean);

      if (inputs.length === 0) {
        console.warn('Duplicate-check: no edit inputs found (check IDs)');
        return;
      }

      // friendly label resolver (priority: data-label -> placeholder -> id map -> name -> id)
      const idLabelMap = {
        editipPhoneNo: 'IP Phone No',
        editmobion: 'Mobion',
        editmobiweb: 'Mobiweb',
        editpbxNo: 'PBX No'
      };
      const getLabel = input =>
        (input.dataset && input.dataset.label) ||
        input.placeholder ||
        idLabelMap[input.id] ||
        input.name ||
        input.id;

      // normalized exact compare (trimmed). If you want case-insensitive for text, add .toLowerCase()
      const normalize = v => (v || '').trim();

      function validateDuplicate(currentInput) {
        const cur = normalize(currentInput.value);
        if (cur === '') return; // ignore empty values

        for (const other of inputs) {
          if (other === currentInput) continue;
          if (normalize(other.value) === cur) {
            const label = getLabel(other);
            alert(`Value "${cur}" has already been entered in the ${label} field.`);
            // clear and return focus so user can re-enter
            currentInput.value = '';
            // refocus asynchronously to avoid focus-blur loop
            setTimeout(() => currentInput.focus(), 0);
            return;
          }
        }
      }

      // attach once for existing inputs
      inputs.forEach(input => {
        // use 'blur' so alert appears after user finishes typing and leaves field
        input.addEventListener('blur', (e) => validateDuplicate(e.target));
      });

      // If your edit form is inside a Bootstrap modal (or the inputs are created dynamically),
      // re-attach on modal show to ensure listeners are present.
      // (This part is safe even if you don't use modals.)
      document.querySelectorAll('.modal').forEach(modalEl => {
        modalEl.addEventListener('shown.bs.modal', () => {
          ids.forEach(id => {
            const el = document.getElementById(id);
            if (el && !el.dataset._dupAttached) {
              el.addEventListener('blur', (e) => validateDuplicate(e.target));
              el.dataset._dupAttached = '1';
            }
          });
        });
      });

      // Optional: quick debug helper, uncomment to log comparisons
      // window._debugDuplicateCheck = () => inputs.forEach(i => console.log(i.id, i.value));
    });
  </script>


</body>

</html>