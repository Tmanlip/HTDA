<?php
// Include the database connection file
include('connectResourceDB.php');

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get form data
    $course_name = $_POST['course'];  // Correctly gets course name from the form
    $document_name = $_FILES['file']['name'];  // Get the uploaded file's name

    // File upload handling
    $target_dir = "../uploads/";  // Directory where files will be stored
    $target_file = $target_dir . basename($document_name);  // Correct target file path using the document name
    $uploadOk = 1;
    $fileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // File type validation
    $allowedTypes = array("pdf", "docx", "zip");
    if (!in_array($fileType, $allowedTypes)) {
        echo "Sorry, only PDF, DOCX, and ZIP files are allowed.";
        header('http://localhost/AD_Project/ResourceSharing/resourceSharing.html');

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
            $uploadOk = 0;
        }

        // Try to upload the file if no errors
        if ($uploadOk == 1 && move_uploaded_file($_FILES["file"]["tmp_name"], $target_file)) {
            // Prepare the SQL query to insert data into the database
            $sql = "INSERT INTO resources (course_name, document_name, file_path, upload_date)
                    VALUES (?, ?, ?, ?)";

            $upload_date = date('Y-m-d');

            // Prepare and bind the statement
            if ($stmt = $conn->prepare($sql)) {
                $stmt->bind_param("ssss", $course_name, $document_name, $target_file, $upload_date);

                // Execute the query
                if ($stmt->execute()) {
                    echo "The file has been uploaded and the details have been saved.";
                    header('http://localhost/AD_Project/ResourceSharing/resourceSharing.html');
                } else {
                    echo "Error: " . $stmt->error;
                    header('http://localhost/AD_Project/ResourceSharing/resourceSharing.html');
                }

                // Close the statement
                $stmt->close();
            } else {
                echo "Error preparing the SQL statement.";
            }
            
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
}

header('Location: resourceSharing.html'); // Redirect to pConnect.html


// Close the database connection
$conn->close();

?>
