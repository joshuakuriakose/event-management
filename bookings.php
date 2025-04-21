<?php
session_start();
include 'db_connect.php'; // Ensure database connection is included

// Redirect if user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch the latest saved event for the logged-in user
$query = "SELECT event_id, event_type, event_date FROM events WHERE user_id = ? ORDER BY event_id DESC LIMIT 1";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$latest_event = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Event</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }

        body {
            display: flex;
            justify-content: flex-start;
            align-items: center;
            min-height: 100vh;
            padding: 0;
            background: url('image3.jpg') no-repeat center center fixed; /* Set the background image */
            background-size: cover; /* Make sure the image covers the entire body */
            background-position: center; /* Ensure the background image is centered */
        }

        .booking-container {
            background: rgba(255, 255, 255, 0.9); /* Transparent white background for better contrast */
            padding: 3rem; /* Increased padding for more space */
            border-radius: 20px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.1);
            width: 60%; /* Increased width to make the container bigger */
            max-width: 600px;
            height: 100vh; /* Full height of the viewport */
            overflow-y: auto; /* Allow scrolling if content overflows */
            display: flex;
            flex-direction: column;
            justify-content: center;
            overflow-y: scroll; /* Allows scrolling */
            scrollbar-width: none; /* Hides scrollbar in Firefox */
            -ms-overflow-style: none;
        }
        
        .booking-container::-webkit-scrollbar {
            display: none; /* Hides scrollbar in Chrome/Safari */
        }

        h2 {
            text-align: center;
            margin-bottom: 1.5rem;
            color: #333;
        }

        .form-group {
            margin-bottom: 1rem;
        }

        label {
            font-weight: 500;
            margin-bottom: 0.5rem;
            display: block;
        }

        select, input {
            width: 100%;
            padding: 0.8rem;
            border: 1px solid #ddd;
            border-radius: 8px;
            font-size: 1rem;
        }

        .hidden {
            display: none;
        }

        .status-box {
            padding: 0.8rem;
            background: #f0f0f0;
            border-radius: 8px;
            text-align: center;
            font-weight: bold;
            margin-top: 0.5rem;
        }

        .book-btn, .pay-btn {
            background:rgb(73, 5, 125);
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 8px;
            font-weight: bold;
            cursor: pointer;
            width: 100%;
            margin-top: 1rem;
            transition: 0.4s ease-in-out;
        }

        .pay-btn {
            background: #4caf50;
        }

        .pay-btn:hover{
            opacity: 0.9;
            box-shadow: 0 4px 15px #4caf50;
            transform: scale(1.05);
        }

        .book-btn:hover{
            opacity: 0.9;
            box-shadow: 0 4px 15px rgb(73, 5, 125);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            body {
                flex-direction: column;
                padding: 1rem;
            }

            .booking-container {
                width: 100%; /* Full width on smaller screens */
                margin-top: 2rem;
                height: auto; /* Allow height to adjust on smaller screens */
            }
        }
    </style>
</head>
<body>

    <div class="booking-container">
        <h2>Payment</h2>
        <form action="bookings_process.php" method="POST" id="bookingForm">
            <?php if ($latest_event) { ?>
                <input type="hidden" name="event_id" value="<?= $latest_event['event_id'] ?>">

                <div class="form-group">
                    <label for="event_type">Event Type:</label>
                    <input type="text" id="event_type" value="<?= htmlspecialchars($latest_event['event_type']) ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="event_date">Event Date:</label>
                    <input type="text" id="event_date" value="<?= htmlspecialchars($latest_event['event_date']) ?>" disabled>
                </div>

                <div class="form-group">
                    <label for="payment_method">Payment Method:</label>
                    <select name="payment_method" id="payment_method" required onchange="togglePaymentFields()">
                        <option value="">Select Payment Method</option>
                        <option value="UPI">UPI</option>
                        <option value="Offline">Offline</option>
                    </select>
                </div>

                <div class="form-group hidden" id="upiField">
                    <label for="upi_id">UPI ID:</label>
                    <input type="text" name="upi_id" id="upi_id" placeholder="Enter your UPI ID">
                    <button type="button" class="pay-btn" onclick="processPayment()">Pay</button>
                </div>

                <div class="form-group">
                    <label>Payment Status:</label>
                    <div class="status-box" id="paymentStatusBox">Pending</div>
                </div>

                <button type="submit" class="book-btn">Book Event</button>
            <?php } else { ?>
                <p>No event found. Please create an event first.</p>
            <?php } ?>
        </form>
    </div>

    <script>
        function togglePaymentFields() {
            const paymentMethod = document.getElementById('payment_method').value;
            const upiField = document.getElementById('upiField');
            const paymentStatusBox = document.getElementById('paymentStatusBox');

            if (paymentMethod === 'UPI') {
                upiField.classList.remove('hidden');
                paymentStatusBox.textContent = "Pending";
            } else {
                upiField.classList.add('hidden');
                paymentStatusBox.textContent = "Pending";
            }
        }

        function processPayment() {
            const upiId = document.getElementById('upi_id').value.trim();
            const paymentStatusBox = document.getElementById('paymentStatusBox');

            if (upiId === "") {
                alert("Please enter a valid UPI ID to proceed.");
                return;
            }

            paymentStatusBox.textContent = "Paid";
        }
    </script>

</body>
</html>
