<?php
require 'db_connect.php';
session_start();

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user = isset($_POST['username']) ? $_POST['username'] : '';
    $pass = isset($_POST['password']) ? $_POST['password'] : '';

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
?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link rel="stylesheet" href="login.css">
</head>
<body>
    <form action="login.php" method="POST">
        <h2>Login</h2>
        <input type="text" name="username" placeholder="Username" required>
        <input type="password" name="password" placeholder="Password" required>
        <button type="submit">Log In</button>
    </form>
</body>
</html>
