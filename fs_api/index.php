<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Web Service</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

    <!-- Bootstrap 5 CSS -->

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg1: #0f1724;
            /* dark navy */
            --bg2: #0b3b6f;

        }

        body {
            margin: 0;
            font-family: 'Poppins', sans-serif;
            background: radial-gradient(1200px 600px at 10% 10%, rgba(255, 255, 255, 0.03), transparent 8%),
                radial-gradient(900px 400px at 90% 90%, rgba(255, 255, 255, 0.02), transparent 6%),
                linear-gradient(160deg, var(--bg1), var(--bg2));
            color: #fff;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        /* Header */
        header {
            display: flex;
            align-items: center;
            gap: 25px;
            padding: 25px 35px;
            background: rgba(255, 255, 255, 0.06);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(12px);
        }

        /* Logo */
        header .logo {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #ffd54a, #ff9a76);
            border-radius: 50%;
            font-weight: bold;
            color: #222;
            font-size: 32px;
            overflow: hidden;
            flex-shrink: 0;
            box-shadow: 0 6px 18px rgba(0, 0, 0, 0.4);
            transition: transform 0.3s ease;
        }

        header .logo img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        header .logo:hover {
            transform: scale(1.1);
        }

        /* Header Text */
        header .header-text {
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        header .header-text h1 {
            margin: 0;
            font-size: 32px;
        }

        header .header-text p {
            margin: 5px 0 0 0;
            font-size: 16px;
            opacity: 0.8;
            max-width: 650px;
        }

        /* Topbar */
        .topbar {
            padding: 15px 30px;
            background: rgba(255, 255, 255, 0.05);
            backdrop-filter: blur(10px);
        }

        .filters {
            display: flex;
            gap: 10px;
            margin-bottom: 10px;
            flex-wrap: wrap;
        }

        .filter-btn {
            padding: 8px 20px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            transition: all 0.3s;
        }

        .filter-btn.active {
            background: linear-gradient(90deg, #ffd54a, #ff9a76);
            color: #222;
        }

        .filter-info {
            font-size: 13px;
            opacity: 0.8;
            margin-top: 5px;
        }

        .search-box {
            margin-top: 10px;
        }

        .search-box input {
            width: 100%;
            padding: 12px 12px;
            border-radius: 10px;
            border: none;
            background: rgba(255, 255, 255, 0.12);
            color: #fff;
            font-size: 14px;
            outline: none;
            transition: background 0.3s;
        }

        .search-box input:focus {
            background: rgba(255, 255, 255, 0.2);
        }

        main {
            flex: 1;
            padding: 25px 35px;
        }

        .grid {
            display: grid;
            gap: 20px;
            grid-template-columns: repeat(auto-fit, minmax(320px, 1fr));
        }

        .card {
            background: rgba(255, 255, 255, 0.08);
            padding: 20px;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.5);
        }

        .card h3 {
            margin: 0;
            font-size: 20px;
        }

        .card p {
            margin: 10px 0;
            font-size: 14px;
            color: rgba(255, 255, 255, 0.8);
        }

        .badge {
            display: inline-block;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 600;
            margin: 8px 0;
            text-transform: uppercase;
        }

        .GET {
            background: rgba(77, 182, 255, 0.2);
            color: #4db6ff;
        }

        .POST {
            background: rgba(46, 204, 113, 0.2);
            color: #2ecc71;
        }

        .PUT {
            background: rgba(255, 215, 0, 0.2);
            color: #ffd700;
        }

        .DELETE {
            background: rgba(255, 107, 107, 0.2);
            color: #ff6b6b;
        }

        .actions {
            margin-top: 12px;
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        .btn {
            padding: 8px 14px;
            border-radius: 8px;
            font-size: 13px;
            cursor: pointer;
            border: none;
            transition: all 0.3s;
        }

        .btn.primary {
            background: linear-gradient(90deg, #ffd54a, #ff9a76);
            color: #222;
            font-weight: bold;
        }

        .btn.primary:hover {
            opacity: 0.9;
        }

        .btn.secondary {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
        }

        .btn.secondary:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Responsive */
        @media (max-width: 768px) {
            header {
                flex-direction: column;
                text-align: center;
                gap: 20px;
            }

            header .header-text h1 {
                font-size: 26px;
            }

            header .header-text p {
                font-size: 14px;
            }

            main {
                padding: 20px;
            }
        }

        @media (max-width: 480px) {
            .search-box input {
                font-size: 13px;
            }

            header .logo {
                width: 100px;
                height: 100px;
                font-size: 28px;
            }
        }



        /* ===== Custom Modal ===== */
        .custom-modal-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.6);
            backdrop-filter: blur(4px);
            z-index: 1050;
            align-items: center;
            justify-content: center;
        }

        .custom-modal {
            background: rgba(15, 23, 36, 0.95);
            border-radius: 12px;
            max-width: 400px;
            width: 90%;
            padding: 20px;
            color: #fff;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.5);
            animation: fadeIn 0.3s ease;
        }

        .custom-modal-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 15px;
            background: linear-gradient(135deg, #5d87ff, #3a4ed5);
            padding: 10px 15px;
            border-radius: 8px 8px 0 0;
        }

        .custom-modal-header h5 {
            margin: 0;
            font-weight: 600;
        }

        .custom-modal-body {
            padding: 15px;
            text-align: center;
        }

        .custom-modal-footer {
            display: flex;
            justify-content: center;
            padding: 10px;
        }

        .close-btn {
            background: none;
            border: none;
            font-size: 20px;
            color: #fff;
            cursor: pointer;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>

<body>
    <header>
        <div class="logo" id="logoContainer">
            <img src="../assets/images/logos/favicon.png" alt="API Logo"
                onerror="this.style.display='none';document.getElementById('logoContainer').textContent='API';">
        </div>
        <div class="header-text">
            <h1> Web Service API</h1>
            <p>Discover and test your service endpoints — dynamic & developer-friendly.</p>
        </div>
        <div style="text-align: right; flex-grow: 1; display: flex; justify-content: flex-end; align-items: center;">
            <button style=" padding: 8px 20px;
            border-radius: 50px;
            border: none;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            background: linear-gradient(90deg, #ffd54a, #ff9a76);
            color: #222;
            transition: all 0.3s;" onclick="openModal();"> ⓘ Version</button>
        </div>
    </header>

    <div class="topbar">
        <div class="search-box">
            <input id="searchInput" type="text" placeholder="Search endpoints, description, tags...">
        </div>
        <br>
        <div class="filters">
            <button class="filter-btn active" data-method="ALL">All</button>
            <button class="filter-btn" data-method="GET">GET</button>
            <button class="filter-btn" data-method="POST">POST</button>
            <button class="filter-btn" data-method="PUT">PUT</button>
            <button class="filter-btn" data-method="DELETE">DELETE</button>
        </div>
        <div class="filter-info" id="filterInfo">Showing 0 endpoints</div>
    </div>

    <main>
        <div class="grid" id="grid"></div>
    </main>

    <div id="aboutModal" class="custom-modal-overlay">
        <div class="custom-modal">
            <div class="custom-modal-header">
                <h5><i class="bi bi-info-circle text-warning me-2"></i> Version <span
                        class="badge bg-light text-primary ms-1" style=" border-radius: 50px; background: white;color:#4db6ff">Latest</span></h5>
                <button class="close-btn" onclick="closeModal()">&times;</button>
            </div>
            <div class="custom-modal-body">
                <h6 class="fw-semibold mb-2">Web Service</h6>
                <p>Application UI <span class="fw-bold">v1.0.2</span></p>
                <small>Released on <span class="fw-semibold">Sep 22, 2025</span></small>
            </div>
            <div class="custom-modal-footer">
                <button class="btn btn-custom btn-sm" onclick="closeModal()">Close</button>
            </div>
        </div>
    </div>

    <script src="apis.js"></script>

    <!-- Core JS (order matters) -->
    <script src="../assets/js/jquery-3.6.0.min.js"></script>
    <!-- Bootstrap JS -->


    <script>
        let currentMethod = "ALL";

        function renderGrid(list) {
            const grid = document.getElementById('grid');
            const info = document.getElementById('filterInfo');
            grid.innerHTML = "";
            list.forEach(api => {
                const card = document.createElement('div');
                card.className = 'card';
                let paramsHTML = api.params?.length ?
                    `<p><strong>Params:</strong> ${api.params.join(', ')}</p>` :
                    '';
                card.innerHTML = `
        <h3>${api.name}</h3>
        <p>${api.desc}</p>
        <div class="badge ${api.method}">${api.method}</div>
        <div class="actions">
          <button class="btn primary" onclick="openAPI('${api.name}')">Open</button>
          <button class="btn secondary" onclick="copyURL('${api.url}')">Copy URL</button>
        </div>`;
                grid.appendChild(card);
            });
            info.textContent = `Showing ${list.length} endpoints`;
        }

        function openAPI(name) {
            window.location.href = `viewer.php?api=${encodeURIComponent(name)}`;
        }

        function copyURL(url) {
            navigator.clipboard.writeText(url);
            alert("Copied URL!");
        }

        function loadAPIs() {
            const q = document.getElementById('searchInput').value.toLowerCase();
            const filtered = apis.filter(api =>
                (currentMethod === "ALL" || api.method === currentMethod) &&
                (api.name.toLowerCase().includes(q) || api.desc.toLowerCase().includes(q))
            );
            renderGrid(filtered);
        }

        // Filters
        document.querySelectorAll('.filter-btn').forEach(btn => {
            btn.addEventListener('click', () => {
                document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
                btn.classList.add('active');
                currentMethod = btn.dataset.method;
                loadAPIs();
            });
        });

        document.getElementById('searchInput').addEventListener('input', loadAPIs);

        // Wait for apis.js to finish loading API definitions
        document.addEventListener('apisReady', loadAPIs);
    </script>


    <script>
        function openModal() {
            document.getElementById("aboutModal").style.display = "flex";
        }

        function closeModal() {
            document.getElementById("aboutModal").style.display = "none";
        }

        // Close when clicking outside modal
        window.onclick = function(event) {
            const modal = document.getElementById("aboutModal");
            if (event.target === modal) {
                closeModal();
            }
        }
    </script>

</body>

</html>