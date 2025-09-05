<?php

if (
    empty($_SESSION['username']) &&
    empty($_SESSION['type']) &&
    empty($_SESSION['subscriber_id'])
) {
    header("Location: index.php");
    exit;
}

// session timeout check (10 sec)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 420)) {
    // destroy session after 10 sec of inactivity
    session_unset();
    session_destroy();
    header("Location: index.php");
    exit;
}
$_SESSION['last_activity'] = time(); // update last activity
