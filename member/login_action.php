<?php
  session_start();
  $cu_page=$_POST['cu_page'];
  //예약정보 유알엘 가져오기
  $return_url=($cu_page)?urldecode($cu_page):"../index.php";// 로그인세션 정보받기 
  $apply =preg_replace("/[^0-9]*/s", "", $return_url);//숫자값만 가져오기(추출했더니 apply2의 2까지 딸려옴 ㅎㅎ)
?>
<meta charset="utf-8">
<?php
$id = $_POST["id"];
$pass = $_POST["pass"];

if(!$id){
	echo "<script>window.alert('아이디를 입력하지 않았습니다.');history.go(-1);</script>";
	exit;
}
if(!$pass){
	echo "<script>window.alert('비밀번호를 입력하지 않았습니다.');history.go(-1);</script>";
	exit;
}

include "../lib/dbconn.php";

$sql="select * from member where m_id='$id'";
$result = mysql_query($sql, $connect);
$row = mysql_fetch_assoc($result);

if(!$row){
	echo "<script>window.alert('등록되지 않는 아이디이거나 비밀번호가 틀렸습니다.');history.go(-1);</script>";
}else{
	$db_pass=$row[m_pass];
	if($pass!=$db_pass){
		echo "<script>window.alert('등록되지 않는 아이디이거나 비밀번호가 틀렸습니다.');history.go(-1);</script>";
		exit;
	}else{
		$userid=$row[m_id];
		$username=$row[m_name];
		$userlevel=$row[m_level];

		$sql="update member set m_last_login=now() where m_id='$userid'";
		$result = mysql_query($sql, $connect);

		$_SESSION["userid"]=$userid;
		$_SESSION["username"]=$username;
		$_SESSION["userlevel"]=$userlevel;

		mysql_close();
		if ($apply=="21"){
		?>
        <!-- 로그인세션 값을 기반으로 돌아가는 주소 -->
		<script>
		location.replace("<?=$return_url?>");
		</script>
		<?}else{
		echo "<script>history.go(-2);</script>";#세션정보 확인해서 쓰기
		}
	}
}
?>