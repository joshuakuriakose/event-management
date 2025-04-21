<?php
$servername = "my-mysql";    // Ensure this matches your Docker Compose service name
$username = "root";
$password = "root";               // Use your MySQL password
$database = "event management";        // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
} else {
    header("Location: login.php");
    exit;
}
?>
