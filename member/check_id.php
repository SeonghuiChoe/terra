<meta charset="utf-8">
<?php
  $id = $_GET[id];
  if(!$id){
    echo("아이디를 입력하세요.");
  }else{
	  if(!preg_match("/^[a-z]/", $id)) {
		echo "아이디의 첫글자는 영문이어야 합니다.";
	  }
	  else if(preg_match("/[^a-z^0-9^_]/", $id)) {
		echo "아이디는 영문, 숫자, _ 만 사용할 수 있습니다.";
	  }
	  else{
		include "../lib/dbconn.php";
    
		$sql="select * from member where m_id='$id'";
		$result = mysql_query($sql, $connect);
		$num_record = mysql_fetch_assoc($result);
    
		if($num_record){
		  echo "아이디가 중복됩니다.<br>다른 아이디를 사용하세요.<br>";
		  /* "<script>window.alert('아이디가 중복됩니다.');history.go(-1);</script>" */
		}else{
		  echo "사용가능한 아이디입니다.";
		}
	mysql_close();
	}
  }
?>