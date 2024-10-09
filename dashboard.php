<?php include 'dbconnection.php'; ?>
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
  <!-- เพิ่ม Chart.js จาก CDN -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body class="p-0">
  <section class="row">

    <?php include("/Users/User/Desktop/XAMPP/htdocs/aside.php"); ?>

    <main class=" col-xl-10 bg-white border border-5">

      <?php
      // สร้าง Query เพื่อดึงข้อมูลสถานะห้อง
      $query = "SELECT status, COUNT(*) as count FROM rooms GROUP BY status";
      $result = $conn->query($query);

      // สร้างตัวแปรเพื่อเก็บจำนวนของแต่ละสถานะ
      $available_count = 0;
      $booked_count = 0;
      $unavailable_count = 0;

      if ($result->num_rows > 0) {
        // ดึงข้อมูลจากผลลัพธ์ Query
        while ($row = $result->fetch_assoc()) {
          if ($row['status'] == 'available') {
            $available_count = $row['count'];
          } elseif ($row['status'] == 'booked') {
            $booked_count = $row['count'];
          } elseif ($row['status'] == 'unavailable') {
            $unavailable_count = $row['count'];
          }
        }
      } else {
        echo "ไม่พบข้อมูลในฐานข้อมูล";
      }

      // ปิดการเชื่อมต่อฐานข้อมูล
      $conn->close();
      ?>



      <div class="container">
        <div class="row pt-4 mb-4 align-item-center">
          <div class="col-10">
            <h1 class="f2-2">
              dashboard
            </h1>
          </div>














          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow">
              <div class="card-body">
                <div class="content">
                  <h5 class="card-title">ห้องเต็ม</h5>
                  <div class="number"><?php echo $unavailable_count; ?></div>
                </div>
                <div class="icon">
                  <i class=""></i>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow">
              <div class="card-body">
                <div class="content">
                  <h5 class="card-title">ห้องจอง</h5>
                  <div class="number"><?php echo $booked_count; ?></div>
                </div>
                <div class="icon">
                  <i class=""></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow">
              <div class="card-body">
                <div class="content">
                  <h5 class="card-title">ห้องว่าง</h5>
                  <div class="number"><?php echo $available_count; ?></div>
                </div>
                <div class="icon">
                  <i class=""></i>
                </div>
              </div>
            </div>
          </div>

          <div class="col-xl-3 col-md-6 mb-4">
            <div class="card shadow">
              <div class="card-body">
                <div class="content">
                  <h5 class="card-title">หัวข้อ 1</h5>
                  <div class="number">123</div>
                </div>
                <div class="icon">
                  <i class=""></i>
                </div>
              </div>
            </div>
          </div>
          <div class="col-2">

          </div>
        </div>
      </div>
    </main>
  </section>
</body>
<script
  src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
  integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
  crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="/Project/template/docphp/js/demo/chart-area-demo.js"></script>

</html>