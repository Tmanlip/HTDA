<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

// Check if the request is valid
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {
    $id = $_POST['id'];
    $table = isset($_POST['table']) ? $_POST['table'] : null;

    if ($table === 'student') {
        $query = "SELECT stud_name AS name, email, course, last_login FROM students WHERE matric_no = ?";
    } elseif ($table === 'lecturer') {
        $query = "SELECT lect_name AS name, email, subject_teached, last_login FROM lecturers WHERE employee_no = ?";
    } else {
        die("Invalid table selected.");
    }

    // Prepare and execute the statement
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
    } else {
        die("User not found.");
    }
}

// Save changes if form submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['name'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course_or_subject = $_POST['course_or_subject'];
    $last_login = $_POST['last_login'];

    if ($table === 'student') {
        $update_query = "UPDATE students SET stud_name = ?, email = ?, course = ?, last_login = ? WHERE matric_no = ?";
    } elseif ($table === 'lecturer') {
        $update_query = "UPDATE lecturers SET lect_name = ?, email = ?, subject_teached = ?, last_login = ? WHERE employee_no = ?";
    }

    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("sssss", $name, $email, $course_or_subject, $last_login, $id);

    if ($update_stmt->execute()) {
        echo "User updated successfully.";
        header("Location: UserList.php");
        exit;
    } else {
        echo "Error updating user: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit User</title>

        <link rel="stylesheet" href="AdminDashboard.css">
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

        <style>
        /* Form Container */
        form {
            border-radius: 8px;
            padding: 30px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 600px;
        }

        label {
            font-size: 14px;
            margin-bottom: 5px;
            display: block;
        }

        input[type="text"],
        input[type="email"],
        select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 14px;
        }

        input[type="text"]:focus,
        input[type="email"]:focus,
        select:focus {
            outline: none;
        }

        button {
            width: 100%;
            padding: 12px;
            border: none;
            font-size: 16px;
            cursor: pointer;
            border-radius: 5px;
            margin: 10px 0;
        }

        a {
            display: inline-block;
            text-align: center;
            padding: 10px;
            text-decoration: none;
            font-size: 16px;
            margin-top: 10px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            form {
                padding: 20px;
            }

            input[type="text"],
            input[type="email"],
            select {
                padding: 8px;
                font-size: 12px;
            }

            button {
                font-size: 14px;
                padding: 10px;
            }

            a {
                font-size: 14px;
            }
        }

        </style>
    </head>

    <body style="height: 120px;">
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
                        <li><a href="AdminHome.html">Home</a></li>
                        <li><a href="UserList.php">User list</a></li>
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

                    <a href="AdminLogin.html" class="logout-button"">Logout</a>
                </div>
            </div>
        </nav>

        <main style="margin-top: 10px;">

        <h2>Edit User</h2>
            <form method="POST" action="EditUser.php">
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($id); ?>">
                <input type="hidden" name="table" value="<?php echo htmlspecialchars($table); ?>">

                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

                <label for="course_or_subject"><?php echo $table === 'student' ? 'Course' : 'Subject Taught'; ?>:</label>
                <input type="text" id="course_or_subject" name="course_or_subject" value="<?php echo htmlspecialchars($table === 'student' ? $user['course'] : $user['subject_teached']); ?>" required>

                <label for="last_login">Last Login:</label>
                <input type="datetime-local" id="last_login" name="last_login" value="<?php echo htmlspecialchars(date('Y-m-d\TH:i', strtotime($user['last_login']))); ?>" required>

                <button type="submit">Save Changes</button>
                <a href="UserList.php">Cancel</a>
            </form>
        </main>

        <script src="AdminScript.js"></script>
    </body>
</html>