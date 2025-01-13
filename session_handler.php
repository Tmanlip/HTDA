<?php
session_start();

// Redirect to login page if not logged in
if (!isset($_SESSION['username']) || !isset($_SESSION['user_type'])) {
    header("Location: http://localhost/HiTDA/User%20Dashboard/login.php");
    exit();
}

// Optional: Handle inactivity timeout (e.g., 20 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1200)) {
    // Session expired
    session_unset();
    session_destroy();
    header("Location: http://localhost/HiTDA/User%20Dashboard/login.php");
    exit();
}
$_SESSION['last_activity'] = time(); // Update last activity timestamp
?>
