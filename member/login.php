<?require_once("./login_h.php");?>

	<form class="login_form" name="login_form" method="post" action="login_action.php" onsubmit="return chk_logform();">
	<input type="hidden" name="cu_page" value="<?=$pre_page?>">
	<!-- 로그인세션 정보보내기 -->
	<input type="hidden" name="apply" value="<?=$apply?>">
		<table>
			<tr>
				<th>아이디</th><td><input type="text" name="id" size="20" tabindex="1" class="login_td2" autofocus/></td><td rowspan="2"><input type="submit" value="로그인" class="login_btn" tabindex="3" /></td>
			</tr>
			<tr>
				<th>비밀번호</th><td><input type="password" name="pass" size="20" tabindex="2" class="login_td2" /></td>
			</tr>
		</table>
		<p>아직 TERRARUN회원이 아니신가요? | <a href="./join_ok.php">회원가입</a></p>
	</form>

<?require_once("./login_f.php");?>