<?php
		$host = "localhost";
		$user = "root";
		$pwd = "Zx.0966765968";
		$db = "4037db";
		$conn = mysqli_connect($host, $user, $pwd, $db) or die ("เชื่อมต่อฐานข้อมูลไม่ได้");
		mysqli_query($conn, "SET NAMES utf8");
?>