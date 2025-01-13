<?php
include 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';
$username = $_SESSION['username'];
$usertype = $_SESSION['user_type'];

// Initialize variables for pre-filling
$name = $email = "";

// Fetch data from the students table based on the logged-in username
if ($usertype === 'student') {
    $stmt = $conn->prepare("SELECT stud_name, email FROM students WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->bind_result($name, $email);
    $stmt->fetch();
    $stmt->close();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from form
    $name = $_POST['name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $content = $_POST['content'];
    $status = 'pending'; // Default status
    $summary = $_POST['summary'];
    $tags = isset($_POST['tags']) ? $_POST['tags'] : '';


    $tagsJson = json_encode(explode(',', $tags)); // Convert tags to JSON format

    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads/'; // Use forward slash for cross-platform compatibility
        $image = $uploadDir . basename($_FILES['image']['name']);
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $image)) {
            die("Failed to upload the image.");
        }
    }

    // Prepare SQL query to insert data into the database
    $sql = "INSERT INTO article (name, title, email, tags, content, image, status, summary)
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
    die("Error preparing the statement: " . $conn->error);
    }

    $stmt->bind_param(
        "ssssssss", 
        $name, 
        $title, 
        $email, 
        $tagsJson, 
        $content, 
        $image, 
        $status, 
        $summary
    );

    // Execute the query
    if ($stmt->execute()) {
        echo "Article submitted successfully!";
        echo "<script>
            alert('Article submitted successfully!');
            window.location.href = 'artcile.php'; // Replace with your redirect page
        </script>";
    } else {
        echo "Error: " . $stmt->error;
    }

    $mail = new PHPMailer(true);

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'tengku03@graduate.utm.my'; // Your Gmail address
        $mail->Password = '1LoveMy5eLF';    // Your App Password (if 2FA)
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
    
        // Recipients
        $mail->setFrom('tengku03@graduate.utm.my', 'Admin Team');
        $mail->addAddress($email, $name); // Recipient email and name
    
        // Content
        $mail->isHTML(true);
        $mail->Subject = "Article Submission Status: $status";
        $mail->Body    = "Dear $name,<br><br>Thank you for submitting your article titled <b>'$title'</b>.<br><br>Status: <b>$status</b><br><br>Best regards,<br>Admin Team";
        $mail->AltBody = "Dear $name,\n\nThank you for submitting your article titled '$title'.\n\nStatus: $status\n\nBest regards,\nAdmin Team";
    
        // Send the email
        $mail->send();
        echo "Email notification sent to $email.";
    } catch (Exception $e) {
        echo "Failed to send email notification. Error: {$mail->ErrorInfo}";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
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
        <link rel="stylesheet" href="artcile.css">

        <!-- Dependencies for Tagify -->
        <link href="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.css" rel="stylesheet">

        <!-- Dependencies for TinyMCE -->
        <script src="https://cdn.tiny.cloud/1/1lo6fuafgrkww126kij1neyr2x1as5lalr8rdjlh5k2guh2r/tinymce/6/tinymce.min.js"></script>

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
                            <input type="text" placeholder="Search...">
                            <i class='bx bx-search'></i>
                        </div>
                    </div>
                </div>

                <span class="logout"><a href="http://localhost/HiTDA/User%20Dashboard/logout.php" style="text-decoration: none;">Log Out</a></span>
            </div>
        </nav>

        <main>
            <div class="container">
                <h1>Submit Your Article</h1>
                <form action="artcile.php" method="POST" enctype="multipart/form-data">
                <label for="name">Author:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" value="<?php echo htmlspecialchars($name); ?>" required>

                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" value="<?php echo htmlspecialchars($email); ?>" required>

                    <label for="tags">Select Tags:</label>
                    <input id="tags" name="tags" placeholder="Choose tags...." required>

                    <label for="title">Article Title:</label>
                    <input type="text" id="title" name="title" placeholder="Enter the title for your articles" required>

                    <label for="content">Article Content:</label>
                    <textarea id="content" name="content" rows="10" placeholder="Write the articles content here..." required></textarea>

                    <label for="summary">Article Summary:</label>
                    <textarea id="summary" name="summary" rows="4" placeholder="Write a brief summary of the articles..." required></textarea>

                    <label for="image">Attach an Image (Optional):</label>
                    <input type="file" id="image" name="image" accept="image/*">
        
                    <button type="submit">Publish Articles</button> 
                </form>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/@yaireo/tagify/dist/tagify.min.js"></script>

        <script src="artcie.js" defer></script>

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