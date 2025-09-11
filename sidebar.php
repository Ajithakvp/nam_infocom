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
    <!-- <label class="search" title="Search">
      <i class='ti ti-search'></i>
      <input type="text" id="searchInput" placeholder="Search..." />
    </label> -->

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
              <span class="hide-menu">Subscriber ID</span>
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
        <?php } ?>
      </ul>

      <!-- Logout -->
      <div class="unlimited-access hide-menu position-relative mb-7 mt-5 rounded">
        <div class="message-body">
          <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">
            <i class="ti ti-logout"></i> Logout
          </a>
        </div>
      </div>
      <div class="unlimited-access hide-menu position-relative mb-7 mt-5 rounded">
        <div class="message-body">
          <!-- <a href="logout.php" class="btn btn-outline-primary mx-3 mt-2 d-block">
            <i class="ti ti-logout"></i> Logout
          </a> -->
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

  /* Active state */
  .sidebar-link.active {
    color: var(--primary);
    font-weight: 600;
  }
</style>
<script>
  window.addEventListener('load', () => {
    const links = Array.from(document.querySelectorAll('#sidebarnav a.sidebar-link'));
    links.forEach(a => a.classList.remove('active'));
    document.querySelectorAll('#sidebarnav li').forEach(li => li.classList.remove('selected'));

    const normalize = s => (s || '').toLowerCase().replace(/^\/+|\/+$/g, '');
    const curPath = normalize(window.location.pathname);
    const curFile = curPath.split('/').filter(Boolean).pop() || '';

    let bestLink = null;
    let bestScore = -1;

    links.forEach(link => {
      const rawHref = link.getAttribute('href');
      if (!rawHref || rawHref.startsWith('#') || rawHref.startsWith('javascript:')) return;

      let url;
      try {
        url = new URL(rawHref, window.location.href);
      } catch (e) {
        return;
      }

      const hrefPath = normalize(url.pathname);
      const hrefFile = hrefPath.split('/').filter(Boolean).pop() || '';

      let score = -1;
      if (hrefFile && hrefFile === curFile) score = 100; // exact file match
      else if (hrefPath && hrefPath === curPath) score = 90; // exact path match
      else if ((url.origin + url.pathname) === window.location.href.split('?')[0]) score = 95;
      else if (hrefFile && curPath.includes(hrefFile)) score = 40; // less aggressive partial match

      if (score > 0) score += Math.min(20, hrefPath.length / 5);
      if (score > bestScore) {
        bestScore = score;
        bestLink = link;
      }
    });

    // Only fall back if nothing scored at all
    if (!bestLink && curFile === '') {
      bestLink = document.querySelector('#sidebarnav a[href="add_user.php"], #sidebarnav a[href="/add_user.php"]');
    }

    if (bestLink) {
      bestLink.classList.add('active');
      const li = bestLink.closest('li');
      if (li) li.classList.add('selected');
      setTimeout(() => {
        bestLink.scrollIntoView({
          behavior: 'smooth',
          block: 'center'
        });
      }, 150);
    }
  });
</script>