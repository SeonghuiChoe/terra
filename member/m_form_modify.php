<?require_once("./mypage_h.php");?>

<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>
	function sample4_execDaumPostcode() {
		new daum.Postcode({
			oncomplete: function(data) {// 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.
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
	}
</script>
<script>
function check_input(){
		if(!document.member_form.phone.value){
			alert("핸드폰 번호를 입력하세요.");
			document.member_form.phone.focus();
			return;
		}
		var phone_check = /[0-9]/;
		if (!phone_check.test(document.member_form.phone.value) || document.member_form.phone.value.length < 8  || document.member_form.phone.value.length > 12){
			alert("핸드폰 번호를 확인해주세요.");
			document.member_form.phone.focus();
			return;
		}
		if(!document.member_form.addr.value && !document.member_form.addr0.value){
			alert("우편번호를 입력하기위해\n우편번호 찾기를 해주세요.");
			document.member_form.addr.focus();
			return;
		}
		var addr_check = /[0-9]/;
		if (!addr_check.test(document.member_form.addr.value) || !addr_check.test(document.member_form.addr0.value) || document.member_form.addr.value.length != 3 || document.member_form.addr.value.length != 3){
			alert("우편번호를 확인해주세요.");
			document.member_form.addr.focus();
			return;
		}
		if(!document.member_form.addr1.value && !document.member_form.addr2.value){
			alert("도로명 지번번호 중 한개는 입력 하셔야합니다.");
			document.member_form.addr1.focus();
			return;
		}
		if(!document.member_form.email.value){
			alert("이메일을 입력하세요.");
			document.member_form.email.focus();
			return;
		}
		if (!((document.member_form.email.value.indexOf(".") > 0) && (document.member_form.email.value.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(document.member_form.email.value)){
			alert("이메일 형식을 확인해주세요.");
			document.member_form.email.focus();
			return;
		}
		document.member_form.submit();
	}
</script>
<?php

$userid = $_SESSION["userid"];
$pass=$_POST['pass'];

if(!$userid){
	echo "<script>window.alert('로그인을 해주세요.');location.href='./login_form.php';</script>";
	}

$sql="select * from member where m_id='$userid'";
$result = mysql_query($sql, $connect);
$row = mysql_fetch_assoc($result);

if(!$row[m_id]){
	include "./logout.php";
	echo "<script>window.alert('회원 정보가 없습니다.');location.href='./login_form.php';</script>";
	}#만약 modify page에서 회원정보가 사라졌을때

$db_pass=$row[m_pass];
if($pass!=$db_pass){
	echo "<script>window.alert('비밀번호가 틀렸습니다.');location.href='./check_delete.php?mode=0';</script>";
	exit;
	}
?>
<div id="wraper">
	<div id="content">
		<div class="mypage_con_m"><span class="name"><?= $row[m_name] ?>(<?= $row[m_id] ?>)</span>님의 변경된 정보를 수정해주세요.<br/>
		<span class="red">*표시는 필수입력사항 입니다.</span>
		</div>
		<form name="member_form" method="post" action="modify.php">
			<table class="join_table">
			<tr><th><span class="red">*</span> 아이디</th><td><input type="text" name="id" id="id" value="<?= $row[m_id] ?>" disabled /></td></tr>
			<tr><th><span class="red">*</span> 이름</th><td><input type="text" name="name" value="<?= $row[m_name] ?>" disabled /><span class="join_sub_text"> 개명된 경우만 변경가능합니다.</span></td></tr>
			<tr><th><span class="red">*</span> 전화번호</th><td><input type="text" name="phone" value="<?= $row[m_phone] ?>" /><span class="join_sub_text2">&nbsp; ex ) 01012345678</span></td></tr>
			<tr><th class="addr"><span class="red">*</span> 주소</th><td><input type="text" id="sample4_postcode1" name="addr" value="<?$addr=substr($row[m_addr],0,3); echo $addr; ?>" onclick="sample4_execDaumPostcode()" class="addr_input" size="10" /> - <input type="text" id="sample4_postcode2" name="addr0" value="<?$addr2=substr($row[m_addr],3,3); echo $addr2; ?>"  onclick="sample4_execDaumPostcode()" size="10" /> <input type="button" onclick="sample4_execDaumPostcode()" value="우편번호 찾기" class="join_btn_s2" /><br>
			<input type="text" id="sample4_roadAddress" name="addr1" value="<?= $row[m_addr1] ?>" style="width:450px;" class="addr_input" /><br>
			<input type="text" id="sample4_jibunAddress" name="addr2" value="<?= $row[m_addr2] ?>"  style="width:450px;" class="addr_input" /><span id="guide" style="color:#999;font-size:12px;"></span><input type="text" name="addr3" class="addr_input" value="<?= $row[m_addr3] ?>"  style="width:450px;" placeholder="상세주소"  /></td></tr>
			<tr><th><span class="red">*</span> 이메일</th><td><input type="email" name="email" value="<?= $row[m_email] ?>" /></td></tr>
			<tr><th>옷 사이즈</th><td>
			<select name="tsize">
			<?$arr_tsize=array("0"=>"사이즈선택","85"=>"XS(85)","90"=>"S(90)","95"=>"M(95)","100"=>"L(100)","105"=>"XL(105)","110"=>"XXL(110)","115"=>"XXXL(115)");?>
			<?foreach($arr_tsize as $key=>$val){$selected=$row[m_tsize]==$key ? " selected":"";?><option value="<?=$key?>"<?=$selected?>><?=$val?></option><?}?>
			</select></td></tr>
			</table>
			<div id="button">
				<input type="button" onclick="check_input()" value="정보수정" class="join_btn" />
				<input type="button" onclick="javascript:location.href='./mypage.php'" value="수정취소" class="join_btn" />
			</div>
		</form>
	</div>
</div>
<?php
mysql_close();
?>
<?require_once("./mypage_f.php");?>
