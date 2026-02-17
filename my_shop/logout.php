<?php
session_start();
session_destroy(); // ล้างข้อมูลการล็อกอินทั้งหมด
header("Location: index.php"); // เด้งกลับไปหน้าแรก
exit();
?>