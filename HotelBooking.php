<?php 
include 'db_config.php'; 
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $hotel_name = $_POST['hotel_name'];
    $hotel_location = $_POST['hotel_location'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $rooms = intval($_POST['rooms']);
    $room_type = $_POST['room_type'];
    $price = floatval($_POST['price']);
    $user_id = $_SESSION['user_id'] ?? null; 
    $hotel_id = $_POST['hotel_id'] ?? null;

    $query = "INSERT INTO hotel_bookings (hotel_name, hotel_location, check_in_date, check_out_date, rooms, room_type, user_id, price, hotel_id)
              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = mysqli_prepare($conn, $query);
    mysqli_stmt_bind_param($stmt, "ssssisdii", $hotel_name, $hotel_location, $check_in_date, $check_out_date, $rooms, $room_type, $user_id, $price, $hotel_id);

    if (mysqli_stmt_execute($stmt)) {
        $_SESSION['total_price'] = $price;  
        $_SESSION['booking_type'] = "hotel";
        $_SESSION['booking_id'] = $conn->insert_id;  

        header("Location: payment.php"); 
        exit;
    } else {
        echo "<script>alert('Error: Could not complete booking.');</script>";
    }
    mysqli_stmt_close($stmt);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hotel Booking</title>
    <link rel="stylesheet" href="Hotel Booking.css">
</head>
<body>
<section>
<form id="booking-form" method="POST" action="process_HotelBooking.php">
    <label for="hotel-name">Hotel Name:</label>
    <input type="text" id="hotel-name" name="hotel_name" value="<?= $hotel_name; ?>" readonly>

    <label for="location">Location:</label>
    <input type="text" id="location" name="hotel_location" value="<?= $location; ?>" readonly>

    <label for="price">Base Price (Single Room per Night):</label>
    <input type="text" id="price" name="base_price" value="<?= number_format($base_price, 2); ?>" readonly>

    <label for="checkin-date">Check-in Date:</label>
    <input type="date" id="checkin-date" name="check_in_date" required>

    <label for="checkout-date">Check-out Date:</label>
    <input type="date" id="checkout-date" name="check_out_date" required>

    <label for="rooms">Number of rooms:</label>
    <input type="number" id="rooms" name="rooms" min="1" value="1" required>

    <label for="room-type">Room Type:</label>
    <select id="room-type" name="room_type">
        <option value="single">Single</option>
        <option value="double">Double</option>
        <option value="suite">Suite</option>
    </select>

    <p>Total Price: <span id="total-price"> $0.00</span></p>

    <input type="hidden" id="total-price-input" name="total_price">

    <button type="submit" name="submit" class="confirm-btn">Confirm Booking</button>
</form>
</section>

<script src="Hotel Booking.js" defer></script>
</body>
</html>
