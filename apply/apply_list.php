<meta charset="utf-8">
<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	include "../common.php";
	include _BASE_DIR."/lib/business.php";

	$apply_board = new board();
    $apply_board->check_login_session();

?>
<!DOCTYPE html>
<html>
<head>
<title>참가신청 현황 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<link rel="stylesheet" href="../css/normalize.css" type="text/css" >
<style type="text/css">
	.sub_mypage_nav li:nth-child(2) a { color:#fff; background-color:#e77c71; }
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
				<p>Home &gt; 마이페이지 &gt; 나의 참가현황</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>나의 참가현황</h1>
				<p>나의 대회 신청현황을 확인할 수 있습니다.</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
<?php include "../include/sub_mypage_nav.php"; ?>
				<div class="subin">

				<?php					 
							$apply_board = new board();
							


							// userid로 신청한 (대회정보)plan_id를 불러온다. 				

							$arr = array("q_table"=>"apply", "q_condition1"=>"mem_id" ,"q_condition2"=>$userid, "q_fld"=>"pla_idx, ap_pub_num");
							$applied = $apply_board->select_query($arr);

							$cnt=0;

							$applied_idx_arr= array();
							$applied_arr = array();
							while($row = mysqli_fetch_array($applied)){
								$applied_arr[$cnt] = $row['pla_idx'];
								$applied_idx_arr[$cnt]= $row['ap_pub_num'];
								$cnt++;
							}
							#var_dump($applied_arr);
							#var_dump($applied_arr); <-- 대회번호가 있는 배열 한개일때와 2개이상일때로 나눠생각해보고
							#var_dump($applied_idx_arr);
							#다시 플랜 테이블에 쿼리를  
							$cnt = count($applied_arr);
							#var_dump($cnt);

				/*add*/if($cnt<=0){echo "참여한 마라톤이 없습니다.";}
				/*add*/else{echo "<div class='mypage_apply_list'>총 ".$cnt."개의 마라톤을 신청하셨습니다. </div>
				<table class='apply_list_table'>
				<th>No.</th><th>마라톤 명칭</th><th>마라톤 일자</th><th>마라톤 시간</th><th>마라톤 장소</th><th>마라톤 거리(km)</th><th>수정/삭제</th>";
				
				}
							

#가져온 마라톤 갯수만큼 반복
for($i=0;$i<$cnt;$i++){
	$arr = array("q_table"=>"plan","q_condition1"=>"pla_idx","q_condition2"=>$applied_arr[$i],"q_fld"=>"*");
	$result = $apply_board->select_query($arr);

	#가져온 마라톤 각각의 정보를 뿌려준다.
	while($row = mysqli_fetch_array($result)){
	$pla_idx = $row['pla_idx'];
	$pla_date = $row['pla_date'];
	/*add*/$pla_time = $row['pla_time'];
	$pla_place = $row['pla_place'];
	$pla_distance = $row['pla_distance'];
	$pla_name = $row['pla_name'];
	$pla_period = $row['pla_period'];

	#$pla_time = substr($pla_time,11,8 ); 
	#$pla_date = substr($pla_date,0,10);	
?>
<div class="clear">

	<tr><td><?=$i+1?></td><td><?=$pla_name?></td><td><?=$pla_date?></td><td><?=$pla_time?></td><td><?=$pla_place?></td><td><?=$pla_distance?></td><td style="text-align:center; "><?=$applied_idx_arr[$cnt]?><a href="delete_apply.php?num_=<?= $applied_idx_arr[$i] ?>" class="su_btn" onclick="return confirm('정말 취소하시겠습니까?');">취소하기</a></td></tr>

<!-- <?php   ?> -->
<!-- <td><a href="deleteApply.php?num_='<? echo $applied_idx_arr[$cnt]; ?>'"  >취소하기 </a></td> -->

<?														
} 
}echo "</table>";

							//신청한 대회가 여러개인 경우와 한개인경우를 구분해야하나?


							//불러온 plan_id로 대회정보들을 뿌려준다. 

			    // 			$q_table = "plan";
			    // 			$fld = "*";
			    // 			$arr_q = array("q_table"=>$q_table,"q_condition1"=>"pla_idx","q_condition2"=>$num_,"q_fld"=>$fld);
			    // 			$result = $apply_board->select_query($arr_q);
			    // 			#$sql="select * from $table  where $column=".$num_;
							// 	while($row = mysqli_fetch_array($result)){
							// 	    $pla_idx = $row['pla_idx'];
							// 		$pla_date = $row['pla_date'];
							// 		$pla_place = $row['pla_place'];
							// 		$pla_distance = $row['pla_distance'];
							// 		$pla_name = $row['pla_name'];
							// 		$pla_period = $row['pla_period'];
							// 		$pla_file1 = $row['pla_file_name_0'];
							// 		$pla_file2 = $row['pla_file_name_1'];
							// 	}
							
							// $pla_time = substr($pla_date,11,8 ); 
							// $pla_date = substr($pla_date,0,10);

							//이미지 주소를 절대경로로 줘서 직접 상대주소화 시켜버림 - windows
							// $pla_file1=substr($pla_file1, 26,67);
							// $pla_file2=substr($pla_file2, 26,67);
					?>

							<!-- <table>
								<tr>
						 			<td>마라톤 일자</td>
						 			<td><?=$pla_date?></td>
						 			<td>마라톤 시간</td>
						 			<td><?=$pla_time?></td>
						 		</tr>
						 		<tr>
						 			<td>마라톤 장소</td>
						 			<td><?=$pla_place?></td>
						 		</tr>
						 		<tr>
						 			<td>마라톤 거리(KM)</td>
						 			<td><?=$pla_distance?></td>
						 		</tr>
						 		<tr>
						 			<td>마라톤 명칭</td>
						 			<td><?=$pla_name?></td>
						 		</tr>
							</table> -->



				</div>
			</div>
		</section>
		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
	</div>
</body>
</html>