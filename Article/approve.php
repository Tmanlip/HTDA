<?php
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Load Composer's autoloader for PHPMailer
require 'vendor/autoload.php';

$successMessage = '';
$errorMessage = '';
$approvedArticle = [];

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $action = $_POST['action'];
    $id = isset($_POST['id']) ? (int)$_POST['id'] : 0;
    $email = isset($_POST['email']) ? filter_var($_POST['email'], FILTER_SANITIZE_EMAIL) : '';
    $name = isset($_POST['name']) ? htmlspecialchars($_POST['name'], ENT_QUOTES, 'UTF-8') : '';
    $title = isset($_POST['title']) ? htmlspecialchars($_POST['title'], ENT_QUOTES, 'UTF-8') : '';

    if ($action == 'approve') {
        $status = 'approved';
    } elseif ($action == 'reject') {
        $status = 'rejected';
    }

    // Fetch article from the database
    $sql = "SELECT * FROM article WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $article = $result->fetch_assoc();
        $article['status'] = $status;

        // Update the status in the database
        $updateSql = "UPDATE article SET status = ? WHERE id = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("si", $status, $id);
        if ($stmt->execute()) {
            $successMessage = "Article status updated to: " . $status;
            $approvedArticle = $article;
        } else {
            $errorMessage = "Error updating article status.";
        }
        $stmt->close();
    } else {
        $errorMessage = "Article not found.";
    }

    // Send email notification
    if (!empty($email) && !empty($name) && !empty($title)) {
        $mail = new PHPMailer(true);

        try {
            // Server settings
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'tengku03@graduate.utm.my'; // Your Gmail address
            $mail->Password = '1LoveMy5eLF'; // Your App Password (if 2FA)
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            // Recipients
            $mail->setFrom('tengku03@graduate.utm.my', 'Admin Team');
            $mail->addAddress($email, $name); // Recipient email and name

            // Content
            $mail->isHTML(true);
            $mail->Subject = "Article Submission Status: $status";
            $mail->Body = "Dear $name,<br><br>Thank you for submitting your article titled <b>'$title'</b>.<br><br>Status: <b>$status</b><br><br>Best regards,<br>Admin Team";
            $mail->AltBody = "Dear $name,\n\nThank you for submitting your article titled '$title'.\n\nStatus: $status\n\nBest regards,\nAdmin Team";

            // Send the email
            $mail->send();
            $successMessage .= " Email notification sent to $email.";
        } catch (Exception $e) {
            $errorMessage .= " Failed to send email notification. Error: {$mail->ErrorInfo}";
        }
    }

    // Redirect or display message
    if ($status === 'approved') {
        echo '<form id="redirectForm" action="disparticle.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($approvedArticle['id']) . '">';
        echo '<input type="hidden" name="title" value="' . htmlspecialchars($approvedArticle['title']) . '">';
        echo '<input type="hidden" name="name" value="' . htmlspecialchars($approvedArticle['name']) . '">';
        echo '<input type="hidden" name="email" value="' . htmlspecialchars($approvedArticle['email']) . '">';
        echo '<input type="hidden" name="summary" value="' . htmlspecialchars($approvedArticle['summary']) . '">';
        echo '<input type="hidden" name="content" value="' . htmlspecialchars($approvedArticle['content']) . '">';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
        echo '</form>';
    } else {
        echo '<form id="redirectForm" action="adminartcile.php" method="POST">';
        echo '<input type="hidden" name="id" value="' . htmlspecialchars($approvedArticle['id']) . '">';
        echo '<input type="hidden" name="title" value="' . htmlspecialchars($approvedArticle['title']) . '">';
        echo '<input type="hidden" name="name" value="' . htmlspecialchars($approvedArticle['name']) . '">';
        echo '<input type="hidden" name="email" value="' . htmlspecialchars($approvedArticle['email']) . '">';
        echo '<input type="hidden" name="summary" value="' . htmlspecialchars($approvedArticle['summary']) . '">';
        echo '<input type="hidden" name="content" value="' . htmlspecialchars($approvedArticle['content']) . '">';
        echo '<script>document.getElementById("redirectForm").submit();</script>';
        echo '</form>';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notification</title>
    <script>
        window.onload = function() {
            <?php if ($successMessage) { ?>
                alert("<?php echo $successMessage; ?>");
            <?php } elseif ($errorMessage) { ?>
                alert("<?php echo $errorMessage; ?>");
            <?php } ?>
        };
    </script>
</head>
<body>
</body>
</html>
