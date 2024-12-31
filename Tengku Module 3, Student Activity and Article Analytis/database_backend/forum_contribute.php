<?php
// Include the database connection file
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

try {
    try {
        $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

   // Function to update forum_contributions for a student
    function updateForumContributions($conn, $matric_no, $question_id = null, $reply_id = null) {
        // Check if the student already has a record in the forum_contributions table
        $stmt = $conn->prepare("SELECT id FROM forum_contributions WHERE student_id = :matric_no AND (question_id = :question_id OR reply_id = :reply_id)");
        $stmt->bindParam(':matric_no', $matric_no);
        $stmt->bindParam(':question_id', $question_id);
        $stmt->bindParam(':reply_id', $reply_id);
        $stmt->execute();

        if ($stmt->rowCount() === 0) {
            // If no record is found, insert a new one
            $insertStmt = $conn->prepare("INSERT INTO forum_contributions (student_id, question_id, reply_id) VALUES (:matric_no, :question_id, :reply_id)");
            $insertStmt->bindParam(':matric_no', $matric_no);
            $insertStmt->bindParam(':question_id', $question_id);
            $insertStmt->bindParam(':reply_id', $reply_id);
            $insertStmt->execute();
        }
    }

    // Query questions with matric_no
    $questionsQuery = $conn->query("SELECT DISTINCT matric_no, id FROM questions WHERE matric_no IS NOT NULL");
    while ($row = $questionsQuery->fetch(PDO::FETCH_ASSOC)) {
        // Insert or update forum_contributions for students who posted questions
        updateForumContributions($conn, $row['matric_no'], $row['id']);
    }

    // Query replies with matric_no
    $repliesQuery = $conn->query("SELECT DISTINCT matric_no, id FROM replies WHERE matric_no IS NOT NULL");
    while ($row = $repliesQuery->fetch(PDO::FETCH_ASSOC)) {
        // Insert or update forum_contributions for students who posted replies
        updateForumContributions($conn, $row['matric_no'], null, $row['id']);
    }

    echo "Forum contributions updated successfully.";

} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

// Close the connection
$conn = null;
?>
