<?php
// Database configuration
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "tutorxcells";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and get form data
$eventName = isset($_POST['eventName']) ? $_POST['eventName'] : '';
$date = isset($_POST['date']) ? $_POST['date'] : '';
$time = isset($_POST['time']) ? $_POST['time'] : '';
$location = isset($_POST['location']) ? $_POST['location'] : '';
$speakerInformation = isset($_POST['speakerInformation']) ? $_POST['speakerInformation'] : '';
$description = isset($_POST['description']) ? $_POST['description'] : '';
$category = isset($_POST['category']) ? $_POST['category'] : '';
$recurringEvent = isset($_POST['recurringEvent']) ? 1 : 0; // Default to 0 if not checked

// Check if required fields are filled
if (!empty($eventName) && !empty($date) && !empty($time) && !empty($location) && !empty($description) && !empty($category)) {
    // Insert data into database
    $sql = "INSERT INTO ems (eventName, date, time, location, speakerInformation, description, category, recurringEvent) 
            VALUES ('$eventName', '$date', '$time', '$location', '$speakerInformation', '$description', '$category', $recurringEvent)";

    if ($conn->query($sql) === TRUE) {
        echo "Event created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    
}

// Close connection
$conn->close();
?>
