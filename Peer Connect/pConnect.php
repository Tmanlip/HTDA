<?php
require 'C:\xampp\htdocs\HiTDA\db_connect.php';
include 'C:\xampp\htdocs\HiTDA\session_handler.php';

$username = $_SESSION['username'];
$usertype = $_SESSION['user_type'];

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
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peer Connect - Study Sessions</title>
    <link rel="stylesheet" href="pConnect.css">
     <!-- Boxicons CSS-->
     <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
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
                <li><a href="http://localhost/HiTDA/Knowledge%20Forum/forum.html">Forum</a></li>
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
                        <input type="text" id="search-session" placeholder="Search...">
                        <i class='bx bx-search' onclick="searchSession()"></i>
                    </div>
                </div>

                <span class="logout"><a href="http://localhost/HiTDA/User%20Dashboard/logout.php" style="text-decoration: none;">Log Out</a></span>
            </div>
        </div>
    </nav>

    <main>
        <header>
            <h1>Find Your Study Session</h1>
        </header>
        
        <section class="form-section">
            <h2>Create a Study Session</h2>
            <form method="POST" action = "submit_sessions.php">
                <label for="subject">Preferred Subject:</label>
                <input type="text" id="session_name" name="session_name" placeholder="E.g., Mathematics" required>

                <label for="experience_level">Your Experience Level:</label>
                <select id="experience_level" name="experience_level" required>
                    <option value="" disabled selected>Select your experience level</option>
                    <option value="Beginner">Beginner</option>
                    <option value="Intermediate">Intermediate</option>
                    <option value="Advanced">Advanced</option>
                </select>

                <label for="time">Preferred Time:</label>
                <select id="time" name="time" required>
                    <option value="" disabled selected>Select your preferred time</option>
                    <option value="Weekdays Morning">Weekdays Morning</option>
                    <option value="Weekdays Afternoon">Weekdays Afternoon</option>
                    <option value="Weekdays Evening">Weekdays Evening</option>
                    <option value="Weekends Morning">Weekends Morning</option>
                    <option value="Weekends Afternoon">Weekends Afternoon</option>
                    <option value="Weekends Evening">Weekends Evening</option>
                </select>

                <label for="location">Preferred Venue:</label>
                <input type="text" id="location" name="location" placeholder="E.g., Library, Café" required>

                <label for="max_participants">Max Participants:</label>
                <input type="number" id="max_participants" name="max_participants" min="1" placeholder="Max participants" required>

                <input type="hidden" id="user_type" name="user_type" value="<?php echo $usertype; ?>">
                <input type="hidden" id="matric_no" name="matric_no" value="<?php echo $student_id; ?>">
                <button type="submit">Create Study Session</button>
            </form>
        </section>

        <section class="results-section">
            <h2>Available Study Sessions</h2>
            <ul id="sessions-list">
                <!-- Dynamic session cards will be inserted here -->
            </ul>
        </section>
    </main>

    <script src="pConnect.js"></script>
    <script src="script.js"></script>
    <script>
        fetch('fetch_sessions.php')
            .then(response => response.json())
            .then(sessions => {
                const sessionsList = document.getElementById('sessions-list');
                sessionsList.innerHTML = '';
        
                sessions.forEach(session => {
                    const card = document.createElement('div');
                    card.classList.add('session-card');
                    card.innerHTML = `
                        <h3>${session.session_name}</h3>
                        <p><strong>Time:</strong> ${session.time}</p>
                        <p><strong>Location:</strong> ${session.location}</p>
                        <p><strong>Experience:</strong> ${session.experience_level}</p>
                        <p><strong>Members:</strong> ${session.members}/${session.max_participants}</p>
                        ${session.members < session.max_participants 
                            ? `
                                <button class="join-button" onclick="joinSession(${session.id}, 'student', 'A22EC0283')">Join</button>
                            ` 
                            : '<span>Full</span>'
                        }
                    `;
                    sessionsList.appendChild(card);
                });
            })
            .catch(error => console.error('Error:', error));

            
        
            function joinSession(sessionId) {
                if (!sessionId) {
                    console.error('Session ID is undefined');
                    return;
                }

                // Fetch user type and student ID from PHP
                const usertype = "<?php echo $usertype; ?>";
                const studentId = "<?php echo $student_id; ?>";

                fetch('join-session.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/json' },
                    body: JSON.stringify({
                        session_id: sessionId,
                        user_type: usertype,
                        student_id: studentId
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        alert('Successfully joined the session!');
                        location.reload();
                    } else {
                        alert(data.message || 'Error joining session');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Failed to join session');
                });
            }

        function searchSession() {
            const searchInput = document.getElementById('search-session').value.toLowerCase();
            
            // Log the search input to verify it's being captured
            console.log("Search Input:", searchInput);
            
            fetch('fetch_sessions.php?search=' + encodeURIComponent(searchInput))  // Send search query as a GET parameter
                .then(response => response.json())
                .then(sessions => {
                    console.log("Fetched Sessions:", sessions);  // Log the fetched sessions
                    
                    const filteredSessions = sessions.filter(session => 
                        session.session_name.toLowerCase().includes(searchInput) ||
                        session.location.toLowerCase().includes(searchInput) ||
                        session.time.toLowerCase().includes(searchInput) ||
                        session.experience_level.toLowerCase().includes(searchInput)
                    );
                    
                    console.log("Filtered Sessions:", filteredSessions);  // Log the filtered sessions
                    
                    updateSessionsList(filteredSessions);
                })
                .catch(error => console.error('Error:', error));
        }



        function updateSessionsList(sessions) {
            const sessionsList = document.getElementById('sessions-list');
            sessionsList.innerHTML = '';
            
            if (sessions.length === 0) {
                sessionsList.innerHTML = '<p>No sessions found</p>';
                return;
            }

            sessions.forEach(session => {
                const card = document.createElement('div');
                card.classList.add('session-card');
                card.innerHTML = `
                    <h3>${session.session_name}</h3>
                    <p><strong>Time:</strong> ${session.time}</p>
                    <p><strong>Location:</strong> ${session.location}</p>
                    <p><strong>Experience:</strong> ${session.experience_level}</p>
                    <p><strong>Members:</strong> ${session.members}/${session.max_participants}</p>
                    ${session.members < session.max_participants 
                        ? `<button class="join-button" onclick="joinSession(${session.id})">Join</button>` 
                        : '<span>Full</span>'}
                `;
                sessionsList.appendChild(card);
            });
        }
    </script>

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