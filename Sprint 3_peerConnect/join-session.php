<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pconnect_db";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed: ' . $conn->connect_error]));
}

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);
$sessionId = $data['session_id'] ?? null;

if ($sessionId) {
    // Start transaction
    $conn->begin_transaction();
    
    try {
        // Check if session exists and has space
        $checkStmt = $conn->prepare("SELECT members, max_participants FROM sessions WHERE id = ?");
        $checkStmt->bind_param("i", $sessionId);
        $checkStmt->execute();
        $result = $checkStmt->get_result();
        $session = $result->fetch_assoc();
        
        if (!$session) {
            throw new Exception('Session not found');
        }
        
        if ($session['members'] >= $session['max_participants']) {
            throw new Exception('Session is full');
        }
        
        // Update members count
        $updateStmt = $conn->prepare("UPDATE sessions SET members = members + 1 WHERE id = ?");
        $updateStmt->bind_param("i", $sessionId);
        $updateStmt->execute();
        
        if ($updateStmt->affected_rows === 0) {
            throw new Exception('Failed to update session');
        }
        
        // Commit transaction
        $conn->commit();
        
        // Fetch updated sessions
        $sessions = $conn->query("SELECT * FROM sessions")->fetch_all(MYSQLI_ASSOC);
        
        echo json_encode(['success' => true, 'sessions' => $sessions]);
    } catch (Exception $e) {
        $conn->rollback();
        echo json_encode(['success' => false, 'message' => $e->getMessage()]);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid session ID']);
}

$conn->close();
?>