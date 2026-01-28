<?php
// ตรวจสอบว่ามีการส่งข้อมูลฟอร์มด้วยเมธอด POST หรือไม่
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // ตั้งค่า Content-Type และ Charset เป็น UTF-8 เพื่อให้แสดงผลภาษาไทยได้อย่างถูกต้อง
    header('Content-Type: text/html; charset=utf-8');
    
    echo '<!DOCTYPE html>
<html lang="th">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>ผลลัพธ์การสมัครงาน</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Prompt:wght@400;600&display=swap" rel="stylesheet">
<style>
    body { font-family: "Prompt", sans-serif; background-color: #f4f7f6; padding: 20px; }
    .container { max-width: 900px; }
    .card-result { background: #fff; border-radius: 15px; box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1); padding: 30px; }
    h1 { color: #6a5af9; margin-bottom: 20px; text-align: center; }
    h3 { color: #1f78b4; border-bottom: 2px solid #e0e0e0; padding-bottom: 5px; margin-top: 25px; margin-bottom: 15px; }
    .result-label { font-weight: 600; color: #555; display: inline-block; width: 250px; }
    .result-value { color: #333; }
</style>
</head>
<body>

<div class="container">
    <div class="card-result">
        <h1>🎉 ผลลัพธ์การส่งใบสมัคร</h1>
        
        <h3>💼 ตำแหน่งงานที่ต้องการสมัคร</h3>
        <p><span class="result-label">ตำแหน่ง:</span> <span class="result-value">' . htmlspecialchars($_POST["position"] ?? 'N/A') . '</span></p>

        <h3>👤 ข้อมูลส่วนตัว</h3>
        <p>
            <span class="result-label">ชื่อ-นามสกุล:</span> 
            <span class="result-value">' . htmlspecialchars($_POST["prefix"] ?? '') . ' ' . htmlspecialchars($_POST["firstname"] ?? 'N/A') . ' ' . htmlspecialchars($_POST["lastname"] ?? 'N/A') . '</span>
        </p>
        <p><span class="result-label">วันเดือนปีเกิด:</span> <span class="result-value">' . htmlspecialchars($_POST["dob"] ?? 'N/A') . '</span></p>
        <p><span class="result-label">เบอร์โทรศัพท์:</span> <span class="result-value">' . htmlspecialchars($_POST["phone"] ?? 'N/A') . '</span></p>
        <p><span class="result-label">อีเมล:</span> <span class="result-value">' . htmlspecialchars($_POST["email"] ?? 'N/A') . '</span></p>
        
        <h3>🎓 ข้อมูลการศึกษาและความสามารถ</h3>
        <p><span class="result-label">ระดับการศึกษาสูงสุด:</span> <span class="result-value">' . htmlspecialchars($_POST["education"] ?? 'N/A') . '</span></p>
        <p><span class="result-label">สถาบันการศึกษาสูงสุด:</span> <span class="result-value">' . htmlspecialchars($_POST["institute"] ?? 'N/A') . '</span></p>
        <p>
            <span class="result-label">ความสามารถพิเศษ/ทักษะ:</span><br>
            <pre class="result-value" style="background-color:#f8f9fa; padding:10px; border-radius:8px; white-space: pre-wrap;">' . htmlspecialchars($_POST["skills"] ?? 'N/A') . '</pre>
        </p>
        <p>
            <span class="result-label">ประสบการณ์ทำงาน:</span><br>
            <pre class="result-value" style="background-color:#f8f9fa; padding:10px; border-radius:8px; white-space: pre-wrap;">' . htmlspecialchars($_POST["experience"] ?? 'N/A') . '</pre>
        </p>

        <div class="text-center mt-4">
            <p class="text-success">✅ ข้อมูลการสมัครงานถูกส่งมาเรียบร้อยแล้ว!</p>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>';

} else {
    // กรณีที่เข้าถึงไฟล์นี้โดยตรงโดยไม่ได้ส่งข้อมูลฟอร์ม
    echo "<h1>🚫 ข้อผิดพลาด: ไม่มีการส่งข้อมูลฟอร์ม!</h1>";
}
?>