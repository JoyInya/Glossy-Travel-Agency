<?php

include('db_config.php');


$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : die("Booking ID not specified.");


$booking = null;


$queries = [
    'hotel_bookings' => "SELECT * FROM hotel_bookings WHERE id = ?",
    'flight_bookings' => "SELECT * FROM flight_bookings WHERE id = ?",
    'activities_booking' => "SELECT * FROM activities_booking WHERE id = ?"
];

foreach ($queries as $table => $query) {
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $booking = $result->fetch_assoc();
        break;  
    }
    $stmt->close();
}


if (!$booking) {
    echo "No booking found with this ID.";
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Details</title>
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <div class="container">
        <h1>Booking Details</h1>
        <p><strong>Booking ID:</strong> <?php echo $booking['id']; ?></p>

        <?php if (isset($booking['hotel_name'])): ?>
            <h3>Hotel Booking</h3>
            <p><strong>Hotel Name:</strong> <?php echo $booking['hotel_name']; ?></p>
            <p><strong>Location:</strong> <?php echo $booking['hotel_location']; ?></p>
            <p><strong>Check-in Date:</strong> <?php echo $booking['check_in_date']; ?></p>
            <p><strong>Check-out Date:</strong> <?php echo $booking['check_out_date']; ?></p>
            <p><strong>Rooms:</strong> <?php echo $booking['rooms']; ?></p>
            <p><strong>Price:</strong> <?php echo $booking['price']; ?></p>
            <p><strong>Status:</strong> <?php echo $booking['status']; ?></p>

        <?php elseif (isset($booking['from_location'])): ?>
            <h3>Flight Booking</h3>
            <p><strong>From:</strong> <?php echo $booking['from_location']; ?></p>
            <p><strong>To:</strong> <?php echo $booking['to_location']; ?></p>
            <p><strong>Departure Date:</strong> <?php echo $booking['departure_date']; ?></p>
            <p><strong>Return Date:</strong> <?php echo $booking['return_date']; ?></p>
            <p><strong>Passenger Name:</strong> <?php echo $booking['passenger_name']; ?></p>
            <p><strong>Total Price:</strong> <?php echo $booking['total_price']; ?></p>
            <p><strong>Status:</strong> <?php echo $booking['status']; ?></p>

        <?php elseif (isset($booking['activity_name'])): ?>
            <h3>Activity Booking</h3>
            <p><strong>Activity Name:</strong> <?php echo $booking['activity_name']; ?></p>
            <p><strong>Country:</strong> <?php echo $booking['country']; ?></p>
            <p><strong>Booking Date:</strong> <?php echo $booking['booking_date']; ?></p>
        <?php endif; ?>

        <a href="view_bookings.php">Back to Bookings</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
