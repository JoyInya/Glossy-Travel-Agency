<?php
$servername = getenv("localhost");      
$username   = getenv("root");      
$password   = getenv("");  
$dbname     = getenv("glossy travel agency");  
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
