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

// Check if 'id' is set in the URL
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];

    // Prepare and execute delete query
    $delete_query = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($delete_query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    // Check if user was deleted successfully
    if ($stmt->affected_rows > 0) {
        // Redirect back to UserList.php after successful deletion
        header("Location: UserList.php?message=User deleted successfully");
        exit;
    } else {
        // If no rows affected, show an error message
        echo "Error: Unable to delete user.";
    }

    $stmt->close();
} else {
    echo "Error: No user ID specified.";
}

$conn->close();
?>
