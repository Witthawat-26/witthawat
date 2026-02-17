<?php 
session_start(); // สำคัญมาก ห้ามลืม
include('includes/db_connect.php'); 
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
include('includes/header.php'); 

// --- 1. ส่วนเพิ่มสินค้า (ที่มีอยู่แล้ว) ---
if(isset($_GET['add'])) {
    $id = $_GET['add'];
    if(!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }
    $_SESSION['cart'][$id] = 1; 
    header("Location: cart.php");
    exit();
}

// --- 2. ส่วนลบสินค้า (เพิ่มใหม่) ---
if(isset($_GET['remove'])) {
    $id_remove = $_GET['remove'];
    unset($_SESSION['cart'][$id_remove]); // ลบสินค้านออกจาก Session
    header("Location: cart.php");
    exit();
}
?>

<div class="container mt-5">
    <h3 class="fw-bold mb-4 text-dark"><i class="bi bi-cart-check-fill"></i> ตะกร้าสินค้าของคุณ</h3>
    
    <div class="card shadow-sm border-0" style="border-radius: 15px;">
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead class="table-dark">
                    <tr>
                        <th class="py-3 px-4">สินค้า</th>
                        <th class="py-3 text-end">ราคา/หน่วย</th>
                        <th class="py-3 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody>
                    <?php 
                    $total = 0; // ตัวแปรเก็บราคารวม
                    if(!empty($_SESSION['cart'])) {
                        foreach($_SESSION['cart'] as $id => $qty) {
                            $res = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
                            $p = mysqli_fetch_assoc($res);
                            
                            if($p) {
                                $total += $p['price']; // บวกราคาสินค้าเข้าไปในยอดรวม
                                echo "<tr>
                                        <td class='align-middle py-3 px-4 fw-bold'>{$p['product_name']}</td>
                                        <td class='align-middle py-3 text-end'>".number_format($p['price'])." ฿</td>
                                        <td class='align-middle py-3 text-center'>
                                            <a href='cart.php?remove=$id' class='btn btn-outline-danger btn-sm rounded-pill px-3' onclick='return confirm(\"ยืนยันการลบสินค้า?\")'>
                                                <i class='bi bi-trash'></i> ลบ
                                            </a>
                                        </td>
                                      </tr>";
                            }
                        }
                        // แถวสรุปราคารวม
                        echo "<tr class='table-light'>
                                <td class='py-3 px-4 fw-bold text-end'>ราคารวมทั้งหมด</td>
                                <td class='py-3 text-end text-danger fw-bold fs-5'>".number_format($total)." ฿</td>
                                <td></td>
                              </tr>";
                    } else {
                        echo "<tr><td colspan='3' class='text-center py-5 text-muted'>ตะกร้าของคุณยังว่างเปล่า <br> <a href='index.php' class='btn btn-primary btn-sm mt-3'>ไปช้อปปิ้งกันเลย</a></td></tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="d-flex justify-content-between mt-4">
        <a href="index.php" class="btn btn-outline-dark px-4 rounded-pill">
            <i class="bi bi-arrow-left"></i> กลับไปเลือกสินค้า
        </a>
        
        <?php if(!empty($_SESSION['cart'])): ?>
            <a href="checkout.php" class="btn btn-success px-5 py-2 fw-bold rounded-pill shadow">
                สั่งซื้อสินค้า <i class="bi bi-arrow-right"></i>
            </a>
        <?php endif; ?>
    </div>
</div>

<?php include('includes/footer.php'); ?>