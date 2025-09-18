<?php
session_start();
session_destroy();

// Prevent caching
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
<title>Animated Login</title>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
<script src="assets/js/jquery-3.6.4.min.js"></script>
<style>
  *{margin:0;padding:0;box-sizing:border-box;font-family:"Segoe UI",sans-serif;}

  body {
    height: 100vh;
    display: flex;
    justify-content: center;
    align-items: center;
    background: #0d0f1a;
    overflow: hidden;
  }

  /* Particle Background */
  canvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
  }

  /* Login Card */
  .login-card {
    width: 380px;
    padding: 40px 30px;
    border-radius: 20px;
    background: rgba(255,255,255,0.08);
    backdrop-filter: blur(15px);
    box-shadow: 0 15px 35px rgba(0,0,0,0.4);
    text-align: center;
    color: #fff;
    z-index: 2;
    animation: rotateIn 1s ease forwards;
    transform: rotateY(90deg);
    opacity: 0;
  }

  @keyframes rotateIn {
    to { transform: rotateY(0); opacity: 1; }
  }

  .login-card img {
    width: 65%;
    margin-bottom: 15px;
    animation: bounceIn 1.2s ease;
    filter: brightness(0) invert(1);
  }

  @keyframes bounceIn {
    0% { transform: scale(0.6); opacity: 0; }
    60% { transform: scale(1.1); opacity: 1; }
    100% { transform: scale(1); }
  }

  .login-card h2 { font-size: 26px; margin-bottom: 10px; color: #fff; }
  .login-card p { font-size: 14px; margin-bottom: 25px; color: #cfd3f3; }

  .input-group { position: relative; margin-bottom: 20px; }
  .left-icon, .toggle-password {
    position: absolute; top: 50%; transform: translateY(-50%);
    color: #3a6dff; font-size: 16px;
  }
  .left-icon { left: 15px; }
  .toggle-password { right: 15px; cursor: pointer; }

  .input-box {
    width: 100%; padding: 12px 42px;
    border-radius: 30px; border: none;
    background: rgba(255,255,255,0.15); color: #fff;
    transition: 0.3s;
  }
  .input-box:focus {
    box-shadow: 0 0 12px #3a6dff, 0 0 25px #5d87ff inset;
    outline: none;
  }

  .btn {
    width: 100%; padding: 13px; border: none;
    border-radius: 30px;
    background: linear-gradient(135deg,#5d87ff,#3a6dff);
    color: white; font-size: 15px; font-weight: bold;
    cursor: pointer; overflow: hidden;
    position: relative;
  }
  .btn::after {
    content:""; position:absolute; top:0; left:-100%;
    width:100%; height:100%;
    background: rgba(255,255,255,0.2);
    transform: skewX(-20deg);
    transition: 0.5s;
  }
  .btn:hover::after { left:100%; }

  .options { text-align:right; font-size:13px; margin-bottom:15px; }
  .options a { color:#5d87ff; text-decoration:none; }
  .options a:hover { text-decoration:underline; }

  @media (max-width: 480px) {
    .login-card { width: 90%; padding: 30px 20px; }
  }
</style>
</head>
<body>
<canvas id="particles"></canvas>

<div class="login-card">
  <img src="assets/images/logos/dark-logo.png" alt="Logo">
  <h2>Welcome Back</h2>
  <p>Enter your credentials to continue</p>

  <div class="input-group">
    <i class="fa fa-user left-icon"></i>
    <input type="text" id="username" placeholder="Username" class="input-box" maxlength="20">
  </div>
  <div class="input-group">
    <i class="fa fa-lock left-icon"></i>
    <input type="password" id="password" placeholder="Password" class="input-box" maxlength="20">
    <i class="fa fa-eye toggle-password" id="togglePassword"></i>
  </div>

  <div class="options"><a href="#"></a></div>
  <button class="btn" id="loginBtn">SIGN IN</button>
</div>

<script>
  // Toggle password
  const togglePassword = document.querySelector("#togglePassword");
  const password = document.querySelector("#password");
  togglePassword.addEventListener("click", () => {
    const type = password.getAttribute("type") === "password" ? "text" : "password";
    password.setAttribute("type", type);
    togglePassword.classList.toggle("fa-eye-slash");
  });

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
      data: { username: username, password: password },
      success: function(response) {
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

  // Particle Background
  const canvas = document.getElementById("particles");
  const ctx = canvas.getContext("2d");
  canvas.width = window.innerWidth;
  canvas.height = window.innerHeight;

  let particlesArray = [];
  const colors = ["#3a6dff","#5d87ff","#ffffff"];
  const mouse = { x:null, y:null, radius:100 };

  window.addEventListener("mousemove", function(e){
    mouse.x = e.x;
    mouse.y = e.y;
  });

  class Particle {
    constructor(){
      this.x = Math.random()*canvas.width;
      this.y = Math.random()*canvas.height;
      this.size = Math.random()*2+1;
      this.speedX = Math.random()*1-0.5;
      this.speedY = Math.random()*1-0.5;
      this.color = colors[Math.floor(Math.random()*colors.length)];
    }
    update(){
      this.x += this.speedX;
      this.y += this.speedY;
      if(this.x < 0 || this.x > canvas.width) this.speedX *= -1;
      if(this.y < 0 || this.y > canvas.height) this.speedY *= -1;

      let dx = mouse.x - this.x;
      let dy = mouse.y - this.y;
      let dist = Math.sqrt(dx*dx+dy*dy);
      if(dist < mouse.radius){
        this.x -= dx/10;
        this.y -= dy/10;
      }
    }
    draw(){
      ctx.beginPath();
      ctx.arc(this.x,this.y,this.size,0,Math.PI*2);
      ctx.fillStyle=this.color;
      ctx.fill();
    }
  }

  function init(){
    particlesArray=[];
    for(let i=0;i<120;i++) particlesArray.push(new Particle());
  }

  function animate(){
    ctx.clearRect(0,0,canvas.width,canvas.height);
    particlesArray.forEach(p=>{p.update();p.draw();});
    requestAnimationFrame(animate);
  }

  init();
  animate();
  window.addEventListener("resize",()=>{
    canvas.width=window.innerWidth;
    canvas.height=window.innerHeight;
    init();
  });
</script>
</body>
</html>
