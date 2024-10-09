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
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables JS -->
    <script type="text/javascript" charset="utf8" src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.js"></script>
    <style>
        table.dataTable thead th {
            background-color: #84bfcd;
            color: #3d73af;
            text-align: center;
            padding: 10px;
            font-size: 1em;
        }


        table.dataTable tbody td {
            padding: 8px;
            text-align: center;
        }


        table.dataTable {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            font-size: 1em;
            border: 1px solid #ddd;
        }


        table.dataTable tbody tr:hover {
            background-color: rgba(143, 204, 216, 0.3);
        }


        .dataTables_filter input {
            border: 2px solid #4CAF50;
            padding: 5px;
            border-radius: 4px;
        }


        .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin-left: 5px;
            background-color: #84bfcd;
            color: white !important;
            border-radius: 4px;
            text-decoration: none;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #45a049;
        }


        table.dataTable tbody tr {
            height: 50px;
        }


        .status-paid {
            background-color: #28a745;
            color: green;
            padding: 5px 10px;
            border-radius: 4px;
        }

        .status-unpaid {
            background-color: #dc3545;
            color: red;
            padding: 5px 10px;
            border-radius: 4px;
        }
    </style>
</head>
</head>

<body class="p-0">
    <section class="row">
        <?php include("aside.php"); ?>
        <main class="col-9 col-xl-10 bg-white border border-5">

            <div class="bg-white mb-5">
                <div class="d-flex justify-content-between align-items-start mt-3">

                    <a href="/billinfoTable.php" class="btn d-flex align-items-center fw-medium text-decoration-none w-25 mt-2" style="width: 150px;">
                        <span class="material-symbols-outlined">arrow_back_ios</span>
                        บิลรายเดือน
                    </a>


                    <a href="/problemTable.php" class="btn d-flex align-items-center fw-medium text-decoration-none gap-10 mt-2" style="width: 150px;">

                        ตารางแจ้งปัญหา
                        <span class="material-symbols-outlined">arrow_forward_ios</span>
                    </a>
                </div>
                <h1 class="prompt-bold text-custom-1 text-center">บิลห้อง</h1>
                <?php
                $sql =  "SELECT * FROM `billing_info` ";
                $result = mysqli_query($conn, $sql);


                ?>

                <table id="billingTable" class="display">
                    <thead>
                        <tr>
                            <th class="border">ค่าไฟ</th>
                            <th class="border">ค่าน้ำ</th>
                            <th class="border">ค่าอื่นๆ</th>
                            <th class="border">วันที่ลงบิล</th>
                            <th class="border">หมายเหตุ</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr>
                                <td class="border"><?php echo $row["electricity_total"] ?></td>
                                <td class="border"><?php echo $row["water_total"] ?></td>
                                <td class="border"><?php echo $row["other_charges"] ?></td>
                                <td class="border"><?php echo $row["billing_date"] ?></td>
                                <td class="border"><?php echo $row["notes"] ?></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                </table>

                <script>
                    $(document).ready(function() {
                        $('#billingTable').DataTable({
                            "pageLength": 10, // กำหนดให้แสดง 10 แถวต่อหน้า
                            "language": {
                                "search": "ค้นหา:", // เปลี่ยนข้อความค้นหาเป็นภาษาไทย
                                "lengthMenu": "แสดง _MENU_ แถวต่อหน้า",
                                "info": "แสดง _START_ ถึง _END_ จาก _TOTAL_ แถว",
                                "paginate": {
                                    "first": "หน้าแรก",
                                    "last": "หน้าสุดท้าย",
                                    "next": "ถัดไป",
                                    "previous": "ก่อนหน้า"
                                }
                            }
                        });
                    });

                    function goToEditPage(roomNumber) {
                        // เปลี่ยน URL ไปยังหน้าที่ต้องการ
                        window.location.href = 'roombill.php?room_number=' + roomNumber;
                    }
                </script>
            </div>
            <?php include 'footer.php' ?>
        </main>
    </section>