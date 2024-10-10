<?php require 'dbconnection.php';
?>
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
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: auto;
            background-color: #fff;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        h2 {
            text-align: center;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .submit-btn {
            display: inline-block;
            width: 100%;
            padding: 10px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        .submit-btn:hover {
            background-color: #218838;
        }
    </style>
</head>

<body class="p-0">
    <section class="row">
        <?php include("aside.php"); ?>
        <main class="col-9 col-xl-10 border border-5 bg-white">
            <?php
            $room_number = $_GET['room_number'] ?? ''; // รับหมายเลขห้องจาก URL
            if ($room_number) {
                // ดึงข้อมูลบิลจากฐานข้อมูล
                $sql = "SELECT * FROM bill WHERE room_number = '$room_number'";
                $result = $conn->query($sql);

                // ตรวจสอบว่ามีข้อมูลหรือไม่
                if ($result->num_rows > 0) {
                    $bill = $result->fetch_assoc();
                } else {
                    echo "ไม่พบข้อมูลบิลสำหรับหมายเลขห้องนี้";
                }
            } else {
                echo "ไม่มีหมายเลขห้องที่ระบุ";
            } ?>
            <div class="form-container mb-5">
                <h1 class="prompt-bold text-custom-1 text-center">แก้ไขบิลห้อง</h1>
                <form action="updateroombill.php" method="POST">
                    <input type="hidden" name="id" value="<?php echo $bill['id']; ?>">

                    <label for="room_number">หมายเลขห้อง :</label>
                    <input type="text" id="room_number" name="room_number" value="<?php echo $bill['room_number']; ?>" required readonly>

                    <label for="electricity_cost">ค่าไฟฟ้า (บาท) :</label>
                    <input type="number" step="0.01" id="electricity_cost" name="electricity_cost" value="<?php echo $bill['electricity_cost']; ?>" required>

                    <label for="water_cost">ค่าน้ำ (บาท) :</label>
                    <input type="number" step="0.01" id="water_cost" name="water_cost" value="<?php echo $bill['water_cost']; ?>" required>

                    <label for="furniture_cost">ค่าเฟอร์นิเจอร์ (บาท) :</label>
                    <input type="number" step="0.01" id="furniture_cost" name="furniture_cost" value="<?php echo $bill['furniture_cost']; ?>" required>

                    <label for="room_cost">ค่าเช่าห้อง (บาท) :</label>
                    <input type="number" step="0.01" id="room_cost" name="room_cost" value="<?php echo $bill['room_cost']; ?>" required>

                    <label for="other_cost">ค่าใช้จ่ายอื่นๆ (บาท) :</label>
                    <input type="number" step="0.01" id="other_cost" name="other_cost" value="<?php echo $bill['other_cost']; ?>" required>

                    <label for="bill_date">วันที่ออกบิล</label>
                    <input type="date" id="bill_date" name="bill_date" required value="<?php echo $bill['bill_date']; ?>">

                    <div class="d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn btn-success">อัปเดตข้อมูล</button>
                    </div>
                </form>
            </div>


            <?php include 'footer.php' ?>
        </main>
    </section>