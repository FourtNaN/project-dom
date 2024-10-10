<?php
require 'dbconnection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $room_number = $_POST['room_number'];
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $id_card_number = $_POST['id_card_number'];
    $phone_number = $_POST['phone_number'];
    $address_add = $_POST['address_add'];

    $update_sql = "UPDATE room_info SET fname = '$fname', lname = '$lname', id_card_number = '$id_card_number', phone_number = '$phone_number' ,address_add = '$address_add'";

    if (isset($_FILES['contract']) && $_FILES['contract']['error'] === UPLOAD_ERR_OK) {
        $contract = file_get_contents($_FILES['contract']['tmp_name']);
        $contract = $conn->real_escape_string($contract);
        $update_sql .= ", contract = '$contract'";
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
