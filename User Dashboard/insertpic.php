<?php
// Get matric_no from form submission
$matric_no = "A22EC0283"; // Ensure your form includes an input for matric_no

// Define upload directory
$target_dir = "upload/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;

// Check if file upload is successful
if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
    echo "The file " . htmlspecialchars(basename($_FILES["fileToUpload"]["name"])) . " has been uploaded.";

    // Database connection
    $conn = new mysqli("localhost", "your_username", "your_password", "your_database");

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement to insert data
    $stmt = $conn->prepare("INSERT INTO students (matric_no, file_path) VALUES (?, ?)
                            ON DUPLICATE KEY UPDATE file_path = VALUES(file_path)");
    $stmt->bind_param("ss", $matric_no, $target_file);

    if ($stmt->execute()) {
        echo "File path and Matric Number saved successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connection
    $stmt->close();
    $conn->close();
} else {
    echo "Sorry, there was an error uploading your file.";
}
?>
