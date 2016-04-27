<?php
  session_start();
  include "../../common.php";

  $table=$_GET["table"];
  $num=$_GET["num"];
  $upload_dir=_BASE_DIR."/data/";
  $page=$_GET["page"];
  $mode=$_GET["mode"];
  $list=$_GET["list"];
  
  if($mode=="deleteAll"){
	  
		$list = explode("_",$list);
		$listNum = count($list);
		for($i=0;$i<$listNum-1;$i++){
			
		$sql="select * from $table where bn_num=".$list[$i];
		$result=mysql_query($sql, $connect);
		$row=mysql_fetch_array($result);

		$copied_name[0]=$row[bn_file_copied_0];
		$copied_name[1]=$row[bn_file_copied_1];
		$copied_name[2]=$row[bn_file_copied_2];


		for($j=0; $j<3; $j++){
			if($copied_name[$j]){
			$image_name=$upload_dir.$copied_name[$j];
			unlink($image_name);
			}
		}
		
		$sql="delete from $table where bn_num=".$list[$i];
		mysql_query($sql, $connect);

		}	
		
		echo("<script>alert('삭제가 완료되었습니다.');location.href='list.php?table=$table&page=$page';</script>");
	  
  }else{

  $sql="select * from $table where bn_num=$num";
  $result=mysql_query($sql, $connect);
  $row=mysql_fetch_array($result);

  $copied_name[0]=$row[bn_file_copied_0];
  $copied_name[1]=$row[bn_file_copied_1];
  $copied_name[2]=$row[bn_file_copied_2];

  for($i=0; $i<3; $i++){
    if($copied_name[$i]){
      $image_name=$upload_dir.$copied_name[$i];
      unlink($image_name);
    }
  }

  $sql="delete from $table where bn_num=$num";
  mysql_query($sql, $connect);
  

  echo("<script>location.href='list.php?table=$table&num=$num&page=$page';</script>");
  
  }
  
  mysql_close();
  
?>