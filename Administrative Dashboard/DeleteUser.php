<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id']) && isset($_POST['table'])) {
    $id = $_POST['id'];
    $table = $_POST['table'];

    // Determine the table and set the query accordingly
    if ($table === 'student') {
        $delete_query = "DELETE FROM students WHERE matric_no = ?";
    } elseif ($table === 'lecturer') {
        $delete_query = "DELETE FROM lecturers WHERE employee_no = ?";
    } else {
        die("Invalid table selected.");
    }

    // Prepare and execute the delete statement
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("s", $id);

    if ($stmt->execute()) {
        // Redirect back to UserList.php after successful deletion
        header("Location: UserList.php?message=User+deleted+successfully");
        exit;
    } else {
        echo "Error deleting user: " . $conn->error;
    }

    $stmt->close();
} else {
    echo "Error: Invalid request or missing parameters.";
}

$conn->close();
?>
