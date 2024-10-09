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
</head>

<body class="p-0">
    <section class="row">

        <?php include("aside.php"); ?>

        <main class="col-9 col-xl-10 bg-white border border-5">


            <?php

            $room_number = $_GET['room_number'];

            if (isset($_GET['message']) && $_GET['message'] == 'update_success') {
                echo '<div class="alert alert-success" role="alert"> แก้ไขข้อมูลเรียบร้อยแล้ว !! </div>';
            }
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $status = $_POST['status'];


                $update_sql = "UPDATE rooms SET status = '$status' WHERE room_number = '$room_number'";
                if ($conn->query($update_sql) === TRUE) { ?>

                    <div id="myAlert" class='alert alert-success text-center'>!!! อัปเดตสถานะเรียบร้อยแล้ว !!!</div>

                <?php
                } else {
                    echo "<div id='myAlert' class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปเดต: " . $conn->error . "</div>";
                }
            }
            $sql = "SELECT room_info.*, rooms.status, rooms.floor 
        FROM room_info 
        JOIN rooms ON room_info.room_number = rooms.room_number
        WHERE room_info.room_number = '$room_number'";

            $result = $conn->query($sql);


            if ($result->num_rows > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    $imageData = base64_encode($row['image']);
                ?><div class="bg-white border border-1">
                        <div class="d-flex justify-content-center p-5">
                            <h1 class="text-custom-5 text-center custom-font-size-head">ห้อง <?php echo $row['room_number']; ?></h1>
                        </div>
                        <div>
                            <div class="prompt-semibold mx-5 p-5 fs-5 text-decoration-underline">ข้อมูลผู้เช่า</div>
                        </div>
                        <div class="mx-5 p-1">

                            <p class="mx-5 p-1 text-custom-1 fs-5">
                                <span class="fw-bold p-lg-5">ชื่อ :</span>
                                <span><?php echo $row['fname']; ?></span>
                            </p>
                        </div>
                        <div class="mx-5 p-1">
                            <p class="mx-5 p-1 text-custom-1 fs-5">
                                <span class="fw-bold p-lg-5">นามสกุล :</span>
                                <span><?php echo $row['lname']; ?></span>
                            </p>
                        </div>
                        <div class="mx-5 p-1">
                            <p class="mx-5 p-1 text-custom-1 fs-5">
                                <span class="fw-bold p-lg-5">เบอร์โทรศัพท์ :</span>
                                <span><?php echo $row['phone_number']; ?></span>
                            </p>
                        </div>

                        <div class="mx-5 p-1">
                            <p class="mx-5 p-1 text-custom-1 fs-5">
                                <span class="fw-bold p-lg-5">เลขบัตรประจำตัวประชาชน :</span>
                                <span><?php echo $row['id_card_number']; ?></span>
                            </p>
                        </div>
                        <div class="mx-5 p-1">
                            <p class="mx-5 p-1 text-custom-1 fs-5">
                                <span class="fw-bold p-lg-5">วันที่เริ่มเข้า :</span>
                                <span><?php echo $row['start_date']; ?></span>
                            </p>
                        </div>
                        <div class="mb-3">
                            <p class="mx-5 p-1 text-custom-1 fs-5">
                                <span class="fw-bold p-lg-5">สัญญาการเข้าพัก :</span>
                                <img src="data:image/jpeg;base64,<?php echo $imageData; ?>" alt="Room Image" style="max-width: 100%; height: auto;" />
                        </div>
                        <div class="mx-5 p-1">
                            <p class="mx-5 p-1 text-custom-1 fs-5">
                                <span class="fw-bold p-lg-5">หมายเหตุ :</span>
                                <span><?php echo $row['notes']; ?></span>
                            </p>
                        </div>
                        <div>
                            <div class="prompt-semibold mx-5 p-5 fs-5 text-decoration-underline">ข้อมูลห้อง</div>
                        </div>
                        <div>
                            <div class="mx-5 p-1 d-flex align-items-center justify-content-between">

                                <p class="mx-5 p-1 text-custom-1 fs-5">
                                    <span class="fw-bold p-lg-5">ห้อง :</span>
                                    <span><?php echo $row['room_number'] ?></span>
                                </p>
                                <p class="mx-5 p-1 text-custom-1 fs-5">
                                    <span class="fw-bold p-lg-5">ชั้น :</span>
                                    <span><?php echo $row['floor'] ?></span>
                                </p>
                                <p class="mx-5 p-1 text-custom-1 fs-5">
                                    <span class="fw-bold p-lg-5">สถานะของห้อง :</span>
                                    <span>
                                        <?php

                                        switch ($row['status']) {
                                            case 'available':
                                                $btnClass = 'btn btn-success';
                                                $btnText = 'ห้องว่าง';
                                                break;
                                            case 'booked':
                                                $btnClass = 'btn btn-warning';
                                                $btnText = 'ห้องจองแล้ว';
                                                break;
                                            case 'unavailable':
                                                $btnClass = 'btn btn-danger';
                                                $btnText = 'ห้องไม่ว่าง';
                                                break;
                                            default:
                                                $btnClass = 'btn btn-secondary';
                                                $btnText = 'สถานะไม่ทราบ';
                                                break;
                                        } ?>
                                        <span class="<?php echo $btnClass; ?>" style="pointer-events: none;"><?php echo $btnText; ?></span>
                                    </span>
                                </p>
                            </div>
                        </div>
                        <form method="post" style="position: absolute; top: 10px; right: 10px; width: 150px;" id="statusForm">
                            <label for="status" class="form-label text-center">สถานะของห้อง</label>
                            <select name="status" id="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                <option value="available" <?php if ($row['status'] == 'available') echo 'selected'; ?>>ห้องว่าง</option>
                                <option value="booked" <?php if ($row['status'] == 'booked') echo 'selected'; ?>>ห้องถูกจอง</option>
                                <option value="unavailable" <?php if ($row['status'] == 'unavailable') echo 'selected'; ?>>ห้องเต็ม</option>
                            </select>
                        </form>
                        <div class="d-flex justify-content-end">
                            <a href='editroominfo.php?room_number=<?php echo $row['room_number']; ?>' class='btn btn-warning m-5'>แก้ไขข้อมูล</a>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class=" alert alert-danger text-center mt-3" role="alert">
                    ! ! ! ไม่มีข้อมูลห้อง ! ! !
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
                <div class="w-100 ml-5 mt-5 pt-5 p-3">
                    <a href="insertForm.php?room_number=<?php echo $room_number; ?>" class="btn btn-danger mt-5 mb-5 ml-5 w-100 p-4">กรอกข้อมูลสำหรับห้อง <?php echo $room_number; ?></a>
                </div>
                <br>
                <br>
                <br>
                <br>
                <br>
                <br>
            <?php } ?>

            <?php $conn->close();
            include 'footer.php' ?>
            <script>
                setTimeout(function() {
                    var alert = document.getElementById('myAlert');
                    alert.style.transition = "transform 1s ease, opacity 1s ease";
                    alert.style.transform = "translateY(-20px)";
                    alert.style.opacity = '0';


                    setTimeout(function() {
                        alert.remove();
                    }, 1000);
                }, 2000);
            </script>

        </main>
    </section>
</body>