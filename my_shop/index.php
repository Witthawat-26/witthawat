<?php 
session_start();
// 1. ต้อง include ไฟล์เชื่อมต่อฐานข้อมูลก่อนใช้งาน $conn
include('includes/db_connect.php'); 

// --- ส่วนประมวลผลการสมัครสมาชิก (คงไว้ตามเดิม) ---
if(isset($_POST['register_now'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; 
    $name = mysqli_real_escape_string($conn, $_POST['name']);

    $check_user = mysqli_query($conn, "SELECT username FROM users WHERE username = '$username'");
    if(mysqli_num_rows($check_user) > 0) {
        echo "<script>alert('ชื่อผู้ใช้นี้ถูกใช้งานแล้ว!');</script>";
    } else {
        $sql_reg = "INSERT INTO users (username, password, name, role) VALUES ('$username', '$password', '$name', 'user')";
        if(mysqli_query($conn, $sql_reg)) {
            echo "<script>alert('สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ'); window.location='login.php';</script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาด: " . mysqli_error($conn) . "');</script>";
        }
    }
}

include('includes/header.php'); 
$is_logged_in = isset($_SESSION['username']);
?>

<style>
    /* ปรับแต่งตามรูปตัวอย่างที่คุณส่งมา */
    .badge-hot { position: absolute; top: 10px; left: 10px; background-color: #ff4757; color: white; padding: 4px 10px; border-radius: 5px; font-weight: bold; font-size: 0.75rem; z-index: 5; }
    .badge-sale { position: absolute; top: 10px; right: 10px; background-color: #ffa502; color: white; padding: 4px 10px; border-radius: 5px; font-weight: bold; font-size: 0.75rem; z-index: 5; }
    .card:hover { transform: translateY(-5px); transition: 0.3s; }
    .card-img-top { height: 200px; object-fit: contain; padding: 15px; background: #fff; }
</style>

<div class="container mt-4">
    <div class="row">
        <div class="col-md-3">
            <?php if (!$is_logged_in): ?>
                <div class="card shadow-sm border-0 mb-4" style="border-radius: 15px;">
                    <div class="card-header bg-primary text-white text-center py-3" style="border-radius: 15px 15px 0 0;">
                        <h5 class="mb-0">สมัครสมาชิกฟรี</h5>
                    </div>
                    <div class="card-body p-4">
                        <form method="POST" action="">
                            <div class="mb-3"><input type="text" name="username" class="form-control" placeholder="Username" required></div>
                            <div class="mb-3"><input type="password" name="password" class="form-control" placeholder="Password" required></div>
                            <div class="mb-4"><input type="text" name="name" class="form-control" placeholder="ชื่อ-นามสกุล" required></div>
                            <button type="submit" name="register_now" class="btn btn-primary w-100 fw-bold">สมัครสมาชิก</button>
                        </form>
                    </div>
                </div>
            <?php else: ?>
                <div class="card shadow-sm border-0 sticky-top" style="top: 20px; border-radius: 15px;">
                    <div class="card-body p-4">
                        <h5 class="fw-bold mb-3"><i class="bi bi-search"></i> ค้นหาสินค้า</h5>
                        <form action="index.php" method="GET" class="mb-4">
                            <div class="input-group">
                                <input type="text" name="search" class="form-control" placeholder="ชื่อสินค้า..." value="<?php echo isset($_GET['search']) ? $_GET['search'] : ''; ?>">
                                <button class="btn btn-dark" type="submit"><i class="bi bi-search"></i></button>
                            </div>
                        </form>

                        <h5 class="fw-bold mb-3"><i class="bi bi-list-stars"></i> หมวดหมู่สินค้า</h5>
                        <div class="list-group list-group-flush">
                            <a href="index.php" class="list-group-item list-group-item-action border-0 px-0 <?php echo !isset($_GET['cat']) && !isset($_GET['type']) ? 'active fw-bold' : ''; ?>">สินค้าทั้งหมด</a>
                            <a href="index.php?type=hot" class="list-group-item list-group-item-action border-0 px-0">🔥 สินค้าแนะนำ</a>
                            <a href="index.php?type=sale" class="list-group-item list-group-item-action border-0 px-0 text-danger">🏷️ สินค้าลดราคา</a>
                            <hr>
                            <a href="index.php?cat=Gear" class="list-group-item list-group-item-action border-0 px-0">Gaming Gear</a>
                            <a href="index.php?cat=CPU" class="list-group-item list-group-item-action border-0 px-0">CPU</a>
                            <a href="index.php?cat=RAM" class="list-group-item list-group-item-action border-0 px-0">RAM / Motherboard</a>
                            <a href="index.php?cat=Monitor" class="list-group-item list-group-item-action border-0 px-0">Monitor</a>
                            <a href="index.php?cat=Console" class="list-group-item list-group-item-action border-0 px-0">Console</a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <div class="col-md-9">
            <?php
            // รับค่าจาก URL เพื่อกรองสินค้า
            $search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : '';
            $type = isset($_GET['type']) ? $_GET['type'] : '';
            $cat = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : '';

            $sql = "SELECT * FROM products WHERE 1";

            if ($search != '') {
                $sql .= " AND product_name LIKE '%$search%'";
                echo "<h3 class='mb-4 fw-bold'>ผลการค้นหา: '$search'</h3>";
            } elseif ($cat != '') {
                $sql .= " AND category = '$cat'"; // กรองตามหมวดหมู่
                echo "<h3 class='mb-4 fw-bold'>หมวดหมู่: $cat</h3>";
            } elseif ($type == 'hot') {
                $sql .= " AND is_hot = 1 ORDER BY product_id DESC";
                echo "<h3 class='mb-4 fw-bold text-primary'>🔥 สินค้าแนะนำล่าสุด</h3>";
            } elseif ($type == 'sale') {
                $sql .= " AND is_sale = 1 ORDER BY price ASC";
                echo "<h3 class='mb-4 fw-bold text-danger'>🏷️ สินค้าลดราคาพิเศษ</h3>";
            } else {
                echo "<h3 class='mb-4 fw-bold border-bottom pb-2'>รายการสินค้าทั้งหมด</h3>";
            }

            $result = mysqli_query($conn, $sql);
            ?>

            <div class="row">
                <?php
                if(mysqli_num_rows($result) > 0) {
                    while($row = mysqli_fetch_assoc($result)) {
                        $p_id = $row['product_id'];
                        // ดึงรูปภาพจากตาราง product_images
                        $img_q = mysqli_query($conn, "SELECT image_path FROM product_images WHERE product_id = $p_id LIMIT 1");
                        $img = mysqli_fetch_assoc($img_q);
                        $show_img = ($img) ? $img['image_path'] : 'no-image.jpg';
                ?>
                <div class="col-md-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 position-relative" style="border-radius: 15px;">
                        <?php if($row['is_hot'] == 1): ?>
                            <span class="badge-hot">🔥 HOT</span>
                        <?php endif; ?>
                        <?php if($row['is_sale'] == 1): ?>
                            <span class="badge-sale">🏷️ SALE</span>
                        <?php endif; ?>

                        <img src="assets/uploads/<?php echo $show_img; ?>" class="card-img-top">
                        <div class="card-body text-center"> 
                            <h6 class="fw-bold text-truncate"><?php echo $row['product_name']; ?></h6>
                            <p class="text-danger fw-bold fs-5 mb-2"><?php echo number_format($row['price']); ?> ฿</p>
                            <div class="d-grid gap-2">
                                <a href="product_detail.php?id=<?php echo $p_id; ?>" class="btn btn-outline-dark btn-sm rounded-pill">รายละเอียด</a>
                                <a href="cart.php?add=<?php echo $p_id; ?>" class="btn btn-success btn-sm rounded-pill">
                                    <i class="bi bi-cart-plus"></i> หยิบลงตะกร้า
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <?php 
                    }
                } else {
                    echo "<div class='text-center p-5 text-muted col-12'>ไม่พบสินค้าในหมวดหมู่นี้</div>";
                }
                ?>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>