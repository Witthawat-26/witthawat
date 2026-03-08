<?php
session_start();
include('db_connect.php');

// เช็คว่า Login หรือยัง (Requirement 1.10)
if (!isset($_SESSION['u_id'])) {
    echo "<script>alert('กรุณาเข้าสู่ระบบก่อนชำระเงิน'); window.location.href='login.php';</script>";
    exit();
}

// ดึงที่อยู่เดิมของลูกค้ามาโชว์
$u_id = $_SESSION['u_id'];
$user_query = mysqli_query($conn, "SELECT * FROM users WHERE u_id = '$u_id'");
$user = mysqli_fetch_assoc($user_query);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ชำระเงิน | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0e14] text-white">
    <div class="container mx-auto mt-10 max-w-2xl p-8 bg-slate-900 rounded-2xl border border-slate-800">
        <h2 class="text-2xl font-bold mb-6 text-blue-500 italic">CHECKOUT <span class="text-white">DETAILS</span></h2>
        
        <form action="order_save.php" method="POST">
            <div class="mb-6">
                <label class="block text-slate-400 mb-2">ชื่อ-นามสกุลผู้รับ</label>
                <input type="text" value="<?php echo $user['u_fullname']; ?>" class="w-full p-3 bg-slate-800 rounded-lg border border-slate-700" readonly>
            </div>
            
            <div class="mb-6">
                <label class="block text-slate-400 mb-2">ที่อยู่จัดส่ง (แก้ไขได้)</label>
                <textarea name="shipping_address" rows="4" class="w-full p-3 bg-slate-800 rounded-lg border border-slate-700 focus:border-blue-500 outline-none" required><?php echo $user['u_address']; ?></textarea>
            </div>

            <div class="bg-slate-800 p-4 rounded-xl mb-8">
                <p class="text-sm text-slate-400">ยอดชำระสุทธิ</p>
                <p class="text-3xl font-black text-blue-500">฿<?php 
                    $total = 0;
                    foreach($_SESSION['cart'] as $id => $qty) {
                        $p_res = mysqli_query($conn, "SELECT p_price FROM products WHERE p_id = '$id'");
                        $p = mysqli_fetch_assoc($p_res);
                        $total += ($p['p_price'] * $qty);
                    }
                    echo number_format($total);
                ?></p>
            </div>

            <button type="submit" class="w-full bg-green-600 py-4 rounded-xl font-bold text-lg hover:bg-green-700 transition shadow-lg shadow-green-900/20">
                ยืนยันการสั่งซื้อ
            </button>
        </form>
    </div>
</body>
</html>