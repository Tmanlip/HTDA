<?php
    include 'C:\xampp\htdocs\HiTDA\db_connect.php';
    include 'C:\xampp\htdocs\HiTDA\session_handler.php';

    $username = $_SESSION['username'];

    // Get the student ID using the username
    $stmt = $conn->prepare("SELECT matric_no FROM students WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $student = $result->fetch_assoc();

    if (!$student) {
        die("Invalid username.");
    }

    $student_id = $student['matric_no'];
?>

<!DOCTYPE html>
<html lang="en">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TutorXcells Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="event.css">
    </script>
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
                        <li><a href="http://localhost/HiTDA/Knowledge%20Forum/forum.php">Forum</a></li>
                        <li><a href="http://localhost/HiTDA/Article/disparticle.php">Article</a></li>
                        <li><a href="http://localhost/HiTDA/Website%20Analytics/update.php">Goals</a></li>
                        <li><a href="http://localhost/HiTDA/Sprint%203/submit_attendance.php">Mark Attendance</a></li>
                        <li><a href="http://localhost/HiTDA/Sprint%202/eventPage.php">Events</a></li>
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
    <div id="home" class="container mx-auto mt-8 p-4 bg-gray-300 rounded-lg">
            <h1 class="text-center text-2xl font-bold text-black mb-4">Home Dashboard</h1>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                <!-- Upcoming Events -->
                <div class="bg-gray-500 p-4 rounded-lg">
                    <h2 class="text-xl font-bold text-black mb-2">Upcoming Events</h2>
                    <div id="home-upcoming-events" class="space-y-2">
                        <?php
                        // Fetch upcoming events for the student
                        $sql = "SELECT s.id, s.event_name, s.seminar_date, s.description, s.place, p.status 
                               FROM seminar s
                               LEFT JOIN participation p ON s.id = p.seminar_id AND p.participant_id = ?
                               WHERE s.seminar_date >= CURDATE()
                               ORDER BY s.seminar_date ASC LIMIT 5";
                        $stmt = $conn->prepare($sql);
                        $stmt->bind_param("s", $student_id);
                        $stmt->execute();
                        $result = $stmt->get_result();

                        if ($result->num_rows > 0) {
                            while ($row = $result->fetch_assoc()) {
                                $isRegistered = !empty($row['status']);
                                echo "<div class='block bg-gray-400 p-2 rounded'>";
                                echo "<p class='text-black'><strong>Event:</strong> {$row['event_name']}</p>";
                                echo "<p class='text-black'><strong>Date:</strong> {$row['seminar_date']}</p>";
                                echo "<p class='text-black'><strong>Description:</strong> {$row['description']}</p>";
                                echo "<p class='text-black'><strong>Location:</strong> {$row['place']}</p>";
                                
                                if (!$isRegistered) {
                                    echo "<form action='http://localhost/HiTDA/Payment&Billing/PaymentForm.php' method='POST'>
                                            <input type='hidden' name='seminar_id' value='{$row['id']}'>
                                            <button type='submit' class='bg-gray-500 p-2 rounded text-white'>Register</button>
                                          </form>";
                                } else {
                                    echo "<p class='text-green-500 font-bold'>Registered</p>";
                                }
                                echo "</div>";
                            }
                        } else {
                            echo "<p class='text-black'>No upcoming events.</p>";
                        }
                        ?>
                    </div>
                </div>
            <!-- Past Events -->
            <div class="bg-gray-500 p-4 rounded-lg">
                <h2 class="text-xl font-bold text-black mb-2">Past Events</h2>
                <div id="home-past-events" class="space-y-2">
                    <?php
                    // Fetch past events
                    $sql = "SELECT event_name, seminar_date, time, place FROM seminar WHERE seminar_date < CURDATE() ORDER BY seminar_date DESC LIMIT 5";
                    $result = $conn->query($sql);

                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<div class='bg-gray-400 p-2 rounded'>
                                    <p class='text-black'><strong>Event:</strong> {$row['event_name']}</p>
                                    <p class='text-black'><strong>Date:</strong> {$row['seminar_date']}</p>
                                    <p class='text-black'><strong>Time:</strong> {$row['time']}</p>
                                    <p class='text-black'><strong>Location:</strong> {$row['place']}</p>
                                  </div>";
                        }
                    } else {
                        echo "<p class='text-black'>No past events.</p>";
                    }
                    ?>
                </div>
            </div>

            <!-- Quick Links -->
            <div class="bg-gray-500 p-4 rounded-lg">
                <h2 class="text-xl font-bold text-black mb-2">Quick Links</h2>
                <ul class="list-disc list-inside text-black">
                    <li><a href="#calendar" class="text-blue-500 hover:underline">View Event Calendar</a></li>
                    <li><a href="#my-events" class="text-blue-500 hover:underline">My Events</a></li>
                    <li><a href="#profile" class="text-blue-500 hover:underline">Update Profile</a></li>
                    <li><a href="#analytics.html" class="text-blue-500 hover:underline">Analytics</a></li>
                </ul>
            </div>
        </div>
    </div>

    <div id="calendar" class="container mx-auto mt-8 p-4 bg-gray-300 rounded-lg">
        <h1 class="text-center text-2xl font-bold text-black mb-4">Event Calendar</h1>
        <?php
        // Set the timezone
        date_default_timezone_set('Asia/Kuala_Lumpur');

        // Get the current month and year from the query string or default to the current date
        $currentMonth = isset($_GET['month']) ? (int)$_GET['month'] : date('m');
        $currentYear = isset($_GET['year']) ? (int)$_GET['year'] : date('Y');

        // Adjust month and year for pagination
        if ($currentMonth < 1) {
            $currentMonth = 12;
            $currentYear--;
        } elseif ($currentMonth > 12) {
            $currentMonth = 1;
            $currentYear++;
        }

        // Get the first day of the month and total days in the month
        $firstDayOfMonth = date('w', strtotime("$currentYear-$currentMonth-01"));
        $totalDaysInMonth = date('t', strtotime("$currentYear-$currentMonth-01"));

        // Fetch events for the current month
        $sql = "SELECT event_name, seminar_date FROM seminar 
                WHERE MONTH(seminar_date) = $currentMonth AND YEAR(seminar_date) = $currentYear";
        $result = $conn->query($sql);
        $events = [];

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $day = date('j', strtotime($row['seminar_date']));
                $events[$day][] = $row['event_name'];
            }
        }

        // Display the month and year
        echo "<div class='bg-gray-500 p-4 rounded-lg mb-4'>";
        echo "<h2 class='text-center text-xl font-bold text-white mb-4'>" . date('F Y', strtotime("$currentYear-$currentMonth-01")) . "</h2>";

        // Display days of the week
        $daysOfWeek = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
        echo "<div class='grid grid-cols-7 gap-4 text-center font-bold text-black'>";
        foreach ($daysOfWeek as $day) {
            echo "<div>$day</div>";
        }
        echo "</div>";

        // Add empty cells for days before the first day of the month
        echo "<div class='grid grid-cols-7 gap-4'>";
        for ($i = 0; $i < $firstDayOfMonth; $i++) {
            echo "<div></div>";
        }

        // Display days of the month
        for ($day = 1; $day <= $totalDaysInMonth; $day++) {
            $class = isset($events[$day]) ? 'bg-yellow-500 text-black font-bold' : 'bg-gray-300 text-black';
            echo "<div class='p-2 rounded $class text-center'>
                    <span>$day</span>";

            // Display event names if any
            if (isset($events[$day])) {
                foreach ($events[$day] as $event) {
                    echo "<div class='text-xs'>$event</div>";
                }
            }
            echo "</div>";
        }

        echo "</div></div>";
        ?>
    </div>

    <div id="my-events" class="container mx-auto mt-8 p-4 bg-gray-300 rounded-lg">
        <h1 class="text-center text-2xl font-bold text-black mb-4">My Events</h1>
        <div class="space-y-4">
            <?php
            // Fetch registered events for the student from the participation table
            $sql = "SELECT e.id, e.event_name, e.seminar_date, e.time, e.place
                    FROM seminar e
                    JOIN participation p ON e.id = p.seminar_id
                    WHERE p.participant_id = ? AND p.role = 'student' ";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("s", $student_id);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    // Create a form for each event
                    echo "<div class='bg-gray-400 p-4 rounded'>
                            <form action='http://localhost/HiTDA/Sprint%203/submit_attendance.php' method='POST'>
                                <input type='hidden' name='seminar_id' value='{$row['id']}'>
                                <input type='hidden' name='matric_no' value='{$student_id}'>
                                <input type='hidden' name='event_name' value='{$row['event_name']}'>
                                <input type='hidden' name='seminar_date' value='{$row['seminar_date']}'>
                                <input type='hidden' name='time' value='{$row['time']}'>
                                <input type='hidden' name='place' value='{$row['place']}'>
                                <button type='submit' class='text-black'>
                                    <p><strong>Event:</strong> {$row['event_name']}</p>
                                    <p><strong>Date:</strong> {$row['seminar_date']}</p>
                                    <p><strong>Time:</strong> {$row['time']}</p>
                                    <p><strong>Location:</strong> {$row['place']}</p>
                                </button>
                            </form>
                        </div>";
                }
            } else {
                echo "<p class='text-black'>No events registered.</p>";
            }
            ?>
        </div>


    </div>
    </main>

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
