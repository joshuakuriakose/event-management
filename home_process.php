<?php
session_start();  // Start session

$host = 'localhost';
$dbname = 'event management';
$username = 'root';
$password = 'root';
$port = 3307;

try {
    $pdo = new PDO("mysql:host=$host;port=$port;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Check if the form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Debugging: Check form submission
    echo "<pre>";
    print_r($_POST);
    echo "</pre>";

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
    $query = "INSERT INTO events (user_id, event_type, event_date, guest_count, budget) 
              VALUES (:user_id, :event_type, :event_date, :guest_count, :budget)";
    $stmt = $pdo->prepare($query);
    $stmt->bindParam(':user_id', $user_id);
    $stmt->bindParam(':event_type', $event_type);
    $stmt->bindParam(':event_date', $event_date);
    $stmt->bindParam(':guest_count', $guest_count);
    $stmt->bindParam(':budget', $budget);

    try {
        $stmt->execute();
        $event_id = $pdo->lastInsertId(); // Get the last inserted event ID

        // Store the latest event ID in session
        $_SESSION['selected_event_id'] = $event_id;

        echo "Event saved successfully!";
        header("Location: bookings.php"); // Redirect to bookings page
        exit;  
    } catch (PDOException $e) {
        die("Error saving event: " . $e->getMessage());
    }
}
?>
