<?php
session_start();
// 1. เปิดการแจ้งเตือน Error (ใช้ตรวจสอบตอนพัฒนา)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../db_connect.php');

// 2. ตรวจสอบว่ามีการส่ง ID มาหรือไม่
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $p_id = mysqli_real_escape_string($conn, $_GET['id']);

    // 3. ดึงชื่อไฟล์รูปภาพมาเก็บไว้ก่อน เพื่อลบไฟล์ออกจาก Server
    $sql_img = "SELECT p_image FROM products WHERE p_id = '$p_id'";
    $res_img = mysqli_query($conn, $sql_img);
    
    if ($res_img && mysqli_num_rows($res_img) > 0) {
        $data = mysqli_fetch_assoc($res_img);
        $image_name = $data['p_image'];
        $image_path = "../assets/images/" . $image_name;

        // ลบไฟล์รูปภาพออกจากโฟลเดอร์ (ถ้ามีไฟล์อยู่จริง)
        if ($image_name != "" && file_exists($image_path)) {
            unlink($image_path);
        }

        // 4. ลบข้อมูลสินค้าออกจากฐานข้อมูล
        $sql_del = "DELETE FROM products WHERE p_id = '$p_id'";
        if (mysqli_query($conn, $sql_del)) {
            // ลบสำเร็จ ให้กลับไปหน้ารายการสินค้า
            header("Location: product_list.php?msg=success");
            exit();
        } else {
            // กรณีลบใน DB ไม่สำเร็จ
            die("MySQL Error: " . mysqli_error($conn));
        }
    } else {
        die("ไม่พบข้อมูลสินค้าที่ต้องการลบ");
    }
} else {
    // ถ้าไม่มี ID ส่งมา ให้เด้งกลับ
    header("Location: product_list.php");
    exit();
}
?>