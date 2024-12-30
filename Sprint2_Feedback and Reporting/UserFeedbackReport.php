<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "tutorxcells";

$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle feedback submission
$message = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit_feedback'])) {
    // Use the correct key: feedback_text
    $feedback_text = isset($_POST['feedback_text']) ? $conn->real_escape_string($_POST['feedback_text']) : '';

    if (!empty($feedback_text)) {
        // Insert feedback into the database
        $sql = "INSERT INTO feedback (feedback_text, status, submission_date) VALUES ('$feedback_text', 'pending', NOW())";
        if ($conn->query($sql) === TRUE) {
            $message = "Feedback submitted successfully!";
        } else {
            $message = "Error: " . $conn->error;
        }
    } else {
        $message = "Feedback cannot be empty.";
    }
}

// Query to get all feedback data
$feedback_query = "SELECT feedback_text, status, submission_date FROM feedback";
$feedback_result = $conn->query($feedback_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback & Reporting</title>

    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: maroon;
            margin: 0;
            padding: 0;
        }

        .feedback-section {
            width: 80%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2, h3 {
            text-align: center;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        textarea {
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            resize: vertical;
            font-size: 14px;
            color: #333;
        }

        button[type="submit"] {
            background-color: #4CAF50;
            color: white;
            border: none;
            padding: 10px 15px;
            font-size: 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        button[type="submit"]:hover {
            background-color: #45a049;
        }

        .feedback-status {
            margin-top: 30px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: left;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        th {
            background-color: #f4f4f4;
        }

        .status {
            padding: 5px;
            border-radius: 5px;
            text-align: center;
        }

        .pending {
            background-color: red;
            color: white;
        }

        .in-progress {
            background-color: orange;
            color: white;
        }

        .resolved {
            background-color: green;
            color: white;
        }

        .message {
            color: green;
            text-align: center;
            font-size: 16px;
            margin-top: 15px;
        }

        .message.error {
            color: red;
        }

    </style>
</head>

<body>
    <main>
       <div class="feedback-section">
            <h2>Submit Your Feedback and Report</h2>
            
            <!-- Feedback Submission Form -->
            <form method="POST" action="submit_feedback.php">
        <textarea name="feedback_text" required placeholder="Enter your feedback..."></textarea>
        <button type="submit">Submit Report</button>
    </form>

            <!-- Message Display -->
            <?php if (!empty($message)) { ?>
                <p class="message <?php echo (strpos($message, 'Error') !== false) ? 'error' : ''; ?>">
                    <?php echo htmlspecialchars($message); ?>
                </p>
            <?php } ?>

            <!-- Feedback Status Table -->
            <div class="feedback-status">
                <h3>Feedback and Report Status</h3>
                <table>
                    <tr>
                        <th>Feedback</th>
                        <th>Status</th>
                        <th>Submission Date</th>
                    </tr>
                     <?php
                    if ($feedback_result && $feedback_result->num_rows > 0) {
                        while ($row = $feedback_result->fetch_assoc()) {
                            $status_class = strtolower(str_replace(' ', '-', $row['status']));
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['feedback_text']) . "</td>";
                            echo "<td class='status $status_class'>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['submission_date']) . "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='3'>No feedback submitted yet.</td></tr>";
                    }
                    ?>
                </table>
            </div>
        </div>
		
		<!-- hgbngh
		jhggj
		kbugyjhkj
		kubyhy -->
    </main>
</body>
</html>

<?php
$conn->close();
?>
