<?php
// Include the database connection
include 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Adjust path if necessary

header('Content-Type: application/json');

// Check if the POST request contains 'question_id'
if (isset($_POST['question_id']) && is_numeric($_POST['question_id'])) {
    $question_id = $_POST['question_id'];

    // Prepare the SQL query to fetch the replies based on question_id
    $query = "SELECT reply_text FROM replies WHERE question_id = ?";

    // Use prepared statement to prevent SQL injection
    if ($stmt = $conn->prepare($query)) {
        // Bind the parameter to the prepared statement
        $stmt->bind_param("i", $question_id);

        // Execute the query
        $stmt->execute();

        // Bind the result variable to the query
        $stmt->bind_result($reply_text);

        // Fetch the replies into an array
        $replies = [];
        while ($stmt->fetch()) {
            $replies[] = ['reply_text' => $reply_text];
        }

        // Close the statement
        $stmt->close();

        // Check if replies are found
        if (empty($replies)) {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => [], 'message' => 'No replies found for this question.']);
        } else {
            http_response_code(200);
            echo json_encode(['status' => 'success', 'data' => $replies]);
        }
    } else {
        // Handle SQL query preparation failure
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Failed to prepare query.']);
    }
} else {
    // Handle missing or invalid question_id
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Invalid or missing question_id.']);
}

// Close the database connection (optional for short scripts)
// $conn->close();
?>
