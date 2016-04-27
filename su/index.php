<meta charset="utf-8">
<?php
  session_start();
  $userid = $_SESSION["userid"];
  $userlevel=$_SESSION["userlevel"];
  include "../common.php";
  if($userid){
	  if($userlevel==10){echo "<script>location.href='".$cfg[url]."/su/su_apply/apply.php';</script>"; exit;}
	  else{echo "<script>location.href='".$cfg[url]."/index.php';</script>"; exit;}
  }
?>
<!DOCTYPE html>
<html>
<head>
	<link href="./css/admin.css" rel="stylesheet" type="text/css" media="all">
</head>
<body>
	<div id="wraper">
	
	<form name="member_form" method="post" action="./su_member/su_login_action.php">
		<table class="su_login_form">
		<tr><td colspan="3" class="logo"><img src="../images/logo_g.png" alt="테라로고" /></td></tr>
		<tr><td>아이디</td><td><input type="text" name="id" size="20" tabindex="1" autofocus/></td><td rowspan="2"><input type="submit" value="로그인" class="su_login_btn" tabindex="3" /></td></tr>
		<tr><td>비밀번호</td><td><input type="password" name="pass" size="20" tabindex="2" /></td></tr>
		</table>
	</form>
	</div>
</body>
</html>