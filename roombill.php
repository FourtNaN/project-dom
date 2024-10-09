<?php require 'dbconnection.php'; ?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Muplace</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous" />
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap" rel="stylesheet">
</head>

<body class="p-0">
  <section class="row">
    <?php include("aside.php"); ?>
    <main class="col-9 col-xl-10 border border-5 bg-white d-flex flex-column">

      <?php
      // รับหมายเลขห้องจาก URL
      $room_number = $_GET['room_number'];

      // ตรวจสอบว่ามีข้อมูลบิลของห้องนี้
      $sql_check = "SELECT * FROM bill WHERE room_number = ?";
      $stmt_check = $conn->prepare($sql_check);
      $stmt_check->bind_param("s", $room_number);
      $stmt_check->execute();
      $result_check = $stmt_check->get_result();

      if ($result_check->num_rows > 0) {
        // แสดงผลรวมของค่าใช้จ่าย
        $sql_sum = "SELECT 
        COALESCE(SUM(electricity_cost), 0) AS total_electricity_cost,
        COALESCE(SUM(water_cost), 0) AS total_water_cost,
        COALESCE(SUM(furniture_cost), 0) AS total_furniture_cost,
        COALESCE(SUM(room_cost), 0) AS total_room_cost,
        COALESCE(SUM(other_cost), 0) AS total_other_cost
    FROM bill WHERE room_number = ?";

        $stmt_sum = $conn->prepare($sql_sum);
        $stmt_sum->bind_param("s", $room_number);
        $stmt_sum->execute();
        $result_sum = $stmt_sum->get_result();

        if ($result_sum->num_rows > 0) {
          $row = $result_sum->fetch_assoc();
          $total_electricity_cost = $row['total_electricity_cost'];
          $total_water_cost = $row['total_water_cost'];
          $total_furniture_cost = $row['total_furniture_cost'];
          $total_room_cost = $row['total_room_cost'];
          $total_other_cost = $row['total_other_cost'];

          // ประมวลผลการอัปเดตสถานะ
          if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['payment_status']) && !empty($_POST['payment_status'])) {
              $status = $_POST['payment_status']; // รับค่าจากฟอร์ม

              // อัปเดตสถานะห้องในฐานข้อมูล
              $update_sql = "UPDATE bill SET payment_status = ? WHERE room_number = ?";
              $stmt_update = $conn->prepare($update_sql);
              $stmt_update->bind_param("ss", $status, $room_number);

              if ($stmt_update->execute()) {
      ?>

                <div id="myAlert" class='alert alert-success text-center'>!!! อัปเดตสถานะเรียบร้อยแล้ว !!!</div>

          <?php
                // อัปเดตสถานะในตัวแปรเพื่อแสดงผลทันที
                $roww['payment_status'] = $status;
              } else {
                echo "<div class='alert alert-danger'>เกิดข้อผิดพลาดในการอัปเดต: " . $stmt_update->error . "</div>";
              }

              $stmt_update->close();
            } else {
              echo "<div class='alert alert-danger'>กรุณาเลือกสถานะ</div>";
            }
          }

          ?>
          <?php
          // แสดงสถานะ
          $roww = $result_check->fetch_assoc();
          ?>
          <div class="d-flex justify-content-center p-5">
            <h1 class="text-custom-5 text-center custom-font-size-head">ห้อง <?php echo  $room_number; ?></h1>
          </div>

          <div class="mx-5 p-1">
            <p class="mx-5 p-1 text-custom-5 fs-5">
              <span class="fw-bold p-lg-5">วันลงบิล :</span>
              <span><?php echo $roww['bill_date'] ?></span>
            </p>
          </div>
          <div class="mx-5 p-1">
            <p class="mx-5 p-1 text-custom-5 fs-5">
              <span class="fw-bold p-lg-5">ค่าไฟ :</span>
              <span><?php echo $total_electricity_cost ?></span>
            </p>
          </div>
          <div class="mx-5 p-1">
            <p class="mx-5 p-1 text-custom-5 fs-5">
              <span class="fw-bold p-lg-5">ค่าน้ำ :</span>
              <span><?php echo $total_water_cost ?></span>
            </p>
          </div>
          <div class="mx-5 p-1">
            <p class="mx-5 p-1 text-custom-5 fs-5">
              <span class="fw-bold p-lg-5">ค่าเฟอร์นิเจอร์ :</span>
              <span><?php echo $total_furniture_cost ?></span>
            </p>
          </div>
          <div class="mx-5 p-1">
            <p class="mx-5 p-1 text-custom-5 fs-5">
              <span class="fw-bold p-lg-5">ค่าเช่าห้อง :</span>
              <span><?php echo $total_room_cost ?></span>
            </p>
          </div>
          <div class="mx-5 p-1">
            <p class="mx-5 p-1 text-custom-5 fs-5">
              <span class="fw-bold p-lg-5">ค่าอื่นๆ :</span>
              <span><?php echo $total_other_cost; ?></span>
            </p>
          </div>
          <div class="mx-5 p-1">
            <p class="mx-5 p-1 text-custom-5 fs-5">
              <span class="fw-bold p-lg-5">รวม :</span>
              <span><?php echo $total_electricity_cost + $total_water_cost + $total_furniture_cost + $total_room_cost + $total_other_cost ?></span>
            </p>
          </div>


          <div class="mx-5 p-1">
            <p class="mx-5 p-1 text-custom-5 fs-5">
              <span class="fw-bold p-lg-5">สถานะ :</span>
              <span>
                <?php
                // กำหนดคลาสสำหรับปุ่มตามสถานะ
                switch ($roww['payment_status']) {
                  case 'จ่ายแล้ว':
                    $btnClass = 'btn btn-success';
                    $btnText = 'จ่ายแล้ว';
                    break;
                  case 'จ่ายช้า':
                    $btnClass = 'btn btn-warning';
                    $btnText = 'จ่ายช้า';
                    break;
                  case 'ยังไม่ได้จ่าย':
                    $btnClass = 'btn btn-danger';
                    $btnText = 'ยังไม่ได้จ่าย';
                    break;
                  default:
                    $btnClass = 'btn btn-secondary';
                    $btnText = 'สถานะไม่ทราบ';
                    break;
                } ?>
                <span class="<?php echo $btnClass; ?>" style="pointer-events: none;"><?php echo $btnText; ?></span>
              </span>
            </p>
            <div class="d-flex justify-content-end mb-3">
              <a href="editroombill.php?room_number=<?php echo $room_number; ?>" class="btn btn-warning me-2">
                แก้ไขบิล
              </a>
              <form action="/deleteroombill.php?room_number=<?php echo $room_number; ?>" method="post" class="d-inline">
                <input type="hidden" name="room_number" value="<?php echo $room_number; ?>">
                <button type="submit" class="btn btn-danger">
                  ลบข้อมูล
                </button>
              </form>
            </div>
          </div>

          <!-- ฟอร์มอัปเดตสถานะ -->
          <form method="post" style="position: absolute; top: 10px; right: 10px; width: 150px;" id="statusForm">
            <label for="payment_status">สถานะ :</label>
            <select name="payment_status" id="payment_status" class="form-select" onchange="this.form.submit()">
              <option value="จ่ายแล้ว" <?php if ($roww['payment_status'] == 'จ่ายแล้ว') echo 'selected'; ?>>จ่ายแล้ว</option>
              <option value="จ่ายช้า" <?php if ($roww['payment_status'] == 'จ่ายช้า') echo 'selected'; ?>>จ่ายช้า</option>
              <option value="ยังไม่ได้จ่าย" <?php if ($roww['payment_status'] == 'ยังไม่ได้จ่าย') echo 'selected'; ?>>ยังไม่ได้จ่าย</option>
            </select>

          </form>

      <?php
        } else {
          echo "<div class='alert alert-warning'>ไม่พบข้อมูลการเรียกเก็บเงินสำหรับห้องนี้</div>";
        }
      } else {
        echo "<div class='alert alert-danger text-center'>! ! ! ไม่พบข้อมูลบิลสำหรับห้องนี้ ! ! !</div>";
      }
      // ปิดการเชื่อมต่อ
      $stmt_check->close();
      $conn->close();
      ?>
      <script>
        // ตั้งค่าให้ alert เลื่อนขึ้นและหายไปหลังจาก 2 วินาที
        setTimeout(function() {
          var alert = document.getElementById('myAlert');
          alert.style.transition = "transform 1s ease, opacity 1s ease"; // ใช้ transition กับ transform และ opacity
          alert.style.transform = "translateY(-20px)"; // เลื่อนขึ้น
          alert.style.opacity = '0'; // ลดความโปร่งใส

          // ลบ alert ออกจาก DOM หลังจาก transition เสร็จ
          setTimeout(function() {
            alert.remove();
          }, 1000); // ใช้เวลา 1 วินาทีในการลบออก
        }, 2000); // รอ 2 วินาทีก่อนเริ่มเลื่อนขึ้น
      </script>
      <?php include 'footer.php' ?>
    </main>

  </section>

</body>



</html>