<?php
header('Content-Type: application/json');

// Database credentials
include 'C:\xampp\htdocs\HiTDA\db_connect.php';
try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch all questions
    $stmt = $pdo->query("SELECT id, matric_no, employee_no, title, description, tags FROM questions");
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the questions as JSON
    echo json_encode($questions);
} catch (PDOException $e) {
    // Handle errors
    echo json_encode(['error' => $e->getMessage()]);
}
?>
