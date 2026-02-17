<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>วิทวัส วงศ์ภาคำ(เกม)</title>
</head>
<body>
    <h1>วิทวัส วงศ์ภาคำ(เกม)</h1>
<form method="post" action="">
    ชื่อภาค<input type="text" name="rname"aotofocus requiewd>
    <button type="submit" name="Submit">บันทึก</button>
>/form><br><br>

<?phpif(isst($_POST['Submit'])){
    include_once("connectdb.php");
    $rname = $_POST['rname'];
    $sql2 = "INSERT INTO 'regions'('r_id','r_name')VALUES(NULL,'{$rname}')";
    mysqli_qery($conn,$sql2) or die ("เพิ่มข้อมูลไม่ได้");

}
?>

<table border="1">
    <tr>
        <th>รหัสภาค</th>
        <th>ชื่อภาค</th>
        <th>ลบ</th>

    </tr>
<?php
include_once("connectdb.php");
$sql = "SELECT * FROM 'regions'";
$rs = mysqli_qery($conn,$sql);

while($data = mysqli_fetch_array($rs)){
?>
    <tr>
        <td><?php echo $data['r_id'];?></td>
        <td><?php echo $data['r_name'];?></td>
        <td width="80" align="ceter"> <img src="images/delete.jpg" width="20"></td>

    </tr>
<?php} ?>
</table> 

</body>
</html>