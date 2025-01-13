<?php
// Include database connection file
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Check if the question_id is provided
if (isset($_GET['question_id'])) {
    // Get the question_id from the GET request
    $questionId = $_GET['question_id'];

    // Prepare the SQL query to delete related forum contributions first
    $deleteContributionsQuery = "DELETE FROM forum_contributions WHERE question_id = ?";

    if ($stmt = $conn->prepare($deleteContributionsQuery)) {
        $stmt->bind_param('i', $questionId);
        $stmt->execute();
        $stmt->close();
    }

    // Prepare the SQL query to delete the question from the database
    $query = "DELETE FROM questions WHERE id = ?";
    
    // Prepare the statement
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter and execute the statement
        $stmt->bind_param('i', $questionId);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            echo json_encode(["status" => "success", "message" => "Question deleted successfully"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Failed to delete question"]);
        }
        $stmt->close();
    } else {
        echo json_encode(["status" => "error", "message" => "Error preparing statement"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "No question ID provided"]);
}

$conn->close();
?>
