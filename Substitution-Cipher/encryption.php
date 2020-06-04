<?php 
$code="";
 ?>
<!DOCTYPE html>
<html lang="ko">
<head>
	<meta charset="UTF-8">
	<title>암호화/복호화</title>
	<link rel="stylesheet" type="text/css" href="css/index.css" />
</head>
<body>
	<div class="wrraper">
		<div class="title">다중치환 암호화/복호화</div>
		<div class="container">
			<form action="encryption_process.php" method="post">
				<div class="inputkey">
					<input type="text" name="key" class="key" placeholder="암호키를 입력해주세요" size="20" class="input" required>
				</div>
				<div class="inputcode">
					<input type="text" name="code" class="code" placeholder="평문을 입력해주세요" size="20" class="input" required>
				</div>
				<div class="submitbutton">
					<input type="submit" value="암호화 / 복호화" class="submit">
				</div>
			</form>
		</div>
	</div>
</body>
</html>