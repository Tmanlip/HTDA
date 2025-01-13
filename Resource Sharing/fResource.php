<?php
// Include the database connection file
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Prepare the response array
$response = array();

// Query to fetch the document data
$sql = "SELECT id, course_name, document_name, file_path, upload_date FROM resources";
$result = $conn->query($sql);

// Check if any rows are returned
if ($result->num_rows > 0) {
    // Fetch all the rows and store them in the response array
    while ($row = $result->fetch_assoc()) {
        $response[] = $row;
    }
} else {
    // If no documents are found, return a message
    $response[] = "No documents found.";
}

// Set the content type to JSON
header('Content-Type: application/json');

// Output the JSON-encoded response
echo json_encode($response);

// Close the database connection
$conn->close();
?>
