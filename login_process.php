<?php
session_start();  // Start the session to access session variables

include("db_connect.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = strtolower(trim($_POST["email"] ?? ''));
    $password = trim($_POST["password"] ?? '');
//checks empty fields
    if (empty($email) || empty($password)) {
        die("<script>alert('All fields are required!'); window.location.href='login.php';</script>");
    }

    // Prepare the SQL statement to check if the email exists
    $stmt = $conn->prepare("SELECT user_id, password FROM users WHERE email = ?");
    
    if (!$stmt) {
        die("Error in SQL statement: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        $stmt->bind_result($user_id, $stored_password);
        $stmt->fetch();
        
        // Debugging: Log the stored password (useful for debugging)
        echo "<script>console.log('Stored password: $stored_password');</script>";

        // Check if the provided password matches the stored one
        if ($password === $stored_password) { 
            // Successful login, set session variables
            $_SESSION['user_id'] = $user_id;  // Store the user_id in session
            echo "<script>alert('Login successful!'); window.location.href='home.php';</script>";
        } else {
            echo "<script>alert('Invalid email or password!'); window.location.href='login.php';</script>";
        }
    } else {
        echo "<script>alert('User not found!'); window.location.href='login.php';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
