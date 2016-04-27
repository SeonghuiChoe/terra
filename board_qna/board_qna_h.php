<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$usernick=$_SESSION["usernick"];
	$userlevel = $_SESSION["userlevel"];
	include "../common.php";
	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>Q&A - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/board_n.css">
<!--<link rel="stylesheet" href="../css/board.css" type="text/css" > 페이징 css-->
<!--<link href="../css/qna.css" rel="stylesheet" type="text/css" >-->
<link rel="stylesheet" type="text/css" href="../css/normalize.css">

<style type="text/css">
	.nav_cust > ul > li:nth-child(4) > a { color:#1eb4a8; *color:#e77c71; }
	.sub_board_nav li:nth-child(4) a { color:#fff; background-color:#e77c71; }
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
				<p>Home &gt; 커뮤니티 &gt; Q&A</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>Q&A</h1>
				<p>궁굼한점을 올려주시면 답변해드려요</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<?php include _BASE_DIR."/include/sub_board_nav.php"; ?>
				<div class="subin">