<?php 
session_start();
include('includes/db_connect.php'); 
include('includes/header.php'); 

if(isset($_POST['reset_request'])) {
    $contact = mysqli_real_escape_string($conn, $_POST['contact']);

    // ตรวจสอบข้อมูลในตาราง users
    $query = "SELECT * FROM users WHERE username='$contact'"; 
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        // ในระบบจริงจะส่ง OTP หรือลิงก์รีเซ็ต
        echo "<script>alert('ระบบตรวจสอบพบข้อมูลเรียบร้อยแล้ว'); window.location='reset_password.php';</script>";
    } else {
        echo "<script>alert('ไม่พบข้อมูลผู้ใช้นี้ในระบบ');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-danger text-white text-center py-3" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0">ลืมรหัสผ่าน?</h4>
                </div>
                <div class="card-body p-4 text-center">
                    <p class="text-muted small mb-4">กรุณากรอกชื่อผู้ใช้หรืออีเมลที่ใช้สมัครสมาชิก</p>
                    <form method="POST" action="">
                        <div class="mb-4 text-start">
                            <label class="form-label">ชื่อผู้ใช้ / อีเมล</label>
                            <input type="text" name="contact" class="form-control" required placeholder="example@mail.com">
                        </div>
                        <button type="submit" name="reset_request" class="btn btn-danger w-100 py-2 fw-bold">ตรวจสอบข้อมูล</button>
                    </form>
                    <hr>
                    <a href="login.php" class="text-decoration-none small">กลับหน้าเข้าสู่ระบบ</a>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>