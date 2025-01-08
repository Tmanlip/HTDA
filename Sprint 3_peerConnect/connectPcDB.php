<?php
// connectPcDB.php

$host = 'localhost';          // Database host (usually 'localhost')
$dbname = 'pconnect_db';          // Database name
$username = 'root';   // Your MySQL username
$password = '';   // Your MySQL password
 
try {
    echo "meow";
    // Create PDO instance for database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); // Set error mode to exception
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>
