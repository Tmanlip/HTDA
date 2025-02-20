<?php
// Database connection
include 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Fetch approved articles from the database
$sql = "SELECT * FROM article WHERE status = 'approved'";
$result = $conn->query($sql);

$approvedArticles = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $approvedArticles[] = $row;
    }
}

// Get the selected tag from the POST request (if any)
$selectedTag = isset($_POST['tag']) ? $_POST['tag'] : null;

// Filter articles based on the selected tag
$filteredArticles = [];
if ($selectedTag) {
    foreach ($approvedArticles as $article) {
        $outerTags = json_decode($article['tags'], true);
        $matchFound = false;

        if (is_array($outerTags)) {
            foreach ($outerTags as $innerTagJson) {
                $innerTags = json_decode($innerTagJson, true);
                if (is_array($innerTags)) {
                    foreach ($innerTags as $tag) {
                        if ($tag['value'] === $selectedTag) {
                            $filteredArticles[] = $article;
                            $matchFound = true;
                            break;
                        }
                    }
                }
                if ($matchFound) break;
            }
        }
    }
} else {
    $filteredArticles = $approvedArticles; // Show all approved articles if no tag is selected
}

// Pagination logic
$articlesPerPage = 6;
$currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$totalArticles = count($filteredArticles);
$totalPages = ceil($totalArticles / $articlesPerPage);
$offset = ($currentPage - 1) * $articlesPerPage;
$currentArticles = array_slice($filteredArticles, $offset, $articlesPerPage);
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

        <!-- CSS -->
        <link rel="stylesheet" href="artcile.css">

        <!-- Boxicons CSS-->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

        <title>Responsive Navigation Menu Bar</title>
    </head>

    <body>
        <nav>
            <div class="nav-bar">
                <i class='bx bx-menu sideBarOpen'></i>
                <span class="logo navLogo"><a href="http://localhost/HiTDA/User%20Dashboard/StudentDashboard.php">TutorXcells</a></span>

                <div class="menu">
                    <div class="logo-toggle">
                        <span class="logo"><a href="http://localhost/HiTDA/User%20Dashboard/StudentDashboard.php">TutorXcells</a></span>
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

                <span class="logout"><a href="http://localhost/HiTDA/User%20Dashboard/logout.php" style="text-decoration: none;">Log Out</a></span>
            </div>
        </nav>

        <main>
            <!-- Tags Section -->
            <div class="button-box">
                <h2>Tags</h2>
                <form action="" method="POST">
                    <ul>
                        <li><button type="submit" name="tag" value="">All</button></li>
                        <?php
                            // Extract all unique tags from the articles
                            $tagsSet = [];
                            foreach ($approvedArticles as $article) {
                                $outerTags = json_decode($article['tags'], true);
                                if (is_array($outerTags)) {
                                    foreach ($outerTags as $innerTagJson) {
                                        $innerTags = json_decode($innerTagJson, true);
                                        if (is_array($innerTags)) {
                                            foreach ($innerTags as $tag) {
                                                if (isset($tag['value'])) {
                                                    $tagsSet[$tag['value']] = true;
                                                }
                                            }
                                        }
                                    }
                                }
                            }

                            // Display buttons for each tag
                            foreach (array_keys($tagsSet) as $tagValue) {
                                echo "<li><button type=\"submit\" name=\"tag\" value=\"" . htmlspecialchars($tagValue) . "\">" . htmlspecialchars($tagValue) . "</button></li>";
                            }
                        ?>
                    </ul>
                </form>
            </div>

            <!-- Articles Section -->
            <div class="display-container">
            <h2>Approved Articles</h2>
            <?php if (empty($currentArticles)): ?>
                <p>No articles found for the selected tag.</p>
            <?php else: ?>
                <div class="article-container">
                    <?php foreach ($currentArticles as $article): ?>
                        <div class="article">
                            <p><strong>Author:</strong> <?php echo htmlspecialchars($article['name']); ?></p>
                            <p><strong>Summary:</strong> <?php echo htmlspecialchars_decode($article['summary']); ?></p>
                            <div class="tags-container">
                                <?php
                                $outerTags = json_decode($article['tags'], true);
                                if (is_array($outerTags)) {
                                    foreach ($outerTags as $innerTagJson) {
                                        $innerTags = json_decode($innerTagJson, true);
                                        if (is_array($innerTags)) {
                                            foreach ($innerTags as $tag) {
                                                if (isset($tag['value'])) {
                                                    echo "<span class=\"tag\">" . htmlspecialchars($tag['value']) . "</span>";
                                                }
                                            }
                                        }
                                    }
                                }
                                ?>
                            </div>
                            <form action="pok.php" method="POST">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($article['id']); ?>">
                                <button type="submit" style="background:none;border:none;text-align:left;padding:0;color:inherit;">Read More</button>
                            </form>
                        </div>
                    <?php endforeach; ?>
                </div>
                <!-- Pagination -->
                <div class="pagination">
                    <?php if ($currentPage > 1): ?>
                        <a href="?page=<?php echo $currentPage - 1; ?>">&laquo; Previous</a>
                    <?php endif; ?>
                    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
                        <a href="?page=<?php echo $i; ?>" <?php echo $i === $currentPage ? 'style="font-weight: bold;"' : ''; ?>><?php echo $i; ?></a>
                    <?php endfor; ?>
                    <?php if ($currentPage < $totalPages): ?>
                        <a href="?page=<?php echo $currentPage + 1; ?>">Next &raquo;</a>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
        
        <a href="artcile.php">Add Article</a>

        </main>

        <script src="artcie.js"></script>

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
