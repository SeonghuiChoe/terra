<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	include "../../common.php";

	if($userlevel!=10){echo "<script>window.alert('권한이 없는 아이디 입니다.');history.go(-1);</script>";}

	$searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
	$searchText=$_GET["searchText"]; // 페이징 searchText
	$scale=10;//한페이지 글 갯수 정의

	$search=$_GET["search"];

	require_once("../lib/su_paging.php"); // 페이징 PHP 호출

	if(!$userid){echo "<script>window.alert('로그인을 해주세요.');location.href='./index.php';</script>";exit;}
	  
	$result=mysql_query($sql_p, $connect);
	$total_record=mysql_num_rows($result);

	if(!$page or $page<1){
	$page=1;
	}

	$start=($page-1)*$scale;
	$number=$total_record-$start;

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>전체 회원보기 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<!--<link rel="stylesheet" type="text/css" href="../css/common.css">-->
<link rel="stylesheet" type="text/css" href="../css/normalize.css">
<style type="text/css">
	.su_left dt:nth-child(9) a { color:#fff; background-color:#1eb4a8; }
</style>
</head>
<body>
	<div id="wraper">
		<div id="all">
		<header class="su_logo">
			<span><a href="<?echo $cfg[url].'/index.php'?>"><img src="<?echo $cfg[url].'/images/logo_g.png'?>" alt="테라로고" /></a></span>
		</header>

		<div class="bottom">
		<nav id="nav_su">
			<?php include _BASE_DIR."/include/su_left.php"; ?>
		</nav>
		<section id="su_content">
			<header class="right_title">
				<h1>회원가입 현황</h1>
				<p>테라런 회원가입 현황</p>
			</header>
			<div class="right_cont">
				<div class="member_list_con">
				<p>총 <?=$total_record?>명의 회원이 있습니다.</p>
				<form action="./member_list.php" method="GET">
				<select name="search">
				<option <?php echo $search=='asc'?'selected="selected"':null?> value="asc">가입일순서</option>
				<option <?php echo $search=='desc'?'selected="selected"':null?> value="desc">가입일역순서</option>
				</select>
				<input type="hidden" name="searchColumn" value="<?=$searchColumn?>" /><input type="hidden" name="searchText" value="<?=$searchText?>" />
				<button type="submit">검색</button>
				</form>
				</div>

				<? if(empty($allPost_p)){echo "회원정보가 없습니다.";}else{
				echo "<table class='member_list_table'><tr><th>ID</th><th>이름</th><th>가입 날짜</th><th>마지막 로그인</th><th>level</th><th class='m_d'>수정/탈퇴</th></tr>";


				for($i=$start; $i<$start+$scale && $i<$total_record; $i++){
				mysql_data_seek($result,$i);
				$row = mysql_fetch_assoc($result);
				$date = date("Y-m-d",strtotime($row[m_regist_day]));
				if($row[m_last_login]){$date2 = date("Y-m-d",strtotime($row[m_last_login]));}else{$date2="";}
				?>
				<tr><td><?= $row[m_id] ?></td><td class="name"><?= $row[m_name] ?></td><td><?= $date ?></td><td><?= $date2 ?></td><td><?= $row[m_level] ?></td><td class="m_d"><a href="./su_mypage.php?m_id=<?=$row[m_id]?>&page=<?=$page?>&searchColumn=<?=$searchColumn?>&searchText=<?=$searchText?>"><input type="button"  value="자세히" class="su_btn" /></a></td></tr>
				<?  $number--;}}

				if(!$_GET["page"])
				$pages=1;
				else
				$pages=$_GET["page"];
				?>
				<tr>
				<td colspan="11" class="member_list_center">
				<div id="boardList"><!-- paging search -->
				<div class="paging">
				<div class="paging"><? echo "<br>".$paging."<br>" ?></div>
				</div>

				<div class="searchBox"> <!-- 게시판별 컬럼명 맞춰야함 -->
				<form action="./member_list.php" method="GET">
				<select name="searchColumn">
				<option <?php echo $searchColumn=='m_id'?'selected="selected"':null?> value="m_id">회원ID</option>
				<option <?php echo $searchColumn=='m_name'?'selected="selected"':null?> value="m_name">회원이름</option>
				</select><input type="hidden" name="search" value="<?=$search?>" />
				<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
				<button type="submit">검색</button>
				</form>
				</div><!-- div_searchBox -->

				</div><!-- member_list_center_searchBox -->
				</td>
				</tr>
				</table>
			</div><!--right_cont end-->

		
		</section>
		</div><!--su_content end-->

		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
		</div>
	</div>
	<?php mysql_close(); ?>
</body>
</html>