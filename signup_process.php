<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

$servername = "my-mysql";    // Ensure this matches your Docker Compose service name
$username = "root";
$password = "root";               // Use your MySQL password
$database = "event management";        

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    echo "<pre>";
    print_r($_POST); 
    echo "</pre>";

    // Ensure form fields match exactly
    $username = trim($_POST["username"] ?? '');
    $phone_number = trim($_POST["phone_number"] ?? '');
    $email = trim($_POST["email"] ?? '');
    $password = trim($_POST["password"] ?? '');

   

    // Insert into database
    $stmt = $conn->prepare("INSERT INTO users (username, phone_number, email, password) VALUES (?, ?, ?, ?)");
    if (!$stmt) {
        die("SQL Error: " . $conn->error);
    }

    $stmt->bind_param("ssss", $username, $phone_number, $email, $password); 

    if ($stmt->execute()) {
        echo "<script>alert('Registration successful!'); window.location.href='login.php';</script>";
    } else {
        die("SQL Execution Error: " . $stmt->error);
    }

    $stmt->close();
}

$conn->close();
?>
