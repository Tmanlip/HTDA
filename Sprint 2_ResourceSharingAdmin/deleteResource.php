<?php
include('connectResourceDB.php');

// Read the input data
$data = json_decode(file_get_contents("php://input"), true);

// Debugging: Check what data is received
if (is_null($data)) {
    echo json_encode(['success' => false, 'error' => 'No data received']);
    exit; // Stop execution if no data is received
}

$id = $data['id'] ?? null; // Use null coalescing operator to avoid undefined index notice

// Debugging: Check if id is set
if ($id === null) {
    echo json_encode(['success' => false, 'error' => 'ID not provided']);
    exit; // Stop execution if ID is not provided
}

// Prepare the SQL query to fetch the resource before deletion
$fetchSql = "SELECT course_name, document_name, file_path, upload_date FROM resources WHERE id = ?";
$fetchStmt = $conn->prepare($fetchSql);
$fetchStmt->bind_param("i", $id);
$fetchStmt->execute();
$result = $fetchStmt->get_result();

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    // Prepare the SQL query to delete the resource
    $sql = "DELETE FROM resources WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        // Log the deleted resource to the deleted_resources table
        $logSql = "INSERT INTO deleted_resources (course_name, document_name, file_path, upload_date)
                    VALUES (?, ?, ?, ?)";
        $logStmt = $conn->prepare($logSql);
        $upload_date = $row['upload_date']; // Get the upload date from the fetched row
        $logStmt->bind_param("ssss", $row['course_name'], $row['document_name'], $row['file_path'], $upload_date);
        $logStmt->execute();

        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    // Close the log statement
    if (isset($logStmt)) {
        $logStmt->close();
    }
} else {
    // Resource not found, return an error message
    echo json_encode(['success' => false, 'error' => 'Resource not found']);
}

// Close the fetch statement
$fetchStmt->close();

// Close the delete statement if it was created
if (isset($stmt)) {
    $stmt->close();
}

// Close the database connection
$conn->close();
?>