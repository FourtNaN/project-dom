fetch("/chart.php")
  .then((response) => {
    if (!response.ok) {
      throw new Error("Network response was not ok " + response.statusText);
    }
    return response.json();
  })
  .then((data) => {
    const ctx = document.getElementById("expenseChart").getContext("2d");

    const expenseChart = new Chart(ctx, {
      type: "line",
      data: {
        labels: data.months, // เดือน
        datasets: [
          {
            label: "Monthly Billing", // ชื่อของกราฟ
            data: data.totalBillings, // ข้อมูลที่แสดง
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
            beginAtZero: true,
          },
        },
      },
    });
  })
  .catch((error) => console.error("Error:", error));
