<?php
session_start();  // Start session

$servername = "my-mysql";    // Ensure this matches your Docker Compose service name
$username = "root";
$password = "root";          // Use your MySQL password
$database = "event management"; 

// Create a connection using mysqli
$conn = new mysqli($servername, $username, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Validate session user_id
    if (!isset($_SESSION['user_id'])) {
        die("Error: User is not logged in.");
    }

    $user_id = $_SESSION['user_id'];
    $event_type = $_POST['event_type'] ?? null;
    $event_date = $_POST['event_date'] ?? null;
    $guest_count = $_POST['guest_count'] ?? null;
    $budget = $_POST['budget'] ?? null;

    // Validate event selection
    if (empty($event_type)) {
        die("Error: No event type selected.");
    }

    // Insert event into the database
    $stmt = $conn->prepare("INSERT INTO events (user_id, event_type, event_date, guest_count, budget) 
                            VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isssi", $user_id, $event_type, $event_date, $guest_count, $budget); // "isssi" indicates string, string, string, integer, integer

    try {
        $stmt->execute();
        $event_id = $stmt->insert_id; // Get the last inserted event ID

        // Store the latest event ID in session
        $_SESSION['selected_event_id'] = $event_id;

        // Redirect after saving the event
        header("Location: bookings.php"); // Redirect to bookings page
        exit;  
    } catch (Exception $e) {
        die("Error saving event: " . $e->getMessage());
    }
}
?>
