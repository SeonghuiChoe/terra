<?php

	session_start();
	include "lib/dbconnection.php";	

	//세션에 정보가 없어도 누구라도 볼수있는 페이지 입니다.


	$width = "250px;";
	$table = "plan";
	$column = "pla_idx";
	$num_ = $_GET['num_'];
	$sql="select * from $table  where $column=".$num_;

	if($result = $connect->query($sql)){
		while($row = mysqli_fetch_array($result)){
		    //$pla_idx = $row['pla_idx'];
			$pla_date = $row['pla_date'];

			$pla_place = $row['pla_place'];
			$pla_distance = $row['pla_distance'];
			$pla_name = $row['pla_name'];
			$pla_period = $row['pla_period'];
			$pla_file1 = $row['pla_file_name_0'];
			$pla_file2 = $row['pla_file_name_1'];
		}
	}
	//var_dump($pla_date);
	$pla_time = substr($pla_date,11,8 ); 
	$pla_date = substr($pla_date,0,10);

	//이미지 주소를 절대경로로 줘서 직접 상대주소화 시켜버림 -ubuntu
    // $pla_file1=substr($pla_file1, 13,42);
    // $pla_file2=substr($pla_file2, 13,42);

    //이미지 주소를 절대경로로 줘서 직접 상대주소화 시켜버림 - windows
	$pla_file1=substr($pla_file1, 26,67);
	$pla_file2=substr($pla_file2, 26,67);


?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>대회일정 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/admin.css">
</head>
<body>
	<div id="wraper">
		<div id="sub_visual">
		<? if($userlevel!=='10'){ ?>
		<nav id="nav_cust">
		<?php include "../include/header_sub.php"; ?>
		<?php include "../include/left_menu_sub.php"; ?>
		</nav>
		<? }else{ ?>
		<nav id="nav_su">
		<?php include "../include/header_su.php"; ?>
		<?php include "../include/left_menu_su.php"; ?>
		</nav>
		<? } ?>

		<section id="subcont">
			<div class="sub_title">

	<h1>여기가 진짜 중요한곳이니까 신경좀쓰자  </h1>
	<table>		
		<tr>
			<td>마라톤 일자, 시간</td>
			<td><?=$pla_date?> ,<?=$pla_time?></td>
		</tr>

		<tr>
			<td>이름</td>
			<td><?=$pla_name?></td>
		</tr>
		<tr>
			<td>장소</td>
			<td><?=$pla_place?></td>
		</tr>
		<tr>
			<td>거리</td>
			<td><?=$pla_distance?></td>
		</tr>
		<tr>
			<td>신청기간</td>
			<td><?=$pla_period?></td>
		</tr>

		
	</table>
	
			
			<img src="<?=$pla_file1?>" style="width:<?=$width?>" >
	 		<img src="<?=$pla_file2?>" style="width:<?=$width?>" >

			<input type="button" value="신청페이지" onclick=location.href="../apply/apply_form.php?num_=<?=$num_?>">

			

			
		
</div>
		</section>
		</div>
		<footer>
		<?php include "../include/footer_sub.php"; ?>
		</footer>
	</div>
</body>
</html>