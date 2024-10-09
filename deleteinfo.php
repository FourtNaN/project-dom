<?php
require 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = $_POST['room_number'];

    // ลบข้อมูลในฐานข้อมูล
    $delete_sql = "DELETE FROM room_info WHERE room_number = '$room_number'";

    if ($conn->query($delete_sql) === TRUE) {
        echo "<div class='alert alert-success'>ลบข้อมูลเรียบร้อยแล้ว</div>";
        // ทำการ redirect ไปหน้าที่ต้องการ เช่น ตารางข้อมูลห้อง
        header("Location: /problemTable.php");
        exit();
    } else {
        echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการลบข้อมูล: " . $conn->error . "</div>";
    }
}

$conn->close();
