<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Fetch payment proofs
$payments_query = "SELECT id, bill_number, file_name, file_path, upload_time, status FROM payment_proofs ORDER BY upload_time DESC;";
$payments_result = $conn->query($payments_query);

// Update status if POST request is received
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_status'])) {
    $payment_id = $_POST['payment_id'];
    $new_status = $_POST['status'];

    $update_query = "UPDATE payment_proofs SET status = '$new_status' WHERE id = '$payment_id'";
    if ($conn->query($update_query) === TRUE) {
        header("Location: " . $_SERVER['PHP_SELF']); // Reload the page to reflect changes
        exit();
    } else {
        $message = "Error updating status: " . $conn->error;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Payment and Billing</title>
    <link rel="stylesheet" href="AdminDashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: maroon;
            margin: 0;
            padding: 0;
        }

        .payment-section {
            width: 90%;
            margin: 50px auto;
            padding: 20px;
            background-color: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            font-size: 24px;
            color: #333;
            text-align: center;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 10px;
            text-align: center;
            border: 1px solid #ddd;
            font-size: 14px;
        }

        th {
            background-color: #f9f9f9;
        }

        .status {
            padding: 5px 10px;
            border-radius: 5px;
            color: #fff;
        }

        .status.pending {
            background-color: #f39c12;
        }

        .status.completed {
            background-color: #2ecc71;
        }

        .status.failed {
            background-color: #e74c3c;
        }
		
		form {
            display: flex;
            align-items: center;
            gap: 10px; /* Adds spacing between select and button */
        }

        select {
            padding: 5px;
            font-size: 14px;
        }
		
		button[type="submit"] {
            padding: 5px 10px;
            font-size: 14px;
            cursor: pointer;
        }

        .message {
            color: green;
            text-align: center;
            margin-bottom: 20px;
        }

        .message.error {
            color: red;
        }
    </style>
</head>
<body>
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sideBarOpen'></i>
            <span class="logo navLogo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php" style="color: white;">TutorXcells</a></span>

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php" style="color: white;">TutorXcells</a></span>
                    <i class='bx bx-x sideBarClosed'></i>
                </div>
                <ul class="nav-links">
                    <li><a href="http://localhost/HiTDA/Feedback%20and%20Reporting/track-report.php">Feedback & Reporting</a></li>
                    <li><a href="http://localhost/HiTDA/Module%203/rewards.php">Student Activity</a></li>
                    <li><a href="http://localhost/HiTDA/Module%203/engagement.php">Article Engagement</a></li>
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
                <a href="AdminLogin.php" class="logout-button" style="color: white;">Logout</a>
            </div>
        </div>
    </nav>

    <main>
        <div class="payment-section">
            <h2>Manage Payment and Billing</h2>
            <?php if (isset($message)) { echo "<p class='message'>" . $message . "</p>"; } ?>
            <table>
                <thead>
                    <tr>
                        <th>Bill Number</th>
                        <th>File Name</th>
                        <th>Uploaded File</th>
                        <th>Upload Time</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    if ($payments_result->num_rows > 0) {
                        while ($row = $payments_result->fetch_assoc()) {
                            $status_class = strtolower($row['status']);
                            echo "<tr>";
                            echo "<td>" . htmlspecialchars($row['bill_number']) . "</td>";
                            echo "<td>" . htmlspecialchars($row['file_name']) . "</td>";
                            echo "<td><a href='" . htmlspecialchars($row['file_path']) . "' target='_blank'>View File</a></td>";
                            echo "<td>" . htmlspecialchars($row['upload_time']) . "</td>";
                            echo "<td><span class='status $status_class'>" . htmlspecialchars($row['status']) . "</span></td>";
                            echo "<td>";
                            echo "<form method='POST'>";
                            echo "<input type='hidden' name='payment_id' value='" . $row['id'] . "'>";
                            echo "<select name='status'>";
                            echo "<option value='Pending'" . ($row['status'] === 'Pending' ? ' selected' : '') . ">Pending</option>";
                            echo "<option value='Completed'" . ($row['status'] === 'Completed' ? ' selected' : '') . ">Completed</option>";
                            echo "<option value='Failed'" . ($row['status'] === 'Failed' ? ' selected' : '') . ">Failed</option>";
                            echo "</select>";
                            echo "<button type='submit' name='update_status'>Update</button>";
                            echo "</form>";
                            echo "</td>";
                            echo "</tr>";
                        }
                    } else {
                        echo "<tr><td colspan='6'>No payment records found.</td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>


<?php
$conn->close();
?>
