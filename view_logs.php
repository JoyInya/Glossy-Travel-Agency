<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "glossy travel agency";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM email_logs";
$result = $conn->query($sql);

echo "<table border='1'>
<tr>
    <th>Email</th>
    <th>Subject</th>
    <th>Status</th>
    <th>Timestamp</th>
</tr>";

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        echo "<tr>
            <td>".$row['email']."</td>
            <td>".$row['subject']."</td>
            <td>".$row['status']."</td>
            <td>".$row['created_at']."</td>
        </tr>";
    }
    echo "</table>";
} else {
    echo "0 results";
}

$conn->close();
?>
