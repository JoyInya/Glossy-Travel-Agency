<?php
include 'db_config.php'; 
session_start(); 

if (isset($_POST['submit'])) {
    $hotel_name = $_POST['hotel_name'];
    $hotel_location = $_POST['hotel_location'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $rooms = intval($_POST['rooms']);
    $room_type = $_POST['room_type'];
    $price = floatval($_POST['total_price']);
    
    $user_id = $_SESSION['user_id'] ?? null; 
    $hotel_id = $_POST['hotel_id'] ?? null; 

    // Double booking check
    $checkBookingQuery = "SELECT * FROM hotel_bookings WHERE user_id = ? AND hotel_name = ? AND (check_in_date = ? OR check_out_date = ?)";
    $checkStmt = $conn->prepare($checkBookingQuery);
    if ($checkStmt === false) {
        die("Error preparing double booking check: " . $conn->error);
    }
    $checkStmt->bind_param("isss", $user_id, $hotel_name, $check_in_date, $check_out_date);
    if (!$checkStmt->execute()) {
        die("Error executing double booking check: " . $checkStmt->error);
    }
    $existingBooking = $checkStmt->get_result()->fetch_assoc();

    if ($existingBooking) {
        // Prompt user via JS confirm
        echo "<script>
                var confirmBooking = confirm('You already have a booking at this hotel on this date. Do you still want to continue with a new booking?');
                if (confirmBooking) {
                    window.location.href = 'payment.php?continue=1';
                } else {
                    alert('Booking cancelled. You were redirected back.');
                    window.location.href = 'Hotel.php';
                }
            </script>";
        exit;
    }

    // If continued booking is confirmed
    if (isset($_GET['continue']) && $_GET['continue'] == 1) {
        // Get hotel details
        $query = "SELECT id, price, single_rooms_available, double_rooms_available, suite_rooms_available FROM hotels WHERE hotel_name = ?";
        $stmt = $conn->prepare($query);
        if ($stmt === false) {
            die("Error preparing hotel query: " . $conn->error);
        }
        $stmt->bind_param("s", $hotel_name);
        if (!$stmt->execute()) {
            die("Error executing hotel query: " . $stmt->error);
        }
        $result = $stmt->get_result();
        $hotel = $result->fetch_assoc();

        if (!$hotel) {
            echo "<script>alert('Hotel not found. Please try again.'); window.location.href='HotelBooking.php';</script>";
            exit;
        }

        $hotelId = $hotel['id'];
        $pricePerRoom = floatval($hotel['price']); 

        // Room availability check
        $roomsAvailable = 0;
        if ($room_type == 'single') {
            $roomsAvailable = $hotel['single_rooms_available'];
        } else if ($room_type == 'double') {
            $roomsAvailable = $hotel['double_rooms_available'];
        } else {
            $roomsAvailable = $hotel['suite_rooms_available'];
        }

        if ($rooms > $roomsAvailable) {
            echo "<script>alert('Not enough rooms available. Please reduce the number of rooms.'); window.location.href='HotelBooking.php';</script>";
            exit;
        }

        // Calculate total
        $totalPrice = $pricePerRoom * $rooms;
        $_SESSION['total_price'] = $totalPrice;

        $queryInsert = "INSERT INTO hotel_bookings (user_id, hotel_name, hotel_location, check_in_date, check_out_date, rooms, room_type, price, hotel_id)
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmtInsert = $conn->prepare($queryInsert);
        $stmtInsert->bind_param("issssisdi", $user_id, $hotel_name, $hotel_location, $check_in_date, $check_out_date, $rooms, $room_type, $totalPrice, $hotelId);
        if (!$stmtInsert->execute()) {
            die("Error inserting booking: " . $stmtInsert->error);
        }

        $_SESSION['booking_id'] = $stmtInsert->insert_id;
        echo "<script>alert('Booking initiated. Please proceed to payment to confirm your booking.'); window.location.href='payment.php';</script>";
        exit;
    }

    // If no existing booking, process normally
    $query = "SELECT id, price, single_rooms_available, double_rooms_available, suite_rooms_available FROM hotels WHERE hotel_name = ?";
    $stmt = $conn->prepare($query);
    if ($stmt === false) {
        die("Error preparing hotel query: " . $conn->error);
    }
    $stmt->bind_param("s", $hotel_name);
    if (!$stmt->execute()) {
        die("Error executing hotel query: " . $stmt->error);
    }
    $result = $stmt->get_result();
    $hotel = $result->fetch_assoc();

    if (!$hotel) {
        echo "<script>alert('Hotel not found. Please try again.'); window.location.href='HotelBooking.php';</script>";
        exit;
    }

    $hotelId = $hotel['id'];
    $pricePerRoom = floatval($hotel['price']); 

    $roomsAvailable = 0;
    if ($room_type == 'single') {
        $roomsAvailable = $hotel['single_rooms_available'];
    } else if ($room_type == 'double') {
        $roomsAvailable = $hotel['double_rooms_available'];
    } else {
        $roomsAvailable = $hotel['suite_rooms_available'];
    }

    if ($rooms > $roomsAvailable) {
        echo "<script>alert('Not enough rooms available. Please try a different number.'); window.location.href='HotelBooking.php';</script>";
        exit;
    }

    $totalPrice = $pricePerRoom * $rooms;
    $_SESSION['total_price'] = $totalPrice;

    $queryInsert = "INSERT INTO hotel_bookings (user_id, hotel_name, hotel_location, check_in_date, check_out_date, rooms, room_type, price, hotel_id)
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmtInsert = $conn->prepare($queryInsert);
    $stmtInsert->bind_param("issssisdi", $user_id, $hotel_name, $hotel_location, $check_in_date, $check_out_date, $rooms, $room_type, $totalPrice, $hotelId);

    if (!$stmtInsert->execute()) {
        die("Error inserting booking: " . $stmtInsert->error);
    }

    $_SESSION['booking_id'] = $stmtInsert->insert_id;
    echo "<script>alert('Booking initiated. Please proceed to payment to confirm your booking.'); window.location.href='payment.php';</script>";
    exit;
}
?>