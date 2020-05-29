<?php 
$code="";
 ?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>암호화</title>
	<link rel="stylesheet" type="text/css" href="css/index.css" />
</head>
<body>
	<table>
		<form action="encryption_process.php" method="post">
		<tr>
			<td>암호키</td>
			<td><input type="text" name="key" placeholder="암호키를 입력해주세요" size="20" required></td>
		</tr>
		<tr>
			<td>평문</td>
			<td><input type="text" name="code" placeholder="평문을 입력해주세요" size="20" required></td>
		</tr>
		<tr>
			<td>암호문</td>
			<td><?=$code?></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="암호화">				
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a href="decoding.php">복호화 하러가기</a>			
			</td>
		</tr>
		</form>
	</table>
</body>
</html>