<?php
session_start();
include 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Include your database connection

// Set the dummy username 'nursya' for now
$_SESSION['username'] = 'nursya'; // Use 'nursya' as the dummy username

$username = $_SESSION['username']; // Use the username stored in the session

// Get the student ID using the username
$stmt = $conn->prepare("SELECT id FROM student WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Invalid username.");
}

$student_id = $student['id'];

// Fetch the student's progress
$stmt = $conn->prepare("SELECT id, goal, progress, target_date FROM student_progress WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$goals = [];
while ($row = $result->fetch_assoc()) {
    $goals[] = $row;
}

echo json_encode($goals);

$stmt->close();
$conn->close();
?>
