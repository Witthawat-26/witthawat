<?php
session_start();
include('../db_connect.php');

// เช็คสิทธิ์ Admin
if ($_SESSION['u_role'] != 'admin') { header("Location: ../index.php"); exit(); }

$cat_id = $_GET['id'];
$res = mysqli_query($conn, "SELECT * FROM categories WHERE cat_id = '$cat_id'");
$cat = mysqli_fetch_assoc($res);

// ระบบอัปเดตชื่อ
if (isset($_POST['update_category'])) {
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    $sql = "UPDATE categories SET cat_name = '$cat_name' WHERE cat_id = '$cat_id'";
    if (mysqli_query($conn, $sql)) {
        echo "<script>alert('แก้ไขสำเร็จ'); window.location.href='category.php';</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8 Spit">
    <title>แก้ไขหมวดหมู่ | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f172a] text-white flex items-center justify-center min-h-screen">
    <div class="max-w-md w-full bg-slate-900 p-8 rounded-2xl border border-slate-800">
        <h2 class="text-xl font-bold mb-6 text-blue-500">EDIT <span class="text-white">CATEGORY</span></h2>
        
        <form method="POST">
            <div class="mb-6">
                <label class="block text-slate-400 mb-2 text-sm">ชื่อหมวดหมู่</label>
                <input type="text\" name="cat_name" value="<?php echo $cat['cat_name']; ?>" 
                       class="w-full bg-slate-800 border border-slate-700 p-3 rounded-lg outline-none focus:border-blue-500" required>
            </div>
            <div class="flex gap-3">
                <button type="submit" name="update_category" class="flex-1 bg-blue-600 py-3 rounded-lg font-bold hover:bg-blue-700">บันทึก</button>
                <a href="category.php" class="flex-1 bg-slate-800 py-3 rounded-lg font-bold text-center hover:bg-slate-700">ยกเลิก</a>
            </div>
        </form>
    </div>
</body>
</html>