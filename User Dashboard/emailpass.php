<?php
// Include database configuration
require 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Update this with the correct path to your DB connection

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    
    // Validate form data
    if (empty($email)) {
        $error = "Email field is required!";
    } else {
        // Check if email exists in the `student` table
        $query = "SELECT email, stud_name FROM students WHERE email = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Email found in `student` table; prepare to send email
                $stmt->bind_result($email, $stud_name);
                $stmt->fetch();
                $stmt->close();
            } else {
                // Check if email exists in the `lecturer` table
                $stmt->close();
                $query = "SELECT email, lect_name FROM lecturers WHERE email = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        // Email found in `lecturer` table; prepare to send email
                        $stmt->bind_result($email, $stud_name);
                        $stmt->fetch();
                    } else {
                        // Email not found in either table
                        $error = "Email not found in our records!";
                    }
                    $stmt->close();
                }
            }
        }

        // Send email notification if a valid email was found
        if (!isset($error) && isset($stud_name)) {
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

                // Generate a unique token for the reset link
                $token = bin2hex(random_bytes(50)); // Generate a random token
                $resetLink = "http://localhost/HiTDA/User%20Dashboard/ForgotPassword.php?token=$token&email=" . urlencode($email);

                // Content
                $mail->isHTML(true);
                $mail->Subject = "Reset Your Password";
                $mail->Body = "Dear $stud_name,<br><br>We received a request to reset your password.<br>
                            You can reset your password using the following link:<br>
                            <a href='$resetLink'>Reset Password</a><br><br>
                            If you did not request a password reset, please ignore this email.<br><br>
                            Best regards,<br>Admin Team";

                // Send the email
                $mail->send();
                
                // Set success message
                $success = "A password reset link has been sent to your email. Please check your inbox.";
            } catch (Exception $e) {
                $error = "Failed to send email notification. Error: {$mail->ErrorInfo}";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="login.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>
<body>
<main>
    <div class="login-wrapper">
        <form action="emailpass.php" method="POST">
            <h2>Reset Password</h2>

            <!-- Display Success/Error Messages -->
            <?php if (isset($error)): ?>
                <div class="alert alert-error">
                    <p style="color: red;"><?php echo $error; ?></p>
                </div>
            <?php endif; ?>

            <?php if (isset($success)): ?>
                <div class="alert alert-success">
                    <p style="color: green;"><?php echo $success; ?></p>
                </div>
            <?php endif; ?>

            <div class="input-field">
                <input type="email" id="email" name="email" style="color: white;" required>
                <label style="color: white;">Please enter your email</label>
            </div>
                
            <button type="submit" id="submit">Confirm email</button>
        </form>
    </div>
</main>

<script src="script.js"></script>
</body>
</html>