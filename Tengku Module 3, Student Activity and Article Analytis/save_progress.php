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

// Get the form data (assuming the form sends 'goal', 'progress', 'target_date', and 'id' for update)
$goal = isset($_POST['goal']) ? $_POST['goal'] : '';
$progress = isset($_POST['progress']) ? $_POST['progress'] : 0;
$target_date = isset($_POST['target_date']) ? $_POST['target_date'] : '';

// Check if there's an existing progress record (using 'id' from POST)
$id = isset($_POST['id']) ? $_POST['id'] : null;

if ($id) {
    // Update existing progress
    $stmt = $conn->prepare("UPDATE student_progress SET goal = ?, progress = ?, target_date = ? WHERE id = ? AND student_id = ?");
    $stmt->bind_param("sisii", $goal, $progress, $target_date, $id, $student_id);
} else {
    // Insert new progress
    $stmt = $conn->prepare("INSERT INTO student_progress (student_id, goal, progress, target_date) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isis", $student_id, $goal, $progress, $target_date);
}

if ($stmt->execute()) {
    echo "Progress saved successfully.";
    header('Location: update.php'); // Change 'index.php' to the appropriate page that displays goals
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
