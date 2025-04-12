<?php

include 'db_config.php';


$all_bookings = [];


$query_hotel = "SELECT id AS booking_id, user_id, check_in_date, check_out_date, hotel_name, status FROM hotel_bookings ORDER BY check_in_date DESC";
$result_hotel = $conn->query($query_hotel);


if ($result_hotel === false) {
    die('Error executing hotel bookings query: ' . $conn->error);
}


if ($result_hotel->num_rows > 0) {
    $hotel_bookings = $result_hotel->fetch_all(MYSQLI_ASSOC);
    foreach ($hotel_bookings as $booking) {
        $booking['type'] = 'Hotel'; 
        $all_bookings[] = $booking;
    }
}


$query_activity = "SELECT id AS booking_id, user_id, booking_date, activity_name FROM activities_booking ORDER BY booking_date DESC";
$result_activity = $conn->query($query_activity);


if ($result_activity === false) {
    die('Error executing activity bookings query: ' . $conn->error);
}


if ($result_activity->num_rows > 0) {
    $activity_bookings = $result_activity->fetch_all(MYSQLI_ASSOC);
    foreach ($activity_bookings as $booking) {
        $booking['type'] = 'Activity'; 
        $all_bookings[] = $booking;
    }
}


$query_flight = "SELECT id AS booking_id, user_id, departure_date, return_date, from_location, to_location, status FROM flight_bookings ORDER BY departure_date DESC";
$result_flight = $conn->query($query_flight);


if ($result_flight === false) {
    die('Error executing flight bookings query: ' . $conn->error);
}


if ($result_flight->num_rows > 0) {
    $flight_bookings = $result_flight->fetch_all(MYSQLI_ASSOC);
    foreach ($flight_bookings as $booking) {
        $booking['type'] = 'Flight'; 
        $all_bookings[] = $booking;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Bookings - Travel Agency</title>
    <link rel="stylesheet" href="view_bookings.css">
</head>
<body>
    <div class="container">
        <header>
            <h1>View All Bookings</h1>
            <a href="admin_dashboard.php" class="back-button">Back to Dashboard</a>
        </header>

        
        <table class="bookings-table">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User ID</th>
                    <th>Booking Date</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($all_bookings)) : ?>
                    <?php foreach ($all_bookings as $booking) : ?>
                        <tr>
                            <td><?= htmlspecialchars($booking['booking_id']) ?></td>
                            <td><?= htmlspecialchars($booking['user_id']) ?></td>
                            <td><?= htmlspecialchars($booking['booking_date'] ?? $booking['check_in_date'] ?? $booking['departure_date']) ?></td>
                            <td><?= htmlspecialchars($booking['type']) ?></td>
                            <td><?= htmlspecialchars($booking['status'] ?? 'N/A') ?></td>
                            <td>
                                <a href="view_booking_details.php?booking_id=<?= $booking['booking_id'] ?>" class="view-btn">View</a>
                                <a href="edit_booking.php?booking_id=<?= $booking['booking_id'] ?>" class="edit-btn">Edit</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="6">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
