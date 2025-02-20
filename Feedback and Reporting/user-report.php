<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

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
                <span class="logo navLogo"><a href="http://localhost/HiTDA/User%20Dashboard/StudentDashboard.php">TutorXcells</a></span>

                <div class="menu">
                    <div class="logo-toggle">
                        <span class="logo"><a href="http://localhost/HiTDA/User%20Dashboard/StudentDashboard.php">TutorXcells</a></span>
                        <i class='bx bx-x sideBarClosed'></i>
                    </div>

                    <ul class="nav-links">
                        <li><a href="#">About</a></li>
                        <li><a href="#">Portfolio</a></li>
                        <li><a href="#">Event</a></li>
                        <li><a href="#">Profile</a></li>
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
                    <table class="feedback-table">
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
        </main>
        <script src="report.js"></script>

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