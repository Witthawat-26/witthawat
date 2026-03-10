<?php
session_start();
include('../db_connect.php');

if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') { 
    header("Location: ../index.php"); exit(); 
}

// ระบบเพิ่มหมวดหมู่
if (isset($_POST['add_category'])) {
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    if(!empty($cat_name)) {
        mysqli_query($conn, "INSERT INTO categories (cat_name) VALUES ('$cat_name')");
        echo "<script>window.location.href='category.php';</script>";
    }
}

$categories = mysqli_query($conn, "SELECT * FROM categories ORDER BY cat_id DESC");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการหมวดหมู่ | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white p-8">
    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black italic text-blue-500">CATEGORY <span class="text-white">MANAGEMENT</span></h1>
            <a href="index.php" class="text-slate-400 hover:text-white"><i class="fas fa-arrow-left mr-2"></i>กลับหน้าหลัก</a>
        </div>

        <form method="POST" class="bg-slate-900 border border-slate-800 p-6 rounded-2xl mb-10 flex gap-4 shadow-xl">
            <input type="text" name="cat_name" placeholder="ชื่อประเภทสินค้าใหม่..." 
                   class="bg-slate-800 border border-slate-700 p-3 rounded-xl flex-1 outline-none focus:border-blue-500 transition" required>
            <button type="submit" name="add_category" class="bg-blue-600 hover:bg-blue-500 px-8 py-3 rounded-xl font-bold transition flex items-center">
                <i class="fas fa-plus mr-2"></i> เพิ่มประเภท
            </button>
        </form>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-slate-800/50 text-slate-400">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">ชื่อประเภทสินค้า</th>
                        <th class="px-6 py-4 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4 font-mono text-slate-500">#<?php echo $cat['cat_id']; ?></td>
                        <td class="px-6 py-4 font-bold text-lg"><?php echo $cat['cat_name']; ?></td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="category_edit.php?id=<?php echo $cat['cat_id']; ?>" 
                               class="inline-flex items-center bg-yellow-500/10 text-yellow-500 border border-yellow-500/20 hover:bg-yellow-500 hover:text-white px-4 py-2 rounded-lg text-xs transition">
                                <i class="fas fa-edit mr-1"></i> แก้ไข
                            </a>
                            <a href="category_delete.php?id=<?php echo $cat['cat_id']; ?>" 
                               class="inline-flex items-center bg-red-500/10 text-red-500 border border-red-500/20 hover:bg-red-500 hover:text-white px-4 py-2 rounded-lg text-xs transition"
                               onclick="return confirm('ยืนยันการลบประเภท: <?php echo $cat['cat_name']; ?>?')">
                                <i class="fas fa-trash mr-1"></i> ลบ
                            </a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>