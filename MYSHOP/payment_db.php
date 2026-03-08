<?php
session_start();
include('db_connect.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['slip_image'])) {
    $order_id = mysqli_real_escape_string($conn, $_POST['order_id']);
    
    // กำหนด Path โดยใช้ __DIR__ เพื่อความแม่นยำ
    $upload_dir = __DIR__ . "/assets/images/";
    
    // สร้างโฟลเดอร์อัตโนมัติถ้ายังไม่มี (กันพลาด)
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    $ext = pathinfo($_FILES['slip_image']['name'], PATHINFO_EXTENSION);
    $new_name = "slip_" . $order_id . "_" . time() . "." . $ext;
    $target_file = $upload_dir . $new_name;

    // ย้ายไฟล์
    if (move_uploaded_file($_FILES['slip_image']['tmp_name'], $target_file)) {
        // บันทึกชื่อไฟล์ลง DB (บันทึกแค่ชื่อไฟล์ ไม่ต้องมี Path เต็ม)
        $sql = "UPDATE orders SET 
                slip_image = '$new_name', 
                order_status = 'waiting' 
                WHERE order_id = '$order_id'";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('อัปโหลดหลักฐานสำเร็จ!'); window.location.href='order_history.php';</script>";
        } else {
            echo "Error DB: " . mysqli_error($conn);
        }
    } else {
        // ถ้ายังไม่ได้อีก จะโชว์ว่าพยายามจะย้ายไปที่ไหน
        echo "Error: ไม่สามารถย้ายไฟล์ไปที่: " . $target_file;
    }
}
?>