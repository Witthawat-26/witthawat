<?php
session_start();
include('../db_connect.php');

// เช็คสิทธิ์ Admin
if (!isset($_SESSION['u_role']) || $_SESSION['u_role'] != 'admin') {
    header("Location: ../index.php"); exit();
}

// ดึงข้อมูลผู้ใช้ทั้งหมด (ยกเว้นรหัสผ่านเพื่อความปลอดภัย)
$sql = "SELECT u_id, u_username, u_fullname, u_email, u_role FROM users ORDER BY u_id DESC";
$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <title>จัดการข้อมูลลูกค้า | Admin</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>
<body class="bg-[#0b0e14] text-white p-8">
    <div class="max-w-6xl mx-auto">
        <div class="mb-6">
            <a href="index.php" class="text-slate-500 hover:text-white transition flex items-center w-fit">
                <i class="fas fa-arrow-left mr-2"></i> กลับหน้าหลัก
            </a>
        </div>

        <div class="flex justify-between items-center mb-10">
            <h1 class="text-3xl font-black italic text-blue-500 uppercase">User <span class="text-white">Management</span></h1>
        </div>

        <div class="bg-slate-900 border border-slate-800 rounded-3xl overflow-hidden shadow-2xl">
            <table class="w-full text-left">
                <thead class="bg-slate-800/50 text-slate-400 text-sm uppercase tracking-widest">
                    <tr>
                        <th class="px-6 py-4">ID</th>
                        <th class="px-6 py-4">Username / Fullname</th>
                        <th class="px-6 py-4">Email</th>
                        <th class="px-6 py-4">Role</th>
                        <th class="px-6 py-4 text-center">จัดการ</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-800">
                    <?php while($row = mysqli_fetch_assoc($result)): ?>
                    <tr class="hover:bg-slate-800/30 transition">
                        <td class="px-6 py-4 font-mono text-blue-400">#<?php echo $row['u_id']; ?></td>
                        <td class="px-6 py-4">
                            <div class="font-bold text-slate-200"><?php echo $row['u_username']; ?></div>
                            <div class="text-xs text-slate-500"><?php echo $row['u_fullname']; ?></div>
                        </td>
                        <td class="px-6 py-4 text-slate-300"><?php echo $row['u_email']; ?></td>
                        <td class="px-6 py-4">
                            <span class="px-3 py-1 rounded-full text-[10px] font-bold uppercase <?php echo ($row['u_role'] == 'admin') ? 'bg-purple-500/10 text-purple-500 border border-purple-500/20' : 'bg-blue-500/10 text-blue-500 border border-blue-500/20'; ?>">
                                <?php echo $row['u_role']; ?>
                            </span>
                        </td>
                        <td class="px-6 py-4 text-center">
                            <div class="flex justify-center space-x-2">
                                <a href="user_edit.php?id=<?php echo $row['u_id']; ?>" class="bg-blue-600/10 text-blue-500 hover:bg-blue-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition">
                                    <i class="fas fa-user-edit text-sm"></i>
                                </a>
                                <?php if($row['u_id'] != $_SESSION['u_id']): // ห้ามลบตัวเอง ?>
                                <a href="user_delete.php?id=<?php echo $row['u_id']; ?>" class="bg-red-600/10 text-red-500 hover:bg-red-600 hover:text-white w-9 h-9 flex items-center justify-center rounded-lg transition" onclick="return confirm('ยืนยันการลบข้อมูลลูกค้ารายนี้หรือไม่? ข้อมูลออเดอร์ของลูกค้าอาจได้รับผลกระทบ')">
                                    <i class="fas fa-user-times text-sm"></i>
                                </a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>