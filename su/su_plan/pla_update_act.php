<?php

session_start();
	include "../../common.php";	
	include _BASE_DIR."/lib/business.php";

#if has not session page return -> login.php 
//$planboard = new board();
//$planboard->check_admin_session();
$table = "plan";
$column = "pla_idx";
// $values from html
/*

marathon date	
marathon place	
marathon distance	
marathon name	
marathon fee	
marathon file
*/

//$plan_board = new board();
//$uploaded = $plan_board->image_FileUpload();

//$value = isset($_POST['value']) ? $_POST['value'] : '';.

$pla_idx = isset($_POST['num_']) ? $_POST['num_'] : '';


$pla_date = isset($_POST['pla_date']) ? $_POST['pla_date'] : '';
#echo $pla_date." <-- 이거 ";



$pla_time = isset($_POST['pla_time']) ? $_POST['pla_time'] : '';
// echo $pla_time;
$pla_place = isset($_POST['pla_place']) ? $_POST['pla_place'] : '';
$pla_distance = isset($_POST['pla_distance']) ? $_POST['pla_distance'] : '';
$pla_name = isset($_POST['pla_name']) ? $_POST['pla_name'] : '';
$pla_period1 = isset($_POST['pla_period']) ? $_POST['pla_period'] : '';
$uploaded = isset($_POST['upfile[]']) ? $_POST['upfile[]'] : '';




#날짜 시간관련 업데이트가 안되고 있다. 

//now  
$now = date('Y-m-d H:i:s',time());


$date = new DateTime();
#var_dump($date);
//YYYY-MM-DD HH:MM:SS
//2015-08-05
date_date_set($date, substr($pla_date,0,4),substr($pla_date,5,2),substr($pla_date,8,2) );
 #setTime ( int $hour , int $minute [, int $second = 0 ] )

$pla_date = date_format($date,'Y-m-d');
// $date = new DateTime();
// date_date_set($date, substr($pla_date,0,4),substr($pla_date,5,2),substr($pla_date,8,2) );
// $pla_date =date_format($date,'Y-m-d');
//echo "<br><br><br>";
#var_dump( $pla_date);


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
	}		#성희 수정부분에서 전에 있던 사진 data에서 지우기





$plan_board = new board();
$uploaded = $plan_board->image_FileUpload();
$uploaded[0] = substr($uploaded[0],3);
$uploaded[1] = substr($uploaded[1],3);


// sql insert into 
/*
INSERT INTO `terra`.`plan` (`pla_idx`, `pla_date`, `pla_place`, `pla_distance`, `pla_period`, `pla_name`, `pla_file_name_0`, `pla_file_name_1`, `pla_file_copied_0`, `pla_file_copied_1`, `pla_reg_date`) 
VALUES (NULL, '2015-08-11', '인천', '10', '2개월', '노네임', '7.jpg', NULL, NULL, NULL, '2015-08-03 00:00:00');

(pla_idx, pla_date, pla_place, pla_distance, pla_period, pla_name, pla_file_name_0, pla_reg_date)

, pla_distance, pla_period, pla_name, pla_file_name_0, pla_reg_date
, $pla_distance,  $pla_period, $pla_name, $pla_file, $now

*/
//var_dump($pla_date);
//		update plan set pla_date=?, pla_place=?, pla_distance=?, pla_period=?, pla_name=?, pla_file_name_0=?, pla_file_name_0=?, pla_reg_date=? WHERE pla_idx=?" 

$sql = "update ".$table." set pla_date=?,pla_time=?, pla_place=?, pla_distance=?, pla_period1=?, pla_name=?, pla_file_name_0=?, pla_file_name_1=?, pla_reg_date=?  WHERE ".$column."=?";


 #var_dump($sql);
// echo $pla_date;
$statement = $connect->prepare($sql);

$statement->bind_param('ssssssssss',$pla_date,$pla_time,$pla_place,$pla_distance,$pla_period1,$pla_name,$uploaded[0],$uploaded[1],$now,$pla_idx);


/*

 VALUES('$pla_date', '$pla_place', '$pla_distance',  '$pla_period', '$pla_name', '$pla_file','$now') where pla_idx=".$pla_idx;

*/

//check database 
if($statement->execute()){
	#echo ' update is done';

	$connect->close();
	// list page redirect <script>window.alert('신청이 완료되었습니다.');location.href='apply_list.php';</script>
	echo "<script>alert('수정이 완료되었습니다');location.href='./plan.php';</script>";
	#header("Location: http://localhost/terra/su/su_plan/plan.php");

}else{
	echo "something wrong check code<br>";
	

	echo $connect->connect_error;

	echo $connect->error;
}



?>