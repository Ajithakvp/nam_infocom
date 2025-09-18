<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width,initial-scale=1" />
    <title>API Service</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --bg1: #0f1724;
            /* dark navy */
            --bg2: #0b3b6f;
            /* bluish */
            --accent: #ffd54a;
            /* yellow */
            --glass: rgba(255, 255, 255, 0.06);
            --glass-strong: rgba(255, 255, 255, 0.10);
            --muted: rgba(255, 255, 255, 0.75);
            --success: #2ecc71;
            --danger: #ff6b6b;
            --info: #4db6ff;
            --card-radius: 14px;
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
            font-family: 'Poppins', system-ui, -apple-system, Segoe UI, Roboto, Helvetica, Arial;
            background: radial-gradient(1200px 600px at 10% 10%, rgba(255, 255, 255, 0.03), transparent 8%),
                radial-gradient(900px 400px at 90% 90%, rgba(255, 255, 255, 0.02), transparent 6%),
                linear-gradient(160deg, var(--bg1), var(--bg2));
            color: #fff;
            -webkit-font-smoothing: antialiased;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }

        /* animated blobs (decorative) */
        .blob {
            position: fixed;
            pointer-events: none;
            z-index: 0;
            filter: blur(30px);
            opacity: 0.18;
        }

        .blob.a {
            width: 420px;
            height: 420px;
            left: -80px;
            top: -60px;
            background: linear-gradient(45deg, #ffd54a, #ff9a76);
            border-radius: 50%;
        }

        .blob.b {
            width: 420px;
            height: 420px;
            right: -100px;
            bottom: -80px;
            background: linear-gradient(45deg, #4db6ff, #7fc7ff);
            border-radius: 50%;
        }

        .blob.c {
            width: 260px;
            height: 260px;
            left: 20%;
            bottom: 5%;
            background: linear-gradient(45deg, #9b8cff, #3fb0ff);
            border-radius: 50%;
            opacity: 0.12;
            filter: blur(20px);
        }

        header {
            position: relative;
            z-index: 3;
            padding: 28px 24px;
            display: flex;
            gap: 20px;
            align-items: center;
            justify-content: space-between;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.02), rgba(255, 255, 255, 0));
            border-bottom: 1px solid rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(6px);
        }

        .brand {
            display: flex;
            gap: 16px;
            align-items: center;
        }

        .logo {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            background: linear-gradient(135deg, #ffd54a, #ff9a76);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #08212b;
            font-weight: 700;
            font-size: 20px;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.35), inset 0 -6px 12px rgba(255, 255, 255, 0.08);
        }

        .brand h1 {
            font-size: 18px;
            margin: 0;
            letter-spacing: 0.2px;
        }

        .brand p {
            margin: 0;
            font-size: 12px;
            opacity: 0.86;
            color: var(--muted)
        }

        /* control bar */
        .controls {
            width: 100%;
            max-width: 1400px;
            margin: 20px auto 0;
            padding: 22px;
            display: grid;
            grid-template-columns: 1fr 340px;
            gap: 18px;
            align-items: start;
            z-index: 2;
        }

        .panel {
            background: linear-gradient(180deg, var(--glass), rgba(255, 255, 255, 0.02));
            border-radius: var(--card-radius);
            padding: 16px;
            box-shadow: 0 10px 30px rgba(2, 6, 23, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.04);
            backdrop-filter: blur(8px);
        }

        /* left - main controls */
        .search-row {
            display: flex;
            gap: 12px;
            align-items: center;
        }

        .search {
            flex: 1;
            display: flex;
            gap: 8px;
            align-items: center;
            background: rgba(0, 0, 0, 0.25);
            padding: 10px 12px;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .search input {
            border: 0;
            outline: none;
            background: transparent;
            color: #fff;
            font-size: 14px;
            width: 100%;
        }

        .small {
            font-size: 13px;
            color: var(--muted);
        }

        .filters {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .chip {
            padding: 8px 12px;
            border-radius: 999px;
            background: rgba(0, 0, 0, 0.22);
            cursor: pointer;
            font-size: 13px;
            border: 1px solid rgba(255, 255, 255, 0.03);
        }

        .chip.active {
            background: linear-gradient(90deg, rgba(255, 255, 255, 0.06), rgba(255, 255, 255, 0.02));
            box-shadow: inset 0 -2px 8px rgba(0, 0, 0, 0.25);
        }

        /* right - data source & upload */
        .side-top {
            display: flex;
            gap: 8px;
            flex-direction: column;
        }

        .source-row {
            display: flex;
            gap: 8px;
        }

        .source-row input[type="text"] {
            flex: 1;
            padding: 10px 12px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.06);
            background: transparent;
            color: #fff;
            outline: none;
        }

        .btn {
            padding: 10px 12px;
            border-radius: 10px;
            border: 0;
            cursor: pointer;
            font-weight: 600;
            background: linear-gradient(90deg, #ffd54a, #ff9a76);
            color: #08212b;
            box-shadow: 0 8px 18px rgba(255, 188, 94, 0.12);
        }

        .btn.secondary {
            background: transparent;
            color: #fff;
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        .info-row {
            display: flex;
            gap: 10px;
            align-items: center;
            margin-top: 12px;
            font-size: 13px;
            color: var(--muted)
        }

        /* grid of cards */
        .grid-wrap {
            width: 100%;
            max-width: 1400px;
            margin: 20px auto 80px;
            padding: 0 20px;
            z-index: 2;
        }

        .grid {
            display: grid;
            gap: 18px;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        }

        .card {
            position: relative;
            overflow: hidden;
            padding: 18px;
            border-radius: 12px;
            background: linear-gradient(180deg, rgba(255, 255, 255, 0.03), rgba(255, 255, 255, 0.01));
            border: 1px solid rgba(255, 255, 255, 0.03);
            box-shadow: 0 8px 30px rgba(2, 6, 23, 0.5);
            transition: transform 220ms cubic-bezier(.2, .9, .3, 1), box-shadow 220ms;
        }

        .card:hover {
            transform: translateY(-6px);
            box-shadow: 0 18px 45px rgba(2, 6, 23, 0.6);
        }

        .top-line {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            gap: 10px;
        }

        .title {
            font-weight: 700;
            font-size: 16px;
            color: #fff;
        }

        .desc {
            margin-top: 8px;
            font-size: 13px;
            color: var(--muted);
            min-height: 40px;
        }

        .url {
            margin-top: 12px;
            padding: 8px 10px;
            background: rgba(255, 255, 255, 0.03);
            border-radius: 8px;
            font-family: monospace;
            font-size: 13px;
            display: flex;
            gap: 10px;
            align-items: center;
            justify-content: space-between;
        }

        .badge {
            font-weight: 700;
            padding: 6px 10px;
            border-radius: 999px;
            font-size: 12px;
            letter-spacing: 0.4px;
        }

        .meth-GET {
            background: rgba(77, 182, 255, 0.12);
            color: var(--info);
            border: 1px solid rgba(77, 182, 255, 0.08);
        }

        .meth-POST {
            background: rgba(46, 204, 113, 0.08);
            color: var(--success);
            border: 1px solid rgba(46, 204, 113, 0.06);
        }

        .meth-DELETE {
            background: rgba(255, 107, 107, 0.08);
            color: var(--danger);
            border: 1px solid rgba(255, 107, 107, 0.06);
        }

        .meth-OTHER {
            background: rgba(255, 213, 74, 0.06);
            color: #ffd54a;
            border: 1px solid rgba(255, 213, 74, 0.06);
        }

        .card-actions {
            display: flex;
            gap: 8px;
            margin-top: 12px;
            flex-wrap: wrap;
        }

        .small-btn {
            padding: 8px 10px;
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.04);
            color: #fff;
            border-radius: 8px;
            cursor: pointer;
            font-size: 13px;
        }

        .small-btn.strong {
            background: linear-gradient(90deg, #ffd54a, #ff9a76);
            color: #08212b;
            border: 0;
            font-weight: 700;
        }

        details {
            margin-top: 12px;
            background: rgba(255, 255, 255, 0.02);
            padding: 10px;
            border-radius: 8px;
            border: 1px solid rgba(255, 255, 255, 0.02);
        }

        pre {
            margin: 0;
            font-size: 13px;
            font-family: ui-monospace, SFMono-Regular, Menlo, Monaco, "Roboto Mono", monospace;
            color: #eaeef6;
            overflow: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            color: var(--muted);
            margin-top: 8px
        }

        table th,
        table td {
            text-align: left;
            padding: 6px 8px;
            border-bottom: 1px dashed rgba(255, 255, 255, 0.02);
        }

        .meta {
            font-size: 12px;
            color: var(--muted);
            margin-top: 8px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        footer {
            text-align: center;
            padding: 18px 14px;
            color: var(--muted);
            font-size: 13px;
            margin-top: auto;
            z-index: 2;
        }

        /* responsiveness */
        @media (max-width:920px) {
            .controls {
                grid-template-columns: 1fr;
                padding: 16px;
                margin-top: 10px;
            }

            header {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
                padding: 18px;
            }

            .brand h1 {
                font-size: 16px
            }
        }
    </style>
</head>

<body>
    <!-- decorative blobs -->
    <div class="blob a" aria-hidden="true"></div>
    <div class="blob b" aria-hidden="true"></div>
    <div class="blob c" aria-hidden="true"></div>

    <header>
        <div class="brand">
            <div class="logo">API</div>
            <div>
                <h1>Service API </h1>
                <p>Discover and test your service endpoints — dynamic & developer-friendly.</p>
            </div>
        </div>

        <!-- <div style="display:flex; gap:10px; align-items:center;">
            <div style="text-align:right; font-size:13px; color:var(--muted)">Dynamic • Upload JSON • Copy cURL</div>
        </div> -->
    </header>

    <div class="controls" role="region" aria-label="controls panel">
        <div class="panel">
            <div class="search-row">
                <div class="search" role="search" aria-label="search endpoints">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" style="opacity:.9">
                        <path d="M21 21l-4.35-4.35" stroke="#fff" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round" />
                        <circle cx="11.5" cy="11.5" r="5.5" stroke="#fff" stroke-width="1.6" opacity="0.9" />
                    </svg>
                    <input id="searchInput" placeholder="Search endpoints, description, tags..." />
                </div>
                <div style="min-width:110px;">
                    <select id="sortSelect" style="padding:10px 12px; border-radius:10px; border:1px solid rgba(255,255,255,0.04); background:transparent; color:#fff;">
                        <option value="name">Sort: Name</option>
                        <option value="method">Sort: Method</option>
                        <option value="new">Sort: Recently loaded</option>
                    </select>
                </div>
            </div>

            <div class="filters" aria-hidden="false" style="margin-top:14px;">
                <div class="chip active" data-method="ALL">All</div>
                <div class="chip" data-method="GET">GET</div>
                <div class="chip" data-method="POST">POST</div>
                <div class="chip" data-method="PUT">PUT</div>
                <div class="chip" data-method="DELETE">DELETE</div>
            </div>

            <div class="meta">
                <div id="countInfo">Showing <strong id="countNum">0</strong> endpoints</div>
                <div style="margin-left:auto; color:var(--muted); font-size:13px" id="sourceInfo">Loaded: built-in</div>
            </div>
        </div>

        <div class="panel side-top" aria-label="data source">
            <div style="display:flex; gap:8px;">
                <input id="sourceUrl" type="text" placeholder="Enter a services JSON URL (optional)" aria-label="services url">
                <button id="loadBtn" class="btn">Load</button>
            </div>

            <div style="display:flex; gap:8px; margin-top:10px;">
                <label class="btn secondary" style="cursor:pointer; display:inline-flex; align-items:center; gap:8px; padding:10px 12px;">
                    Upload JSON
                    <input id="fileInput" type="file" accept="application/json" style="display:none" />
                </label>
                <button id="fetchDefaultBtn" class="btn secondary">Fetch /services.json</button>
            </div>

            <div class="info-row">
                <div>Tip: Your JSON should be an array of objects: <code style="font-family:monospace; font-size:12px; background:rgba(255,255,255,0.02); padding:4px 6px; border-radius:6px;">[{ "name": "...", "method":"GET", "url":"/About", "desc":"..." }]</code></div>
            </div>
        </div>
    </div>

    <main class="grid-wrap" id="main" role="main">
        <div class="grid panel" id="grid"></div>
    </main>

    <footer>© 2025 Service API Explorer — Made for devs. Want Swagger/OpenAPI import? I can add it.</footer>

    <script>
        /* ---------------------------
  SAMPLE fallback endpoints
   - format: { name, method, url, desc, tags:[...], params: [{name,type,desc}], body: {...} }
----------------------------*/
        const SAMPLE = [{
                name: "About",
                method: "GET",
                url: "/About",
                desc: "Service information & description",
                tags: ["meta"]
            },
            {
                name: "Activateaccount",
                method: "GET",
                url: "/Activateaccount",
                desc: "Activate a user account using query token",
                tags: ["auth"]
            },
            {
                name: "Activateaccount_json",
                method: "POST",
                url: "/Activateaccount_json",
                desc: "Activate account with JSON payload",
                tags: ["auth", "json"],
                params: [{
                    name: "token",
                    type: "string",
                    desc: "activation token"
                }],
                body: {
                    token: "abc123"
                }
            },
            {
                name: "AddMessageQueue",
                method: "POST",
                url: "/AddMessageQueue",
                desc: "Add a message to queue",
                tags: ["queue"],
                params: [{
                    name: "queueName",
                    type: "string",
                    desc: "queue identifier"
                }],
                body: {
                    queueName: "main",
                    message: "Hello"
                }
            },
            {
                name: "GetUserInfo",
                method: "GET",
                url: "/nam_infocom/fs_api/fetch_group_setting.php?action=fetch_group",
                desc: "Fetch details for user by id",
                tags: ["user"]
            },
            {
                name: "UpdateProfile",
                method: "PUT",
                url: "/UpdateProfile",
                desc: "Update user profile data",
                tags: ["user", "update"],
                body: {
                    name: "John",
                    email: "john@example.com"
                }
            },
            {
                name: "DeleteAccount",
                method: "DELETE",
                url: "/DeleteAccount?id=123",
                desc: "Delete user account permanently",
                tags: ["danger"],
                params: [{
                    name: "id",
                    type: "int",
                    desc: "user id"
                }]
            }
        ];

        /* state */
        let endpoints = []; // master list
        let filtered = []; // filtered -> render
        let currentMethod = "ALL";

        /* DOM refs */
        const grid = document.getElementById('grid');
        const searchInput = document.getElementById('searchInput');
        const countNum = document.getElementById('countNum');
        const countInfo = document.getElementById('countInfo');
        const sourceInfo = document.getElementById('sourceInfo');
        const loadBtn = document.getElementById('loadBtn');
        const sourceUrl = document.getElementById('sourceUrl');
        const fileInput = document.getElementById('fileInput');
        const fetchDefaultBtn = document.getElementById('fetchDefaultBtn');
        const chipEls = document.querySelectorAll('.chip');
        // const sortSelect = document.getElementById('sortSelect');

        /* util */
        const debounce = (fn, wait = 220) => {
            let t;
            return (...args) => {
                clearTimeout(t);
                t = setTimeout(() => fn(...args), wait);
            };
        };
        const copyToClipboard = async (text) => {
            try {
                await navigator.clipboard.writeText(text);
                toast('Copied to clipboard');
            } catch (e) {
                const ta = document.createElement('textarea');
                ta.value = text;
                document.body.appendChild(ta);
                ta.select();
                document.execCommand('copy');
                ta.remove();
                toast('Copied to clipboard');
            }
        };

        function toast(msg) {
            // minimal toast
            const el = document.createElement('div');
            el.textContent = msg;
            el.style.position = 'fixed';
            el.style.right = '18px';
            el.style.bottom = '18px';
            el.style.padding = '10px 14px';
            el.style.background = 'rgba(0,0,0,0.6)';
            el.style.borderRadius = '8px';
            el.style.color = '#fff';
            el.style.zIndex = 9999;
            document.body.appendChild(el);
            setTimeout(() => el.style.opacity = '0', 1400);
            setTimeout(() => el.remove(), 2000);
        }

        /* load initial (fallback) */
        function loadInitial() {
            endpoints = SAMPLE.slice();
            markLoadedSource('built-in sample');
            applyFiltersAndRender();
        }

        /* mark loaded source */
        function markLoadedSource(name) {
            sourceInfo.textContent = "Loaded: " + name;
        }

        /* fetch JSON from URL */
        async function fetchFromUrl(url) {
            try {
                const res = await fetch(url, {
                    cache: 'no-store'
                });
                if (!res.ok) throw new Error('HTTP ' + res.status);
                const data = await res.json();
                // support either top-level array or { endpoints: []}
                const list = Array.isArray(data) ? data : (Array.isArray(data.endpoints) ? data.endpoints : []);
                if (!list.length) throw new Error('No endpoints found in JSON');
                endpoints = list.map(normalizeEndpoint);
                markLoadedSource(url);
                applyFiltersAndRender();
            } catch (err) {
                toast('Failed to load: ' + err.message);
                console.error(err);
            }
        }

        /* normalize incoming objects to expected shape */
        function normalizeEndpoint(raw) {
            // allow raw being a string or object
            if (typeof raw === 'string') {
                return {
                    name: raw,
                    method: 'GET',
                    url: raw,
                    desc: ''
                };
            }
            const epi = {
                name: raw.name || raw.title || raw.url || 'unnamed',
                method: (raw.method || raw.httpMethod || 'GET').toUpperCase(),
                url: raw.url || raw.path || '/',
                desc: raw.desc || raw.description || '',
                tags: Array.isArray(raw.tags) ? raw.tags : (raw.tag ? [raw.tag] : []),
                params: Array.isArray(raw.params) ? raw.params : [],
                body: (raw.body !== undefined) ? raw.body : null,
                meta: raw.meta || {}
            };
            return epi;
        }

        /* render grid */
        function applyFiltersAndRender() {
            const q = (searchInput.value || '').trim().toLowerCase();
            filtered = endpoints.filter(ep => {
                if (currentMethod !== 'ALL' && ep.method !== currentMethod) return false;
                if (!q) return true;
                // search in name, url, desc, tags
                const hay = (ep.name + ' ' + ep.url + ' ' + ep.desc + ' ' + (ep.tags || []).join(' ')).toLowerCase();
                return hay.includes(q);
            });

            // sort
            const sortBy = "name";
            if (sortBy === 'name') filtered.sort((a, b) => a.name.localeCompare(b.name));
            else if (sortBy === 'method') filtered.sort((a, b) => a.method.localeCompare(b.method));
            // 'new' => keep order

            renderGrid(filtered);
        }

        /* create & attach cards */
        function renderGrid(list) {
            grid.innerHTML = '';
            countNum.textContent = list.length;
            list.forEach((ep, i) => {
                const card = document.createElement('div');
                card.className = 'card';
                card.innerHTML = `
      <div class="top-line">
        <div>
          <div class="title">${escapeHtml(ep.name)}</div>
          <div class="desc">${escapeHtml(ep.desc || '')}</div>
        </div>
        <div style="text-align:right">
          <div class="badge ${badgeClass(ep.method)}">${ep.method}</div>
          <div style="margin-top:8px; font-size:12px; color:var(--muted)">${(ep.tags||[]).slice(0,3).map(t=>`<span style="opacity:.9">#${escapeHtml(t)}</span>`).join(' ')}</div>
        </div>
      </div>

      <div class="url">
        <div style="flex:1; overflow:hidden; text-overflow:ellipsis; white-space:nowrap">${escapeHtml(ep.url)}</div>
        <div style="margin-left:10px; display:flex; gap:8px">
          <button class="small-btn" data-open>Open</button>
          <button class="small-btn" data-copy>Copy URL</button>
        </div>
      </div>

      <div class="card-actions">
        <button class="small-btn strong" data-curl>Copy cURL</button>
        <button class="small-btn" data-details>Details</button>
      </div>

      <details>
        <summary style="cursor:pointer; color:var(--muted)">Request sample & parameters</summary>
        <div style="margin-top:8px;">
          <div style="font-size:13px; color:var(--muted)">Params</div>
          ${renderParamsTable(ep.params)}
          <div style="margin-top:8px; font-size:13px; color:var(--muted)">Body</div>
          <pre>${escapeHtml(JSON.stringify(ep.body ?? {}, null, 2))}</pre>
        </div>
      </details>
    `;

                // attach event listeners
                const openBtn = card.querySelector('[data-open]');
                openBtn.addEventListener('click', () => {
                    const url = ep.url || '/';
                    // try to open absolute or relative
                    window.open(url, '_blank');
                });

                const copyBtn = card.querySelector('[data-copy]');
                copyBtn.addEventListener('click', () => {
                    copyToClipboard(ep.url || '');
                });

                const curlBtn = card.querySelector('[data-curl]');
                curlBtn.addEventListener('click', () => {
                    const curl = generateCurlCommand(ep);
                    copyToClipboard(curl);
                });

                grid.appendChild(card);
                // small animation
                card.style.opacity = 0;
                card.style.transform = 'translateY(12px)';
                setTimeout(() => {
                    card.style.transition = 'all .36s cubic-bezier(.2,.9,.3,1)';
                    card.style.opacity = 1;
                    card.style.transform = 'translateY(0)';
                }, 60 * i);
            });
        }

        /* render params table */
        function renderParamsTable(params) {
            if (!params || !params.length) return `<div style="color:var(--muted); font-size:13px">No parameters</div>`;
            const rows = params.map(p => `<tr><td><strong>${escapeHtml(p.name||'')}</strong></td><td>${escapeHtml(p.type||'')}</td><td>${escapeHtml(p.desc||'')}</td></tr>`).join('');
            return `<table><thead><tr><th>Name</th><th>Type</th><th>Description</th></tr></thead><tbody>${rows}</tbody></table>`;
        }

        /* badges */
        function badgeClass(method) {
            if (!method) return 'meth-OTHER';
            const m = method.toUpperCase();
            if (m === 'GET') return 'meth-GET';
            if (m === 'POST') return 'meth-POST';
            if (m === 'DELETE') return 'meth-DELETE';
            return 'meth-OTHER';
        }

        /* produce a reasonable cURL string */
        function generateCurlCommand(ep) {
            const url = ep.url || '/';
            const method = (ep.method || 'GET').toUpperCase();
            let cmd = `curl -X ${method}`;
            if (method === 'GET' || method === 'DELETE') {
                cmd += ` "${url}"`;
            } else {
                const body = ep.body ? JSON.stringify(ep.body) : '';
                cmd += ` -H "Content-Type: application/json" -d '${body}' "${url}"`;
            }
            return cmd;
        }

        /* escape */
        function escapeHtml(s) {
            if (s === null || s === undefined) return '';
            return String(s).replace(/[&<>"]/g, c => ({
                '&': '&amp;',
                '<': '&lt;',
                '>': '&gt;',
                '"': '&quot;'
            } [c]));
        }

        /* search & filter handlers */
        const doSearch = debounce(() => applyFiltersAndRender(), 200);
        searchInput.addEventListener('input', doSearch);

        chipEls.forEach(ch => {
            ch.addEventListener('click', () => {
                chipEls.forEach(x => x.classList.remove('active'));
                ch.classList.add('active');
                currentMethod = ch.dataset.method || 'ALL';
                applyFiltersAndRender();
            });
        });

        sortSelect.addEventListener('change', applyFiltersAndRender);

        /* load from input URL */
        loadBtn.addEventListener('click', () => {
            const url = sourceUrl.value.trim();
            if (!url) {
                toast('Enter a valid URL');
                return;
            }
            fetchFromUrl(url);
        });

        /* file upload */
        fileInput.addEventListener('change', (e) => {
            const f = e.target.files[0];
            if (!f) return;
            const r = new FileReader();
            r.onload = () => {
                try {
                    const json = JSON.parse(r.result);
                    const list = Array.isArray(json) ? json : (Array.isArray(json.endpoints) ? json.endpoints : null);
                    if (!list) throw new Error('File JSON must be an array or { endpoints: [] }');
                    endpoints = list.map(normalizeEndpoint);
                    markLoadedSource('uploaded file: ' + f.name);
                    applyFiltersAndRender();
                } catch (err) {
                    toast('Invalid JSON file: ' + err.message);
                    console.error(err);
                }
            };
            r.readAsText(f);
        });

        /* fetch default path */
        fetchDefaultBtn.addEventListener('click', () => {
            fetchFromUrl('/services.json');
        });

        /* fallback initial load */
        loadInitial();

        /* helper: try to automatically fetch /services.json on start (optional) */
        // try auto load if the file exists (silently)
        (async function tryAutoLoad() {
            try {
                const res = await fetch('/services.json', {
                    method: 'HEAD',
                    cache: 'no-store'
                });
                if (res.ok) {
                    fetchFromUrl('/services.json');
                }
            } catch (e) {}
        })();
    </script>
</body>

</html>