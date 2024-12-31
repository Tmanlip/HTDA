<?php
// Include the database connection file
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

try {
    // Establishing the database connection
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Function to update the resource_sharing table
    function updateResourceSharing($conn, $matric_no, $resource_id) {
        // Check if the student already has a record in the resource_sharing table for this resource
        $stmt = $conn->prepare("SELECT id FROM resource_sharing WHERE student_id = :matric_no AND resource_id = :resource_id");
        $stmt->bindParam(':matric_no', $matric_no);
        $stmt->bindParam(':resource_id', $resource_id);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // If no record is found, insert a new one
            $insertStmt = $conn->prepare("INSERT INTO resource_sharing (student_id, resource_id) VALUES (:matric_no, :resource_id)");
            $insertStmt->bindParam(':matric_no', $matric_no);
            $insertStmt->bindParam(':resource_id', $resource_id);
            $insertStmt->execute();
        }
    }

    // Query the resources table to find resources linked to students
    $resourcesQuery = $conn->query("SELECT id, matric_no FROM resources WHERE matric_no IS NOT NULL");
    while ($row = $resourcesQuery->fetch(PDO::FETCH_ASSOC)) {
        // Insert or update resource_sharing for students who have been linked to a resource
        updateResourceSharing($conn, $row['matric_no'], $row['id']);
    }

    // Query the resources table for lecturer-uploaded resources (if needed)
    $lecturerResourcesQuery = $conn->query("SELECT id, matric_no FROM resources WHERE employee_no IS NOT NULL");
    while ($row = $lecturerResourcesQuery->fetch(PDO::FETCH_ASSOC)) {
        // Insert or update resource_sharing for students linked to lecturer-uploaded resources
        updateResourceSharing($conn, $row['matric_no'], $row['id']);
    }

    echo "Resource sharing updated successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
