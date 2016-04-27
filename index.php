<?php
  session_start();
  include "./common.php";

  $page=1;

  $sql_n="select bn_num, bn_subject, bn_regist_day from board_n ORDER BY bn_num desc LIMIT 5";
  $result_n=mysql_query($sql_n, $connect);
  $rows_n=mysql_num_rows($result_n);

  $sql_rv="select br_num, br_title, br_reg_date from board_rv ORDER BY br_num desc LIMIT 5";
  $result_rv=mysql_query($sql_rv, $connect);
  $rows_rv=mysql_num_rows($result_rv);

  $sql_f="select bf_num, bf_title, bf_reg_date from board_f ORDER BY bf_num desc LIMIT 5";
  $result_f=mysql_query($sql_f, $connect);
  $rows_f=mysql_num_rows($result_f);

  $sql_p="select pla_idx, pla_name, pla_date from plan ORDER BY pla_idx desc LIMIT 2";
  $result_p=mysql_query($sql_p, $connect);
  $rows_p=mysql_num_rows($result_p);

  $sql_g="select bg_num, bg_id, bg_subject, bg_name, bg_regist_day, bg_file_copied_0 from board_g ORDER BY bg_num desc LIMIT 4";
  $result_g=mysql_query($sql_g, $connect);
  $rows_g=mysql_num_rows($result_g);

  $emptyData="<tr><td class='empty'>등록된 글이 없습니다.</td></tr>";
  $emptyData_g="<table><tr><td class='empty'>등록된 글이 없습니다.</td></tr></table>";
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>테라런 메인페이지 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="./css/common.css">

<!--메인배너-->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
<script src="./js/jquery.bxslider.min.js"></script>
<link href="./css/jquery.bxslider.css" rel="stylesheet" />
<script type="text/javascript">
        $(document).ready(function(){  
        $('#slider1').bxSlider({
        mode: 'fade',
        auto: true,
        autoControls: true,
        pause: 3000
        });
    });
</script>
<!--메인배너 좌우버튼-->
<script type="text/javascript">
	$(document).ready(function() {
        $(".bx-wrapper").bind({
			mouseover : function(){
			$(".bx-wrapper .bx-prev, .bx-wrapper .bx-next").fadeIn();
			},
			mouseleave : function(){
			$(".bx-wrapper .bx-prev, .bx-wrapper .bx-next").fadeOut();
			}
		});
    });
</script>

<!--탭부분-->
<script src="./js/maintab_board.js"></script>
<!--event3 소배너-->
<script type="text/javascript" src="./js/jquery.rotator.js"></script>
<script type="text/javascript">
	$(document).ready(function() {
		$("#rotator1").rotator({n:2});        
	});
</script>
<!--탑으로 이동버튼-->
<script src="./js/movetop.js"></script>

