<?php
session_start();
include 'db_config.php';

if (!isset($_GET['transaction_id'])) {
    echo "<script>alert('Invalid Payment!'); window.location.href='HotelBooking.php';</script>";
    exit;
}

$payment_id = $_GET['transaction_id'];
$payer_id = $_GET['payer_id'] ?? 'Unknown';
$payer_email = $_GET['payer_email'] ?? 'Unknown';
$amount = $_SESSION['total_price'] ?? 0;
$currency = "USD";
$payment_status = "Completed";
$user_id = $_SESSION['user_id'] ?? null;


$insert_query = "INSERT INTO payments (payment_id, payer_id, payer_email, amount, currency, payment_status) 
                 VALUES (?, ?, ?, ?, ?, ?)";
$stmt = $conn->prepare($insert_query);
$stmt->bind_param("sssds", $payment_id, $payer_id, $payer_email, $amount, $currency, $payment_status);
$stmt->execute();


echo "<script>alert('Payment successful! Your booking is confirmed.'); window.location.href='HotelBooking.php';</script>";
?>