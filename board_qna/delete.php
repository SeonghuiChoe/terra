<?php
  session_start();

  $table=$_GET["table"];
  $num=$_GET["num"];
  if($_GET["bq_num"]){
	  $num = $_GET["bq_num"];
  }
  $page=$_GET["page"];
  $mypage=$_GET["mypage"];
  $test=$_GET["test"];

  if(!$_SESSION['userid']){
    echo ("<script>history.go(-1);</script>");
    exit;
  }else{
    include "../lib/dbconn.php";

    $sql="select * from $table where bq_num=$num";
    $result=mysql_query($sql, $connect);
    $row=mysql_fetch_array($result);
    $chk_id=$row['bq_id'];

    if($chk_id==$_SESSION['userid'] or $_SESSION['userlevel']==10){
      $sql="delete from $table where bq_num=$num";
      mysql_query($sql, $connect);
    }

    mysql_close();
  }
if($mypage) {
echo"<script>location.href='../member/list.php?page=$page&test=$test'</script>";
} else {
echo"<script>location.href='./list.php?table=$table&num=$num&page=$page';</script>";
}
?>