<?php
require 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // รับค่าจากฟอร์ม
    $billing_date = $_POST['billing_date'];
    $electricity_total = $_POST['electricity_total'];
    $water_total = $_POST['water_total'];
    $other_charges = $_POST['other_charges'];
    $notes = $_POST['notes'];

    // ตรวจสอบว่าข้อมูลค่าไฟ ค่าน้ำ หรือค่าอื่นๆ ถูกส่งมาหรือไม่
    if (!empty($billing_date) && isset($electricity_total) && isset($water_total)) {
        // อัปเดตข้อมูลในฐานข้อมูล
        $sql = "UPDATE billing_info 
                SET electricity_total = ?, water_total = ?, other_charges = ?, notes = ?
                WHERE billing_date = ?";

        // เตรียม statement เพื่อป้องกัน SQL injection
        $stmt = $conn->prepare($sql);
        $stmt->bind_param('ddsss', $electricity_total, $water_total, $other_charges, $notes, $billing_date);

        if ($stmt->execute()) {
            // สำเร็จ: เปลี่ยนเส้นทางไปยังหน้าอื่น เช่น ตารางข้อมูล
            header("Location: monthlybilltable.php?status=success");
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "กรุณากรอกข้อมูลที่จำเป็น";
    }

    $stmt->close();
}
$conn->close();
