<?php
session_start();
include 'db_config.php';

// Validate the GET parameters
if (!isset($_GET['orderID'], $_GET['amount'], $_GET['bookingType'], $_GET['bookingID'])) {
    die("Error: Missing payment details.");
}

// Sanitize and validate inputs
$paymentId = htmlspecialchars($_GET['orderID']);
$amount = floatval($_GET['amount']);
$bookingType = htmlspecialchars($_GET['bookingType']);
$bookingId = intval($_GET['bookingID']);
$payerId = $_SESSION['user_id'];  // Ensure that payer is logged in and session is set
$payerEmail = $_SESSION['user_email']; // Assuming user's email is stored in session

// Validate bookingType to ensure it's either 'hotel' or 'flight'
if (!in_array($bookingType, ['hotel', 'flight'])) {
    die("Error: Invalid booking type.");
}

// Start transaction for both payment and booking update
$conn->begin_transaction();

try {
    // Insert payment record into the payments table
    $stmt = $conn->prepare("INSERT INTO payments (payment_id, payer_id, payer_email, amount, currency, payment_status) 
                           VALUES (?, ?, ?, ?, 'USD', 'Completed')");
    if (!$stmt) {
        throw new Exception("Error: Could not prepare the payment insertion statement.");
    }
    $stmt->bind_param("ssis", $paymentId, $payerId, $payerEmail, $amount); // Bind parameters (payment_id, payer_id, payer_email, amount)
    if (!$stmt->execute()) {
        throw new Exception("Error: Could not execute the payment insertion.");
    }

    // Update the booking status based on booking type (hotel or flight)
    if ($bookingType == "hotel") {
        $updateBooking = $conn->prepare("UPDATE hotel_bookings SET payment_status = 'Paid', status = 'Confirmed' WHERE id = ?");
    } else {
        $updateBooking = $conn->prepare("UPDATE flight_bookings SET payment_status = 'Paid', status = 'Confirmed' WHERE id = ?");
    }

    if (!$updateBooking) {
        throw new Exception("Error: Could not prepare the update booking statement.");
    }

    $updateBooking->bind_param("i", $bookingId);
    if (!$updateBooking->execute()) {
        throw new Exception("Error: Could not execute the booking update.");
    }

    // Commit the transaction
    $conn->commit();

    // Redirect to the 'my-itinerary.php' page after successful payment
    echo "<script>alert('Payment successful! Thank you.'); window.location.href='my-itinerary.php';</script>";
    exit;

} catch (Exception $e) {
    // Rollback the transaction if any error occurs
    $conn->rollback();

    // Handle the error and provide feedback to the user
    echo "<script>alert('Payment failed: " . $e->getMessage() . "'); window.location.href='payment_error.php';</script>";
    exit;
}
?>
