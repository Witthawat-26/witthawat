<?php 
// ต้องถอยหลัง 1 ชั้น (../) เพื่อออกไปหาโฟลเดอร์ includes
include('../includes/db_connect.php'); 
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container bg-white p-4 shadow-sm">
        <div class="d-flex justify-content-between mb-4">
            <h3>รายงานการขาย (Admin)</h3>
            <a href="add_product.php" class="btn btn-success">เพิ่มสินค้าใหม่</a>
        </div>

        <table id="mySalesTable" class="table table-striped table-bordered">
            <thead>
                <tr>
                    <th>สินค้า</th>
                    <th>หมวดหมู่</th>
                    <th>จังหวัด</th>
                    <th>ราคารวม</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $sql = "SELECT * FROM progamer_sales";
                $result = mysqli_query($conn, $sql);
                while($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                        <td>{$row['product_name']}</td>
                        <td>{$row['category']}</td>
                        <td>{$row['province']}</td>
                        <td>" . number_format($row['total_price']) . "</td>
                    </tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#mySalesTable').DataTable();
        });
    </script>
</body>
</html>