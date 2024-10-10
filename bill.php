<?php require 'dbconnection.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Muplace</title>
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
        crossorigin="anonymous" />
    <link rel="stylesheet" href="/style.css" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

</head>

<body class="p-0">
    <section class="row">
        <?php include("aside.php"); ?>
        <main class="col-9 col-xl-10 bg-white border border-5">

            <h1 class="prompt-bold text-custom-1 text-center my-3">บิลค่าห้อง</h1>

            <?php

            require 'dbconnection.php';
            $sql = "SELECT * FROM rooms ORDER BY floor, room_number";
            $result = $conn->query($sql);
            $total_costs = [];
            $sql_totals = "SELECT 
                                room_number,
                                SUM(electricity_cost) AS total_electricity,
                                SUM(water_cost) AS total_water,
                                SUM(furniture_cost) AS total_furniture,
                                SUM(room_cost) AS total_room,
                                SUM(other_cost) AS total_other,
                                (SUM(electricity_cost) + SUM(water_cost) + SUM(furniture_cost) + SUM(room_cost) + SUM(other_cost)) AS total_cost
                            FROM 
                                bill
                            GROUP BY 
                                room_number";

            $result_totals = $conn->query($sql_totals);
            if ($result_totals->num_rows > 0) {
                while ($row = $result_totals->fetch_assoc()) {
                    $total_costs[$row['room_number']] = $row['total_cost'];
                }
            }
            if ($result->num_rows > 0) {
                for ($floor = 1; $floor <= 8; $floor++) {
                    echo "<div class='floor-heading text-center'>";
                    echo "<h2 class='m-3 fs-1' style='color: #3d73af; font-weight: bold; display: inline-block; border-bottom: 3px solid #007BFF;'>ชั้นที่ " . $floor . "</h2>";
                    echo "</div>";
                    for ($room = 1; $room <= 23; $room++) {
                        $room_number = sprintf("%d%02d", $floor, $room);


                        $sql_bill = "SELECT payment_status FROM bill WHERE room_number = ?";
                        $stmt_bill = $conn->prepare($sql_bill);
                        $stmt_bill->bind_param("s", $room_number);
                        $stmt_bill->execute();
                        $result_bill = $stmt_bill->get_result();


                        $button_color = '';
                        if ($result_bill->num_rows > 0) {
                            $row_bill = $result_bill->fetch_assoc();
                            $payment_status = $row_bill['payment_status'];

                            if ($payment_status == 'จ่ายแล้ว') {
                                $button_color = 'green';
                            } elseif ($payment_status == 'จ่ายช้า') {
                                $button_color = 'yellow';
                            } elseif ($payment_status == 'ยังไม่ได้จ่าย') {
                                $button_color = 'red';
                            }
                        } else {

                            $button_color = 'custom-color-1';
                        }


                        echo '<a href="roombill.php?room_number=' . $room_number . '" class="room-button ' . $button_color . '">';
                        echo $room_number;
                        echo '<br>';
                        if (isset($total_costs[$room_number])) {
                            echo  number_format($total_costs[$room_number], 0);
                        } else {
                            echo "<br><br>";
                        }
                        echo '</a>';
                    }
                }
            } else {
                echo "ไม่พบข้อมูลห้องในฐานข้อมูล.";
            }
            ?>
        </main>
    </section>