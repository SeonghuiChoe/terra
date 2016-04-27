<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];

	include "../../common.php";
    include _BASE_DIR."/lib/business.php";

	// page= 페이징처리변수 sch=서칭시 사용변수 fld = 서칭시 검색할 필드명
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$sch =  isset($_POST['sch']) ? $_POST['sch'] : '';
	$fld =  isset($_POST['fld']) ? $_POST['fld'] : '';
	
	#values for paging $page,$q_table,$q_column
	
	$q_table = "plan";
	$q_column = "pla_idx";
	

	//전체 페이지 [플랜테이블 역순 페이지1]
	$arr_q = array("q_table" => "plan","q_column" => "pla_idx", "page"=>$page,"sch"=>$sch,"q_fld"=>$fld) ;
	#보드 클래스 생성
	$planboard = new board();
	$planboard->check_admin_session();
	#보드 클래스의 fileupload함수를 호출 use in sql statment
	$resultpage = $planboard->search_and_paging($arr_q);
?>
<!DOCTYPE html>
<html>
<head>
<meta  http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>관리자 대회일정 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/plan_apply.css">
<style type="text/css">
	.su_left dt:nth-child(1) a { color:#fff; background-color:#1eb4a8; }
</style>
</head>
<body>
	<div id="wraper">
		<div id="all">
		<header class="su_logo">
			<span><a href="<?echo $cfg[url].'/index.php'?>"><img src="<?echo $cfg[url].'/images/logo_g.png'?>" alt="테라로고" /></a></span>
		</header>
		<div class="bottom">
		<nav id="nav_su">
			<?php include _BASE_DIR."/include/su_left.php"; ?>
		</nav>
		<section id="su_content">
			<header class="right_title">
				<h1>대회일정</h1>
				<p>테라런 대회일정 관리</p>
			</header>
			<div class="right_cont">

			
			
			
			<?$result = $resultpage['result_article'];$num = mysqli_num_rows($result);?>
			총 <?=$num?>개의 대회가 있습니다.<br /><br />
			<table class="plan_list_table">
			<tr>
				<th>회차</th>
				<th>대회일</th>
				<th>마대회명</th>
				<th>장소</th>
				<th>거리</th>
				
				<th>등록일</th>
				<th>이미지파일</th>
			<!-- 	<th>수정/삭제</th> -->
			</tr>
			<?php

				// for statement 
				//for($i=$start_page; $i<$start_page+$scale&&$i<$total_record;$i++){

					// 가져올 레코드 위치(포인터)로 이동, for문에서 요긴하게 사용됨
					//mysqli_data_seek($result, $i);
					//$row = mysqli_fetch_array($result);

				// $result =  $planboard -> paging_article($arr_q);
				// $rows = mysqli_num_rows($result);
				$result = $resultpage['result_article'];
				while($row = mysqli_fetch_array($result)){

					$item_pla_idx=isset($row['pla_idx']) ? $row['pla_idx']: null;
					$item_pla_date=isset($row['pla_date']) ? $row['pla_date']: null;
					$item_pla_place=isset($row['pla_place']) ? $row['pla_place']: null;
					$item_pla_distance=isset($row['pla_distance']) ? $row['pla_distance']: null;
					$item_pla_name=isset($row['pla_name']) ? $row['pla_name']: null;
					$item_pla_reg_date=isset($row['pla_reg_date']) ? $row['pla_reg_date']: null;
                    $pla_file_name_0=isset($row['pla_file_name_0']) ? $row['pla_file_name_0']: null;
                    $pla_file_name_1=isset($row['pla_file_name_0']) ? $row['pla_file_name_0']: null;
					// $item_pla_date=$row['pla_date'];
					// $item_pla_place=$row['pla_place'];
					// $item_pla_distance=$row['pla_distance'];
					// $item_pla_name=$row['pla_name'];					
					// $item_pla_reg_date=$row['pla_reg_date'];
					//$item_file="none11";

                   // 이미지가 존재할경우 O을 표시
				   isset($pla_file_name_0)? $flag_img_exist ="O" :$flag_img_exist ="X";
				   
			?>
			
			<tr>			
				<td><?= $item_pla_idx?></td>
				<td><?= $item_pla_date?></td>
				<td class="subject"><a href="pla_view_plan.php?num_=<?=$item_pla_idx?>"><?= $item_pla_name?></a></td>
				<td><?= $item_pla_place?></td>
				<td><?= $item_pla_distance?></td>								
				<td><? $item_pla_reg_date = date("Y-m-d (H:i:s)",strtotime($item_pla_reg_date)); echo $item_pla_reg_date;?></td>
				<td><?= $flag_img_exist ?></td>
				<!--<td> <input type="button" class="button" value="수정" onclick=location.href="pla_update_form.php?num_=<?= $item_pla_idx ?>" >
					<input type="button" class="button" value="삭제" onclick=location.href="pla_delete_act.php?num_=<?= $item_pla_idx ?>"> 
				</td>-->
				</tr>
				
				<?php
			
			}
			
			//if want pagin start here

			#$connect->close();
		?></table>
		
		<div class="paging"><? echo "<br>".$resultpage['result_block']."<br><br>" ?></div>
	
		<div class="row"> <!-- 검색 폼 row 시작-->
			<div class="col-md-2"></div>
			<div class="col-md-8" align="center"> 	
			<form name='frm2' action='plan.php' method='POST'>
			<select name="fld">
			<!--추후 필요하면 검색조건은 추가 가능하다! -->
				<option value="pla_idx">대회번호</option>
				<option value="pla_name" selected="selected">대회이름</option>
				<option value="pla_place">대회장소</option>
			</select>
			<input name="sch" type="text" id="sch"><input type="button" class="button" value="검색">
			</form>
			</div>
			<div class="col-md-2"></div>
		</div> <!-- 검색 폼 row 끝 -->

		<div id="button"><a href= "pla_insert_form.php">마라톤정보입력</a></div>	
			
			
			
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