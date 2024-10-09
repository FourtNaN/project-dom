<?php

require "/Users/User/Desktop/XAMPP/htdocs/dbconnection.php";



$room_number = $_POST['room_number'];
$problem_description = $_POST['problem_description'];
$report_date = $_POST['report_date'];
$estimated_resolution_date = $_POST['estimated_resolution_date'];
$notes = $_POST['notes'];
$status = $_POST['status'];


$sql = "UPDATE reported_issues  SET problem_description = '$problem_description', report_date = '$report_date', estimated_resolution_date = '$estimated_resolution_date', notes = '$notes', status = '$status' 
WHERE room_number = '$room_number'";

if ($conn->query($sql) === TRUE) {
    header("Location: problemTable.php?message=update_success");
    exit();
} else {
    echo "เกิดข้อผิดพลาด: " . $conn->error;
}

$conn->close();
