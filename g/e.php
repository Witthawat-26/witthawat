<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>Dashboard - นายวิทวัส วงศ์ภาคำ</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body { font-family: sans-serif; background: #f4f7f6; padding: 20px; color: #333; }
        .container { display: grid; grid-template-columns: 1fr 1fr; gap: 20px; max-width: 1200px; margin: auto; }
        .box { background: #fff; padding: 20px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .full-width { grid-column: span 2; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #eee; }
        th { background: #f8f9fa; }
        h1 { text-align: center; color: #2c3e50; }
    </style>
</head>
<body>

<h1>📊 รายงานยอดขาย: นายวิทวัส วงศ์ภาคำ (เกมส์)</h1>

<div class="container">
    <div class="box full-width">
        <h3>รายการยอดขายตามประเทศ</h3>
        <table>
            <thead>
                <tr><th>ประเทศ</th><th style="text-align:right">ยอดขายรวม</th></tr>
            </thead>
            <tbody>
                <?php
                include_once("connectdb.php");
                $sql = "SELECT `p_country`, SUM(`p_amount`) AS total FROM `popsupermarket` GROUP BY `p_country` ORDER BY total DESC;";
                $rs = mysqli_query($conn, $sql);
                $labels = []; $values = [];
                while ($data = mysqli_fetch_array($rs)) {
                    $labels[] = $data['p_country'];
                    $values[] = (float)$data['total'];
                    echo "<tr>
                            <td>📍 {$data['p_country']}</td>
                            <td align='right'><strong>".number_format($data['total'], 2)."</strong></td>
                          </tr>";
                }
                mysqli_close($conn);
                ?>
            </tbody>
        </table>
    </div>

    <div class="box">
        <canvas id="barChart"></canvas>
    </div>

    <div class="box">
        <canvas id="pieChart"></canvas>
    </div>
</div>

<script>
const ctxBar = document.getElementById('barChart');
const ctxPie = document.getElementById('pieChart');
const commonData = {
    labels: <?php echo json_encode($labels); ?>,
    datasets: [{
        label: 'ยอดขาย (Amount)',
        data: <?php echo json_encode($values); ?>,
        backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc', '#f6c23e', '#e74a3b', '#858796'],
        borderWidth: 1
    }]
};

// กราฟแท่ง (Bar)
new Chart(ctxBar, {
    type: 'bar',
    data: commonData,
    options: { 
        plugins: { title: { display: true, text: 'เปรียบเทียบยอดขาย' } },
        scales: { y: { beginAtZero: true } }
    }
});

// กราฟวงกลม (Pie)
new Chart(ctxPie, {
    type: 'pie',
    data: commonData,
    options: {
        plugins: { title: { display: true, text: 'สัดส่วนยอดขาย (%)' } }
    }
});
</script>

</body>
</html>