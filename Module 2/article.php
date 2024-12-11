<?php
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "Invalid access.";
    exit;
}

// Retrieve data from POST
$id = $_POST['id'] ?? null;
$title = $_POST['title'] ?? null;
$name = $_POST['name'] ?? null;
$email = $_POST['email'] ?? null;
$summary = $_POST['summary'] ?? null;
$content = $_POST['content'] ?? null;

if (!$id || !$title || !$name || !$email) {
    echo "Incomplete data received.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Approved Articles</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

    <!-- CSS -->
    <link rel="stylesheet" href="artcile.css">

    <!-- Boxicons CSS-->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
</head>

<body>
    <header>
        <h1>Articles</h1>
    </header>

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
        <?php if (count($approvedArticles) > 0): ?>
            <?php foreach ($approvedArticles as $article): ?>
                <div class="display-container">
                    <h2><?php echo htmlspecialchars($article['title']); ?></h2>
                    <p><strong>Author:</strong> <?php echo htmlspecialchars($article['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($article['email']); ?></p>
                    <p><strong>Summary:</strong> <?php echo htmlspecialchars_decode($article['summary']); ?></p>
                    <div><?php echo htmlspecialchars_decode($article['content']); ?></div>
                    <?php if (!empty($article['image'])): ?>
                        <img src="<?php echo htmlspecialchars($article['image']); ?>" alt="Article Image">
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No approved articles found.</p>
        <?php endif; ?>
    </main>

    <script src="artcie.js"></script>

</body>
</html>
