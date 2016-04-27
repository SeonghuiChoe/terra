<?php
	$username = $_SESSION["username"];
	$userid = $_SESSION["userid"];
	$userlevel = $_SESSION["userlevel"];
	
?>
<div class="header_top">
	<div class="login">
	<?php
	if(!$userid){
	?>
	<a href="<?echo $cfg[url].'/member/login.php'?>">로그인</a> | 
	<a href="<?echo $cfg[url].'/member/join_ok.php'?>">회원가입</a>
	<?php
	} else {
		if($userlevel==10){
	?>
		<span><span class="bold">관리자</span>님 반갑습니다.</span> |
		<a href="<?echo $cfg[url].'/member/logout.php'?>">로그아웃</a> | 
		<a href="<?echo $cfg[url].'/su/su_apply/apply.php'?>">관리자페이지</a>
		<?
		} else {
		?>
		<span><span class="bold"><?=$username?>(<?=$userid?>)</span>님 반갑습니다. </span> | 
		<a href="<?echo $cfg[url].'/member/logout.php'?>">로그아웃</a> | 
		<a href="<?echo $cfg[url].'/member/mypage.php'?>">마이페이지</a>
		<?
		}
		?> 
	<?php
	}
	?>
	</div>
</div>

<div class="header_logo">
<span><a href="<?echo $cfg[url].'/index.php'?>"><img src="<?echo $cfg[url].'/images/logo.png'?>" alt="테라로고" /></a></span>
</div>

<nav class="nav_cust">
<ul>
	<li class="active has-sub"><a href="<?echo $cfg[url].'/intro/intro.php'?>">테라소개</a><ul>
         <li class='has-sub'><a href='<?echo $cfg[url].'/intro/intro.php'?>'>테라소개</a></li>
         <li class='has-sub'><a href='<?echo $cfg[url].'/intro/terrarun.php'?>'>대회소개</a></li>
		 <li class='has-sub'><a href='<?echo $cfg[url].'/intro/location.php'?>'>테라위치</a></li>
      </ul></li><li><a href="<?echo $cfg[url].'/plan/plan.php'?>">대회일정</a></li><li><a href="<?echo $cfg[url].'/apply/apply2.php?apply=1'?>">참가신청</a><!--<ul><li class="has-sub"><a href='<?echo $cfg[url].'/apply/apply.php'?>'>참가신청</a></li><li class="has-sub"><a href='<?echo $cfg[url].'/apply/apply_list.php'?>'>참가신청현황</a></li></ul>--></li><li class="active has-sub"><a href="<?echo $cfg[url].'/board_n/list.php'?>">커뮤니티</a><ul>
         <li class='has-sub'><a href='<?echo $cfg[url].'/board_n/list.php'?>'>공지사항</a></li>
         <li class='has-sub'><a href='<?echo $cfg[url].'/board_f/list.php'?>'>자유게시판</a></li>
		 <li class='has-sub'><a href='<?echo $cfg[url].'/board_g/list.php'?>'>갤러리</a></li>
		 <li class='has-sub'><a href='<?echo $cfg[url].'/board_qna/list.php'?>'>Q&A</a></li>
		 <li class='has-sub'><a href='<?echo $cfg[url].'/board_rv/list.php'?>'>대회후기</a></li>
      </ul></li>
</ul>

</nav>

<div id="quick">
<div class="first">Quick</div>
<div class="last">
<a href="http://heeday1436.dothome.co.kr"><div class="intro">Intro</div></a>
<a href="http://heeday1436.dothome.co.kr/pf1/index.html"><div class="rodls">기업</div></a>
<a href="http://heeday1436.dothome.co.kr/pf2/index.html"><div class="phone">모바일</div></a>
<a href="http://heeday1436.dothome.co.kr/pf3/index.php"><div class="rel">반응형</div></a>
<a href="http://heeday1436.dothome.co.kr/pf4/index.html"><div class="single">SPA</div></a>
</div>
</div>