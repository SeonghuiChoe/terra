<?php
  session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<link href="./css/admin.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
	<div id="wraper">
	<form name="member_form" method="post" action="su_login_action.php">   
		<table class="su_login_form">
		<tr>
			<td>아이디</td>
			<td><input type="text" name="id" autofocus></input></td>
			<td rowspan="2"><input type="submit" value="로그인" class="su_login_submit"></input></td>
		</tr>
		<tr>
			<td>비밀번호</td>
			<td><input type="password" name="pass"></input></td>
		</tr>
		</table>
	</form>
	</div>
</body>
</html>