<?php
// update_attendance.php
require 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Ensure correct path to your db_connect.php

// Get the raw POST data
$data = json_decode(file_get_contents('php://input'), true);

// Check if the data is valid
if (isset($data['matric_no']) && isset($data['attendance']) && isset($data['seminar_id'])) {
    $matric_no = $data['matric_no'];
    $attendance = $data['attendance'];
    $seminar_id = $data['seminar_id']; // Ensure seminar_id is passed

    // Sanitize input to prevent SQL injection
    $matric_no = mysqli_real_escape_string($conn, $matric_no);
    $attendance = mysqli_real_escape_string($conn, $attendance);
    $seminar_id = mysqli_real_escape_string($conn, $seminar_id);

    // Update the attendance in the database for the specific seminar
    $query = "UPDATE participation SET attendance = '$attendance' WHERE participant_id = '$matric_no' AND seminar_id = '$seminar_id'";

    // Check if the query was successful
    if (mysqli_query($conn, $query)) {
        echo json_encode(["status" => "success"]);
    } else {
        // If there's an error, return the error message
        echo json_encode(["status" => "error", "message" => mysqli_error($conn)]);
    }
} else {
    // Return an error if the necessary data is missing
    echo json_encode(["status" => "error", "message" => "Missing matric_no, attendance, or seminar_id"]);
}
?>
