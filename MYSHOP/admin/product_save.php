<?php
session_start();
include('../db_connect.php');

if (isset($_POST['save_product'])) {
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_price = $_POST['p_price'];
    $p_stock = $_POST['p_stock'];
    $cat_id = $_POST['cat_id'];
    $p_detail = mysqli_real_escape_string($conn, $_POST['p_detail']);

    // 1. ตรวจสอบว่ามีโฟลเดอร์ assets/images หรือยัง (ในระดับนอก admin)
    $upload_dir = "../assets/images/";
    
    if (!is_dir($upload_dir)) {
        // ถ้าไม่มีให้สร้างโฟลเดอร์ขึ้นมาเอง
        mkdir($upload_dir, 0777, true);
    }

    // 2. ตรวจสอบว่ามีการเลือกรูปภาพมาจริงไหม
    if ($_FILES['p_image']['name'] != "") {
        $ext = pathinfo(basename($_FILES['p_image']['name']), PATHINFO_EXTENSION);
        $new_image_name = 'img_' . uniqid() . '.' . $ext;
        $image_path = $upload_dir . $new_image_name;

        // 3. ย้ายไฟล์ไปยังโฟลเดอร์ที่กำหนด
        if (move_uploaded_file($_FILES['p_image']['tmp_name'], $image_path)) {
            
            // 4. บันทึกลง Database
            $sql = "INSERT INTO products (p_name, p_price, p_stock, cat_id, p_detail, p_image) 
                    VALUES ('$p_name', '$p_price', '$p_stock', '$cat_id', '$p_detail', '$new_image_name')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('เพิ่มสินค้าสำเร็จ!'); window.location.href='product_list.php';</script>";
            } else {
                echo "Error: " . mysqli_error($conn);
            }
        } else {
            // ถ้า Error ตรงนี้ แสดงว่า Path ../assets/images/ ผิด หรือหาโฟลเดอร์ไม่เจอ
            die("เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ! กรุณาเช็คว่ามีโฟลเดอร์ assets/images อยู่จริงไหม");
        }
    } else {
        echo "<script>alert('กรุณาเลือกรูปภาพ'); window.history.back();</script>";
    }
}
?>