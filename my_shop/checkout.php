<?php 
session_start();
include('includes/db_connect.php'); 
if (!$conn) { die("Connection failed: " . mysqli_connect_error()); }
include('includes/header.php'); 

if(empty($_SESSION['cart'])) {
    echo "<script>alert('ไม่มีสินค้าในตะกร้า!'); window.location='index.php';</script>";
    exit();
}

if(isset($_POST['confirm_order'])) {
    $c_name = mysqli_real_escape_string($conn, $_POST['customer_name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address_detail']);
    $province = mysqli_real_escape_string($conn, $_POST['province']);
    $sale_date = date('Y-m-d');

    foreach($_SESSION['cart'] as $id => $qty) {
        $res = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
        $p = mysqli_fetch_assoc($res);
        
        if($p) {
            $p_name = $p['product_name'];
            $p_cat = $p['category'];
            $p_price = $p['price'];

            // บันทึกข้อมูลที่อยู่ลงไปด้วย
            $sql = "INSERT INTO progamer_sales (customer_name, phone, address_detail, product_name, category, sale_date, province, total_price) 
                    VALUES ('$c_name', '$phone', '$address', '$p_name', '$p_cat', '$sale_date', '$province', '$p_price')";
            mysqli_query($conn, $sql);
        }
    }
    unset($_SESSION['cart']);
    echo "<script>alert('สั่งซื้อสำเร็จ! เราจะรีบจัดส่งให้คุณ'); window.location='index.php';</script>";
}
?>

