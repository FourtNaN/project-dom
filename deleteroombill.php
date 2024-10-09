<?php require 'dbconnection.php'; ?>

<?php
if (isset($_GET['room_number'])) {
    // รับ room_number ที่ส่งมาจาก URL
    $room_number = $_GET['room_number'];

    // ลบข้อมูลจากฐานข้อมูลตาม room_number
    $sql = "DELETE FROM bill WHERE room_number='$room_number'";

    if ($conn->query($sql) === TRUE) {
        echo "ลบข้อมูลเรียบร้อยแล้ว";
        // เปลี่ยนเส้นทางไปยัง roombill.php
        header("Location: roombill.php?room_number=$room_number");
        exit;
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    echo "ไม่พบหมายเลขห้องที่จะลบ";
}

$conn->close();
?>
