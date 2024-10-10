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
        <main class="col-9 col-xl-10 border border-5 bg-white">

            <div class="container mt-5">
                <h1 class="prompt-bold text-custom-1 text-center">กรอกเลขห้องเพื่อพิมพ์บิลค่าห้อง</h1>

                <form action="/Invoice.php" method="POST">
                    <div class="mb-3">
                        <label for="room_number_1" class="form-label">เลขห้องที่ 1</label>
                        <input type="text" class="form-control" id="room_number_1" name="room_number_1" required>
                    </div>
                    <div class="mb-3">
                        <label for="room_number_2" class="form-label">เลขห้องที่ 2</label>
                        <input type="text" class="form-control" id="room_number_2" name="room_number_2" required>
                    </div>
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">ส่งข้อมูล</button>
                    </div>

                </form>
            </div>
        </main>
    </section>