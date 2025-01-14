<?php
// Include database configuration
require 'C:\xampp\htdocs\HiTDA\db_connect.php'; // Update this with the correct path to your DB connection
session_start();

// Initialize email variable
$email = '';

// Check if email is passed as a query parameter
if (isset($_GET['email'])) {
    $email = $_GET['email'];
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $newPassword = isset($_POST['password']) ? $_POST['password'] : '';
    $confirmPassword = isset($_POST['confirmedpassword']) ? $_POST['confirmedpassword'] : '';

    // Validate form data
    if (empty($email) || empty($newPassword) || empty($confirmPassword)) {
        $error = "All fields are required!";
    } elseif ($newPassword !== $confirmPassword) {
        $error = "Passwords do not match!";
    } else {
        // Check if email exists in the `student` table
        $query = "SELECT email FROM students WHERE email = ?";
        if ($stmt = $conn->prepare($query)) {
            $stmt->bind_param('s', $email);
            $stmt->execute();
            $stmt->store_result();

            if ($stmt->num_rows > 0) {
                // Email found in `student` table; prepare update query
                $updateQuery = "UPDATE students SET password = ? WHERE email = ?";
                $stmt->close();
            } else {
                // Check if email exists in the `lecturer` table
                $stmt->close();
                $query = "SELECT email FROM lecturers WHERE email = ?";
                if ($stmt = $conn->prepare($query)) {
                    $stmt->bind_param('s', $email);
                    $stmt->execute();
                    $stmt->store_result();

                    if ($stmt->num_rows > 0) {
                        // Email found in `lecturer` table; prepare update query
                        $updateQuery = "UPDATE lecturers SET password = ? WHERE email = ?";
                    } else {
                        // Email not found in either table
                        $error = "Email not found in our records!";
                    }
                    $stmt->close();
                }
            }
        }

        // Execute password update if a valid update query exists
        if (!isset($error) && isset($updateQuery)) {
            if ($stmt = $conn->prepare($updateQuery)) {
                $stmt->bind_param('ss', $newPassword, $email);
                if ($stmt->execute()) {
                    $success = "Password successfully reset!";
                } else {
                    $error = "Failed to reset password!";
                }
                $stmt->close();
            } else {
                $error = "Database query failed!";
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
    <title>Forgot Password</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
    <link rel="stylesheet" href="fp.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <img src="Logo-UTM-white.png" alt="UTM Logo" class="header-image">
        <i class='bx bx-x exem'></i>
        <span class="text">TutorXcells</span>
    </header>

    <main>
        <div class="login-wrapper">
            <form action="ForgotPassword.php" method="POST">
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
                    <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" style="color: white;" required>
                    <label style="color: white;">Please enter your email</label>
                </div>

                <div class="input-field">
                    <input type="password" id="new_password" name="password" style="color: white;" required>
                    <label style="color: white;">Enter your new password</label>
                </div>

                <div class="input-field">
                    <input type="password" id="confirm_password" name="confirmedpassword" style="color: white;" required>
                    <label style="color: white;">Confirm your new password</label>
                </div>

                <button type="submit" id="submit">Reset Password</button>
                <button type="button" id="login" style="margin-top: 10px;">
                    <a href="login.php" style="color: black">Go to Login Page</a>
                </button>
            </form>
        </div>
    </main>
    
    <script src="script.js"></script>
</body>
</html>