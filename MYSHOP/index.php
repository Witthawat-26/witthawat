<?php 
// 1. เริ่มต้น Session และเชื่อมต่อฐานข้อมูล
session_start(); 
include('db_connect.php'); 

// 2. รับค่าการค้นหาและหมวดหมู่
$search = isset($_GET['search']) ? mysqli_real_escape_string($conn, $_GET['search']) : "";
$cat_id = isset($_GET['cat_id']) ? mysqli_real_escape_string($conn, $_GET['cat_id']) : "";

// 3. สร้างคำสั่ง SQL แบบ Dynamic (Requirement 1.1, 1.4)
$sql = "SELECT p.*, c.cat_name FROM products p 
        LEFT JOIN categories c ON p.cat_id = c.cat_id 
        WHERE 1=1"; // ใช้ 1=1 เพื่อให้ง่ายต่อการต่อ String query

if ($search != "") {
    $sql .= " AND (p.p_name LIKE '%$search%' OR c.cat_name LIKE '%$search%')";
}

if ($cat_id != "") {
    $sql .= " AND p.cat_id = '$cat_id'";
}

$sql .= " ORDER BY p.p_id DESC";
$result = mysqli_query($conn, $sql);

// 4. ดึงหมวดหมู่ทั้งหมดมาทำปุ่มกด
$sql_cats = "SELECT * FROM categories";
$res_cats = mysqli_query($conn, $sql_cats);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PROGAMER | Ultimate Gaming Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@300;400;700;900&display=swap" rel="stylesheet">
    <style>
        body { background-color: #0b0e14; color: #e2e8f0; font-family: 'Kanit', sans-serif; }
        .neon-glow:hover { border-color: #3b82f6; box-shadow: 0 0 20px rgba(59, 130, 246, 0.3); }
        .scrollbar-hide::-webkit-scrollbar { display: none; }
        ::-webkit-scrollbar { width: 8px; }
        ::-webkit-scrollbar-track { background: #0b0e14; }
        ::-webkit-scrollbar-thumb { background: #1e293b; border-radius: 10px; }
    </style>
</head>
<body>

    <nav class="bg-slate-900/90 backdrop-blur-md sticky top-0 z-50 border-b border-slate-800 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <a href="index.php">
                <h1 class="text-3xl font-black text-blue-500 italic tracking-tighter">PRO<span class="text-white">GAMER</span></h1>
            </a>
            
            <div class="hidden md:flex flex-1 mx-10">
                <form action="index.php" method="GET" class="w-full flex">
                    <input type="text" name="search" value="<?php echo $search; ?>" placeholder="ค้นหาเกมมิ่งเกียร์..." 
                           class="w-full bg-slate-800 border border-slate-700 px-4 py-2 rounded-l-lg focus:outline-none focus:border-blue-500 text-white text-sm">
                    <button type="submit" class="bg-blue-600 px-6 rounded-r-lg hover:bg-blue-700 transition"><i class="fas fa-search text-sm"></i></button>
                </form>
            </div>

            <div class="flex items-center space-x-6">
                <a href="cart.php" class="relative group p-2">
                    <i class="fas fa-shopping-cart text-2xl text-slate-300 group-hover:text-blue-500 transition"></i>
                    <?php 
                        $cart_count = (isset($_SESSION['cart'])) ? count($_SESSION['cart']) : 0;
                        if ($cart_count > 0): 
                    ?>
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] font-bold px-1.5 py-0.5 rounded-full min-w-[18px] h-[18px] flex items-center justify-center border-2 border-[#0b0e14] animate-bounce">
                            <?php echo $cart_count; ?>
                        </span>
                    <?php endif; ?>
                </a>

                <?php if (isset($_SESSION['u_id'])): ?>
                    <div class="flex items-center space-x-4 border-l border-slate-700 pl-6">
                        <div class="text-right hidden sm:block text-xs">
                            <p class="text-slate-400">Welcome,</p>
                            <p class="font-bold text-blue-400"><?php echo $_SESSION['u_username']; ?></p>
                        </div>
                        <div class="group relative py-2"> 
                            <div class="flex items-center cursor-pointer">
                                <i class="fas fa-user-circle text-2xl"></i>
                                <i class="fas fa-chevron-down text-[10px] ml-1 text-slate-500 transition-transform group-hover:rotate-180"></i>
                            </div>
                            <div class="absolute right-0 top-full w-48 pt-2 invisible opacity-0 group-hover:visible group-hover:opacity-100 transition-all duration-200 z-[60]">
                                <div class="bg-slate-900 border border-slate-800 rounded-xl shadow-2xl overflow-hidden">
                                    <a href="profile.php" class="block px-4 py-3 hover:bg-slate-800 text-sm transition"><i class="fas fa-user-edit mr-3"></i> แก้ไขข้อมูลส่วนตัว</a>
                                    <a href="order_history.php" class="block px-4 py-3 hover:bg-slate-800 text-sm transition"><i class="fas fa-history mr-3"></i> ประวัติการสั่งซื้อ</a>
                                    <?php if($_SESSION['u_role'] == 'admin'): ?>
                                        <a href="admin/index.php" class="block px-4 py-3 hover:bg-blue-900/50 text-sm font-bold text-blue-400 border-t border-slate-800"><i class="fas fa-tools mr-3"></i> ระบบหลังร้าน</a>
                                    <?php endif; ?>
                                    <a href="logout.php" class="block px-4 py-3 bg-red-900/10 hover:bg-red-900/30 text-sm text-red-500 font-bold border-t border-slate-800 transition"><i class="fas fa-sign-out-alt mr-3"></i> ออกจากระบบ</a>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="flex items-center space-x-3">
                        <a href="login.php" class="text-xs font-bold hover:text-blue-400 transition">LOG IN</a>
                        <a href="register.php" class="bg-blue-600 px-5 py-2 rounded-full text-xs font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-900/20">JOIN NOW</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <div class="container mx-auto mt-8 px-4">
        <div class="flex items-center space-x-3 overflow-x-auto scrollbar-hide py-2">
            <a href="index.php" 
               class="px-6 py-2 rounded-full text-xs font-bold transition-all border <?php echo ($cat_id == '') ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-900/40' : 'bg-slate-900 border-slate-800 text-slate-400 hover:border-blue-500'; ?>">
               ทั้งหมด
            </a>
            <?php while($cat = mysqli_fetch_assoc($res_cats)): ?>
                <a href="index.php?cat_id=<?php echo $cat['cat_id']; ?><?php echo ($search != '') ? '&search='.$search : ''; ?>" 
                   class="px-6 py-2 rounded-full text-xs font-bold transition-all border <?php echo ($cat_id == $cat['cat_id']) ? 'bg-blue-600 border-blue-600 text-white shadow-lg shadow-blue-900/40' : 'bg-slate-900 border-slate-800 text-slate-400 hover:border-blue-500'; ?>">
                   <?php echo $cat['cat_name']; ?>
                </a>
            <?php endwhile; ?>
        </div>
    </div>

    <main class="container mx-auto mt-10 px-4 mb-20">
        
        <div class="flex justify-between items-end mb-8 border-l-4 border-blue-500 pl-4">
            <div>
                <h2 class="text-3xl font-black italic tracking-tight">EXPLORE <span class="text-blue-500">GEAR</span></h2>
                <p class="text-slate-500 text-xs uppercase tracking-widest mt-1">
                    <?php 
                        if($cat_id != "") { echo "แสดงสินค้าในหมวดหมู่ที่เลือก"; }
                        elseif($search != "") { echo "ผลการค้นหาสำหรับ: " . htmlspecialchars($search); }
                        else { echo "สินค้ามาใหม่ล่าสุด"; }
                    ?>
                </p>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
            <?php if (mysqli_num_rows($result) > 0): ?>
                <?php while($product = mysqli_fetch_assoc($result)): ?>
                <div class="neon-glow bg-slate-900 rounded-2xl border border-slate-800 overflow-hidden group transition-all duration-300 flex flex-col h-full">
                    <div class="h-56 bg-slate-800/30 flex items-center justify-center p-8 relative overflow-hidden">
                        <img src="assets/images/<?php echo $product['p_image']; ?>" 
                             class="object-contain h-full w-full group-hover:scale-110 transition-transform duration-500"
                             onerror="this.src='https://via.placeholder.com/300x300?text=No+Image'">
                        <div class="absolute top-3 left-3 bg-blue-600/90 backdrop-blur-sm text-[10px] font-black px-3 py-1 rounded-full uppercase tracking-tighter">
                            <?php echo $product['cat_name']; ?>
                        </div>
                    </div>
                    
                    <div class="p-6 flex flex-col flex-grow">
                        <a href="product-detail.php?id=<?php echo $product['p_id']; ?>">
                            <h4 class="font-bold text-lg mb-2 hover:text-blue-400 transition line-clamp-1"><?php echo $product['p_name']; ?></h4>
                        </a>
                        <p class="text-slate-500 text-xs mb-6 line-clamp-2 leading-relaxed italic">
                            <?php echo $product['p_detail']; ?>
                        </p>
                        
                        <div class="mt-auto flex justify-between items-center">
                            <div>
                                <p class="text-[10px] text-slate-500 uppercase font-bold">Price</p>
                                <span class="text-2xl font-black text-white italic">฿<?php echo number_format($product['p_price']); ?></span>
                            </div>
                            <form action="cart_add.php" method="POST">
                                <input type="hidden" name="p_id" value="<?php echo $product['p_id']; ?>">
                                <button type="submit" class="bg-blue-600 hover:bg-blue-400 text-white w-12 h-12 rounded-2xl flex items-center justify-center transition shadow-lg shadow-blue-900/20 active:scale-90">
                                    <i class="fas fa-cart-plus text-lg"></i>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-span-full py-32 text-center bg-slate-900/50 rounded-3xl border border-dashed border-slate-800">
                    <div class="w-20 h-20 bg-slate-800 rounded-full flex items-center justify-center mx-auto mb-6">
                        <i class="fas fa-search text-3xl text-slate-600"></i>
                    </div>
                    <h3 class="text-xl font-bold">ไม่พบสินค้า</h3>
                    <p class="text-slate-500 mt-2 text-sm">ลองค้นหาด้วยคำอื่น หรือเลือกหมวดหมู่อื่นดูนะ</p>
                    <a href="index.php" class="bg-blue-600 px-8 py-3 rounded-full text-xs font-bold mt-8 inline-block hover:bg-blue-500 transition">ดูสินค้าทั้งหมด</a>
                </div>
            <?php endif; ?>
        </div>
    </main>

    <footer class="bg-slate-950 border-t border-slate-900 py-12 text-center">
        <div class="container mx-auto px-4">
            <h2 class="text-2xl font-black text-blue-500 italic mb-4">PRO<span class="text-white">GAMER</span></h2>
            <p class="text-slate-500 text-xs max-w-md mx-auto leading-relaxed mb-8">
                ศูนย์รวมอุปกรณ์เกมมิ่งเกียร์ระดับพรีเมียม สำหรับเกมเมอร์ตัวจริงที่ต้องการความเป็นหนึ่งในทุกการแข่งขัน
            </p>
            <p class="text-slate-700 text-[10px] uppercase tracking-[0.2em]">&copy; 2026 PROGAMER GEAR STORE. BUILD FOR GLORY.</p>
        </div>
    </footer>

</body>
</html>