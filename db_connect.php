<?php
$servername = "my-mysql";    // Ensure this matches your Docker Compose service name
$username = "root";
$password = "root";               // Use your MySQL password
$database = "event management";


$conn = new mysqli($servername, $username, $password, $database);


if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
