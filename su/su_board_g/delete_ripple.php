<?
  include "../lib/dbconn.php";

  $table=$_GET["table"];
  $num=$_GET["num"];
  $page=$_GET["page"];
  $ripple_num=$_GET["ripple_num"];


  $sql="delete from bg_memo where bgm_num=$ripple_num";
  echo $sql;
  mysql_query($sql, $connect);
  mysql_close();

  echo ("
  <script>
  location.href='view.php?table=$table&num=$num&page=$page';
  </script>
  ");
?>