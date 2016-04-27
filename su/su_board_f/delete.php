<?
session_start();

include("../lib/dbconn.php");
$table=$_GET["table"];
$bf_num=$_GET["bf_num"];
$upload_dir="../data/";
$mypage=$_GET["mypage"];
$mode=$_GET["mode"];
$list=$_GET["list"];


if($mode=="deleteAll"){
	  	$list = explode("_",$list);
		$listNum = count($list);
		for($i=0;$i<$listNum-1;$i++){
			
		/*자유게시판은 사진없음
		$sql="select * from $table where bf_num=".$list[$i];
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
		*/
		
		$sql="delete from $table where bf_num=".$list[$i];
		mysql_query($sql, $connect);
		$sql="DELETE FROM bf_re WHERE bf_re_parent=".$list[$i];
		mysql_query($sql, $connect);

		}	
		echo("<script>alert('삭제가 완료되었습니다.');location.href='list.php?table=$table&page=$page';</script>");
	  
  }else{



/*자유게시판은 사진없음
$sql="SELECT * FROM $table WHERE bf_num=$bf_num";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

$copied_name[0]=$row[bf_copied_0];
$copied_name[1]=$row[bf_copied_1];
$copied_name[2]=$row[bf_copied_2];

for($i=0; $i<3; $i++){
	if($copied_name[$i]){
		$image_name=$upload_dir.$copied_name[$i];
		unlink($image_name);
	}
}*/

$sql="DELETE FROM $table WHERE bf_num=$bf_num";
mysql_query($sql, $connect);
$sql="DELETE FROM bf_re WHERE bf_re_parent=$bf_num";
mysql_query($sql, $connect);


if($mypage){
echo"<script>history.back();</script>";
}else{
echo"<script>location.href='./list.php?table=$table';</script>";
}

  }
  
  
  mysql_close();
  
?>