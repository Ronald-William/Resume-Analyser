<?php
// Process form submission first (backend part)
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    header('Content-Type: application/json');
    
    // Database configuration
    $servername = "localhost";
    $username = "root";  
    $password = "";      
    $dbname = "plagiarism_checker";  

    
    $conn = new mysqli($servername, $username, $password);

   
    if ($conn->connect_error) {
        echo json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]);
        exit;
    }

    
    $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
    if ($conn->query($sql) !== TRUE) {
        echo json_encode(['success' => false, 'message' => 'Error creating database: ' . $conn->error]);
        exit;
    }

    
    $conn->select_db($dbname);

    // Create table if it doesn't exist
    $sql = "CREATE TABLE IF NOT EXISTS feedback (
        id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        email VARCHAR(100) NOT NULL,
        description TEXT NOT NULL,
        stars INT(1) DEFAULT 5,
        submission_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";

    if ($conn->query($sql) !== TRUE) {
        echo json_encode(['success' => false, 'message' => 'Error creating table: ' . $conn->error]);
        exit;
    }

   
    $name = isset($_POST['name']) ? $conn->real_escape_string(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? $conn->real_escape_string(trim($_POST['email'])) : '';
    $description = isset($_POST['message']) ? $conn->real_escape_string(trim($_POST['message'])) : '';
    $stars = isset($_POST['stars']) ? intval($_POST['stars']) : 5; 
    
   
    if (empty($name) || empty($email) || empty($description)) {
        echo json_encode(['success' => false, 'message' => 'Please fill all required fields']);
        exit;
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format']);
        exit;
    }
    
    // Ensure stars is between 1 and 5
    if ($stars < 1 || $stars > 5) {
        $stars = 5; 
    }
    
    // Insert data into database
    $sql = "INSERT INTO feedback (name, email, description, stars) 
            VALUES (?, ?, ?, ?)";
    
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("sssi", $name, $email, $description, $stars);
        
        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Error submitting feedback: ' . $stmt->error]);
        }
        
        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Error preparing statement: ' . $conn->error]);
    }

    
    $conn->close();
    
   
    exit;
}