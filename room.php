<?php
require 'dbconnection.php'; // เชื่อมต่อฐานข้อมูล

for ($floor = 1; $floor <= 8; $floor++) {
    for ($room = 1; $room <= 23; $room++) {
        $room_number = sprintf("%d%02d", $floor, $room); // สร้างหมายเลขห้องเช่น 101, 102, ..., 823
        $sql = "INSERT INTO rooms (room_number, floor, status) VALUES ('$room_number', '$floor', 'available')";

        if ($conn->query($sql) === TRUE) {
            echo "เพิ่มห้อง $room_number สำเร็จ<br>";
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มห้อง $room_number: " . $conn->error . "<br>";
        }
    }
}

$conn->close();

?>