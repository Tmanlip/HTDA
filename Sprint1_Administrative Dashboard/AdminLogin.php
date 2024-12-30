<?php
require 'db_connect.php';
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

    // Fetch user from admin table
    $stmt = $conn->prepare("SELECT password FROM admin WHERE username = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $stmt->bind_result($storedPassword); // Bind the stored password to a variable
    $stmt->fetch();

    // Check if admin is found and validate the password
    if ($storedPassword) {
        if ($pass === $storedPassword) {  // Plaintext password validation (consider hashing in production)
            // Login successful
            $_SESSION['username'] = $user;

            // Set remember me cookie if checked
            if ($remember) {
                setcookie("username", $user, time() + (86400 * 3), "/"); // 3 days
            }

            header("Location: AdminHome.html");
            exit();
        } else {
            $login_error = "Invalid username or password.";
        }
    } else {
        // Username not found in admin table
        $login_error = "Invalid username or password.";
    }

    $stmt->close();
}

// Check if remember me cookie is set
if (isset($_COOKIE['username']) && !isset($_SESSION['username'])) {
    $_SESSION['username'] = $_COOKIE['username'];
    header("Location: AdminDashboard.html");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css" />
    <link rel="stylesheet" href="AdminLogin.css">
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
            <form action="AdminLogin.php" method="POST">
                <h2>Admin Login</h2>

                <div class="input-field">
                    <input type="text" id="username" name="username" required>
                    <label style="color: white;">Enter admin username</label>
                </div>

                <div class="input-field">
                    <input type="password" id="password" name="password" required>
                    <label style="color: white;">Enter password</label>
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
                    echo "<p class='error'>$login_error</p>";
                } ?>
            </form>
        </div>
    </main>

    <script src="script.js"></script>

</body>

</html>
