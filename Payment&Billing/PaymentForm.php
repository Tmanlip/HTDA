<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>QR Code Payment</title>
    <!-- Boxicons CSS-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <script src="https://cdn.jsdelivr.net/npm/qrcode"></script>
    <link rel="stylesheet" href="Admindashboard.css">
</head>
<body>
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sideBarOpen'></i>
                <span class="logo navLogo"><a href="#">TutorXcells</a></span>

                <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="#">TutorXcells</a></span>
                    <i class='bx bx-x sideBarClosed'></i>
                </div>

                <ul class="nav-links">
                    <li><a href="#">Home</a></li>
                    <li><a href="#">About</a></li>
                    <li><a href="#">Portfolio</a></li>
                    <li><a href="#">Event</a></li>
                    <li><a href="#">Profile</a></li>
                </ul>
            </div>

            <div class="darkLight-searchBox">
                <div class="dark-light">
                    <i class='bx bx-moon moon'></i>
                    <i class='bx bx-sun sun' ></i>
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
            </div>
        </div>
    </nav>

    <main>
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
                        <input type="hidden" name="seminar_id" value="<?php echo $_POST['seminar_id']; ?>"> <!-- Pass the seminar ID -->
                        <input type="hidden" name="matric_no" value="A22EC0283"> <!-- Pass the unique bill number -->
                        <button class="submit-btn" type="submit">Submit Payment Proof</button>
                    </form>
                </div>
            </div>
            <div class="footer">
                Secure Payment Powered by QR System
            </div>
        </div>
    </main>

    <script src="script.js"></script>

    <footer>
        <div class="content">
            <div class="top">
                <div class="logo-details">
                    <!-- <i class="fab fa-slack">
                        <span class="logo_name">UTM</span>
                    </i> -->

                    <img src="Logo-UTM-white.png" alt="UTM Logo" class="footer-image">
                </div>

                <div class="media-icons">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-linkedin-in"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>

            <div class="link-boxes">
                <ul class="box">
                    <li class="link_name">University Teknology Malaysia</li>
                    <li><a href=#>Home</a></li>
                    <li><a href=#>About</a></li>
                    <li><a href=#>Portfolio</a></li>
                    <li><a href=#>Event</a></li>
                    <li><a href=#>Profile</a></li>
                </ul>

                <ul class="box">
                    <li class="link_name">Faculty of Computing</li>
                    <li><a href=#>Home</a></li>
                    <li><a href=#>About</a></li>
                </ul>

                <ul class="box">
                    <li class="link_name">PERSAKA</li>
                    <li><a href=#>Home</a></li>
                    <li><a href=#>About</a></li>
                    <div class="media-icons">
                        <a href="#"><i class="fab fa-facebook-f"></i></a>
                        <a href="#"><i class="fab fa-twitter"></i></a>
                        <a href="#"><i class="fab fa-instagram"></i></a>
                        <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        <a href="#"><i class="fab fa-youtube"></i></a>
                    </div>
                </ul>

                <ul class="box">
                    <li class="link_name">Community</li>
                    <li><a href=#>Forum</a></li>
                    <li><a href=#>Repositories</a></li>
                </ul>
            </div>
        </div>

        <div class="bottom-details">
            <div class="bottom_text">
                <span class="copyright_text">Copyright &#169; 2024 <a href="#">Universiti Teknologi Malaysia.</a> All right reserved</span>
                <span class="policy_terms">
                    <a href="#">Privacy Policy</a>
                    <a href="#">Terms and Conditions</a>
                </span>
            </div>
        </div>
    </footer>

</body>

</html>
