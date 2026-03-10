<?php
session_start();
include('../db_connect.php');

// เช็คสิทธิ์ Admin
if ($_SESSION['u_role'] != 'admin') { header("Location: ../index.php"); exit(); }

if (isset($_GET['id'])) {
    $cat_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // ตรวจสอบก่อนว่ามีสินค้าที่ใช้หมวดหมู่นี้อยู่หรือไม่ (เพื่อป้องกัน Data Error)
    $check_product = mysqli_query($conn, "SELECT p_id FROM products WHERE cat_id = '$cat_id' LIMIT 1");
    
    if (mysqli_num_rows($check_product) > 0) {
        echo "<script>alert('ไม่สามารถลบได้ เนื่องจากมีสินค้าอยู่ในหมวดหมู่นี้!'); window.location.href='category.php';</script>";
    } else {
        $sql = "DELETE FROM categories WHERE cat_id = '$cat_id'";
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('ลบหมวดหมู่สำเร็จ'); window.location.href='category.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>