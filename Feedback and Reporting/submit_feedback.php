<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Use the correct input name from the form
    $feedback = isset($_POST['feedback_text']) ? $_POST['feedback_text'] : '';

    // Ensure feedback is not empty
    if (!empty($feedback)) {
        // Prepare and execute the insert query
        $query = "INSERT INTO feedback (feedback_text, status) VALUES (?, 'pending')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $feedback);

        if ($stmt->execute()) {
            // Redirect with a success message using JavaScript
            echo "<script>
                alert('Feedback submitted successfully!');
                window.location.href = 'user-report.php';
            </script>";
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        // Redirect with an error message using JavaScript
        echo "<script>
            alert('Feedback cannot be empty.');
            window.location.href = 'UserFeedbackReport.php';
        </script>";
    }
}

$conn->close();
?>

