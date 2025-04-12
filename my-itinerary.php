<?php
include 'db_config.php';
session_start();

// Assuming the user is logged in, we fetch their user_id from the session
$user_id = $_SESSION['user_id']; // Get the logged-in user's ID from session

// Fetch the bookings for the logged-in user (flights, hotels, activities)
$sql_flights = "SELECT * FROM flight_bookings WHERE user_id = ?";
$stmt_flights = $conn->prepare($sql_flights);
$stmt_flights->bind_param("i", $user_id);
$stmt_flights->execute();
$result_flights = $stmt_flights->get_result();

$sql_hotels = "SELECT * FROM hotel_bookings WHERE user_id = ?";
$stmt_hotels = $conn->prepare($sql_hotels);
$stmt_hotels->bind_param("i", $user_id);
$stmt_hotels->execute();
$result_hotels = $stmt_hotels->get_result();

$sql_activities = "SELECT * FROM activities_booking WHERE user_id = ?";
$stmt_activities = $conn->prepare($sql_activities);
$stmt_activities->bind_param("i", $user_id);
$stmt_activities->execute();
$result_activities = $stmt_activities->get_result();

// Check if a bookingID is passed in the query string (for confirmed bookings)
if (isset($_GET['bookingID'])) {
    $booking_id = $_GET['bookingID'];

    // Retrieve the booking details from the database using the booking ID for hotels
    $query = "SELECT * FROM hotel_bookings WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $booking_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $booking = $result->fetch_assoc();

    if ($booking) {
        // Display booking confirmation details
        echo "<h2>Booking Confirmation</h2>";
        echo "<p><strong>Hotel:</strong> " . htmlspecialchars($booking['hotel_name']) . "</p>";
        echo "<p><strong>Location:</strong> " . htmlspecialchars($booking['hotel_location']) . "</p>";
        echo "<p><strong>Check-in Date:</strong> " . htmlspecialchars($booking['check_in_date']) . "</p>";
        echo "<p><strong>Check-out Date:</strong> " . htmlspecialchars($booking['check_out_date']) . "</p>";
        echo "<p><strong>Rooms Booked:</strong> " . htmlspecialchars($booking['rooms']) . "</p>";
        echo "<p><strong>Room Type:</strong> " . htmlspecialchars($booking['room_type']) . "</p>";
        echo "<p><strong>Total Price:</strong> $" . htmlspecialchars($booking['price']) . "</p>";
        echo "<p><strong>Payment Status:</strong> " . ucfirst(htmlspecialchars($booking['payment_status'])) . "</p>";
        echo "<button>Confirm Booking</button>";  // Example of confirm button (can be linked to a function to confirm booking)
    } else {
        echo "<p>Error: Booking not found.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Itinerary</title>
    <link rel="stylesheet" href="my-itinerary.css">
</head>
<body>
    <h2>My Itinerary</h2>

    <!-- Flights Section -->
    <h3 class="section-title">Booked Flights</h3>
    <?php while ($flight = $result_flights->fetch_assoc()) { ?>
        <div class="card">
            <p><strong>From:</strong> <?php echo $flight['from_location']; ?></p>
            <p><strong>To:</strong> <?php echo $flight['to_location']; ?></p>
            <p><strong>Travelers:</strong> <?php echo $flight['travelers']; ?></p>
            <p><strong>Departure:</strong> <?php echo $flight['departure_date']; ?></p>
            <p><strong>Return:</strong> <?php echo $flight['return_date'] ?: 'N/A'; ?></p>
            <p><strong>Class:</strong> <?php echo $flight['class']; ?></p>
            <p><strong>Total Price:</strong> $<?php echo number_format($flight['total_price'], 2); ?></p>
            <p><strong>Passenger Name:</strong> <?php echo $flight['passenger_name']; ?></p>
            <p><strong>Payment Status:</strong> <?php echo ucfirst($flight['payment_status']); ?></p>
        </div>
    <?php } ?>

    <!-- Hotels Section -->
    <h3 class="section-title">Booked Hotels</h3>
    <?php while ($hotel = $result_hotels->fetch_assoc()) { ?>
        <div class="card">
            <p><strong>Hotel:</strong> <?php echo $hotel['hotel_name']; ?></p>
            <p><strong>Location:</strong> <?php echo $hotel['hotel_location']; ?></p>
            <p><strong>Check-in:</strong> <?php echo $hotel['check_in_date']; ?></p>
            <p><strong>Check-out:</strong> <?php echo $hotel['check_out_date']; ?></p>
            <p><strong>Rooms:</strong> <?php echo $hotel['rooms']; ?></p>
            <p><strong>Room Type:</strong> <?php echo $hotel['room_type']; ?></p>
            <p><strong>Total Price:</strong> $<?php echo number_format($hotel['price'], 2); ?></p>
            <p><strong>Payment Status:</strong> <?php echo ucfirst($hotel['payment_status']); ?></p>
            <a href="my-itinerary.php?bookingID=<?php echo $hotel['id']; ?>">View Confirmation</a>
        </div>
    <?php } ?>

    <!-- Activities Section -->
    <h3 class="section-title">Booked Activities</h3>
    <?php while ($activity = $result_activities->fetch_assoc()) { ?>
        <div class="card">
            <p><strong>Activity:</strong> <?php echo $activity['activity_name']; ?></p>
            <p><strong>Date:</strong> <?php echo $activity['booking_date']; ?></p>
        </div>
    <?php } ?>
</body>
</html>
