<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pconnect_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get form data
$session_name = trim($_POST['session_name']);
$experience_level = trim($_POST['experience_level']);
$time = trim($_POST['time']);
$location = trim($_POST['location']);
$max_participants = trim($_POST['max_participants']);
$members = trim($_POST['members']);

// Validate inputs (Optional but recommended)
if (empty($session_name) || empty($time) || empty($location)) {
    die("Error: Required fields are missing.");
}

// Prepare and bind
$stmt = $conn->prepare("INSERT INTO sessions (session_name, experience_level, `time`, `location`, max_participants, members) VALUES (?, ?, ?, ?, ?, ?)");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssssss", $session_name, $experience_level, $time, $location, $max_participants, $members);

// Execute and check for success
if ($stmt->execute()) {
    echo "Session added successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();


header('Location: pConnect.html'); // Redirect to pConnect.html

?>
