fetch("/chart.php") // ดึงข้อมูลจาก chart.php
  .then((response) => {
    if (!response.ok) {
      throw new Error("Network response was not ok " + response.statusText);
    }
    return response.json(); // แปลงเป็น JSON
  })
  .then((data) => {
    console.log(data);
    const ctx = document.getElementById("expenseChart").getContext("2d");

    const expenseChart = new Chart(ctx, {
      type: "line", // ประเภทกราฟ
      data: {
        labels: data.months, // เดือนที่ดึงจากฐานข้อมูล หรือเดือนเริ่มต้น
        datasets: [
          {
            label: "บิลรายเดือน", // ชื่อกราฟ
            data: data.totalBillings, // ยอดใช้จ่ายจากฐานข้อมูล หรือข้อมูลเริ่มต้น
            fill: true,
            backgroundColor: "rgba(75, 192, 192, 0.2)",
            borderColor: "rgba(75, 192, 192, 1)",
            borderWidth: 2,
          },
        ],
      },
      options: {
        scales: {
          y: {
            beginAtZero: true, // ให้แกน Y เริ่มจาก 0
          },
        },
      },
    });
  })
  .catch((error) => console.error("Error:", error));
