<?php
session_start();
include('../db_connect.php');

if (isset($_POST['save_product'])) {
    $p_name = $_POST['p_name'];
    $p_price = $_POST['p_price'];
    $p_stock = $_POST['p_stock'];
    $cat_id = $_POST['cat_id'];
    $p_detail = $_POST['p_detail'];

    // จัดการเรื่องรูปภาพ
    $ext = pathinfo(basename($_FILES['p_image']['name']), PATHINFO_EXTENSION); // นามสกุลไฟล์
    $new_image_name = 'img_' . uniqid() . '.' . $ext; // ตั้งชื่อใหม่กันชื่อซ้ำ
    $image_path = "../assets/images/" . $new_image_name;

    if (move_uploaded_file($_FILES['p_image']['tmp_name'], $image_path)) {
        // บันทึกลง Database
        $sql = "INSERT INTO products (p_name, p_price, p_stock, cat_id, p_detail, p_image) 
                VALUES ('$p_name', '$p_price', '$p_stock', '$cat_id', '$p_detail', '$new_image_name')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('เพิ่มสินค้าสำเร็จ!'); window.location.href='index.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
    }
}
?>