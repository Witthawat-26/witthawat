<?php 
session_start();
include('db_connect.php');

// 1. รับ ID สินค้าจาก URL
if (isset($_GET['id'])) {
    $p_id = mysqli_real_escape_string($conn, $_GET['id']);
    
    // 2. ดึงข้อมูลสินค้าชิ้นนั้นจาก Database
    $sql = "SELECT p.*, c.cat_name FROM products p 
            LEFT JOIN categories c ON p.cat_id = c.cat_id 
            WHERE p.p_id = '$p_id'";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);

    // ถ้าไม่พบสินค้าให้กลับหน้าแรก
    if (!$product) { header("Location: index.php"); exit(); }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title><?php echo $product['p_name']; ?> | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white min-h-screen">

    <div class="container mx-auto mt-20 px-4">
        <a href="index.php" class="inline-block mb-8 text-slate-400 hover:text-white transition">
            <i class="fas fa-arrow-left mr-2"></i> กลับไปหน้าร้าน
        </a>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-12 bg-slate-900/50 p-8 rounded-3xl border border-slate-800">
            <div class="bg-slate-800/30 rounded-2xl p-10 flex items-center justify-center border border-slate-800">
                <img src="assets/images/<?php echo $product['p_image']; ?>" 
                     class="max-h-[400px] object-contain drop-shadow-[0_0_30px_rgba(59,130,246,0.2)]"
                     onerror="this.src='https://via.placeholder.com/500x500?text=No+Image'">
            </div>

            <div class="flex flex-col justify-center">
                <span class="text-blue-500 font-bold tracking-widest uppercase text-sm mb-2"><?php echo $product['cat_name']; ?></span>
                <h1 class="text-4xl font-black mb-4"><?php echo $product['p_name']; ?></h1>
                
                <div class="flex items-center mb-6 text-yellow-500">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                    <span class="ml-2 text-slate-400 text-sm">(Review 4.5)</span>
                </div>

                <p class="text-slate-400 leading-relaxed mb-8 text-lg">
                    <?php echo nl2br($product['p_detail']); ?>
                </p>

                <div class="flex items-center space-x-10 mb-10 border-y border-slate-800 py-6">
                    <div>
                        <p class="text-slate-500 text-sm mb-1">ราคาปัจจุบัน</p>
                        <p class="text-4xl font-black text-blue-500">฿<?php echo number_format($product['p_price']); ?></p>
                    </div>
                    <div>
                        <p class="text-slate-500 text-sm mb-1">สถานะสต็อก</p>
                        <p class="text-lg font-bold <?php echo ($product['p_stock'] > 0) ? 'text-green-500' : 'text-red-500'; ?>">
                            <i class="fas fa-check-circle mr-1"></i> <?php echo ($product['p_stock'] > 0) ? 'มีสินค้าพร้อมส่ง' : 'สินค้าหมด'; ?>
                        </p>
                    </div>
                </div>

                <form action="cart_add.php" method="POST">
                    <input type="hidden" name="p_id" value="<?php echo $product['p_id']; ?>">
                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-500 py-5 rounded-2xl font-bold text-xl transition shadow-xl shadow-blue-900/20 flex items-center justify-center space-x-4">
                        <i class="fas fa-shopping-basket"></i>
                        <span>หยิบลงตะกร้าสินค้า</span>
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>
</html>