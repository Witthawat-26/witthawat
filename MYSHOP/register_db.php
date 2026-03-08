<?php
session_start();
include('db_connect.php');

if (isset($_POST['reg_user'])) {
    // รับค่าจากฟอร์มและป้องกัน SQL Injection
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // เข้ารหัสรหัสผ่านเพื่อความปลอดภัย
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // ตรวจสอบว่า Username ซ้ำหรือไม่
    $user_check = "SELECT * FROM users WHERE u_username = '$username' LIMIT 1";
    $query = mysqli_query($conn, $user_check);
    
    if (mysqli_num_rows($query) > 0) {
        echo "<script>alert('Username นี้มีผู้ใช้แล้ว!'); window.history.back();</script>";
    } else {
        // บันทึกข้อมูล
        $sql = "INSERT INTO users (u_username, u_password, u_fullname, u_email, u_address, u_role) 
                VALUES ('$username', '$hashed_password', '$fullname', '$email', '$address', 'customer')";
        
        if (mysqli_query($conn, $sql)) {
            echo "<script>alert('สมัครสมาชิกสำเร็จ!'); window.location.href='login.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    }
}
?>