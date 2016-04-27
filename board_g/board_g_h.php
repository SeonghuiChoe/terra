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
<title>갤러리 - Terra Run</title>
<link rel="stylesheet" href="../css/common.css" type="text/css">
<link rel="stylesheet" href="../css/board_g.css" type="text/css">
<link rel="stylesheet" href="../css/gal.css" type="text/css">
<link rel="stylesheet" href="../css/normalize.css" type="text/css">


<style type="text/css">
  .nav_cust > ul > li:nth-child(4) > a { color:#1eb4a8; *color:#e77c71; }
  .sub_board_nav li:nth-child(3) a { color:#fff; background-color:#e77c71; }
  #pic table{margin:0 auto;} 


  #itsub1 p{font-size:12px;font-weight:bold;color: #fa3e0c;text-align:center;
  max-width: 210px;
  white-space:nowrap;
  text-overflow:ellipsis; 
  overflow:hidden; }
  #itsub2 p{font-size:12px;text-align:center;}
  a {text-decoration: none;color: #3a3a3a;}
  td{padding:15px 125px 5px 10px;}
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
				<p>Home &gt; 커뮤니티 &gt; 갤러리</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>갤러리</h1>
				<p>대회사진을 공유해요</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<?php include _BASE_DIR."/include/sub_board_nav.php"; ?>
				<div class="subin">

