<?php 
include('includes/db_connect.php'); 
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
include('includes/header.php'); 

if(isset($_POST['register'])) {
    // รับค่าจากฟอร์ม (อ้างอิงบทที่ 17)
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password']; // ในการทำงานจริงควรใช้ password_hash()
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = $_POST['phone'];
    $address = mysqli_real_escape_string($conn, $_POST['address']);

    // ตรวจสอบว่ามีชื่อผู้ใช้นี้หรือยัง
    $check = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
    
    if(mysqli_num_rows($check) > 0) {
        $error = "ชื่อผู้ใช้นี้มีผู้ใช้งานแล้ว กรุณาเปลี่ยนใหม่";
    } else {
        // บันทึกข้อมูล (อ้างอิงบทที่ 21)
        $sql = "INSERT INTO users (username, password, name, phone, address, role) 
                VALUES ('$username', '$password', '$name', '$phone', '$address', 'user')";
        
        if(mysqli_query($conn, $sql)) {
            echo "<script>alert('สมัครสมาชิกสำเร็จ! กรุณาเข้าสู่ระบบ'); window.location='login.php';</script>";
        } else {
            $error = "เกิดข้อผิดพลาด: " . mysqli_error($conn);
        }
    }
}
?>

<div class="container mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow">
                <div class="card-header bg-primary text-white text-center">
                    <h4>สมัครสมาชิกใหม่</h4>
                </div>
                <div class="card-body p-4">
                    <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
                    
                    <form method="POST">
                        <div class="mb-3">
                            <label class="form-label">ชื่อผู้ใช้ (Username)</label>
                            <input type="text" name="username" class="form-control" placeholder="ภาษาอังกฤษหรือตัวเลข" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">รหัสผ่าน (Password)</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <hr>
                        <div class="mb-3">
                            <label class="form-label">ชื่อ-นามสกุล</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">เบอร์โทรศัพท์</label>
                            <input type="text" name="phone" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">ที่อยู่จัดส่งสินค้า</label>
                            <textarea name="address" class="form-control" rows="3" required></textarea>
                        </div>
                        
                        <button type="submit" name="register" class="btn btn-primary w-100 mb-3">สมัครสมาชิก</button>
                        <div class="text-center">
                            มีบัญชีอยู่แล้ว? <a href="login.php">เข้าสู่ระบบที่นี่</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('includes/footer.php'); ?>