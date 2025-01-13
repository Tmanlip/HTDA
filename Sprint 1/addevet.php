<?php
// Database connection details
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve form data
    $event_name = $_POST['event_name'];
    $seminar_date = $_POST['seminar_date'];
    $time = $_POST['time'];
    $place = $_POST['place'];
    $speaker = $_POST['speaker'];
    $description = $_POST['description'];
    $category = $_POST['category'];
    $recurring = isset($_POST['recurring']) ? 1 : 0;

    // Prepare the SQL query
    $sql = "INSERT INTO seminar (event_name, seminar_date, time, place, speaker, description, category, recurring) 
            VALUES (:event_name, :seminar_date, :time, :place, :speaker, :description, :category, :recurring)";

    try {
        $stmt = $pdo->prepare($sql);
        $stmt->bindParam(':event_name', $event_name);
        $stmt->bindParam(':seminar_date', $seminar_date);
        $stmt->bindParam(':time', $time);
        $stmt->bindParam(':place', $place);
        $stmt->bindParam(':speaker', $speaker);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':category', $category);
        $stmt->bindParam(':recurring', $recurring, PDO::PARAM_BOOL);

        // Execute the query
        $stmt->execute();

        echo "<script>alert('Event created successfully!'); window.location.href = 'eventManagement.php';</script>";
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
