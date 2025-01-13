<?php
// Include the database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Prepare the response array
$response = array();

try {
    // Query to fetch the deleted resource data
    $sql = "SELECT id, course_name, document_name, file_path, upload_date 
            FROM deleted_resources 
            ORDER BY upload_date DESC";
            
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        // Fetch all the rows and store them in the response array
        while ($row = $result->fetch_assoc()) {
            $response[] = array(
                'id' => $row['id'],
                'course_name' => $row['course_name'],
                'document_name' => $row['document_name'],
                'file_path' => $row['file_path'],
                'upload_date' => $row['upload_date']
            );
        }
    } else {
        $response = array();
    }

    // Set the content type to JSON
    header('Content-Type: application/json');
    echo json_encode($response);

} catch (Exception $e) {
    error_log("Database error: " . $e->getMessage());
    header('HTTP/1.1 500 Internal Server Error');
    echo json_encode(array('error' => 'Database error occurred'));
}

// Close the database connection
$conn->close();
?>