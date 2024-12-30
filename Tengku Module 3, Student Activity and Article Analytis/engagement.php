<?php
// database connection
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Query to fetch article details with content views
$sql = "
    SELECT a.id, a.title, a.summary, a.created_at, cv.views
    FROM article a
    LEFT JOIN content_views cv ON a.id = cv.article_id
    WHERE a.status = 'approved'
    ORDER BY a.created_at DESC
";

$result = $conn->query($sql);
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
            <div class="engage">
                <section class="art">
                    <h1>Articles</h1>
                    <?php
                    // Define articles per page
                    $articlesPerPage = 3;

                    // Get the current page from the URL, default to page 1
                    $page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;

                    // Calculate the offset for the SQL query
                    $offset = ($page - 1) * $articlesPerPage;

                    // Fetch the total number of articles securely
                    $stmtTotal = $conn->prepare("SELECT COUNT(*) AS total FROM article");
                    $stmtTotal->execute();
                    $totalArticlesResult = $stmtTotal->get_result();
                    $totalArticles = $totalArticlesResult->fetch_assoc()['total'];

                    // Calculate the total number of pages
                    $totalPages = ceil($totalArticles / $articlesPerPage);

                    // Fetch articles for the current page, including views
                    $stmt = $conn->prepare("
                        SELECT a.title, a.summary, IFNULL(cv.views, 0) AS views, a.created_at 
                        FROM article a
                        LEFT JOIN content_views cv ON a.id = cv.article_id
                        LIMIT ? OFFSET ?
                    ");
                    $stmt->bind_param("ii", $articlesPerPage, $offset);
                    $stmt->execute();
                    $result = $stmt->get_result();

                    if ($result->num_rows > 0) {
                        // Loop through and display articles
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='article'>";
                            echo "<h2>" . htmlspecialchars($row['title']) . "</h2>";
                            echo "<p><strong>Summary:</strong> " . htmlspecialchars_decode($row['summary']) . "</p>";
                            echo "<p><strong>Views:</strong> " . $row['views'] . "</p>";
                            echo "<p><strong>Published:</strong> " . $row['created_at'] . "</p>";
                            echo "</div>";
                            echo "<hr>";
                        }
                    } else {
                        echo "<p>No articles available.</p>";
                    }

                    // Generate pagination links
                    echo "<div class='pagination'>";
                    if ($page > 1) {
                        echo "<a href='?page=" . ($page - 1) . "'>Previous</a> ";
                    }
                    for ($i = 1; $i <= $totalPages; $i++) {
                        if ($i === $page) {
                            echo "<a class='current-page'>$i</a> ";
                        } else {
                            echo "<a href='?page=$i'>$i</a> ";
                        }
                    }
                    if ($page < $totalPages) {
                        echo "<a href='?page=" . ($page + 1) . "'>Next</a>";
                    }
                    echo "</div>";
                    ?>

                </section>

                <section class="chart">
                    <h1>Views by Tags</h1>
                    <canvas id="viewsChart"></canvas>
                </section>
            </div>
        </main>

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            // Fetch data from chart_data.php
            fetch('chart_data.php')
                .then(response => response.json())
                .then(data => {
                    // Extract tags and views from the fetched data
                    const tags = data.map(item => item.tag);
                    const views = data.map(item => item.views);

                    // Create the pie chart
                    const ctx = document.getElementById('viewsChart').getContext('2d');
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: tags,
                            datasets: [{
                                data: views,
                                backgroundColor: [
                                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                                    '#FF9F40', '#FF6384', '#36A2EB', '#FFCE56'
                                ],
                                hoverBackgroundColor: [
                                    '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF',
                                    '#FF9F40', '#FF6384', '#36A2EB', '#FFCE56'
                                ]
                            }]
                        },
                        options: {
                            responsive: true,
                            plugins: {
                                legend: {
                                    position: 'top',
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function (tooltipItem) {
                                            return `${tooltipItem.label}: ${tooltipItem.raw} views`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                })
                .catch(error => console.error('Error fetching data:', error));
        </script>

        <script src="rw.js"></script>

        <!-- <footer>
            <div class="content">
                <div class="top">
                    <div class="logo-details">
                        <i class="fab fa-slack">
                            <span class="logo_name">UTM</span>
                        </i>

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
        </footer> -->
    </body>
</html>