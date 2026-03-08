<?php
session_start();
include('db_connect.php');

// เช็คว่า Login หรือยัง
if (!isset($_SESSION['u_id'])) { header("Location: login.php"); exit(); }

$u_id = $_SESSION['u_id'];
$sql = "SELECT * FROM users WHERE u_id = '$u_id'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>แก้ไขข้อมูลส่วนตัว | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-xl bg-slate-900 border border-slate-800 p-8 rounded-3xl shadow-2xl">
        <h2 class="text-2xl font-bold mb-6 flex items-center">
            <i class="fas fa-user-edit mr-3 text-blue-500"></i> แก้ไขข้อมูลส่วนตัว
        </h2>

        <form action="profile_update.php" method="POST" class="space-y-5">
            <div>
                <label class="block text-sm text-slate-500 mb-2">ชื่อผู้ใช้ (แก้ไขไม่ได้)</label>
                <input type="text" value="<?php echo $user['u_username']; ?>" disabled 
                       class="w-full bg-slate-800 border border-slate-700 p-3 rounded-xl opacity-50 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-sm text-slate-400 mb-2">ชื่อ-นามสกุล</label>
                <input type="text" name="fullname" value="<?php echo $user['u_fullname']; ?>" 
                       class="w-full bg-slate-800 border border-slate-700 p-3 rounded-xl focus:border-blue-500 outline-none" required>
            </div>

            <div>
                <label class="block text-sm text-slate-400 mb-2">อีเมล</label>
                <input type="email" name="email" value="<?php echo $user['u_email']; ?>" 
                       class="w-full bg-slate-800 border border-slate-700 p-3 rounded-xl focus:border-blue-500 outline-none" required>
            </div>

            <div>
                <label class="block text-sm text-slate-400 mb-2">ที่อยู่จัดส่ง</label>
                <textarea name="address" rows="3" 
                          class="w-full bg-slate-800 border border-slate-700 p-3 rounded-xl focus:border-blue-500 outline-none"><?php echo $user['u_address']; ?></textarea>
            </div>

            <div class="pt-4 flex gap-3">
                <button type="submit" name="update_profile" 
                        class="flex-1 bg-blue-600 hover:bg-blue-500 py-3 rounded-xl font-bold transition">
                    บันทึกการเปลี่ยนแปลง
                </button>
                <a href="index.php" class="flex-1 bg-slate-800 hover:bg-slate-700 py-3 rounded-xl font-bold text-center transition">
                    ยกเลิก
                </a>
            </div>
        </form>
    </div>

</body>
</html>