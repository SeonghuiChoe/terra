<?php
  session_start();
?>
<meta charset="utf-8">
<?php
	$userid = $_SESSION["userid"];
	$userlevel=$_SESSION['userlevel'];
	$m_id=$_GET['m_id'];


  if($userlevel!=10){echo "<script>
        window.alert('관리자 페이지 입니다.');
      </script>";
  }else{
	#$pass=$_POST["pass"];
	$name=$_POST["name"];
	$gender=$_POST["gender"];
	$birth=$_POST["birth"];
    $phone=$_POST["phone"];
    $addr = $_POST["addr"].$_POST["addr0"];
    $addr1 = $_POST["addr1"];
    $addr2 = $_POST["addr2"];
    $addr3 = $_POST["addr3"];
    $email=$_POST["email"];
    $tsize=$_POST["tsize"];

    include "../../common.php";
	/*$sql="select * from member where m_id='$m_id'";
	$result = mysql_query($sql, $connect);
	$row = mysql_fetch_assoc($result);

	if ($pass==substr($row[m_pass],0,3).'****'){
		$pass=$row[m_pass];
	}*/

    $sql="update member set ";
    $sql.="m_name='$name', m_gender='$gender', m_birth='$birth', m_phone='$phone', m_addr='$addr', m_addr1='$addr1', m_addr2='$addr2', m_addr3='$addr3', m_email='$email', m_tsize='$tsize'";
    $sql.=" where m_id='$m_id'";

    $result = mysql_query($sql, $connect);
    mysql_close();
  }
  echo("
  <script>
  window.alert('수정이 완료되었습니다.');
  history.go(-2);
  </script>
  ");
?>