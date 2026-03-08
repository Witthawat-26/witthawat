<?php
session_start();
include('db_connect.php');

if (isset($_POST['shipping_address'])) {
    $u_id = $_SESSION['u_id'];
    $address = mysqli_real_escape_string($conn, $_POST['shipping_address']);
    $order_date = date('Y-m-d H:i:s');
    
    // 1. คำนวณราคารวม
    $total_price = 0;
    foreach ($_SESSION['cart'] as $p_id => $qty) {
        $p_query = mysqli_query($conn, "SELECT p_price FROM products WHERE p_id = '$p_id'");
        $p_data = mysqli_fetch_assoc($p_query);
        $total_price += ($p_data['p_price'] * $qty);
    }

    // 2. บันทึกลงตาราง orders (ใช้ชื่อคอลัมน์ตามรูป image_803aff.png)
    $sql_order = "INSERT INTO orders (u_id, order_date, total_price, order_status, shipping_address) 
                  VALUES ('$u_id', '$order_date', '$total_price', 'pending', '$address')";
    
    if (mysqli_query($conn, $sql_order)) {
        $order_id = mysqli_insert_id($conn);

        // 3. บันทึกลงตาราง order_details (ใช้ชื่อคอลัมน์ตามรูป image_802f46.png)
        foreach ($_SESSION['cart'] as $p_id => $qty) {
            $p_query = mysqli_query($conn, "SELECT p_price FROM products WHERE p_id = '$p_id'");
            $p_data = mysqli_fetch_assoc($p_query);
            $current_price = $p_data['p_price'];

            $sql_detail = "INSERT INTO order_details (order_id, p_id, quantity, price_at_time) 
                           VALUES ('$order_id', '$p_id', '$qty', '$current_price')";
            mysqli_query($conn, $sql_detail);
            
            // 4. ตัดสต็อก
            mysqli_query($conn, "UPDATE products SET p_stock = p_stock - $qty WHERE p_id = '$p_id'");
        }

        unset($_SESSION['cart']);
        echo "<script>alert('สั่งซื้อสินค้าสำเร็จ!'); window.location.href='order_history.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>