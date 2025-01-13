<?php
// Database connection
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Set JSON header
header('Content-Type: application/json');

// Enable error reporting for debugging (remove this in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

try {
    // Database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Validate input
    if (empty($_POST['question_id']) || empty($_POST['matric_no']) || empty($_POST['reply_text'])) {
        echo json_encode(['status' => 'error', 'message' => 'Missing required fields: question_id, matric_no, or reply_text']);
        exit;
    }

    $questionId = $_POST['question_id'];
    $matricNo = $_POST['matric_no'];
    $replyText = $_POST['reply_text'];

    // Check if matric_no exists in the students table
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM students WHERE matric_no = :matric_no");
    $stmt->execute([':matric_no' => $matricNo]);
    $studentExists = $stmt->fetchColumn();

    if (!$studentExists) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid matric_no: Student does not exist.']);
        exit;
    }

    // Insert the reply into the replies table
    $stmt = $pdo->prepare("INSERT INTO replies (question_id, matric_no, reply_text) VALUES (:question_id, :matric_no, :reply_text)");
    $stmt->execute([
        ':question_id' => $questionId,
        ':matric_no' => $matricNo,
        ':reply_text' => $replyText,
    ]);

    // Get the ID of the inserted reply
    $replyId = $pdo->lastInsertId();

    if (!$replyId) {
        echo json_encode(['status' => 'error', 'message' => 'Failed to insert reply into the database.']);
        exit;
    }

    // Insert the forum contribution into the forum_contributions table
    $stmt = $pdo->prepare("INSERT INTO forum_contributions (student_id, question_id, reply_id) VALUES (:student_id, :question_id, :reply_id)");
    $stmt->execute([
        ':student_id' => $matricNo, // Assuming matric_no is the student_id
        ':question_id' => $questionId,
        ':reply_id' => $replyId,
    ]);

    // Return success response
    echo json_encode(['status' => 'success', 'message' => 'Reply added and contribution recorded successfully!']);
} catch (PDOException $e) {
    // Log detailed error for debugging
    error_log("Database error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'Database error occurred: ' . $e->getMessage()]);
    exit;
} catch (Exception $e) {
    // Log and handle general errors
    error_log("General error: " . $e->getMessage());
    echo json_encode(['status' => 'error', 'message' => 'An unexpected error occurred: ' . $e->getMessage()]);
    exit;
}

?>