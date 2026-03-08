<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['slip_image'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    // 1. ตรวจสอบโฟลเดอร์ก่อน (Path ต้องตรงกับโครงสร้างในรูปของคุณ)
    $upload_dir = "assets/images/";
    
    if (!is_dir($upload_dir)) {
        die("Error: ไม่พบโฟลเดอร์ $upload_dir กรุณาสร้างโฟลเดอร์ก่อนครับ");
    }

    // 2. จัดการไฟล์รูป
    $ext = pathinfo($_FILES['slip_image']['name'], PATHINFO_EXTENSION);
    $new_name = "slip_" . $order_id . "_" . time() . "." . $ext;
    $target = $upload_dir . $new_name;

    if (move_uploaded_file($_FILES['slip_image']['tmp_name'], $target)) {
        // 3. อัปเดต DB (หลังจากที่คุณเพิ่มคอลัมน์ slip_image ใน phpMyAdmin แล้ว)
        $sql = "UPDATE orders SET 
                slip_image = '$new_name', 
                order_status = 'waiting' 
                WHERE order_id = '$order_id'";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('อัปโหลดหลักฐานสำเร็จ! แอดมินจะรีบตรวจสอบออเดอร์ให้ครับ'); window.location.href='order_history.php';</script>";
        } else {
            echo "Error DB: " . mysqli_error($conn);
        }
    } else {
        // แจ้ง Error ละเอียดขึ้นว่าทำไมย้ายไฟล์ไม่ได้
        echo "Error: ไม่สามารถย้ายไฟล์ไปยัง $target ได้ (เช็ค Permission หรือ Path)";
    }
} else {
    header("Location: index.php");
}
?>