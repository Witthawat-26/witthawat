<?php
session_start();
include('../db_connect.php');

// เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// ดึงหมวดหมู่สินค้ามาแสดงใน Dropdown (Requirement 2.2)
$cat_query = mysqli_query($conn, "SELECT * FROM categories");
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>เพิ่มสินค้าใหม่ | PROGAMER Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0f172a] text-white p-10">

    <div class="max-w-2xl mx-auto bg-slate-900 p-8 rounded-2xl border border-slate-800">
        <div class="flex justify-between items-center mb-8">
            <h2 class="text-2xl font-bold text-blue-500">ADD <span class="text-white">NEW PRODUCT</span></h2>
            <a href="index.php" class="text-slate-400 hover:text-white">ยกเลิก</a>
        </div>

        <form action="product_save.php" method="POST" enctype="multipart/form-data" class="space-y-6">
            <div>
                <label class="block text-sm text-slate-400 mb-2">ชื่อสินค้า</label>
                <input type="text" name="p_name" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-lg outline-none focus:border-blue-500" required>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-sm text-slate-400 mb-2">ราคา (บาท)</label>
                    <input type="number" name="p_price" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-lg outline-none focus:border-blue-500" required>
                </div>
                <div>
                    <label class="block text-sm text-slate-400 mb-2">จำนวนในสต็อก</label>
                    <input type="number" name="p_stock" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-lg outline-none focus:border-blue-500" required>
                </div>
            </div>

            <div>
                <label class="block text-sm text-slate-400 mb-2">หมวดหมู่สินค้า</label>
                <select name="cat_id" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-lg outline-none focus:border-blue-500">
                    <?php while($cat = mysqli_fetch_assoc($cat_query)) { ?>
                        <option value="<?php echo $cat['cat_id']; ?>"><?php echo $cat['cat_name']; ?></option>
                    <?php } ?>
                </select>
            </div>

            <div>
                <label class="block text-sm text-slate-400 mb-2">รายละเอียดสินค้า</label>
                <textarea name="p_detail" rows="4" class="w-full bg-slate-800 border border-slate-700 p-3 rounded-lg outline-none focus:border-blue-500"></textarea>
            </div>

            <div>
                <label class="block text-sm text-slate-400 mb-2">รูปภาพสินค้า</label>
                <input type="file" name="p_image" class="w-full text-slate-400 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-blue-600 file:text-white hover:file:bg-blue-700" required>
            </div>

            <button type="submit" name="save_product" class="w-full bg-blue-600 py-4 rounded-xl font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-900/40">
                บันทึกข้อมูลสินค้า
            </button>
        </form>
    </div>

</body>
</html>