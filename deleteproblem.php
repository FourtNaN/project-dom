<?php
require 'dbconnection.php';
$room_number = $_GET["room_number"];
$sql = "DELETE FROM reported_issues WHERE room_number=$room_number";

$result = mysqli_query($conn, $sql);
if ($conn->query($sql) === TRUE) {
    header("Location: problemTable.php?message=update_success");
    exit(); // จบการทำงานของสคริปต์
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}
