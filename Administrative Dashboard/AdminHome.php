<?php
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- CSS -->
    <link rel="stylesheet" href="AdminDashboard.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

    <!-- Chart.js Library -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
</head>
<body style="height: 100vh;">
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sideBarOpen'></i>
            <span class="logo navLogo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php">TutorXcells</a></span>

            <div class="menu">
                <div class="logo-toggle">
                    <span class="logo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php">TutorXcells</a></span>
                    <i class='bx bx-x sideBarClosed'></i>
                </div>

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
                <a href="AdminLogin.php" class="logout-button"">Logout</a>
            </div>
        </div>
    </nav>

    <main style="margin-top: 10px;">
        <ul class="nav-links">
            <li><a href="UserList.php">User list</a></li>
            <li><a href="http://localhost/HiTDA/Peer%20Connect/peerConnectAdmin.html">Manage Session</a></li>
            <li><a href="http://localhost/HiTDA/Resource%20Sharing/adminDashboard.html">Manage Resource</a></li>
            <li><a href="http://localhost/HiTDA/Sprint%201/eventManagement.php">Manage Events</a></li>
            <li><a href="http://localhost/HiTDA/Sprint%202/ViewRegisteredStud.php">View Registered Student</a></li>
            <li><a href="http://localhost/HiTDA/Knowledge%20Forum/adminForum.html">Manage Forum</a></li>
            <li><a href="http://localhost/HiTDA/Article/adminartcile.php">Manage Article</a></li>
            <li><a href="http://localhost/HiTDA/Website%20Analytics/rewards.php">Student Activity</a></li>
            <li><a href="http://localhost/HiTDA/Website%20Analytics/engagement.php">Article Engagement</a></li>
            <li><a href="http://localhost/HiTDA/Feedback%20and%20Reporting/track-report.php">Feedback</a></li>
            <li><a href="http://localhost/HiTDA/Payment&Billing/TrackPaymentBilling.php">Manage Payment</a></li>
        </ul>
        <!-- User Data Chart -->
        <div class="user-chart">
            <h2>User Statistics</h2>
            <canvas id="userChart" width="400" height="200"></canvas>
        </div>
    </main>

    <script>
        // Fetch user data from the PHP backend
        fetch('fetch_chart_data.php')
        .then(response => response.json())
        .then(data => {
            const ctx = document.getElementById('userChart').getContext('2d');

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: [
                        'Students - Active',
                        'Students - Inactive',
                        'Lecturers - Active',
                        'Lecturers - Inactive'
                    ],
                    datasets: [{
                        label: 'User Status',
                        data: [
                            data.active_students,
                            data.inactive_students,
                            data.active_lecturers,
                            data.inactive_lecturers
                        ],
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.6)', // Students - Active
                            'rgba(255, 99, 132, 0.6)', // Students - Inactive
                            'rgba(54, 162, 235, 0.6)', // Lecturers - Active
                            'rgba(255, 206, 86, 0.6)'  // Lecturers - Inactive
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        title: {
                            display: true,
                            text: 'Distribution of Active and Inactive Users'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            title: {
                                display: true,
                                text: 'Number of Users'
                            }
                        }
                    }
                }
            });
        })
        .catch(error => console.error('Error fetching chart data:', error));

    </script>

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
