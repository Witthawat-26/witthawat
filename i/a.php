<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>วิทวัส วงศ์ภาคำ(เกม)</title>
</head>
<body>
    <h1>วิทวัส วงศ์ภาคำ(เกม)</h1>


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