<?php
include 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Include your database connection
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

$username = $_SESSION['username']; // Use the username stored in the session

// Get the student ID using the username
$stmt = $conn->prepare("SELECT matric_no FROM students WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Invalid username.");
}

$student_id = $student['matric_no'];

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Retrieve form data
    $id = isset($_POST['id']) ? $_POST['id'] : null;
    $goal = $_POST['goal'];
    $progress = $_POST['progress'];
    $target_date = $_POST['target_date'];

    // Update or insert the progress data
    if ($id) {
        // Update existing progress
        $stmt = $conn->prepare("UPDATE student_progress SET goal = ?, progress = ?, target_date = ? WHERE matric_no = ? AND student_id = ?");
        $stmt->bind_param("sissi", $goal, $progress, $target_date, $id, $student_id);
    } else {
        // Insert new progress
        $stmt = $conn->prepare("INSERT INTO student_progress (student_id, goal, progress, target_date) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $student_id, $goal, $progress, $target_date);
    }

    if ($stmt->execute()) {
        echo "<p>Progress saved successfully!</p>";
    } else {
        echo "<p>Error: " . $stmt->error . "</p>";
    }

    $stmt->close();
}

// Fetch existing progress data
$stmt = $conn->prepare("SELECT id, goal, progress, target_date FROM student_progress WHERE student_id = ?");
$stmt->bind_param("s", $student_id);
$stmt->execute();
$result = $stmt->get_result();

$goals = [];
while ($row = $result->fetch_assoc()) {
    $goals[] = $row;
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

        <!-- CSS -->
        <link rel="stylesheet" href="reward.css">

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
            </div>
        </nav>

        
        <main>
            <h2>Your Goals and Progress</h2>
            <!-- Display existing goals and progress -->
            <div id="goals">
                <?php foreach ($goals as $goal): ?>
                    <div class="goal-item">
                        <h3>Goal: <?php echo htmlspecialchars($goal['goal']); ?></h3>
                        <div class="progress-bar">
                            <div style="width: <?php echo $goal['progress']; ?>%"><?php echo $goal['progress']; ?>%</div>
                        </div>
                        <p>Target Date: <?php echo $goal['target_date']; ?></p>
                        <button onclick="editGoal(<?php echo $goal['id']; ?>, '<?php echo htmlspecialchars($goal['goal']); ?>', <?php echo $goal['progress']; ?>, '<?php echo $goal['target_date']; ?>')">Edit</button>
                    </div>
                <?php endforeach; ?>
            </div>

            <form action="save_progress.php" method="POST">
                <h2>Edit your goals<h2>
                <input type="hidden" name="id" id="id"> <!-- Add this hidden field to store the goal ID -->    
                <input type="hidden" name="matric_no" id="matric_no" value="<?php echo htmlspecialchars($student_id); ?>">
                <label for="goal">Goal</label>
                <textarea id="goal" name="goal" required></textarea>
        
                <label for="progress">Progress (%)</label>
                <input type="number" id="progress" name="progress" min="0" max="100" required>
        
                <label for="target_date">Target Date</label>
                <input type="date" id="target_date" name="target_date" required>
        
                <button type="submit">Save Progress</button>
            </form>
            
    <script>
    // Function to fill the form with existing goal data for editing
    function editGoal(id, goal, progress, target_date) {
        document.getElementById('id').value = id; // Set the goal ID
        document.getElementById('goal').value = goal; // Set the goal text
        document.getElementById('progress').value = progress; // Set the progress value
        document.getElementById('target_date').value = target_date; // Set the target date
    }

    </script>
    <script src="rw.js"></script>

<!-- <footer>
    <div class="content">
        <div class="top">
            <div class="logo-details">
                <img src="Logo-UTM-white.png" alt="UTM Logo" class="footer-image">
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
