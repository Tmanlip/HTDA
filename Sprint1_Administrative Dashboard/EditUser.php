<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$database = "tutorxcells";
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if 'id' is in the URL
if (!isset($_GET['id'])) {
    die("Error: User ID not specified.");
}

$user_id = $_GET['id'];

// Fetch user data
$query = "SELECT * FROM users WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Check if user exists
if (!$user) {
    die("Error: User not found.");
}

// Update user information if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $course_or_department = $_POST['course_or_department'];
    $status = $_POST['status'];

    $update_query = "UPDATE users SET name = ?, email = ?, course_or_department = ?, status = ? WHERE id = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("ssssi", $name, $email, $course_or_department, $status, $user_id);
    $update_stmt->execute();

    header("Location: UserList.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>

<style>

/* Edit User Page Styles */

/* General Styling */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
    display: flex;
    justify-content: center;
    align-items: center;
    min-height: 100vh;
}

h2 {
    text-align: center;
    color: #333;
    margin-bottom: 20px;
}

/* Form Container */
form {
    background-color: white;
    border-radius: 8px;
    padding: 30px;
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    width: 100%;
    max-width: 600px;
}

label {
    font-size: 14px;
    color: #555;
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
    border-color: #0066cc;
    outline: none;
}

button {
    width: 100%;
    padding: 12px;
    border: none;
    background-color: #0066cc;
    color: white;
    font-size: 16px;
    cursor: pointer;
    border-radius: 5px;
    margin: 10px 0;
}

button:hover {
    background-color: #005bb5;
}

a {
    display: inline-block;
    text-align: center;
    padding: 10px;
    text-decoration: none;
    color: #0066cc;
    font-size: 16px;
    margin-top: 10px;
}

a:hover {
    color: #004d99;
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
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="AdminDashboard.css">
</head>
<body>
    <form method="POST" action="">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($user['name']); ?>" required>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>" required>

        <label for="course_or_department">Course/Department:</label>
        <input type="text" id="course_or_department" name="course_or_department" value="<?php echo htmlspecialchars($user['course_or_department']); ?>" required>

        <label for="status">Status:</label>
        <select id="status" name="status" required>
            <option value="active" <?php echo $user['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
            <option value="inactive" <?php echo $user['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
        </select>

        <button type="submit">Save Changes</button>
        <a href="UserList.php">Cancel</a>
    </form>
</body>
</html>

<?php
$conn->close();
?>
