<?php
$room_number1 = $_GET['room_number1'] ?? '';
$room_number2 = $_GET['room_number2'] ?? '';
?>

<!DOCTYPE html>
<html lang="th">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ใบแจ้งหนี้</title>
    <style>
        * {
            margin: 1px;
            padding: 1px;
            box-sizing: border-box;
        }

        @media print {
            @page {
                size: A4;
                margin: 0;
            }

            .print-button {
                display: none;

                /* ซ่อนปุ่มในโหมดพิมพ์ */
                body {
                    margin: 20mm;
                }
            }
        }

        .invoice {
            width: 100%;
            max-width: 210mm;
            margin: auto;
            padding: 20px;
            font-size: 7px;
        }

        .dashed-line {
            border-top: 2px dashed #000;
            margin: 20px 0;
        }

        img {
            width: 300px;
            height: 25px;
        }

        /* ตาราง */
        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            border-left: none;
            border-right: none;
            padding: 8px;
        }

        .table th {
            text-align: center;
            /* จัดให้อยู่กลางสำหรับทุก th */
        }

        .table th:nth-child(2) {
            width: 200px;
        }

        .table th:nth-child(3) {
            text-align: left;
            /* จัดให้ชิดซ้ายสำหรับ th ที่สาม */
        }

        .table td:nth-child(1) {
            text-align: center;
        }

        .table td:nth-child(2) {
            text-align: left;
        }

        .table td:nth-child(3),
        .table th:nth-child(3) {
            text-align: right;
        }

        .table thead {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
        }

        .table tfoot {
            border-top: 2px solid black;
            border-bottom: 2px solid black;
            text-align: right;
            font-weight: bold;
        }

        .table tfoot td {
            padding: 8px;
        }

        .table tr:last-child td {
            border-bottom: none;
        }

        .table th:nth-child(1) {
            width: 20%;
        }

        .table th:nth-child(2) {
            width: 50%;
        }

        .table th:nth-child(3) {
            width: 40%;
        }

        .table tbody tr td {
            border-bottom: none;
        }

        .table td {
            padding: 5px;
        }
    </style>

</head>

