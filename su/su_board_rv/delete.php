<?
session_start();
include "../../common.php";
$table=$_GET["table"];
$br_num=$_GET["br_num"];
$upload_dir=_BASE_DIR."/data/";
$mode=$_GET["mode"];
$list=$_GET["list"];


	if($mode=="deleteAll"){
		$list = explode("_",$list);
		$listNum = count($list);
		for($i=0;$i<$listNum-1;$i++){
			
		$sql="select * from $table where br_num=".$list[$i];
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
		
		$sql="delete from $table where br_num=".$list[$i];
		mysql_query($sql, $connect);
		$sql="delete from bg_memo where br_re_parent=".$list[$i];
		mysql_query($sql, $connect);
		}
		
		echo("<script>alert('삭제가 완료되었습니다.');location.href='list.php?table=$table&page=$page';</script>");
  
	  }else{
			$sql="SELECT * FROM $table WHERE br_num=$br_num";
			$result=mysql_query($sql, $connect);
			$row=mysql_fetch_array($result);

			$copied_name[0]=$row[br_copied_0];
			$copied_name[1]=$row[br_copied_1];
			$copied_name[2]=$row[br_copied_2];

			for($i=0; $i<3; $i++){
			if($copied_name[$i]){
			$image_name=$upload_dir.$copied_name[$i];
			unlink($image_name);
			}
			}

			$sql="DELETE FROM $table WHERE br_num=$br_num";
			mysql_query($sql, $connect);
			$sql="DELETE FROM br_re WHERE br_re_parent=$br_num";
			mysql_query($sql, $connect);
			
			echo("<script>alert('삭제가 완료되었습니다.');location.href='list.php?table=$table&page=$page';</script>");
	  
	  }
	  
	  mysql_close();
	  
	  
?>