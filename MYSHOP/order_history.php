<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['u_id'])) { header("Location: login.php"); exit(); }

$u_id = $_SESSION['u_id'];
// ดึงข้อมูลออเดอร์เรียงจากใหม่ไปเก่า
$sql = "SELECT * FROM orders WHERE u_id = '$u_id' ORDER BY order_date DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ประวัติการสั่งซื้อ | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white p-10">
    <div class="container mx-auto max-w-4xl">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-black italic text-blue-500">ORDER <span class="text-white">HISTORY</span></h2>
            <a href="index.php" class="text-slate-400 hover:text-white"><i class="fas fa-home mr-2"></i>กลับหน้าร้าน</a>
        </div>
        
        <div class="space-y-4">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($order = mysqli_fetch_assoc($result)): ?>
                <div class="bg-slate-900 border border-slate-800 p-6 rounded-2xl flex justify-between items-center hover:border-blue-500/50 transition">
                    <div>
                        <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Order ID: #<?php echo $order['order_id']; ?></p>
                        <p class="text-lg font-bold"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
                        <p class="text-blue-500 font-black mt-2 text-xl">฿<?php echo number_format($order['total_price']); ?></p>
                    </div>
                    <div class="text-right">
                        <span class="px-4 py-1 rounded-full text-xs font-bold uppercase bg-blue-500/10 text-blue-400 border border-blue-500/20">
                            <?php echo $order['order_status']; ?>
                        </span>
                        <p class="text-xs text-slate-500 mt-4 italic"><?php echo $order['shipping_address']; ?></p>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-20 bg-slate-900/50 rounded-3xl border border-dashed border-slate-800">
                    <i class="fas fa-box-open text-6xl text-slate-800 mb-4"></i>
                    <p class="text-slate-500">คุณยังไม่มีประวัติการสั่งซื้อ</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>