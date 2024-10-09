<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require 'dbconnection.php';

header('Content-Type: application/json');

$query = "SELECT DATE_FORMAT(billing_date, '%Y-%m') AS month, 
                 SUM(electricity_total + water_total + IFNULL(other_charges, 0)) AS total_billing
          FROM billing_info
          GROUP BY month
          ORDER BY month";

$result = $mysqli->query($query);

if (!$result) {
    echo json_encode(['error' => $mysqli->error]);
    exit;
}

$months = [];
$totalBillings = [];

while ($row = $result->fetch_assoc()) {
    $months[] = $row['month'];
    $totalBillings[] = (float)$row['total_billing'];
}

echo json_encode(['months' => $months, 'totalBillings' => $totalBillings]);

$mysqli->close();
