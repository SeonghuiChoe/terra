<?php
session_start();
$userid = $_SESSION["userid"];
$username = $_SESSION["username"];
$userlevel = $_SESSION["userlevel"];
include "../../common.php";
$race=$_GET['race'];
$m_id=$_GET['m_id'];
$page=$_GET['page'];
$searchColumn=$_GET['searchColumn'];
$searchText=$_GET['searchText'];

if(!$userid){echo "<script>window.alert('로그인을 해주세요.');location.href='./index.php';</script>";exit;}
if($userlevel!=10 ){echo "<script>window.alert('관리자만 접근가능합니다.');</script>";exit;}

$sql="select * from member where m_id='$m_id'";
$result = mysql_query($sql, $connect);
$row = mysql_fetch_assoc($result);

/*if(!$row[m_id]){
	include _BASE_DIR."/su_member/logout.php";
	echo "<script>window.alert('로그인 정보가 없습니다.');location.href='./index.php';</script>";
	} #만약 mypage에서 회원정보가 사라졌을때

$sql="select * from apply where mem_id='$userid'";
$result2 = mysql_query($sql, $connect);
$total_record=mysql_num_rows($result2);
$row2 = mysql_fetch_assoc($result2);*/

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>회원 정보 자세히보기 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
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
				<p>테라런 회원 자세히보기</p>
			</header>
			<div class="right_cont">

				
		<table class="mypage_table">
		<tr><th>아이디</th><td><?= $row[m_id] ?></td></tr>
		<!--<tr><td class="su_mypage_td">비밀번호</td><td class="mypage_tdv"><?echo substr($row[m_pass],0,3)."****" ?></td></tr>-->
		<tr><th>이름</th><td><?= $row[m_name] ?></td></tr>
		<tr><th>성별</th><td><?= $row[m_gender] ?>자</td></tr>
		<tr><th>생년월일</th><td><?$addr=substr($row[m_birth],0,4); echo $addr."년 "; ?><?$addr=substr($row[m_birth],4,2); echo $addr."월 "; ?><?$addr=substr($row[m_birth],6,2); echo $addr."일 "; ?></td></tr>
		<tr><th>전화번호</th><td><?= $row[m_phone] ?></td></tr>
		<tr><th>주소</th><td class="addr">우편번호) <?$addr=substr($row[m_addr],0,3); echo $addr; ?> - <?$addr2=substr($row[m_addr],3,3); echo $addr2; ?><br />도로) <?= $row[m_addr1] ?> <br />지번) <?= $row[m_addr2] ?><br />상세주소) <?= $row[m_addr3] ?></td></tr>
		<tr><th>이메일</th><td><?= $row[m_email] ?></td></tr>
		<tr><th>옷 사이즈</th><td><? if($row[m_tsize]==0){echo "사이즈등록바람";}else{switch($row[m_tsize]){case 85: echo "XS";break;case 90: echo "S";break;case 95: echo "M";break;case 100: echo "L";break;case 105: echo "XL";break;case 110: echo "XXL";break;case 115: echo "XXXL";break;}echo " (".$row[m_tsize].")";} ?></td></tr><?#0:수정	1:탈퇴	2:비번번경 ?>
		<tr><th>가입날짜</th><td><?= $row[m_regist_day] ?></td></tr>
		<tr><th>로그인날짜</th><td><?= $row[m_last_login] ?></td></tr>
		<tr><th>수정날짜</th><td><?= $row[m_last_update] ?></td></tr>
	</table>

	<div id="button">
	<a href="javascript:history.back();">목록보기</a>	<a href="<?echo "javascript:location.href='./su_modify_form.php?m_id=$row[m_id]&page=$page';"; ?>">정보수정</a> <a href="./su_delete.php?m_id=<?=$row[m_id]?>&page=<?=$page?>" 
	<?if($userid==$row['m_id']){echo "본인을 ";} ?>onclick="return confirm('<?if($userid==$row['m_id']){echo "본인을 ";} ?>강제탈퇴를 시키시겠습니까?');">강제탈퇴</a>
	</div>




			</div>
		</section>
		</div>
		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
		</div>
	</div>
<?php
mysql_close();
?>
</body>
</html>