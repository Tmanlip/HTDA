<?php
// Include database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Set response headers
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type, X-Requested-With');

// Handle preflight requests
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

// Log request details for debugging
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']);
error_log("Raw POST Data: " . file_get_contents("php://input"));

// Verify request method
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid request method. Expected POST, got ' . $_SERVER['REQUEST_METHOD']
    ]);
    exit();
}

// Get and decode request body
$input = file_get_contents("php://input");
$data = json_decode($input, true);

// Validate input
if (!$data || !isset($data['id'])) {
    http_response_code(400);
    echo json_encode([
        'success' => false,
        'error' => 'Invalid input data',
        'received' => $input
    ]);
    exit();
}

$id = $data['id'];

try {
    // Start transaction
    $conn->begin_transaction();

    // Get resource details
    $stmt = $conn->prepare("SELECT * FROM resources WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Resource not found");
    }

    $resource = $result->fetch_assoc();

    // After deleting the resource
$insert = $conn->prepare("INSERT INTO deleted_resources (id, course_name, document_name, file_path, upload_date) VALUES (?, ?, ?, ?, ?)");
$insert->bind_param("issss", 
    $resource['id'],
    $resource['course_name'],
    $resource['document_name'],
    $resource['file_path'],
    $resource['upload_date']
);
    $insert->execute();

    // Delete from resources
    $delete = $conn->prepare("DELETE FROM resources WHERE id = ?");
    $delete->bind_param("i", $id);
    $delete->execute();

    // Commit transaction
    $conn->commit();

    echo json_encode([
        'success' => true,
        'message' => 'Resource successfully deleted'
    ]);

} catch (Exception $e) {
    // Rollback on error
    $conn->rollback();
    
    http_response_code(500);
    echo json_encode([
        'success' => false,
        'error' => $e->getMessage()
    ]);

} finally {
    // Close all statements
    if (isset($stmt)) $stmt->close();
    if (isset($insert)) $insert->close();
    if (isset($delete)) $delete->close();
    $conn->close();
}
?>