<?php
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

    // Restrict access to students
if ($_SESSION['user_type'] !== 'student') {
    header("Location: login.php"); // Redirect to an unauthorized access page
    exit();
}

$username = $_SESSION['username'];

// Fetch student information including course code
$stmt = $conn->prepare("SELECT stud_name, matric_no, course, course_code, email, phone_number, image_data FROM students WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$stmt->bind_result($name, $matricNo, $course, $courseCode, $email, $phoneNumber, $image);
$stmt->fetch();
$stmt->close();

    // Fetch student details
    $stmt = $conn->prepare("SELECT matric_no FROM students WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        // If student
        $stmt->bind_result($userId);
        $stmt->fetch();
        $isStudent = true;
        $userIdField = 'matric_no';
    } else {
        // Not a student, redirect to login
        header("Location: login.php");
        exit();
    }

    // Fetch the seminar history for the student
    $query = "SELECT s.event_name, s.seminar_date, s.description, s.place, p.status
            FROM seminar s
            JOIN participation p ON s.id = p.seminar_id
            WHERE p.participant_id = ? AND p.role = 'student'
            ORDER BY s.seminar_date DESC";

    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $userId);
    $stmt->execute();
    $stmt->bind_result($title, $date, $description, $location, $status);
?>


<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

        <!-- CSS -->
        <link rel="stylesheet" href="userdashboard.css">

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
                        <li><a href="http://localhost/HiTDA/Knowledge%20Forum/forum.php">Forum</a></li>
                        <li><a href="http://localhost/HiTDA/Article/disparticle.php">Article</a></li>
                        <li><a href="http://localhost/HiTDA/Website%20Analytics/update.php">Goals</a></li>
                        <li><a href="http://localhost/HiTDA/Sprint%203/submit_attendance.php">Mark Attendance</a></li>
                        <li><a href="http://localhost/HiTDA/Sprint%202/eventPage.php">Events</a></li>
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
            <div class="first-box">
                <p>Profile</p>

                <div class="profile-cont">
                    <!-- Display Profile Image -->
                    <?php if ($image): ?>
                        <img src="data:image/jpeg;base64,<?php echo base64_encode($image); ?>" alt="Profile Image" class="profile-image">
                    <?php else: ?>
                    <!-- Default Profile Icon if No Image is Set -->
                        <i class='bx bx-user-circle prof'></i>
                    <?php endif; ?> 
                </div>

                <div class="icon-box">
                    <div class="home">
                        <i class='bx bx-home-alt-2 prof'></i>
                        <span class="prof-text">Dashboard</span>
                    </div>
    
                    <div class="home-2">
                        <i class='bx bx-user usr'></i>
                        <span class="usr-text">User</span>
                    </div>

                    <div class="home-3">
                        <i class='bx bx-history history'></i>
                        <span class="history-text">History</span>
                    </div>

                    <div class="home-4">
                        <i class='bx bx-edit edit'></i>
                        <span class="edit-text">Report</span>
                    </div>

                    <div class="home-5">
                        <i class='bx bx-group group'></i>
                        <span class="edit-text">Group</span>
                    </div>

                    <div class="home-6">
                    <i class='bx bx-hdd hdd'></i>
                        <span class="edit-text">Resource</span>
                    </div>
                </div>
            </div>

            <div class="second-big-box">
                    <div class="small-first-box">
                    <div class="first-items displayed">
                        <i class='bx bx-home-alt-2 prof-2'></i>
                        <span class="prof-2-text">Dashboard</span>
                    </div>
                        
                    <div class="second-items hidden">
                        <i class='bx bx-user usr-2'></i>
                        <span class="usr-text usr-2-text">User</span>
                    </div>
    
                    <div class="third-items hidden">
                        <i class='bx bx-history'></i>
                        <span class="usr-text history-text">History</span>
                    </div>
                </div>
    
                <div class="big-first-box">
                    <div class="one-box-dash">
                        <!-- Students-->
                        <p>Welcome to TutorXcells</p>
                        <ul>
                            <li>This is a platform for students to gain notes or exercise to the course</li>
                            <li>There is also seminars or academic events that will be advertise later by PERSAKA</li>
                        </ul>
                    </div>
        
                    <div class="two-box-dash">
                        <p>Announcement</p>
                        <div class="announcement-content">
                            <p>📢 <strong>Important Update:</strong> Our new tutoring sessions start on November 1st. Register now to secure your spot!</p>
                            <p>📅 <strong>Upcoming Event:</strong> Join us for a workshop on 'Effective Study Techniques' on November 5th.</p>
                            <p>🔔 <strong>Reminder:</strong> Mid-term evaluations are due by the end of this week. Please submit them through the portal.</p>
                        </div>
                    </div>
    
                    <div class="one-box-usr hidden">
                        <p>STUDENT'S INFORMATION</p>
    
                        <div class="info">
                            <div class="info-box">
                                <p><strong>NAME: </strong><?php echo htmlspecialchars($name); ?></p>
                            </div>
                            <div class="info-box">
                                <p><strong>MATRIC NUMBER: </strong><?php echo htmlspecialchars($matricNo); ?></p>
                            </div>
                            <div class="info-box">
                                <p><strong>COURSE: </strong><?php echo htmlspecialchars($course); ?></p>
                            </div>
                            <div class="info-box">
                                <p><strong>COURSE CODE: </strong><?php echo htmlspecialchars($courseCode); ?></p>
                            </div>
                            <div class="info-box">
                                <p><strong>EMAIL: </strong><?php echo htmlspecialchars($email); ?></p>
                            </div>
                            <div class="info-box">
                                <p><strong>PHONE NUMBER: </strong><?php echo htmlspecialchars($phoneNumber); ?></p>
                            </div>
                        </div>    
                    </div>
    
                    <div class="one-box-hist hidden">
                        <p>HISTORY</p>
                        <div class="seminar-history">
                            <?php while ($stmt->fetch()): ?>
                                <div class="seminar-record">
                                <h4><?php echo htmlspecialchars($title); ?></h4>
                                <p><strong>Date:</strong> <?php echo htmlspecialchars($date); ?></p>
                                <p><strong>Location:</strong> <?php echo htmlspecialchars($location); ?></p>
                                <p><strong>Description:</strong> <?php echo htmlspecialchars($description); ?></p>
                                <p><strong>Status:</strong> <?php echo htmlspecialchars($status); ?></p>
                                </div>
                            <?php endwhile; ?>
        
                            <?php if ($stmt->num_rows == 0): ?>
                                <p>No seminars found in your history.</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="third-box">

            </div>
        </main>

        <script src="script.js"></script>

        <footer>
            <div class="content">
                <div class="top">
                    <div class="logo-details">
                        <img src="http://localhost/HiTDA/Module%201/upload/Logo-UTM-white.png" alt="UTM Logo" class="footer-image">
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
        </footer>
    </body>
</html>