<?php
// Database configuration
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Get form data
$usertype = trim($_POST['user_type']);
$id = $_POST['matric_no'];

if ($usertype === 'student') {
    $check_stmt = $conn->prepare("SELECT 1 FROM students WHERE matric_no = ?");
} elseif ($usertype === 'lecturer') {
    $check_stmt = $conn->prepare("SELECT 1 FROM lecturers WHERE employee_no = ?");
}

$check_stmt->bind_param("s", $id);
$check_stmt->execute();
$result = $check_stmt->get_result();

if ($result->num_rows === 0) {
    die("Error: The provided ID does not exist in the database.");
}

$check_stmt->close();

$session_name = trim($_POST['session_name']);
$experience_level = trim($_POST['experience_level']);
$time = trim($_POST['time']);
$location = trim($_POST['location']);
$max_participants = (int)trim($_POST['max_participants']);

// Validate inputs
if (empty($session_name) || empty($time) || empty($location) || empty($id)) {
    die("Error: Required fields are missing.");
}

// Determine the appropriate query based on user type
if ($usertype === 'student') {
    $stmt = $conn->prepare(
        "INSERT INTO sessions (session_name, experience_level, `time`, `location`, max_participants, student_id) 
        VALUES (?, ?, ?, ?, ?, ?)"
    );
} elseif ($usertype === 'lecturer') {
    $stmt = $conn->prepare(
        "INSERT INTO sessions (session_name, experience_level, `time`, `location`, max_participants, lecturer_id) 
        VALUES (?, ?, ?, ?, ?, ?)"
    );
}

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

// Bind parameters
$stmt->bind_param("ssssss", $session_name, $experience_level, $time, $location, $max_participants, $id);

// Execute and check for success
if ($stmt->execute()) {
    echo "Session added successfully.";

    // Get the last inserted session ID
    $session_id = $stmt->insert_id;

    // If the user is a student, add an entry to the peer_collaborations table
    if ($usertype === 'student') {
        $peer_stmt = $conn->prepare(
            "INSERT INTO peer_collaborations (student_id, session_id) VALUES (?, ?)"
        );

        if ($peer_stmt) {
            $peer_stmt->bind_param("si", $id, $session_id);

            if ($peer_stmt->execute()) {
                echo " Peer collaboration entry added successfully.";
            } else {
                echo " Error adding peer collaboration entry: " . $peer_stmt->error;
            }

            $peer_stmt->close();
        } else {
            echo " Prepare failed for peer_collaborations: " . $conn->error;
        }
    }
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

// Redirect to pConnect.html
header('Location: pConnect.php');
exit();
?>
