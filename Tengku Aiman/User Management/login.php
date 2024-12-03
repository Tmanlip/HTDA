<?php
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
session_start();

// Check for inactivity (20 minutes)
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 1200)) { // 1200 seconds = 20 minutes
    session_unset();
    session_destroy();
}
$_SESSION['last_activity'] = time(); // Update last activity time

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = isset($_POST['username']) ? $_POST['username'] : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';
    $remember = isset($_POST['remember']);

    // Fetch user from student table
    $stmt = $conn->prepare("SELECT password FROM student WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($storedPassword); // Bind the stored password to a variable
    $stmt->fetch();

    // Check if student is found and validate the password
    if ($storedPassword) {
        if ($pass == $storedPassword) {
            // Login successful
            $_SESSION['username'] = $user;

            // Set remember me cookie if checked
            if ($remember) {
                setcookie("username", $user, time() + (86400 * 3), "/"); // 3 days
            }

            header("Location: StudentDashboard.php");
            exit();
        } else {
            $login_error = "Invalid username or password";
        }
    } else {
        // If student not found, check lecturer table
        $stmt = $conn->prepare("SELECT password FROM lecturer WHERE username = ?");
        $stmt->bind_param("s", $user);  // Use same $user variable
        $stmt->execute();
        $stmt->bind_result($storedPassword);  // Bind the stored password to a variable
        $stmt->fetch();

        // Check if lecturer is found and validate the password
        if ($storedPassword) {
            if ($pass === $storedPassword) {  // Plaintext password check for lecturer
                // Login successful
                $_SESSION['username'] = $user;

                // Set remember me cookie if checked
                if ($remember) {
                    setcookie("username", $user, time() + (86400 * 3), "/"); // 3 days
                }

                header("Location: LecturerDashboard.php");
                exit();
            } else {
                $login_error = "Invalid username or password.";
            }
        } else {
            // Username not found in both tables
            $login_error = "Invalid username or password.";
        }
    }

    $stmt->close();
}

// Check if remember me cookie is set
if (isset($_COOKIE['username']) && !isset($_SESSION['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    header("Location: StudentDashboard.php"); // Redirect based on role if necessary
    exit();
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="login.css">
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
            <form action="login.php" method="POST">
                <h2>Login</h2>

                <div class="input-field">
                    <input type="text" id="username" name="username" style="color: white;" required>
                    <label style="color: white;">Enter your username</label>
                </div>

                <div class="input-field">
                    <input type="password" id="password" style="color: white;" name="password" required>
                    <label style="color: white;">Enter your password</label>
                </div>

                <div class="password-options">
                    <label for="remember">
                        <input type="checkbox" id="remember" name="remember">
                        <p style="color: white;">Remember me</p>
                    </label>

                    <label for="Forgot">
                        <a href="ForgotPassword.php" style="color: white;">Forgot Password</a>
                    </label>
                </div>

                <button type="submit" id="submit">Log In</button>
                <?php if (isset($login_error)) {
                    echo "<p class='error' style='color: red;'>$login_error</p>";
                } ?>
            </form>
        </div>
    </main>

    <script src="script.js"></script>

</body>

</html>