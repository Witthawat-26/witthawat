<?php
session_start();
include('db_connect.php');

// ตรวจสอบว่ามี order_id ส่งมาไหม
if(!isset($_GET['order_id'])) { header("Location: index.php"); exit(); }

$order_id = mysqli_real_escape_string($conn, $_GET['order_id']);
$sql = "SELECT * FROM orders WHERE order_id = '$order_id'";
$res = mysqli_query($conn, $sql);
$order = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ชำระเงินด้วย QR Code | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white flex items-center justify-center min-h-screen p-4">

    <div class="max-w-md w-full bg-slate-900 rounded-[2rem] border border-slate-800 p-8 shadow-2xl relative overflow-hidden">
        <div class="absolute -top-10 -right-10 w-32 h-32 bg-blue-600/10 rounded-full blur-3xl"></div>
        
        <div class="text-center relative z-10">
            <h2 class="text-2xl font-black italic text-blue-500 mb-1">PRO<span class="text-white">PAYMENT</span></h2>
            <p class="text-slate-500 text-xs uppercase tracking-widest mb-6">Order ID: #<?php echo $order_id; ?></p>

            <div class="bg-white p-6 rounded-3xl mb-6 inline-block shadow-inner">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PAY-TO-PROGAMER-<?php echo $order['total_price']; ?>" 
                     alt="PromptPay QR Code" class="w-56 h-56">
                <div class="mt-4 flex items-center justify-center space-x-2">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c5/PromptPay-logo.png" class="h-6" alt="PromptPay">
                </div>
            </div>

            <div class="bg-slate-800/50 rounded-2xl p-4 mb-8">
                <p class="text-slate-400 text-[10px] uppercase font-bold mb-1">ยอดชำระที่ต้องโอน</p>
                <p class="text-4xl font-black text-white italic">฿<?php echo number_format($order['total_price'], 2); ?></p>
            </div>

            <div class="space-y-3">
                <a href="order_history.php" class="block w-full bg-blue-600 hover:bg-blue-500 py-4 rounded-xl font-bold transition-all transform active:scale-95 shadow-lg shadow-blue-900/20">
                    <i class="fas fa-check-circle mr-2"></i> ฉันโอนเงินแล้ว
                </a>
                <p class="text-[10px] text-slate-500 leading-relaxed px-4">
                    * กรุณาเก็บหลักฐานการโอนเงินไว้เพื่อแจ้งแอดมินในกรณีที่สถานะไม่อัปเดต
                </p>
            </div>
        </div>
    </div>

</body>
</html>