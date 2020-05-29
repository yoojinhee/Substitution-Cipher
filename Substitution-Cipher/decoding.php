<?php 
$decryption="";
 ?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>복호화</title>
	<link rel="stylesheet" type="text/css" href="css/index.css" />
</head>
<body>
	<table>
		<form action="decoding_process.php" method="post">
		<tr>
			<td>암호키</td>
			<td><input type="text" name="key" placeholder="암호키를 입력해주세요" size="20" required></td>
		</tr>
		<tr>
			<td>암호문</td>
			<td><input type="text" name="code" placeholder="암호문을 입력해주세요" size="20" required></td>
		</tr>
		<tr>
			<td>복호문</td>
			<td><?=$decryption?></td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit" value="복호화">				
			</td>
		</tr>
		<tr>
			<td colspan="2">
				<a href="encryption.php">암호화 하러가기</a>			
			</td>
		</tr>
		</form>
	</table>
</body>
</html>