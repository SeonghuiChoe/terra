<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
    include "../common.php";
	if($_SESSION["userid"]){
	echo "<script>window.alert('로그인 중입니다.');history.go(-1);</script>";
}	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>회원가입 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<script>
	function join_ok(){
		if(document.join_form.ok.checked){
			document.join_form.submit();
		}else{
			alert("약관에 동의하셔야 회원가입을 하실 수 있습니다.");
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
				<p>Home &gt; 회원가입</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>회원가입</h1>
				<p>회원가입을 하시면 더 많은 정보를 공유할 수 있습니다.</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<div class="subin">