<body>
    <?php
    require 'dbconnection.php';
    $room_number_1 = $_POST['room_number_1'];
    $room_number_2 = $_POST['room_number_2'];

    $sql = "
    SELECT 
        ri.room_number,
        ri.fname,
        ri.lname,
        ri.id_card_number,
        ri.phone_number,
        ri.address_add,
        b.electricity_cost,
        b.water_cost,
        b.furniture_cost,
        b.room_cost,
        b.other_cost,
        b.bill_date
    FROM room_info ri
    LEFT JOIN bill b ON ri.room_number = b.room_number
    WHERE ri.room_number IN ('$room_number_1', '$room_number_2')
    ";

    $result = $conn->query($sql);

    $total_electricity_cost1 = 0;
    $total_water_cost1 = 0;
    $total_furniture_cost1 = 0;
    $total_room_cost1 = 0;
    $total_other_cost1 = 0;

    $total_electricity_cost2 = 0;
    $total_water_cost2 = 0;
    $total_furniture_cost2 = 0;
    $total_room_cost2 = 0;
    $total_other_cost2 = 0;
    ?>
    <div class="invoice">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">
            <?php if ($result->num_rows > 0) {
                $row1 = $result->fetch_assoc();
                $row2 = $result->fetch_assoc(); { ?>
                    <div>
                        <img src="/img/head.jpg" alt="">
                        <h4>เอ็มยูเพลส (MU place)</h4>
                        <p>หมู่ 3 ถนนศาลายา-นครชัยศรี ตำบลศาลายา อำเภอพุทธมณฑล จังหวัด นครปฐม 73170</p>
                        <h4>ลูกค้า (Customer)</h4>
                        <p><?php echo $row1['fname']; ?></p>
                        <p><?php echo $row1['lname'] ?></p>
                        <p><?php echo $row1['address_add'] ?></p>
                        <p>เลขประจำตัวผู้เสียภาษี : <?php echo $row1['id_card_number'] ?></p>
                        <p>โทร : <?php echo $row1['phone_number']; ?></p>
                    </div>
                    <div>
                        <h2>ใบแจ้งหนี้ (Invoice)</h2>
                        <p style="font-weight: bold; text-align: left;">ต้นฉบับ (Original)</p>
                        <p>วันที่ (Date)<?php echo $row1['bill_date'] ?></p>
                        <p>ห้อง (Room)<?php echo $row1['room_number'] ?></p>
                    </div>
        </div>
        <h3>รายละเอียดค่าใช้จ่าย</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ลำดับ (#)</th>
                    <th>รายการ (Description)</th>
                    <th>ราคา (Price)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $index = 1;
                ?>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าเช่าห้อง (Room rate) <?php echo $row1['room_number'];  ?> วันที่ <?php echo $row1['bill_date'] ?></td>
                    <td><?php echo $row1['room_cost'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าน้ำ (Water rate) วันที่ <?php echo $row1['bill_date'] ?></td>
                    <td><?php echo $row1['water_cost'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าไฟฟ้า (Electrical rate) วันที่ <?php echo $row1['bill_date'] ?></td>
                    <td><?php echo $row1['electricity_cost'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าเช่าเฟอร์นิเจอร์ (Furnuture rate)</td>
                    <td><?php echo $row1['furniture_cost'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าอื่นๆ (Other cost)</td>
                    <td><?php echo $row1['other_cost'] ?></td>
                </tr>
            </tbody>


            <tfoot>
                <tr>
                    <?php

                    $total_electricity_cost1 += $row1['electricity_cost'];
                    $total_water_cost1 += $row1['water_cost'];
                    $total_furniture_cost1 += $row1['furniture_cost'];
                    $total_room_cost1 += $row1['room_cost'];
                    $total_other_cost1 += $row1['other_cost'];

                    $total_amount1 = $total_room_cost1 + $total_water_cost1 + $total_electricity_cost1 + $total_furniture_cost1 + $total_other_cost1;
                    ?>
                    <th></th>
                    <th colspan="2">รวม</th>
                    <th><?php echo $total_amount1; ?> บาท</th>
                </tr>
            </tfoot>

        </table>
        <h3>หมายเหตุ (Note)</h3>
        <div style="margin-top: 30px; text-align: center;">
            <p>ลงชื่อ..............................................................ผู้วางบิล</p>
            <br>
            <p>(.....................................................)</p>
        </div>
        <h3>หมายเหตุ</h3>
        <i style="text-decoration: underline; color:red;"> - กรุณาชำระค่าที่พักไม่เกินวันที่ 5 ของเดือน กรณีเกินจะปรับวันละ 100บาท</i>
        <i> (Please pay your bill within the 5 of the month,otherwise you will be fined 100 B./day)</i>
        <p> - กรณีชำระเป็นเงินสดสามารถชำระได้ในเวลา 8:00น. ถึง 19:00น.</p>
        <p> - สัญญาเช่าห้องมีผลบังคับโดยอัตโนมัติต่อไปอีก 1ปี นับจากวันที่ครบกำหนดตามสัญญา หากไม่มีการแสดงเจตนาเป็นสัญลักษญ์อักษร ว่าจะ
            <i style="text-decoration: underline; color:red;">ยกเลิกสัญญานี้อย่างน้อย 1 เดือนก่อนครบกำหนดตามสัญญา</i>
        </p>
        <h3 style="text-decoration: underline;">บัญชีธนาคาร เอ็ม ยู เพลส</h3>
        <div style="display: flex; align-items: center; margin-bottom: 0px;">
            <h4 style="margin-right: 10px;">ธนาคาร:</h4>
            <p style="margin-right: 20px;">กรุงไทย สาขา ศาลายา 2</p>
            <h4 style="margin-right: 10px;">ชื่อบัญชี:</h4>
            <p style="margin-right: 20px;">เอ็มยูเพลส โดย นายพิชิต มากอ้น</p>
            <h4 style="margin-right: 10px;">เลขบัญชี:</h4>
            <p>981-9-92614-9</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 3px;">
            <h4 style="margin-right: 10px;">ธนาคาร:</h4>
            <p style="margin-right: 20px;">ไทยพาณิชย์ สาขา บางโพ</p>
            <h4 style="margin-right: 10px;">ชื่อบัญชี:</h4>
            <p style="margin-right: 20px;">เอ็มยูเพลส โดย นายพิชิต มากอ้น</p>
            <h4 style="margin-right: 10px;">เลขบัญชี:</h4>
            <p>116-212-387-1</p>
        </div>
        <span>* กรุณาส่งหลักฐานการโอนผ่าน แอปพลิเคชั่นไลน์ <span style="color: green;">(LINE)</span> LINE ID: muplace</span>


    </div>
    <div class="dashed-line"></div> <!-- เส้นแบ่ง -->
    <div class="invoice">
        <div style="display: flex; justify-content: space-between; align-items: flex-start;">

            <div>
                <img src="/img/head.jpg" alt="">
                <h4>เอ็มยูเพลส (MU place)</h4>
                <p>หมู่ 3 ถนนศาลายา-นครชัยศรี ตำบลศาลายา อำเภอพุทธมณฑล จังหวัด นครปฐม 73170</p>
                <h4>ลูกค้า (Customer)</h4>
                <p><?php echo $row2['fname']; ?></p>
                <p><?php echo $row2['lname'] ?></p>
                <p><?php echo $row1['address_add'] ?></p>
                <p>เลขประจำตัวผู้เสียภาษี : <?php echo $row2['id_card_number'] ?></p>
                <p>โทร : <?php echo $row2['phone_number']; ?></p>
            </div>
            <div>
                <h2>ใบแจ้งหนี้ (Invoice)</h2>
                <p style="font-weight: bold; text-align: left;">ต้นฉบับ (Original)</p>
                <p>วันที่ (Date)<?php echo $row2['bill_date'] ?></p>
                <p>ห้อง (Room)<?php echo $row2['room_number'] ?></p>
            </div>
        </div>
        <h3>รายละเอียดค่าใช้จ่าย</h3>
        <table class="table">
            <thead>
                <tr>
                    <th>ลำดับ (#)</th>
                    <th>รายการ (Description)</th>
                    <th>ราคา (Price)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                    $index = 1;
                ?>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าเช่าห้อง (Room rate) <?php echo $row2['room_number'];  ?> วันที่ <?php echo $row2['bill_date'] ?></td>
                    <td><?php echo $row2['room_cost'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าน้ำ (Water rate) วันที่ <?php echo $row2['bill_date'] ?></td>
                    <td><?php echo $row1['water_cost'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าไฟฟ้า (Electrical rate) วันที่ <?php echo $row2['bill_date'] ?></td>
                    <td><?php echo $row1['electricity_cost'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าเช่าเฟอร์นิเจอร์ (Furnuture rate)</td>
                    <td><?php echo $row2['furniture_cost'] ?></td>
                </tr>
                <tr>
                    <td><?php echo $index++; ?></td>
                    <td>ค่าอื่นๆ (Other cost)</td>
                    <td><?php echo $row2['other_cost'] ?></td>
                </tr>
            </tbody>


            <tfoot>
                <tr>
                    <?php

                    $total_electricity_cost2 += $row2['electricity_cost'];
                    $total_water_cost2 += $row2['water_cost'];
                    $total_furniture_cost2 += $row2['furniture_cost'];
                    $total_room_cost2 += $row2['room_cost'];
                    $total_other_cost2 += $row2['other_cost'];

                    $total_amount2 = $total_room_cost2 + $total_water_cost2 + $total_electricity_cost2 + $total_furniture_cost2 + $total_other_cost2;
                    ?>
                    <th></th>
                    <th colspan="2">รวม</th>
                    <th><?php echo $total_amount2; ?> บาท</th>
                </tr>
            </tfoot>

        </table>
        <h3>หมายเหตุ (Note)</h3>
        <div style="margin-top: 30px; text-align: center;">
            <p>ลงชื่อ..............................................................ผู้วางบิล</p>
            <br>
            <p>(.....................................................)</p>
        </div>


        <h3>หมายเหตุ</h3>
        <i style="text-decoration: underline; color:red;"> - กรุณาชำระค่าที่พักไม่เกินวันที่ 5 ของเดือน กรณีเกินจะปรับวันละ 100บาท</i>
        <i> (Please pay your bill within the 5 of the month,otherwise you will be fined 100 B./day)</i>
        <p> - กรณีชำระเป็นเงินสดสามารถชำระได้ในเวลา 8:00น. ถึง 19:00น.</p>
        <p> - สัญญาเช่าห้องมีผลบังคับโดยอัตโนมัติต่อไปอีก 1ปี นับจากวันที่ครบกำหนดตามสัญญา หากไม่มีการแสดงเจตนาเป็นสัญลักษญ์อักษร ว่าจะ
            <i style="text-decoration: underline; color:red;">ยกเลิกสัญญานี้อย่างน้อย 1 เดือนก่อนครบกำหนดตามสัญญา</i>
        </p>
        <h3 style="text-decoration: underline;">บัญชีธนาคาร เอ็ม ยู เพลส</h3>
        <div style="display: flex; align-items: center; margin-bottom: 0px;">
            <h4 style="margin-right: 10px;">ธนาคาร:</h4>
            <p style="margin-right: 20px;">กรุงไทย สาขา ศาลายา 2</p>
            <h4 style="margin-right: 10px;">ชื่อบัญชี:</h4>
            <p style="margin-right: 20px;">เอ็มยูเพลส โดย นายพิชิต มากอ้น</p>
            <h4 style="margin-right: 10px;">เลขบัญชี:</h4>
            <p>981-9-92614-9</p>
        </div>
        <div style="display: flex; align-items: center; margin-bottom: 3px;">
            <h4 style="margin-right: 10px;">ธนาคาร:</h4>
            <p style="margin-right: 20px;">ไทยพาณิชย์ สาขา บางโพ</p>
            <h4 style="margin-right: 10px;">ชื่อบัญชี:</h4>
            <p style="margin-right: 20px;">เอ็มยูเพลส โดย นายพิชิต มากอ้น</p>
            <h4 style="margin-right: 10px;">เลขบัญชี:</h4>
            <p>116-212-387-1</p>
        </div>
        <span>* กรุณาส่งหลักฐานการโอนผ่าน แอปพลิเคชั่นไลน์ <span style="color: green;">(LINE)</span> LINE ID: muplace</span>

<?php }
            } else {
                echo "ไม่พบข้อมูลห้องที่ระบุ";
            }
?>
    </div>

</body>
<button class="print-button" onclick="window.print()">พิมพ์บิล</button>

</html>