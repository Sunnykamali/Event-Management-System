<?php
session_start();
include 'config.php';

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

// Fetch user data from the session
$user_id = $_SESSION['user_id'];
$first_name = $_SESSION['user'];
$last_name = $_SESSION['last_name'];  
$contact_number = $_SESSION['contact_number'];  
$email = $_SESSION['email'];  
$event = $_SESSION['event'];
$profile_pic = $_SESSION['profile_pic'];
$registration_date = $_SESSION['registration_date']; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>

    <!-- Navigation Bar -->
    <nav>
        <div class="logo">
            <img src="logo.png" alt="Logo">
        </div>
        <ul>
            <li><a href="#profile">Profile</a></li>
            <li><a href="#events">Events</a></li>
            <li><a href="#contact">Contact</a></li>
            <li><a href="logout.php">Logout</a></li> <!-- Logout link -->
        </ul>
    </nav>

    <!-- Profile Section -->
    <section class="profile" id="profile">
        <div class="profile-container">
            <div class="user-info">
                <img src="uploads/profile_pics/<?php echo $profile_pic; ?>" alt="User Image" class="user-image">
                <div class="user-details">
                    <h2><?php echo $first_name . " " . $last_name; ?></h2>
                    <p><strong>Email:</strong> <?php echo $email; ?></p> <!-- Display email -->
                    <p><strong>Contact Number:</strong> <?php echo $contact_number; ?></p> <!-- Display contact number -->
                    <p><strong>Selected Event:</strong> <?php echo $event; ?></p> <!-- Display selected event -->
                    <p><strong>Registration Date:</strong> <?php echo $registration_date; ?></p> <!-- Display registration date -->
                </div>
            </div>
        </div>
    </section>

    <!-- Upcoming Events Section -->
    <section class="events" id="events">
        <h2>Upcoming Events</h2>
        <div class="event-list">
            <div class="event-card">
                <h3>Tech Conference 2025</h3>
                <p>Date: June 25, 2025</p>
                <p>Location: San Francisco, CA</p>
                <p>Details: A conference focused on the latest in tech innovations and software development.</p>
            </div>
            <div class="event-card">
                <h3>Music Festival 2025</h3>
                <p>Date: July 10, 2025</p>
                <p>Location: Los Angeles, CA</p>
                <p>Details: A grand music festival featuring international artists and performances.</p>
            </div>
            <div class="event-card">
                <h3>Web Development Workshop</h3>
                <p>Date: August 5, 2025</p>
                <p>Location: New York, NY</p>
                <p>Details: A hands-on workshop for aspiring web developers, covering the latest frameworks and techniques.</p>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer>
        <p>&copy; 2025 Your Company. All rights reserved.</p>
    </footer>

</body>
</html>
