<?php	
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	
	include "../../common.php";	
	include _BASE_DIR."/lib/business.php";

	$table = "plan";
	$column = "pla_idx";

	$pla_idx = isset($_GET['num_']) ? $_GET['num_'] : '';

	#var_dump($_GET);
	//DELETE FROM plan WHERE pla_idx =4


	$sql="select * from $table where $column = $pla_idx";
	$result=$connect->query($sql);
	$row=mysqli_fetch_array($result);

	$copied_name[0]=$row[pla_file_name_0];
	$copied_name[1]=$row[pla_file_name_1];
	
	for($i=0; $i<2; $i++){
	if($copied_name[$i]){
	$image_name="../".$upload_dir.$copied_name[$i];
	unlink($image_name);
	}
	}		
	$sql = "delete from ".$table." where ".$column." = '".$pla_idx."'";
	$result=$connect->query($sql);
	#ar_dump($sql);

	if($connect->query($sql)){
		echo "<script>alert('정상적으로 삭제되었습니다.');location.href='plan.php';</script>";
	}else{

		echo $connect->error;
	}
	$connect->close();
?>