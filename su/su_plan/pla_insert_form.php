<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	
	include "../../common.php";	
	include _BASE_DIR."/lib/business.php";
	
	$apply_board = new board();
	$apply_board->check_admin_session();
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>관리자 대회일정 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/plan_apply.css">
<style type="text/css">
	.su_left dt:nth-child(1) a { color:#fff; background-color:#1eb4a8; }
</style>
</head>
<body>
	<div id="wraper">
		<div id="all">
		<header class="su_logo">
			<span><a href="<?echo $cfg[url].'/index.php'?>"><img src="../../images/logo_g.png" alt="테라로고" /></a></span>
		</header>
		<div class="bottom">
		<nav id="nav_su">
			<?php include _BASE_DIR."/include/su_left.php"; ?>
		</nav>
		<section id="su_content">
			<header class="right_title">
				<h1>대회일정</h1>
				<p>테라런 대회일정 관리</p>
			</header>
			<div class="right_cont">
		
			 	<form enctype="multipart/form-data" action="pla_insert_act.php" method="POST">

			 		<table class="plan_table">
				 		<tr>
				 			<th>마라톤 일자</td>
				 			<td><input type="date" name="pla_date"></td>
						</tr>
				 		<tr>
				 			<th>마라톤 시간</td>
				 			<td><input type="time" name="pla_time"></td>
				 		</tr>
				 		<tr>
				 			<th>마라톤 장소</td>
				 			<td><input type="text" name="pla_place"></td>
				 		</tr>
				 		<tr>
				 			<th>마라톤 거리(km)</td>
				 			<td><input type="text" name="pla_distance"></td>
				 		</tr>
				 		<tr>
				 			<th>마라톤 명칭</td>
				 			<td><input type="text" name="pla_name"></td>
				 		</tr>
				 		<tr>
				 			<th>마라톤 신청 기간</td>
				 			<td><input type="text" name="pla_period"></td>
				 		</tr>
				 		<tr>
				 			<th>이미지첨부1</th>
				 			<td><input type="file" name="upfile[]"></td>
				 		</tr>
						<tr>
							<th>이미지첨부2</th>
							<td><input type="file" name="upfile[]"></td>
						</tr>
				 	</table>
					<div id="button"><input type="submit" value="입력"></div>	
			 	</form>

		</section>
		</div><!--bottom end-->

		<footer>
		<?php include "../../include/footer.php"; ?>
		</footer>
	
		</div><!--all end-->
	</div>
 </body>
 </html>