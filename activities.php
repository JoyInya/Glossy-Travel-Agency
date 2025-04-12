<?php 
include 'db_config.php'; 
include 'include/header.php';
?> 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Explore Activities</title>
    <link rel="stylesheet" href="activities.css"> 
</head>
<body>

    <section class="activities">
        <h2>Explore Activities</h2>
        
        <label for="country-filter">Filter by Country:</label>
        <select id="country-filter" onchange="filterActivities()">
            <option value="all">All Countries</option>
            <option value="paris">Paris</option>
            <option value="kenya">Kenya</option>
            <option value="usa">USA</option>
            <option value="south-africa">South Africa</option>
        </select>

        <div class="activities-grid">
            <?php include 'Activity.php'; ?> 
        </div>
    </section>

    <script src="activities.js"></script> 
</body>
<?php include 'include/footer.php'; ?>
</html>
