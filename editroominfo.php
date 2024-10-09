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
            <div class="form-container">
                <h2>แก้ไขข้อมูลห้อง</h2>
                <?php

                if (isset($_GET['room_number'])) {
                    $room_number = $_GET['room_number'];

                    $sql = "SELECT * FROM room_info WHERE room_number = '$room_number'";
                    $result = $conn->query($sql);

                    if ($result === false) {
                        echo "Error in query: " . $conn->error;
                    }
                    if ($result->num_rows > 0) {

                        $row = $result->fetch_assoc();

                ?>
                        <form action="/updateinfo.php" method="POST" class="mb-3" enctype="multipart/form-data">
                            <div class="mb-3">
                                <label for="room_number" class="form-label">เลขห้อง</label>
                                <input type="text" name="room_number" id="room_number" class="form-control" value="<?php echo $row['room_number']; ?>" readonly>
                            </div>
                            <div class="mb-3">
                                <label for="fname" class="form-label">ชื่อ</label>
                                <input type="text" name="fname" id="fname" class="form-control" value="<?php echo $row['fname']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label for="lname" class="form-label">นามสกุล</label>
                                <input type="text" name="lname" id="lname" class="form-control" value="<?php echo $row['lname']; ?>" required>
                            </div>
                            <label for="phone_number" class="form-label">หมายเลขโทรศัพท์</label>
                            <input type="text" name="phone_number" id="phone_number" class="form-control" maxlength="10" required value="<?php echo $row['phone_number']; ?>">
                            <div class="mb-3">
                                <label for="id_card_number" class="form-label">เลขบัตรประชาชน</label>
                                <input type="text" name="id_card_number" id="id_card_number" class="form-control" value="<?php echo $row['id_card_number']; ?>" maxlength="13" required>
                            </div>
                            <div class="mb-3">
                                <label for="image" class="form-label">เอกสารสัญญา</label>
                                <input type="file" name="image" id="image" class="form-control" accept="image/*">
                            </div>
                            <div class="d-flex justify-content-end align-items-end mt-3">
                                <input type="submit" value="อัปเดตข้อมูล" class="btn btn-primary me-2 w-25">
                                <button type="button" class="btn btn-danger w-25" onclick="confirmDelete('<?php echo $row['room_number']; ?>') ">ลบข้อมูล</button>
                            </div>
                        </form>
                        <form id="deleteForm" action="/deleteinfo.php" method="POST" style="display:none;">
                            <input type="hidden" name="room_number" id="deleteRoomNumber">
                        </form>

                        <script>
                            function confirmDelete(roomNumber) {
                                if (confirm('คุณแน่ใจว่าจะลบข้อมูลนี้?')) {
                                    document.getElementById('deleteRoomNumber').value = roomNumber;
                                    document.getElementById('deleteForm').submit();
                                }
                            };
                        </script>

                <?php } else {
                        echo "ไม่พบข้อมูลที่ต้องการแก้ไข";
                    }
                } else {
                    echo "ไม่มี room_number ที่ระบุใน URL";
                }

                $conn->close();
                ?>
            </div>
        </main>
    </section>
</body>

</html>