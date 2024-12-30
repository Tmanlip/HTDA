<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Payment</title>
    <script src="https://cdn.jsdelivr.net/npm/qrcode"></script>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: maroon;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 600px;
            margin: 50px auto;
            background: #ffffff;
            box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            overflow: hidden;
            text-align: center;
        }

        .header {
            background-color: gold;
            color: black;
            padding: 15px 0;
            font-size: 1.5em;
        }

        .content {
            padding: 20px;
        }

        .qr-code {
            margin: 20px auto;
        }

        .upload-section {
            margin-top: 20px;
            text-align: center;
        }

        .upload-section input[type="file"] {
            margin: 20px 0;
            padding: 10px;
            font-size: 1em;
        }

        .submit-btn {
            display: block;
            width: 100%;
            max-width: 300px;
            background-color: gold;
            color: black;
            border: none;
            padding: 12px;
            font-size: 1.1em;
            cursor: pointer;
            border-radius: 5px;
            margin: 20px auto;
        }

        .submit-btn:hover {
            background-color: gold;
        }

        .footer {
            text-align: center;
            font-size: 0.9em;
            color: #666;
            padding: 10px 0;
        }
    </style>
</head>
<body>
    <?php
    // Generate a unique bill number (example: use current timestamp and a random number)
    $billNumber = 'BILL-' . rand(100000, 999999);
    ?>

    <div class="container">
        <div class="header">
            QR Code Payment
        </div>
        <div class="content">
            <!-- Display Bill Details -->
            <div class="bill-details">
                <p>Bill Number: <span id="bill-number"><?php echo $billNumber; ?></span></p>
                <p>Amount to Pay: <span id="amount">RM5.00</span></p>
            </div>

            <!-- QR Code Section -->
            <div class="qr-code">
                <p>Scan this QR code to make payment:</p>
                <img src="QR.jpg" alt="QR">
            </div>

            <!-- Upload Payment Proof Section -->
            <div class="upload-section">
                <form action="SubmitPayment.php" method="POST" enctype="multipart/form-data">
                    <p>After making the payment, please upload your payment proof:</p>
                    <input type="file" name="payment-proof" accept="application/pdf" required>
                    <input type="hidden" name="bill_number" value="<?php echo $billNumber; ?>"> <!-- Pass the unique bill number -->
                    <button class="submit-btn" type="submit">Submit Payment Proof</button>
                </form>
            </div>
        </div>
        <div class="footer">
            Secure Payment Powered by QR System
        </div>
    </div>
</body>
</html>
