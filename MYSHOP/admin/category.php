<?php
session_start();
include('../db_connect.php');

// เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') { 
    header("Location: ../index.php"); 
    exit(); 
}

// ระบบเพิ่มหมวดหมู่ (Requirement 2.2.2)
if (isset($_POST['add_category'])) {
    $cat_name = mysqli_real_escape_string($conn, $_POST['cat_name']);
    if (!empty($cat_name)) {
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
    <title>จัดการหมวดหมู่ | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0f172a] text-white flex">
    <main class="flex-1 p-10">
        <h2 class="text-2xl font-bold mb-8 text-blue-500">MANAGE <span class="text-white">CATEGORIES</span></h2>

        <form method="POST" class="mb-10 flex gap-4">
            <input type="text" name="cat_name" placeholder="ชื่อหมวดหมู่ใหม่..." class="bg-slate-800 border border-slate-700 p-3 rounded-lg flex-1 outline-none focus:border-blue-500" required>
            <button type="submit" name="add_category" class="bg-blue-600 px-8 py-3 rounded-lg font-bold hover:bg-blue-700 transition">เพิ่ม</button>
        </form>

        <table class="w-full bg-slate-900 rounded-xl overflow-hidden">
            <thead class="bg-slate-800 text-slate-400">
                <tr>
                    <th class="p-4 text-left">ID</th>
                    <th class="p-4 text-left">ชื่อหมวดหมู่</th>
                    <th class="p-4 text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php while($cat = mysqli_fetch_assoc($categories)): ?>
                <tr class="border-b border-slate-800 hover:bg-slate-800/50 transition">
                    <td class="p-4"><?php echo $cat['cat_id']; ?></td>
                    <td class="p-4 font-bold"><?php echo $cat['cat_name']; ?></td>
                    <td class="p-4 text-center">
                        <a href="category_edit.php?id=<?php echo $cat['cat_id']; ?>" 
                           class="inline-block text-yellow-500 mx-2 hover:text-yellow-400 transition">
                            <i class="fas fa-edit mr-1"></i> แก้ไข
                        </a>
                        
                        <a href="category_delete.php?id=<?php echo $cat['cat_id']; ?>" 
                           class="inline-block text-red-500 mx-2 hover:text-red-400 transition" 
                           onclick="return confirm('ยืนยันการลบหมวดหมู่ <?php echo $cat['cat_name']; ?>? (สินค้าในหมวดนี้อาจได้รับผลกระทบ)')">
                            <i class="fas fa-trash mr-1"></i> ลบ
                        </a>
                    </td>
                </tr>
                <?php endwhile; ?>
                
                <?php if(mysqli_num_rows($categories) == 0): ?>
                <tr>
                    <td colspan="3" class="p-10 text-center text-slate-500 italic">ยังไม่มีข้อมูลหมวดหมู่สินค้า</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
        
        <div class="mt-8">
            <a href="product_list.php" class="text-slate-400 hover:text-white transition">
                <i class="fas fa-arrow-left mr-2"></i> กลับไปหน้าจัดการสินค้า
            </a>
        </div>
    </main>
</body>
</html>