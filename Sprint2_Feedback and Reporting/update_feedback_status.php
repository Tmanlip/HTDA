<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "tutorxcells";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle feedback status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['feedback_id']) && isset($_POST['status'])) {
    $feedback_id = $_POST['feedback_id'];
    $new_status = $_POST['status'];

    // Update status in the database
    $update_query = "UPDATE feedback SET status = '$new_status' WHERE id = '$feedback_id'";

    if ($conn->query($update_query) === TRUE) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => $conn->error]);
    }
}

$conn->close();
?>
