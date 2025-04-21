<?php
session_start();
include 'db_connect.php';

// Handle booking cancellation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['action']) && $_POST['action'] == 'cancel') {
    $booking_id = $_POST['booking_id'];
    
    $sql = "UPDATE bookings SET status = 'Cancelled', payment_status = 'Refund' 
            WHERE booking_id = ? AND user_id = ?";
    
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("si", $booking_id, $_SESSION['user_id']);
    
    $response = array();
    if ($stmt->execute()) {
        $response['success'] = true;
    } else {
        $response['success'] = false;
    }
    
    echo json_encode($response);
    exit();
}

// Fetch bookings for the current user
$sql = "SELECT b.*, e.event_type, e.event_date, u.username 
        FROM bookings b 
        JOIN events e ON b.event_id = e.event_id 
        JOIN users u ON b.user_id = u.user_id 
        WHERE b.user_id = ? 
        ORDER BY e.event_date DESC";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $statusClass = '';
        switch($row['payment_status']) {
            case 'Confirmed':
                $statusClass = 'status-confirmed';
                break;
            case 'Pending':
                $statusClass = 'status-pending';
                break;
            case 'Refund':
                $statusClass = 'status-cancelled';
                break;
        }
        ?>
        <div class="booking-card">
            <div class="booking-details">
                <div class="detail-group">
                    <div class="detail-label">Booking ID</div>
                    <div class="detail-value"><?php echo htmlspecialchars($row['booking_id']); ?></div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Event Type</div>
                    <div class="detail-value"><?php echo htmlspecialchars($row['event_type']); ?></div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Event Date</div>
                    <div class="detail-value"><?php echo htmlspecialchars($row['event_date']); ?></div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Status</div>
                    <div class="detail-value <?php echo $statusClass; ?>"><?php echo htmlspecialchars($row['status']); ?></div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Payment Status</div>
                    <div class="detail-value <?php echo $statusClass; ?>"><?php echo htmlspecialchars($row['payment_status']); ?></div>
                </div>
                <div class="detail-group">
                    <div class="detail-label">Payment Method</div>
                    <div class="detail-value"><?php echo htmlspecialchars($row['payment_method']); ?></div>
                </div>
            </div>
            <?php if ($row['status'] != 'Cancelled'): ?>
                <button class="cancel-btn" onclick="cancelBooking('<?php echo $row['booking_id']; ?>')">Cancel Booking</button>
            <?php endif; ?>
        </div>
        <?php
    }
} else {
    echo '<div class="no-bookings">No bookings found.</div>';
}

$stmt->close();
$conn->close();
?>