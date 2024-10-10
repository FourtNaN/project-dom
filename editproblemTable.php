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
    <style>
        .border-custom {
            border: 1px solid #4e5d88;
            /* กำหนดสีของ border */
        }
    </style>
</head>

<body class="p-0">
    <section class="row">
        <?php include("aside.php"); ?>
        <main class="col-9 col-xl-10 bg-white border border-5">

            <?php

            if (isset($_GET['room_number'])) {
                $room_number = $_GET['room_number']; // รับค่า room_number จาก URL

                // ดึงข้อมูลจากฐานข้อมูลตาม room_number
                $sql = "SELECT * FROM reported_issues WHERE room_number = '$room_number'";
                $result = $conn->query($sql);

                if ($result === false) {
                    echo "Error in query: " . $conn->error; // แสดงข้อผิดพลาด
                }
                if ($result->num_rows > 0) {

                    $row = $result->fetch_assoc();

            ?>
                    <div class="form-container">
                        <a href="/problemTable.php" class="btn d-flex align-items-center fw-medium  text-decoration-none " style="width: 150px;"><span class="material-symbols-outlined ">arrow_back_ios</span>กลับหน้าแรก</a>

                        <h2 class="mt-3 mb-2">แจ้งปัญหา</h2>
                        <form action="/updateproblem.php" method="post">
                            <div class="mb-3">
                                <label for="room_number" class="form-label">เลขห้อง :</label>
                                <input type="text" readonly class="form-control-plaintext border border-custom " id="room_number" name="room_number" value="<?php echo $row["room_number"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="problem_description" class="form-label">ปัญหาที่พบ :</label>
                                <textarea class="form-control" id="problem_description" name="problem_description" rows="3"><?php echo htmlspecialchars($row['problem_description']); ?></textarea>
                            </div>
                            <div class=" mb-3">
                                <label for="report_date" class="form-label">วันที่รับเรื่อง :</label>
                                <input type="date" class="form-control" id="report_date" name="report_date" value="<?php echo $row["report_date"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="estimated_resolution_date" class="form-label">วันที่คาดว่าจะดำเนินการ :</label>
                                <input type="date" class="form-control" id="estimated_resolution_date" name="estimated_resolution_date" value="<?php echo $row["estimated_resolution_date"] ?>">
                            </div>
                            <div class="mb-3">
                                <label for="notes" class="form-label">หมายเหตุ :</label>
                                <textarea class="form-control" id="notes" name="notes" rows="2"><?php echo htmlspecialchars($row['notes']); ?></textarea>
                            </div>
                            <label for="status">สถานะ:</label>
                            <select name="status" class="mb-4" required>
                                <option value="ยังไม่ดำเนินการ" <?= $row['status'] == 'ยังไม่ดำเนินการ' ? 'selected' : ''; ?>>ยังไม่ดำเนินการ</option>
                                <option value="กำลังดำเนินการ" <?= $row['status'] == 'กำลังดำเนินการ' ? 'selected' : ''; ?>>กำลังดำเนินการ</option>
                                <option value="เสร็จสิ้น" <?= $row['status'] == 'เสร็จสิ้น' ? 'selected' : ''; ?>>เสร็จสิ้น</option>
                            </select>
                            <div class="d-flex justify-content-end mt-3">
                                <button type="submit" class="btn btn-success me-2" style="width: 150px;">แก้ไขข้อมูล</button>
                                <a href="deleteproblem.php?room_number=<?php echo $row["room_number"] ?>" class="btn btn-danger" style="width: 150px;" onclick="return confirm('คุณต้องการลบข้อมูลหรือไม่')">ลบข้อมูล</a>
                            </div>
                        </form>
                    </div>

            <?php } else {
                    echo "ไม่พบข้อมูลที่ต้องการแก้ไข";
                }
            } else {
                echo "ไม่มี room_number ที่ระบุใน URL";
            }


            $conn->close();
            ?>
        </main>
    </section>