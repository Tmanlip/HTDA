<?php


header('Content-Type: application/json');
echo json_encode(['status' => 'success', 'message' => 'Question posted successfully!']);

// Database credentials
$host = 'localhost';   // Replace with your actual host
$db   = 'forum_db';    // Replace with your database name
$user = 'root';        // Replace with your database username
$pass = '';            // Replace with your database password;

try {
    // Establish a database connection
    $pdo = new PDO("mysql:host=$host;dbname=$db", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    
    // Insert the question into the database
        $stmt = $pdo->prepare("INSERT INTO questions (id, user_id, title, description, tags) 
                               VALUES (:id, :user_id, :title, :description, :tags)");
        $stmt->execute([
            'id' => $_POST['id'],
            'user_id' => $_POST['user_id'],            // User ID passed from the form
            'title' => $_POST['title'],               // Title from the form
            'description' => $_POST['description'],   // Description from the form
            'tags' => $_POST['tags']                  // Tags from the form
        ]);

    }catch (PDOException $e) {
        $e->getMessage();
    }

    

        
?>
