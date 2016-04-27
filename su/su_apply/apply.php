<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];

	include "../../common.php";
    include _BASE_DIR."/lib/business.php";

    $apply_board = new board();
	$apply_board->check_admin_session();

	// page= 페이징처리변수 sch=서칭시 사용변수 fld = 서칭시 검색할 필드명
	$page = isset($_GET['page']) ? $_GET['page'] : '1';
	$sch =  isset($_POST['sch']) ? $_POST['sch'] : '';
	$fld =  isset($_POST['q_fld']) ? $_POST['q_fld'] : '';
	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>관리자 참가신청현황 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/plan_apply.css">
<style type="text/css">
	.su_left dt:nth-child(2) a { color:#fff; background-color:#1eb4a8; }
	.point {background-color: #1eb4a8;}
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
			<?php include _BASE_DIR."/include/su_left.php"; ?>
		</nav>
		<section id="su_content">
			<header class="right_title">
				<h1>참가신청 현황</h1>
				<p>현재 진행되고있는 레이스 신청현황</p>
			</header>
			<div class="right_cont">
			
		<?
			//플랜테이블의 최근 대회를 구하기  min(pla_idx);
        // $arr = array("q_fld"=>"min(pla_idx)", "q_table"=>"plan");
        // $result = $apply_board->select_query($arr);

        // while($rows = mysqli_fetch_array($result)){
        //     $latest_pla_idx = $rows['min(pla_idx)'];
        // }

			//대회정보를 불러올꺼다. 
			


		    //배열(배열(),배열(),배열()) 의 형태  필드명, ,테이블명, 조건절
		    $arr = array("q_fld"=>array("m_id"=>"m.m_id","a_idx"=>"a.ap_pub_num","name"=>"m.m_name","birth"=>"m.m_birth","phone"=>"m.m_phone", "gender"=>"m.m_gender", "pla_idx"=>"a.pla_idx","pla_name"=>"pla_name"),
		                "q_table"=>array("q_table1"=>"member m","q_table2"=>"apply a"),
		                "q_where" => array("q_where1"=>"m.m_id", "q_where2"=> "a.mem_id"),
		                "page"=>$page,"sch"=>$sch,"fld"=>$fld
		    );

		    $resultpage = $apply_board -> registraion_status($arr);

		    $result = $resultpage['result_article'];


		     /* 
				회원명     회원 성별   회원아이디  대회명  신청한대회T인덱스  신청T인덱스    대회날짜 
				#mem_name//mem_gender//mem_id// pla_name//applied_plan_index//apply_index//pla_date
		    */
			
			$result = $resultpage['result_article'];
			$num = mysqli_num_rows($result);
			
			?>
			
			총 <?=$num?>명의 회원이 대회신청을 했습니다.<br /><br />
				<table class="plan_list_table">
					<tr>
						<th>회원아이디</th>
						<th>회원명</th>				
						<th>성별</th>						
						<th>대회명</th>
						<th>대회 관련번호</th>			
						<th>신청 관련번호</th>					
						<th>대회날짜</th>	
					</tr>
			<?php



		    while($row = mysqli_fetch_array($result)){

				$mem_name		=isset($row['mem_name']) ? $row['mem_name']: null;
				$mem_gender		=isset($row['mem_gender']) ? $row['mem_gender']: null;
				$mem_id			=isset($row['mem_id']) ? $row['mem_id']: null;
				$pla_name		=isset($row['pla_name']) ? $row['pla_name']: null;
				$applied_plan_index=isset($row['applied_plan_index']) ? $row['applied_plan_index']: null;
				$apply_index	=isset($row['apply_index']) ? $row['apply_index']: null;                            #apply_index<---- 이게  신청관련 수정에 필요한 키 
				$pla_date       =isset($row['pla_date']) ? $row['pla_date']: null;

			?>
				<tr>		
					<td><?= $mem_id?></a></td>				
					<td><?= $mem_name?></td>
					<td><?= $mem_gender?></td>									
					<td class="subject"><a href="apply_update_form.php?num_=<?=$apply_index?>"><?= $pla_name?></td>
					<td><?= $applied_plan_index?></td>						
					<td><?= $apply_index?></td>	
					<td><?= $pla_date?></td>						
				</tr>
				<?php
				}
				#while문 끝 
				?>
				</table>
				

			<div class="paging"><? echo "<br>".$resultpage['result_block']."<br><br>" ?></div>
			
			<div class="row"> <!-- 검색 폼 row 시작-->
			<div class="col-md-2"></div>
			<div class="col-md-8" align="center"> 	
			<form name='frm2' action='apply.php' method='POST'>
			<select name="q_fld">
			<!--추후 필요하면 검색조건은 추가 가능하다! -->
				<option value="mem_name">회원명</option>
				<option value="pla_name" selected="selected">대회이름</option>
				<option value="pla_place">대회장소</option>
			</select>
			<input name="sch" type="text" id="sch"><input type="submit">
			</form>
			</div>
			<div class="col-md-2"></div>
			</div> <br><!-- 검색 폼 row 끝 -->	 

			</table>


			</div>
		</section>
		</div>
		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
		</div>
	</div>
</body>
</html>