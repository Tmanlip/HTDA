<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Collect data from form
    $name = $_POST['name'];
    $title = $_POST['title'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $content = $_POST['content'];
    $status = 'pending'; // Default status
    $summary = $_POST['summary'];
        

    // Handle file upload if an image is provided
    $image = null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $uploadDir = 'uploads\ ';
        $image = $uploadDir . basename($_FILES['image']['name']);
        move_uploaded_file($_FILES['image']['tmp_name'], $image);
    }

    // Prepare the article data
    $article = [
        "name" => $name,
        "title" => $title,
        "email" => $email,
        "content" => $content,
        "image" => $image,
        "status" => $status,
        "summary" => $summary
    ];

    // File path to the JSON file
$filePath = 'articles.json';

// Initialize an empty array to store articles
$data = [];

// Check if the file exists and load existing data
if (file_exists($filePath)) {
    $data = json_decode(file_get_contents($filePath), true);
}

// Generate a new ID
if (!empty($data)) {
    // If articles exist, determine the next available ID
    $maxId = max(array_column($data, 'id'));  // Find the highest ID
    $newId = $maxId + 1;  // Increment it for the next article
} else {
    // If no articles exist, start with ID 1
    $newId = 1;
}

// Add the new article with the generated ID
$article['id'] = $newId;
$data[] = $article;

// Save the updated data back to the JSON file
if (file_put_contents($filePath, json_encode($data, JSON_PRETTY_PRINT))) {
    echo "<script>
        alert('Article submitted successfully!');
        window.location.href = 'artcile.php'; // Replace with your redirect page
    </script>";
} else {
    echo "<script>
        alert('Failed to submit the article. Please try again.');
        window.location.href = 'artcile.php'; // Replace with your form page
    </script>";
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

        <!-- Boxicons CSS-->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <title>Responsive Navigation Menu Bar</title>
    </head>

    <body> 
        <nav>
            <div class="nav-bar">
                <i class='bx bx-menu sideBarOpen'></i>
                <span class="logo navLogo"><a href="#">TutorXcells</a></span>

                <div class="menu">
                    <div class="logo-toggle">
                        <span class="logo"><a href="#">TutorXcells</a></span>
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

                <span class="logout"><a href="logout.php" style="text-decoration: none;">Log Out</a></span>
            </div>
        </nav>

        <main>
            <div class="container">
                <h1>Submit Your Article</h1>
                <form action="artcile.php" method="POST" enctype="multipart/form-data">
                    <label for="name">Author:</label>
                    <input type="text" id="name" name="name" placeholder="Enter your full name" required>

                    <label for="email">Email Address:</label>
                    <input type="email" id="email" name="email" placeholder="Enter your email" required>

                    <label for="title">Article Title:</label>
                    <input type="text" id="title" name="title" placeholder="Enter the title for your articles" required>

                    <label for="content">Article Content:</label>
                    <textarea id="content" name="content" rows="10" placeholder="Write the articles content here..." required></textarea>

                    <label for="summary">Article Summary:</label>
                    <textarea id="summary" name="summary" rows="4" placeholder="Write a brief summary of the articles..." required></textarea>

                    <label for="image">Attach an Image (Optional):</label>
                    <input type="file" id="image" name="image" accept="image/*">
        
                    <button type="submit">Publish News</button>
                </form>
            </div>
        </main>

        <script src="https://cdn.tiny.cloud/1/1lo6fuafgrkww126kij1neyr2x1as5lalr8rdjlh5k2guh2r/tinymce/6/tinymce.min.js" referrerpolicy="origin"></script>

        <script src="artcie.js"></script>

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