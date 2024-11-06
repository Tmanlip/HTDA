<?php
include 'db_connect.php' ;
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE-edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Login Page</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

        <!-- CSS -->
        <link rel="stylesheet" href="login.css">

        <!-- Boxicons CSS-->
        <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    </head>

    <body>
        <header>
            <img src="Logo-UTM-white.png" alt="UTM Logo" class="header-image">
            <i class='bx bx-x exem'></i>
            <span class="text">TutorXcells</span>
        </header>

        <!-- <nav>
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
        </nav> -->

        <main>
            <div class="login-wrapper">
                <form action="#">
                    <h2>Login</h2>
                    <div class="input-field">
                        <input type="username" id="username" required>
                        <label >Enter your username</label>
                    </div>

                    <div class="input-field">
                        <input type="password" id="password" required>
                        <label >Enter your password</label>
                    </div>

                    <div class="password-options">
                        <label for="remember">
                            <input type="checkbox" id="remember">
                            <p>Remember me</p>
                        </label>

                        <label for="Forgot">
                            <a href="">Forgot Password</a>
                        </label>
                    </div>

                    <button type="submit" id="submit">Log In</button>
                </form>
            </div>
        </main>

        <script type="module" src="config.js"></script>
        
        <script src="script.js"></script>

    </body>
</html>
