<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];

	include "../../common.php";
    include _BASE_DIR."/lib/business.php";

	$table = "apply";
	$column = "ap_pub_num";
	
	$pla_idx = isset($_GET['num_']) ? $_GET['num_'] : '';
	$sql = "delete from ".$table ." where ". $column. " = '".$pla_idx."'";

	if($connect->query($sql)){
		echo "<script>alert('정상적으로 삭제되었습니다.');location.href='./apply.php';</script>";
	} else{
		echo $connect->error;
	}

	$connect->close();
?>	