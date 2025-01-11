<?php
// connectPcDB.php

$host = 'localhost';          // Database host (usually 'localhost')
$dbname = 'pconnect_db';          // Database name
$username = 'root';   // Your MySQL username
$password = '';   // Your MySQL password
 
try {
    // Create PDO instance for database connection
    $conn = new mysqli($host, $username, $password, $dbname); // Ensure $conn is initialized
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
