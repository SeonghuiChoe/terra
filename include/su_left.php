<?php
	session_start();
	$userid = $_SESSION["userid"];
	$userlevel = $_SESSION["userlevel"];
	$username = $_SESSION["username"];
	//$username = iconv("euckr","utf8", $username);
	include _BASE_DIR."/common.php";
?>
<meta charset="utf-8">
<div class="nav_top"><?if($userid){?>
	<h3>관리자페이지</h3><br />
	<p><span class="username"><?= $username ?></span>님, 반갑습니다.</p>
	<p><a href="<?echo $cfg[url].'/su/su_member/su_logout.php'?>" onclick="return confirm('로그아웃 하시겠습니까?');">[로그아웃]</a></p>
	<?}else{?>
	<h3>관리자페이지</h3><br />
	<p>관리자로 로그인 해주세요.</p>
	<p><a href="./index.php">[로그인]</a></p>
	<?}?>
</div>


<dl class="su_left">
	<dt><a href="<?echo $cfg[url].'/su/su_plan/plan.php'?>">대회일정</a></dt>
	<dt><a href="<?echo $cfg[url].'/su/su_apply/apply.php?apply=1'?>">참가신청 현황</a></dt>
	<dt><a href="<?echo $cfg[url].'/su/su_board_n/list.php'?>">게시판 현황</a></dt>
		<dd><a href="<?echo $cfg[url].'/su/su_board_n/list.php'?>">공지사항</a></dd>
		<dd><a href="<?echo $cfg[url].'/su/su_board_f/list.php'?>">자유 게시판</a></dd>
		<dd><a href="<?echo $cfg[url].'/su/su_board_g/list.php'?>">갤러리</a></dd>
		<dd><a href="<?echo $cfg[url].'/su/su_board_qna/list.php'?>">Q&A</a></dd>
		<dd><a href="<?echo $cfg[url].'/su/su_board_rv/list.php'?>">대회 후기</a></dd>
	<dt><a href="<?echo $cfg[url].'/su/su_member/member_list.php'?>">회원가입 현황</a></dt>
</dl>
