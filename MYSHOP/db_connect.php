<?php
$servername = "localhost";
$username = "root";
$password = "zx123456"; // ปกติ XAMPP จะไม่มีรหัสผ่าน ถ้ามีให้ใส่ที่นี่
$dbname = "progamer_db";

// สร้างการเชื่อมต่อ
$conn = mysqli_connect($servername, $username, $password, $dbname);

// ตรวจสอบการเชื่อมต่อ
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตั้งค่าให้รองรับภาษาไทย
mysqli_set_charset($conn, "utf8mb4");
?>