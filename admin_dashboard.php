<?php
session_start();

// Protect the page: Ensure only admins can access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// Database connection
include 'db_config.php';

// Fetch total bookings (from hotel_bookings, activities_booking, and flight_bookings)
$hotel_booking_query = "SELECT COUNT(*) FROM hotel_bookings";
$hotel_booking_result = $conn->query($hotel_booking_query);

if (!$hotel_booking_result) {
    die("Error fetching hotel bookings: " . $conn->error);
}

$total_hotel_bookings = $hotel_booking_result->fetch_row()[0];

$activity_booking_query = "SELECT COUNT(*) FROM activities_booking";
$activity_booking_result = $conn->query($activity_booking_query);

if (!$activity_booking_result) {
    die("Error fetching activity bookings: " . $conn->error);
}

$total_activity_bookings = $activity_booking_result->fetch_row()[0];

$flight_booking_query = "SELECT COUNT(*) FROM flight_bookings";
$flight_booking_result = $conn->query($flight_booking_query);

if (!$flight_booking_result) {
    die("Error fetching flight bookings: " . $conn->error);
}

$total_flight_bookings = $flight_booking_result->fetch_row()[0];

// Total bookings = sum of bookings from all tables (excluding activity bookings for pending cancellations)
$total_bookings = $total_hotel_bookings + $total_activity_bookings + $total_flight_bookings;

// Fetch total non-admin users
$user_query = "SELECT COUNT(*) FROM users WHERE role != 'admin'"; // Only count non-admin users
$user_result = $conn->query($user_query);

if (!$user_result) {
    die("Error fetching total users: " . $conn->error);
}

$total_users = $user_result->fetch_row()[0];

// Fetch pending cancellations for hotel bookings (assuming status column exists and 'pending' is used)
$pending_query = "SELECT COUNT(*) FROM hotel_bookings WHERE status = 'pending'"; // Adjust status column name if needed
$pending_result = $conn->query($pending_query);

if (!$pending_result) {
    die("Error fetching pending cancellations for hotel bookings: " . $conn->error);
}

$total_pending_cancellations = $pending_result->fetch_row()[0];

// Fetch pending cancellations for flight bookings (assuming status column exists and 'pending' is used)
$pending_query = "SELECT COUNT(*) FROM flight_bookings WHERE status = 'pending'"; // Adjust status column name if needed
$pending_result = $conn->query($pending_query);

if (!$pending_result) {
    die("Error fetching pending cancellations for flight bookings: " . $conn->error);
}

$total_pending_cancellations += $pending_result->fetch_row()[0];

// No need to consider activities_bookings for pending cancellations calculation
// $pending_activity_query is now excluded.

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="admin_dashboard.css">
</head>
<body>
    <!-- Sidebar -->
    <div class="sidebar">
        <h2>Admin Dashboard</h2>
        <ul>
            <li><a href="view_bookings.php">Manage Bookings</a></li>
            <li><a href="manage_users.php">Manage Users</a></li>
            <li><a href="send_notifications.php">Send Notifications</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <h1>Welcome, Admin <?php echo htmlspecialchars($_SESSION['user']); ?>!</h1>
        <p>This is the admin dashboard where you can manage bookings, users, and notifications.</p>

        <div class="stats">
            <div class="card">
                <h3>Total Bookings</h3>
                <p><?php echo $total_bookings; ?></p>
            </div>
            <div class="card">
                <h3>Total Users</h3>
                <p><?php echo $total_users; ?></p>
            </div>
            <div class="card">
                <h3>Pending Cancellations</h3>
                <p><?php echo $total_pending_cancellations; ?></p>
            </div>
        </div>
    </div>

</body>
</html>
