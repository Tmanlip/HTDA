<?php
include 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

$username = $_SESSION['username'];
$usertype = $_SESSION['user_type'];

$stmt = $conn->prepare("SELECT matric_no FROM students WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Invalid username.");
}

$student_id = $student['matric_no'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forum</title>
    <link rel="stylesheet" href="forum.css">
    <!-- Boxicons CSS-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
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
                        <input id="search-input" type="text" placeholder="Search...">
                        <i class='bx bx-search' onclick="searchQuestions()"></i>
                    </div>                    
                    
                </div>
            </div>
        </div>
    </nav>

    <main>
        <div class="forum-container">
            <!-- Question Form -->
            <div class="question-form">
                <h2>Ask a Question</h2>
                <form id="questionForm">
                    <input type="text" id="question-title" name="title" placeholder="Title" required>
                    <textarea id="question-description" name="description" placeholder="Description" required></textarea>
                    <input type="text" id="question-tags" name="tags" placeholder="Tags (comma-separated)" required>
                    <input type="hidden" name="matric_no" value="<?php echo $student_id; ?>"> <!-- Replace with dynamic user ID if needed -->
                    <button type="submit">Post Question</button>
                </form>
            </div>
            <script src="postquestion.js"></script>

            <!-- Questions List -->
            <div class="questions-list">
                <h2>Forum</h2>
                <ul id="questions-list" >
                    <!-- Question items will be populated here by JavaScript -->
                </ul>
            </div>
        </div>
   
    </main>

    <script src="forum.js"></script>
</body>
</html>
