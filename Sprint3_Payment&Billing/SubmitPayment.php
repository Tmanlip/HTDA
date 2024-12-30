<?php
// Database connection
$host = 'localhost'; 
$username = 'root';  
$password = '';      
$database = 'tutorxcells';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die("<script>alert('Database connection failed: " . $conn->connect_error . "');</script>");
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bill_number = $_POST['bill_number']; // Get the unique bill number
    $upload_dir = 'uploads/';
    $file = $_FILES['payment-proof'];

    if ($file['error'] == 0) {
        $file_name = basename($file['name']);
        $file_ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        if ($file_ext === 'pdf') {
            $new_file_name = uniqid('proof_', true) . '.' . $file_ext;
            $target_file = $upload_dir . $new_file_name;

            if (!file_exists($upload_dir)) {
                mkdir($upload_dir, 0777, true);
            }

            if (move_uploaded_file($file['tmp_name'], $target_file)) {
                $stmt = $conn->prepare("INSERT INTO payment_proofs (bill_number, file_name, file_path) VALUES (?, ?, ?)");
                $stmt->bind_param("sss", $bill_number, $file_name, $target_file);

                if ($stmt->execute()) {
                    echo "<script>
                        alert('Payment proof uploaded and saved successfully!');
                        window.location.href = 'PaymentForm.php'; // Redirect back to the form
                    </script>";
                } else {
                    echo "<script>
                        alert('Database error: " . $stmt->error . "');
                        window.history.back();
                    </script>";
                }
                $stmt->close();
            } else {
                echo "<script>
                    alert('Failed to upload file.');
                    window.history.back();
                </script>";
            }
        } else {
            echo "<script>
                alert('Invalid file format. Only PDF files are allowed.');
                window.history.back();
            </script>";
        }
    } else {
        echo "<script>
            alert('Error uploading file.');
            window.history.back();
        </script>";
    }
}

$conn->close();
?>