<div class="container mt-5">
    <div class="row">
        <div class="col-md-7 mb-4">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-header bg-dark text-white py-3">
                    <h5 class="mb-0"><i class="bi bi-truck"></i> ข้อมูลการจัดส่ง</h5>
                </div>
                <div class="card-body p-4">
                    <form method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">ชื่อ-นามสกุล ผู้รับ</label>
                                <input type="text" name="customer_name" class="form-control" required placeholder="นาย สมชาย ใจดี">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">เบอร์โทรศัพท์</label>
                                <input type="text" name="phone" class="form-control" required placeholder="08x-xxxxxxx">
                            </div>
                        </div>
                        <div class="mb-3">
                            <label class="form-label fw-bold">ที่อยู่โดยละเอียด</label>
                            <textarea name="address_detail" class="form-control" rows="4" required placeholder="บ้านเลขที่, ถนน, ตำบล, อำเภอ..."></textarea>
                        </div>
                        <div class="mb-4">
    <label class="form-label fw-bold">จังหวัด</label>
    <select name="province" class="form-select" required>
        <option value="" disabled selected>--- เลือกจังหวัด ---</option>
        <option value="กรุงเทพมหานคร">กรุงเทพมหานคร</option>
        <option value="กระบี่">กระบี่</option>
        <option value="กาญจนบุรี">กาญจนบุรี</option>
        <option value="กาฬสินธุ์">กาฬสินธุ์</option>
        <option value="กำแพงเพชร">กำแพงเพชร</option>
        <option value="ขอนแก่น">ขอนแก่น</option>
        <option value="จันทบุรี">จันทบุรี</option>
        <option value="ฉะเชิงเทรา">ฉะเชิงเทรา</option>
        <option value="ชลบุรี">ชลบุรี</option>
        <option value="ชัยนาท">ชัยนาท</option>
        <option value="ชัยภูมิ">ชัยภูมิ</option>
        <option value="ชุมพร">ชุมพร</option>
        <option value="เชียงราย">เชียงราย</option>
        <option value="เชียงใหม่">เชียงใหม่</option>
        <option value="ตรัง">ตรัง</option>
        <option value="ตราด">ตราด</option>
        <option value="ตาก">ตาก</option>
        <option value="นครนายก">นครนายก</option>
        <option value="นครปฐม">นครปฐม</option>
        <option value="นครพนม">นครพนม</option>
        <option value="นครราชสีมา">นครราชสีมา</option>
        <option value="นครศรีธรรมราช">นครศรีธรรมราช</option>
        <option value="นครสวรรค์">นครสวรรค์</option>
        <option value="นนทบุรี">นนทบุรี</option>
        <option value="นราธิวาส">นราธิวาส</option>
        <option value="น่าน">น่าน</option>
        <option value="บึงกาฬ">บึงกาฬ</option>
        <option value="บุรีรัมย์">บุรีรัมย์</option>
        <option value="ปทุมธานี">ปทุมธานี</option>
        <option value="ประจวบคีรีขันธ์">ประจวบคีรีขันธ์</option>
        <option value="ปราจีนบุรี">ปราจีนบุรี</option>
        <option value="ปัตตานี">ปัตตานี</option>
        <option value="พระนครศรีอยุธยา">พระนครศรีอยุธยา</option>
        <option value="พังงา">พังงา</option>
        <option value="พัทลุง">พัทลุง</option>
        <option value="พิจิตร">พิจิตร</option>
        <option value="พิษณุโลก">พิษณุโลก</option>
        <option value="เพชรบุรี">เพชรบุรี</option>
        <option value="เพชรบูรณ์">เพชรบูรณ์</option>
        <option value="แพร่">แพร่</option>
        <option value="พะเยา">พะเยา</option>
        <option value="ภูเก็ต">ภูเก็ต</option>
        <option value="มหาสารคาม">มหาสารคาม</option>
        <option value="มุกดาหาร">มุกดาหาร</option>
        <option value="แม่ฮ่องสอน">แม่ฮ่องสอน</option>
        <option value="ยะลา">ยะลา</option>
        <option value="ยโสธร">ยโสธร</option>
        <option value="ร้อยเอ็ด">ร้อยเอ็ด</option>
        <option value="ระนอง">ระนอง</option>
        <option value="ระยอง">ระยอง</option>
        <option value="ราชบุรี">ราชบุรี</option>
        <option value="ลพบุรี">ลพบุรี</option>
        <option value="ลำปาง">ลำปาง</option>
        <option value="ลำพูน">ลำพูน</option>
        <option value="เลย">เลย</option>
        <option value="ศรีสะเกษ">ศรีสะเกษ</option>
        <option value="สกลนคร">สกลนคร</option>
        <option value="สงขลา">สงขลา</option>
        <option value="สตูล">สตูล</option>
        <option value="สมุทรปราการ">สมุทรปราการ</option>
        <option value="สมุทรสงคราม">สมุทรสงคราม</option>
        <option value="สมุทรสาคร">สมุทรสาคร</option>
        <option value="สระแก้ว">สระแก้ว</option>
        <option value="สระบุรี">สระบุรี</option>
        <option value="สิงห์บุรี">สิงห์บุรี</option>
        <option value="สุโขทัย">สุโขทัย</option>
        <option value="สุพรรณบุรี">สุพรรณบุรี</option>
        <option value="สุราษฎร์ธานี">สุราษฎร์ธานี</option>
        <option value="สุรินทร์">สุรินทร์</option>
        <option value="หนองคาย">หนองคาย</option>
        <option value="หนองบัวลำภู">หนองบัวลำภู</option>
        <option value="อ่างทอง">อ่างทอง</option>
        <option value="อุดรธานี">อุดรธานี</option>
        <option value="อุทัยธานี">อุทัยธานี</option>
        <option value="อุตรดิตถ์">อุตรดิตถ์</option>
        <option value="อุบลราชธานี">อุบลราชธานี</option>
        <option value="อำนาจเจริญ">อำนาจเจริญ</option>
    </select>
</div>
                        <button type="submit" name="confirm_order" class="btn btn-success btn-lg w-100 shadow">ยืนยันการสั่งซื้อ</button>
                </div>
            </div>
        </div>

        <div class="col-md-5">
            <div class="card shadow-sm border-0" style="border-radius: 15px;">
                <div class="card-body">
                    <h5 class="fw-bold border-bottom pb-2">สรุปคำสั่งซื้อ</h5>
                    <?php 
                    $total = 0;
                    foreach($_SESSION['cart'] as $id => $qty): 
                        $res = mysqli_query($conn, "SELECT * FROM products WHERE product_id = $id");
                        $p = mysqli_fetch_assoc($res);
                        $total += $p['price'];
                    ?>
                    <div class="d-flex justify-content-between mb-2">
                        <span><?php echo $p['product_name']; ?></span>
                        <span><?php echo number_format($p['price']); ?> ฿</span>
                    </div>
                    <?php endforeach; ?>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold text-danger fs-5">
                        <span>ยอดรวมสุทธิ</span>
                        <span><?php echo number_format($total); ?> ฿</span>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
</div>

<?php include('includes/footer.php'); ?>