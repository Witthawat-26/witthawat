<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>รายงานยอดขาย - นายวิทวัส</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: 'Sarabun', sans-serif; background: #f0f2f5; margin: 0; padding: 20px; }
        .dashboard-container { max-width: 1100px; margin: auto; display: grid; grid-template-columns: 1fr 1.5fr; gap: 20px; }
        .card { background: white; padding: 20px; border-radius: 15px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .header { grid-column: span 2; text-align: center; margin-bottom: 10px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th { background: #4e73df; color: white; padding: 12px; border-radius: 5px 5px 0 0; }
        td { padding: 10px; border-bottom: 1px solid #eee; text-align: center; }
        .chart-box { margin-bottom: 20px; }
        h2 { color: #2c3e50; font-size: 1.5rem; }
    </style>
</head>
<body>

<div class="dashboard-container">
    <div class="header">
        <h1>📊 คุณวิทวัส วงศ์ภาคำ (เกมส์)</h1>
        <p>Dashboard ยอดขายรายเดือน</p>
    </div>

    <div class="card">
        <h2>📋 สรุปตัวเลข</h2>
        <table>
            <thead>
                <tr><th>เดือน</th><th>ยอดขาย</th></tr>
            </thead>
            <tbody>
                <?php
                include_once("connectdb.php");
                $sql ="SELECT MONTH(p_date) AS Month, SUM(p_amount) AS Total_Sales FROM popsupermarket GROUP BY MONTH(p_date) ORDER BY Month;";
                $rs = mysqli_query($conn,$sql);
                
                $monthNames = ["", "มกราคม", "กุมภาพันธ์", "มีนาคม", "เมษายน", "พฤษภาคม", "มิถุนายน", "กรกฎาคม", "สิงหาคม", "กันยายน", "ตุลาคม", "พฤศจิกายน", "ธันวาคม"];
                $labels = [];
                $values = [];

                while ($data = mysqli_fetch_array($rs)) {
                    $m_name = $monthNames[$data['Month']];
                    $labels[] = $m_name;
                    $values[] = $data['Total_Sales'];
                ?>
                <tr>
                    <td><?php echo $m_name; ?></td>
                    <td style="text-align:right; font-weight:bold;"><?php echo number_format($data['Total_Sales'], 2); ?></td>
                </tr>
                <?php } mysqli_close($conn); ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="chart-box">
            <canvas id="barChart" height="120"></canvas>
        </div>
        <hr style="border: 0.5px solid #eee; margin: 20px 0;">
        <div class="chart-box" style="width: 70%; margin: auto;">
            <canvas id="donutChart"></canvas>
        </div>
    </div>
</div>

<script>
const labels = <?php echo json_encode($labels); ?>;
const dataValues = <?php echo json_encode($values); ?>;
const colors = ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#6f42c1', '#5a5c69'];

// กราฟแท่ง
new Chart(document.getElementById('barChart'), {
    type: 'bar',
    data: {
        labels: labels,
        datasets: [{
            label: 'ยอดขายรายเดือน',
            data: dataValues,
            backgroundColor: '#4e73df',
            borderRadius: 5
        }]
    },
    options: { plugins: { legend: { display: false } } }
});

// กราฟโดนัท
new Chart(document.getElementById('donutChart'), {
    type: 'doughnut',
    data: {
        labels: labels,
        datasets: [{
            data: dataValues,
            backgroundColor: colors,
            hoverOffset: 10
        }]
    },
    options: {
        cutout: '70%',
        plugins: {
            title: { display: true, text: 'สัดส่วนเปอร์เซ็นต์ยอดขาย' }
        }
    }
});
</script>

</body>
</html>