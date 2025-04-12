<?php
include 'db_config.php';

$query = "SELECT * FROM activities"; 
$result = mysqli_query($conn, $query);

while ($row = mysqli_fetch_assoc($result)) {
    echo '<div class="activity-card" data-country="'.strtolower($row['country']).'">';
    echo '<img src="pictures/'.$row['image'].'" alt="'.$row['activity_name'].'">';
    echo '<h3>'.$row['activity_name'].' ('.$row['country'].')</h3>';
    echo '<p>'.$row['description'].'</p>';
    
   
    echo '<button onclick="window.location.href=\'ActivitiesBookingPage.php?activity='.urlencode($row['activity_name']).'&country='.urlencode($row['country']).'\'">Book Now</button>';
    echo '</div>';
}
?>
