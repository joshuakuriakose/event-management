<?php
session_start();
include 'db_connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION['user_id'];
    $event_id = isset($_POST['event_id']) ? (int) $_POST['event_id'] : 0;
    $payment_method = $_POST['payment_method'] ?? NULL;
    $upi_id = $_POST['upi_id'] ?? NULL;
    $payment_status = ($payment_method === "UPI" && !empty($upi_id)) ? "Paid" : "Pending";
    $status = "Booked";
    $created_at = date('Y-m-d H:i:s');

    // Debugging: Log the output to a file instead of echoing
    file_put_contents('debug_log.txt', "Debugging Output:\n", FILE_APPEND);
    file_put_contents('debug_log.txt', "Event ID: $event_id\n", FILE_APPEND);
    file_put_contents('debug_log.txt', "User ID: $user_id\n", FILE_APPEND);
    file_put_contents('debug_log.txt', "Payment Method: $payment_method\n", FILE_APPEND);
    file_put_contents('debug_log.txt', "UPI ID: $upi_id\n", FILE_APPEND);
    file_put_contents('debug_log.txt', "Payment Status: $payment_status\n", FILE_APPEND);

    // Check if event exists for this user
    $check_event = $conn->prepare("SELECT event_id FROM events WHERE event_id = ? AND user_id = ?");
    $check_event->bind_param("ii", $event_id, $user_id);
    $check_event->execute();
    $result = $check_event->get_result();

    if ($result->num_rows === 0) {
        echo "Error: Invalid event selected. <a href='javascript:history.back()'>Go Back</a>";
        exit();
    }

    // Insert into bookings table
    $stmt = $conn->prepare("INSERT INTO bookings (user_id, event_id, status, payment_status, payment_method, upi_id, created_at) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("iisssss", $user_id, $event_id, $status, $payment_status, $payment_method, $upi_id, $created_at);

    if ($stmt->execute()) {
        header("Location: viewbookings.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statements
    $check_event->close();
    $stmt->close();
    $conn->close();
} else {
    echo "Error: Invalid request.";
}
?>
