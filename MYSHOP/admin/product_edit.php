<?php
session_start();
include('../db_connect.php');

$p_id = $_GET['id'];
$p_sql = "SELECT * FROM products WHERE p_id = '$p_id'";
$p_res = mysqli_query($conn, $p_sql);
$p_data = mysqli_fetch_assoc($p_res);

// ดึงหมวดหมู่ทั้งหมดสำหรับ Select Box
$cat_sql = "SELECT * FROM categories";
$cat_res = mysqli_query($conn, $cat_sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขสินค้า | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0e14] text-white p-10">
    <div class="max-w-2xl mx-auto bg-slate-900 p-8 rounded-3xl border border-slate-800">
        <h2 class="text-2xl font-bold mb-8">แก้ไขข้อมูลสินค้า</h2>
        
        <form action="product_update.php" method="POST" enctype="multipart/form-data" class="space-y-5">
            <input type="hidden" name="p_id" value="<?php echo $p_data['p_id']; ?>">
            <input type="hidden" name="old_image" value="<?php echo $p_data['p_image']; ?>">

            <div>
                <label class="block text-slate-400 mb-2">ชื่อสินค้า</label>
                <input type="text" name="p_name" value="<?php echo $p_data['p_name']; ?>" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500">
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-slate-400 mb-2">ราคา (บาท)</label>
                    <input type="number" name="p_price" value="<?php echo $p_data['p_price']; ?>" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-slate-400 mb-2">จำนวนในสต็อก</label>
                    <input type="number" name="p_stock" value="<?php echo $p_data['p_stock']; ?>" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-xl outline-none focus:border-blue-500">
                </div>
            </div>

            <div>
                <label class="block text-slate-400 mb-2">หมวดหมู่</label>
                <select name="cat_id" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-xl">
                    <?php while($cat = mysqli_fetch_assoc($cat_res)): ?>
                        <option value="<?php echo $cat['cat_id']; ?>" <?php if($cat['cat_id'] == $p_data['cat_id']) echo 'selected'; ?>>
                            <?php echo $cat['cat_name']; ?>
                        </option>
                    <?php endwhile; ?>
                </select>
            </div>

            <div>
                <label class="block text-slate-400 mb-2">รูปภาพสินค้า (เว้นไว้ถ้าไม่เปลี่ยน)</label>
                <input type="file" name="p_image" class="w-full text-sm text-slate-400">
                <p class="mt-2 text-xs text-slate-500">รูปเดิม: <?php echo $p_data['p_image']; ?></p>
            </div>

            <div class="pt-5 space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-500 px-8 py-3 rounded-xl font-bold transition">บันทึกการแก้ไข</button>
                <a href="product_list.php" class="bg-slate-700 hover:bg-slate-600 px-8 py-3 rounded-xl transition inline-block">ยกเลิก</a>
            </div>
        </form>
    </div>
</body>
</html>