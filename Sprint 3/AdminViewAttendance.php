<?php
// Database connection
require 'C:\xampp\htdocs\HiTDA\db_connect.php';

// Fetch seminars happening within 1 month from today
$query = "
    SELECT id, event_name, seminar_date, 
           CASE 
               WHEN seminar_date < CURDATE() THEN 'Completed'
               ELSE 'Oncoming'
           END AS event_status
    FROM seminar 
    WHERE seminar_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
";
$seminars_result = mysqli_query($conn, $query);

// Fetch participants for seminars within 1 month from today
$query = "
    SELECT 
        s.matric_no, s.stud_name, s.email, 
        p.attendance AS attendance_status, 
        se.id AS seminar_id, 
        CASE 
            WHEN se.seminar_date < CURDATE() THEN 'Completed'
            ELSE 'Oncoming'
        END AS event_status
    FROM students s
    JOIN participation p ON s.matric_no = p.participant_id
    JOIN seminar se ON p.seminar_id = se.id
    WHERE se.seminar_date BETWEEN DATE_SUB(CURDATE(), INTERVAL 1 MONTH) AND DATE_ADD(CURDATE(), INTERVAL 1 MONTH)
";
$participants_result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Registered Participants</title>
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link href='https://unpkg.com/boxicons@2.1.1/css/boxicons.min.css' rel='stylesheet'>
    <script>
    function updateStatus(participantId, seminarId, selectElement) {
        const participant = participants.find(p => p.matric_no === participantId);
        if (participant) {
            participant.attendance_status = selectElement.value;

            // Update attendance in the database
            fetch('update_attendance.php', {
                method: 'POST',
                body: JSON.stringify({
                    matric_no: participantId,
                    attendance: selectElement.value,
                    seminar_id: seminarId // Pass seminar_id to ensure correct update
                }),
                headers: {
                    'Content-Type': 'application/json'
                }
            })
            .then(response => response.json())
            .then(data => {
                console.log(data); // Debugging the response from PHP
                if (data.status === "success") {
                    renderParticipants(document.getElementById("eventFilter").value);
                    updateSummary();
                } else {
                    alert("Failed to update attendance: " + (data.message || "Unknown error"));
                }
            })
            .catch(error => {
                console.error("Error updating attendance:", error);
                alert("Error updating attendance");
            });
        }
    }



    function renderParticipants(eventFilter) {
        const tableBody = document.getElementById("attendanceTable");
        tableBody.innerHTML = ""; // Clear current rows

        participants
            .filter(p => p.seminar_id == eventFilter)
            .forEach(p => {
                const row = `
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">${p.stud_name}</td>
                        <td class="border border-gray-300 px-4 py-2">${p.email}</td>
                        <td class="border border-gray-300 px-4 py-2">${p.event_status}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <select onchange="updateStatus('${p.matric_no}', '${p.seminar_id}', this)" class="border border-gray-300 p-2 rounded">
                                <option value="Present" ${p.attendance_status === 'Present' ? 'selected' : ''}>Present</option>
                                <option value="Absent" ${p.attendance_status === 'Absent' ? 'selected' : ''}>Absent</option>
                            </select>
                        </td>
                        <td class="border border-gray-300 px-4 py-2">
                            <button onclick="removeParticipant('${p.matric_no}')" class="bg-red-500 text-white px-3 py-1 rounded">Remove</button>
                        </td>
                    </tr>
                `;
                tableBody.innerHTML += row;
            });
    }



    function updateSummary() {
        const totalParticipants = participants.length;
        const totalPresent = participants.filter(p => p.attendance_status === 'present').length;
        const totalAbsent = participants.filter(p => p.attendance_status === 'absent').length;

        document.getElementById("totalParticipants").textContent = totalParticipants;
        document.getElementById("totalPresent").textContent = totalPresent;
        document.getElementById("totalAbsent").textContent = totalAbsent;
    }

    const participants = <?php echo json_encode(mysqli_fetch_all($participants_result, MYSQLI_ASSOC)); ?>;

    window.onload = () => {
        const eventFilter = document.getElementById("eventFilter");
        if (eventFilter.value) renderParticipants(eventFilter.value);
        updateSummary();
    };
</script>

</head>
<body class="bg-gray-100 text-gray-800">
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
                  <input type="text" placeholder="Search materials..." class="search-bar">
                <i class='bx bx-search'></i>
            </div>
          </div>
      </div>

      <span class="logout"><a href="http://localhost/HiTDA/User%20Dashboard/logout.php" style="text-decoration: none;">Log Out</a></span>
    </div>
  </nav>

  <main>
  <div class="container mx-auto mt-8 p-4">
        <h1 class="text-2xl font-bold mb-4">Attendance Tracking</h1>

        <label for="eventFilter" class="block font-bold mb-2">Select Event:</label>
        <select id="eventFilter" class="w-full border p-2 rounded mb-4" onchange="renderParticipants(this.value)">
            <option value="">Select an Event</option>
            <?php while ($seminar = mysqli_fetch_assoc($seminars_result)): ?>
                <option value="<?php echo $seminar['id']; ?>"><?php echo $seminar['event_name']; ?></option>
            <?php endwhile; ?>
        </select>

        <table class="table-auto w-full border-collapse border border-gray-300">
            <thead>
                <tr class="bg-gray-200">
                    <th class="border px-4 py-2">Participant Name</th>
                    <th class="border px-4 py-2">Email</th>
                    <th class="border px-4 py-2">Event Status</th>
                    <th class="border px-4 py-2">Attendance Status</th>
                    <th class="border px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody id="attendanceTable">
                <!-- Dynamic content will be rendered here -->
            </tbody>
        </table>

        <div class="mt-4">
            <h2 class="font-bold mb-2">Summary</h2>
            <p>Total Participants: <span id="totalParticipants">0</span></p>
            <p>Total Present: <span id="totalPresent">0</span></p>
            <p>Total Absent: <span id="totalAbsent">0</span></p>
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
