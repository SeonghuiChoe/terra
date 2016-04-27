<?php
  session_start();
?>
<meta charset="utf-8">
<?php
  $userid=$_SESSION['userid'];
  $postid=$_POST['id'];
  
  if(!$userid){echo "<script>window.alert('로그인을 해주세요.');location.href='./login.php';</script>";
  }else{
    $phone=$_POST["phone"];
    $addr = $_POST["addr"].$_POST["addr0"];
    $addr1 = $_POST["addr1"];
    $addr2 = $_POST["addr2"];
    $addr3 = $_POST["addr3"];
    $email=$_POST["email"];
    $tsize=$_POST["tsize"];
    $last_update=date("Y-m-d (H:i)");

    include "../lib/dbconn.php";

    $sql="update member set ";
    $sql.="m_phone='$phone', m_addr='$addr', m_addr1='$addr1', m_addr2='$addr2', m_addr3='$addr3', m_email='$email', m_last_update='$last_update', m_tsize='$tsize'";
    $sql.=" where m_id='$userid'";

    $result = mysql_query($sql, $connect);
    mysql_close();
  }
  echo("
  <script>
  window.alert('수정이 완료되었습니다.');
  location.href='./mypage.php';
  </script>
  ");
?>