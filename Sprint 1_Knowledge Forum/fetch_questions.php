<?php
header('Content-Type: application/json');


// Database credentials
$host = 'localhost';   // Replace with your actual host
$db   = 'forum_db';    // Replace with your database name
$user = 'root';        // Replace with your database username
$pass = '';            // Replace with your database password;


try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Query to fetch all questions
    $stmt = $pdo->query("SELECT id, user_id, title, description, tags FROM questions");
    $questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the questions as JSON
    echo json_encode($questions);
} catch (PDOException $e) {
    // Handle errors
    echo json_encode(['error' => $e->getMessage()]);
}
?>
