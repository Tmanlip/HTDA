<?php
include 'C:\xampp\htdocs\HiTDA\session_handler.php';
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

        <!-- CSS -->
        <link rel="stylesheet" href="reward.css">

        <!-- Boxicons CSS-->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <title>Responsive Navigation Menu Bar</title>
    </head>
 
    <body>
        <nav>
            <div class="nav-bar">
                <i class='bx bx-menu sideBarOpen'></i>
                <span class="logo navLogo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php">TutorXcells</a></span>

                <div class="menu">
                    <div class="logo-toggle">
                        <span class="logo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php">TutorXcells</a></span>
                        <i class='bx bx-x sideBarClosed'></i>
                    </div>

                    <ul class="nav-links">
                        <li><a href="http://localhost/HiTDA/Administrative%20Dashboard/UserList.php">User list</a></li>
                        <li><a href="http://localhost/HiTDA/Feedback%20and%20Reporting/track-report.php">Feedback & Reporting</a></li>
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
            <div class="container">
                <h1>Academic Analytics Dashboard</h1>
        
                <!-- Peer Collaborations Chart -->
                <div class="section">
                    <h2>Peer Collaborations</h2>
                    <canvas id="collaborationsChart"></canvas>
                </div>
        
                <!-- Forum Contributions Chart -->
                <div class="section">
                    <h2>Forum Contributions</h2>
                    <canvas id="contributionsChart"></canvas>
                </div>
        
                <!-- Merit Scores Chart -->
                <div class="section">
                    <h2>Merit Scores</h2>
                    <canvas id="meritScoresChart"></canvas>
                </div>
        
                <!-- Shared Resources Chart -->
                <div class="section">
                    <h2>Shared Resources</h2>
                    <canvas id="sharedResourcesChart"></canvas>
                </div>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function () {
                fetch('analytics.php')
                .then(response => response.json())
                .then(data => {
                    console.log('Analytics Data:', data);

                    // Render Peer Collaborations Chart
                    const collaborationsChart = renderChart(
                        'collaborationsChart',
                        'Peer Collaborations',
                        data.collaborations,
                        'collaborations'
                    );
                        
                    addChartClickListener(collaborationsChart, data.collaborations);

                    // Render Forum Contributions Chart
                    const contributionsChart = renderChart(
                        'contributionsChart',
                        'Forum Contributions',
                        data.contributions,
                        'contributions'
                    );
                        
                    addChartClickListener(contributionsChart, data.contributions);

                    // Render Merit Scores Chart
                    const meritScoresChart = renderChart(
                        'meritScoresChart',
                        'Merit Scores',
                        data.merit_scores,
                        'merit_score'
                    );
                     
                    addChartClickListener(meritScoresChart, data.merit_scores);

                    // Render Shared Resources Chart
                    const sharedResourcesChart = renderChart(
                        'sharedResourcesChart',
                        'Shared Resources',
                        data.shared_resources,
                        'shared_resources'
                    );
                        
                    addChartClickListener(sharedResourcesChart, data.shared_resources);
                })
                .catch(error => console.error('Error fetching data:', error));
            });

            // Function to render a chart
            function renderChart(chartId, title, data, valueKey) {
                const ctx = document.getElementById(chartId).getContext('2d');
                const labels = data.map(item => `Student ID: ${item.student_id}`);
                const values = data.map(item => item[valueKey]);

                return new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: title,
                            data: values,
                            backgroundColor: 'rgba(75, 192, 192, 0.6)',
                            borderColor: 'rgba(75, 192, 192, 1)',
                            borderWidth: 1
                        }]
                    },
                    options: {
                        responsive: true,
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            }

            // Function to add a click listener to a chart
            function addChartClickListener(chart, studentData) {
                document.getElementById(chart.canvas.id).onclick = function (evt) {
                    const points = chart.getElementsAtEventForMode(evt, 'nearest', { intersect: true }, true);
                    if (points.length) {
                        const index = points[0].index;
                        const student = studentData[index];

                        // Create and submit a hidden form
                        const form = document.createElement('form');
                        form.method = 'POST';
                        form.action = 'student_info.php';

                        // Add student ID
                        const studentIdInput = document.createElement('input');
                        studentIdInput.type = 'hidden';
                        studentIdInput.name = 'student_id';
                        studentIdInput.value = student.student_id;
                        form.appendChild(studentIdInput);

                        // Submit the form
                        document.body.appendChild(form);
                        form.submit();
                    }
                };
            }
        </script>

        <script src="rw.js"></script>

        <footer>
            <div class="content">
                <div class="top">
                    <div class="logo-details">
                        <img src="http://localhost/HiTDA/Module%201/upload/Logo-UTM-white.png" alt="UTM Logo" class="footer-image">
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