<?php
session_start();
include('../db_connect.php');

// เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

$order_id = mysqli_real_escape_string($conn, $_GET['id']);

// --- ส่วนของการอัปเดตสถานะ (แก้ไขจุดนี้) ---
if (isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    $sql_update = "UPDATE orders SET order_status = '$new_status' WHERE order_id = '$order_id'";
    
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('อัปเดตสถานะสำเร็จ!'); window.location.href='index.php';</script>";
        exit();
    } else {
        echo "<script>alert('เกิดข้อผิดพลาด: " . mysqli_error($conn) . "');</script>";
    }
}

// ดึงข้อมูลออเดอร์ + ข้อมูลลูกค้า
$order_query = mysqli_query($conn, "SELECT o.*, u.u_fullname, u.u_email FROM orders o JOIN users u ON o.u_id = u.u_id WHERE o.order_id = '$order_id'");
$order = mysqli_fetch_assoc($order_query);

// ดึงรายการสินค้าในออเดอร์
$details_query = mysqli_query($conn, "SELECT od.*, p.p_name FROM order_details od JOIN products p ON od.p_id = p.p_id WHERE od.order_id = '$order_id'");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดออเดอร์ #<?php echo $order_id; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white p-10">

    <div class="max-w-4xl mx-auto">
        <div class="flex justify-between items-center mb-10">
            <div>
                <a href="index.php" class="text-slate-500 hover:text-white mb-4 inline-block transition">
                    <i class="fas fa-arrow-left mr-2"></i> กลับหน้าจัดการออเดอร์
                </a>
                <h2 class="text-3xl font-black italic text-blue-500 uppercase">Order <span class="text-white">Details</span></h2>
                <p class="text-slate-500 font-mono mt-2">ID: #<?php echo $order_id; ?></p>
            </div>

            <form method="POST" class="bg-slate-900 p-6 rounded-2xl border border-slate-800 shadow-xl">
                <label class="block text-xs font-bold text-slate-500 uppercase mb-3">สถานะคำสั่งซื้อ</label>
                <div class="flex gap-3">
                    <select name="status" class="bg-slate-800 border border-slate-700 text-sm rounded-xl px-4 py-2 outline-none focus:border-blue-500">
                        <option value="pending" <?php if($order['order_status'] == 'pending') echo 'selected'; ?>>รอดำเนินการ (Pending)</option>
                        <option value="shipped" <?php if($order['order_status'] == 'shipped') echo 'selected'; ?>>จัดส่งแล้ว (Shipped)</option>
                    </select>
                    <button type="submit" name="update_status" class="bg-blue-600 hover:bg-blue-500 px-6 py-2 rounded-xl text-sm font-bold transition">
                        อัปเดต
                    </button>
                </div>
            </form>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
            <div class="bg-slate-900/50 p-8 rounded-3xl border border-slate-800">
                <h3 class="text-slate-500 text-xs font-bold uppercase mb-4 tracking-widest">ข้อมูลลูกค้า</h3>
                <p class="text-xl font-bold mb-1"><?php echo $order['u_fullname']; ?></p>
                <p class="text-slate-400 text-sm"><?php echo $order['u_email']; ?></p>
            </div>
            <div class="bg-slate-900/50 p-8 rounded-3xl border border-slate-800">
                <h3 class="text-slate-500 text-xs font-bold uppercase mb-4 tracking-widest">ที่อยู่จัดส่ง</h3>
                <p class="italic text-slate-300"><?php echo $order['shipping_address']; ?></p>
            </div>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-slate-800/50 text-slate-400 text-xs uppercase tracking-wider">
                    <tr>
                        <th class="px-8 py-4">รายการสินค้า</th>
                        <th class="px-8 py-4 text-center">จำนวน</th>
                        <th class="px-8 py-4 text-right">ราคา/ชิ้น</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php while($item = mysqli_fetch_assoc($details_query)): ?>
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-8 py-5 font-bold text-slate-200"><?php echo $item['p_name']; ?></td>
                        <td class="px-8 py-5 text-center font-mono text-blue-400"><?php echo $item['quantity']; ?></td>
                        <td class="px-8 py-5 text-right font-mono text-slate-300">฿<?php echo number_format($item['price_at_time']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
                <tfoot class="bg-slate-800/20">
                    <tr>
                        <td colspan="2" class="px-8 py-6 text-right font-bold text-slate-400 uppercase tracking-widest">ราคารวมทั้งสิ้น:</td>
                        <td class="px-8 py-6 text-right font-black text-3xl text-blue-500">฿<?php echo number_format($order['total_price']); ?></td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>

</body>
</html>