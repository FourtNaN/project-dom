<?php
require 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $id_card_number = $_POST['id_card_number'];
    $phone_number = $_POST['phone_number'];

    $update_sql = "UPDATE room_info SET fname = '$fname', lname = '$lname', id_card_number = '$id_card_number', phone_number = '$phone_number'";

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        $image = file_get_contents($_FILES['image']['tmp_name']);
        $image = $conn->real_escape_string($image);
        $update_sql .= ", image = '$image'";
    }

    $update_sql .= " WHERE room_number = '$room_number'";



    if ($conn->query($update_sql) === TRUE) {
        header("Location: Roominfo.php?room_number=$room_number&message=update_success");
        exit();
    } else {
        echo "<div class='alert alert-danger'>เกิดข้อผิดพลาด: " . $conn->error . "</div>";
    }
} else {
    echo "ไม่พบข้อมูลที่ส่งมาจากฟอร์ม";
}

$conn->close();
