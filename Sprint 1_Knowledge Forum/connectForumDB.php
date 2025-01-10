<?php
// Database connection details
$host = "localhost";
$username = "root"; // Default XAMPP username
$password = "";     // Default XAMPP password (leave empty)
$database = "forum_db";

// Create connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
echo "Connected successfully"; // For testing purposes (remove or comment out in production)
?>
