<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

// Query to get students and lecturers 
$students_query = "SELECT * FROM students";
$lecturers_query = "SELECT * FROM lecturers";

$students_result = $conn->query($students_query);
$lecturers_result = $conn->query($lecturers_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Responsive Navigation Menu Bar</title>

    <!-- CSS -->
    <link rel="stylesheet" href="AdminDashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
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
                    <li><a href="http://localhost/HiTDA/Feedback%20and%20Reporting/track-report.php">Feedback & Reporting</a></li>
                    <li><a href="http://localhost/HiTDA/Module%203/rewards.php">Student Activity</a></li>
                    <li><a href="http://localhost/HiTDA/Module%203/engagement.php">Article Engagement</a></li>
                </ul>
            </div>

            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun'></i>
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

                <a href="AdminLogin.html" class="logout-button"">Logout</a>
            </div>
        </div>
    </nav>

    <main>
        <!-- User List Section -->
        <div class="user-list">
            <h2>User List</h2>

            <!-- Student List -->
            <div class="user-category">
                <h3>Students</h3>
                <table class="user-table">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Course</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        if ($students_result->num_rows > 0) {
                            while ($row = $students_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['stud_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['course']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['last_login']) . "</td>";
                                echo "<td class='action-buttons'>";
                                // Edit form
                                echo "<form action='EditUser.php' method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['matric_no']) . "'>";
                                echo "<input type='hidden' name='table' value='student'>";
                                echo "<button type='submit' class='edit-btn'>Edit</button>";
                                echo "</form>";
                                
                                // Delete form
                                echo "<form action='deleteUser.php' method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['matric_no']) . "'>";
                                echo "<input type='hidden' name='table' value='student'>"; // Change 'student' to 'lecturer' dynamically as needed
                                echo "<button type='submit' class='delete-btn'>Delete</button>";
                                echo "</form>";
                                
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                </table>
            </div>

            <!-- Lecturer List -->
            <div class="user-category">
                <h3>Lecturers</h3>
                <table class="user-table">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Department</th>
                        <th>Last Login</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                        if ($lecturers_result->num_rows > 0) {
                            while ($row = $lecturers_result->fetch_assoc()) {
                                echo "<tr>";
                                echo "<td>" . htmlspecialchars($row['lect_name']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['subject_teached']) . "</td>";
                                echo "<td>" . htmlspecialchars($row['last_login']) . "</td>";
                                echo "<td class='action-buttons'>";
                                // Edit form
                                echo "<form action='EditUser.php' method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['employee_no']) . "'>";
                                echo "<input type='hidden' name='table' value='lecturer'>";
                                echo "<button type='submit' class='edit-btn'>Edit</button>";
                                echo "</form>";
                                
                                // Delete form
                                echo "<form action='deleteUser.php' method='POST' style='display:inline;'>";
                                echo "<input type='hidden' name='id' value='" . htmlspecialchars($row['employee_no']) . "'>";
                                echo "<input type='hidden' name='table' value='lecturer'>"; // Change 'student' to 'lecturer' dynamically as needed
                                echo "<button type='submit' class='delete-btn'>Delete</button>";
                                echo "</form>";
                                
                                echo "</td>";
                                echo "</tr>";
                            }
                        }
                        ?>
                </table>
            </div>
        </div>
    </main>
    <script src="AdminScript.js"></script>
</body>
</html>

