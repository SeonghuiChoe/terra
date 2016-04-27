<?php
  session_start();
  include "../../common.php";

  $table=$_GET["table"];
  $num=$_GET["num"];
  $page=$_GET["page"];
  $mode=$_GET["mode"];
  $list=$_GET["list"];

  if($_SESSION['userlevel']!=10){
    echo "<script>history.go(-1);</script>";
    exit;
  }else{
	if($mode=="deleteAll"){
		$list = explode("_",$list);
		$listNum = count($list);
		for($i=0;$i<$listNum-1;$i++){			
			$sql="delete from $table where bq_num=".$list[$i];
			mysql_query($sql, $connect);#관리자가 삭제시 답변도 같이 삭제?
			$sql="delete from $table where bq_group_num=".$list[$i];
			mysql_query($sql, $connect);
		}	
		echo("<script>alert('삭제가 완료되었습니다.');location.href='list.php?table=$table&page=$page';</script>");
  
	  }else{		  
		$sql="select * from $table where bq_num=$num";
		$result=mysql_query($sql, $connect);
		$row=mysql_fetch_array($result);
		$chk_id=$row['bq_id'];
		if($chk_id==$_SESSION['userid'] or $_SESSION['userid']=="admin"){
		  $sql="delete from $table where bq_num=$num";
		  mysql_query($sql, $connect);
		  
		}
		echo ("<script>location.href='list.php';</script>");
	  }
	  
	  mysql_close();
  }
?>