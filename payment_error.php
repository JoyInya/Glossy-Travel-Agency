<?php
// Start session to handle user information if needed
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Error</title>
    <link rel="stylesheet" href="styles.css"> <!-- Add your custom CSS -->
</head>
<body>
    <div class="error-container">
        <h2>Payment Error</h2>
        <p>We're sorry, but there was an issue processing your payment. Please try again.</p>

        <!-- Display a generic error message, or add specific details from the payment gateway if available -->
        <p>Error Details: <?php echo isset($_GET['error_message']) ? htmlspecialchars($_GET['error_message']) : 'An unknown error occurred.'; ?></p>

        <p>Possible Actions:</p>
        <ul>
            <li>Ensure your payment details are correct.</li>
            <li>Check your internet connection and try again.</li>
            <li>If the issue persists, please <a href="contact_us.php">contact support</a>.</li>
        </ul>

        <!-- Back to Booking or Retry Payment -->
        <p><a href="payment.php">Retry Payment</a></p>
        <p><a href="my-itinerary.php">Go Back to Your Itinerary</a></p>
    </div>
</body>
</html>
