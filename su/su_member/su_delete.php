<?php
  session_start();
?>
  <meta charset="utf-8">
<?php
  $userid=$_SESSION['userid'];
  $m_id=$_GET['m_id'];
  $page=$_GET['page'];
  
  if(!$userid){echo "<script>
        window.alert('로그인을 해주세요.');
        location.href='./index.php';
      </script>";
  }else{
    include "../../common.php";		
		
		$sql="select * from apply where mem_id='$m_id'";
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
				echo "<script>window.alert('".$total_date."취소후 탈퇴가 가능합니다.');history.back();</script>";
			}else{
				$sql="delete from member where m_id='$m_id'";
				mysql_query($sql, $connect);
				/*$sql="delete from apply where mem_id='$m_id'";
				mysql_query($sql, $connect);*/#살려두는걸로
				
				if($userid == $m_id){include _BASE_DIR."/su/su_member/su_logout.php";exit;}
				echo "<script>window.alert('탈퇴 처리가 완료되었습니다.');location.href='./member_list.php?page=$page';</script>";
			}
			mysql_close();
	}	
  

?>