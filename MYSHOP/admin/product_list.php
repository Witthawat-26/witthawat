<?php
session_start();
include('../db_connect.php');

// เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php"); exit();
}

// ดึงข้อมูลสินค้าพร้อมชื่อหมวดหมู่
$sql = "SELECT p.*, c.cat_name FROM products p 
        LEFT JOIN categories c ON p.cat_id = c.cat_id 
        ORDER BY p.p_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการสินค้า | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white p-8">
    <div class="max-w-6xl mx-auto">
        
        <div class="mb-6">
            <a href="index.php" class="text-slate-500 hover:text-white transition flex items-center w-fit">
                <i class="fas fa-arrow-left mr-2"></i> กลับหน้าจัดการออเดอร์
            </a>
        </div>

        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black italic text-blue-500 uppercase">Product <span class="text-white">List</span></h1>
            
            <div class="flex space-x-3">
                <a href="category.php" class="bg-slate-800 border border-slate-700 hover:bg-slate-700 px-5 py-2.5 rounded-xl text-sm font-bold transition">
                    <i class="fas fa-tags mr-2 text-blue-500"></i> จัดการประเภท
                </a>
                <a href="product_add.php" class="bg-green-600 hover:bg-green-500 px-6 py-2.5 rounded-xl transition font-bold shadow-lg shadow-green-900/20">
                    <i class="fas fa-plus mr-2"></i> เพิ่มสินค้าใหม่
                </a>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-800/50 text-slate-400 text-sm uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">รูปภาพ</th>
                        <th class="px-6 py-4">ชื่อสินค้า / หมวดหมู่</th>
                        <th class="px-6 py-4">ราคา</th>
                        <th class="px-6 py-4">สต็อก</th>
                        <th class="px-6 py-4 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4">
                            <img src="../assets/images/<?php echo $row['p_image']; ?>" class="w-12 h-12 object-contain bg-slate-800 rounded-lg shadow-inner">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-200"><?php echo $row['p_name']; ?></div>
                            <div class="text-[10px] text-blue-500 uppercase font-bold tracking-tighter"><?php echo $row['cat_name']; ?></div>
                        </td>
                        <td class="px-6 py-4 font-mono text-blue-400 font-bold">฿<?php echo number_format($row['p_price']); ?></td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-xs font-bold <?php echo ($row['p_stock'] <= 5) ? 'bg-red-500/10 text-red-500 border border-red-500/20' : 'bg-slate-800 text-slate-300'; ?>">
                                <?php echo $row['p_stock']; ?> ชิ้น
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="product_edit.php?id=<?php echo $row['p_id']; ?>" class="bg-blue-600/10 text-blue-500 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition">
                                    <i class="fas fa-edit text-sm"></i>
                                </a>
                                <a href="product_delete.php?id=<?php echo $row['p_id']; ?>" class="bg-red-600/10 text-red-500 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition" onclick="return confirm('ยืนยันการลบสินค้าหรือไม่?')">
                                    <i class="fas fa-trash text-sm"></i>
                                </a>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>