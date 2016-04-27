<?php
  session_start();
  require_once("./join_h.php");
?>

<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
<script>/*close*/
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
<script>/*close*/
	function check_id(){
		window.open("check_id.php?id="+document.member_form.id.value,"IDcheck","left=200,top=200,width=220,height=60,scrollbars=no,resizable=yes");
	}

	function check_input(){
		if(!document.member_form.id.value){
			alert("아이디를 입력하세요.");
			document.member_form.id.focus();
			return;
		}
		var id_check = /^[a-z]+[a-z0-9]{5,19}$/g;
		if (!id_check.test(document.member_form.id.value)){
			alert("아이디는 영문 소문자로 시작하는 6~20자 영문 소문자 또는 숫자이어야 합니다.");
			document.member_form.id.focus();
			return;
		}
		var pw = document.member_form.pass.value;
		var pw2 = document.member_form.pass_confirm.value;
		if(!pw){
			alert("비밀번호를 입력하세요.");
			document.member_form.pass.focus();
			return;
		}
		if(!pw2){
			alert("비밀번호확인을 입력하세요.");
			document.member_form.pass_confirm.focus();
			return;
		}
		if(pw != pw2){
			alert("비밀번호가 일치하지 않습니다.");
			document.member_form.pass.focus();
			document.member_form.pass.select();
			return;
		}
		var pass_check = /[A-Za-z0-9!@#$%^&*()]{8,20}$/i; 
		var pass_chk_num = pw.search(/[0-9]/g); 
		var pass_chk_eng =pw.search(/[a-z]/ig); 
		var pass_chk_spa =pw.search(/[!@#$%^&*()]/ig); 
		if (!pass_check.test(pw) || pass_chk_num <0 || pass_chk_eng<0 || pass_chk_spa<0 ){
			alert('비밀번호 형식이 틀렸습니다.'); 
			document.member_form.pass.focus();
			return; 
		}
		if(!document.member_form.name.value){
			alert("이름을 입력하세요");
			document.member_form.name.focus();
			return;
		}
		var name_check = /[가-힣a-zA-Z]$/g; 
		if (!name_check.test(document.member_form.name.value)){
			alert('이름은 영문자와 한글만 가능합니다.'); 
			return; 
		}
		if(!document.member_form.gender.value){
			alert("성별을 입력하세요.");
			document.member_form.gender.focus();
			return;
		}
		if(!document.member_form.birth.value){
			alert("생년월일을 입력하세요.");
			document.member_form.birth.focus();
			return;
		}
		var birth_check = /[0-9]/;
		if (!birth_check.test(document.member_form.birth.value) || document.member_form.birth.value.length !=8){
			alert("생년월일은 8개의 숫자로 입력해주세요.");
			document.member_form.birth.focus();
			return;
		}
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
<body>
<div id="wraper">
	<div id="content">
		<div class="join_con">
		TERRARUN에 오신 것을 환영합니다.<br/>회원가입을 위해 아래의 빈칸을 입력해주세요.<br/>
		<span class="red">*표시는 필수입력사항 입니다.</span>
		</div>

		<form name="member_form" method="post" action="insert.php">
			<table class="join_table">
			<tr><th><span class="red">*</span> 아이디</th><td><input type="text" name="id" id="id" /> <a href="#id" onclick="check_id()"><input type="button" value="중복확인" class="join_btn_s" /></a><span class="join_sub_text">&nbsp; 영문 소문자로 시작하는 6~20자 영문 소문자 또는 숫자</span></td></tr>
			<tr><th><span class="red">*</span> 비밀번호</th><td><input type="password" name="pass" /><span class="join_sub_text">&nbsp; 영문자, 숫자, 특수문자를 조합 한 8~20자</span></td></tr>
			<tr><th><span class="red">*</span> 비밀번호 확인</th><td><input type="password" name="pass_confirm" /></td></tr>
			<tr><th><span class="red">*</span> 이름</th><td><input type="text" name="name" /></td></tr>
			<tr><th><span class="red">*</span> 성별</th><td><input type="radio" name="gender" value="남자" checked="checked" /> 남자&nbsp;&nbsp;<input type="radio" name="gender" value="여자" /> 여자</td></tr>
			<tr><th><span class="red">*</span> 생년월일</th><td><input type="text" name="birth" /><span class="join_sub_text2">&nbsp; ex ) 19910410 - 4자리년도</span></td></tr>
			<tr><th><span class="red">*</span> 전화번호</th><td><input type="text" name="phone" /><span class="join_sub_text2">&nbsp; ex ) 01012345678</span></td></tr>
			<tr><th class="addr"><span class="red">*</span> 주소</th><td><input type="text" id="sample4_postcode1" name="addr" onclick="sample4_execDaumPostcode()" class="addr_input" size="10" /> - <input type="text" id="sample4_postcode2" name="addr0" onclick="sample4_execDaumPostcode()" size="10" /> <input type="button" onclick="sample4_execDaumPostcode()" value="우편번호 찾기" class="join_btn_s2" /><br />
			<input type="text" id="sample4_roadAddress" name="addr1" placeholder="도로명주소" style="width:450px;" class="addr_input" /><br />
			<input type="text" id="sample4_jibunAddress" name="addr2" placeholder="지번주소" style="width:450px;" class="addr_input" /><span id="guide" style="color:#999;font-size:12px;"></span><input type="text" name="addr3" class="addr_input" style="width:450px;" placeholder="상세주소"  /></td></tr>
			<tr><th><span class="red">*</span> 이메일</th><td><input type="email" name="email" class="email" /></td></tr>
			<tr><th>옷 사이즈</th><td>
			<select name="tsize">
				<option selected="selected" value="0">선택하세요</option>
				<option value="85">XS(85)</option>
				<option value="90">S(90)</option>
				<option value="95">M(95)</option>
				<option value="100">L(100)</option>
				<option value="105">XL(105)</option>
				<option value="110">XXL(110)</option>
				<option value="115">XXL(115)</option>
			</select></td></tr>
			</table>
			<div id="button">
				<input type="button" onclick="check_input()" value="회원가입" class="join_btn" />
				<input type="reset" value="전부지우기" class="join_btn" />
			</div>
		</form>
	</div>
</div>
<?require_once("./join_f.php");?>
