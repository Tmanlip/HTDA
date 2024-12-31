<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE-edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

    <link rel="stylesheet" href="reward.css">
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
                    <i class='bx bx-sun sun'></i>
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
        <div id="output-container">
            <?php
            // Check if data is received
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['student_id'])) {
                $student_id = htmlspecialchars($_POST['student_id']);

                include 'C:\xampp\htdocs\HiTDA\db_connect.php';

                // Query the database for the student information
                $sql = "SELECT * FROM student WHERE matric_no = ?";
                $stmt = $conn->prepare($sql);
                $stmt->bind_param("s", $student_id);
                $stmt->execute();
                $result = $stmt->get_result();

                // Display student information
                if ($result->num_rows > 0) {
                    $student = $result->fetch_assoc();
                    echo "<h1>Student Information</h1>";
                    echo "<p><strong>Student ID:</strong> " . htmlspecialchars($student['matric_no']) . "</p>";
                    echo "<p><strong>Name:</strong> " . htmlspecialchars($student['stud_name']) . "</p>";
                    echo "<p><strong>Program:</strong> " . htmlspecialchars($student['course']) . "</p>";
                    echo "<p><strong>Year:</strong> " . htmlspecialchars($student['course_code']) . "</p>";
                    echo "<p><strong>CGPA:</strong> " . htmlspecialchars($student['cgpa']) . "</p>";
                } else {
                    echo "<p>No student found with ID: " . htmlspecialchars($student_id) . "</p>";
                }

                // Fetch forum contributions
                $forum_contrib_sql = "SELECT * FROM forum_contributions WHERE student_id = ?";
                $forum_stmt = $conn->prepare($forum_contrib_sql);
                $forum_stmt->bind_param("s", $student_id);
                $forum_stmt->execute();
                $forum_result = $forum_stmt->get_result();

                if ($forum_result->num_rows > 0) {
                    echo "<h2>Forum Contributions</h2>";
                    while ($forum_contrib = $forum_result->fetch_assoc()) {
                        echo "<p><strong>Contribution ID:</strong> " . htmlspecialchars($forum_contrib['id']) . "</p>";

                        // Related questions
                        if ($forum_contrib['question_id']) {
                            $question_sql = "SELECT * FROM questions WHERE id = ?";
                            $question_stmt = $conn->prepare($question_sql);
                            $question_stmt->bind_param("i", $forum_contrib['question_id']);
                            $question_stmt->execute();
                            $question_result = $question_stmt->get_result();

                            if ($question_result->num_rows > 0) {
                                $question = $question_result->fetch_assoc();
                                echo "<p><strong>Question:</strong> " . htmlspecialchars($question['title']) . "</p>";
                                echo "<p><strong>Description:</strong> " . htmlspecialchars($question['description']) . "</p>";
                            }
                        }

                        // Related replies
                        if ($forum_contrib['reply_id']) {
                            $reply_sql = "SELECT * FROM replies WHERE id = ?";
                            $reply_stmt = $conn->prepare($reply_sql);
                            $reply_stmt->bind_param("i", $forum_contrib['reply_id']);
                            $reply_stmt->execute();
                            $reply_result = $reply_stmt->get_result();

                            if ($reply_result->num_rows > 0) {
                                $reply = $reply_result->fetch_assoc();
                                echo "<p><strong>Reply:</strong> " . htmlspecialchars($reply['reply_text']) . "</p>";
                            }
                        }
                    }
                } else {
                    echo "<p>No forum contributions found for this student.</p>";
                }

                // Fetch shared resources for the student
                $resource_sharing_sql = "SELECT r.id, r.course_name, r.document_name, r.upload_date 
                FROM resources r 
                JOIN resource_sharing rs ON r.id = rs.resource_id 
                WHERE rs.student_id = ?";
                $resource_stmt = $conn->prepare($resource_sharing_sql);
                $resource_stmt->bind_param("s", $student_id);
                $resource_stmt->execute();
                $resource_result = $resource_stmt->get_result();

                if ($resource_result->num_rows > 0) {
                echo "<h2>Resources Shared by the Student</h2>";
                while ($resource = $resource_result->fetch_assoc()) {
                echo "<p><strong>Resource ID:</strong> " . htmlspecialchars($resource['id']) . "</p>";
                echo "<p><strong>Course:</strong> " . htmlspecialchars($resource['course_name']) . "</p>";
                echo "<p><strong>Document:</strong> " . htmlspecialchars($resource['document_name']) . "</p>";
                echo "<p><strong>Upload Date:</strong> " . htmlspecialchars($resource['upload_date']) . "</p>";
                }
                } else {
                echo "<p>No resources found shared by this student.</p>";
                }

                // Fetch seminar history
                // Fetch the seminar history for the student
                $query = "SELECT s.event_name, s.seminar_date, s.description, s.place, p.status
                FROM seminar s
                JOIN participation p ON s.id = p.seminar_id
                WHERE p.student_id = ? AND p.role = 'student'
                ORDER BY s.seminar_date DESC";

                $stmt = $conn->prepare($query);
                $stmt->bind_param("i", $userId);
                $stmt->execute();
                $stmt->bind_result($title, $date, $description, $location, $status);

                echo "<h2>Seminar History</h2>";
                if ($stmt->num_rows > 0) {
                    while ($seminar_stmt->fetch()) {
                        echo '<div class="seminar-record">';
                        echo '<h4>' . htmlspecialchars($title) . '</h4>';
                        echo '<p><strong>Date:</strong> ' . htmlspecialchars($date) . '</p>';
                        echo '<p><strong>Location:</strong> ' . htmlspecialchars($location) . '</p>';
                        echo '<p><strong>Description:</strong> ' . htmlspecialchars($description) . '</p>';
                        echo '<p><strong>Status:</strong> ' . htmlspecialchars($status) . '</p>';
                        echo '</div>';
                    }
                } else {
                    echo "<p>No seminars found in your history.</p>";
                }

                // Close the connection
                $stmt->close();
                $forum_stmt->close();
                $conn->close();
            } else {
                echo "<p>Invalid request. No student ID provided.</p>";
            }
            ?>
        </div>
    </main>

    <script src="rw.js"></script>

    <!-- <footer>
        <div class="content">
            <Footer content
        </div> -->
    </footer>
</body>
</html>
