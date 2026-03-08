<?php
session_start();
// 1. เปิดการแสดง Error เพื่อหาจุดตาย (ถ้าแก้เสร็จแล้วค่อยเอาออก)
ini_set('display_errors', 1);
error_reporting(E_ALL);

include('../db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['p_id'])) {
    
    // 2. รับค่าจากฟอร์มและทำความสะอาดข้อมูล
    $p_id = mysqli_real_escape_string($conn, $_POST['p_id']);
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_price = mysqli_real_escape_string($conn, $_POST['p_price']);
    $p_stock = mysqli_real_escape_string($conn, $_POST['p_stock']);
    $cat_id = mysqli_real_escape_string($conn, $_POST['cat_id']);
    $old_image = $_POST['old_image'];

    // 3. จัดการเรื่องรูปภาพ
    $filename = $old_image; // ตั้งต้นเป็นชื่อรูปเดิม

    if (isset($_FILES['p_image']) && $_FILES['p_image']['error'] == 0) {
        $ext = pathinfo($_FILES['p_image']['name'], PATHINFO_EXTENSION);
        $new_name = time() . "." . $ext;
        $target = "../assets/images/" . $new_name;

        if (move_uploaded_file($_FILES['p_image']['tmp_name'], $target)) {
            $filename = $new_name;
            // ลบรูปเก่าทิ้ง (ถ้ามีรูปเก่าและไม่ใช่ชื่อว่าง)
            if ($old_image != "" && file_exists("../assets/images/" . $old_image)) {
                unlink("../assets/images/" . $old_image);
            }
        } else {
            die("Error: ไม่สามารถอัปโหลดรูปภาพไปยัง Folder assets/images ได้ (เช็ค Permission)");
        }
    }

    // 4. อัปเดตข้อมูลลงฐานข้อมูล
    $sql = "UPDATE products SET 
            p_name = '$p_name', 
            p_price = '$p_price', 
            p_stock = '$p_stock', 
            cat_id = '$cat_id', 
            p_image = '$filename' 
            WHERE p_id = '$p_id'";

    if (mysqli_query($conn, $sql)) {
        // อัปเดตสำเร็จ: แจ้งเตือนและกลับหน้าเดิม
        echo "<script>
                alert('อัปเดตข้อมูลสินค้าสำเร็จ!');
                window.location.href = 'product_list.php';
              </script>";
        exit();
    } else {
        // ถ้า SQL มีปัญหา จะโชว์ Error ตรงนี้
        die("MySQL Error: " . mysqli_error($conn));
    }

} else {
    // ถ้าไม่ได้มาจากการกดปุ่ม Submit
    header("Location: product_list.php");
    exit();
}
?>