<?php
session_start();
include('../db_connect.php');

if (isset($_POST['save_product'])) {
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_price = $_POST['p_price'];
    $p_stock = $_POST['p_stock'];
    $cat_id = $_POST['cat_id'];
    $p_detail = mysqli_real_escape_string($conn, $_POST['p_detail']);

    // 1. สร้าง Path แบบสมบูรณ์ (Absolute Path) สำหรับ Windows
    // สิ่งนี้จะช่วยให้ PHP หาโฟลเดอร์ assets/images เจอแน่นอน
    $base_dir = $_SERVER['DOCUMENT_ROOT'] . '/witthawat/MYSHOP/assets/images/';
    
    // 2. ตรวจสอบและสร้างโฟลเดอร์ถ้าไม่มี
    if (!is_dir($base_dir)) {
        mkdir($base_dir, 0777, true);
    }

    if ($_FILES['p_image']['name'] != "") {
        $ext = pathinfo(basename($_FILES['p_image']['name']), PATHINFO_EXTENSION);
        $new_image_name = 'img_' . uniqid() . '.' . $ext;
        $target_path = $base_dir . $new_image_name;

        // 3. ย้ายไฟล์
        if (move_uploaded_file($_FILES['p_image']['tmp_name'], $target_path)) {
            
            $sql = "INSERT INTO products (p_name, p_price, p_stock, cat_id, p_detail, p_image) 
                    VALUES ('$p_name', '$p_price', '$p_stock', '$cat_id', '$p_detail', '$new_image_name')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('เพิ่มสินค้าสำเร็จ!'); window.location.href='product_list.php';</script>";
            } else {
                echo "Error SQL: " . mysqli_error($conn);
            }
        } else {
            // โชว์ Path ที่มันพยายามจะเขียน เพื่อให้คุณไปเช็คในเครื่องว่าโฟลเดอร์ตรงกันไหม
            echo "พยายามบันทึกไปที่: " . $target_path . "<br>";
            die("Error: ไม่สามารถบันทึกไฟล์รูปภาพได้ กรุณาเช็คชื่อโฟลเดอร์ assets/images");
        }
    } else {
        echo "<script>alert('กรุณาเลือกรูปภาพ'); window.history.back();</script>";
    }
}
?>