
<!DOCTYPE html>
<html lang="en">

<head>

    
    <style>
        :root {
            --bg: #eef2f7;
            --card: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --primary: #6b70ff;
            --primary-weak: #f3f4ff;
            --border: #e5e7eb;
            --shadow: 0 10px 30px rgba(31, 41, 55, .08);
            --radius: 18px;
            --sb-w: 280px;
            --sb-w-min: 86px;
        }

        [data-theme="dark"] {
            --bg: #0f1115;
            --card: #151922;
            --text: #e7eaf0;
            --muted: #9aa3b2;
            --primary: #7d83ff;
            --primary-weak: #1e2230;
            --border: #252b36;
            --shadow: 0 10px 30px rgba(0, 0, 0, .45);
        }

        * {
            box-sizing: border-box
        }

        html,
        body {
            height: 100%
        }

        body {
            margin: 0;
            background: var(--bg);
            color: var(--text);
            font: 500 15px/1.45 Inter, ui-sans-serif, system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            display: flex;
        }

        /* ===== Sidebar ===== */
        .sidebar {
            position: relative;
            width: var(--sb-w);
            min-width: var(--sb-w);
            height: 100dvh;
            background: var(--card);
            box-shadow: var(--shadow);
            border-right: 1px solid var(--border);
            transition: width .28s ease;
            display: flex;
            flex-direction: column;
        }

        .sidebar.is-collapsed {
            width: var(--sb-w-min);
            min-width: var(--sb-w-min);
        }

        /* header / brand */
        .brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px;
            border-radius: 12px;
        }

        .brand-badge {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            display: grid;
            place-items: center;
            background: var(--primary);
            color: #fff;
            font-weight: 800;
        }

        .brand-txt {
            white-space: nowrap
        }

        .brand-txt b {
            display: block;
            font-size: 15px
        }

        .brand-txt small {
            color: var(--muted);
            font-weight: 600
        }

        /* edge toggle pill  */
        .edge-toggle {
            position: absolute;
            top: 18px;
            right: -14px;
            width: 28px;
            height: 28px;
            border-radius: 999px;
            background: var(--primary);
            color: #fff;
            display: grid;
            place-items: center;
            box-shadow: 0 6px 18px rgba(0, 0, 0, .25);
            cursor: pointer;
            border: none;
            transition: transform .28s ease;
        }

        .sidebar.is-collapsed .edge-toggle {
            transform: rotate(180deg)
        }

        /* search */
        .search {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 10px 12px;
            border: 1px solid var(--border);
            border-radius: 12px;
            background: var(--card);
            margin: 0 14px 10px;
        }

        .search input {
            border: 0;
            outline: 0;
            background: transparent;
            width: 100%;
            color: var(--text);
            font: inherit;
        }

        .sidebar.is-collapsed .search input {
            display: none
        }

        /* nav wrapper (scrollable area) */
        .nav-wrapper {
            flex: 1;
            overflow-y: auto;
            padding: 0 14px;
        }

        .nav {
            display: flex;
            flex-direction: column;
            gap: 6px;
            margin: 6px 0;
        }

        .nav a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 12px;
            color: var(--text);
            text-decoration: none;
            transition: background .2s, color .2s;
            position: relative;
        }

        .nav a i {
            font-size: 20px;
            width: 28px;
            text-align: center;
            color: var(--muted);
        }

        .nav a .label {
            white-space: nowrap;
            overflow: hidden
        }

        .nav a:hover {
            background: var(--primary-weak)
        }

        .nav a.active {
            background: var(--primary);
            color: #fff
        }

        .nav a.active i {
            color: #fff
        }

        .section-split {
            height: 1px;
            background: var(--border);
            margin: 10px 0
        }

        /* bottom area */
        .bottom {
            padding: 0 14px 14px;
            display: flex;
            flex-direction: column;
            gap: 6px;
        }

        /* switch */
        .mode {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 12px;
            border-radius: 12px;
        }

        .mode:hover {
            background: var(--primary-weak)
        }

        .switch {
            --w: 44px;
            --h: 24px;
            width: var(--w);
            height: var(--h);
            background: #cfd6ff;
            border-radius: 999px;
            position: relative;
            transition: .2s;
        }

        .switch::after {
            content: "";
            position: absolute;
            top: 2px;
            left: 2px;
            width: var(--h);
            height: calc(var(--h) - 4px);
            background: #fff;
            border-radius: 999px;
            transition: transform .2s;
        }

        [data-theme="dark"] .switch {
            background: #5e67ff
        }

        [data-theme="dark"] .switch::after {
            transform: translateX(20px)
        }

        /* collapsed : hide labels, keep icons */
        .sidebar.is-collapsed .brand-txt,
        .sidebar.is-collapsed .label,
        .sidebar.is-collapsed .mode .label {
            display: none;
        }

        /* ===== Content area (demo) ===== */
        .content {
            flex: 1;
            padding: 28px;
            width: 100%;
        }

        .card-demo {
            background: var(--card);
            border: 1px solid var(--border);
            border-radius: var(--radius);
            padding: 28px;
            box-shadow: var(--shadow);
        }

        /* Responsive: mobile drawer style */
        @media (max-width: 760px) {
            .sidebar {
                position: fixed;
                left: 0;
                top: 0;
                z-index: 30
            }

            .content {
                padding: 20px
            }

            body.drawer-open::before {
                content: "";
                position: fixed;
                inset: 0;
                background: rgba(0, 0, 0, .35)
            }
        }
    </style>
</head>

<body data-theme="light">

    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
        <button class="edge-toggle" id="toggleBtn" aria-label="Collapse sidebar">
            <i class='bx bx-chevron-right'></i>
        </button>

        <div class="brand">
            <div class="brand-badge">CL</div>
            <div class="brand-txt">
                <b>Codinglab</b>
                <small>web developer</small>
            </div>
        </div>

        <label class="search" title="Search">
            <i class='bx bx-search'></i>
            <input type="text" id="searchInput" placeholder="Search..." />
        </label>


            <div class="mode" id="modeBtn" role="button" aria-label="Toggle dark mode">
                <span class="label">Dark Mode</span>
                <span class="switch" id="switchKnob"></span>
            </div>
       
    </aside>


    <script>
        const body = document.body;
        const sidebar = document.getElementById('sidebar');
        const toggleBtn = document.getElementById('toggleBtn');
        const modeBtn = document.getElementById('modeBtn');
        const searchInput = document.getElementById('searchInput');

        // Sidebar collapse
        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('is-collapsed');
            body.classList.toggle('drawer-open',
                !sidebar.classList.contains('is-collapsed') && window.innerWidth < 760
            );
        });

        // Active item
        document.querySelectorAll('.nav a').forEach(a => {
            a.addEventListener('click', (e) => {
                document.querySelectorAll('.nav a').forEach(x => x.classList.remove('active'));
                a.classList.add('active');
                e.preventDefault();
            });
        });

        // Search filter
        searchInput.addEventListener('input', () => {
            const filter = searchInput.value.toLowerCase();
            document.querySelectorAll('#navMenu a').forEach(link => {
                const text = link.innerText.toLowerCase();
                link.style.display = text.includes(filter) ? 'flex' : 'none';
            });
        });

        // Theme toggle with persistence
        const setTheme = t => {
            document.body.setAttribute('data-theme', t);
            localStorage.setItem('pref-theme', t);
        };
        setTheme(localStorage.getItem('pref-theme') || 'light');
        modeBtn.addEventListener('click', () => {
            const next = document.body.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
            setTheme(next);
        });
    </script>
</body>

</html>   this is not working