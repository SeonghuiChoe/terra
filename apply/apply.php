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
	$apply_board = new board();
   

    $num_ = isset($_GET['num_'])? $_GET['num_']: null ; //대회를 여러개 신청할수 있을줄 알았다. 

	//마라톤 대회번호 num_을 겟에서 받지 않고 최근대회 불러오는 방법으로 해야한다.
	//$num_ = $apply_board->latest_plan();

	/*함수에서 안가져올경우 직접 select_query 호출 호출되는거 확인함.
	
	//플랜테이블의 최근 대회를 구하기  min(pla_idx); business.php파일에 이미 만들어둠 정상동작하면 추후 리펙토링 
        $arr = array("q_fld"=>"min(pla_idx)", "q_table"=>"plan");
        $result = $applyboard->select_query($arr);

        while($rows = mysqli_fetch_array($result)){
            $latest_pla_idx = $rows['min(pla_idx)'];
        }
	*/

        	//뿌리기전에 다시한번 num_값으로 셀렉트해서 하단의 변수들을 초기화 해줘야 정상동작할거같어 ㅠㅠ
			$fld ="pla_name, pla_date,pla_place, pla_time, pla_distance";
			#var_dump($pla_num);
			$arr_q = array("q_table"=> "plan" ,"q_condition1" =>"pla_idx","q_condition2" =>$num_ ,"q_fld"=>$fld) ;
			$result = $apply_board->select_query($arr_q);

			while($rows =  mysqli_fetch_array($result)){
				$pla_name = $rows['pla_name'];
				$pla_date = $rows['pla_date'];
				$pla_place = $rows['pla_place'];
				$pla_time = $rows['pla_time'];
				$pla_distance = $rows['pla_distance'];

			}
			

	$sql2 = "Select * from plan where pla_idx=".$_GET['num_'];
	$result2 = $connect->query($sql2);				
	$row2=mysqli_fetch_array($result2);
	$pla_file1 = $row2[pla_file_name_0];


