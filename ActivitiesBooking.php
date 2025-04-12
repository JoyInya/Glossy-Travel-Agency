<?php
include 'db_config.php';
session_set_cookie_params(86400 * 30);
session_start();

// Assuming the user is logged in, we fetch their user_id from the session
$user_id = $_SESSION['user_id']; // Get the logged-in user's ID from session

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get data from the POST request
    $activity_name = $_POST['activity_name'];
    $country = $_POST['country'];
    $booking_date = $_POST['booking_date'];
    $full_name = $_POST['full_name'];  // Assuming you have this in your form
    $email = $_POST['email'];  // Assuming you have this in your form

    // Check for existing booking
    $checkBookingQuery = "SELECT * FROM activities_booking WHERE user_id = ? AND booking_date = ?";
    $checkStmt = $conn->prepare($checkBookingQuery);
    $checkStmt->bind_param("is", $user_id, $booking_date);
    $checkStmt->execute();
    $existingBooking = $checkStmt->get_result()->fetch_assoc();

    if ($existingBooking) {
        // Double booking detected, ask user if they want to continue
        echo "<script>
            var confirmBooking = confirm('You already have a booking on this date. Do you still want to continue with this booking?');
            if (confirmBooking) {
                window.location.href = 'ActivitiesBooking.php';  // Continue booking
            } else {
                window.location.href = 'activities.php';  // Redirect to the booking page
            }
        </script>";
        exit;
    }

    // Insert the booking into activities_booking table
    $sql = "INSERT INTO activities_booking (user_id, activity_name, country, booking_date, full_name, email) 
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssss", $user_id, $activity_name, $country, $booking_date, $full_name, $email);  // Bind parameters

    if ($stmt->execute()) {
        echo "Booking Successful!";
        header("Refresh: 2; URL=my-itinerary.php"); // Redirect to the itinerary page
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
}

$conn->close();
?>
