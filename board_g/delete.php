<?php
  session_start();
  include "../lib/dbconn.php";

  $table=$_GET["table"];
  $upload_dir="../data/";
  $page=$_GET["page"];
  $num=$_GET["num"];
  if($_GET["bg_num"]){
	$num=$_GET["bg_num"];
  }  
  $mypage=$_GET["mypage"];
  $test=$_GET["test"];

  $sql="select * from $table where bg_num=$num";
  $result=mysql_query($sql, $connect);
  $row=mysql_fetch_array($result);

  $total_image_copied=$row[bg_file_copied_0];
  $image_copied=explode(",", $total_image_copied);
  $file_cnt=count($image_copied);
  
  //$copied_name[0]=$row[bg_file_copied_0];
  //$copied_name[1]=$row[bg_file_copied_1];
  //$copied_name[2]=$row[bg_file_copied_2];

  for($i=0; $i<$file_cnt; $i++){
    if($image_copied[$i]){
      $image_name=$upload_dir.$image_copied[$i];
      unlink($image_name);
    }
  }

  $sql="delete from $table where bg_num=$num";
  mysql_query($sql, $connect);
  mysql_close();

  if($mypage) {
echo"<script>location.href='../member/list.php?&test=$test&page=$page'</script>";
} else {
echo"<script>location.href='./list.php?table=$table&num=$num&page=$page';</script>";
}
?>