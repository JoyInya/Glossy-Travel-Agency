<?php
include 'db_config.php'; 
session_start(); // Ensure session handling is working correctly

// Check if the form is submitted
if (isset($_POST['submit'])) {
    // Collecting form data
    $fromLocation = $_POST['fromLocation'];
    $toLocation = $_POST['toLocation'];
    $travelers = (int)$_POST['travelers'];
    $departure = $_POST['departure'];
    $return = !empty($_POST['return']) ? $_POST['return'] : NULL;
    $travelClass = isset($_POST['travelClass']) ? $_POST['travelClass'] : "Economy";
    $passengerName = $_POST['passenger_name']; // Ensure this field is in the form
    $user_id = $_SESSION['user_id']; // Ensure that user is logged in and session is set

    // Debugging output (Remove in production)
    echo "User ID: $user_id<br>";
    echo "From Location: $fromLocation<br>";
    echo "To Location: $toLocation<br>";
    echo "Travelers: $travelers<br>";
    echo "Departure: $departure<br>";
    echo "Return: $return<br>";
    echo "Class: $travelClass<br>";

    // Double booking check
    $checkBookingQuery = "SELECT * FROM flight_bookings WHERE user_id = ? AND (departure_date = ? OR return_date = ?)";
    $checkStmt = $conn->prepare($checkBookingQuery);
    $checkStmt->bind_param("iss", $user_id, $departure, $return);
    $checkStmt->execute();
    $existingBooking = $checkStmt->get_result()->fetch_assoc();

    if ($existingBooking) {
        // Double booking detected, ask user if they want to continue
        echo "<script>
                var confirmBooking = confirm('You already have a booking on this date. Do you still want to continue with this booking?');
                if (confirmBooking) {
                    window.location.href = 'flights.php';  // Continue booking
                } else {
                    window.location.href = 'Book Flight.php';  // Redirect to the booking page
                }
            </script>";
        exit;
    }

    // Fetch flight details from the database
    $query = "SELECT id, price, economy_seats_available, business_seats_available FROM flights WHERE departure = ? AND destination = ?";
    $stmt = $conn->prepare($query);

    if (!$stmt) {
        die("SQL Error (Flight Fetch): " . $conn->error);
    }

    $stmt->bind_param("ss", $fromLocation, $toLocation);
    $stmt->execute();
    $result = $stmt->get_result();
    $flight = $result->fetch_assoc();

    if (!$flight) {
        echo "<script>alert('Error: Flight not found. Please check your details.'); window.location.href='Book Flight.php';</script>";
        exit;
    }

    // Fetch necessary details from the flight result
    $flightId = $flight['id'];
    $basePrice = floatval($flight['price']);
    $seatColumn = ($travelClass === 'Economy') ? 'economy_seats_available' : 'business_seats_available';
    $seatsAvailable = (int)$flight[$seatColumn];

    // Check if enough seats are available
    if ($travelers > $seatsAvailable) {
        echo "<script>alert('Error: Not enough seats available. Only $seatsAvailable left.'); window.location.href='Book Flight.php';</script>";
        exit;
    }

    // Calculate total price based on class and number of travelers
    $multiplier = ($travelClass === 'Economy') ? 1 : 1.8; 
    $totalPrice = $basePrice * $travelers * $multiplier;

    // Update the available seats in the database
    $newSeatsAvailable = $seatsAvailable - $travelers;
    $updateQuery = "UPDATE flights SET $seatColumn = ? WHERE id = ?";
    $updateStmt = $conn->prepare($updateQuery);

    if (!$updateStmt) {
        die("SQL Error (Seat Update): " . $conn->error);
    }
    $updateStmt->bind_param("ii", $newSeatsAvailable, $flightId);
    $updateStmt->execute();

    // Check if the update was successful
    if ($updateStmt->affected_rows <= 0) {
        die("Error: Could not update seat availability.");
    }

    // Insert booking into the flight_bookings table with status and payment_status
    $insertQuery = "INSERT INTO flight_bookings (from_location, to_location, travelers, departure_date, return_date, class, total_price, flight_id, user_id, passenger_name, status, payment_status) 
                    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'Pending', 'pending')";
    $insertStmt = $conn->prepare($insertQuery);

    if (!$insertStmt) {
        die("SQL Error (Booking Insert): " . $conn->error);
    }

    $insertStmt->bind_param("ssisssdiss", $fromLocation, $toLocation, $travelers, $departure, $return, $travelClass, $totalPrice, $flightId, $user_id, $passengerName);
    $insertStmt->execute();

    // Check if the booking was successful
    if ($insertStmt->affected_rows > 0) {
        // Booking successful, set session variables
        $_SESSION['total_price'] = $totalPrice;
        $_SESSION['booking_type'] = "flight";
        $_SESSION['booking_id'] = $insertStmt->insert_id;

        // Output for debugging (remove in production)
        echo "Booking Successful! Your booking ID is: " . $_SESSION['booking_id'] . "<br>";
        echo "Total Price: " . $_SESSION['total_price'] . "<br>";

        // Redirect with confirmation message
        echo "<script>alert('Booking initiated. Please proceed to payment to confirm your booking.'); window.location.href='payment.php';</script>";
        exit;
    } else {
        echo "<script>alert('Error: Could not complete the booking.'); window.location.href='Book Flight.php';</script>";
        exit;
    }
}
?>
