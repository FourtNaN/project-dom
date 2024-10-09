<?php
require 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = isset($_GET['room_number']) ? $_GET['room_number'] : null; // รับ room_number จาก query string
    $fname = isset($_POST['fname']) ? $_POST['fname'] : null; // ตรวจสอบ fname
    $lname = isset($_POST['lname']) ? $_POST['lname'] : null; // ตรวจสอบ lname

    if ($room_number === null || $fname === null || $lname === null) {
        echo "กรุณากรอกข้อมูลให้ครบถ้วน.";
        exit;
    }

    // สร้างคำสั่ง SQL ด้วยการเตรียมคำสั่ง
    $stmt = $conn->prepare("INSERT INTO room_info (room_number, fname, lname) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $room_number, $fname, $lname); // "sss" หมายถึงสามตัวแปรประเภท string

    // รันคำสั่ง SQL
    if ($stmt->execute()) {
        echo "บันทึกข้อมูลเรียบร้อย";
    } else {
        echo "เกิดข้อผิดพลาด: " . $stmt->error;
    }

    // ปิดคำสั่ง
    $stmt->close();
}
