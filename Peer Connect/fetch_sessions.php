<?php
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

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