<?
include("./board_f_h.php");

include ("../lib/dbconn.php");
$userid=$_SESSION["userid"];
$username=$_SESSION["username"];
$mode=$_GET["mode"];
$table=$_GET["table"];
$col="bf_num";
$bf_num=$_GET["bf_num"];
$page=$_GET["page"];
$mypage=$_GET["mypage"];
$test=$_GET["test"];  

if(!$userid){
	echo("
	<script>
	window.alert('로그인을 하십시오');
	location.href='../member/login.php';
	</script>
	");
	exit;
}

if($mode=="modify"){
	$sql="SELECT * FROM $table WHERE $col=$bf_num";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);
	$bf_title=$row[bf_title];
	$bf_content=$row[bf_content];
	mysql_close();
}
?>
<script>
function check_input() {
	if(!document.bf_write.subject.value) {
		alert("제목을 입력하세요");
		document.bf_write.subject.focus();
		return;
	}
	if(!document.bf_write.content.value) {
		alert("내용을 입력하세요");
		document.bf_write.content.focus();
		return;
	}
	document.bf_write.submit();
}
</script>

<div class="write_form">
<?
if($mode=="modify") {
?>
	<form name="bf_write" method="post" action="write_insert.php?mode=modify&bf_num=<?=$bf_num?>&page=<?=$page?>&table=<?=$table?>&mypage=<?=$mypage?>&test=<?=$test?>">
<?
} else {
?>
	<form name="bf_write" method="post" action="write_insert.php?table=<?=$table?>&page=<?=$page?>">
<?
}
?>
		<table>
			<tr>
				<th>작성자</th>
				<td><?echo"$username($userid)"?>&nbsp;|&nbsp;<input type="checkbox" name="html_ok" value="y">HTML 쓰기</input></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><input class="subject" type="text" name="subject" value="<?=$bf_title?>"></input></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><textarea class="content" rows="15" cols="80" name="content"><?=$bf_content?></textarea></td>
			</tr>
		</table>
		<div id="button">
			<?
			if($mode=="modify"){
			?>
			<input type="button" value="수정하기" onclick="check_input();"/>
			<?
			} else {
			?>
			<input type="button" value="글올리기" onclick="check_input();"/>
			<?
			}
			?>
			<input type="reset" value="다시쓰기" />
			<input type="button" value="목록보기" onclick="location.href='list.php?page=<?=$page?>'" />
		</div>
	</form>
</div>
<?
include("./board_f_f.php");
?>