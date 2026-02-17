<?php 
include('../includes/db_connect.php'); 
include('../includes/header.php'); 

if(isset($_POST['save_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $price = $_POST['p_price'];
    $desc = mysqli_real_escape_string($conn, $_POST['p_desc']);

    // 1. บันทึกข้อมูลสินค้าลงตาราง products
    $sql = "INSERT INTO products (product_name, price, description) VALUES ('$name', '$price', '$desc')";
    
    if(mysqli_query($conn, $sql)) {
        $last_id = mysqli_insert_id($conn); // ดึง ID ของสินค้าที่เพิ่งเพิ่มเข้าไป

        // 2. ตรวจสอบการอัปโหลดไฟล์รูปภาพ
        if(isset($_FILES['p_image']) && $_FILES['p_image']['error'] == 0) {
            // ตั้งชื่อไฟล์ใหม่โดยใช้เวลาปัจจุบัน เพื่อป้องกันชื่อซ้ำ
            $ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
            $filename = time() . "." . $ext; 
            
            $tempname = $_FILES['p_image']['tmp_name'];
            $folder = "../assets/uploads/" . $filename; // ระบุที่อยู่ที่จะเก็บไฟล์จริง

            // ย้ายไฟล์จากโฟลเดอร์ชั่วคราวไปยังโฟลเดอร์ uploads ของเรา
            if(move_uploaded_file($tempname, $folder)) {
                // 3. บันทึกชื่อไฟล์ลงตาราง product_images
                mysqli_query($conn, "INSERT INTO product_images (product_id, image_path) VALUES ('$last_id', '$filename')");
            }
        }
        echo "<script>alert('เพิ่มสินค้าและรูปภาพสำเร็จ!'); window.location='../index.php';</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow border-0" style="border-radius: 20px;">
                <div class="card-body p-5">
                    <h3 class="fw-bold mb-4 text-center text-primary">เพิ่มสินค้าใหม่</h3>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="mb-3">
                            <label class="form-label fw-bold">ชื่อสินค้า</label>
                            <input type="text" name="p_name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">ราคาสินค้า (บาท)</label>
                            <input type="number" name="p_price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">รายละเอียด</label>
                            <textarea name="p_desc" class="form-control" rows="3"></textarea>
                        </div>
                        <div class="mb-4">
                            <label class="form-label fw-bold text-danger">เลือกรูปภาพสินค้า</label>
                            <input type="file" name="p_image" class="form-control" accept="image/*" required>
                        </div>
                        <button type="submit" name="save_product" class="btn btn-primary w-100 py-2 fw-bold">บันทึกสินค้า</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>