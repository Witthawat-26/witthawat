<?php 
session_start();
include('includes/db_connect.php'); 
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
include('includes/header.php'); 

// เช็คสิทธิ์แอดมิน (ใช้เงื่อนไขเดิมของคุณ)
if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('เฉพาะแอดมินเท่านั้น!'); window.location='index.php';</script>";
    exit();
}

// 1. ดึงยอดขายรวมทั้งหมด
$total_sales_res = mysqli_query($conn, "SELECT SUM(total_price) as grand_total FROM progamer_sales");
$total_sales = mysqli_fetch_assoc($total_sales_res);

// 2. ดึงจำนวนออเดอร์ทั้งหมด
$count_orders_res = mysqli_query($conn, "SELECT COUNT(*) as total_orders FROM progamer_sales");
$count_orders = mysqli_fetch_assoc($count_orders_res);

// 3. ดึงสินค้าที่ขายดีที่สุด 5 อันดับแรก
$top_products = mysqli_query($conn, "SELECT product_name, COUNT(*) as qty, SUM(total_price) as sum_price 
                                     FROM progamer_sales GROUP BY product_name ORDER BY qty DESC LIMIT 5");

// 4. ดึงยอดขายแยกตามจังหวัด
$province_sales = mysqli_query($conn, "SELECT province, SUM(total_price) as sum_price 
                                       FROM progamer_sales GROUP BY province ORDER BY sum_price DESC");
?>

<div class="container mt-5">
    <h2 class="fw-bold mb-4"><i class="bi bi-speedometer2"></i> Sales Dashboard - PROGAMER</h2>
    
    <div class="row mb-5">
        <div class="col-md-6 mb-3">
            <div class="card bg-primary text-white shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5>ยอดขายรวมทั้งหมด</h5>
                    <h2 class="fw-bold">฿ <?php echo number_format($total_sales['grand_total']); ?></h2>
                </div>
            </div>
        </div>
        <div class="col-md-6 mb-3">
            <div class="card bg-dark text-white shadow border-0" style="border-radius: 15px;">
                <div class="card-body p-4">
                    <h5>จำนวนรายการสั่งซื้อทั้งหมด</h5>
                    <h2 class="fw-bold"><?php echo number_format($count_orders['total_orders']); ?> ออเดอร์</h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-primary">5 อันดับสินค้าขายดี (จำนวนครั้ง)</h5>
                </div>
                <div class="card-body">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ชื่อสินค้า</th>
                                <th class="text-center">จำนวนขาย</th>
                                <th class="text-end">ยอดเงินรวม</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while($row = mysqli_fetch_assoc($top_products)): ?>
                            <tr>
                                <td><?php echo $row['product_name']; ?></td>
                                <td class="text-center"><?php echo $row['qty']; ?></td>
                                <td class="text-end">฿ <?php echo number_format($row['sum_price']); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-5 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-white py-3">
                    <h5 class="mb-0 fw-bold text-success">ยอดขายแยกตามจังหวัด</h5>
                </div>
                <div class="card-body">
                    <div style="max-height: 300px; overflow-y: auto;">
                        <table class="table table-sm">
                            <?php while($row = mysqli_fetch_assoc($province_sales)): ?>
                            <tr>
                                <td><?php echo $row['province']; ?></td>
                                <td class="text-end fw-bold">฿ <?php echo number_format($row['sum_price']); ?></td>
                            </tr>
                            <?php endwhile; ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>