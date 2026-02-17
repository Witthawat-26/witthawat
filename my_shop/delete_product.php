<?php
include('../includes/db_connect.php');

if(isset($_GET['id'])) {
    $p_id = $_GET['id'];

    // 1. ดึงชื่อไฟล์รูปภาพทั้งหมดของสินค้านี้มาเพื่อสั่งลบไฟล์ในเครื่อง
    $img_res = mysqli_query($conn, "SELECT image_path FROM product_images WHERE product_id = $p_id");
    while($img = mysqli_fetch_assoc($img_res)) {
        $file_path = "../assets/uploads/" . $img['image_path'];
        if(file_exists($file_path)) { unlink($file_path); } // คำสั่งลบไฟล์จริงออกจากโฟลเดอร์
    }

    // 2. ลบข้อมูลในฐานข้อมูล (ตาราง images และ products)
    // หมายเหตุ: ถ้าตั้ง ON DELETE CASCADE ไว้ใน SQL มันจะลบรูปใน DB ให้เองอัตโนมัติ
    mysqli_query($conn, "DELETE FROM products WHERE product_id = $p_id");

    echo "<script>alert('ลบสินค้าและรูปภาพเรียบร้อย'); window.location='dashboard.php';</script>";
}
?>