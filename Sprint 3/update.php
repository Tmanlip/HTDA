<?php
include 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Include your database connection

// Get the POST data
$student_email = isset($_POST['student_email']) ? $_POST['student_email'] : '';
$seminar_id = isset($_POST['seminar_id']) ? $_POST['seminar_id'] : '';

// Validate the input
if (empty($student_email) || empty($seminar_id)) {
    echo json_encode(['success' => false, 'message' => 'Missing required data']);
    exit;
}

// Check if the student is already marked as present for this seminar
$stmt = $conn->prepare("SELECT attendance FROM participation WHERE student_email = ? AND seminar_id = ?");
$stmt->bind_param("si", $student_email, $seminar_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $attendance = $result->fetch_assoc()['attendance'];
    if ($attendance == 'present') {
        echo json_encode(['success' => false, 'message' => 'Attendance already marked as present']);
        exit;
    }
}

// Update attendance to 'present'
$stmt = $conn->prepare("UPDATE participation SET attendance = 'present' WHERE student_email = ? AND seminar_id = ?");
$stmt->bind_param("si", $student_email, $seminar_id);
if ($stmt->execute()) {
    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false, 'message' => 'Error updating attendance']);
}
?>
