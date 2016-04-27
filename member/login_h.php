<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	$apply=$_GET["apply"];
	include "../common.php";
	if($_SESSION["userid"]){
		echo "<script>window.alert('로그인 중 입니다.');history.go(-1);</script>";
	}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>로그인 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<script>

	function chk_logform() {
		if(login_form.id.value == "") {
			alert('아이디를 입력하지 않았습니다.');
			login_form.id.focus();
			return false;
		}
		else if(login_form.pass.value == "") {
			alert('비밀번호를 입력하지 않았습니다.');
			login_form.pass.focus();
			return false;
		}
		else{
			return true;
		}
	}
</script>

<!--탑으로 이동버튼-->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="../js/movetop.js"></script>

</head>
<body>
	<div id="wraper">
		<header>
			<?php include _BASE_DIR."/include/header.php"; ?>
		</header>
		
		<section id="subloca">
			<div class="subloca">
				<p>Home &gt; 로그인</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>로그인</h1>
				<p>로그인을 해주세요</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<div class="subin">
