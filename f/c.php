<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>66010914037 วิทวัส วงศ์ภาคำ (เกม)</title>
</head>

<body>

<h1>66010914037 วิทวัส วงศ์ภาคำ (เกม)</h1>

<form method="post" action="">
	กรอกคะแนน <input type="number" min="0" max="100"name="a" aotofocus required>
    <button type="submit" name="Submit">OK</button>
</form>
<hr>

<?php
if(isset($_POST['Submit'])){
		$score = $_POST['a'];
	if ($score >= 80) {
		$grade = "A" ;
	} else if ($score >= 70) {
		$grade =  "B" ;
	} else if ($score >= 60) {
		$grade =  "C" ;
	} else if ($score >= 50) {
		$grade = "D" ;
	} else {
		$grade = "F" ;
} 
}
	echo "<h2>ได้คะแนน  $score เกรด $grade </h2>" ;
?>





</body>
</html>