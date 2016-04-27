<?require_once("./mypage_h.php");
  $mode=$_GET['mode'];#0이면 수정 1이면 탈퇴  
?>
<script>
	function chk_pass() {
		if(delete_form.pass.value == "") {
			alert('Input Pass');
			delete_form.pass.focus();
			return false;
		}
		else{			
		document.delete_form.submit();
		}
	}
	function chk_pass2() {
		if(delete_form.pass.value == "") {
			alert('Input Pass');
			delete_form.pass.focus();
			return false;
		}
		else{			
		var up=confirm("정말로 탈퇴하시겠습니까?");
		if(up){document.delete_form.action="./delete.php";document.delete_form.submit();}else{document.delete_form.action="./mypage.php";document.delete_form.submit();}
		}
	}
	function chk_pass3() {
		if(delete_form.pass.value == "") {
			alert('비밀번호를 입혁하세요.');
			delete_form.pass.focus();
			return false;
		}
		if(delete_form.newpass.value == "") {
			alert('변경 비밀번호를 입력하세요.');
			delete_form.newpass.focus();
			return false;
		}
		if(delete_form.newpass2.value == "") {
			alert('변경 비밀번호 확인을 입력하세요.');
			delete_form.newpass2.focus();
			return false;
		}
		if(delete_form.newpass.value != delete_form.newpass2.value) {
			alert('변경 비밀번호와 확인 비밀번호가 다릅니다.');
			delete_form.newpass.focus();
			return false;
		}
		var pass_check = /[A-Za-z0-9!@#$%^&*()]{8,20}$/i; 
		var pass_chk_num = delete_form.newpass.value.search(/[0-9]/g); 
		var pass_chk_eng =delete_form.newpass.value.search(/[a-z]/ig); 
		var pass_chk_spa =delete_form.newpass.value.search(/[!@#$%^&*()]/ig); 
		if (!pass_check.test(delete_form.newpass.value) || pass_chk_num <0 || pass_chk_eng<0 || pass_chk_spa<0 ){
			alert('비밀번호 형식이 틀렸습니다.'); 
			document.delete_form.newpass.focus();
			return; 
		}		
		else{			
		document.delete_form.action="./update_pass.php";document.delete_form.submit();
		}
	}
</script>
  <div id="wraper">
    <header>
    </header>
    <menu>
    </menu>
    <div id="content">
        <form class="delete_form" name="delete_form" method="post" action="./m_form_modify.php" onsubmit="return chk_pass();">
			<?#0:수정	1:탈퇴	2:비번번경
			if($mode==0){ echo "<h3>비밀번호 확인 후 수정</h3>"; }elseif($mode==1){echo "<h3>비밀번호 확인 후 탈퇴</h3>";}else{echo "<h3>비밀번호 변경</h3>";} ?> 
			<table class="check_delete_table">
			<tr><th>비밀번호</th><td><input type="password" name="pass" /></td></tr>
			<?if($mode==2){echo "<tr><th>변경 비밀번호</th><td><input type='password' name='newpass' /></td></tr><tr><th>변경 비밀번호 확인</th><td><input type='password' name='newpass2' /></td></tr>";}?>
			</table>
			<div id="button">
				<? $mo='a'; if($mode==0){ echo "<input type='submit' value='수정하기' />"; }elseif($mode==1){echo "<input type='button' value='탈퇴하기' onclick='javascript:chk_pass2();' />";}else{echo "<input type='button' value='비밀번호 변경' onclick='javascript:chk_pass3();' />"; } ?>
			</div>
        </form>
    </div>
  </div>
<?require_once("./mypage_f.php");?>