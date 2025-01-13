<?php
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
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
  <title>Resource Sharing Module</title>
  <link rel="stylesheet" href="resourceSharing.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
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
                    <li><a href="#">Home</a></li>
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
                  <input type="text" placeholder="Search materials..." class="search-bar">
                <i class='bx bx-search'></i>
            </div>
          </div>
      </div>

      <span class="logout"><a href="http://localhost/HiTDA/User%20Dashboard/logout.php" style="text-decoration: none;">Log Out</a></span>
    </div>
  </nav>

  <main class="main-content">

    <!-- Categories Section -->
    <section class="categories">
      <button class="category-btn">All</button>
      <button class="category-btn">Computational Mathematics</button>
      <button class="category-btn">Digital Logic</button>
      <button class="category-btn">Programming Techniques</button>
    </section>

    <!-- Upload Material Section -->
    <section id="upload-section" class="upload-section">
      <h2>Upload Material</h2>
      <form action="uploadResource.php" method="POST" enctype="multipart/form-data">
        <label for="course">Select Course:</label>
        <select name="course" id="course" required>
          <option value="Computational Mathematics">Computational Mathematics</option>
          <option value="Digital Logic">Digital Logic</option>
          <option value="Programming Techniques">Programming Techniques</option>
        </select><br><br>

        <label for="file">Select document to upload:</label>
        <input type="file" name="file" id="file" required><br><br>

        <button type="submit" name="submit" class="upload-btn">Upload Document</button>
      </form>
    </section>

    <!-- Shared Folders Section -->

    <div class="shared-folders">
      <h2>Shared Resources</h2>
      <ul id="shared-folders" >

      </ul>

          <!-- Shared folders items will be populated here by JavaScript -->
    </div>
  

  </main>

  <script src="rs.js"></script>
  <script src="dynamicdisplay.js"></script>

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