?>
<!DOCTYPE html>
<html>
<head>e
<title>참가신청 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/common.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<style type="text/css">
	.nav_cust > ul > li:nth-child(3) > a { color:#1eb4a8; *color:#e77c71; }
	.sub_apply_nav li:nth-child(1) a { color:#fff; background-color:#e77c71; }
	table { font-size:14px; }
</style>

<!--탑으로 이동버튼-->
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="../js/movetop.js"></script>

<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>

<script type="text/javascript">

$(document).ready(function(){
	
//if(!$num_){
//$('#pla_name').html('대회를 선택해주세요.');
//$('#date').html('')
//$('#place').html('');
//$('#time').html('');
//$('#distance').html('');}
//$('#plan_num_input').val($num_);
// $('#date').html('');
// $('#place').html('');
// $('#time').html('');
// $('#distance').html('');

	//셀렉트 버튼을 클릭하면 대회번호를 히든폽값에 넣는다.
	$("#plan_num").change(function(){
		//$(".join_table").find("tr:gt(1):lt(6)").remove();
			//alert();
		 $num_ = $("#plan_num option:selected").val();
		 //alert($num_);
		 
		 //내가 이미 신청했던 대회번호와 현재 선택한 번호가 같을때 경고메시지 뿌리면서 셀렉트 박스를 초기화한다. 
		if(window.XMLHttpRequest){
			xmlhttp= new XMLHttpRequest();
		}else{
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");

		}
		xmlhttp.onreadystatechange = function(){
			if(xmlhttp.readyState ==4 && xmlhttp.status ==200){
				
				var xmlres = xmlhttp.responseText;
				var str_arr = xmlres.split(","); //4개의 배열
				var pla_date=str_arr[0].substr(str_arr[0].length-10,str_arr[0].length);
				var pla_place=str_arr[1];
				var pla_time=str_arr[2];         					
				var pla_name=str_arr[3];
				if(!pla_name){pla_name="대회를 선택해주세요.";}
				var pla_distance=str_arr[4].substr(0,2);
				if(pla_distance=="nu"){pla_distance="";}
				//alert(pla_name);

				$('#pla_name').html(pla_name);
				$('#date').html(pla_date)
				$('#place').html(pla_place);
				$('#time').html(pla_time);
				$('#distance').html(pla_distance);

				$('#plan_num_input').val($num_);

				
				//$(".join_table").find("tr:eq(1)").after();
										// $("#replace").html(xmlhttp.responseText) ;
			}
		}
		xmlhttp.open("GET","get_plan.php?num_="+$num_, true);
		xmlhttp.send();
		
	
		})


			//버튼에 따라 폼에 다른경로를 지정한다.
			$("#update_info").bind("click", function(){
				 $('[name=apply_form]').attr("action","change_member_info_act.php");
				 $('[name=apply_form]').submit();
			});

			/*$("#updateInfoAndApply").bind("click", function(){
				alert('신청하기');
				 $('[name=apply_form]').attr("action","apply_act.php");

				 $('[name=apply_form]').submit();
			});*/


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


<script>
function check_input(){
		if(!document.apply_form.phone.value){
			alert("핸드폰 번호를 입력하세요.");
			document.apply_form.phone.focus();
			return;
		}
		var phone_check = /[0-9]/;
		if (!phone_check.test(document.apply_form.phone.value) || document.apply_form.phone.value.length < 8  || document.apply_form.phone.value.length > 12){
			alert("핸드폰 번호를 확인해주세요.");
			document.join_table.phone.focus();
			return;
		}
		if(!document.apply_form.addr.value && !document.apply_form.addr0.value){
			alert("우편번호를 입력하기위해\n우편번호 찾기를 해주세요.");
			document.apply_form.addr.focus();
			return;
		}
		var addr_check = /[0-9]/;
		if (!addr_check.test(document.apply_form.addr.value) || !addr_check.test(document.apply_form.addr0.value) || document.apply_form.addr.value.length != 3 || document.apply_form.addr.value.length != 3){
			alert("우편번호를 확인해주세요.");
			document.apply_form.addr.focus();
			return;
		}
		if(!document.apply_form.addr1.value && !document.apply_form.addr2.value){
			alert("도로명 지번번호 중 한개는 입력 하셔야합니다.");
			document.apply_form.addr1.focus();
			return;
		}
		if(!document.apply_form.email.value){
			alert("이메일을 입력하세요.");
			document.apply_form.email.focus();
			return;
		}
		if (!((document.apply_form.email.value.indexOf(".") > 0) && (document.apply_form.email.value.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(document.apply_form.email.value)){
			alert("이메일 형식을 확인해주세요.");
			document.apply_form.email.focus();
			return;
		}
		document.apply_form.submit();
	}
</script>
</head>
<body>
	<div id="wraper">
		<header>
			<?php include _BASE_DIR."/include/header.php"; ?>
		</header>
		
		<section id="subloca">
			<div class="subloca">
				<p>Home &gt; 참가신청</p>
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
				<!--<?php include _BASE_DIR."/include/sub_apply_nav.php"; ?>-->
				<div class="subin">

			    	<!-- 셀렉트 박스를 보여주는곳  -->
			    	<div id="content">
					<form name="apply_form" action="apply_act.php" method="POST">
						<img src="<?=$pla_file1?>" alt="image" title="image">

						<table class="apply_table">
						<caption>선택된 대회 정보</caption>
						<tr><th>참가 대회명</th><td id="pla_name"><?=$pla_name?><!-- 참가대회명 --></td>

			    	<?
			    	if($_GET['num_']){
			    		$num_= $_GET['num_'];

			    		// 선택한대회에대한 정보를 보여주는데 쓸꺼야 299line
			    		$pla_num = $num_;
			    		#echo $pla_num;
			    		//대회정보에서 대회번호를 선택해서 들어온경우 

			    		$arr = array("q_table"=>"plan","q_fld"=>"*","q_where"=>"pla_idx","q_sch"=>$num_);

			    		/*
							select * from plan where pla_idx = num_
			    		*/
			    		$result = $apply_board->select_query($arr);

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
			    	}else{
			    	?>
					<h3 style="color: #1eb4a8;">대회를 선택해 주세요 </h3><br>
					<select name="num_" id='plan_num' >
					<option name="test" value=""  selected="selected">대회선택</option>
					<?php
					$planboard = new board();
				
					$arr_q = array("q_table" => "plan","q_column" => "pla_idx", "page"=>$page,"sch"=>$sch,"q_fld"=>$fld) ;
					$resultpage = $planboard->search_and_paging($arr_q);

					$result = $resultpage['result_article'];		

					var_dump($result);

					while($row = mysqli_fetch_array($result)){

						$num_=isset($row['pla_idx']) ? $row['pla_idx']: null;
						$item_pla_date=isset($row['pla_date']) ? $row['pla_date']: null;					
						$item_pla_name=isset($row['pla_name']) ? $row['pla_name']: null;					
					
						echo "<option  value='".$num_ ."'>".$item_pla_name."</option>";	
					}
					?>

					</select>	

					<?php
			    	}
					# num_이 없을경우 else 문의 끝 if(!$GET['num_'])

			    	# 회원 아이디로 이미 신청한 대회index를 배열로 준비한다.
						$apply_board = new board();				    	
						$arr = array("q_table"=>"apply", "q_condition1"=>"mem_id" ,"q_condition2"=>$userid, "q_fld"=>"pla_idx");
						$applied = $apply_board->select_query($arr);

						$cnt=0;

						$applied_arr = array();
						while($row = mysqli_fetch_array($applied)){
							$applied_arr[$cnt] = $row['pla_idx'];
							$cnt++;
						}

			    	$fld = "m_phone,m_email,m_tsize, m_addr,m_addr1,m_addr2,m_addr2,m_addr3";
			    	$arr_q = array("q_table"=> "member" ,"q_condition1" =>"m_id","q_condition2" =>$userid ,"q_fld"=>$fld) ;
			    	
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
								"m_addr2"=>$rows['m_addr2'],
								"m_addr3"=>$rows['m_addr3']
								);	
					}
					?>

			<input type="hidden" name="num_" id="plan_num_input" value="<?=$num_?>" >
			
			
			<?
			$fld ="pla_name, pla_date,pla_place, pla_time, pla_distance";
			#var_dump($pla_num);
			$arr_q = array("q_table"=> "plan" ,"q_condition1" =>"pla_idx","q_condition2" =>$pla_num ,"q_fld"=>$fld) ;
			$result = $apply_board->select_query($arr_q);

			while($rows =  mysqli_fetch_array($result)){
				$pla_name = $rows['pla_name'];
				$pla_date = $rows['pla_date'];
				$pla_place = $rows['pla_place'];
				$pla_time = $rows['pla_time'];
				$pla_distance = $rows['pla_distance'];
			}
			?>
						
			<tr><th>마라톤 일자</th><td id="date"><?=$pla_date?></td></tr>			
			<tr><th>마라톤 장소</th><td id="place"><?=$pla_place?></td></tr>
			<tr><th>마라톤 시간</th><td id="time"><?=$pla_time?></td></tr>
			<tr><th>마라톤 거리(km)</th><td id="distance"><?=$pla_distance?></td></tr>
			</table>


            <!-- 로그인한 회원의 내용을 읽어온다. -->
			<table class="apply_table apply_table2">
			<caption>변경된 회원정보를 적어주세요.<br/><span class="redt red">* 표시는 필수입력사항 입니다.</span></caption>			
			<tr><th><span class="red">*</span> 전화번호</th><td><input type="text" name="phone" value="<?=$arr_res['m_phone']?>" /><span class="join_sub_text2">&nbsp; ex ) 01012345678</span></td></tr>
			<tr><th class="addr"><span class="red">*</span> 주소</th><td><input type="text" id="sample4_postcode1" name="addr" value="<?php $addr = substr($arr_res['m_addr'],0,3); echo $addr; ?>" onclick="sample4_execDaumPostcode()" class="addr_input" size="10" /> - <input type="text" id="sample4_postcode2" name="addr0" value="<?php $addr0= substr($arr_res['m_addr'],3,3); echo $addr0; ?>"  onclick="sample4_execDaumPostcode()" size="10" /> <input type="button" onclick="sample4_execDaumPostcode()" value="우편번호 찾기" class="join_btn_s2" id="findPostCodeButton" /><br><!--id뭐지?-->
			<input type="text" id="sample4_roadAddress" name="addr1" value="<?=$arr_res['m_addr1']?>" style="width:450px;" class="addr_input" placeholder="도로명" /><br />
			<input type="text" id="sample4_jibunAddress" name="addr2" value="<?=$arr_res['m_addr2']?>"  style="width:450px;" class="addr_input" placeholder="지번" /><span id="guide" style="color:#999;font-size:12px;"></span><input type="text" name="addr3" id="sample4_jibunAddress" value="<?=$arr_res['m_addr3']?>" class="addr_input" style="width:450px;" placeholder="상세주소"  /></td></tr>
			<tr><th><span class="red">*</span> 이메일</th><td><input type="email" name="email" class="email" value="<?=$arr_res['m_email']?>" /></td></tr>
			<tr><th>옷 사이즈</th><td>
			<select name="t_size">
			<?$arr_tsize=array("0"=>"사이즈선택","85"=>"XS(85)","90"=>"S(90)","95"=>"M(95)","100"=>"L(100)","105"=>"XL(105)","110"=>"XXL(110)","115"=>"XXXL(115)");?>
			<?foreach($arr_tsize as $key=>$val){$selected=$arr_res['m_tsize']==$key ? " selected":"";?><option value="<?=$key?>"<?=$selected?>><?=$val?></option><?}?>
			</select></td></tr>
			</table>

			<div id="button">
			<input type="button" value="신청하기" onclick="javacript:check_input();" />
			</div>
	
			</form><!--apply_form end-->
			</div><!--content end-->

				</div>
			</div>
		</section>

		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
	</div>
</body>
</html>