<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>66010914037 วิทวัส วงศ์ภาคำ(เกม)</title>

<style>
    body{
        font-family: "Prompt", sans-serif;
        background: linear-gradient(135deg, #6a5af9, #ff6ad5);
        margin: 0;
        padding: 45px 0;
        color: #fff;
    }
    h1{
        text-align: center;
        margin-bottom: 30px;
        font-size: 36px;
        text-shadow: 0 3px 6px rgba(0,0,0,0.3);
    }

    /* ฟอร์มใหญ่ขึ้น */
    form{
        width: 900px;
        margin: auto;
        background: rgba(255,255,255,0.97);
        color: #333;
        padding: 35px;
        border-radius: 20px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.25);
        backdrop-filter: blur(5px);
        font-size: 18px;
    }

    input, textarea, select{
        width: 100%;
        padding: 15px;
        margin-top: 5px;
        margin-bottom: 22px;
        border-radius: 12px;
        border: 2px solid #ccc;
        font-size: 18px;
        transition: 0.3s;
    }

    input:focus, textarea:focus, select:focus{
        border-color: #6a5af9;
        box-shadow: 0 0 10px rgba(106,90,249,0.5);
        outline: none;
    }

    /* ปุ่มไซส์ใหญ่ขึ้น */
    button{
        padding: 14px 28px;
        margin: 6px;
        font-size: 18px;
        border: none;
        border-radius: 12px;
        cursor: pointer;
        transition: 0.25s;
        color: #fff;
    }

    button[type="submit"]{
        background: #6a5af9;
    }
    button[type="submit"]:hover{ background: #5843f6; }

    button[type="reset"]{
        background: #ff4b5c;
    }
    button[type="reset"]:hover{ background: #d93b49; }

    .btn-blue{
        background: #18a3ff;
    }
    .btn-blue:hover{ background: #0c89d4; }

    .btn-print{
        background: #00c896;
    }
    .btn-print:hover{ background: #00ad81; }

    hr{
        margin-top: 40px;
        border: none;
        height: 2px;
        background: rgba(255,255,255,0.5);
    }

    /* กล่องผลลัพธ์ */
    .result-box{
        width: 900px;
        margin: auto;
        background: rgba(255,255,255,0.97);
        padding: 30px;
        border-radius: 18px;
        box-shadow: 0 12px 28px rgba(0,0,0,0.25);
        margin-top: 25px;
        color: #333;
        font-size: 20px;
    }

</style>
</head>

<body>

<h1>ฟอร์มรับข้อมูล - วิทวัส วงศ์ภาคำ (เกม) GPT</h1>

<form method="post" action="">
ชื่อ-สกุล  
<input type="text" name="fullname" autofocus required>

เบอร์โทร  
<input type="text" name="phone" required>

ส่วนสูง (100 - 200 ซม.)  
<input type="number" name="height" min="100" max="200" required>

ที่อยู่  
<textarea name="address" cols="40" rows="4"></textarea>

วันเดือนปีเกิด  
<input type="date" name="brthday">

สีที่ชอบ  
<input type="color" name="color" style="padding:3px; height:60px; width:120px;">

สาขาวิชา  
<select name="major">
    <option value="การบัญชี">การบัญชี</option>
    <option value="การตลาด">การตลาด</option>
    <option value="การจัดการ">การจัดการ</option>
    <option value="คอมพิวเตอร์ธุรกิจ">คอมพิวเตอร์ธุรกิจ</option>
</select>

<button type="submit" name="Submit">สมัครสมาชิก</button>
<button type="reset">ยกเลิก</button>
<button type="button" class="btn-blue" onClick="window.location='https://www.msu.ac.th/';">Go to MSU</button>
<button type="button" class="btn-blue" onMouseOver="alert('สวัสดีท่าสมาชิกชมรมคนชอบ');">Hello</button>
<button type="button" class="btn-print" onClick="window.print();">พิมพ์</button>

</form>

<hr>

<?php
if (isset($_POST['Submit'])) {
    $fullname=$_POST['fullname'];
    $phone=$_POST['phone'];
    $height=$_POST['height'];
    $address=$_POST['address'];
    $brthday=$_POST['brthday'];
    $color=$_POST['color'];
    $major=$_POST['major'];

    echo "<div class='result-box'>";
    echo "<h2>ข้อมูลที่คุณส่งมา</h2>";
    echo "ชื่อ-สกุล : " .$fullname."<br><br>";
    echo "เบอร์โทร : ". $phone."<br><br>";
    echo "ส่วนสูง : ". $height." ซม.<br><br>";
    echo "ที่อยู่ : ". nl2br($address)."<br><br>";
    echo "วันเดือนปีเกิด : ". $brthday."<br><br>";
    echo "สีที่ชอบ : <div style='background-color:{$color};width:350px;height:40px;border-radius:10px;margin:10px 0;'></div>";
    echo "สาขาวิชา : ". $major."<br><br>";
    echo "</div>";
}
?>

</body>
</html>
