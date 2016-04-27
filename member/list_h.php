<?php
	@session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	include "../common.php";
	if(!$userid){echo "<script>window.alert('로그인을 해주세요.');
	location.href='../member/login.php';</script>";exit;}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>마이페이지 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<link rel="stylesheet" href="../css/normalize.css" type="text/css" >
<style type="text/css">
	.sub_mypage_nav li:nth-child(3) a { color:#fff; background-color:#e77c71; }
</style>

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
				<p>Home &gt; 마이페이지 &gt; 나의 게시글</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>나의 게시글</h1>
				<p>게시판별 나의 게시글을 볼 수 있습니다.</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
	<?php include "../include/sub_mypage_nav.php"; ?>
				<div class="subin">
