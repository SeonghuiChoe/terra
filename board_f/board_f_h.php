<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	include "../common.php";
	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>자유게시판 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">

<!--<link rel="stylesheet" href="../css/board.css" type="text/css" >-->
<link rel="stylesheet" href="../css/normalize.css" type="text/css" >
<link rel="stylesheet" type="text/css" href="../css/board_f.css"/>
<!--탑으로 이동버튼-->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="../js/movetop.js"></script>

<style type="text/css">
	.nav_cust > ul > li:nth-child(4) > a { color:#1eb4a8; *color:#e77c71; }
	.sub_board_nav li:nth-child(2) a { color:#fff; background-color:#e77c71; }

	#list_item2 a{text-decoration: none;color: #3a3a3a;}
	#list_item2 {max-width: 490px;
	white-space:nowrap;
	text-overflow:ellipsis; 
	overflow:hidden; }
	#list_item2 a:hover {text-decoration: underline;color: #0936f9;}
	a {text-decoration: none;color: #3a3a3a;}
</style>
</head>

<body>
	<div id="wraper">
		<header>
			<?php include _BASE_DIR."/include/header.php"; ?>
		</header>
		
		<section id="subloca">
			<div class="subloca">
				<p>Home &gt; 커뮤니티 &gt; 자유게시판</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>자유게시판</h1>
				<p>자유로운 소통공간</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<?php include "../include/sub_board_nav.php"; ?>
				<div class="subin">