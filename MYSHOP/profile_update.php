<?php
session_start();
include('db_connect.php');

if (isset($_POST['update_profile'])) {
    $u_id = $_SESSION['u_id'];
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    $sql = "UPDATE users SET 
            u_fullname = '$fullname', 
            u_email = '$email', 
            u_address = '$address' 
            WHERE u_id = '$u_id'";

    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('อัปเดตข้อมูลสำเร็จ!'); window.location.href='profile.php';</script>";
    } else {
        echo "เกิดข้อผิดพลาด: " . mysqli_error($conn);
    }
}
?>