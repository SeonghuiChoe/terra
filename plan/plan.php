<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	//세션에 정보가 없어도 누구라도 볼수있는 페이지 입니다.
	include "../common.php";
	include _BASE_DIR."/lib/business.php";

	// page= 페이징처리변수 sch=서칭시 사용변수 fld = 서칭시 검색할 필드명
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$sch =  isset($_POST['sch']) ? $_POST['sch'] : '';
	$q_fld =  isset($_POST['q_fld']) ? $_POST['q_fld'] : '';


	$planboard = new board();
	#$planboard->check_admin_session();

	$arr_q = array("q_table" => "plan","q_column" => "pla_idx", "page"=>$page,"sch"=>$sch,"q_fld"=>$q_fld) ;
	$resultpage = $planboard->search_and_paging($arr_q);
	
	$num_=$_GET['num_'];
	if(!$num_){/* where pla_idx= (Select max(pla_idx) from plan)*/
		$sql = "Select * from plan order by pla_date asc";	
		$result = $connect->query($sql);				
		$row=mysqli_fetch_array($result);
		$num_=$row[pla_idx];
	}


	$no=$_GET['no'];
	if(!$no){
		$sql = "Select * from plan";
		$result = $connect->query($sql);				
		$row=mysqli_num_rows($result);
		$no=$row;
	}
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>대회일정 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/normalize.css">
<link rel="stylesheet" type="text/css" href="../css/plan.css">
<style type="text/css">
	.nav_cust > ul > li:nth-child(2) > a { color:#1eb4a8; *color:#e77c71; }
</style>
<!--탑으로 이동버튼-->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="../js/movetop.js"></script>
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
			if(!$num_){echo "대회일정이 없습니다.";}else{
				#$num_ = isset($_GET['num_'])? $_GET['num_']:'';

				// 초기화면 또는 페이지 이동으로 온 경우 (아직 상세를 누르지 않은경우)
		
			
            //사용자가 대회 리스트에서 대회명을 클릭하여 num_값을 받아온경우
            #$num_ = isset($_GET['num_'])?$_GET['num_']:'';

            #echo "나와야할것!";
			// $table = "plan";
			// $column = "pla_idx";
			// $num_ = $_GET['num_'];
			// $sql="select * from $table  where $column=".$num_;

			$arr = array("q_table"=>"plan","q_fld"=>"*","q_condition1"=>"pla_idx","q_condition2"=>$num_);

			$result = $planboard->select_query($arr);

			if($result){
				while($row = mysqli_fetch_array($result)){
				    //$pla_idx = $row['pla_idx'];
					$pla_date = $row['pla_date'];
					$pla_time = $row['pla_time'];
					$pla_place = $row['pla_place'];		
					$pla_distance = $row['pla_distance'];
					$pla_name = $row['pla_name'];
					$pla_period = $row['pla_period'];
					$pla_file1 = $row['pla_file_name_0'];
					$pla_file2 = $row['pla_file_name_1'];
				}
			}

			// 마라톤 일시는 date하고 시간하고 분리한다.
			//$pla_time = substr($pla_date,11,8 ); 
			//$pla_date = substr($pla_date,0,10);
	?>	
				<!--여기서부터 마라톤 상세  -->



				<div class="plan_detail">
					<div>
						<div class="left"><img src="<?=$pla_file1?>" /></div>
						<div class="right">
							<p>접수중</p>
							<table>
								<caption>제<?=$num_?>회&nbsp;<?=$pla_name?></caption>
								<tr><th>날짜</th><td><?=$pla_date?></td></tr>
								<tr><th>시간</th><td><?=$pla_time?></td></tr>
								<tr><th>장소</th><td><?=$pla_place?></td></tr>
								<tr><th>거리</th><td><?=$pla_distance?></td></tr>
								<!--<tr><th>신청기간</th><td><?=$pla_period?></td></tr>-->
							</table>
							<input type="button" value="신청하기" class="button" onclick=location.href="../apply/apply.php?num_=<?=$num_?>">
						</div>
					</div>
				</div>


				<!-- 검색시 밑으로 빠져버리는 테이블-->
				<div class="list_form">
				<table>
					<tr>
						<th>No.</th>				
						<th>대회일</th>
						<th>마라톤 대회명</th>
						<th>마라톤 장소</th>
						<th>거리</th>			
						<th>등록일</th>						
					</tr>
					<?php						
						$result = $resultpage['result_article'];
						$no = mysqli_num_rows($result);
						while($row = mysqli_fetch_array($result)){
							$item_pla_idx=isset($row['pla_idx']) ? $row['pla_idx']: null;
							$item_pla_date=isset($row['pla_date']) ? $row['pla_date']: null;
							$item_pla_place=isset($row['pla_place']) ? $row['pla_place']: null;
							$item_pla_distance=isset($row['pla_distance']) ? $row['pla_distance']: null;
							$item_pla_name=isset($row['pla_name']) ? $row['pla_name']: null;
							$item_pla_reg_date=isset($row['pla_reg_date']) ? $row['pla_reg_date']: null;	
							$item_pla_reg_date=date("Y-m-d (H:i)",strtotime($item_pla_reg_date));
					?>
					<tr>	
						<td><?echo $no; $no=$no-1;?></td>
						<!--<td><?= $item_pla_idx?></td>-->
						<td><?= $item_pla_date?></td>
						<td class="subject"><a href="plan.php?num_=<?=$item_pla_idx?>&no=<?=$no?>"><?= $item_pla_name?></a></td>
						<td><?= $item_pla_place?></td>
						<td><?= $item_pla_distance?></td>
						<td><?= $item_pla_reg_date?></td>
					<?php
					}
					?>				
					</tr>
					</table>
					</div>
					<?
					//if want pagin start here
					#$connect->close();
					
					echo "<div class='paging'><br>".$resultpage['result_block']."<br><br></div>";
					?>	

					<div class="row"> <!-- 검색 폼 row 시작-->
						<div class="col-md-2"></div>
						<div class="col-md-8" align="center"> 	
						<form name='frm2' action='plan.php' method='POST'>
						<select name="q_fld">
						<!--추후 필요하면 검색조건은 추가 가능하다! -->
							<option value="pla_idx">대회번호</option>
							<option value="pla_name" selected="selected">대회이름</option>
							<option value="pla_place">대회장소</option>
						</select>
						<input name="sch" type="text" id="sch">
						<input type="button" class="button" value="검색">
						</form>
						</div>
						<div class="col-md-2"></div>
					</div> <br><!-- 검색 폼 row 끝 -->
					<?}?>
				</div>
			</div>
		</section>

		<footer>
		<?   include _BASE_DIR."/include/footer.php"; ?>
		</footer>
	</div>
</body>
</html>