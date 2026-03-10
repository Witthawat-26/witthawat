<?php
session_start();
include('../db_connect.php');

// 1. เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// 2. รับค่า ID จาก URL ให้ได้ก่อน
if (!isset($_GET['id'])) {
    header("Location: index.php");
    exit();
}
$order_id = mysqli_real_escape_string($conn, $_GET['id']);

// 3. ส่วนของการอัปเดต (เมื่อมีการกดปุ่มอัปเดต)
if (isset($_POST['update_status'])) {
    // ดึงค่าจากฟอร์ม
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    // บังคับใช้ $order_id จาก URL มาทำการอัปเดต
    $sql_update = "UPDATE orders SET order_status = '$new_status' WHERE order_id = '$order_id'";
    
    if (mysqli_query($conn, $sql_update)) {
        // อัปเดตเสร็จแล้ว ให้เด้งไปหน้า index.php ทันทีเพื่อดูผลลัพธ์
        echo "<script>
                alert('อัปเดตเป็น: " . $new_status . " เรียบร้อยแล้ว!');
                window.location.href='index.php';
              </script>";
        exit();
    } else {
        echo "Error: " . mysqli_error($conn);
        exit();
    }
}

// 4. ดึงข้อมูลมาแสดงผลปกติ
$order_query = mysqli_query($conn, "SELECT o.*, u.u_fullname, u.u_email FROM orders o JOIN users u ON o.u_id = u.u_id WHERE o.order_id = '$order_id'");
$order = mysqli_fetch_assoc($order_query);
$details_query = mysqli_query($conn, "SELECT od.*, p.p_name FROM order_details od JOIN products p ON od.p_id = p.p_id WHERE od.order_id = '$order_id'");
?>
<?php
session_start();
include('../db_connect.php');

// 1. เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// 2. รับค่า ID (ลองรับทั้งจาก GET และ POST เพื่อกันพลาด)
$order_id = isset($_GET['id']) ? mysqli_real_escape_string($conn, $_GET['id']) : (isset($_POST['order_id_hidden']) ? mysqli_real_escape_string($conn, $_POST['order_id_hidden']) : '');

if ($order_id == '') {
    header("Location: index.php");
    exit();
}

// 3. --- ส่วนของการอัปเดตสถานะ --- 
if (isset($_POST['update_status'])) {
    $new_status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // ใช้ order_status และ order_id ตามรูปฐานข้อมูลเป๊ะๆ
    $sql_update = "UPDATE orders SET order_status = '$new_status' WHERE order_id = '$order_id'";
    
    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('อัปเดตสถานะสำเร็จ!'); window.location.href='order_view.php?id=$order_id';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// 4. ดึงข้อมูลมาแสดงผล
$order_query = mysqli_query($conn, "SELECT o.*, u.u_fullname, u.u_email FROM orders o JOIN users u ON o.u_id = u.u_id WHERE o.order_id = '$order_id'");
$order = mysqli_fetch_assoc($order_query);
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
                <input type="hidden" name="order_id_hidden" value="<?php echo $order_id; ?>">
                
                <label class="block text-xs font-bold text-slate-500 uppercase mb-3">สถานะคำสั่งซื้อ</label>
                <div class="flex gap-3">
                    <select name="status" class="bg-slate-800 border border-slate-700 text-sm rounded-xl px-4 py-2 outline-none focus:border-blue-500 text-white">
                        <option value="pending" <?php if($order['order_status'] == 'pending') echo 'selected'; ?>>รอดำเนินการ (Pending)</option>
                        <option value="shipped" <?php if($order['order_status'] == 'shipped') echo 'selected'; ?>>จัดส่งแล้ว (Shipped)</option>
                    </select>
                    <button type="submit" name="update_status" class="bg-blue-600 hover:bg-blue-500 px-6 py-2 rounded-xl text-sm font-bold transition">
                        อัปเดต
                    </button>
                </div>
            </form>
        </div>
        
        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <tbody class="divide-y divide-slate-800">
                    <?php while($item = mysqli_fetch_assoc($details_query)): ?>
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-8 py-5 font-bold text-slate-200"><?php echo $item['p_name']; ?></td>
                        <td class="px-8 py-5 text-center font-mono text-blue-400"><?php echo $item['quantity']; ?></td>
                        <td class="px-8 py-5 text-right font-mono text-slate-300">฿<?php echo number_format($item['price_at_time']); ?></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>