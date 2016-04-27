<?php
  session_start();
  include("../lib/dbconn.php");
?>
<meta charset="utf-8">
<?php
  $userid=$_SESSION["userid"];
  $username=$_SESSION["username"];
  $usernick=$_SESSION["usernick"];
  $ripple_content=$_POST["ripple_content"];
  $table=$_GET["table"];
  $ripple=$_GET["ripple"];
  $num=$_GET["num"];
  $page=$_GET["page"];


  if(!$userid){
    echo("
    <script>
    window.alert('로그인을 하십시요');
    location.href='../../member/login.php';
    </script>
    ");
    exit;
  }

  $regist_day=date("Y-m-d (H:i)");

  include "../lib/dbconn.php";

  $sql="insert into $ripple (bgm_parent, bgm_id, bgm_name, bgm_nick, bgm_content, bgm_regist_day) ";
  $sql.="values ('$num', '$userid', '$username', '$usernick', '$ripple_content','$regist_day')";
  mysql_query($sql, $connect);



  echo("
  <script>
  location.href = 'view.php?table=$table&num=$num&page=$page';
  </script>
  ");
   mysql_close();
?>