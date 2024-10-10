<?php
require 'dbconnection.php'; // เชื่อมต่อฐานข้อมูล

header('Content-Type: application/json');

// ตรวจสอบว่าตัวแปร $conn มีการกำหนดหรือไม่
if (!$conn) {
    echo json_encode(['error' => 'Database connection not established']);
    exit;
}

// คิวรีฐานข้อมูล
$query = "SELECT DATE_FORMAT(billing_date, '%Y-%m') AS month, 
                 SUM(electricity_total + water_total + IFNULL(other_charges, 0)) AS total_billing
          FROM billing_info
          GROUP BY month
          ORDER BY month";

$result = mysqli_query($conn, $query);

if (!$result) {
    echo json_encode(['error' => mysqli_error($conn)]);
    exit;
}

$months = [];
$totalBillings = [];

while ($row = mysqli_fetch_assoc($result)) {
    $months[] = $row['month'];
    $totalBillings[] = (float)$row['total_billing'];
}

echo json_encode(['months' => $months, 'totalBillings' => $totalBillings]);

mysqli_close($conn);
