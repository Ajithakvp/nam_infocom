<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Redirect to login if session is empty
if (
    empty($_SESSION['username']) ||
    empty($_SESSION['type']) ||
    empty($_SESSION['subscriber_id'])
) {
    header("Location: index.php");
    exit;
}

// session timeout check (7 minutes here, change to 10s if for testing)
$timeout = 420; // seconds (use 420 for 7 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > $timeout)) {
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}

$_SESSION['last_activity'] = time(); // update last activity
