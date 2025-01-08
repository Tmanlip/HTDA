<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pconnect_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT id, session_name, experience_level, time, location, max_participants, members FROM sessions";
$result = $conn->query($sql);

$sessions = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $sessions[] = $row;
    }
}

$conn->close();
echo json_encode($sessions);
?>