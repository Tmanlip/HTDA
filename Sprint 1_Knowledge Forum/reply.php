<?php

// Database connection
$host = 'localhost';
$db = 'forum_db';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insert the reply into the database
    $stmt = $pdo->prepare("INSERT INTO replies (id, question_id, user_id, reply_text) VALUES (:id, :question_id, :user_id, :reply_text)");
    $stmt->execute([
        'id' => $_POST['id'],
        'question_id' => $_POST['question_id'],
        'user_id' => $_POST['user_id'],
        'reply_text' => $_POST['reply_text'],
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Reply added successfully!']);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
