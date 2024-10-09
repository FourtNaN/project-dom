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
        <main class="col-9 col-xl-10 border border-5 bg-white mb-lg-5">

            <?php
            $today = date('Y-m-d');
            if ($_SERVER["REQUEST_METHOD"] == "POST") {

                $room_number = $_POST['room_number'];
                $problem_description = $_POST['problem_description'];
                $report_date = $_POST['report_date'];
                $estimated_resolution_date = $_POST['estimated_resolution_date'];
                $notes = $_POST['notes'];


                $sql = "INSERT INTO reported_issues (room_number, problem_description, report_date, estimated_resolution_date, notes)
                        VALUES ('$room_number', '$problem_description', '$report_date', '$estimated_resolution_date', '$notes')";


                if ($conn->query($sql) === TRUE) {
                    echo '<div class="alert alert-success" role="alert">ปัญหาได้รับการบันทึกเรียบร้อยแล้ว!</div>';
                } else {
                    echo '<div class="alert alert-danger" role="alert">เกิดข้อผิดพลาด: ' . $conn->error . '</div>';
                }
            }


            $conn->close();
            ?>
            <div class="form-container mb-5 mt-5">

                <h1 class="prompt-bold text-custom-1 text-center">แจ้งปัญหา</h1>
                <form action="" method="post">
                    <div class="mb-3">
                        <label for="room_number" class="form-label">เลขห้อง :</label>
                        <input type="text" class="form-control" id="room_number" name="room_number" required>
                    </div>
                    <div class="mb-3">
                        <label for="problem_description" class="form-label">ปัญหาที่พบ :</label>
                        <textarea class="form-control" id="problem_description" name="problem_description" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="report_date" class="form-label">วันที่รับเรื่อง :</label>
                        <input type="date" class="form-control" id="report_date" name="report_date" required value="<?php echo $today; ?>">
                    </div>
                    <div class="mb-3">
                        <label for="estimated_resolution_date" class="form-label">วันที่คาดว่าจะดำเนินการ :</label>
                        <input type="date" class="form-control" id="estimated_resolution_date" name="estimated_resolution_date">
                    </div>
                    <div class="mb-3">
                        <label for="notes" class="form-label">หมายเหตุ :</label>
                        <textarea class="form-control" id="notes" name="notes" rows="2"></textarea>
                    </div>
                    <div class="d-flex justify-content-end align-items-end">
                        <button type="submit" class="btn btn-success ">บันทึกข้อมูล</button>
                    </div>
                </form>
            </div>

            <?php include 'footer.php' ?>

        </main>
    </section>