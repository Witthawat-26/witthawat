<?php 
session_start();
include('includes/db_connect.php'); 
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
include('includes/header.php'); 

if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    echo "<script>alert('เฉพาะแอดมินเท่านั้น!'); window.location='index.php';</script>";
    exit();
}

if(isset($_POST['save_bulk'])) {
    foreach($_POST['p_name'] as $key => $name) {
        if(!empty($name)) {
            $price = $_POST['p_price'][$key];
            $desc = mysqli_real_escape_string($conn, $_POST['p_desc'][$key]);
            $cat = $_POST['p_cat'][$key]; // รับค่าหมวดหมู่
            $is_hot = isset($_POST['p_hot'][$key]) ? 1 : 0; // เช็คสินค้าแนะนำ
            $is_sale = isset($_POST['p_sale'][$key]) ? 1 : 0; // เช็คสินค้าลดราคา
            
            // 1. บันทึกข้อมูลสินค้า (เพิ่มคอลัมน์ category, is_hot, is_sale ในฐานข้อมูลด้วยนะครับ)
            $sql = "INSERT INTO products (product_name, price, description, category, is_hot, is_sale) 
                    VALUES ('$name', '$price', '$desc', '$cat', '$is_hot', '$is_sale')";
            
            if(mysqli_query($conn, $sql)) {
                $product_id = mysqli_insert_id($conn);
                $img_name = $_FILES['p_img']['name'][$key];
                $img_tmp = $_FILES['p_img']['tmp_name'][$key];
                
                if(!empty($img_name)) {
                    $new_img_name = time() . "_" . $img_name;
                    move_uploaded_file($img_tmp, "assets/uploads/" . $new_img_name); //
                    mysqli_query($conn, "INSERT INTO product_images (product_id, image_path) VALUES ('$product_id', '$new_img_name')");
                }
            }
        }
    }
    echo "<script>alert('เพิ่มข้อมูลสินค้าและสถานะพิเศษเรียบร้อยแล้ว!'); window.location='index.php';</script>";
}
?>

<div class="container mt-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="fw-bold"><i class="bi bi-grid-3x3-gap-fill"></i> จัดการสต็อกสินค้าแบบรวดเร็ว</h3>
        <span class="badge bg-dark">โหมดแอดมิน: <?php echo $_SESSION['name']; ?></span>
    </div>

    <form method="POST" enctype="multipart/form-data">
        <div class="table-responsive">
            <table class="table table-hover align-middle bg-white shadow-sm" style="border-radius: 10px; overflow: hidden;">
                <thead class="table-dark">
                    <tr>
                        <th width="20%">ข้อมูลพื้นฐาน</th>
                        <th width="15%">หมวดหมู่</th>
                        <th width="15%">สถานะพิเศษ</th>
                        <th>รายละเอียดสินค้า</th>
                        <th width="20%">อัปโหลดรูป</th>
                    </tr>
                </thead>
                <tbody>
                    <?php for($i=1; $i<=5; $i++): ?>
                    <tr>
                        <td>
                            <input type="text" name="p_name[]" class="form-control mb-2" placeholder="ชื่อสินค้า">
                            <input type="number" name="p_price[]" class="form-control" placeholder="ราคา (บาท)">
                        </td>
                        <td>
                            <select name="p_cat[]" class="form-select">
                                <option value="Gear">Gaming Gear</option>
                                <option value="PC">Desktop PC</option>
                                <option value="Console">Console</option>
                                <option value="Accessory">Accessories</option>
                            </select>
                        </td>
                        <td>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="p_hot[<?php echo $i-1; ?>]">
                                <label class="form-check-label small">🔥 สินค้าแนะนำ</label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="p_sale[<?php echo $i-1; ?>]">
                                <label class="form-check-label small text-danger">🏷️ สินค้าลดราคา</label>
                            </div>
                        </td>
                        <td>
                            <textarea name="p_desc[]" class="form-control" rows="3" placeholder="สเปคสินค้า..."></textarea>
                        </td>
                        <td>
                            <input type="file" name="p_img[]" class="form-control">
                        </td>
                    </tr>
                    <?php endfor; ?>
                </tbody>
            </table>
        </div>
        <div class="text-end mt-3 mb-5">
            <a href="index.php" class="btn btn-light px-4">ยกเลิก</a>
            <button type="submit" name="save_bulk" class="btn btn-primary btn-lg px-5 shadow-sm">บันทึกข้อมูลทั้งหมด</button>
        </div>
    </form>
</div>

<?php include('includes/footer.php'); ?>