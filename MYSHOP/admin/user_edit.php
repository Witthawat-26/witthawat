<?php
session_start();
include('../db_connect.php');

// 1. เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php");
    exit();
}

// 2. รับค่า ID จาก URL
if (!isset($_GET['id'])) {
    header("Location: user_list.php");
    exit();
}
$u_id = mysqli_real_escape_string($conn, $_GET['id']);

// 3. ส่วนของการอัปเดตข้อมูล (เมื่อกดบันทึก)
if (isset($_POST['update_user'])) {
    $fullname = mysqli_real_escape_string($conn, $_POST['u_fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['u_email']);
    $role = mysqli_real_escape_string($conn, $_POST['u_role']);
    $new_password = $_POST['new_password'];

    // เริ่มสร้างคำสั่ง SQL
    $sql_update = "UPDATE users SET u_fullname='$fullname', u_email='$email', u_role='$role'";

    // ถ้ามีการกรอกรหัสผ่านใหม่เข้ามา ให้เพิ่มการอัปเดต Password ด้วย
    if (!empty($new_password)) {
        // แนะนำให้ใช้ password_hash เพื่อความปลอดภัย แต่ถ้าโค้ดเดิมคุณใช้ MD5 หรือ Plain text ให้ปรับตามระบบเดิมนะครับ
        // ในที่นี้สมมติว่าเป็นข้อความธรรมดาตามโครงสร้างที่คุณอาจจะทำไว้เบื้องต้น
        $sql_update .= ", u_password='$new_password'";
    }

    $sql_update .= " WHERE u_id='$u_id'";

    if (mysqli_query($conn, $sql_update)) {
        echo "<script>alert('อัปเดตข้อมูลเรียบร้อยแล้ว'); window.location.href='user_list.php';</script>";
        exit();
    } else {
        echo "<script>alert('Error: " . mysqli_error($conn) . "');</script>";
    }
}

// 4. ดึงข้อมูลเดิมมาแสดงในฟอร์ม
$res = mysqli_query($conn, "SELECT * FROM users WHERE u_id = '$u_id'");
$user_data = mysqli_fetch_assoc($res);

if (!$user_data) {
    header("Location: user_list.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลผู้ใช้ #<?php echo $u_id; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white p-6 md:p-10">

    <div class="max-w-2xl mx-auto">
        <a href="user_list.php" class="text-slate-500 hover:text-white mb-6 inline-block transition">
            <i class="fas fa-arrow-left mr-2"></i> กลับหน้าจัดการลูกค้า
        </a>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl p-8 shadow-2xl">
            <h2 class="text-2xl font-black italic text-blue-500 uppercase mb-8">Edit <span class="text-white">User Info</span></h2>

            <form method="POST" class="space-y-6">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">Username (เปลี่ยนไม่ได้)</label>
                    <input type="text" value="<?php echo $user_data['u_username']; ?>" disabled 
                           class="w-full bg-slate-800/50 border border-slate-700 text-slate-400 rounded-xl px-4 py-3 outline-none cursor-not-allowed">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">ชื่อ-นามสกุล</label>
                        <input type="text" name="u_fullname" value="<?php echo $user_data['u_fullname']; ?>" required
                               class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition">
                    </div>
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase mb-2">ระดับสิทธิ์ (Role)</label>
                        <select name="u_role" class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition cursor-pointer">
                            <option value="user" <?php if($user_data['u_role'] == 'user') echo 'selected'; ?>>User (ลูกค้าทั่วไป)</option>
                            <option value="admin" <?php if($user_data['u_role'] == 'admin') echo 'selected'; ?>>Admin (ผู้ดูแลระบบ)</option>
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase mb-2">อีเมล</label>
                    <input type="email" name="u_email" value="<?php echo $user_data['u_email']; ?>" required
                           class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl px-4 py-3 outline-none focus:border-blue-500 transition">
                </div>

                <hr class="border-slate-800 my-4">

                <div>
                    <label class="block text-xs font-bold text-blue-400 uppercase mb-2">รหัสผ่านใหม่ (ปล่อยว่างถ้าไม่ต้องการเปลี่ยน)</label>
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 pl-4 flex items-center text-slate-500">
                            <i class="fas fa-lock"></i>
                        </span>
                        <input type="password" name="new_password" placeholder="ระบุรหัสผ่านใหม่ที่นี่"
                               class="w-full bg-slate-800 border border-slate-700 text-white rounded-xl pl-11 pr-4 py-3 outline-none focus:border-blue-500 transition">
                    </div>
                </div>

                <div class="pt-4">
                    <button type="submit" name="update_user" 
                            class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-2xl transition shadow-lg shadow-blue-900/20">
                        <i class="fas fa-save mr-2"></i> บันทึกการเปลี่ยนแปลง
                    </button>
                </div>
            </form>
        </div>
    </div>

</body>
</html>