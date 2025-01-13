<?php

header('Content-Type: application/json');

// Include your database connection
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Check if the POST data exists
    if (isset($_POST['matric_no'], $_POST['title'], $_POST['description'], $_POST['tags'])) {
        // Fetch matric_no, title, description, and tags from the form (submitted via POST)
        $matric_no = $_POST['matric_no'];
        $title = $_POST['title'];
        $description = $_POST['description'];
        $tags = $_POST['tags'];

        // Insert the question into the questions table
        $stmt = $pdo->prepare("INSERT INTO questions (matric_no, title, description, tags) 
                               VALUES (:matric_no, :title, :description, :tags)");

        // Execute the query and check for success
        if ($stmt->execute([
            'matric_no' => $matric_no,
            'title' => $title,
            'description' => $description,
            'tags' => $tags
        ])) {
            // Get the ID of the inserted question
            $question_id = $pdo->lastInsertId();

            // Insert into forum_contributions table
            $stmt_contrib = $pdo->prepare("INSERT INTO forum_contributions (student_id, question_id, reply_id) 
                                          VALUES (:student_id, :question_id, :reply_id)");

            // Insert the student_id, question_id, and NULL for reply_id (since it's a question)
            if ($stmt_contrib->execute([
                'student_id' => $matric_no,
                'question_id' => $question_id,
                'reply_id' => NULL
            ])) {
                // Return a success message in JSON format
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Question posted and contribution recorded successfully!'
                ]);
            } else {
                // If the forum_contributions insert failed
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to record forum contribution.'
                ]);
            }
        } else {
            // If the question insert failed
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to post the question.'
            ]);
        }
    } else {
        // If the required POST data is missing
        echo json_encode([
            'status' => 'error',
            'message' => 'Required fields are missing.'
        ]);
    }

} catch (PDOException $e) {
    // Catch and return any database connection errors
    echo json_encode([
        'status' => 'error',
        'message' => 'Database error: ' . $e->getMessage()
    ]);
}
?>
