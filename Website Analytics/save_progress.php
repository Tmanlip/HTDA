<?php
include 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Include your database connection
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

$username = $_SESSION['username']; // Use the username stored in the session

// Get the student ID from the POST data (sent from the form)
$student_id = isset($_POST['matric_no']) ? $_POST['matric_no'] : null;

if (!$student_id) {
    die("Invalid student ID.");
}

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
    $stmt->bind_param("ssis", $student_id, $goal, $progress, $target_date);
}

if ($stmt->execute()) {
    echo "Progress saved successfully.";
    header('Location: update.php'); // Change 'update.php' to the appropriate page that displays goals
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
