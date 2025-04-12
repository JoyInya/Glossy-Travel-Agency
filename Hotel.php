<?php 
include 'db_config.php'; 
include 'include/header.php';
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Hotels</title>
    <link rel="stylesheet" href="hotel.css"> 
</head>
<body>

    <section class="hotels">
        <h2>Explore Hotels</h2>
        
        <label for="country-filter">Filter by Country:</label>
        <select id="country-filter" onchange="filterHotels()">
            <option value="all">All Countries</option>
            <option value="paris">Paris</option>
            <option value="kenya">Kenya</option>
            <option value="usa">USA</option>
            <option value="south-africa">South Africa</option>
        </select>

        <div class="hotels-grid">
            <?php include 'Hotels.php'; ?> 
        </div>
    </section>

    <script src="Hotel.js"></script> 
    <?php include 'include/footer.php'; ?>
</body>
</html>
