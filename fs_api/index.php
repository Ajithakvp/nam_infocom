<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Web Service</title>
    <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />

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

   <script src="apis.js"></script>
<script>
  let currentMethod = "ALL";

  function renderGrid(list) {
    const grid = document.getElementById('grid');
    const info = document.getElementById('filterInfo');
    grid.innerHTML = "";
    list.forEach(api => {
      const card = document.createElement('div');
      card.className = 'card';
      let paramsHTML = api.params?.length 
        ? `<p><strong>Params:</strong> ${api.params.join(', ')}</p>` 
        : '';
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

</body>

</html>