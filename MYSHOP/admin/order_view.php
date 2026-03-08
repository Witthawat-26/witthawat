<?php
session_start();
include('../db_connect.php');

$order_id = $_GET['id'];

// อัปเดตสถานะถ้ามีการกดปุ่ม
if (isset($_POST['update_status'])) {
    $new_status = $_POST['status'];
    mysqli_query($conn, "UPDATE orders SET order_status = '$new_status' WHERE order_id = '$order_id'");
    echo "<script>alert('อัปเดตสถานะสำเร็จ!'); window.location.href='index.php';</script>";
}

// ดึงข้อมูลออเดอร์ + ข้อมูลลูกค้า
$order_query = mysqli_query($conn, "SELECT o.*, u.u_fullname, u.u_email FROM orders o JOIN users u ON o.u_id = u.u_id WHERE o.order_id = '$order_id'");
$order = mysqli_fetch_assoc($order_query);

// ดึงรายการสินค้าในออเดอร์ (ใช้ชื่อคอลัมน์ quantity และ price_at_time ตามที่คุณมี)
$details_query = mysqli_query($conn, "SELECT od.*, p.p_name FROM order_details od JOIN products p ON od.p_id = p.p_id WHERE od.order_id = '$order_id'");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>รายละเอียดออเดอร์ #<?php echo $order_id; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0e14] text-white p-10 font-['Kanit']">
    <div class="max-w-4xl mx-auto bg-slate-900 border border-slate-800 rounded-3xl p-8">
        <div class="flex justify-between items-start mb-8">
            <div>
                <h2 class="text-2xl font-bold text-blue-500">ORDER #<?php echo $order_id; ?></h2>
                <p class="text-slate-500"><?php echo $order['order_date']; ?></p>
            </div>
            <form method="POST" class="flex gap-2">
                <select name="status" class="bg-slate-800 border border-slate-700 rounded-lg px-3 py-2 text-sm outline-none">
                    <option value="pending" <?php if($order['order_status'] == 'pending') echo 'selected'; ?>>รอดำเนินการ</option>
                    <option value="shipped" <?php if($order['order_status'] == 'shipped') echo 'selected'; ?>>จัดส่งแล้ว</option>
                </select>
                <button type="submit" name="update_status" class="bg-blue-600 hover:bg-blue-500 px-4 py-2 rounded-lg text-sm font-bold transition">อัปเดต</button>
            </form>
        </div>

        <div class="grid grid-cols-2 gap-8 mb-8 border-y border-slate-800 py-6">
            <div>
                <h4 class="text-slate-500 uppercase text-[10px] tracking-widest mb-2">ข้อมูลลูกค้า</h4>
                <p class="font-bold"><?php echo $order['u_fullname']; ?></p>
                <p class="text-sm text-slate-400"><?php echo $order['u_email']; ?></p>
            </div>
            <div>
                <h4 class="text-slate-500 uppercase text-[10px] tracking-widest mb-2">ที่อยู่จัดส่ง</h4>
                <p class="text-sm italic text-slate-300"><?php echo $order['shipping_address']; ?></p>
            </div>
        </div>

        <table class="w-full mb-8 text-sm">
            <thead>
                <tr class="text-slate-500 border-b border-slate-800">
                    <th class="text-left py-4">รายการสินค้า</th>
                    <th class="text-center py-4">จำนวน</th>
                    <th class="text-right py-4">ราคา/ชิ้น</th>
                </tr>
            </thead>
            <tbody>
                <?php while($item = mysqli_fetch_assoc($details_query)): ?>
                <tr class="border-b border-slate-800/50">
                    <td class="py-4"><?php echo $item['p_name']; ?></td>
                    <td class="text-center py-4"><?php echo $item['quantity']; ?></td>
                    <td class="text-right py-4">฿<?php echo number_format($item['price_at_time']); ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="2" class="pt-6 text-right font-bold text-slate-400">ราคารวมทั้งสิ้น:</td>
                    <td class="pt-6 text-right font-bold text-2xl text-blue-500">฿<?php echo number_format($order['total_price']); ?></td>
                </tr>
            </tfoot>
        </table>
        
        <a href="index.php" class="text-slate-500 hover:text-white transition text-sm">← กลับไปหน้าจัดการออเดอร์</a>
    </div>
</body>
</html>