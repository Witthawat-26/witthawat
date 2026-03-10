<?php
session_start();
include('../db_connect.php');

// เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// ดึงออเดอร์ทั้งหมด
$sql = "SELECT o.*, u.u_username FROM orders o 
        JOIN users u ON o.u_id = u.u_id 
        ORDER BY o.order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการออเดอร์ | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white">

    <nav class="bg-slate-900 border-b border-slate-800 mb-10">
        <div class="max-w-6xl mx-auto px-4">
            <div class="flex items-center justify-between h-16">
                <div class="flex items-center space-x-8">
                    <h1 class="text-xl font-black italic text-blue-500">PRO<span class="text-white">GAMER</span> <span class="text-[10px] ml-2 bg-blue-600 text-white px-2 py-0.5 rounded-full not-italic tracking-normal">ADMIN</span></h1>
                    
                    <div class="flex space-x-2">
                        <a href="index.php" class="bg-blue-600 text-white px-4 py-2 rounded-lg text-sm font-bold flex items-center transition">
                            <i class="fas fa-shopping-basket mr-2"></i> จัดการออเดอร์
                        </a>
                        <a href="product_list.php" class="text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-2 rounded-lg text-sm font-medium flex items-center transition">
                            <i class="fas fa-boxes mr-2"></i> จัดการสินค้า
                        </a>
                        <a href="category.php" class="text-slate-400 hover:text-white hover:bg-slate-800 px-4 py-2 rounded-lg text-sm font-medium flex items-center transition">
                            <i class="fas fa-tags mr-2"></i> จัดการประเภทสินค้า
                        </a>
                    </div>
                </div>

                <div class="flex items-center space-x-6 text-sm">
                    <a href="../index.php" class="text-slate-400 hover:text-white transition">
                        <i class="fas fa-external-link-alt mr-1"></i> ไปหน้าร้านค้า
                    </a>
                    <div class="h-4 w-[1px] bg-slate-800"></div>
                    <a href="../logout.php" class="text-red-500 hover:text-red-400 font-bold transition">
                        <i class="fas fa-sign-out-alt mr-1"></i> ออกจากระบบ
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 pb-10">
        <div class="flex justify-between items-center mb-10">
            <h2 class="text-3xl font-black italic text-blue-500 uppercase">Order <span class="text-white">Management</span></h2>
            
            <div class="flex space-x-3">
                <a href="category.php" class="bg-slate-800 border border-slate-700 hover:bg-slate-700 px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg">
                    <i class="fas fa-tags mr-2 text-blue-500"></i> จัดการประเภทสินค้า
                </a>
                <a href="product_add.php" class="bg-green-600 hover:bg-green-500 px-5 py-2.5 rounded-xl text-sm font-bold transition shadow-lg shadow-green-900/20">
                    <i class="fas fa-plus mr-2"></i> เพิ่มสินค้าใหม่
                </a>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-slate-800/50 text-slate-400 text-sm uppercase tracking-wider">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">ลูกค้า</th>
                        <th class="px-6 py-4">วันที่สั่ง</th>
                        <th class="px-6 py-4">ยอดรวม</th>
                        <th class="px-6 py-4">สถานะ</th>
                        <th class="px-6 py-4 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php if(mysqli_num_rows($result) > 0): ?>
                        <?php while($row = mysqli_fetch_assoc($result)): ?>
                        <tr class="hover:bg-slate-800/30 transition">
                            <td class="px-6 py-4 font-mono text-blue-400">#<?php echo $row['order_id']; ?></td>
                            <td class="px-6 py-4 font-bold text-slate-200"><?php echo $row['u_username']; ?></td>
                            <td class="px-6 py-4 text-sm text-slate-400"><?php echo date('d/m/Y H:i', strtotime($row['order_date'])); ?></td>
                            <td class="px-6 py-4 text-blue-500 font-black">฿<?php echo number_format($row['total_price']); ?></td>
                            <td class="px-6 py-4">
                                <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase 
                                    <?php echo ($row['order_status'] == 'pending') ? 'bg-yellow-500/10 text-yellow-500 border border-yellow-500/20' : 'bg-green-500/10 text-green-500 border border-green-500/20'; ?>">
                                    <?php echo ($row['order_status'] == 'pending') ? 'รอดำเนินการ' : 'จัดส่งแล้ว'; ?>
                                </span>
                            </td>
                            <td class="px-6 py-4 text-center">
                                <a href="order_view.php?id=<?php echo $row['order_id']; ?>" class="inline-flex items-center bg-slate-800 hover:bg-blue-600 border border-slate-700 px-4 py-2 rounded-lg text-xs transition">
                                    <i class="fas fa-eye mr-2"></i> รายละเอียด
                                </a>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="6" class="px-6 py-20 text-center text-slate-500 italic">
                                ยังไม่มีข้อมูลคำสั่งซื้อในขณะนี้
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

</body>
</html>