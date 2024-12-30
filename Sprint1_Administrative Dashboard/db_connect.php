<?php
$host = 'localhost'; // Database host
$dbname = 'tutorxcells'; // Database name
$username = 'root'; // Database username (default for XAMPP)
$password = ''; // Database password (default is empty for XAMPP)

// Create a connection
$conn = new mysqli($host, $username, $password, $dbname);

// Check the connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
