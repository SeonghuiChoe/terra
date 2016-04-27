<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	include "../../common.php";

	if($userlevel!=10){echo "<script>window.alert('권한이 없는 아이디 입니다.');history.go(-1);</script>";}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>관리자 대회후기 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<style type="text/css">
	.su_left dt:nth-child(3) a { color:#fff; background-color:#1eb4a8; }
	.su_left dd:nth-child(8) a { color:#1eb4a8; font-weight:bold; }
</style>
</head>
<body>
	<div id="wraper">
		<div id="all">
		<header class="su_logo">
			<span><a href="./index.php"><img src="<?echo $cfg[url].'/images/logo_g.png'?>" alt="테라로고" /></a></span>
		</header>
		<div class="bottom">
		<nav id="nav_su">
			<?php include _BASE_DIR."/include/su_left.php"; ?>
		</nav>
		<section id="su_content">
			<header class="right_title">
				<h1>대회후기</h1>
				<p>글올기기, 수정, 삭제 관리</p>
			</header>
			<div class="right_cont">

				테이블영역

			</div>
		</section>
		</div>
		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
		</div>
	</div>
</body>
</html>