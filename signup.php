<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $full_name = trim($_POST['name']);
    $phone = trim($_POST['phn_number']);
    $reg_number = trim($_POST['reg_number']);
    $email = trim($_POST['email']);
    $pass = $_POST['password'];


    if(strlen($full_name)<=0){
        echo "!Name Field Empty";
        exit;
    }

    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "!Invalid email format";
        exit;
    }

    
    if (!preg_match('/^[0-9]{10}$/', $phone)) {
        echo "!Invalid phone number format";
        exit;
    }

    
    if (strlen($pass) < 8 || !preg_match('/[A-Z]/', $pass) || !preg_match('/[a-z]/', $pass) || !preg_match('/\d/', $pass) || !preg_match('/[\W]/', $pass)) {
        echo "!Password must be at least 8 characters long, include one uppercase letter, one lowercase letter, one digit, and one special character";
        exit;
    }

 
    $hashed_password = password_hash($pass,PASSWORD_DEFAULT);

   
    $servername = "localhost";
    $username = "root";
    $password = "";
    $database = "user_details";

  
    $conn = mysqli_connect($servername, $username, $password, $database);

    // if ($conn->connect_error) {
    //     die("<scrip>alert('Database connection failed');</script>");
    // }

    
    $stmt = $conn->prepare("SELECT email, reg_number FROM info WHERE email = ? OR reg_number = ?");
    $stmt->bind_param("ss", $email, $reg_number);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo "Email or Registration number already registered. Login instead!";
        $stmt->close();
        $conn->close();
        exit;
    }
    $stmt->close();

    
    $stmt = $conn->prepare("INSERT INTO info (full_name, phone, reg_number, email, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $phone, $reg_number, $email, $hashed_password);
    
    if ($stmt->execute()) {
        echo "Signup successful! You can now login.";
    } else {
        echo $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
