
<?php 
include 'db_config.php'; 
include 'include/header.php';
$totalPrice = isset($_SESSION['total_price']) ? $_SESSION['total_price'] : 0;

?> 


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Flight</title>
    <link rel="stylesheet" href="Flight.css">
    

</head>
<body>

<div class="container">
    <h2>Book Your Flight</h2>

    <form id="flightBookingForm" action="flights.php" method="POST">
        <label for="passenger_name">Passenger Name:</label>
        <input type="text" id="passenger_name" name="passenger_name" required>

        <label for="fromLocation">From:</label>
        <select id="fromLocation" name="fromLocation" required>
            <option value="">Select Departure</option>
            <option value="Kenya">Kenya</option>
            <option value="Paris">Paris</option>
            <option value="USA">USA</option>
            <option value="South Africa">South Africa</option>
        </select>

        <label for="toLocation">To:</label>
        <select id="toLocation" name="toLocation" required>
            <option value="">Select Destination</option>
            <option value="Kenya">Kenya</option>
            <option value="Paris">Paris</option>
            <option value="USA">USA</option>
            <option value="South Africa">South Africa</option>
        </select>

        <label for="travelers">Travelers:</label>
        <input type="number" id="travelers" name="travelers" min="1" value="1" required>

        <label for="departure">Departure Date:</label>
        <input type="date" id="departure" name="departure" required>

        <label for="return">Return Date (optional):</label>
        <input type="date" id="return" name="return">

        <label>Travel Class:</label>
        <div class="class-selection">
            <button type="button" class="class-btn active" data-class="Economy">Economy</button>
            <button type="button" class="class-btn" data-class="Business">Business</button>
        </div>
        <input type="hidden" name="travelClass" id="travelClassInput" value="Economy">

        <button type="button" id="calculatePrice">Calculate Price</button>
        <p id="totalPrice">Total: $0</p>
        <input type="hidden" name="totalPrice" id="totalPriceInput">

        <button type="submit" name="submit" class="btn">Book Flight</button>
    </form>
</div>

    
    <script src="Book Flight.js"></script>
   
 <?php include 'include/footer.php';?>
</body>

</html>
