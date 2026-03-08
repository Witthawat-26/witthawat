<!DOCTYPE html>
<html lang="th">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>สมัครสมาชิก | PROGAMER</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body { background-color: #0b0e14; color: #e2e8f0; font-family: 'Kanit', sans-serif; }
        .glass { background: rgba(30, 41, 59, 0.7); backdrop-filter: blur(10px); }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">

    <div class="w-full max-w-lg glass p-8 rounded-3xl border border-slate-800 shadow-2xl">
        <div class="text-center mb-8">
            <h1 class="text-3xl font-black text-blue-500 italic tracking-tighter mb-2">PRO<span class="text-white">GAMER</span></h1>
            <h2 class="text-xl font-bold">สร้างบัญชีใหม่</h2>
            <p class="text-slate-400 text-sm">เข้าร่วมสมรภูมิช้อปปิ้งกับเรา</p>
        </div>

        <form action="register_db.php" method="POST" class="space-y-5">
            
            <div class="relative">
                <i class="fas fa-user absolute left-4 top-4 text-slate-500"></i>
                <input type="text" name="username" placeholder="ชื่อผู้ใช้ (Username)" 
                       class="w-full bg-slate-900 border border-slate-700 pl-12 pr-4 py-3 rounded-xl outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" required>
            </div>

            <div class="relative">
                <i class="fas fa-lock absolute left-4 top-4 text-slate-500"></i>
                <input type="password" name="password" placeholder="รหัสผ่าน" 
                       class="w-full bg-slate-900 border border-slate-700 pl-12 pr-4 py-3 rounded-xl outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition" required>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="relative">
                    <i class="fas fa-id-card absolute left-4 top-4 text-slate-500"></i>
                    <input type="text" name="fullname" placeholder="ชื่อ-นามสกุล" 
                           class="w-full bg-slate-900 border border-slate-700 pl-12 pr-4 py-3 rounded-xl outline-none focus:border-blue-500 transition" required>
                </div>
                <div class="relative">
                    <i class="fas fa-envelope absolute left-4 top-4 text-slate-500"></i>
                    <input type="email" name="email" placeholder="อีเมล" 
                           class="w-full bg-slate-900 border border-slate-700 pl-12 pr-4 py-3 rounded-xl outline-none focus:border-blue-500 transition" required>
                </div>
            </div>

            <div class="relative">
                <i class="fas fa-map-marker-alt absolute left-4 top-4 text-slate-500"></i>
                <textarea name="address" placeholder="ที่อยู่สำหรับจัดส่ง" rows="3" 
                          class="w-full bg-slate-900 border border-slate-700 pl-12 pr-4 py-3 rounded-xl outline-none focus:border-blue-500 transition"></textarea>
            </div>

            <button type="submit" name="reg_user" 
                    class="w-full bg-blue-600 hover:bg-blue-500 text-white font-bold py-4 rounded-xl transition duration-300 shadow-lg shadow-blue-900/40 transform hover:-translate-y-1">
                ยืนยันการสมัครสมาชิก
            </button>
        </form>

        <p class="text-center mt-8 text-slate-400 text-sm">
            เป็นสมาชิกอยู่แล้ว? <a href="login.php" class="text-blue-500 font-bold hover:underline">เข้าสู่ระบบที่นี่</a>
        </p>
    </div>

</body>
</html>