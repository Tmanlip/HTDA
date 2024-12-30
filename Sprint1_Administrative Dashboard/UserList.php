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

// Query to get students and lecturers
$students_query = "SELECT * FROM users WHERE role = 'Student'";
$lecturers_query = "SELECT * FROM users WHERE role = 'Lecturer'";

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

    <style>
        /* Your inline styles go here */
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

                <a href="AdminLogin.html" class="logout-button" style="color: white;">Logout</a>
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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    if ($students_result->num_rows > 0) {
                        while ($row = $students_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['course_or_department']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<a href='EditUser.php?id=" . htmlspecialchars($row['id']) . "'><button class='edit-btn'>Edit</button></a>";
                            echo "<a href='deleteUser.php?id=" . htmlspecialchars($row['id']) . "'><button class='delete-btn'>Delete</button></a>";
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
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                    <?php
                    if ($lecturers_result->num_rows > 0) {
                        while ($row = $lecturers_result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['name']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['email']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['course_or_department']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['status']) . "</td>";
                            echo "<td class='action-buttons'>";
                            echo "<a href='EditUser.php?id=" . htmlspecialchars($row['id']) . "'><button class='edit-btn'>Edit</button></a>";
                            echo "<a href='deleteUser.php?id=" . htmlspecialchars($row['id']) . "'><button class='delete-btn'>Delete</button></a>";
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

<?php
$conn->close();
?>
