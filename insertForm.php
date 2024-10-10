<?php require 'dbconnection.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Muplace</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
</head>

<body class="p-0">
    <section class="row">
        <?php include("aside.php"); ?>
        <main class="col-9 col-xl-10 bg-white border border-5">
            <?php
            $today = date('Y-m-d');
            $room_number_from_url = isset($_GET['room_number']) ? $_GET['room_number'] : '';
            if ($_SERVER['REQUEST_METHOD'] === 'POST') {
                $fname = $_POST['fname'];
                $lname = $_POST['lname'];
                $id_card_number = $_POST['id_card_number'];
                $room_number = $_POST['room_number'];
                $phone_number = $_POST['phone_number'];
                $address_add = $_POST['address_add'];
                $start_date = $_POST['start_date'];

                if (isset($_FILES['contract']) && $_FILES['contract']['error'] === UPLOAD_ERR_OK) {
                    $contract = file_get_contents($_FILES['contract']['tmp_name']);
                    $stmt = $conn->prepare("INSERT INTO room_info (room_number, fname, lname, id_card_number, phone_number, address_add, contract, start_date) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
                    $stmt->bind_param("ssssssss", $room_number, $fname, $lname, $id_card_number, $phone_number, $address_add, $contract, $start_date);


                    if ($stmt->execute()) {
                        $update_status_sql = "UPDATE rooms SET status = 'unavailable' WHERE room_number = '$room_number'";
                        if ($conn->query($update_status_sql) === TRUE) {
                            echo "<div class='alert alert-success'>บันทึกข้อมูลเรียบร้อยแล้ว และสถานะของห้องถูกเปลี่ยนเป็น 'ห้องเต็ม'</div>";
                        } else {
                            echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการเปลี่ยนสถานะ: " . $conn->error . "</div>";
                        }
                    } else {
                        echo "<div class='alert alert-danger'>เกิดข้อผิดพลาด: " . $stmt->error . "</div>";
                    }
                } else {
                    echo "<div class='alert alert-danger'>กรุณาอัปโหลดรูปภาพ</div>";
                }
            }

            ?>
            <div class="form-container mb-5 mt-3">
                <h1 class="prompt-bold text-custom-1 text-center">แบบฟอร์มบันทึกข้อมูลห้อง</h1>
                <form action="insertForm.php" method="POST" enctype="multipart/form-data">
                    <div class="mb-3">
                        <label for="fname" class="form-label">ชื่อ</label>
                        <input type="text" name="fname" id="fname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="lname" class="form-label">นามสกุล</label>
                        <input type="text" name="lname" id="lname" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_card_number" class="form-label">เลขบัตรประชาชน</label>
                        <input type="text" name="id_card_number" id="id_card_number" class="form-control" maxlength="13" required>
                    </div>
                    <div class="mb-3">
                        <label for="phone_number" class="form-label">เบอร์โทรศัพท์</label>
                        <input type="tel" name="phone_number" id="phone_number" class="form-control" maxlength="10" required>
                    </div>
                    <div class="mb-3">
                        <label for="start_date" class="form-label">วันที่เริ่มเช่า</label>
                        <input type="date" name="start_date" id="start_date" class="form-control" required value="<?php echo $today; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="room_number" class="form-label">เลขห้อง</label>
                        <select name="room_number" id="room_number" class="form-select" required>
                            <option value="">เลือกเลขห้อง</option>
                            <?php
                            $room_sql = "SELECT room_number FROM rooms WHERE status NOT IN ('unavailable', 'booked')";
                            $room_result = $conn->query($room_sql);
                            if ($room_result->num_rows > 0) {
                                while ($room_row = $room_result->fetch_assoc()) {
                                    $selected = ($room_row['room_number'] == $room_number_from_url) ? 'selected' : '';
                                    echo "<option class='text-center' value='" . $room_row['room_number'] . "' $selected>" . $room_row['room_number'] . "</option>";
                                }
                            } else {
                                echo "<option value=''>ไม่มีห้องว่าง</option>";
                            }
                            ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">ที่อยู่</label>
                        <input type="text" name="address_add" id="address_add" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label for="contract" class="form-label">เอกสารสัญญา</label>
                        <input type="file" name="contract" id="contract" class="form-control" accept="image/*">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">หมายเหตุ</label>
                        <textarea name="notes" id="notes" class="form-control"></textarea>
                    </div>
                    <div class="d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn btn-success">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
            <?php include 'footer.php' ?>
        </main>
    </section>
</body>

</html>