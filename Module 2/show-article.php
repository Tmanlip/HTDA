<?php // Read the JSON file 
$filePath = 'articles.json'; 
$data = json_decode(file_get_contents($filePath), true); // Get the article ID from the POST parameter 
$id = isset($_POST['id']) ? (int)$_POST['id'] : 0; // Find the article by ID 
$article = null; 
foreach ($data as $item) { 
    if ($item['id'] === $id) { 
        $article = $item; 
        break; 
    } 
} 
if (!$article) { 
    echo "Article not found."; 
    exit; 
} 
$name = htmlspecialchars($article['name']); 
$email = htmlspecialchars($article['email']); 
$title = htmlspecialchars($article['title']); 
$content = htmlspecialchars_decode($article['content']); // Decode HTML entities 
$summary = htmlspecialchars_decode($article['summary']); 
$image = $article['image']; 
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

                <span class="logout"><a href="logout.php" style="text-decoration: none;">Log Out</a></span>
            </div>
        </nav>
        
        <main>

        <form method="post" action="approve.php" class="button-box">
            <button type="submit" name="action" value="approve" class="approve">Approve Article</button>
            <button type="submit" name="action" value="reject" class="reject">Reject Article</button>
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <input type="hidden" name="email" value="<?php echo $email; ?>">
            <input type="hidden" name="name" value="<?php echo $name; ?>">
            <input type="hidden" name="title" value="<?php echo $title; ?>">
        </form>

            <!-- <div class="button-box">
                <button type="submit" class="approve">Publish Article</button>
                <button type="submit" class="reject">Publish Article</button>
            </div> -->

            <div class="display-container">
                <h1><?php echo $title; ?></h1> 
                <p><strong>Author:</strong> <?php echo $name; ?></p> 
                <p><strong>Email:</strong> <?php echo $email; ?></p> 
                <p><strong>Summary:</strong> <?php echo $summary; ?></p>
                <br><br> 
                <div>
                    <?php echo $content; ?>
                </div> 
                <?php if ($image): ?> 
                    <img src="<?php echo $image; ?>" alt="Article Image"> 
                <?php endif; ?>
            </div>
        </main>

        <script src="artcie.js"></script>

        <!-- <footer>
            <div class="content">
                <div class="top">
                    <div class="logo-details">
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