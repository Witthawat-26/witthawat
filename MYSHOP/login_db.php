<?php
session_start();
include('db_connect.php');

if (isset($_POST['login_user'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE u_username = '$username'";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        
        // ตรวจสอบรหัสผ่านที่เข้ารหัสไว้
        if (password_verify($password, $user['u_password'])) {
            $_SESSION['u_id'] = $user['u_id'];
            $_SESSION['u_username'] = $user['u_username'];
            $_SESSION['u_role'] = $user['u_role'];

            if ($user['u_role'] == 'admin') {
                header("Location: admin/index.php"); // ไปหน้าหลังร้าน
            } else {
                header("Location: index.php"); // ไปหน้าหน้าร้าน
            }
        } else {
            echo "<script>alert('รหัสผ่านไม่ถูกต้อง!'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('ไม่พบ Username นี้ในระบบ!'); window.history.back();</script>";
    }
}
?>