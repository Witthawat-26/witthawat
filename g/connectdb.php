<?php
		$host = "localhost";
		$user = "root";
		$pwd = "zx123456";
		$db = "4037db";
		$conn = mysqli_connect($host, $user, $pwd, $db) or die ("เชื่อมต่อฐานข้อมูลไม่ได้");
		mysqli_query($conn, "SET NAMES utf8");
?>