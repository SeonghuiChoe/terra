<?require_once("./mypage_h.php");?>

<?php

$race=$_GET['race'];

$sql="select * from member where m_id='$userid'";
$result = mysql_query($sql, $connect);
$row = mysql_fetch_assoc($result);

if(!$row[m_id]){
	include "./logout.php";
	echo "<script>window.alert('로그인 정보가 없습니다.');location.href='./login_form.php';</script>";
	} #만약 mypage에서 회원정보가 사라졌을때

$sql="select * from apply where mem_id='$userid'";
$result2 = mysql_query($sql, $connect);
$total_record=mysql_num_rows($result2);
$row2 = mysql_fetch_assoc($result2);

?>
	<div class="mypage_con"><span class="name"><?= $row[m_name] ?>(<?= $row[m_id] ?>)</span>님의 정보입니다.<br/>
	회원정보는 개인정보취급방침에 따라 안전하게 보호되며, 회원님의 명백한 동의 없이 공개 또는 제 3자에게 제공되지 않습니다. </div>
	<table class="mypage_table">
		<tr><th>아이디</th><td class="mypage_tdv"><?= $row[m_id] ?></td></tr>
		<tr><th>이름</th><td class="mypage_tdv"><?= $row[m_name] ?></td></tr>
		<tr><th>성별</th><td class="mypage_tdv"><?= $row[m_gender] ?>자</td></tr>
		<tr><th>생년월일</th><td class="mypage_tdv"><?$addr=substr($row[m_birth],0,4); echo $addr."년 "; ?><?$addr=substr($row[m_birth],4,2); echo $addr."월 "; ?><?$addr=substr($row[m_birth],6,2); echo $addr."일 "; ?></td></tr>
		<tr><th>전화번호</th><td class="mypage_tdv"><?= $row[m_phone] ?></td></tr>
		<tr><th class="addr">주소</th><td>우편번호) <?$addr=substr($row[m_addr],0,3); echo $addr; ?> - <?$addr2=substr($row[m_addr],3,3); echo $addr2; ?><br />도로) <?= $row[m_addr1] ?> <br />지번) <?= $row[m_addr2] ?><br />상세주소) <?= $row[m_addr3] ?></td></tr>
		<tr><th>이메일</th><td class="mypage_tdv"><?= $row[m_email] ?></td></tr>
		<tr><th>옷 사이즈</th><td class="mypage_tdv"><? if($row[m_tsize]==0){echo "사이즈등록바람";}else{switch($row[m_tsize]){case 85: echo "XS";break;case 90: echo "S";break;case 95: echo "M";break;case 100: echo "L";break;case 105: echo "XL";break;case 110: echo "XXL";break;case 115: echo "XXXL";break;}echo " (".$row[m_tsize].")";} ?></td></tr><?#0:수정	1:탈퇴	2:비번번경?>
	</table>
	<div id="button">
		<a href="./check_delete.php?mode=0">정보수정</a>
		<a href="./check_delete.php?mode=2">비밀번호 변경</a>
		<a href="./check_delete.php?mode=1">탈퇴하기</a>
	</div>
	<!--
	<div id="button">
		<a href="./check_delete.php?mode=0"><input type="button" value="정보수정" class="mypage_btn"  /></a>
		<a href="./check_delete.php?mode=2"><input type="button" value="비밀번호 변경" class="mypage_btn"  /></a>
		<a href="./check_delete.php?mode=1"><input type="button" value="탈퇴하기" class="mypage_btn" /></a>
	</div>-->


<?php
mysql_close();
require_once("./mypage_f.php");
?>
