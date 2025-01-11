<?php
// CORS headers
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");

include('connectPcDB.php'); // Correct database connection file

if (!isset($conn)) {
    echo json_encode(['success' => false, 'error' => 'Database connection not established.']);
}

// Debugging: Log the request method
error_log("Request Method: " . $_SERVER['REQUEST_METHOD']); // Log the request method

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read the input data
    $data = json_decode(file_get_contents("php://input"));

    // Debugging: Check what data is received
    if (is_null($data)) {
        echo json_encode(['success' => false, 'error' => 'No data received']);
        exit; // Stop execution if no data is received
    }

    $id = $data->id ?? null; // Use null coalescing operator to avoid undefined index notice

    // Debugging: Check if id is set
    if ($id === null) {
        echo json_encode(['success' => false, 'error' => 'ID not provided']);
        exit; // Stop execution if ID is not provided
    }

    // Step 1: Fetch the session data to be deleted
    $sqlFetch = "SELECT id, session_name, experience_level, time, location, max_participants, members FROM sessions WHERE id = ?";
    $stmtFetch = $conn->prepare($sqlFetch);
    $stmtFetch->bind_param("i", $id);
    $stmtFetch->execute();
    $result = $stmtFetch->get_result();

    // Check if the session exists
    if ($result->num_rows === 0) {
        echo json_encode(['success' => false, 'error' => 'Session not found.']);
        exit; // Stop execution if session is not found
    }

    // Fetch the session data
    $sessionData = $result->fetch_assoc();

    // Step 2: Insert the session data into the deleted_sessions table
    $sqlDelete = "INSERT INTO deleted_sessions (id, session_name, experience_level, time, location, max_participants, members) 
                  VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmtDelete = $conn->prepare($sqlDelete);
    $stmtDelete->bind_param("issssii", 
        $sessionData['id'], 
        $sessionData['session_name'], 
        $sessionData['experience_level'], 
        $sessionData['time'], 
        $sessionData['location'], 
        $sessionData['max_participants'], 
        $sessionData['members']
    );
    $stmtDelete->execute();

    // Step 3: Delete the session from the sessions table
    $sql = "DELETE FROM sessions WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => "Failed to delete session."]);
    }

    // Close the statements and connection
    $stmtFetch->close();
    $stmtDelete->close();
    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}

// Close the database connection
if (isset($conn)) {
    $conn->close();
}
?>