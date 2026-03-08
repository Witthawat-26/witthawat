<?php session_start(); ?>
<!DOCTYPE html>
<html>
<head>
    <title>Login | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0e14] text-white flex items-center justify-center min-h-screen">
    <div class="w-full max-w-md p-8 bg-slate-900 rounded-2xl border border-slate-800">
        <h2 class="text-3xl font-bold text-center mb-8 text-blue-500">LOGIN</h2>
        <form action="login_db.php" method="POST" class="space-y-6">
            <div>
                <label class="block mb-2 text-sm">Username</label>
                <input type="text" name="username" class="w-full p-3 bg-slate-800 rounded-lg border border-slate-700 focus:border-blue-500 outline-none" required>
            </div>
            <div>
                <label class="block mb-2 text-sm">Password</label>
                <input type="password" name="password" class="w-full p-3 bg-slate-800 rounded-lg border border-slate-700 focus:border-blue-500 outline-none" required>
            </div>
            <button type="submit" name="login_user" class="w-full bg-blue-600 py-3 rounded-lg font-bold hover:bg-blue-700 transition shadow-lg shadow-blue-900/40">เข้าสู่ระบบ</button>
        </form>
        <p class="mt-6 text-center text-slate-400 text-sm">ยังไม่มีบัญชี? <a href="register.php" class="text-blue-400 hover:underline">สมัครสมาชิกที่นี่</a></p>
    </div>
</body>
</html>