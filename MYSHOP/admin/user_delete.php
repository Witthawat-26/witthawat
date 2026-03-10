<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php"); exit();
}

if (isset($_GET['id'])) {
    $u_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // ป้องกันการลบตัวเอง
    if ($u_id == $_SESSION['u_id']) {
        echo "<script>alert('ไม่สามารถลบบัญชีที่คุณกำลังใช้งานอยู่ได้'); window.location.href='user_list.php';</script>";
        exit();
    }

    $sql = "DELETE FROM users WHERE u_id = '$u_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('ลบข้อมูลลูกค้าเรียบร้อยแล้ว'); window.location.href='user_list.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>