</head>
<body onload="init()">
	<div id="wraper">
		<header>
			<?php include _BASE_DIR."/include/header.php"; ?>
		</header>

		<section id="mainban">
			<div class="mainban slider">
                <ul id="slider1">
                <li><img src="images/index/main_ban1.jpg" alt="테라런사진1" title="테라런사진1"/></li>
                <li><img src="images/index/main_ban2.jpg" alt="테라런사진2" title="테라런사진2"/></li>
                <li><img src="images/index/main_ban3.jpg" alt="테라런사진3" title="테라런사진3"/></li>
                <li><img src="images/index/main_ban4.jpg" alt="테라런사진4" title="테라런사진4"/></li>
                </ul>
            </div>
		</section>

		<section id="contents">
			<div class="contents">
				<div class="con01">
					<ul id="tabs">
						<li><a href="#tab1">NOTICE</a></li>
						<li><a href="#tab2">REVIEW</a></li>
						<li><a href="#tab3">FREE</a></li>
					</ul>
					<div class="tabContent" id="tab1">
						<table>
							<?
							if($rows_n <= 0) {
							echo $emptyData;
							} else {
							for ($i=0; $i<$rows_n; $i++) {
							$num = mysql_result($result_n, $i, 0);
							$subject = mysql_result($result_n, $i, 1);
							$date = mysql_result($result_n, $i, 2);
							$date = date("Y-m-d",strtotime($date));
							?>
							<tr><td><a href="./board_n/view.php?table=board_n&num=<?=$num?>&page=<?=$page?>"><?=$subject?></a></td><td><?=$date?></td></tr>
							<? 
							}
							}
							?>
						</table>
					</div>
					<div class="tabContent" id="tab2">
						<table>
							<?
							if($rows_rv <= 0) {
							echo $emptyData;
							} else {
							for ($i=0; $i<$rows_rv; $i++) {
							$num = mysql_result($result_rv, $i, 0);
							$subject = mysql_result($result_rv, $i, 1);
							$date = mysql_result($result_rv, $i, 2);
							$date = date("Y-m-d",strtotime($date));
							?>
							<tr><td><a href="./board_rv/view.php?table=board_rv&br_num=<?=$num?>&page=<?=$page?>"><?=$subject?></a></td><td><?=$date?></td></tr>
							<? 
							}
							}
							?>
						</table>
					</div>
					<div class="tabContent" id="tab3">
						<table>
							<?
							if($rows_f <= 0) {
							echo $emptyData;
							} else {
							for ($i=0; $i<$rows_f; $i++) {
							$num = mysql_result($result_f, $i, 0);
							$subject = mysql_result($result_f, $i, 1);
							$date = mysql_result($result_f, $i, 2);
							$date = date("Y-m-d",strtotime($date));
							?>
							<tr><td><a href="./board_f/view.php?table=board_f&bf_num=<?=$num?>&page=<?=$page?>"><?=$subject?></a></td><td><?=$date?></td></tr>
							<? 
							}
							}
							?>
						</table>
					</div>
				</div>

				<div class="con02">
					<div class="tit"><h4>TODAY</h4><span class="today"><?echo date("Y년 m월d일");?></span></div>
					<div><h4>TERRARUN PLAN</h4><a href="./plan/plan.php"><p>+ 더보기</p></a></div>
					<div class="con">
						<table>
							<?
							if($rows_p <= 0) {
							echo $emptyData;
							} else {
							for ($i=0; $i<$rows_p; $i++) {
							$num = mysql_result($result_p, $i, 0);
							$subject = mysql_result($result_p, $i, 1);
							$date = mysql_result($result_p, $i, 2);
							$date1 = date("Y-m",strtotime($date));
							$date2 = date("d",strtotime($date));
							?>
							<tr>
								<td><span class="day"><?=$date2?></span><br><span class="date"><?=$date1?></span></td>
								<td><p><a href="./apply/apply.php?num_=<?=$num?>">제<?=$num?>회 <?=$subject?></a></p><p><span class="ready">접수중</span>&nbsp;<a href="./apply/apply.php?num_=<?=$num?>"><span class="apply">참가신청</span></a></p></td>
							</tr>
							<? 
							}
							}
							?>
						</table>
					</div>
				</div>

				<div class="con03">
					<div class="tit"><h4>GALLERY</h4></div>
					<div id="rotator1" class="con">
							
							<?
							if($rows_g <= 0) {
							echo $emptyData_g;
							} else {
							for ($i=0; $i<$rows_g; $i++) {
							$num = mysql_result($result_g, $i, 0);
							$id = mysql_result($result_g, $i, 1);
							$subject = mysql_result($result_g, $i, 2);
							$name = mysql_result($result_g, $i, 3);
							$date = mysql_result($result_g, $i, 4);
							$date = date("Y-m-d",strtotime($date));
							$img = mysql_result($result_g, $i, 5);
							$img = explode(",", $img);
							$img = $img[0];
							?>
							<table>
							<tr><td><a href="./board_g/view.php?table=board_g&num=<?=$num?>&page=<?=$page?>"><img src="./data/<?=$img?>" alt="최근 갤러리 이미지" title="최근 갤러리 이미지" /></a></td><td><p class="text"><a href="./board_g/view.php?table=board_g&num=<?=$num?>&page=<?=$page?>"><?=$subject?></a></p><p class="name"><?=$name?>(<?=$id?>)</p><p class="date"><?=$date?></p></td></tr>
							</table>
							<? 
							}
							}
							?>
							
					</div>
			
					
					<!--<ul>
						<li><img src="./images/index/gal_01.png" alt="최근 갤러리 이미지" title="최근 갤러리 이미지" /></li>
						<li>
							<p>내용</p><p>날짜</p>
						</li>
						<li><img src="./images/index/gal_02.png" alt="" /></li>
					</ul>

					<div><a href="./apply/apply2.php"><img src="./images/index/ban_apply1.png" alt="테라런 참가신청하기" title="테라런 참가신청하기" /></a></div>-->



				</div>
			
			
			</div>
		</section>

		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
	</div>
</body>
</html>