<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Receipts</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }

        body {
            background: url('image3.jpg') no-repeat center center fixed;
            background-size: cover;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
            overflow: hidden; /* Prevent body from showing scrollbar */
        }

        /* Wrapper to manage scrolling invisibly */
        .scroll-wrapper {
            width: 100%;
            height: 100vh; /* Full viewport height */
            overflow-y: auto; /* Handle scrolling here */
            -ms-overflow-style: none; /* Hide scrollbar in IE/Edge */
            scrollbar-width: none; /* Hide scrollbar in Firefox */
        }

        .scroll-wrapper::-webkit-scrollbar {
            display: none; /* Hide scrollbar in Chrome/Safari/Opera */
            width: 0;
            height: 0;
        }

        .header {
            text-align: center;
            font-size: 3rem;
            font-weight: 800;
            color: #fff;
            text-shadow: -1px -1px 0 black, 1px -1px 0 black, -1px 1px 0 black, 1px 1px 0 black;
            margin-bottom: 1rem;
        }

        .home-btn {
            background: linear-gradient(135deg, #42a5f5, #1e88e5);
            color: white;
            padding: 1rem 2rem;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 1.2rem;
            font-weight: 700;
            text-decoration: none;
            display: inline-block;
            transition: all 0.3s ease;
            box-shadow: 3px 3px 10px rgba(0, 0, 0, 0.3);
            margin-bottom: 2rem;
            margin-top: 1.5rem; /* Added to move the button down */
        }

        .home-btn:hover {
            background: linear-gradient(135deg, #1e88e5, #42a5f5);
            transform: scale(1.05);
        }

        .receipt-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            width: 90%;
            max-width: 800px; /* Narrower for receipt-like feel */
            min-height: 600px;
            display: flex;
            flex-direction: column;
            border: 2px dashed #333; /* Receipt border */
            margin: 0 auto; /* Center the container horizontally */
        }

        .receipt-header {
            text-align: center;
            font-size: 1.8rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1.5rem;
            border-bottom: 2px solid #42a5f5;
            padding-bottom: 0.5rem;
        }

        .bookings-container {
            max-width: 100%;
            flex-grow: 1; /* Allows container to expand naturally */
        }

        .booking-card {
            background: #fff;
            border: 1px solid #eee;
            border-radius: 10px;
            padding: 1.5rem;
            margin-bottom: 1rem;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);
            position: relative; /* For cancel button positioning */
            display: flex;
            flex-direction: column;
            align-items: center; /* Center the content within the card */
        }

        .booking-details {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 1rem;
            font-size: 1rem;
            color: #555;
            width: 100%; /* Ensures full width for grid */
            text-align: left; /* Keep text left-aligned for readability */
        }

        .booking-details span {
            font-weight: 600;
            color: #333;
        }

        .cancel-btn {
            background: linear-gradient(135deg, #ff6b6b, #ee5253);
            color: white;
            padding: 0.6rem 1.2rem;
            border: none;
            border-radius: 8px;
            cursor: pointer;
            font-weight: 600;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            margin-top: 0.5rem; /* Space above button */
            align-self: center; /* Center the button horizontally */
        }

        .cancel-btn:hover {
            background: linear-gradient(135deg, #ee5253, #ff6b6b);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(238, 82, 83, 0.3);
        }

        .status-confirmed { color: #2ecc71; font-weight: 700; }
        .status-pending { color: #f1c40f; font-weight: 700; }
        .status-cancelled { color: #e74c3c; font-weight: 700; }

        .receipt-footer {
            margin-top: 1.5rem;
            text-align: center;
            font-size: 1rem;
            color: #666;
            border-top: 1px dashed #42a5f5;
            padding-top: 1rem;
        }

        .no-bookings {
            text-align: center;
            color: #666;
            font-size: 1.2rem;
            margin-top: 2rem;
        }

        @media (max-width: 768px) {
            .receipt-container {
                width: 95%;
                padding: 1.5rem;
                min-height: 500px;
            }

            .header {
                font-size: 2.5rem;
            }

            .home-btn {
                font-size: 1rem;
                padding: 0.8rem 1.5rem;
            }

            .booking-details {
                grid-template-columns: 1fr;
            }

            .booking-card {
                align-items: center; /* Center on mobile */
            }

            .cancel-btn {
                position: static;
                margin-top: 1rem;
                width: 100%; /* Full width on mobile */
                align-self: center; /* Ensure centered */
            }
        }
    </style>
</head>
<body>
    <div class="scroll-wrapper">        
        <a href="home.php" class="home-btn">Home</a>

        <div class="receipt-container">
            <div class="receipt-header">Booking Receipt</div>
            <div class="bookings-container">
                <div id="bookings-list">
                    <!-- Bookings will be loaded here dynamically -->
                    <div class="booking-card">
                        <button class="cancel-btn" onclick="cancelBooking(16)">Cancel</button>
                        <div class="booking-details">
                            <span>Booking ID:</span> 16<br>
                            <span>Event Type:</span> Anniversary<br>
                            <span>Event Date:</span> 2025-07-11<br>
                            <span>Status:</span> <span class="status-cancelled">Cancelled</span><br>
                            <span>Payment Status:</span> Refund<br>
                            <span>Payment Method:</span> UPI
                        </div>
                    </div>
                    <div class="booking-card">
                        <button class="cancel-btn" onclick="cancelBooking(19)">Cancel</button>
                        <div class="booking-details">
                            <span>Booking ID:</span> 19<br>
                            <span>Event Type:</span> Corporate Event<br>
                            <span>Event Date:</span> 2025-04-24<br>
                            <span>Status:</span> <span class="status-cancelled">Cancelled</span><br>
                            <span>Payment Status:</span> Refund<br>
                            <span>Payment Method:</span> Offline
                        </div>
                    </div>
                    <!-- Add more cards to test page scrolling -->
                </div>
            </div>
            <div class="receipt-footer">
                Thank you for your booking! For inquiries, contact support@xai.com<br>
                Generated on: April 09, 2025
            </div>
        </div>
    </div>

    <script>
        function cancelBooking(bookingId) {
            if (confirm('Are you sure you want to cancel this booking?')) {
                fetch('viewbookings_process.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: 'booking_id=' + bookingId + '&action=cancel'
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error cancelling booking');
                    }
                });
            }
        }

        document.addEventListener('DOMContentLoaded', function() {
            fetch('viewbookings_process.php')
                .then(response => response.text())
                .then(html => {
                    document.getElementById('bookings-list').innerHTML = html;
                });
        });
    </script>
</body>
</html>