<?php
include 'C:\xampp\htdocs\HiTDA\session_handler.php';
?>
<html>
<head>
    <title>Event and Scheduling Form</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="navbar.css">
</head>

<body>
    <nav>
        <div class="nav-bar">
            <i class='bx bx-menu sideBarOpen'></i>
            <span class="logo navLogo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php">TutorXcells</a></span>

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
        <div class="container mx-auto mt-8">
            <div class="bg-gray-700 p-6 rounded-lg">
                <h2 class="text-center text-white font-bold text-2xl mb-4">Event and Scheduling Form</h2>
                <div class="mb-6">
                    <h3 class="text-white font-bold text-xl mb-2">Create Event</h3>
                    <form class="bg-gray-300 p-4 rounded-lg" action="addevet.php" method="POST">
                        <div class="mb-4">
                            <label class="block text-black mb-2" for="event-name">Event Name</label>
                            <input class="w-full p-2 rounded" type="text" id="event-name" name="event_name" placeholder="Enter event name" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-black mb-2" for="event-date">Date</label>
                            <input class="w-full p-2 rounded" type="date" id="event-date" name="seminar_date" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-black mb-2" for="event-time">Time</label>
                            <input class="w-full p-2 rounded" type="time" id="event-time" name="time" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-black mb-2" for="event-location">Location</label>
                            <input class="w-full p-2 rounded" type="text" id="event-location" name="place" placeholder="Enter location (physical or virtual)" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-black mb-2" for="event-speaker">Speaker Information</label>
                            <input class="w-full p-2 rounded" type="text" id="event-speaker" name="speaker" placeholder="Enter speaker information" required>
                        </div>
                        <div class="mb-4">
                            <label class="block text-black mb-2" for="event-description">Description</label>
                            <textarea class="w-full p-2 rounded" id="event-description" name="description" placeholder="Enter event description" required></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="block text-black mb-2" for="event-category">Category</label>
                            <select class="w-full p-2 rounded" id="event-category" name="category">
                                <option>Academic</option>
                                <option>Career-related</option>
                                <option>Skill Development</option>
                            </select>
                        </div>
                        <div class="mb-4">
                            <label class="block text-black mb-2" for="event-recurring">Recurring Event</label>
                            <input type="checkbox" id="event-recurring" name="recurring">
                            <label for="event-recurring" class="text-black ml-2">Yes</label>
                        </div>
                        <button class="bg-green-500 text-white px-4 py-2 rounded" type="submit">Create Event</button>
                    </form>
                </div>
            </div>
        </div>
    
        <!-- Modal -->
        <div id="event-modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg w-96">
                <h3 class="text-black font-bold text-xl mb-4">Event Created Successfully!</h3>
                <p><strong>Event Name:</strong> <span id="modal-event-name"></span></p>
                <p><strong>Date:</strong> <span id="modal-event-date"></span></p>
                <p><strong>Time:</strong> <span id="modal-event-time"></span></p>
                <p><strong>Location:</strong> <span id="modal-event-location"></span></p>
                <p><strong>Speaker:</strong> <span id="modal-event-speaker"></span></p>
                <p><strong>Description:</strong> <span id="modal-event-description"></span></p>
                <p><strong>Category:</strong> <span id="modal-event-category"></span></p>
                <p><strong>Recurring:</strong> <span id="modal-event-recurring"></span></p>
                <button class="bg-red-500 text-white px-4 py-2 rounded mt-4" onclick="closeModal()">Close</button>
            </div>
        </div>
    </main>

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

    <script src="script.js"></script>
</body>
</html>
