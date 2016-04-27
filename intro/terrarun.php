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
	.sub_intro_nav li:nth-child(2) a { color:#fff; background-color:#e77c71; }
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
				<p>Home &gt; 테라소개 &gt; 대회소개</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>대회소개</h1>
				<p>테라런의 대회소개</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<?php include _BASE_DIR."/include/sub_intro_nav.php"; ?>
				<div class="subin_intro">


				<div class="con0">
					<h2>TERRARUN은?</h2>
					<p>TERRARUN은 마라톤을 통해 개인의 신체 건강증진과 더불어 우리 사회에 올바른 기부문화를 확산시키기 위해 <br/>2010년부터 시작된 대회입니다. 
					TERRARUN은 매달 정해진 날짜에 전국 각지에 레이스 지역이 결정되면 대회가 진행됩니다. TERRARUN에 참가한 TERRA RUNNER 1인당 10만원씩 기부금이 적립되며 적립된 기부금 전액은 연말에 도움이 필요한 소외계층 및 공익활동을 위해 사용됩니다. 
					</p>
				</div>
				<div class="con1">
					<h2>■ TERRARUN의 성과</h2>
					<div>
						<div class="graph0">
							<p><img src="../images/intro/graph01.png" /></p>
							<p>총 누적 수입 현황</p>
						</div>
						<div class="graph1">
							<p><img src="../images/intro/graph02.png" /></p>
							<p>연 참가자 수</p>
						</div>
					</div>
				</div>
				<div class="con2">
					<h2>■ TERRARUN 참가방법</h2>
					<p>TERRARUN은 전액 후원사의 기부금을 통해 운영됩니다. 따라서 별도의 참가비는 없으며 사이트 내에서 대회일정을 확인한 후 자신의 일정에 맞는 레이스를 신청하면 됩니다.
					</p>
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