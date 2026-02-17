<?php 
// 1. เริ่ม Session และเชื่อมต่อฐานข้อมูล
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include('includes/db_connect.php'); 
include('includes/header.php'); 

// 2. ส่วนประมวลผลการเข้าสู่ระบบ
if(isset($_POST['login_btn'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // ข้อมูลในฐานข้อมูลเป็น Plain Text

    $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
    $result = mysqli_query($conn, $query);

    if(mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // เก็บข้อมูลลง Session
        $_SESSION['username'] = $user['username'];
        $_SESSION['name'] = $user['name'];
        $_SESSION['role'] = $user['role'];

        echo "<script>alert('ยินดีต้อนรับคุณ " . $user['name'] . "'); window.location='index.php';</script>";
    } else {
        echo "<script>alert('ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง');</script>";
    }
}
?>

<div class="container mt-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-dark text-white text-center py-3" style="border-radius: 15px 15px 0 0;">
                    <h4 class="mb-0">เข้าสู่ระบบ PROGAMER</h4>
                </div>
                <div class="card-body p-4">
                    <form method="POST" action="">
                        <div class="mb-3">
                            <label class="form-label">ชื่อผู้ใช้ (Username)</label>
                            <input type="text" name="username" class="form-control bg-light" required placeholder="ใส่อีเมลหรือชื่อผู้ใช้">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รหัสผ่าน (Password)</label>
                            <input type="password" name="password" class="form-control bg-light" required placeholder="ใส่รหัสผ่าน">
                        </div>
                        
                        <div class="mb-4 text-end">
                            <a href="forgot_password.php" class="text-danger small text-decoration-none">ลืมรหัสผ่านใช่หรือไม่?</a>
                        </div>

                        <button type="submit" name="login_btn" class="btn btn-dark w-100 py-2 fw-bold shadow-sm">เข้าสู่ระบบ</button>
                    </form>
                    
                    <hr class="my-4">
                    
                    <div class="text-center">
                        <p class="small text-muted mb-1">ยังไม่มีบัญชีสมาชิก?</p>
                        <a href="index.php" class="btn btn-outline-primary btn-sm w-100">สมัครสมาชิกใหม่ฟรี</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>