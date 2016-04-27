<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	
	include "../../common.php";
    include _BASE_DIR."/lib/business.php"; 
	
	$apply_board = new board();
	$apply_board->check_admin_session();
	#var_dump($_GET);
	//받아온 신청테이블의 인덱스 
	$num_apply_idx = isset($_GET['num_'])? $_GET['num_']: null ;
	#echo "<script>alert(".$num_apply_idx.");</script>";
	$q_table = "apply";
	$fld = "m_phone,m_email,m_tsize, m_addr,m_addr1,m_addr2,m_addr3";
	$arr_q = array("q_table" =>$q_table ,"q_condition1" =>"ap_pub_num","q_condition2" =>$num_apply_idx ,"q_fld"=>$fld) ;
	$result = $apply_board ->select_query($arr_q);

	//var_dump(mysqli_fetch_array($result));
	while($rows =  mysqli_fetch_array($result)){
		$arr_res = array(
		"m_phone"=>$rows['m_phone'],
		"m_email"=>$rows['m_email'],
		"m_tsize"=>$rows['m_tsize'],
		"m_addr" =>$rows['m_addr'],
		"m_addr1"=>$rows['m_addr1'],
		"m_addr2"=>$rows['m_addr2'],
		"m_addr3"=>$rows['m_addr3']
		);				

	}	
?>


<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>관리자 참가신청현황 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/plan_apply.css">
<script src="//code.jquery.com/jquery.min.js"></script>
<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script type="text/javascript">
$(document).ready(function(){

	// //버튼에 따라 폼에 다른경로를 지정한다.
	// $("#update_info").bind("click", function(){
	//      $('[name=apply_form]').attr("action","change_member_info_act.php");
	//      $('[name=apply_form]').submit();
	// });

	// $("#updateInfoAndApply").bind("click", function(){
	//      $('[name=apply_form]').attr("action","apply_act.php");

	//      $('[name=apply_form]').submit();
	// });


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
			<?php include "../../include/su_left.php"; ?>
		</nav>
		<section id="su_content">
			<header class="right_title">
				<h1>참가신청 정보 수정 </h1>
				<p>참가신청한 사용자의 정보를 수정하실수 있습니다</p>
			</header>
			<div class="right_cont">

			<!--시작  -->

			<form name="apply_form" action="apply_update_action_su.php" method="POST">
			
				<table class="apply_table">
				<input type="hidden" name="num_" value="<?=$num_apply_idx?>">
				<tr><th><span class="red">*</span> 전화번호</th><td class="apply_size3"><input type="text" name="phone" value="<?=$arr_res['m_phone']?>" /><span class="join_sub_text2">&nbsp; ex ) 01012345678</span></td></tr>
			
				<tr><th><span class="red">*</span> 주소</th><td class="addr"><input type="text" id="sample4_postcode1" name="addr" value="<?php $addr = substr($arr_res['m_addr'],0,3); echo $addr; ?>" onclick="sample4_execDaumPostcode()" class="addr_input" size="10" /> - <input type="text" id="sample4_postcode2" name="addr0" value="<?php $addr0= substr($arr_res['m_addr'],3,3); echo $addr0; ?>"  onclick="sample4_execDaumPostcode()" size="10" /> <input type="button" onclick="sample4_execDaumPostcode()" value="우편번호 찾기" class="join_btn_s2" id="findPostCodeButton" /><br><!--id뭐지?-->
				<input type="text" id="sample4_roadAddress" name="addr1" value="<?=$arr_res['m_addr1']?>" style="width:450px;" class="addr_input" placeholder="도로명" /><br />
				<input type="text" id="sample4_jibunAddress" name="addr2" value="<?=$arr_res['m_addr2']?>"  style="width:450px;" class="addr_input" placeholder="지번" /><span id="guide" style="color:#999;font-size:12px;"></span><input type="text" name="addr3" id="sample4_jibunAddress" value="<?=$arr_res['m_addr3']?>" class="addr_input" style="width:450px;" placeholder="상세주소"  /></td>
				</tr>

				<tr><th><span class="red">*</span> 이메일</th><td><input type="email" name="email" class="email" value="<?=$arr_res['m_email']?>" /></td></tr>

				<tr><th>옷 사이즈</th><td>
				<select name="t_size">
				<?$arr_tsize=array("0"=>"사이즈선택","85"=>"XS(85)","90"=>"S(90)","95"=>"M(95)","100"=>"L(100)","105"=>"XL(105)","110"=>"XXL(110)","115"=>"XXXL(115)");?>
				<?foreach($arr_tsize as $key=>$val){$selected=$arr_res['m_tsize']==$key ? " selected":"";?><option value="<?=$key?>"<?=$selected?>><?=$val?></option><?}?>
				</select></td></tr>				
				</table>

				<div id="button">
					<input type="submit" class="join_btn" value="정보수정" >			
					<!-- <a style="padding-top:12px" href="delete_apply.php?num_=<?= $applied_idx_arr[$i] ?>" class="button" onclick="return confirm('정말 취소하시겠습니까?');">취소하기  </a></td> -->
					<!-- <input class="cancel" type="button" value="Cancel" onclick="if (confirm('Are you sure you want to delete your post?')) window.location.href='http://www.google.com';" /> -->
					<input type="button" class="join_btn" value="대회신청 취소"onclick="if( confirm('정말 취소하겠습니까?')) window.location.href='apply_delete_action_su.php?num_=<?=$num_apply_idx?>'; "/>
					<input type="button" value="목록보기" onclick="javascript:history.back(-1);" />
				</div>
				</form>

				</div>                
							
			<!--끝   -->

		</section>
		</div>
		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
		</div>
	</div>
</body>
</html>
