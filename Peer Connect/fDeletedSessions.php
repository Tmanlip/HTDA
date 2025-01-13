<?php
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

$response = array();
$sql = "SELECT id, session_name, experience_level, time, location, max_participants, members FROM deleted_sessions"; // Fetch from deleted_sessions
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
}

echo json_encode($response);
$conn->close();
?>