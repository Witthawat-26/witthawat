<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['slip_image'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    // อัปโหลดรูปสลิป
    $ext = pathinfo($_FILES['slip_image']['name'], PATHINFO_EXTENSION);
    $new_name = "slip_" . $order_id . "_" . time() . "." . $ext;
    $target = "assets/images/" . $new_name; // เก็บไว้ที่เดียวกับรูปสินค้าเพื่อให้ง่าย

    if (move_uploaded_file($_FILES['slip_image']['tmp_name'], $target)) {
        // อัปเดตชื่อไฟล์สลิปและเปลี่ยนสถานะเป็น 'waiting_verification' (รอตรวจสอบ)
        // หมายเหตุ: คุณต้องมีคอลัมน์ slip_image ในตาราง orders ตามโครงสร้างของคุณ
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
        echo "Error: ไม่สามารถบันทึกไฟล์รูปภาพได้";
    }
}
?>