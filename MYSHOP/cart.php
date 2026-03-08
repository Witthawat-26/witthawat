<?php
session_start();
include('db_connect.php');

// ระบบลบสินค้าออกจากตะกร้า
if (isset($_GET['remove'])) {
    $remove_id = $_GET['remove'];
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>ตะกร้าสินค้า | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white">

    <div class="container mx-auto mt-10 px-4">
        <h2 class="text-3xl font-bold mb-8 italic text-blue-500">YOUR <span class="text-white">CART</span></h2>

        <?php if (!empty($_SESSION['cart'])): ?>
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-10">
                <div class="lg:col-span-2 space-y-4">
                    <?php 
                    $total_price = 0;
                    foreach ($_SESSION['cart'] as $p_id => $qty): 
                        $sql = "SELECT * FROM products WHERE p_id = '$p_id'";
                        $result = mysqli_query($conn, $sql);
                        $product = mysqli_fetch_assoc($result);
                        $subtotal = $product['p_price'] * $qty;
                        $total_price += $subtotal;
                    ?>
                    <div class="bg-slate-900 p-4 rounded-xl border border-slate-800 flex items-center">
                        <img src="assets/images/<?php echo $product['p_image']; ?>" class="w-20 h-20 object-contain bg-slate-800 rounded-lg p-2">
                        <div class="ml-6 flex-1">
                            <h4 class="font-bold text-lg"><?php echo $product['p_name']; ?></h4>
                            <p class="text-blue-400 font-bold">฿<?php echo number_format($product['p_price']); ?> x <?php echo $qty; ?></p>
                        </div>
                        <div class="text-right">
                            <p class="font-bold text-xl mb-2">฿<?php echo number_format($subtotal); ?></p>
                            <a href="cart.php?remove=<?php echo $p_id; ?>" class="text-red-500 hover:text-red-400 text-sm"><i class="fas fa-trash"></i> ลบออก</a>
                        </div>
                    </div>
                    <?php endforeach; ?>
                </div>

                <div class="bg-slate-900 p-6 rounded-2xl border border-blue-500/30 h-fit">
                    <h3 class="text-xl font-bold mb-6 border-b border-slate-800 pb-4">สรุปการสั่งซื้อ</h3>
                    <div class="flex justify-between mb-4">
                        <span class="text-slate-400">ราคารวม</span>
                        <span class="text-xl font-bold">฿<?php echo number_format($total_price); ?></span>
                    </div>
                    <div class="flex justify-between mb-8">
                        <span class="text-slate-400">ค่าจัดส่ง</span>
                        <span class="text-green-400 font-bold">ฟรี</span>
                    </div>
                    <hr class="border-slate-800 mb-6">
                    <div class="flex justify-between mb-8">
                        <span class="text-lg">ยอดชำระสุทธิ</span>
                        <span class="text-3xl font-black text-blue-500">฿<?php echo number_format($total_price); ?></span>
                    </div>
                    
                    <a href="checkout.php" class="block w-full bg-blue-600 text-center py-4 rounded-xl font-bold text-lg hover:bg-blue-700 transition shadow-lg shadow-blue-900/40">
                        ดำเนินการสั่งซื้อ
                    </a>
                    <a href="index.php" class="block text-center mt-4 text-slate-500 hover:text-white text-sm">เลือกซื้อสินค้าต่อ</a>
                </div>
            </div>
        <?php else: ?>
            <div class="text-center py-20 bg-slate-900 rounded-3xl border border-dashed border-slate-700">
                <i class="fas fa-shopping-cart text-6xl text-slate-800 mb-6"></i>
                <p class="text-xl text-slate-500 mb-8">ตะกร้าของคุณยังว่างเปล่า...</p>
                <a href="index.php" class="bg-blue-600 px-10 py-3 rounded-full font-bold hover:bg-blue-700 transition">เริ่มช้อปปิ้งเลย</a>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>