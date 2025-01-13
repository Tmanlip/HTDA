<?php
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Initialize response array
$response = [
    'active_students' => 0,
    'inactive_students' => 0,
    'active_lecturers' => 0,
    'inactive_lecturers' => 0,
];

// Define the "active" threshold (e.g., users active within the past 30 days)
$active_threshold = date('Y-m-d H:i:s', strtotime('-30 days'));

try {
    // Query for students: active and inactive based on last_login
    $stmt = $conn->prepare("
        SELECT 
            SUM(CASE WHEN last_login >= ? THEN 1 ELSE 0 END) AS active_students,
            SUM(CASE WHEN last_login < ? OR last_login IS NULL THEN 1 ELSE 0 END) AS inactive_students
        FROM students
    ");
    $stmt->bind_param("ss", $active_threshold, $active_threshold);
    $stmt->execute();
    $stmt->bind_result($active_students, $inactive_students);
    $stmt->fetch();
    $response['active_students'] = $active_students ?? 0;
    $response['inactive_students'] = $inactive_students ?? 0;
    $stmt->close();

    // Query for lecturers: active and inactive based on last_login
    $stmt = $conn->prepare("
        SELECT 
            SUM(CASE WHEN last_login >= ? THEN 1 ELSE 0 END) AS active_lecturers,
            SUM(CASE WHEN last_login < ? OR last_login IS NULL THEN 1 ELSE 0 END) AS inactive_lecturers
        FROM lecturers
    ");
    $stmt->bind_param("ss", $active_threshold, $active_threshold);
    $stmt->execute();
    $stmt->bind_result($active_lecturers, $inactive_lecturers);
    $stmt->fetch();
    $response['active_lecturers'] = $active_lecturers ?? 0;
    $response['inactive_lecturers'] = $inactive_lecturers ?? 0;
    $stmt->close();
} catch (Exception $e) {
    // Log error or handle appropriately
    error_log("Error fetching data: " . $e->getMessage());
}

// Output the response as JSON
header('Content-Type: application/json');
echo json_encode($response);
?>
