<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>66010914037 วิทวัส วงศ์ภาคำ(เกม) Gemini</title>
<style>
    /* ตั้งค่าพื้นฐานสำหรับ body */
    body {
        font-family: Arial, sans-serif;
        background-color: #f4f4f9;
        color: #333;
        margin: 20px;
    }

    /* สไตล์สำหรับส่วนหัว (Heading) */
    h1 {
        color: #007bff;
        border-bottom: 3px solid #007bff;
        padding-bottom: 10px;
        margin-bottom: 20px;
    }

    /* สไตล์สำหรับฟอร์ม */
    form {
        background-color: #fff;
        padding: 30px;
        border-radius: 8px;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        margin: auto; /* จัดให้อยู่ตรงกลางหน้า */
    }

    /* สไตล์สำหรับแถวของข้อมูลในฟอร์ม */
    .form-group {
        margin-bottom: 15px;
        display: flex; /* ใช้ Flexbox เพื่อจัดเรียงฉลากและช่องกรอก */
        align-items: center; /* จัดให้อยู่กึ่งกลางแนวตั้ง */
    }

    /* สไตล์สำหรับฉลาก/ข้อความนำหน้า */
    .form-group label {
        width: 120px; /* กำหนดความกว้างสำหรับฉลาก */
        font-weight: bold;
        padding-right: 10px;
    }

    /* สไตล์สำหรับช่อง input และ select */
    input[type="text"],
    input[type="number"],
    input[type="date"],
    select,
    textarea {
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        box-sizing: border-box; /* ให้ padding ไม่เพิ่มขนาดโดยรวม */
        flex-grow: 1; /* ให้ช่อง input ขยายเต็มพื้นที่ที่เหลือ */
    }

    textarea {
        resize: vertical; /* อนุญาตให้เปลี่ยนขนาดในแนวตั้งเท่านั้น */
        height: 80px;
    }
    
    /* สไตล์สำหรับช่อง input color */
    input[type="color"] {
        height: 40px;
        padding: 0;
        border: none;
        width: 100px;
    }

    /* สไตล์สำหรับปุ่ม */
    button {
        background-color: #28a745;
        color: white;
        padding: 10px 15px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        margin-right: 10px;
        transition: background-color 0.3s ease;
    }

    button:hover {
        background-color: #218838;
    }
    
    /* สไตล์สำหรับปุ่ม ยกเลิก */
    button[type="reset"] {
        background-color: #dc3545;
    }

    button[type="reset"]:hover {
        background-color: #c82333;
    }

    /* สไตล์สำหรับส่วนแสดงผลลัพธ์ */
    .result-section {
        margin-top: 30px;
        padding: 20px;
        border: 1px dashed #007bff;
        background-color: #e9f7ff;
        border-radius: 8px;
        max-width: 600px;
        margin-left: auto;
        margin-right: auto;
    }

    .result-section div {
        margin-bottom: 5px;
    }
    
    /* สไตล์สำหรับแสดงสีที่ชอบ */
    .color-display {
        display: inline-block;
        width: 100px;
        height: 20px;
        border: 1px solid #ccc;
        vertical-align: middle;
        margin-left: 10px;
    }
</style>
</head>

<body>

<h1>ฟอร์มรับข้อมูล - วิทวัส วงศ์ภาคำ (เกม)</h1>

<form method="post" action="">
    
    <div class="form-group">
        <label for="fullname">ชื่อ-สกุล</label>
        <input type="text" name="fullname" id="fullname" autofocus required>*
    </div>

    <div class="form-group">
        <label for="phone">เบอร์โทร</label>
        <input type="text" name="phone" id="phone" required>*
    </div>

    <div class="form-group">
        <label for="height">ส่วนสูง</label>
        <div>
            <input type="number" name="height" id="height" min="100" max="200" required> ซม.*
        </div>
    </div>

    <div class="form-group" style="align-items: flex-start;">
        <label for="address">ที่อยู่</label>
        <textarea name="address" id="address" cols="40" rows="4"></textarea>
    </div>

    <div class="form-group">
        <label for="brthday">วันเดือนปีเกิด</label>
        <input type="date" name="brthday" id="brthday">
    </div>

    <div class="form-group">
        <label for="color">สีที่ชอบ</label>
        <input type="color" name="color" id="color">
    </div>

    <div class="form-group">
        <label for="major">สาขาวิชา</label>
        <select name="major" id="major">
            <option value="การบัญชี">การบัญชี</option>
            <option value="การตลาด">การตลาด</option>
            <option value="การจัดการ">การจัดการ</option>
            <option value="คอมพิวเตอร์ธุรกิจ">คอมพิวเตอร์ธุรกิจ</option>
        </select>
    </div>

    <div style="margin-top: 20px; text-align: center;">
        <button type="submit" name="Submit">สมัครสมาชิก</button>
        <button type="reset" >ยกเลิก</button>
        <button type="button" onClick="window.location='https://www.msu.ac.th/';">Go to MSU</button>
        <button type="button" onMouseOver="alert('สวัสดีท่าสมาชิคชมรมคนชอบ');">Hello</button>
        <button type="button" onClick="window.print();">พิมพ์</button>
    </div>

</form>


<hr style="margin-top: 30px; border-color: #007bff;">

<?php
if (isset($_POST['Submit'])) {
	$fullname=$_POST['fullname'] ;
	$phone=$_POST['phone'] ;
	$height=$_POST['height'] ;
	$address=$_POST['address'] ;
	$brthday=$_POST['brthday'] ;
	$color=$_POST['color'] ;
	$major=$_POST['major'] ;

	?>
	<div class="result-section">
        <h2>✅ ข้อมูลที่ได้รับ</h2>
        <div>**ชื่อ-สกุล:** <?php echo $fullname; ?></div>
        <div>**เบอร์โทร:** <?php echo $phone; ?></div>
        <div>**ส่วนสูง:** <?php echo $height; ?> ซม.</div>
        <div>**ที่อยู่:** <?php echo nl2br($address); ?></div>
        <div>**วันเดือนปีเกิด:** <?php echo $brthday; ?></div>
        <div>
            **สีที่ชอบ:** <?php echo $color; ?> 
            <div class="color-display" style='background-color:<?php echo $color; ?>'></div>
        </div>
        <div>**สาขาวิชา:** <?php echo $major; ?></div>
	</div>
	<?php
}
?>
</body>
</html>