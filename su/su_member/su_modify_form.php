<?php
session_start();
$userid = $_SESSION["userid"];
$username = $_SESSION["username"];
$userlevel = $_SESSION["userlevel"];
include "../../common.php";
$race=$_GET['race'];
$m_id=$_GET['m_id'];

if(!$userid){echo "<script>window.alert('로그인을 해주세요.');location.href='./login_form.php';</script>";}
if($userlevel!=10 ){echo "<script>window.alert('관리자만 접근가능합니다.');</script>";exit;}

$sql="select * from member where m_id='$m_id'";
$result = mysql_query($sql, $connect);
$row = mysql_fetch_assoc($result);


if(!$row[m_id]){include _BASE_DIR."/logout.php";echo "<script>
	window.alert('회원 정보가 없습니다.');
	location.href='./login_form.php';
  </script>";}#만약 modify page에서 회원정보가 사라졌을때

/*$sql="select * from apply where mem_id='$userid'";
$result2 = mysql_query($sql, $connect);
$total_record=mysql_num_rows($result2);
$row2 = mysql_fetch_assoc($result2);*/

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<title>회원 정보 수정하기 - Terra Run</title>
<link rel="stylesheet" type="text/css" href="../css/admin.css">
<link rel="stylesheet" type="text/css" href="../css/member.css">
<script type="text/javascript" src="http://dmaps.daum.net/map_js_init/postcode.v2.js"></script>
  <script>
    function sample4_execDaumPostcode() {
        new daum.Postcode({
            oncomplete: function(data) {
                // 팝업에서 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 도로명 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullRoadAddr = data.roadAddress; // 도로명 주소 변수
                var extraRoadAddr = ''; // 도로명 조합형 주소 변수

                // 법정동명이 있을 경우 추가한다.
                if(data.bname !== ''){
                    extraRoadAddr += data.bname;
                }
                // 건물명이 있을 경우 추가한다.
                if(data.buildingName !== ''){
                    extraRoadAddr += (extraRoadAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                }
                // 도로명, 지번 조합형 주소가 있을 경우, 괄호까지 추가한 최종 문자열을 만든다.
                if(extraRoadAddr !== ''){
                    extraRoadAddr = ' (' + extraRoadAddr + ')';
                }
                // 도로명, 지번 주소의 유무에 따라 해당 조합형 주소를 추가한다.
                if(fullRoadAddr !== ''){
                    fullRoadAddr += extraRoadAddr;
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById("sample4_postcode1").value = data.postcode1;
                document.getElementById("sample4_postcode2").value = data.postcode2;
                document.getElementById("sample4_roadAddress").value = fullRoadAddr;
                document.getElementById("sample4_jibunAddress").value = data.jibunAddress;

                // 사용자가 '선택 안함'을 클릭한 경우, 예상 주소라는 표시를 해준다.
                if(data.autoRoadAddress) {
                    //예상되는 도로명 주소에 조합형 주소를 추가한다.
                    var expRoadAddr = data.autoRoadAddress + extraRoadAddr;
                    document.getElementById("guide").innerHTML = '(예상 도로명 주소 : ' + expRoadAddr + ')';

                } else if(data.autoJibunAddress) {
                    var expJibunAddr = data.autoJibunAddress;
                    document.getElementById("guide").innerHTML = '(예상 지번 주소 : ' + expJibunAddr + ')';

                } else {
                    document.getElementById("guide").innerHTML = '';
                }
            }
        }).open();
    }
</script>
  <script>
    function check_input(){	
	if(!document.member_form.name.value){
        alert("이름를 입력하세요");
        document.member_form.name.focus();
        return;
      }
	  if(!document.member_form.gender.value){
        alert("성별을 입력하세요");
        return;
      }
	  if(!document.member_form.birth.value){
        alert("생년월일를 입력하세요");
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
        alert("핸드폰 번호를 입력하세요");
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
        alert("우편번호를 입력하기위해\n우편번호 찾기를 해주세요");
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
        alert("도로명 지번번호 중 한개는 입력 하셔야합니다. ");
        document.member_form.addr.focus();
        return;
	  }
      if(!document.member_form.email.value){
        alert("이메일을 입력하세요");
        document.member_form.email.focus();
        return;
      }
	  	  if (!((document.member_form.email.value.indexOf(".") > 0) && (document.member_form.email.value.indexOf("@") > 0)) || /[^a-zA-Z0-9.@_-]/.test(document.member_form.email.value)){
        alert("The Email address is invalid.");
		return false;
      }
      document.member_form.submit();
    }

	function check_pass(){	

	}
	

  </script>
<style type="text/css">
	.su_left dt:nth-child(9) a { color:#fff; background-color:#1eb4a8; }
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
				<h1>회원가입 현황</h1>
				<p>테라런 회원정보 수정하기</p>
			</header>
			<div class="right_cont">

				

<form name="member_form" method="post" action="su_modify.php?m_id=<?=$row[m_id]?>">
	  <table class="mypage_table">
	  <tr><th>아이디</th><td><input type="text" name="id" id="id" value="<?= $row[m_id] ?>" disabled /></td>
	  </tr>
	  <!--<tr><td class="su_mypage_td">비밀번호</td><td class="su_mypage_m"><input type="text" name="pass" id="pass" value="<?echo substr($row[m_pass],0,3).'****';?>" /></td></tr>-->

	  <tr><th>이름</th><td><input type="text" name="name" value="<?= $row[m_name] ?>" /></td></tr>
	  <tr><th>성별</th><td><? if($row[m_gender]=='남'){echo "<input type='radio' name='gender' value='남' checked='checked' />"; } else{ echo "<input type='radio' name='gender' value='남' />";} ?> 남자&nbsp;&nbsp;<? if($row[m_gender]=='여'){echo "<input type='radio' name='gender' value='여' checked='checked' />"; } else{ echo "<input type='radio' name='gender' value='여' />";} ?>여자</td></td></tr>
	  <tr><th>생년월일</th><td><input type="text" name="birth" value="<?= $row[m_birth] ?>" /><span class="join_sub_text2">&nbsp; ex ) 19910410 - 4자리년도</span></td></tr>
	  <tr><th>전화번호</th><td><input type="text" name="phone" value="<?= $row[m_phone] ?>" /><span class="join_sub_text2">&nbsp; ex ) 01012345678</span></td></tr>
	  <tr><th>주소</th><td class="addr"><input type="text" id="sample4_postcode1" name="addr" value="<?$addr=substr($row[m_addr],0,3); echo $addr; ?>" onclick="sample4_execDaumPostcode()" class="addr_input" /> - <input type="text" id="sample4_postcode2" name="addr0" value="<?$addr2=substr($row[m_addr],3,3); echo $addr2; ?>" onclick="sample4_execDaumPostcode()"  /> <input type="button" onclick="sample4_execDaumPostcode()" value="우편번호 찾기"><br>
	<input type="text" id="sample4_roadAddress" name="addr1" value="<?= $row[m_addr1] ?>" style="width:450px;" class="addr_input" /><br>
	<input type="text" id="sample4_jibunAddress" name="addr2" value="<?= $row[m_addr2] ?>"  style="width:450px;" /><br /><span id="guide" style="color:#999;font-size:12px;"></span><input type="text" name="addr3" class="addr_input" value="<?= $row[m_addr3] ?>"  style="width:450px;" placeholder="상세주소"  /></td></tr>
	  <tr><th>이메일</th><td><input type="email" name="email" value="<?= $row[m_email] ?>" /></td></tr>
	  <tr><th>T-size</th><td><select name="tsize">
		<?$arr_tsize=array("0"=>"사이즈등록","85"=>"XS(85)","90"=>"S(90)","95"=>"M(95)","100"=>"L(100)","105"=>"XL(105)","110"=>"XXL(110)","115"=>"XXXL(115)");?>
		<?foreach($arr_tsize as $key=>$val){$selected=$row[m_tsize]==$key ? " selected":"";?><option value="<?=$key?>"<?=$selected?>><?=$val?></option><?}?>
	  </select></td></tr>
	  </table>

	<div id="button">
	  <input type="button" onclick="check_input()" value="정보수정"> <input type="button" onclick="javascript:alert('이메일보내는거만들기');" value="비밀번호변경"> <input type="button" onclick="javascript:history.go(-1);" value="수정취소">
	  </div>

	  </form>





			</div>
		</section>
		</div>
		<footer>
		<?php include _BASE_DIR."/include/footer.php"; ?>
		</footer>
		</div>
	</div>
<?php
mysql_close();
?>
</body>
</html>