<?php
// ตั้งค่าการเชื่อมต่อฐานข้อมูล
$host = "localhost";
$user = "root";
$pass = "zx123456";
$dbname = "4029db"; // ชื่อฐานข้อมูลที่คุณใช้งานอยู่

// สร้างการเชื่อมต่อ
$conn = mysqli_connect($host, $user, $pass, $dbname);

// ตรวจสอบการเชื่อมต่อ จะบอกว่าเชื่อมต่อหรือไม่
if (!$conn) {
    die("เชื่อมต่อฐานข้อมูลล้มเหลว: " . mysqli_connect_error());
}

// ตั้งค่าให้รองรับภาษาไทยอย่างสมบูรณ์
mysqli_set_charset($conn, "utf8mb4");
?>