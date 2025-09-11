<?php
include("chksession.php");

?><header class="app-header">
  <nav class="navbar navbar-expand-lg navbar-light">
    <ul class="navbar-nav">
      <li class="nav-item d-block d-xl-none">
        <a class="nav-link sidebartoggler nav-icon-hover" id="headerCollapse" href="javascript:void(0)">
          <i class="ti ti-menu-2"></i>
        </a>
      </li>
      <!-- <li class="nav-item">
        <a class="nav-link nav-icon-hover" href="javascript:void(0)">
          <i class="ti ti-bell-ringing"></i>
          <div class="notification bg-primary rounded-circle"></div>
        </a>
      </li> -->
    </ul>
    <div class="navbar-collapse justify-content-end px-0" id="navbarNav">
      <ul class="navbar-nav flex-row ms-auto align-items-center justify-content-end">
        <span style="font-family: Arial, sans-serif; font-weight: bold;color:#5d87ff">
          <?php echo $_SESSION['username']; ?>
        </span>
        <li class="nav-item dropdown">
          <a class="nav-link nav-icon-hover" href="javascript:void(0)" id="drop2" data-bs-toggle="dropdown"
            aria-expanded="false">
            <img src="assets/images/profile/user.png" alt="" width="35" height="35" class="rounded-circle">
          </a>
          <div class="dropdown-menu dropdown-menu-end dropdown-menu-animate-up" aria-labelledby="drop2">
            <div class="message-body">
              <div class="d-flex align-items-center gap-2 dropdown-item" onclick="viewaboutdialog();">
                <i class="ti ti-info-circle fs-6"></i>
                <p class="mb-0 fs-3">About</p>
              </div>
              <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">Logout</a>
            </div>
          </div>
        </li>
      </ul>
    </div>
  </nav>
</header>

<script>
  function viewaboutdialog() {
    let deleteModal = new bootstrap.Modal(document.getElementById('viewabout'));
    deleteModal.show();
  }
</script>

<!-- About / Version Modal -->
<div class="modal fade" id="viewabout" tabindex="-1" aria-labelledby="viewaboutlabel" aria-hidden="true" data-bs-backdrop="static" data-bs-keyboard="false">
  <div class="modal-dialog modal-dialog-centered">
    <div class="modal-content shadow-lg border-0 rounded-4">

      <!-- Modal Header -->
      <div class="modal-header text-white"
        style="background: linear-gradient(135deg, #5d87ff, #3a4ed5); border-top-left-radius: 0.5rem; border-top-right-radius: 0.5rem;">
        <i class="ti ti-info-circle fs-6 text-warning"></i> &nbsp;&nbsp;
        <h5 class="modal-title fw-bold" style="color:aliceblue">
          Version <span class="badge bg-light text-primary ms-2">Latest</span>
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>

      <!-- Modal Body -->
      <div class="modal-body text-center p-4">
        <h6 class="fw-semibold text-dark mb-2">Configuration Settings</h6>
        <p class="text-muted mb-1">Application UI <span class="fw-bold">v1.0.2</span></p>
        <small class="text-secondary">Released on <span class="fw-semibold">Sep 11, 2025</span></small>
      </div>

      <!-- Modal Footer -->
      <div class="modal-footer justify-content-center border-0 pb-4">
        <button type="button" class="btn btn-sm px-4 rounded-pill"
          style="background: #5d87ff; color: #fff;" data-bs-dismiss="modal">
          Close
        </button>
      </div>
    </div>
  </div>
</div>