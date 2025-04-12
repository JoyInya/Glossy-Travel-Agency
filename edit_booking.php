<?php
// Include database configuration
include('db_config.php');

// Get the booking ID from the URL
$booking_id = isset($_GET['booking_id']) ? $_GET['booking_id'] : die("Booking ID not specified.");

// Initialize booking variable
$booking = null;

// Check for hotel booking
$query = "SELECT * FROM hotel_bookings WHERE id = $booking_id";
$result = $conn->query($query);
if ($result && $result->num_rows > 0) {
    $booking = $result->fetch_assoc();
}

// Check for flight booking if not found in hotel bookings
if (!$booking) {
    $query = "SELECT * FROM flight_bookings WHERE id = $booking_id";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $booking = $result->fetch_assoc();
    }
}

// Check for activity booking if not found in hotel or flight bookings
if (!$booking) {
    $query = "SELECT * FROM activities_booking WHERE id = $booking_id";
    $result = $conn->query($query);
    if ($result && $result->num_rows > 0) {
        $booking = $result->fetch_assoc();
    }
}

// If no booking is found
if (!$booking) {
    echo "No booking found with this ID.";
    exit;
}

// Update the booking when the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $status = $_POST['status'];
    $payment_status = $_POST['payment_status'];

    // Prepare the update query based on the table where the booking belongs
    if (isset($booking['hotel_name'])) {
        $update_query = "UPDATE hotel_bookings SET status = '$status', payment_status = '$payment_status' WHERE id = $booking_id";
    } elseif (isset($booking['from_location'])) {
        $update_query = "UPDATE flight_bookings SET status = '$status', payment_status = '$payment_status' WHERE id = $booking_id";
    } elseif (isset($booking['activity_name'])) {
        $update_query = "UPDATE activities_booking SET status = '$status', payment_status = '$payment_status' WHERE id = $booking_id";
    }

    // Execute the update query
    if ($conn->query($update_query) === TRUE) {
        echo "Booking updated successfully.";
        header("Location: view_booking_details.php?booking_id=$booking_id"); // Redirect to details page
        exit;
    } else {
        echo "Error updating booking: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Booking</title>
    <link rel="stylesheet" href="styless.css">
</head>
<body>
    <div class="container">
        <h1>Edit Booking</h1>
        <form action="edit_booking.php?booking_id=<?php echo $booking['id']; ?>" method="post">
            <label for="status">Booking Status</label>
            <select name="status" id="status" required>
                <option value="Pending" <?php echo ($booking['status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Paid" <?php echo ($booking['status'] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
                <option value="Canceled" <?php echo ($booking['status'] == 'Canceled') ? 'selected' : ''; ?>>Canceled</option>
            </select>

            <label for="payment_status">Payment Status</label>
            <select name="payment_status" id="payment_status" required>
                <option value="Pending" <?php echo ($booking['payment_status'] == 'Pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="Paid" <?php echo ($booking['payment_status'] == 'Paid') ? 'selected' : ''; ?>>Paid</option>
            </select>

            <button type="submit">Update Booking</button>
        </form>

        <a href="view_booking_details.php?booking_id=<?php echo $booking['id']; ?>">Back to Booking Details</a>
    </div>
</body>
</html>

<?php $conn->close(); ?>
