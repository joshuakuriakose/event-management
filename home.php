<?php
session_start(); // Move session_start() to the very top of the file
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Event Management</title>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Quicksand', sans-serif;
        }

        body {
            height: 100%;
            overflow-y: auto;
            background: #fff; /* Default background for events section */
        }

        .top-container {
            position: relative;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            overflow: hidden;
        }

        .top-container::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('image2.png') no-repeat center center;
            background-size: cover;
            filter: blur(6px);
            z-index: -1;
        }

        .top-header {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(0, 0, 0, 0.5); /* Semi-transparent background for header */
            z-index: 1;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            color: #fff;
        }

        .nav-links {
            display: flex;
            gap: 1rem;
        }

        .nav-links a {
            color: #fff;
            text-decoration: none;
            font-size: 0.9rem;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .nav-links a:hover {
            color: #4fc3f7;
        }

        .intro {
            font-size: 2.2rem; /* Increased font size for a more prominent look */
            font-weight: 700; /* Increased thickness */
            color: #ffffff; /* Bright white for professionalism */
            max-width: 700px; /* Slightly wider for better readability */
            line-height: 1.6; /* Improved line spacing */
            position: relative;
            z-index: 1;
            padding: 0 2rem;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.5); /* Subtle shadow for depth */
            background: rgba(0, 0, 0, 0.3); /* Slight overlay for better contrast */
            padding: 1.5rem; /* Padding for the background overlay */
            border-radius: 10px; /* Rounded corners for a polished look */
        }

        .events-container {
            width: 100%;
            padding: 2rem;
            background: #fff;
            min-height: 100vh; /* Ensure full screen for events */
            overflow-y: auto;
        }

        .events-container h2 {
            font-size: 2.5rem;
            color: rgb(73, 5, 125);
            margin-bottom: 1.5rem;
            text-align: center;
        }

        .events-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .event-card {
            background: #fff;
            padding: 0; /* Removed padding to let image and form handle spacing */
            border-radius: 0px;
            box-shadow: 0px 0px 10px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
            display: flex;
            flex-direction: column;
            margin-bottom: 0; /* Removed margin to avoid extra spacing */
        }

        .event-card img {
            width: 100%;
            height: 200px; /* Fixed height to occupy full top, adjust as needed */
            object-fit: cover; /* Ensure image covers the area without distortion */
            border-top-left-radius: 0px;
            border-top-right-radius: 0px;
            margin-bottom: 0; /* Removed margin to align with card edge */
        }

        .event-card .card-content {
            padding: 1.5rem; /* Added padding to the content below the image */
        }

        .event-card h3 {
            font-size: 1.8rem;
            color: rgb(73, 5, 125);
            margin-bottom: 1rem;
        }

        .event-card form {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .event-card input {
            padding: 0.8rem;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .event-card button {
            background: #4fc3f7;
            color: white;
            padding: 1rem;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
            margin-top: auto;
            transition: 0.4s ease-in-out;
            background-size: 200%;
            background-image: linear-gradient(to right, rgb(73, 5, 125), #002236);
        }

        .event-card button:hover {
            background-position: -100% 0;
            box-shadow: 0 4px 15px rgb(73, 5, 125);
            transform: scale(1.05);
        }

        @media (max-width: 768px) {
            .top-container {
                height: 50vh;
            }

            .top-header {
                padding: 1rem;
            }

            .logo {
                font-size: 1.2rem;
            }

            .nav-links a {
                font-size: 0.8rem;
            }

            .intro {
                font-size: 1.5rem; /* Reduced for mobile */
                max-width: 80%;
                padding: 1rem;
            }

            .events-grid {
                grid-template-columns: 1fr; /* Stack cards vertically on mobile */
            }

            .events-container {
                padding: 1rem;
            }

            .event-card h3 {
                font-size: 1.5rem;
            }

            .event-card img {
                height: 150px; /* Reduced height for mobile */
            }

            .event-card .card-content {
                padding: 1rem;
            }
        }
    </style>
</head>
<body>
    <div class="top-container">
        <div class="top-header">
            <div class="logo">MyEventManagement</div>
            <div class="nav-links">
                <a href="viewbookings.php">View My Bookings</a>
                <a href="login.php">Logout</a>
            </div>
        </div>
        <p class="intro">
            Welcome to our event management platform! We help you plan and organize your special occasions effortlessly. Choose your event type, specify your details, and let us take care of the rest.
        </p>
    </div>
    <div class="events-container">
        <h2>Events</h2>
        <div class="events-grid">
            <div class="event-card">
                <img src="birthday.png" alt="Birthday Event">
                <div class="card-content">
                    <h3>Birthday</h3>
                    <form action="home_process.php" method="POST">
                        <input type="hidden" name="event_type" value="Birthday">
                        <label>Event Date</label>
                        <input type="date" name="event_date" required />
                        <label>Guest Count</label>
                        <input type="number" name="guest_count" min="1" required />
                        <label>Budget</label>
                        <input type="number" name="budget" readonly />
                        <button type="submit">Save Event</button>
                    </form>
                </div>
            </div>
            <div class="event-card">
                <img src="wedding.jpg" alt="Wedding Event">
                <div class="card-content">
                    <h3>Wedding</h3>
                    <form action="home_process.php" method="POST">
                        <input type="hidden" name="event_type" value="Wedding">
                        <label>Event Date</label>
                        <input type="date" name="event_date" required />
                        <label>Guest Count</label>
                        <input type="number" name="guest_count" min="1" required />
                        <label>Budget</label>
                        <input type="number" name="budget" readonly />
                        <button type="submit">Save Event</button>
                    </form>
                </div>
            </div>
            <div class="event-card">
                <img src="funeral.jpg" alt="Funeral Event">
                <div class="card-content">
                    <h3>Funeral</h3>
                    <form action="home_process.php" method="POST">
                        <input type="hidden" name="event_type" value="Funeral">
                        <label>Event Date</label>
                        <input type="date" name="event_date" required />
                        <label>Guest Count</label>
                        <input type="number" name="guest_count" min="1" required />
                        <label>Budget</label>
                        <input type="number" name="budget" readonly />
                        <button type="submit">Save Event</button>
                    </form>
                </div>
            </div>
            <div class="event-card">
                <img src="anniversary.jpg" alt="Anniversary Event">
                <div class="card-content">
                    <h3>Anniversary</h3>
                    <form action="home_process.php" method="POST">
                        <input type="hidden" name="event_type" value="Anniversary">
                        <label>Event Date</label>
                        <input type="date" name="event_date" required />
                        <label>Guest Count</label>
                        <input type="number" name="guest_count" min="1" required />
                        <label>Budget</label>
                        <input type="number" name="budget" readonly />
                        <button type="submit">Save Event</button>
                    </form>
                </div>
            </div>
            <div class="event-card">
                <img src="corporate.jpg" alt="Corporate Event">
                <div class="card-content">
                    <h3>Corporate Event</h3>
                    <form action="home_process.php" method="POST">
                        <input type="hidden" name="event_type" value="Corporate Event">
                        <label>Event Date</label>
                        <input type="date" name="event_date" required />
                        <label>Guest Count</label>
                        <input type="number" name="guest_count" min="1" required />
                        <label>Budget</label>
                        <input type="number" name="budget" readonly />
                        <button type="submit">Save Event</button>
                    </form>
                </div>
            </div>
            <div class="event-card">
                <img src="baptism.jpg" alt="Baptism Event">
                <div class="card-content">
                    <h3>Baptism</h3>
                    <form action="home_process.php" method="POST">
                        <input type="hidden" name="event_type" value="Baptism">
                        <label>Event Date</label>
                        <input type="date" name="event_date" required />
                        <label>Guest Count</label>
                        <input type="number" name="guest_count" min="1" required />
                        <label>Budget</label>
                        <input type="number" name="budget" readonly />
                        <button type="submit">Save Event</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener("DOMContentLoaded", function () {
            const today = new Date();
            const nextWeek = new Date(today.getFullYear(), today.getMonth(), today.getDate() + 7);
            const formattedDate = nextWeek.toISOString().split('T')[0];

            const dateInputs = document.querySelectorAll('input[type="date"]');
            dateInputs.forEach(input => {
                input.setAttribute('min', formattedDate);
            });

            document.querySelectorAll('input[name="guest_count"]').forEach(input => {
                input.addEventListener('input', function () {
                    const eventCard = input.closest('.event-card');
                    const eventType = eventCard.querySelector('h3').textContent;
                    let costPerGuest;

                    switch (eventType) {
                        case 'Birthday':
                            costPerGuest = 10;
                            break;
                        case 'Wedding':
                            costPerGuest = 50;
                            break;
                        case 'Funeral':
                            costPerGuest = 30;
                            break;
                        case 'Anniversary':
                            costPerGuest = 40;
                            break;
                        case 'Corporate Event':
                            costPerGuest = 60;
                            break;
                        case 'Baptism':
                            costPerGuest = 25;
                            break;
                        default:
                            costPerGuest = 20;
                    }

                    const guestCount = parseInt(input.value, 10) || 0;
                    const totalCost = guestCount * costPerGuest;
                    const budgetInput = eventCard.querySelector('input[name="budget"]');
                    budgetInput.value = totalCost.toFixed(2);
                });
            });
        });
    </script>
</body>
</html>