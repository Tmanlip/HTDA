<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Number of events to display per page
$events_per_page = 3;

// Get the current page from the URL, default to 1 if not set
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$offset = ($page - 1) * $events_per_page;

// Query to get event details and participants with pagination
$sql = "
    SELECT s.event_name, s.seminar_date, st.stud_name, st.email, p.registration_date
    FROM seminar s
    LEFT JOIN participation p ON s.id = p.seminar_id
    LEFT JOIN students st ON p.participant_id = st.matric_no
    WHERE p.role = 'student' OR p.participant_id IS NULL
    ORDER BY s.seminar_date DESC
    LIMIT $events_per_page OFFSET $offset
";
$result = $conn->query($sql);

// Query to get the total number of events for pagination
$total_events_sql = "SELECT COUNT(DISTINCT s.id) AS total_events FROM seminar s LEFT JOIN participation p ON s.id = p.seminar_id";
$total_events_result = $conn->query($total_events_sql);
$total_events_row = $total_events_result->fetch_assoc();
$total_events = $total_events_row['total_events'];
$total_pages = ceil($total_events / $events_per_page);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Registered Participants</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="event.css">
    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark');
        }

        // Function to delete a row
        function deleteRow(button) {
            const row = button.closest("tr"); // Find the closest table row
            row.remove(); // Remove the row from the DOM
        }
    </script>
</head>
<body class="bg-red-900 text-black">
<nav>
            <div class="nav-bar">
                <i class='bx bx-menu sideBarOpen'></i>
                <span class="logo navLogo"><a href="http://localhost/HiTDA/Administrative%20Dashboard/AdminHome.php">TutorXcells</a></span>

                <div class="menu">
                    <div class="logo-toggle">
                        <span class="logo"><a href="http://localhost/HiTDA/User%20Dashboard/StudentDashboard.php">TutorXcells</a></span>
                        <i class='bx bx-x sideBarClosed'></i>
                    </div>

                    <ul class="nav-links">
                        <li><a href="http://localhost/HiTDA/Sprint%203/AdminViewAttendance.php">Student Attendance</a></li>
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
    <div class="container mx-auto mt-8 p-4 bg-white shadow-md rounded-lg max-w-4xl">
        <h1 class="text-2xl font-bold text-center mb-4">Registered Participants</h1>
        
        <?php
        $current_event = null;
        if ($result->num_rows > 0) {
            $event_participants = [];
            
            // Fetch all rows and group participants by event
            while ($row = $result->fetch_assoc()) {
                $event_participants[$row['event_name']][] = $row;
            }
            
            // Display each event with its participants
            foreach ($event_participants as $event_name => $participants) {
                echo "<div class='mb-8 p-6 bg-gray-100 rounded-lg shadow-md'>";
                echo "<h2 class='text-xl font-semibold mb-4'>" . $event_name . "</h2>";
                echo "<p class='text-sm text-gray-500'>" . date('d/m/Y', strtotime($participants[0]['seminar_date'])) . "</p>";
                
                if (count($participants) > 0) {
                    echo "<table class='table-auto w-full border-collapse border border-gray-300'>";
                    echo "<thead><tr class='bg-gray-200'>
                            <th class='border border-gray-300 px-4 py-2'>Participant Name</th>
                            <th class='border border-gray-300 px-4 py-2'>Email</th>
                            <th class='border border-gray-300 px-4 py-2'>Registration Date</th>
                            <th class='border border-gray-300 px-4 py-2'>Actions</th>
                          </tr></thead><tbody>";
                    
                    // Output participant details
                    foreach ($participants as $row) {
                        echo "<tr>";
                        echo "<td class='border border-gray-300 px-4 py-2'>" . $row['stud_name'] . "</td>";
                        echo "<td class='border border-gray-300 px-4 py-2'>" . $row['email'] . "</td>";
                        echo "<td class='border border-gray-300 px-4 py-2'>" . $row['registration_date'] . "</td>";
                        echo "<td class='border border-gray-300 px-4 py-2 text-center'>
                                <button onclick='deleteRow(this)' class='bg-red-500 text-white px-3 py-1 rounded'>Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                    echo "</tbody></table>";
                } else {
                    // Display message if no participants
                    echo "<p class='text-center text-gray-500'>No participants</p>";
                }
                echo "</div>"; // Close event block
            }
        } else {
            echo "<p class='text-center'>No events found</p>";
        }
        ?>

        <!-- Pagination Links -->
        <div class="mt-4 text-center">
            <?php if ($page > 1): ?>
                <a href="?page=<?php echo $page - 1; ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Previous</a>
            <?php endif; ?>
            
            <?php if ($page < $total_pages): ?>
                <a href="?page=<?php echo $page + 1; ?>" class="bg-blue-500 text-white px-4 py-2 rounded">Next</a>
            <?php endif; ?>
        </div>
    </div>

    <?php $conn->close(); ?>
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

        <script src="script.js"></script>
</body>
</html>
