<?php require 'dbconnection.php'; ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // รับค่าจากฟอร์ม
    $id = $_POST['id'];
    $room_number = $_POST['room_number'];
    $electricity_cost = $_POST['electricity_cost'];
    $water_cost = $_POST['water_cost'];
    $furniture_cost = $_POST['furniture_cost'];
    $room_cost = $_POST['room_cost'];
    $other_cost = $_POST['other_cost'];
    $bill_date = $_POST['bill_date'];

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE bill SET 
        room_number='$room_number', 
        electricity_cost='$electricity_cost', 
        water_cost='$water_cost', 
        furniture_cost='$furniture_cost', 
        room_cost='$room_cost', 
        other_cost='$other_cost', 
        bill_date='$bill_date' 
    WHERE id='$id'";

    if ($conn->query($sql) === TRUE) {
        echo "อัปเดตข้อมูลเรียบร้อยแล้ว";
        header("Location: roombill.php?room_number=$room_number");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
