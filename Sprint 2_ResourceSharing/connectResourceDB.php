<?php
// Database credentials
$servername = "localhost";  // Replace with your database server (usually 'localhost')
$username = "root";         // Replace with your database username
$password = "";             // Replace with your database password (if any)
$dbname = "resource_db";  // Replace with your actual database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    // If the connection fails, show the error message
    die("Connection failed: " . $conn->connect_error);
}
?>
