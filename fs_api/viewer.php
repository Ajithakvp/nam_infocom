<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>API Viewer</title>
  <link rel="shortcut icon" type="image/png" href="../assets/images/logos/favicon.png" />
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;500;700&display=swap" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Fira+Code&display=swap" rel="stylesheet">
  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
    }

    body {
      font-family: 'Poppins', sans-serif;
      background: linear-gradient(135deg, #141e30, #243b55);
      color: #fff;
      min-height: 100vh;
      display: flex;
      flex-direction: column;
      padding: 20px;
    }

    .header {
      padding: 24px;
      background: rgba(0, 0, 0, 0.25);
      border-radius: 16px;
      box-shadow: 0 8px 20px rgba(0, 0, 0, 0.35);
      margin-bottom: 24px;
    }

    h2 {
      font-size: 28px;
      margin-bottom: 8px;
      font-weight: 600;
    }

    p {
      font-size: 15px;
      opacity: 0.85;
      margin-bottom: 16px;
    }

    .param-card {
      margin-top: 15px;
      background: rgba(255, 255, 255, 0.06);
      border-radius: 16px;
      padding: 24px;
      box-shadow: 0 10px 30px rgba(0, 0, 0, 0.35);
      max-width: 800px;
      transition: background 0.3s ease;
    }

    .param-card:hover {
      background: rgba(255, 255, 255, 0.08);
    }

    .param-row {
      display: flex;
      align-items: center;
      justify-content: space-between;
      margin-bottom: 20px;
      gap: 12px;
      flex-wrap: nowrap;
    }

    .param-row label {
      flex: 0 0 180px;
      font-weight: 500;
      font-size: 16px;
      opacity: 0.95;
      display: flex;
      justify-content: space-between;
      align-items: center;
    }

    .type {
      font-size: 12px;
      color: #ff9a76;
      opacity: 0.8;
      margin-left: 8px;
      font-weight: 400;
    }

    .param-row input {
      flex: 1;
      padding: 12px 14px;
      border-radius: 10px;
      border: 1px solid rgba(255, 255, 255, 0.2);
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-size: 15px;
      transition: all 0.3s ease;
    }

    .param-row input:focus {
      outline: none;
      border-color: #ff6a88;
      background: rgba(255, 255, 255, 0.18);
      box-shadow: 0 0 8px rgba(255, 106, 136, 0.6);
      transform: scale(1.02);
    }

    .buttons {
      margin-top: 18px;
      display: flex;
      gap: 12px;
      flex-wrap: wrap;
    }

    button {
      background: linear-gradient(90deg, #ffd54a, #ff9a76);
      border: none;
      padding: 12px 20px;
      border-radius: 10px;
      color: #fff;
      font-weight: 600;
      cursor: pointer;
      font-size: 15px;
      transition: 0.3s ease;
      box-shadow: 0 4px 14px rgba(0, 0, 0, 0.3);
    }

    button:hover {
      transform: translateY(-2px) scale(1.04);
      opacity: 0.95;
    }

    .response-box {
      flex: 1;
      padding: 24px;
      font-family: "Arial", sans-serif;
      white-space: pre-wrap;
      font-size: 15px;
      border-radius: 16px;
      border: 1px solid rgba(255, 255, 255, 0.12);
      background: rgba(30, 30, 30, 0.95);
      box-shadow: 0 8px 24px rgba(0, 0, 0, 0.45);
      overflow: auto;
      line-height: 1.5;
      margin-bottom: 24px;
    }

    .response-box::-webkit-scrollbar {
      width: 8px;
    }

    .response-box::-webkit-scrollbar-track {
      background: rgba(255, 255, 255, 0.05);
      border-radius: 4px;
    }

    .response-box::-webkit-scrollbar-thumb {
      background: rgba(255, 255, 255, 0.25);
      border-radius: 4px;
    }

    .json-key {
      color: #ff9a76;
    }

    .json-string {
      color: #8ce563;
    }

    .json-number {
      color: #4dd0e1;
    }

    .json-boolean {
      color: #f9f871;
    }

    .json-null {
      color: #ff5370;
    }

    @media (max-width:991px) {
      .param-row label {
        flex: 0 0 150px;
        font-size: 15px;
      }

      .param-card {
        padding: 20px;
      }
    }

    @media (max-width:600px) {
      .param-row {
        flex-wrap: wrap;
        flex-direction: column;
        align-items: flex-start;
      }

      .param-row label {
        flex: none;
        width: 100%;
        margin-bottom: 6px;
        justify-content: flex-start;
      }

      .param-row input {
        width: 100%;
      }

      .buttons {
        flex-direction: column;
        align-items: stretch;
      }

      button {
        width: 100%;
      }
    }
  </style>
</head>

<body>
  <div class="header">
    <h2 id="apiTitle"></h2>
    <p id="apiDesc"></p>
    <form id="apiForm" class="param-card"></form>
    <div class="buttons">
      <button id="previewBtn">👀 Preview Request</button>
      <button id="sendBtn">🚀 Send Request</button>
    </div>
  </div>
  <div class="response-box" id="responseBox">Response will appear here...</div>

  <!-- Include APIs -->
  <script src="apis.js"></script>
  <script>
    document.addEventListener('apisReady', () => {
      const urlParams = new URLSearchParams(window.location.search);
      const apiName = urlParams.get("api") || "Fetch Add User";
      const api = window.apis.find(a => a.name === apiName);

      if (!api) {
        document.getElementById("apiTitle").textContent = "API Not Found";
        document.getElementById("apiDesc").textContent = `No API found for "${apiName}"`;
        return;
      }

      document.getElementById("apiTitle").textContent = apiName;
      document.getElementById("apiDesc").textContent = api.desc;

      const form = document.getElementById("apiForm");
      form.innerHTML = "";
      if (api.params?.length) {
        api.params.forEach(p => {
          const row = document.createElement("div");
          row.className = "param-row";
          row.innerHTML = `
          <label for="${p}">${p} <span class="type">string</span></label>
          <input type="text" id="${p}" placeholder="Enter ${p}">
        `;
          form.appendChild(row);
        });
      } else {
        form.innerHTML = "<p>No parameters required for this API.</p>";
      }

      /** Format & highlight JSON nicely */
      function syntaxHighlight(json) {
        if (typeof json !== 'string') json = JSON.stringify(json, null, 2);
        json = json.replace(/&/g, '&amp;').replace(/</g, '&lt;').replace(/>/g, '&gt;');
        return json.replace(/("(\\u[a-zA-Z0-9]{4}|\\[^u]|[^\\"])*"(\s*:)?|\b(true|false|null)\b|\b-?\d+(\.\d+)?([eE][+\-]?\d+)?\b)/g, match => {
          let cls = 'json-number';
          if (/^"/.test(match)) cls = /:$/.test(match) ? 'json-key' : 'json-string';
          else if (/true|false/.test(match)) cls = 'json-boolean';
          else if (/null/.test(match)) cls = 'json-null';
          return `<span class="${cls}">${match}</span>`;
        });
      }


      function collectData() {
        const obj = {};
        api.params?.forEach(p => {
          obj[p] = document.getElementById(p)?.value.trim() || "";
        });
        return obj;
      }

      /** Preview Request */
      document.getElementById("previewBtn").onclick = e => {
        e.preventDefault();
        const preview = {
          method: api.method,
          url: api.url,
          params: collectData()
        };
        document.getElementById("responseBox").innerHTML = "📤 Request Preview:\n" + syntaxHighlight(preview);
      };

      document.getElementById("sendBtn").onclick = async e => {
        e.preventDefault();
        document.getElementById("responseBox").textContent = "⏳ Sending...";
        try {
          let response;
          if (api.method === "GET") {
            response = await fetch(api.url);
          } else {
            const body = new URLSearchParams();
            api.params.forEach(p => body.append(p, document.getElementById(p).value));
            response = await fetch(api.url, {
              method: "POST",
              body
            });
          }
          const json = await response.json();
          document.getElementById("responseBox").innerHTML = syntaxHighlight(json);
        } catch (err) {
          document.getElementById("responseBox").textContent = "❌ Error: " + err.message;
        }
      };
    });
  </script>
</body>

</html>