<?php include("chksession.php");
?>
<aside class="left-sidebar">
  <!-- Sidebar scroll-->
  <div>
    <div class="brand-logo d-flex align-items-center justify-content-between">
      <a href="add_user.php" class="text-nowrap logo-img">
        <img src="assets/images/logos/dark-logo1.svg" width="180" alt="Logo" />
      </a>
      <div class="close-btn d-xl-none d-block sidebartoggler cursor-pointer" id="sidebarCollapse">
        <i class="ti ti-x fs-8"></i>
      </div>
    </div>

    <!-- Search -->
    <label class="search" title="Search">
      <i class='ti ti-search'></i>
      <input type="text" id="searchInput" placeholder="Search..." />
    </label>

    <!-- Sidebar navigation-->
    <nav class="sidebar-nav scroll-sidebar" data-simplebar="">
      <ul id="sidebarnav">
        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">Menu</span>
        </li>

        <li class="sidebar-item">
          <a class="sidebar-link" href="add_user.php">
            <span><i class="ti ti-user-plus"></i></span>
            <span class="hide-menu">Add User</span>
          </a>
        </li>

        <?php if ($_SESSION['type'] == 'admin') { ?>

          <li class="sidebar-item">
            <a class="sidebar-link" href="subscribes_id.php">
              <span><i class="ti ti-id-badge-2"></i></span>
              <span class="hide-menu">Subscribes ID</span>
            </a>
          </li>

        <?php } ?>

        <?php if ($_SESSION['type'] == 'admin') { ?>

          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">SETTINGS</span>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link" href="ip_settings.php">
              <span><i class="ti ti-world"></i></span>
              <span class="hide-menu">IP Settings</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="port_settings.php">
              <span><i class="ti ti-plug-connected"></i></span>
              <span class="hide-menu">Port Settings</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="layout_settings.php">
              <span><i class="ti ti-layout"></i></span>
              <span class="hide-menu">Layout Settings</span>
            </a>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="group_settings.php">
              <span><i class="ti ti-users"></i></span>
              <span class="hide-menu">Group Settings</span>
            </a>
          </li>

        <?php } ?>

        <li class="nav-small-cap">
          <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
          <span class="hide-menu">REPORTS</span>
        </li>
        <li class="sidebar-item">
          <a class="sidebar-link" href="reports.php">
            <span><i class="ti ti-report-analytics"></i></span>
            <span class="hide-menu">Reports</span>
          </a>
        </li>

        <?php if ($_SESSION['type'] == 'admin') { ?>

          <li class="nav-small-cap">
            <i class="ti ti-dots nav-small-cap-icon fs-4"></i>
            <span class="hide-menu">DATA BASE</span>
          </li>
          <li class="sidebar-item">
            <a class="sidebar-link" href="db_creation.php">
              <span><i class="ti ti-database"></i></span>
              <span class="hide-menu">DB Creation</span>
            </a>
          </li>
      </ul>

    <?php } ?>

    <!-- Logout -->
    <div class="unlimited-access hide-menu position-relative mb-7 mt-5 rounded">
      <div class="message-body">
        <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block"><i
            class="ti ti-logout"></i> Logout</a>
      </div>
    </div>

    <div class="unlimited-access hide-menu position-relative mb-7 mt-5 rounded">
      <div class="message-body">

      </div>
    </div>

    </nav>
    <!-- End Sidebar navigation -->
  </div>
  <!-- End Sidebar scroll-->
</aside>

<style>
  /* search */
  :root {
    --card: #ffffff;
    --text: #1f2937;
    --muted: #6b7280;
    --primary: #6b70ff;
    --shadow: 0 10px 30px rgba(31, 41, 55, .08);

  }

  .search {
    display: flex;
    align-items: center;
    gap: 10px;
    padding: 12px 16px;
    border: 1px solid var(--primary);
    /* 👈 bold border with theme primary color */
    border-radius: 14px;
    background: var(--card);
    margin: 12px 14px 16px;
    box-shadow: var(--shadow, none);
  }

  .search i {
    font-size: 18px;
    color: var(--muted);
  }

  .search input {
    border: none;
    outline: none;
    background: transparent;
    width: 100%;
    color: var(--text);
    font-size: 15px;
    font: inherit;
  }
</style>

<script>
  // Search filter with section header handling
  searchInput.addEventListener('input', () => {
    const filter = searchInput.value.toLowerCase();

    document.querySelectorAll('#sidebarnav > li').forEach(li => {
      if (li.classList.contains('sidebar-item')) {
        const text = li.innerText.toLowerCase();
        li.style.display = text.includes(filter) ? 'block' : 'none';
      }
    });

    // Hide section headers if all their items are hidden
    document.querySelectorAll('#sidebarnav > .nav-small-cap').forEach(header => {
      let next = header.nextElementSibling;
      let hasVisible = false;

      while (next && !next.classList.contains('nav-small-cap')) {
        if (next.classList.contains('sidebar-item') && next.style.display !== 'none') {
          hasVisible = true;
          break;
        }
        next = next.nextElementSibling;
      }

      header.style.display = hasVisible ? 'block' : 'none';
    });
  });
</script>