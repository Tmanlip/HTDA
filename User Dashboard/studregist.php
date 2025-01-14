<?php
// Include necessary files
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect and sanitize input
    $matric_no = $conn->real_escape_string($_POST['matric_no']);
    $stud_name = $conn->real_escape_string($_POST['stud_name']);
    $course = $conn->real_escape_string($_POST['course']);
    $course_code = $conn->real_escape_string($_POST['course_code']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone_number = $conn->real_escape_string($_POST['phone_number']);
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password

    // Check if the email already exists
    $checkEmailQuery = "SELECT email FROM students WHERE email = ?";
    $stmtCheck = $conn->prepare($checkEmailQuery);
    $stmtCheck->bind_param("s", $email);
    $stmtCheck->execute();
    $stmtCheck->store_result();

    if ($stmtCheck->num_rows > 0) {
        // Email already exists
        echo "<script>alert('This email is already registered. Please use a different email.');</script>";
    } else {
        // Handle image upload
        $image_data = null;
        if (isset($_FILES['image_data']) && $_FILES['image_data']['error'] == UPLOAD_ERR_OK) {
            $image_data = file_get_contents($_FILES['image_data']['tmp_name']);
        }

        // Prepare SQL statement
        $sql = "INSERT INTO students (matric_no, stud_name, course, course_code, email, phone_number, image_data, username, password) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

        // Prepare statement
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssssss", $matric_no, $stud_name, $course, $course_code, $email, $phone_number, $image_data, $username, $password);

        // Execute the statement
        if ($stmt->execute()) {
            // Registration successful
            echo "<script>
                alert('Registration successful!');
            </script>";

            // Send email notification
            $mail = new PHPMailer(true);
            try {
                // Server settings
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tengku03@graduate.utm.my'; // Your Gmail address
                $mail->Password = '1LoveMy5eLF'; // Your App Password (if 2FA)
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mail->Port = 587;

                // Recipients
                $mail->setFrom('tengku03@graduate.utm.my', 'Admin Team');
                $mail->addAddress($email, $stud_name); // Recipient email and name

                // Content
                $mail->isHTML(true);
                $mail->Subject = "Welcome to TutorXcells!";
                $mail->Body = "Dear $stud_name,<br><br>Thank you for registering with us!<br><br>
                              You can now log in to your account using the following link:<br>
                              <a href='http://localhost/HiTDA/User%20Dashboard/login.php'>Login to your account</a><br><br>
                              Best regards,<br>Admin Team";

                // Send the email
                $mail->send();
                echo "Email notification sent to $email.";
            } catch (Exception $e) {
                echo "Failed to send email notification. Error: {$mail->ErrorInfo}";
            }
        } else {
            echo "Error: " . $stmt->error;
        }

        // Close the statement
        $stmt->close();
    }

    // Close the check statement and connection
    $stmtCheck->close();
    $conn->close();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <style>
        .login-wrapper {
            max-width: 800px; /* Max width for the form */
            margin: 50px auto; /* Center the form */
            padding: 20px;
            border-radius: 8px; /* Rounded corners */
        }

        .login-wrapper form {
            display: flex;
            flex-wrap: wrap; /* Allow wrapping of input fields */
            justify-content: space-between; /* Space between input fields */
        }

        .login-wrapper form .input-field {
            flex: 1 1 45%; /* Each input field takes up to 45% of the width */
            min-width: 200px; /* Minimum width for input fields */
        }
    </style>
</head>

<body>
    <header>
        <img src="http://localhost/HiTDA/User%20Dashboard/upload/Logo-UTM-white.png" alt="UTM Logo" class="header-image">
        <i class='bx bx-x exem'></i>
        <span class="text">TutorXcells</span>
    </header>

    <main style="margin-top: 250px;">
        <div class="login-wrapper">
            <form action="studregist.php" method="POST" enctype="multipart/form-data">
                <h2>Register</h2>

                <div class="input-field">
                    <input type="text" id="matric_no" name="matric_no" required>
                    <label>Matric Number</label>
                </div>

                <div class="input-field">
                    <input type="text" id="stud_name" name="stud_name" required>
                    <label>Student Name</label>
                </div>

                <div class="input-field">
                    <input type="text" id="course" name="course" required>
                    <label>Course</label>
                </div>

                <div class="input-field">
                    <input type="text" id="course_code" name="course_code" required>
                    <label>Course Code</label>
                </div>

                <div class="input-field">
                    <input type="email" id="email" name="email" required>
                    <label>Email</label>
                </div>

                <div class="input-field">
                    <input type="text" id="phone_number" name="phone_number" required>
                    <label>Phone Number</label>
                </div>

                <div class="input-field">
                    <input type="file" id="image_data" name="image_data">
                    <label>Profile Image (optional)</label>
                </div>

                <div class="input-field">
                    <input type="text" id="username" name="username" required>
                    <label>Username</label>
                </div>

                <div class="input-field">
                    <input type="password" id="password" name="password" required>
                    <label>Password</label>
                </div>

                <button type="submit" id="submit">Register</button>
                <?php if (isset($registration_error)) {
                    echo "<p class='error' style='color: red;'>$registration_error</p>";
                } ?>
            </form>
        </div>
    </main>

    <script src="script.js"></script>

</body>

</html>