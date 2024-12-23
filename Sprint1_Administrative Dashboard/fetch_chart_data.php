<?php
// Include database connection
include 'db_connect.php';

// Query to fetch user statistics
$sql = "SELECT 
    SUM(role = 'Student' AND status = 'Active') AS active_students,
    SUM(role = 'Student' AND status = 'Inactive') AS inactive_students,
    SUM(role = 'Lecturer' AND status = 'Active') AS active_lecturers,
    SUM(role = 'Lecturer' AND status = 'Inactive') AS inactive_lecturers
    FROM users";

$result = $conn->query($sql);

// If data exists, fetch and return as JSON
if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode($data);
} else {
    echo json_encode([
        "active_students" => 0,
        "inactive_students" => 0,
        "active_lecturers" => 0,
        "inactive_lecturers" => 0
    ]);
}

// Close the database connection
$conn->close();
?>
