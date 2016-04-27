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
	.sub_intro_nav li:nth-child(1) a { color:#fff; background-color:#e77c71; }
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
				<p>Home &gt; 테라소개 &gt; 테라소개</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>테라소개</h1>
				<p>테라의 레이스 취지</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<?php include _BASE_DIR."/include/sub_intro_nav.php"; ?>
				<div class="subin_intro">


				<div class="first">
					<h2>사회의 동등한 일원으로서<br/>함께사는 사회를 위해 꿈을 실천하는 사람들 <span>TERRA</span></h2>
					<p>테라는 국적과 인종, 이념, 종교, 성별 등과 상관 없이 도움을 필요로 하는 이들을 위해<br />어디든지 달려가 도움의 손길을 전하는 비영리 공익재단입니다.
					<br/>테라는 모든 사람이 '함께 사는 사회'를 지향하고 실천 행동 비전으로 '나눔의 생활화'를 함께 추구하며<br />이를 통해 인간의 존엄과 가치를 지키는데 목적이 있습니다.
					</p>
				</div>

				<div class="line"></div>

				<div class="second">
					<div><img src="../images/intro/intro01.jpg" /></div>
					<dl>
						<dt class="bold">'함께 사는 사회'는 모든 구성원들이 <br/>인간의 존엄과 가치가 보장받도록 <br/>도움을 주는 사회입니다. </dt>
						<dd>인간의 존엄과 가치는 성, 지역, 연령, 인종, 더 나아가 도덕, 제도, 종교, 정치, 금전, 신체조건 등 그 어떠한 기준으로도 차별받지않는 평등권을 통해 지킬 수 있습니다. 테라는 모든 이들의 평등권을 기반으로 '함께 사는 사회'의 모든 구성원이 탄생부터 죽음에 이르기까지 동등하게 행복할 권리를 존중받고, 가능성에 대한 동등한 기회를 보장받으며, 사회의 동등한 일원으로서 상호 다양성에 대한 이해와 존중을 통해 평화를 추구하도록 지원합니다. 더 나아가 이를 방해하는 근본 문제를 확인하고 해결하기 위해 협력합니다.</dd>
					</dl>
					<div class="clear"></div>
				</div>
	
				<div class="third">
					<dl>
						<dt class="bold">'나눔의 생활화'는 사회에 대한 공감, <br/>상호 이해와 배려를 바탕으로 일상 속에서 <br/>나눔을 실천하도록 하는 것입니다.</dt>
						<dd>우리는 '나눔'을 일방향적 개념이 아니라, 나눔의 과정에 참여하는 모든 사람들이 궁극적으로 함께 행복해지는 순환적 개념으로 이해합니다. 우리는 '함께 사는 사회로 가는 나눔의 생활화'를 실현하기 위해 모든 개인, 단체, 지역사회와 대화하고 공감을 이끌어 내며 이를 바탕으로 협력합니다. 우리는 이와 같은 비전의 실현이 변화를 기반으로 이루어진다는 생각으로, 모든 활동 영역과 과정에 측정 가능한 기준을 제시하고 확인합니다.</dd>
					</dl>
					<div><img src="../images/intro/intro02.jpg" /></div>
					<div class="clear"></div>
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