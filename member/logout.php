<?php
  session_start();
  unset($_SESSION['userid']);
  unset($_SESSION['username']);
  unset($_SESSION['userlevel']);

  echo "<script>location.href='../index.php';</script>";#세션정보로돌아기기
?>