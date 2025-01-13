<?php
// Database configuration
$host = 'localhost';       // Database server (use IP or 'localhost' if on the same server)
$dbname = 'tutorxcells';  // Replace with your actual database name
$username = 'root'; // Replace with your actual database username
$password = ''; // Replace with your actual database password 

// Create a connection to the database
$conn = new mysqli($host, $username, $password, $dbname);

// Check if the connection was successful
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Close the connection at the end of the script (optional for short scripts)
// $conn->close();
?>
