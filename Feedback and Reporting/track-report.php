<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

// Query to get all feedback
$feedback_query = "SELECT feedback.id, feedback.feedback_text, feedback.status, feedback.submission_date FROM `feedback`;";
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
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

        <!-- CSS -->
        <link rel="stylesheet" href="report.css">

        <!-- Boxicons CSS-->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <title>Responsive Navigation Menu Bar</title>
    </head>

    <body>
        <nav>
            <div class="nav-bar">
                <i class='bx bx-menu sideBarOpen'></i>
                <span class="logo navLogo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php">TutorXcells</a></span>

                <div class="menu">
                    <div class="logo-toggle">
                        <span class="logo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php">TutorXcells</a></span>
                        <i class='bx bx-x sideBarClosed'></i>
                    </div>

                    <ul class="nav-links">
                        <li><a href="http://localhost/HiTDA/Administrative%20Dashboard/UserList.php">User list</a></li>
                        <li><a href="http://localhost/HiTDA/Module%203/rewards.php">Student Activity</a></li>
                        <li><a href="http://localhost/HiTDA/Module%203/engagement.php">Article Engagement</a></li>
                    </ul>
                </div>

                <div class="darkLight-searchBox">
                    <div class="dark-light">
                        <i class='bx bx-moon moon'></i>
                        <i class='bx bx-sun sun' ></i>
                    </div>

                    <div class="searchBox">
                        <div class="searchToggle">
                            <i class='bx bx-x cancel'></i>
                            <i class='bx bx-search search'></i>
                        </div>

                        <div class="search-field">
                            <input type="text" placeholder="Search...">
                            <i class='bx bx-search'></i>
                        </div>
                    </div>
                </div>
                <span class="logout"><a href="logout.php" style="text-decoration: none;">Log Out</a></span>
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

        <script src="report.js"></script>

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

        <!-- <footer>
            <div class="content">
                <div class="top">
                    <div class="logo-details">
                        <img src="http://localhost/HiTDA/Module%201/Logo-UTM-white.png" alt="UTM Logo" class="footer-image">
                    </div>

                    <div class="media-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </div>

                <div class="link-boxes">
                    <ul class="box">
                        <li class="link_name">University Teknology Malaysia</li>
                        <li><a href=#>Home</a></li>
                        <li><a href=#>About</a></li>
                        <li><a href=#>Portfolio</a></li>
                        <li><a href=#>Event</a></li>
                        <li><a href=#>Profile</a></li>
                    </ul>

                    <ul class="box">
                        <li class="link_name">Faculty of Computing</li>
                        <li><a href=#>Home</a></li>
                        <li><a href=#>About</a></li>
                    </ul>

                    <ul class="box">
                        <li class="link_name">PERSAKA</li>
                        <li><a href=#>Home</a></li>
                        <li><a href=#>About</a></li>
                        <div class="media-icons">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                            <a href="#"><i class="fab fa-youtube"></i></a>
                        </div>
                    </ul>

                    <ul class="box">
                        <li class="link_name">Community</li>
                        <li><a href=#>Forum</a></li>
                        <li><a href=#>Repositories</a></li>
                    </ul>
                </div>
            </div>

            <div class="bottom-details">
                <div class="bottom_text">
                    <span class="copyright_text">Copyright &#169; 2024 <a href="#">Universiti Teknologi Malaysia.</a> All right reserved</span>
                    <span class="policy_terms">
                        <a href="#">Privacy Policy</a>
                        <a href="#">Terms and Conditions</a>
                    </span>
                </div>
            </div>
        </footer> -->
    </body>
</html>