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
        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black italic text-blue-500">PRODUCT <span class="text-white">LIST</span></h1>
            <a href="product_add.php" class="bg-blue-600 hover:bg-blue-500 px-6 py-2 rounded-xl transition font-bold">+ เพิ่มสินค้าใหม่</a>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-800/50 text-slate-400 text-sm uppercase">
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
                            <img src="../assets/images/<?php echo $row['p_image']; ?>" class="w-12 h-12 object-contain bg-slate-800 rounded-lg">
                        </td>
                        <td class="px-6 py-4">
                            <div class="font-bold"><?php echo $row['p_name']; ?></div>
                            <div class="text-[10px] text-blue-500 uppercase"><?php echo $row['cat_name']; ?></div>
                        </td>
                        <td class="px-6 py-4 font-mono text-blue-400">฿<?php echo number_format($row['p_price']); ?></td>
                        <td class="px-6 py-4">
                            <span class="<?php echo ($row['p_stock'] <= 5) ? 'text-red-500 font-bold' : 'text-slate-300'; ?>">
                                <?php echo $row['p_stock']; ?> ชิ้น
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center space-x-2">
                            <a href="product_edit.php?id=<?php echo $row['p_id']; ?>" class="inline-block bg-yellow-600/20 text-yellow-500 hover:bg-yellow-600 hover:text-white p-2 rounded-lg transition">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="product_delete.php?id=<?php echo $row['p_id']; ?>" class="inline-block bg-red-600/20 text-red-500 hover:bg-red-600 hover:text-white p-2 rounded-lg transition" onclick="return confirm('ยืนยันการลบสินค้าหรือไม่?')">
                                <i class="fas fa-trash"></i>
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