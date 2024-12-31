<?php
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Initialize an array to hold all analytics data
$response = array();

// Peer Collaborations
$sql = "SELECT s.matric_no AS student_id, COUNT(pc.id) as collaborations 
        FROM peer_collaborations pc 
        JOIN student s ON pc.student_id = s.matric_no
        GROUP BY s.matric_no";

$result = $conn->query($sql);
$collaborations = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $collaborations[] = $row;
    }
}
$response['collaborations'] = $collaborations;

// Forum Contributions
$sql = "SELECT s.matric_no AS student_id, COUNT(fc.id) as contributions 
        FROM forum_contributions fc 
        JOIN student s ON fc.student_id = s.matric_no
        GROUP BY s.matric_no";
$result = $conn->query($sql);
$contributions = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $contributions[] = $row;
    }
}
$response['contributions'] = $contributions;

// Merit Scores
$sql = "SELECT s.matric_no AS student_id, ms.merit_score 
        FROM merit_scores ms 
        JOIN student s ON ms.student_id = s.matric_no";
$result = $conn->query($sql);
$merit_scores = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $merit_scores[] = $row;
    }
}
$response['merit_scores'] = $merit_scores;

// Shared Resources
$sql = "SELECT s.matric_no AS student_id, COUNT(rs.id) as shared_resources 
        FROM resource_sharing rs 
        JOIN student s ON rs.student_id = s.matric_no     
        GROUP BY s.matric_no";
$result = $conn->query($sql);
$shared_resources = array();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $shared_resources[] = $row;
    }
}
$response['shared_resources'] = $shared_resources;

// Return all data as JSON
header('Content-Type: application/json');
echo json_encode($response);

$conn->close();
?>
