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

// Query to get all feedback
$feedback_query = "SELECT feedback.id, feedback.feedback_text, feedback.status, feedback.submission_date FROM feedback;";
$feedback_result = $conn->query($feedback_query);

// Handle feedback status update (if needed for non-AJAX)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $feedback_id = $_POST['feedback_id'];
    $new_status = $_POST['status'];

    // Update status in the database
    $update_query = "UPDATE feedback SET status = '$new_status' WHERE id = '$feedback_id'";

    if ($conn->query($update_query) === TRUE) {
        $message = "Feedback status updated successfully!";
    } else {
        $message = "Error updating status: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Feedback & Reporting</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <style>
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

        h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        .feedback-table {
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

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .action-buttons button {
            padding: 5px 10px;
            cursor: pointer;
            font-size: 14px;
        }

        .update-status {
            margin-top: 10px;
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
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sideBarOpen'></i>
            <span class="logo navLogo"><a href="#" style="color: white;">TutorXcells</a></span>
            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="#" style="color: white;">TutorXcells</a></span>
                    <i class='bx bx-x sideBarClosed'></i>
                </div>
                <ul class="nav-links">
                    <li><a href="AdminHome.html" style="color: white;">Home</a></li>
                    <li><a href="UserList.php" style="color: white;">User list</a></li>
                    <li><a href="TrackReport.phpp" style="color: white;">Feedback & Reporting</a></li>
                </ul>
            </div>
            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun'></i>
                </div>
                <a href="AdminLogin.php" class="logout-button" style="color: white;">Logout</a>
            </div>
        </div>
    </nav>

    <main>
        <div class="feedback-section">
            <h2>Manage Feedback and Report</h2>
            <?php if (isset($message)) { echo "<p class='message'>" . $message . "</p>"; } ?>
            <table class="feedback-table">
                <tr>
                    <th>Feedback</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
                <?php
                if ($feedback_result->num_rows > 0) {
                    while ($row = $feedback_result->fetch_assoc()) {
                        $status_class = strtolower(str_replace(' ', '-', $row['status']));
                        echo "<tr>";
                        echo "<td>" . htmlspecialchars($row['feedback_text']) . "</td>";
                        echo "<td class='status $status_class' id='status-".$row['id']."'>" . htmlspecialchars($row['status']) . "</td>";
                        echo "<td class='action-buttons'>";
                        ?>
                        <select name="status" id="status-select-<?php echo $row['id']; ?>" onchange="updateStatus(<?php echo $row['id']; ?>)">
                            <option value="Pending" <?php if ($row['status'] == 'Pending') echo 'selected'; ?>>Pending</option>
                            <option value="In Progress" <?php if ($row['status'] == 'In Progress') echo 'selected'; ?>>In Progress</option>
                            <option value="Resolved" <?php if ($row['status'] == 'Resolved') echo 'selected'; ?>>Resolved</option>
                        </select>
                        </td>
                        <?php
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='4'>No feedback available.</td></tr>";
                }
                ?>
            </table>
        </div>
    </main>

    <script>
        function updateStatus(feedbackId) {
            var status = document.getElementById('status-select-' + feedbackId).value;

            var xhr = new XMLHttpRequest();
            xhr.open("POST", "update_feedback_status.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");

            xhr.onreadystatechange = function() {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        // Update the status in the table
                        document.getElementById('status-' + feedbackId).innerText = status;
                        document.getElementById('status-' + feedbackId).className = 'status ' + status.toLowerCase().replace(" ", "-");
                    } else {
                        alert('Error updating status: ' + response.message);
                    }
                }
            };

            xhr.send("feedback_id=" + feedbackId + "&status=" + status);
        }
    </script>

</body>
</html>

<?php
$conn->close();
?>