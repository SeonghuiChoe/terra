<meta charset="utf-8">
<?php
	//session_start();
	// $userid = $_SESSION["userid"];
	// $username = $_SESSION["username"];
	// $userlevel = $_SESSION["userlevel"];
	

    include "../common.php";
    include _BASE_DIR."/lib/business.php";

    $apply_board = new board();
    //$apply_board->check_login_session();
//
//
//	$userid = $_SESSION["userid"];
//	$username = $_SESSION["username"];
//	$userlevel = $_SESSION["userlevel"];


	//마라톤 대회번호
	$num_ = isset($_GET['num_'])? $_GET['num_']: null ;
	


?>

<!DOCTYPE html>
<html>
<head>
<title>참가신청 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<style type="text/css">
	.nav_cust li:nth-child(3) a { color:#1eb4a8; *color:#e77c71; }
	.sub_apply_nav li:nth-child(1) a { color:#fff; background-color:#e77c71; }
</style>
</head>
<body>
	<div id="wraper">
		<header>
			<?php include _BASE_DIR."/include/header.php"; ?>
		</header>
		
		<section id="subloca">
			<div class="subloca">
				<p>Home &gt; 참가신청 &gt; 참가신청</p>
			</div>
		</section>

		<section id="subcate">
			<div class="subcate">
				<h1>참가신청</h1>
				<p>테라런 대회에 참가하세요</p>
			</div>
		</section>

		<section id="sub_contents">
			<div class="sub_contents">
				<?php include _BASE_DIR."/include/sub_apply_nav.php"; ?>
				<div class="subin">
				  <!-- 기존에 이미 신청한 마라톤이 있으면 상단에 보여준다. 
				
				  -->

			    <?php

			    	/*로그인한 회원이 신청한 내역이 있으면 신청한내용을 뿌려주고
					알람으로 이미 신청이 되어있어 신청이 불가능하다고 보여줌 
			    	*/


			    	/* 로그인한 회원이 신청한 내역이 없으면 신청 action 하고
			    	   알람으로 신청 되었다고 메시지 보여주며 상단에 예약신청내역을 보여준다.

			    	*/


			        //if("select pla_idx from apply where memid = $memid"){
			         // 있을경우 내용을 어떻게 뿌려줄지 생각해 보아야 한다.
			    	//}

			    	//임시적으로 유저아이디를 c1으로 설정 추후 변수값을 초기화하지말아야함 
			    	//$userid="c1";

			    	$fld = "mem_id";
			    	$q_table = "apply";
			    	$arr_q = array("q_table"=>$q_table, "q_condition1"=>"pla_idx","q_condition2"=>$num_,"q_fld"=>$fld);

			    	$result = $apply_board->select_query($arr_q);
			    	$s=0;
			    	$applied =array();

			    	while($rows =  mysqli_fetch_array($result)){
			    		$applied[$s] = $rows['mem_id'];
			    		$s++;
			    		//echo $applied[$s-1];
			    	}


			    	
                    // apply 테이블에서 현재 선택된 대회에 신청한 아이디들중에 현재 로그인한 회원의 아이디가 있는지 확인
			    	if(in_array($userid, $applied)){
			    		//이미 신청한 회원 : 신청한 마라톤정보를 보여준다.
			    		echo "이미 현재 보고있는 대회신청한 내역이 있다.";

			    			$q_table = "plan";
			    			$fld = "*";
			    			$arr_q = array("q_table"=>$q_table,"q_condition1"=>"pla_idx","q_condition2"=>$num_,"q_fld"=>$fld);
			    			$result = $apply_board->select_query($arr_q);
			    			#$sql="select * from $table  where $column=".$num_;
								while($row = mysqli_fetch_array($result)){
								    $pla_idx = $row['pla_idx'];
									$pla_date = $row['pla_date'];
									$pla_place = $row['pla_place'];
									$pla_distance = $row['pla_distance'];
									$pla_name = $row['pla_name'];
									$pla_period = $row['pla_period'];
									$pla_file1 = $row['pla_file_name_0'];
									$pla_file2 = $row['pla_file_name_1'];
								}
							
							$pla_time = substr($pla_date,11,8 ); 
							$pla_date = substr($pla_date,0,10);

							//이미지 주소를 절대경로로 줘서 직접 상대주소화 시켜버림 - windows
							$pla_file1=substr($pla_file1, 26,67);
							$pla_file2=substr($pla_file2, 26,67);
				?>

							<table>
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
						 			<td>마라톤 레이스 거리(KM)</td>
						 			<td><?=$pla_distance?></td>
						 		</tr>
						 		<tr>
						 			<td>마라톤 명칭</td>
						 			<td><?=$pla_name?></td>
						 		</tr>
							</table>
				
				
				<?php

			    	}else{
			    		//마라톤 신청처리할 회원 :예약신청을 한다. 

			    		//폼안의 정보를 member테이블에 갱신해준다. 
			    		//echo "대회 신청한 정보가 없으니까 넣을꺼 ";

			    		//신청하기 버튼을 클릭해서 대회에 신청한다.
			    		echo "<script> alert('이미 신청 하셨습니다.');</script>";
			    		header("Location:apply_list.php");
			    	}

			    	


			    	    	

			    	
			    	$q_table= "member";			    	

			    	//매개변수를 설정한다. 
			    	$fld = "m_phone,m_email,m_tsize, m_addr,m_addr1,m_addr2";
			    	$arr_q = array("q_table" =>$q_table ,"q_condition1" =>"m_id","q_condition2" =>$userid ,"q_fld"=>$fld) ;
			    	
			    	$result = $apply_board->select_query($arr_q);

			    	//var_dump($result);

					//var_dump(mysqli_fetch_array($result));
					while($rows =  mysqli_fetch_array($result)){
							$arr_res = array(
								"m_phone"=>$rows['m_phone'],
								"m_email"=>$rows['m_email'],
								"m_tsize"=>$rows['m_tsize'],
								"m_addr" =>$rows['m_addr'],
								"m_addr1"=>$rows['m_addr1'],
								"m_addr2"=>$rows['m_addr2']
								);				

					}	

//			    	$m_addr = $arr_res['m_addr'] ." ".  $arr_res['m_addr1']." ".$arr_res['m_addr2'];


			    ?>




            <!-- 로그인한 회원의 내용을 읽어온다. -->
			<hr>
			<h3>변동사항이 있으면 입력 해주세요</h3>
			<form name="apply_form" action="apply_act.php" method="POST">
				<table >
					<tr>
						<td><label for="phone">연락처</label></td>

						<td><input type="text" name="phone" value="<?=$arr_res['m_phone']?>"></td>
						<td><input type="hidden" name="num_" value="<?=$num_?>"</td>
					</tr>
					<tr>
						<td><label for="email">e메일</label></td>
						<td><input type="text" name="email"value="<?=$arr_res['m_email']?>"></td>
					</tr>
					<tr>
						<td><label for="t_size">티셔츠 사이즈</label></td>
						<td><input type="text" name="t_size"value="<?=$arr_res['m_tsize']?>"></td>
					</tr>
					<tr>
						<td><label for="addr">우편번호</label></td>
						<td><input type="text" name="addr" id="sample4_postcode1" value="<?php $addr = substr($arr_res['m_addr'],0,3); echo $addr; ?>">-</td>
						<td><input type="text" name="addr0" id="sample4_postcode2" value="<?php $addr0= substr($arr_res['m_addr'],3,3); echo $addr0; ?>"></td>
						<td><input type="button" id="findPostCodeButton" name="" value="우편번호 찾기">
					</tr>
					<tr>
                        <td><label for="addr1">주소</label></td>
                    	<td colspan=2><input type="text" name="addr1" id="sample4_roadAddress" value="<?=$arr_res['m_addr1']?>" style="width:100%;"></td>

                    </tr>
                    <tr>
                        <td><label for="addr2"></label></td>
                        <td colspan=2><input type="text" name="addr2" id="sample4_jibunAddress" value="<?=$arr_res['m_addr2']?>" style="width:100%;"></td>
                    </tr>

				</table>

				<input type="button" id="update_info" value="정보수정" >
				<br>

				<hr>
				<br>

                <?php
		        if(!in_array($userid, $applied)){

		        ?>
				<h4>상기 정보로 마라톤 신청 하도록 합니다 </h4>
				<input type="button" id="updateInfoAndApply" value="신청하기" >

				<?php
				}
				?>
							
			</form>

            <script src="//code.jquery.com/jquery.min.js"></script>
            <script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
			<script type="text/javascript">

            $(document).ready(function(){

                //버튼에 따라 폼에 다른경로를 지정한다.
                $("#update_info").bind("click", function(){
                     $('[name=apply_form]').attr("action","change_member_info_act.php");
                     $('[name=apply_form]').submit();
                });

                $("#updateInfoAndApply").bind("click", function(){
                     $('[name=apply_form]').attr("action","apply_act.php");

                     $('[name=apply_form]').submit();
                });


                $("#findPostCodeButton").bind("click",function () {

                            		new daum.Postcode({
                            			oncomplete: function(data) {
                            			    // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
                            				// 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                            				// 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                            				var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                            				var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                            				if(data.bname !== ''){// 법정동명이 있을 경우 추가한다.
                            					extraRoadAddr += data.bname;
                            				}
                            				if(data.buildingName !== ''){// 건물명이 있을 경우 추가한다.
                            					extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                            				}
                            				if(extraRoadAddr !== ''){// 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                            					extraRoadAddr = ' (' + extraRoadAddr + ')';
                            				}
                            				if(fullRoadAddr !== ''){// 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                            					fullRoadAddr += extraRoadAddr;
                            				}
                            				// 우편번호와 주소 정보를 해당 필드에 넣는다.
                            				document.getElementById("sample4_postcode1").value = data.postcode1;
                            				document.getElementById("sample4_postcode2").value = data.postcode2;
                            				document.getElementById("sample4_roadAddress").value = fullRoadAddr;
                            				document.getElementById("sample4_jibunAddress").value = data.jibunAddress;

                            				if(data.autoRoadAddress) {// 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                            				//예상되는 도로명 주소에 조합형 주소를 추가한다.
                            					var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                            					document.getElementById("guide").innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';
                            				}else if(data.autoJibunAddress) {
                            					var expJibunAddr = data.autoJibunAddress;
                            					document.getElementById("guide").innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

                            				}else{
                            					document.getElementById("guide").innerHTML = '';
                            				}
                            			}
                            		}).open();
                });

			});

			</script>


				</div>
			</div>
		</section>

		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
	</div>
</body>
</html>