<?php	
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	
	include "../../common.php";	
    include _BASE_DIR."/lib/business.php";
	
	#if has not session page return -> login.php 
	$planboard = new board();
	$planboard->check_admin_session();	
	$table = "plan";
	//get num
	$num_ = $_GET['num_'];
	#var_dump($_GET);
	$pla_date ='';

	$sql = "select * from ".$table." where pla_idx=".$num_ ;
	$results2 = $connect->query($sql);
	$num=mysqli_num_rows($results2);
	if(!$num){echo "<script>alert('대회정보가 없습니다.');location.href='./plan.php';</script>";exit;}

	#echo $sql;
	if($results = $connect->query($sql)){
		while($row = mysqli_fetch_array($results)){
			$pla_date = $row['pla_date'];
			$pla_time = $row['pla_time'];
			$pla_place = $row['pla_place'];
			$pla_distance = $row['pla_distance'];
			$pla_name = $row['pla_name'];
			$pla_period1 = $row['pla_period1'];
			$pla_file1 = $row['pla_file_name_0'];
			$pla_file2 = $row['pla_file_name_1'];
		}
	}
	

	#var_dump($pla_date);
	//pla_date divide to date and time
	//2015-08-31 00:00:00
	#$pla_time = substr($pla_date,11,8 ); 


	#$pla_date = substr($pla_date,0,10);
	//$pla_date = str_replace("-",". ",$pla_date);
	
	//var_dump($pla_file);

	


	/* pdo using but i have no time 

	$pdo = new PDO('mysql:host=localhost;dbname=terra','root','apmsetup');
	$statement = $pdo->query("select * from apply where pla_idx= :id");
	$id = filter_input(INPUT_GET,'id', FILTER_SANITIZE_NUMBER_INT);

	$statement->bindParam(':id',$id,PDO::PARAM_INT );

	$stmt->execute();

	$row = $statement->fetch(PDO::FETCH_ARRAY);
	echo $row['pla_date'];
	*/
	
	

	if($results){
		//var_dump($pla_date);

	}else{
		echo $connect->error;
	}

	
 
?>

<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>관리자 대회일정 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/plan_apply.css">
<style type="text/css">
	.su_left dt:nth-child(1) a { color:#fff; background-color:#1eb4a8; }
<!--input[type="button"]:hover, input[type="button"] input:hover{background-color:#fff; color:#1eb4a8; border:2px solid #1eb4a8; }
	.button { display:inline-block; width:100px; height:40px; font-weight:bold; background-color:#1eb4a8; color:#fff; border:2px solid #1eb4a8; padding-top:13px; }	-->	
</style>
</head>
<body>
	<div id="wraper">
		<div id="all">
		<header class="su_logo">
			<span><a href="<?echo $cfg[url].'/index.php'?>"><img src="../../images/logo_g.png" alt="테라로고" /></a></span>
		</header>
		<div class="bottom">
		<nav id="nav_su">
			<?php include  "../../include/su_left.php"; ?>
		</nav>
		<section id="su_content">
			<header class="right_title">
				<h1>대회일정</h1>
				<p>테라런 대회일정 관리</p>
			</header>
			<div class="right_cont">

	 	<form action="pla_update_act.php" method="POST" enctype="multipart/form-data">

	 		<table class="plan_table">
		 		<tr>
		 			<th>대회 일자</th><td><input type="date" name="pla_date" value="<?=$pla_date?>"></td>
		 		</tr>	
		 		<tr>
		 			<th>대회 시간</th><td><input type="time" name="pla_time" value="<?=$pla_time?>"></td>
		 		</tr>
		 		<tr>
		 			<th>대회 장소</th><td><input type="text" name="pla_place" value="<?=$pla_place?>"></td>
		 		</tr>
		 		<tr>
		 			<th>마라톤 거리(km)</th><td><input type="text" name="pla_distance" value="<?=$pla_distance?>"></td>
		 		</tr>
		 		<tr>
		 			<th>마라톤 명칭</th><td><input type="text" name="pla_name" value="<?=$pla_name?>"><input type="hidden" name="num_" value="<?=$num_?>"></td>
		 		</tr>
		 		<tr>
		 			<th>마라톤 신청 기간</th><td><input type="text" name="pla_period" value="<?=$pla_period1?>"></td>
		 		</tr>
		 		<tr>
		 			<th>이미지첨부1</th>
		 			<!--<input type="hidden"value="20000" name="MAX_FILE_SIZE"></input>-->
		 			<td><input type="file" name="upfile[]" ></td>
		 		</tr>
				<tr><th>이미지첨부2</th><td><input type="file" name="upfile[]" ></td></tr>
				<?
				if($pla_file1!="" or $pla_file2!=""){
				?>
				<tr>
					<th>기존이미지</th>
					<td class="modify_img">
					<?if($pla_file1!=""){echo "<img src='../".$pla_file1."' style='width:300px'> ";}
					if($pla_file2!=""){echo "<img src='../".$pla_file2."' style='width:300px'>";}?>
					</td>
				</tr>
				<?
					}
				?>
		 </table>	

		 <div id="button">
			<input type="submit" value="수정하기">
		 	<input type="button" value="삭제하기" onclick="if(confirm('정말로 삭제하시겠습니까?'))window.location.href='pla_delete_act.php?num_=<?= $num_ ?>';"/>
			<input type="button" value="목록보기" onclick="javascript:history.back(-1);" />
		 </div>

	 	</form>


		</div>
		</section>
		</div>
		<footer>
		<?php include "../../include/footer.php"; ?>
		</footer>
		</div>
	</div>
</body>
</html>

 <?php


 $connect->close();
 ?>