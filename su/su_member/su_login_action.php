<?php
  session_start();
?>
<meta charset="utf-8">
<?php
  $id = $_POST["id"];
  $pass = $_POST["pass"];

  if(!$id){
    echo("
      <script>
        window.alert('아이디를 입력해 주세요.');
        history.go(-1);
      </script>
    ");
    exit;
  }
  if(!$pass){
    echo("
      <script>
        window.alert('비밀번호를 입력해 주세요.');
        history.go(-1);
      </script>
    ");
    exit;
  }

  include "../lib/dbconn.php";

  $sql="select * from member where m_id='$id'";
  $result=mysql_query($sql, $connect);

  $num_match=mysql_num_rows($result);
  if(!$num_match){
    echo("
      <script>
        window.alert('등록되지 않는 아이디이거나 비밀번호가 틀렸습니다.');
        history.go(-1);
      </script>
    ");
	exit;
  }

  $row=mysql_fetch_array($result);
  $db_id=$row[m_id];
  $db_pass=$row[m_pass];
  $db_level=$row[m_level];

  if($pass!=$db_pass){
      echo("
        <script>
          window.alert('등록되지 않는 아이디이거나 비밀번호가 틀렸습니다.');
          history.go(-1);
        </script>
      ");
      exit;
    }

  if($db_level==10 && $pass==$db_pass && $id==$db_id){
	  $userid=$row[m_id];
      $username=$row[m_name];
      $userlevel=$row[m_level];

      $_SESSION["userid"]=$userid;
      $_SESSION["username"]=$username;
      $_SESSION["userlevel"]=$userlevel;

      echo("
        <script>
          location.href='../su_apply/apply.php';
        </script>
      ");
  } else {
	echo("
      <script>
        window.alert('권한이 없는 아이디 입니다.');
        history.go(-1);
      </script>
    ");
  }
?>