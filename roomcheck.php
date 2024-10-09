<?php
require 'dbconnection.php';
$sql = "SELECT * FROM rooms ORDER BY floor, room_number";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "Room: " . $row['room_number'] . " - Status: " . $row['status'] . "<br>";
    }
} else {
    echo "No rooms found in database.";
}
?>