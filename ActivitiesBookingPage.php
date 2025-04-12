<?php include 'db_config.php'; ?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Activity</title>
    <link rel="stylesheet" href="ActBooking.CSS">
</head>
<body>

    <section class="booking">
        <h2>Book Your Activity</h2>
        
        <p id="activity-details">Loading...</p> 

       
        <form action="ActivitiesBooking.php" method="POST">
            <label for="full_name">Full Name:</label>
            <input type="text" id="full_name" name="full_name" placeholder="Enter Full Name" required>

            <label for="email">Email:</label>
            <input type="email" id="email" name="email" placeholder="Enter Email" required>


            <input type="hidden" id="activity-name" name="activity_name">
            <input type="hidden" id="country" name="country">

            <label for="booking-date">Booking Date:</label>
            <input type="date" id="booking-date" name="booking_date" required>

            <button type="submit">Confirm Booking</button>
        </form>
    </section>

    <script src="ActBooking.js"></script>

</body>
</html>
