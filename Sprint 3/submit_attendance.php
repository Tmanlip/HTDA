<?php
include 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Include your database connection
include 'C:\xampp\htdocs\HiTDA\session_handler.php'; // Include session handler

// Get the username from the session
$username = $_SESSION['username']; 

// Get the student ID using the username
$stmt = $conn->prepare("SELECT matric_no, stud_name, email FROM students WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();
$student = $result->fetch_assoc();

if (!$student) {
    die("Invalid username.");
}

$student_id = $student['matric_no'];
$student_name = $student['stud_name'];
$student_email = $student['email'];

// Fetch the seminars the student is registered in
$seminarStmt = $conn->prepare("SELECT s.id, s.event_name, s.seminar_date, s.time, s.place, s.speaker, s.category, s.recurring FROM seminar s JOIN participation p ON s.id = p.seminar_id WHERE p.participant_id = ?");
$seminarStmt->bind_param("s", $student_id);
$seminarStmt->execute();
$seminarResult = $seminarStmt->get_result();
$seminars = [];

while ($seminar = $seminarResult->fetch_assoc()) {
    $seminars[] = $seminar;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Seminar Attendance</title>

    <link rel="stylesheet" href="event.css">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        const seminars = <?php echo json_encode($seminars); ?>; // Pass the seminars from PHP to JavaScript
        const studentName = "<?php echo $student_name; ?>"; // Pass student name from PHP
        const studentEmail = "<?php echo $student_email; ?>"; // Pass student email from PHP

        // Function to auto-fill the seminar details
        function autoFillSeminarDetails() {
            const selectedSeminarId = document.getElementById("seminarSelect").value;

            if (selectedSeminarId === "none") {
                document.getElementById("seminarDetails").innerHTML = "";
                return;
            }

            const selectedSeminar = seminars.find(seminar => seminar.id == selectedSeminarId);
            if (selectedSeminar) {
                document.getElementById("seminarDetails").innerHTML = `
                    <p><strong>Seminar:</strong> ${selectedSeminar.event_name}</p>
                    <p><strong>Date:</strong> ${selectedSeminar.seminar_date}</p>
                    <p><strong>Time:</strong> ${selectedSeminar.time}</p>
                    <p><strong>Place:</strong> ${selectedSeminar.place}</p>
                `;
            }
        }

        // Mark Attendance
        function markAttendance() {
            const selectedSeminarId = document.getElementById("seminarSelect").value;

            if (selectedSeminarId === "none") {
                alert("Please select a seminar.");
                return;
            }

            // Debugging: Log the data being sent
            console.log("Student Email: ", studentEmail);
            console.log("Selected Seminar ID: ", selectedSeminarId);

            // Send an AJAX request to update the attendance
            const xhr = new XMLHttpRequest();
            xhr.open("POST", "update.php", true);
            xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
            xhr.onload = function() {
                if (xhr.status === 200) {
                    const response = JSON.parse(xhr.responseText);
                    if (response.success) {
                        alert(`Attendance marked successfully for ${selectedSeminar.event_name}`);
                    } else {
                        alert("Error marking attendance: " + response.message);
                    }
                } else {
                    alert("Error with the request: " + xhr.status);
                }
            };

            // Send data to the server
            const data = `student_email=${encodeURIComponent(studentEmail)}&seminar_id=${encodeURIComponent(selectedSeminarId)}`;
            console.log("Data being sent: ", data);  // Debugging the data
            xhr.send(data);
        }


        // Set initial values for student fields
        window.onload = function() {
            document.getElementById("studentName").value = studentName;
            document.getElementById("studentEmail").value = studentEmail;
        }
    </script>
</head>
<body class="bg-blue-100 text-gray-900">

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

                <span class="logout"><a href="http://localhost/HiTDA/User%20Dashboard/logout.php" style="text-decoration: none;">Log Out</a></span>
            </div>
        </nav>

    <main>
    <div class="container mx-auto p-4">
        <h1 class="text-3xl font-bold text-center mb-6">Mark Your Seminar Attendance</h1>

        <!-- Attendance Form -->
        <div class="bg-white shadow-md rounded-lg p-6 max-w-lg mx-auto">
            <form id="studentAttendanceForm" onsubmit="event.preventDefault(); markAttendance();">
                <div class="mb-4">
                    <label for="studentName" class="block text-gray-700 font-bold mb-2">Name:</label>
                    <input type="text" id="studentName" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter your name" readonly />
                </div>

                <div class="mb-4">
                    <label for="studentEmail" class="block text-gray-700 font-bold mb-2">Email:</label>
                    <input type="email" id="studentEmail" class="w-full border border-gray-300 p-2 rounded" placeholder="Enter your email" readonly />
                </div>

                <div class="mb-4">
                    <label for="seminarSelect" class="block text-gray-700 font-bold mb-2">Select Seminar:</label>
                    <select id="seminarSelect" class="w-full border border-gray-300 p-2 rounded" onchange="autoFillSeminarDetails()">
                        <option value="none">-- Select a Seminar --</option>
                        <?php foreach ($seminars as $seminar): ?>
                            <option value="<?php echo $seminar['id']; ?>">
                                <?php echo $seminar['event_name']; ?> 
                                (<?php echo $seminar['seminar_date']; ?>, 
                                <?php echo $seminar['time']; ?>, 
                                <?php echo $seminar['place']; ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div id="seminarDetails" class="mb-4 text-gray-700"></div>

                <div class="text-center">
                    <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
                        Mark Attendance
                    </button>
                </div>
            </form>
        </div>
    </div>
    </main>

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
