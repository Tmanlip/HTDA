<?php
// Database connection
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $bill_number = $_POST['bill_number']; // Get the unique bill number
    $seminar_id = $_POST['seminar_id']; // Get the seminar ID
    $upload_dir = 'uploads/';
    $file = $_FILES['payment-proof'];

    // Check if seminar_id exists
    $stmt_check_seminar = $conn->prepare("SELECT id FROM seminar WHERE id = ?");
    $stmt_check_seminar->bind_param("i", $seminar_id);
    $stmt_check_seminar->execute();
    $stmt_check_seminar->store_result();

    if ($stmt_check_seminar->num_rows > 0) {
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
                    // Insert payment proof into the 'payment_proofs' table
                    $stmt = $conn->prepare("INSERT INTO payment_proofs (bill_number, file_name, file_path) VALUES (?, ?, ?)");
                    $stmt->bind_param("sss", $bill_number, $file_name, $target_file);

                    if ($stmt->execute()) {
                        // Associate payment proof with the seminar in 'participation' table
                        $participant_id = $_POST['matric_no']; // Assuming participant ID is stored in matric_no
                        $role = 'student'; // Assuming role is student for simplicity
                        $status = 'completed'; // Assuming the status is 'completed' upon payment

                        $stmt_participation = $conn->prepare("INSERT INTO participation (seminar_id, participant_id, role, status) VALUES (?, ?, ?, ?)");
                        $stmt_participation->bind_param("isss", $seminar_id, $participant_id, $role, $status);

                        if ($stmt_participation->execute()) {
                            echo "<script>
                                alert('Payment proof uploaded and saved successfully!');
                                window.location.href = 'http://localhost/HiTDA/Sprint%202/eventPage.php'; // Redirect back to the form
                            </script>";
                        } else {
                            echo "<script>
                                alert('Failed to associate payment proof with seminar. Error: " . $stmt_participation->error . "');
                                window.history.back();
                            </script>";
                        }

                        $stmt_participation->close();
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
    } else {
        echo "<script>
            alert('Invalid seminar ID.');
            window.history.back();
        </script>";
    }

    $stmt_check_seminar->close();
}

$conn->close();
?>
