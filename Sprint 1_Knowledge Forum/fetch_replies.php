<?php
header('Content-Type: application/json');

// Database connection
$host = 'localhost';
$db = 'forum_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Ensure question_id is passed
    if (!isset($_GET['question_id']) || empty(trim($_GET['question_id']))) {
        echo json_encode([]);
    }
    
    // Fetch replies for the question
    $stmt = $pdo->query("SELECT id, question_id, user_id, reply_text FROM replies");
    $replies = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($replies);
} catch (PDOException $e) {
    echo json_encode([]);
}
