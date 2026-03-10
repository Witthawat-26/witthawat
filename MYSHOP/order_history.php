<?php
session_start();
include('db_connect.php');

if (!isset($_SESSION['u_id'])) { 
    header("Location: login.php"); 
    exit(); 
}

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
<body class="bg-[#0b0e14] text-white p-6 md:p-10">
    <div class="container mx-auto max-w-4xl">
        <div class="flex items-center justify-between mb-8">
            <h2 class="text-3xl font-black italic text-blue-500">ORDER <span class="text-white">HISTORY</span></h2>
            <a href="index.php" class="text-slate-400 hover:text-white transition"><i class="fas fa-home mr-2"></i>กลับหน้าร้าน</a>
        </div>
        
        <div class="space-y-6">
            <?php if(mysqli_num_rows($result) > 0): ?>
                <?php while($order = mysqli_fetch_assoc($result)): 
                    $order_id = $order['order_id'];
                    
                    // ดึงข้อมูลสินค้าโดยใช้ชื่อคอลัมน์ p_image ตามใน Database
                    $items_sql = "SELECT od.*, p.p_name, p.p_image 
                                  FROM order_details od 
                                  JOIN products p ON od.p_id = p.p_id 
                                  WHERE od.order_id = '$order_id'";
                    $items_result = mysqli_query($conn, $items_sql);
                ?>
                <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden hover:border-blue-500/50 transition shadow-xl">
                    <div class="bg-slate-800/50 p-6 flex justify-between items-center border-b border-slate-800">
                        <div>
                            <p class="text-[10px] text-slate-500 uppercase tracking-widest mb-1">Order ID: #<?php echo $order_id; ?></p>
                            <p class="text-lg font-bold text-blue-400"><?php echo date('d/m/Y H:i', strtotime($order['order_date'])); ?></p>
                        </div>
                        <div class="text-right">
                            <span class="px-4 py-1 rounded-full text-xs font-bold uppercase bg-blue-500/10 text-blue-400 border border-blue-500/20">
                                <?php echo $order['order_status']; ?>
                            </span>
                        </div>
                    </div>

                    <div class="p-6 space-y-4">
                        <?php while($item = mysqli_fetch_assoc($items_result)): 
                            // แก้ไข Path เป็น assets/images/
                            $img_name = $item['p_image'];
                            $img_path = "assets/images/" . $img_name;
                            
                            // ตรวจสอบว่ามีไฟล์อยู่จริงหรือไม่
                            if (!empty($img_name) && file_exists($img_path)) {
                                $display_img = $img_path;
                            } else {
                                $display_img = "https://via.placeholder.com/150?text=No+Image";
                            }
                        ?>
                        <div class="flex items-center gap-4 bg-slate-800/30 p-3 rounded-2xl border border-slate-800/50">
                            <img src="<?php echo $display_img; ?>" 
                                 alt="<?php echo $item['p_name']; ?>" 
                                 class="w-16 h-16 object-cover rounded-xl shadow-md bg-slate-700">
                            
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-200 line-clamp-1"><?php echo $item['p_name']; ?></h4>
                                <p class="text-xs text-slate-500">จำนวน: <?php echo $item['quantity']; ?> ชิ้น</p>
                            </div>
                            
                            <div class="text-right">
                                <p class="text-sm font-bold text-white">฿<?php echo number_format($item['price']); ?></p>
                            </div>
                        </div>
                        <?php endwhile; ?>
                    </div>

                    <div class="bg-slate-800/20 p-6 flex justify-between items-center border-t border-slate-800">
                        <p class="text-xs text-slate-500 max-w-[60%] line-clamp-1 italic">
                            <i class="fas fa-map-marker-alt mr-1"></i> <?php echo $order['shipping_address']; ?>
                        </p>
                        <div class="text-right">
                            <p class="text-xs text-slate-400">ราคารวมสุทธิ</p>
                            <p class="text-2xl font-black text-white">฿<?php echo number_format($order['total_price']); ?></p>
                        </div>
                    </div>
                </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="text-center py-20 bg-slate-900/50 rounded-3xl border border-dashed border-slate-800">
                    <i class="fas fa-box-open text-6xl text-slate-800 mb-4"></i>
                    <p class="text-slate-500 font-bold uppercase tracking-widest">คุณยังไม่มีประวัติการสั่งซื้อ</p>
                    <a href="index.php" class="mt-6 inline-block bg-blue-600 hover:bg-blue-500 px-8 py-3 rounded-full font-bold transition">ไปช้อปปิ้งเลย</a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>