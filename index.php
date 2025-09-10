<?php
session_start();


// // If not logged in, redirect to login page
// // if(!isset($_SESSION['username'])){
// //     header("Location: login.php");
// //     exit();
// // }

// Prevent caching (so back button doesn’t reload old page)
// header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
// header("Cache-Control: post-check=0, pre-check=0", false);
// header("Pragma: no-cache");

session_destroy();
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

include("config.php");


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login Page</title>

  <!-- Font Awesome -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <!-- jQuery -->
  <script src="assets/js/jquery-3.6.4.min.js"></script>

  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      font-family: "Segoe UI", Arial, sans-serif;
    }

    body {
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
      padding: 20px;
      background: linear-gradient(135deg, #5d87ff 0%, #3a6dff 50%, #c7d7ff 100%);
      overflow: hidden;
    }

    .login-card {
      position: relative;
      background: #fff;
      width: 100%;
      max-width: 380px;
      border-radius: 20px;
      padding: 40px 30px;
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
      z-index: 2;
      text-align: center;
    }

    .login-card h2 {
      font-size: 26px;
      font-weight: bold;
      text-align: left;
      margin-bottom: 5px;
      color: #333;
    }

    .login-card p {
      font-size: 14px;
      color: #777;
      text-align: left;
      margin-bottom: 25px;
    }

    .input-group {
      position: relative;
      margin-bottom: 20px;
    }

    .left-icon {
      position: absolute;
      top: 50%;
      left: 15px;
      transform: translateY(-50%);
      color: #5d87ff;
      font-size: 16px;
    }

    .toggle-password {
      position: absolute;
      top: 50%;
      right: 15px;
      transform: translateY(-50%);
      cursor: pointer;
      color: #5d87ff;
      font-size: 16px;
    }

    .input-box {
      width: 100%;
      padding: 12px 42px;
      border-radius: 30px;
      border: 1px solid #ddd;
      background: #f9f9f9;
      font-size: 14px;
      outline: none;
      transition: 0.3s;
    }

    .input-box:focus {
      border-color: #5d87ff;
      background: #fff;
    }

    .options {
      display: flex;
      justify-content: flex-end;
      font-size: 13px;
      margin: -10px 0 20px;
    }

    .options a {
      text-decoration: none;
      color: #5d87ff;
      font-weight: 500;
    }

    .btn {
      width: 100%;
      padding: 13px;
      border: none;
      border-radius: 30px;
      background: linear-gradient(135deg, #5d87ff, #3a6dff);
      color: white;
      font-size: 15px;
      font-weight: bold;
      cursor: pointer;
      transition: 0.3s;
    }

    .btn:hover {
      opacity: 0.9;
      transform: scale(1.02);
    }

    /* Background Circles */
    .circle {
      position: absolute;
      border-radius: 50%;
      background: rgba(255, 255, 255, 0.15);
      z-index: 1;
    }

    .circle.small {
      width: 90px;
      height: 90px;
      top: 20%;
      left: 10%;
    }

    .circle.medium {
      width: 160px;
      height: 160px;
      bottom: 10%;
      right: 15%;
    }

    .circle.large {
      width: 250px;
      height: 250px;
      bottom: -80px;
      left: -80px;
    }
  </style>
</head>

<body>
  <!-- Circles in Background -->
  <div class="circle small"></div>
  <div class="circle medium"></div>
  <div class="circle large"></div>

  <!-- Login Card -->
  <div class="login-card">
    <h2>Hello!</h2>
    <p>Sign in to your account</p>

    <div class="input-group">
      <i class="fa fa-user left-icon"></i>
      <input type="text" id="username" placeholder="Username" class="input-box">
    </div>

    <div class="input-group">
      <i class="fa fa-lock left-icon"></i>
      <input type="password" id="password" placeholder="Password" class="input-box">
      <i class="fa fa-eye toggle-password" id="togglePassword"></i>
    </div>

    <div class="options">
      <a href="#">Forgot password?</a>
    </div>

    <button class="btn" id="loginBtn">SIGN IN</button>
  </div>


  <!-- JS -->
  <script>
    // Password toggle
    const togglePassword = document.querySelector("#togglePassword");
    const password = document.querySelector("#password");

    togglePassword.addEventListener("click", () => {
      const type = password.getAttribute("type") === "password" ? "text" : "password";
      password.setAttribute("type", type);
      togglePassword.classList.toggle("fa-eye-slash");
    });


    // Disable back button
    history.pushState(null, null, location.href);
    window.onpopstate = function() {
      history.go(1);
    };

    window.onload = function() {
      if (window.history && window.history.pushState) {
        window.history.pushState(null, null, window.location.href);
        window.onpopstate = function() {
          window.history.go(1);
        };
      }
    };

    // AJAX Login
    $("#loginBtn").on("click", function() {
      const username = $("#username").val().trim();
      const password = $("#password").val().trim();

      if (username === "" || password === "") {
        alert("Please enter both username and password!");
        return;
      }

      $.ajax({
        url: "loginchk.php",
        type: "POST",
        data: {
          username: username,
          password: password
        },
        success: function(response) {
          console.log("Server Response:", response);
          if (response === "success") {
            window.location.href = "add_user.php";
          } else {
            alert("Invalid username or password!");
          }
        },
        error: function() {
          alert("Error connecting to server!");
        }
      });
    });
  </script>
</body>

</html>