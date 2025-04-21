<?php
$servername = "my-mysql";    // Or use the name of your service if in Docker (e.g., "db")
$username = "root";
$password = "root";               // Use your MySQL password
$database = "event management";        // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("❌ Connection failed: " . $conn->connect_error);
}
echo "✅ Connected successfully";
?>
