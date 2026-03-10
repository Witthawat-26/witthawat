<?php
session_start();
include('../db_connect.php');

// 1. เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// 2. รับค่า ID จาก URL
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$order_id = mysqli_real_escape_string($conn, $_GET['id']);

// 3. ส่วนของการอัปเดตสถานะ (Process Update)
if (isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // อัปเดตข้อมูลลง Database โดยอิงตาม order_id
    $sql_update = "UPDATE orders SET order_status = '$new_status' WHERE order_id = '$order_id'";
    
    if (mysqli_query($conn, $sql_update)) {
        // อัปเดตเสร็จแล้ว ให้เด้งไปหน้า index.php เพื่อดูการเปลี่ยนแปลงในตารางรวมทันที
        echo "<script>
                alert('อัปเดตสถานะเป็น " . ($new_status == 'shipped' ? 'จัดส่งแล้ว' : 'รอดำเนินการ') . " สำเร็จ!');
                window.location.href='index.php';
              </script>";
        exit();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด: " . mysqli_error($conn) . "');</script>";
    }
}

// 4. ดึงข้อมูลมาแสดงผล (Fetch Data)
// ดึงข้อมูลหลักของออเดอร์
$order_query = mysqli_query($conn, "SELECT o.*, u.u_fullname, u.u_email FROM orders o JOIN users u ON o.u_id = u.u_id WHERE o.order_id = '$order_id'");
$order = mysqli_fetch_assoc($order_query);

// ดึงรายการสินค้าในออเดอร์นี้
$details_query = mysqli_query($conn, "SELECT od.*, p.p_name FROM order_details od JOIN products p ON od.p_id = p.p_id WHERE od.order_id = '$order_id'");

// ถ้าไม่พบข้อมูลออเดอร์ให้กลับหน้าหลัก
if (!$order) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดออเดอร์ #<?php echo $order_id; ?> | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white p-6 md:p-10">

    <div class="max-w-4xl mx-auto">
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center mb-10 gap-6">
            <div>
                <a href="index.php" class="text-slate-500 hover:text-white mb-4 inline-block transition">
                    <i class="fas fa-arrow-left mr-2"></i> กลับหน้าจัดการออเดอร์
                </a>
                <h2 class="text-3xl font-black italic text-blue-500 uppercase">Order <span class="text-white">Details</span></h2>
                <p class="text-slate-500 font-mono mt-2">ORDER ID: #<?php echo $order_id; ?></p>
            </div>

            <form method="POST" class="bg-slate-900 p-6 rounded-2xl border border-slate-800 shadow-xl w-full md:w-auto">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-3">แก้ไขสถานะคำสั่งซื้อ</label>
                <div class="flex gap-3">
                    <select name="status" class="bg-slate-800 border border-slate-700 text-sm rounded-xl px-4 py-2 outline-none focus:border-blue-500 text-white cursor-pointer">
                        <option value="pending" <?php if($order['order_status'] == 'pending') echo 'selected'; ?>>รอดำเนินการ (Pending)</option>
                        <option value="shipped" <?php if($order['order_status'] == 'shipped') echo 'selected'; ?>>จัดส่งแล้ว (Shipped)</option>
                    </select>
                    <button type="submit" name="update_status" class="bg-blue-600 hover:bg-blue-500 px-6 py-2 rounded-xl text-sm font-bold transition shadow-lg shadow-blue-900/20">
                        อัปเดต
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-800">
                <p class="text-xs font-bold text-slate-500 uppercase mb-2">ข้อมูลลูกค้า</p>
                <p class="text-lg font-bold text-white"><?php echo $order['u_fullname']; ?></p>
                <p class="text-slate-400 text-sm"><?php echo $order['u_email']; ?></p>
            </div>
            <div class="bg-slate-900/50 p-6 rounded-2xl border border-slate-800">
                <p class="text-xs font-bold text-slate-500 uppercase mb-2">ที่อยู่จัดส่ง</p>
                <p class="text-slate-300 text-sm italic"><?php echo $order['shipping_address']; ?></p>
            </div>
        </div>
        
        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-slate-800/50 text-slate-400 text-xs uppercase tracking-widest">
                    <tr>
                        <th class="px-8 py-4">รายการสินค้า</th>
                        <th class="px-8 py-4 text-center">จำนวน</th>
                        <th class="px-8 py-4 text-right">ราคา/หน่วย</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php 
                    $total_calc = 0;
                    while($item = mysqli_fetch_assoc($details_query)): 
                        $total_calc += ($item['price_at_time'] * $item['quantity']);
                    ?>
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-8 py-5 font-bold text-slate-200"><?php echo $item['p_name']; ?></td>
                        <td class="px-8 py-5 text-center font-mono text-blue-400"><?php echo $item['quantity']; ?> ชิ้น</td>
                        <td class="px-8 py-5 text-right font-mono text-slate-300">฿<?php echo number_format($item['price_at_time']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot class="bg-slate-800/20">
                    <tr>
                        <td colspan="2" class="px-8 py-6 text-right font-bold text-slate-400">ราคารวมทั้งสิ้น:</td>
                        <td class="px-8 py-6 text-right font-black text-2xl text-blue-500">฿<?php echo number_format($order['total_price']); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</body>
</html>