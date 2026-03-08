<?php
session_start();
include('db_connect.php');

// ตรวจสอบว่ามีการส่ง id สินค้ามาหรือไม่
if (isset($_POST['p_id'])) {
    $p_id = $_POST['p_id'];

    // ถ้ายังไม่มีตะกร้า ให้สร้าง Array ว่างขึ้นมา
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // ถ้ามีสินค้านี้ในตะกร้าอยู่แล้ว ให้เพิ่มจำนวน (+1)
    if (isset($_SESSION['cart'][$p_id])) {
        $_SESSION['cart'][$p_id]++;
    } else {
        // ถ้ายังไม่มี ให้ตั้งค่าจำนวนเป็น 1
        $_SESSION['cart'][$p_id] = 1;
    }

    header("Location: cart.php"); // เพิ่มเสร็จแล้วส่งไปหน้าตะกร้า
    exit();
}
?>