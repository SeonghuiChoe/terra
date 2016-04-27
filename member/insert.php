<meta charset="utf-8">
<?php
  $id = $_POST["id"];
  $pass = $_POST["pass"];
  $name = $_POST["name"];
  $phone = $_POST["phone"];
  $email = $_POST["email"];
  $addr = $_POST["addr"].$_POST["addr0"];
  $addr1 = $_POST["addr1"];
  $addr2 = $_POST["addr2"];
  $addr3 = $_POST["addr3"];
  $tsize = $_POST["tsize"];
  $gender = $_POST["gender"];
  $birth = $_POST["birth"];

  include "../lib/dbconn.php";

  $sql = "select * from member where m_id='$id'";
  $result = mysql_query($sql, $connect);
  $exist_id = mysql_fetch_assoc($result);

  if(!preg_match("/^[a-z]/", $id)) {
		echo "<script>window.alert('아이디의 첫글자는 영문이어야 합니다.');
      history.go(-1);
    </script>";
  }
  else if(preg_match("/[^a-z^0-9^_]/", $id)) {
		echo "<script>window.alert('아이디는 영문, 숫자, _ 만 사용할 수 있습니다.');
      history.go(-1);
    </script>";
  }
  else if($exist_id){
    echo("
    <script>
      window.alert('해당 아이디가 존재합니다.');
      history.go(-1);
    </script>
    ");
    exit;
  }else{
    $sql="insert into member(m_id, m_pass, m_name, m_gender, m_birth, m_phone, m_addr, m_addr1, m_addr2, m_addr3, m_email, m_regist_day, m_level, m_tsize) values('$id', '$pass', '$name', '$gender','$birth','$phone', '$addr','$addr1','$addr2', '$addr3', '$email', now(), 1, '$tsize')";
    mysql_query($sql, $connect);
	mysql_close();
	 echo ("<script>window.alert('가입 완료');
     location.href='../index.php';</script>");
  }
  
?>