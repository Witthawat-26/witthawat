<?php 
session_start();
include('includes/db_connect.php'); 
include('includes/header.php'); 

if(isset($_POST['change_password'])) {
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    // 1. ตรวจสอบว่ารหัสผ่านใหม่ทั้งสองช่องตรงกันหรือไม่
    if($new_password !== $confirm_password) {
        echo "<script>alert('รหัสผ่านใหม่ไม่ตรงกัน กรุณากรอกใหม่อีกครั้ง');</script>";
    } else {
        // 2. ตรวจสอบว่าผู้ใช้นี้มีตัวตนจริงในระบบ (เช็คจาก Username หรือ Email)
        $check_user = mysqli_query($conn, "SELECT id FROM users WHERE username = '$contact'");
        
        if(mysqli_num_rows($check_user) > 0) {
            // 3. อัปเดตรหัสผ่านใหม่ลงฐานข้อมูล
            $update_sql = "UPDATE users SET password = '$new_password' WHERE username = '$contact'";
            
            if(mysqli_query($conn, $update_sql)) {
                echo "<script>alert('เปลี่ยนรหัสผ่านสำเร็จ! กรุณาเข้าสู่ระบบด้วยรหัสผ่านใหม่'); window.location='login.php';</script>";
            } else {
                echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล');</script>";
            }
        } else {
            echo "<script>alert('ไม่พบข้อมูลผู้ใช้ในระบบ');</script>";
        }
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-success text-white text-center py-3" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0">ตั้งรหัสผ่านใหม่</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label small">ยืนยันชื่อผู้ใช้/อีเมล</label>
                            <input type="text" name="contact" class="form-control bg-light" required placeholder="ใส่อีเมลของคุณอีกครั้ง">
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label small">รหัสผ่านใหม่</label>
                            <input type="password" name="new_password" class="form-control" required placeholder="อย่างน้อย 8 ตัวอักษร">
                        </div>
                        <div class="mb-4">
                            <label class="form-label small">ยืนยันรหัสผ่านใหม่</label>
                            <input type="password" name="confirm_password" class="form-control" required placeholder="กรอกรหัสผ่านใหม่อีกครั้ง">
                        </div>
                        
                        <button type="submit" name="change_password" class="btn btn-success w-100 py-2 fw-bold shadow-sm">บันทึกรหัสผ่านใหม่</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>