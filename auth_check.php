<?php
session_start();

// Check if user logged in
// if (!isset($_SESSION['username'])) {
//     header("Location: login.php");
//     exit;
// }

// Timeout in seconds
$timeout = 30;

// Check last activity
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    // Session expired
    session_unset();
    session_destroy();
    header("Location: login.php?expired=1");
    exit;
}

// Update last activity time
$_SESSION['last_activity'] = time();
