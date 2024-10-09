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
        /* ตกแต่งหัวตาราง */
        table.dataTable thead th {
            background-color: #84bfcd;
            color: #3d73af;
            text-align: center;
            padding: 10px;
            font-size: 1em;
        }

        /* ตกแต่งแถว */
        table.dataTable tbody td {
            padding: 8px;
            text-align: center;
        }

        /* ตกแต่งเส้นขอบ */
        table.dataTable {
            border-collapse: collapse;
            width: 100%;
            margin: 20px 0;
            font-size: 1em;
            border: 1px solid #ddd;
        }

        /* เปลี่ยนสีแถวเมื่อวางเมาส์ */
        table.dataTable tbody tr:hover {
            background-color: rgba(143, 204, 216, 0.3);
        }

        /* ตกแต่งแถบค้นหา */
        .dataTables_filter input {
            border: 2px solid #4CAF50;
            padding: 5px;
            border-radius: 4px;
        }

        /* ปุ่มแบ่งหน้า */
        .dataTables_paginate .paginate_button {
            padding: 6px 12px;
            margin-left: 5px;
            background-color: #8fccd8;
            color: white !important;
            border-radius: 4px;
            text-decoration: none;
        }

        .dataTables_paginate .paginate_button:hover {
            background-color: #45a049;
        }

        /* กำหนดขนาดแถว */
        table.dataTable tbody tr {
            height: 50px;
        }

        /* ตกแต่งสถานะจ่ายเงิน */
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

        th.problems {
            width: 30%;
            /* กว้างสำหรับคอลัมน์ที่ต้องการขนาดใหญ่ */
        }

        th.done {
            width: 10%;
            /* กว้างสำหรับคอลัมน์ที่ต้องการขนาดใหญ่ */
        }
    </style>
</head>
</head>

<body class="p-0">
    <section class="row">
        <?php include("aside.php"); ?>
        <main class="col-9 col-xl-10  border border-5 bg-white">
            <?php
            $sql =  "SELECT * FROM `rooms` ";
            $result = mysqli_query($conn, $sql);
            $row = mysqli_fetch_assoc($result);
            if (isset($_GET['message']) && $_GET['message'] == 'update_success') {
                echo '<div class="alert alert-success" role="alert"> แก้ไขข้อมูลเรียบร้อยแล้ว !! </div>
';
            }

            ?>

            <div class="bg-white mb-5">
                <br>

                <div class="d-flex justify-content-between align-items-start ">
                    <!-- ปุ่มซ้ายบน -->
                    <a href="/billinfoTable.php" class="btn d-flex align-items-center fw-medium text-decoration-none w-25 mt-3" style="width: 150px;">
                        <span class="material-symbols-outlined">arrow_back_ios</span>
                        ตารางการจ่ายเงิน
                    </a>

                    <!-- ปุ่มขวาบน -->
                    <a href="/problemTable.php" class="btn d-flex align-items-center fw-medium text-decoration-none gap-10" style="width: 150px;">

                        ตารางแจ้งปัญหา
                        <span class="material-symbols-outlined">arrow_forward_ios</span>
                    </a>
                </div>

                <h1 class="prompt-bold text-custom-1 text-center">ห้องพัก</h1>
                <!-- สร้างตาราง -->
                <table id="billingTable" class="display ">
                    <thead>
                        <tr>
                            <th class="border">ห้อง</th>
                            <th class="problems border">ชั้น</th>
                            <th class="border">สถานะห้อง</th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                            <tr onclick="goToEditPage('<?= htmlspecialchars($row['room_number']); ?>')">
                                <td class="border"><?php echo $row["room_number"] ?></td>
                                <td class="border"><?php echo $row["floor"] ?></td>
                                <td class="border">
                                    <?php
                                    $statusClass = '';
                                    switch ($row['status']) {
                                        case 'available':
                                            $statusClass = 'btn btn-success  ';
                                            $style = 'style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"';
                                            break;
                                        case 'unavailable':
                                            $statusClass = 'btn btn-danger ';
                                            $style = 'style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem;"';
                                            break;
                                        case 'booked':
                                            $statusClass = 'btn btn-warning text-white';
                                            $style = 'style="--bs-btn-padding-y: .25rem; --bs-btn-padding-x: .5rem; --bs-btn-font-size: .75rem; "';
                                            break;
                                    }
                                    ?>
                                    <button class="<?= $statusClass ?>" style="width: 150px;" <?= $style ?> disabled>
                                        <?php echo $row["status"]; ?>
                                    </button>
                                </td>
                            </tr>
                        <?php } ?>

                    </tbody>
                </table>
                <br>

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
                        window.location.href = 'RoomInfo.php?room_number=' + roomNumber;
                    }
                </script>
            </div>
            <?php include 'footer.php' ?>
        </main>
    </section>