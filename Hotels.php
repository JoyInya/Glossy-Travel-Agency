<?php
include 'db_config.php'; 

$query = "SELECT * FROM hotels";
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="hotel-card">';
    echo '<img src="pictures/' . htmlspecialchars($row['image']) . '" alt="' . htmlspecialchars($row['hotel_name']) . '">';
    echo '<h3>' . htmlspecialchars($row['hotel_name']) . ' (' . htmlspecialchars($row['country']) . ')</h3>';
    echo '<p>' . htmlspecialchars($row['description']) . '</p>';
    echo '<p>Price: $' . htmlspecialchars($row['price']) . '</p>';
    echo '<button onclick="bookHotel(\'' . $row['hotel_name'] . '\', \'' . $row['country'] . '\', \'' . $row['price'] . '\')">Book Now</button>';
    echo '</div>'; 
}
?>
