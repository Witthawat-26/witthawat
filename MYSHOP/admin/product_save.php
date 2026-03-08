<?php
session_start();
include('../db_connect.php');

if (isset($_POST['save_product'])) {
    $p_name = mysqli_real_escape_string($conn, $_POST['p_name']);
    $p_price = $_POST['p_price'];
    $p_stock = $_POST['p_stock'];
    $cat_id = $_POST['cat_id'];
    $p_detail = mysqli_real_escape_string($conn, $_POST['p_detail']);

    // 1. ใช้ __DIR__ เพื่อหาตำแหน่งที่แน่นอนของไฟล์นี้ แล้วถอยออกไปหา assets
    // __DIR__ บน Windows จะได้ประมาณ C:\xampp\htdocs\MYSHOP\admin
    $upload_dir = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'assets' . DIRECTORY_SEPARATOR . 'images' . DIRECTORY_SEPARATOR;

    // 2. ถ้าไม่มีโฟลเดอร์ ให้สร้างขึ้นมาเลย (รวมถึงโฟลเดอร์ย่อยด้วย)
    if (!is_dir($upload_dir)) {
        mkdir($upload_dir, 0777, true);
    }

    // 3. จัดการไฟล์ภาพ
    if ($_FILES['p_image']['name'] != "") {
        $ext = pathinfo(basename($_FILES['p_image']['name']), PATHINFO_EXTENSION);
        $new_image_name = 'img_' . uniqid() . '.' . $ext;
        $target_path = $upload_dir . $new_image_name;

        // 4. ย้ายไฟล์
        if (move_uploaded_file($_FILES['p_image']['tmp_name'], $target_path)) {
            
            $sql = "INSERT INTO products (p_name, p_price, p_stock, cat_id, p_detail, p_image) 
                    VALUES ('$p_name', '$p_price', '$p_stock', '$cat_id', '$p_detail', '$new_image_name')";
            
            if (mysqli_query($conn, $sql)) {
                echo "<script>alert('เพิ่มสินค้าสำเร็จ!'); window.location.href='product_list.php';</script>";
            } else {
                echo "Error SQL: " . mysqli_error($conn);
            }
        } else {
            // ถ้ายังไม่ได้อีก จะโชว์ Path ที่ PHP พยายามจะวางไฟล์ให้ดูครับ
            echo "พยายามย้ายไปที่: " . $target_path . "<br>";
            die("Error: ไม่สามารถบันทึกไฟล์รูปภาพได้ เช็คสิทธิ์โฟลเดอร์อีกครั้ง");
        }
    } else {
        echo "<script>alert('กรุณาเลือกรูปภาพ'); window.history.back();</script>";
    }
}
?>