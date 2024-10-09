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
        .form-container {
            background-color: #f8f9fa;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
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
    </style>
</head>

<body class="p-0">
    <section class="row">
        <?php include("aside.php"); ?>
        <main class="col-9 col-xl-10 bg-white border border-5 mb-5">
            <?php
            $today = date('Y-m-d');
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                $electricity_total = $_POST['electricity_total'];
                $water_total = $_POST['water_total'];
                $other_charges = $_POST['other_charges'];
                $billing_date = $_POST['billing_date'];
                $notes = $_POST['notes'];


                $sql = "INSERT INTO billing_info (electricity_total, water_total, other_charges, billing_date, notes)
                    VALUES ('$electricity_total', '$water_total', '$other_charges', '$billing_date', '$notes')";


                if ($conn->query($sql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">Data saved successfully!</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">Error: ' . $sql . '<br>' . $conn->error . '</div>';
                }
            }

            $conn->close();
            ?>
            <div class="form-container mb-5 mt-5">
                <h1 class="prompt-bold text-custom-1 text-center">กรอกข้อมูลบิล</h1>

                <form action="" method="POST">
                    <div class="mb-3">
                        <label for="billing_date" class="form-label">วันที่ใส่ข้อมูล</label>
                        <input type="date" class="form-control" id="billing_date" name="billing_date" required value="<?php echo $today; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="electricity_total" class="form-label">ค่าไฟรวม (บาท) :</label>
                        <input type="number" step="0.01" class="form-control" id="electricity_total" name="electricity_total" required>
                    </div>
                    <div class="mb-3">
                        <label for="water_total" class="form-label">ค่าน้ำรวม (บาท) :</label>
                        <input type="number" step="0.01" class="form-control" id="water_total" name="water_total" required>
                    </div>
                    <div class="mb-3">
                        <label for="other_charges" class="form-label">ค่าบริการอื่นๆ (บาท) :</label>
                        <input type="number" step="0.01" class="form-control" id="other_charges" name="other_charges" value="0">
                    </div>

                    <div class="mb-3">
                        <label for="notes" class="form-label">หมายเหตุ</label>
                        <textarea class="form-control" id="notes" name="notes"></textarea>
                    </div>
                    <div class="d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn btn-success ">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>
            <div class="mt-5">
                <?php include 'footer.php' ?>
            </div>
        </main>
    </section>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>