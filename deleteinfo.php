<?php
require 'dbconnection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $room_number = $_POST['room_number'];

    // ลบข้อมูลจากตาราง room_info
    $delete_sql = "DELETE FROM room_info WHERE room_number = ?";
    $stmt = $conn->prepare($delete_sql);
    $stmt->bind_param("s", $room_number);

    if ($stmt->execute()) {
        // เปลี่ยนสถานะห้องในตาราง rooms
        $update_status_sql = "UPDATE rooms SET status = 'available' WHERE room_number = ?";
        $update_stmt = $conn->prepare($update_status_sql);
        $update_stmt->bind_param("s", $room_number);
        $update_stmt->execute();

        // เปลี่ยนเส้นทางกลับไปยังหน้า index.php
        header("Location: index.php?message=ลบข้อมูลเรียบร้อยแล้ว");
        exit();
    } else {
        echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการลบข้อมูล: " . $stmt->error . "</div>";
    }

    // ปิดการเชื่อมต่อ
    $stmt->close();
}
$conn->close();
