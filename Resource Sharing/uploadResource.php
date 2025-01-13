<?php
// Include the database connection file
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $username = $_SESSION['username'];
    $usertype = $_SESSION['user_type'];

    $stmt = $conn->prepare("SELECT matric_no FROM students WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        die("Invalid username.");
    }

    $student_id = $student['matric_no'];

    // Get form data
    $course_name = $_POST['course'];  // Correctly gets course name from the form
    $document_name = $_FILES['file']['name'];  // Get the uploaded file's name

    // File upload handling
    $target_dir = "uploads/";  // Directory where files will be stored
    $target_file = $target_dir . basename($document_name);  // Correct target file path using the document name
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Debug: Check file size and type
    echo "File size: " . $_FILES['file']['size'] . "<br>";
    echo "File type: " . $_FILES['file']['type'] . "<br>";

    // File type validation
    $allowedTypes = array("pdf", "docx", "zip");
    if (!in_array($fileType, $allowedTypes)) {
        echo "Sorry, only PDF, DOCX, and ZIP files are allowed.";
        $uploadOk = 0;
    }

    // File size validation (example: limit to 10MB)
    $maxSize = 10 * 1024 * 1024;  // 10MB
    if ($_FILES['file']['size'] > $maxSize) {
        echo "Sorry, your file is too large.";
        $uploadOk = 0;
    }

    // Check if the file already exists
    if (file_exists($target_file)) {
        echo "Sorry, the file already exists.";
        $uploadOk = 0;
    }

    // Check if $uploadOk is set to 0 due to an error
    if ($uploadOk == 0) {
        echo "Sorry, your file was not uploaded.";
    } else {
        // Check for errors in the upload process
        if ($_FILES['file']['error'] !== UPLOAD_ERR_OK) {
            echo "Error during file upload: " . $_FILES['file']['error'];
            exit;  // Exit to stop further execution
        }

        // Try to upload the file if no errors
        if ($uploadOk == 1 && move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Prepare the SQL query to insert data into the resources table
            $sql = "INSERT INTO resources (course_name, document_name, file_path, upload_date)
                    VALUES (?, ?, ?, ?)";

            $upload_date = date('Y-m-d');

            // Prepare and bind the statement
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $course_name, $document_name, $target_file, $upload_date);

                // Execute the query
                if ($stmt->execute()) {
                    // Get the last inserted resource ID
                    $resource_id = $stmt->insert_id;

                    // Now insert the data into the resource_sharing table
                    $sharing_sql = "INSERT INTO resource_sharing (student_id, resource_id) VALUES (?, ?)";
                    if ($sharing_stmt = $conn->prepare($sharing_sql)) {
                        $sharing_stmt->bind_param("si", $student_id, $resource_id);

                        // Execute the query for resource sharing
                        if ($sharing_stmt->execute()) {
                            echo "The file has been uploaded and the details have been saved.";
                            header('Location: resourceSharing.php');
                        } else {
                            echo "Error saving to resource_sharing: " . $sharing_stmt->error;
                        }

                        // Close the resource sharing statement
                        $sharing_stmt->close();
                    } else {
                        echo "Error preparing the resource sharing SQL statement.";
                    }
                } else {
                    echo "Error: " . $stmt->error;
                }

                // Close the resources statement
                $stmt->close();
            } else {
                echo "Error preparing the resources SQL statement.";
            }
            
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

// Close the database connection
$conn->close();
?>
