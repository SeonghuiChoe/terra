<?php
	//session_start();
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	//세션에 정보가 없어도 누구라도 볼수있는 페이지 입니다.
	include "../common.php";
	include _BASE_DIR."/lib/business.php";
	include _BASE_DIR."/lib/dbconnection_.php";




	// page= 페이징처리변수 sch=서칭시 사용변수 fld = 서칭시 검색할 필드명
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$sch =  isset($_POST['sch']) ? $_POST['sch'] : '';
	$fld =  isset($_POST['fld']) ? $_POST['fld'] : '';


	$planboard = new board();

	$arr_q = array("q_table" => "plan","q_column" => "pla_idx", "page"=>$page,"sch"=>$sch,"fld"=>$fld) ;
	$resultpage = $planboard->search_and_paging($arr_q);


?>

<?php

//	$userid = $_SESSION["userid"];
//	$username = $_SESSION["username"];
//	$userlevel = $_SESSION["userlevel"];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>대회일정 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<style type="text/css">
	.nav_cust > ul > li:nth-child(2) > a { color:#1eb4a8; *color:#e77c71; }
</style>
</head>
<body>
	<div id="wraper">
		<header>
			<?php include _BASE_DIR."/include/header.php"; ?>
		</header>
		
		<section id="subloca">
			<div class="subloca">
				<p>Home &gt; 대회일정</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>대회일정</h1>
				<p>테라런 대회일정을 확인하세요</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<div class="subin">

			<?php

                $num_ = isset($_GET['num_'])? $_GET['num_']:'';

				// 초기화면 또는 페이지 이동으로 온 경우 (아직 상세를 누르지 않은경우)
				if($num_==''){
				
			?>	

				<table border=1>
					<tr>
						<th>회차</th>				
						<th>일자</th>
						<th>마라톤 대회명</th>
						<th>마라톤 장소</th>
						<th>마라톤 거리</th>			
						<th>신청일자</th>					
						
					</tr>
					<?php						
						
						$result = $resultpage['result_article'];
						while($row = mysqli_fetch_array($result)){

							$item_pla_idx=isset($row['pla_idx']) ? $row['pla_idx']: null;
							$item_pla_date=isset($row['pla_date']) ? $row['pla_date']: null;
							$item_pla_place=isset($row['pla_place']) ? $row['pla_place']: null;
							$item_pla_distance=isset($row['pla_distance']) ? $row['pla_distance']: null;
							$item_pla_name=isset($row['pla_name']) ? $row['pla_name']: null;
							$item_pla_reg_date=isset($row['pla_reg_date']) ? $row['pla_reg_date']: null;								
					?>
					<tr>			
						<td><?= $item_pla_idx?></td>

						<td><?= $item_pla_date?></td>
						<td><a href="list_plan_u.php?num_=<?=$item_pla_idx?>"><?= $item_pla_name?></a></td>				
						<td><?= $item_pla_place?></td>
						<td><?= $item_pla_distance?></td>
						
						<td><?= $item_pla_reg_date?></td>
						
						
						</tr>
					<?php					
					
					}					
					
					$connect->close();
				?>
				</table>
		
		<?php
			echo "<div align='center'>".$resultpage['result_block']."</div>";
		
		?>
	
		<div class="row"> <!-- 검색 폼 row 시작-->
			<div class="col-md-2"></div>
			<div class="col-md-8" align="center"> 	
			<form name='frm2' action='list_plan.php' method='POST'>
			<select name="fld">
			<!--추후 필요하면 검색조건은 추가 가능하다! -->
				<option value="pla_idx">대회번호</option>
				<option value="pla_name" selected="selected">대회이름</option>
				<option value="pla_place">대회장소</option>
			</select>
			<input name="sch" type="text" id="sch"><input type="submit">
			</form>
			</div>
			<div class="col-md-2"></div>
		</div> <br><!-- 검색 폼 row 끝 -->

		</div>
		</section>
		</div>
		<footer>

		</footer>
	</div>
</body>
</html>

	<?php
		}else{
            //사용자가 대회 리스트에서 대회명을 클릭하여 num_값을 받아온경우
            $num_ = isset($_GET['num_'])?$_GET['num_']:'';

            echo "나와야할것!";
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

			// 마라톤 일시는 date하고 시간하고 분리한다.
			$pla_time = substr($pla_date,11,8 ); 
			$pla_date = substr($pla_date,0,10);
	?>	
				<!--여기서부터 마라톤 상세  -->
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

				<input type="button" value="신청하기" onclick=location.href="../apply/apply_form.php?num_=<?=$num_?>">


				<br><br><br>

				<table border=1>
					<tr>
						<th>회차</th>				
						<th>일자</th>
						<th>마라톤 대회명</th>
						<th>마라톤 장소</th>
						<th>마라톤 거리</th>			
						<th>신청일자</th>						
						
					</tr>
					<?php						
						
						$result = $resultpage['result_article'];
						while($row = mysqli_fetch_array($result)){

							$item_pla_idx=isset($row['pla_idx']) ? $row['pla_idx']: null;
							$item_pla_date=isset($row['pla_date']) ? $row['pla_date']: null;
							$item_pla_place=isset($row['pla_place']) ? $row['pla_place']: null;
							$item_pla_distance=isset($row['pla_distance']) ? $row['pla_distance']: null;
							$item_pla_name=isset($row['pla_name']) ? $row['pla_name']: null;
							$item_pla_reg_date=isset($row['pla_reg_date']) ? $row['pla_reg_date']: null;								
					?>
					<tr>			
						<td><?= $item_pla_idx?></td>

						<td><?= $item_pla_date?></td>
						<td><a href="list_plan_u.php?num_=<?=$item_pla_idx?>"><?= $item_pla_name?></a></td>				
						<td><?= $item_pla_place?></td>
						<td><?= $item_pla_distance?></td>
						
						<td><?= $item_pla_reg_date?></td>
						
						
						</tr>
					<?php
						
					
					}
					
					//if want pagin start here

					$connect->close();
				?>
				</table>
		
		<?php
			echo "<div align='center'>".$resultpage['result_block']."</div>";
		
		?>
	
		<div class="row"> <!-- 검색 폼 row 시작-->
			<div class="col-md-2"></div>
			<div class="col-md-8" align="center"> 	
			<form name='frm2' action='list_plan_u.php' method='POST'>
			<select name="fld">
			<!--추후 필요하면 검색조건은 추가 가능하다! -->
				<option value="pla_idx">대회번호</option>
				<option value="pla_name" selected="selected">대회이름</option>
				<option value="pla_place">대회장소</option>
			</select>
			<input name="sch" type="text" id="sch"><input type="submit">
			</form>
			</div>
			<div class="col-md-2"></div>
		</div> <br><!-- 검색 폼 row 끝 -->

		</div>
		</section>
		</div>

	</div>
</body>
</html>

<?php
	} #if(isset(num_))일경우
?>