<?php
  session_start();
?>
<meta charset="utf-8">
<?php
  $userid=$_SESSION['userid'];
  $pass=$_POST['pass'];
  
  if(!$userid){echo "<script>window.alert('로그인을 해주세요.');
        location.href='./login_form.php';</script>";
  }else{
    include "../lib/dbconn.php";
	
	$sql="select * from member where m_id='$userid'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_assoc($result);
	$db_pass=$row[m_pass];
		if($pass!=$db_pass){
		  echo "<script>window.alert('비밀번호가 틀렸습니다.'); location.href='./check_delete.php?mode=1';</script>";
		  exit;
		}else{
			$sql="select * from apply where mem_id='$userid'";
			$result=mysql_query($sql, $connect);
			$total_record=mysql_num_rows($result);
				if($total_record>0){
					for($i=0;$i<$total_record;$i++){
					mysql_data_seek($result,$i);
					$row = mysql_fetch_assoc($result);
					$plan_sql="select * from plan where pla_idx=".$row[pla_idx];
					$plan_result=mysql_query($plan_sql, $connect);
					$plan_row = mysql_fetch_assoc($plan_result);
					
					if($plan_row[pla_date] > date("Y-m-d H:i:s") ){ 
						$total_date .= date("Y-m-d",strtotime($plan_row[pla_date]))."일자 레이스 참가예약이 되어있습니다.\\n";
						}
					}
					echo "<script>window.alert('".$total_date."취소후 탈퇴가 가능합니다.');location.href='./mypage.php';</script>";
				}else{
					$sql="delete from member where m_id='$userid'";
					mysql_query($sql, $connect);
					/*$sql="delete from apply where mem_id='$userid'";
					mysql_query($sql, $connect);*/#살려두는걸로
					echo "<script>window.alert('탈퇴가 완료되었습니다.');
					location.href='./logout.php';</script>";
			}
			
		}mysql_close();
	}
	
  

?>