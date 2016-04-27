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
<title>테라소개 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/intro.css">
<style type="text/css">
	.nav_cust > ul > li:nth-child(1) > a { color:#1eb4a8; *color:#e77c71; }
	.sub_intro_nav li:nth-child(3) a { color:#fff; background-color:#e77c71; }
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
				<p>Home &gt; 테라소개 &gt; 테라위치</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>테라위치</h1>
				<p>테라의 위치를 안내해드립니다</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<?php include _BASE_DIR."/include/sub_intro_nav.php"; ?>
				<div class="subin">

				<div class="box">
					<div class="map">
						<iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1582.6836630846626!2d127.03052922089367!3d37.49925374370982!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x357ca157987804c3%3A0x12580baeb76c55de!2z7ISc7Jq47Yq567OE7IucIOqwleuCqOq1rCDsl63sgrzrj5kgNjQ5LTE0!5e0!3m2!1sko!2skr!4v1439438736049" width="950" height="400" frameborder="0" style="border:0" allowfullscreen></iframe>
					</div>
					<div class="info">

						<table>
							<tr><th>주소</th><td>서울특별시 강남구 테헤란로 119 대호빌딩 8층</td></tr>
							<tr><th>버스</th><td>145, 146, 730, 341, 4312, 4420, 4421</td></tr>
							<tr><th>지하철</th><td>2호선 강남역 12번 출구</td></tr>
							<tr><th>대표전화</th><td>02-3448-1005</td></tr>
							<tr><th>팩스</th><td>02-3481-9122</td></tr>
						</table>

					</div>
				</div>

				</div>
			</div>
		</section>

		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
	</div>
</body>
</html>