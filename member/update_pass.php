<?php
  session_start();
?>
<meta charset="utf-8">
<?php
  $userid=$_SESSION['userid'];
  $pass=$_POST['pass'];
  $newpass=$_POST['newpass'];
  
  if(!$userid){echo "<script>window.alert('로그인을 해주세요.');location.href='./login.php';</script>";
  }else{
    include "../lib/dbconn.php";
	
	$sql="select * from member where m_id='$userid'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_assoc($result);
	$db_pass=$row[m_pass];
	if($pass!=$db_pass){
      echo "<script>window.alert('비밀번호가 틀렸습니다.'); location.href='./check_delete.php?mode=2';</script>";
      exit;
	}
	else{		
		$sql="update member set m_pass='$newpass' where m_id='$userid'";
		mysql_query($sql, $connect);
		echo "<script>  window.alert('비밀번호 변경이 완료되었습니다.');
		location.href='./mypage.php';</script>";
		
		mysql_close();
		}
	}
	
  

?>