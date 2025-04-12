<?php
session_start();
include 'db_config.php';
// DEBUG: show all errors (remove later in production)
ini_set('display_errors', 1);
error_reporting(E_ALL);

if (!isset($_SESSION['total_price'], $_SESSION['booking_id'])) {
    die("Error: Booking details missing.");
}

$totalPrice = $_SESSION['total_price'];
$booking_id = $_SESSION['booking_id'];

require 'config.php';
$paypalClientId = PAYPAL_CLIENT_ID;
?>

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=<?= htmlspecialchars($paypalClientId) ?>&currency=USD"></script>

<!-- PayPal Button Container -->
<div id="paypal-button-container"></div>

<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '<?= htmlspecialchars($totalPrice) ?>'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
            return actions.order.capture().then(function(details) {
                window.location.href = "process_payment.php?amount=<?= urlencode($totalPrice) ?>&orderID=" + details.id + "&bookingID=<?= urlencode($booking_id) ?>";
            });
        }
    }).render('#paypal-button-container');
</script>
