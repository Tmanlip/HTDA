<?php
session_start(); // Start the session

// Unset all session variables
$_SESSION = array();

// Destroy the session
session_destroy();

// Clear the "Remember me" cookie if it exists
if (isset($_COOKIE['username'])) {
    setcookie("username", "", time() - 3600, "/"); // Expire the cookie
}

// Redirect to the login page
header("Location: login.php");
exit();
?>
