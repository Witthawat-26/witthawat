<?php
session_start();
include('db_connect.php');

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

    <div class="max-w-md w-full bg-slate-900 rounded-[2rem] border border-slate-800 p-8 shadow-2xl">
        <div class="text-center">
            <h2 class="text-2xl font-black italic text-blue-500 mb-1">PRO<span class="text-white">PAYMENT</span></h2>
            <p class="text-slate-500 text-xs uppercase tracking-widest mb-6">Order ID: #<?php echo $order_id; ?></p>

            <div class="bg-white p-6 rounded-3xl mb-6 inline-block shadow-inner">
                <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=PROGAMER-PAY-<?php echo $order['total_price']; ?>" class="w-56 h-56">
                <div class="mt-4 flex items-center justify-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c5/PromptPay-logo.png" class="h-6">
                </div>
            </div>

            <div class="bg-slate-800/50 rounded-2xl p-4 mb-8 text-center">
                <p class="text-slate-400 text-[10px] uppercase font-bold">ยอดชำระสุทธิ</p>
                <p class="text-4xl font-black text-white italic">฿<?php echo number_format($order['total_price'], 2); ?></p>
            </div>

            <form action="payment_db.php" method="POST" enctype="multipart/form-data" class="space-y-5">
                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                
                <div class="text-left">
                    <label class="block text-slate-400 text-[10px] uppercase font-bold mb-2 ml-1">อัปโหลดสลิปการโอนเงิน</label>
                    <input type="file" name="slip_image" required accept="image/*"
                           class="w-full bg-slate-800 border border-slate-700 text-sm text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-500 cursor-pointer p-2 rounded-xl">
                </div>

                <button type="submit" class="w-full bg-green-600 hover:bg-green-500 py-4 rounded-xl font-bold transition-all shadow-lg shadow-green-900/20 active:scale-95">
                    <i class="fas fa-paper-plane mr-2"></i> ยืนยันการชำระเงิน
                </button>
            </form>
            
            <a href="order_history.php" class="block mt-4 text-xs text-slate-500 hover:text-white transition">ไว้แจ้งภายหลัง</a>
        </div>
    </div>

</body>
</html>