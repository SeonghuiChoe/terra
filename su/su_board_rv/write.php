<?
include("./board_rv_su_h.php");
$userid=$_SESSION["userid"];
$username=$_SESSION["username"];
$mode=$_GET["mode"];
$table=$_GET["table"];
$br_num=$_GET["br_num"];
$page=$_GET["page"];

if(!$userid){
	echo("
	<script>
	window.alert('로그인을 하십시오');
	history.go(-1);
	</script>
	");
	exit;
}

if($mode=="modify"){
	$sql="SELECT * FROM $table WHERE br_num=$br_num";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);
	
	$br_title=$row[br_title];
	$br_content=$row[br_content];
	$br_img_0=$row[br_img_0];
	$br_img_1=$row[br_img_1];
	$br_img_2=$row[br_img_2];

	$br_copied_file_0=$row[br_copied_0];
	$br_copied_file_1=$row[br_copied_1];
	$br_copied_file_2=$row[br_copied_2];
	mysql_close();
}
?>
<script>
function check_input() {
	if(!document.br_write.subject.value) {
		alert("제목을 입력하세요");
		document.br_write.subject.focus();
		return;
	}
	if(!document.br_write.content.value) {
		alert("내용을 입력하세요");
		document.br_write.content.focus();
		return;
	}
	document.br_write.submit();
}
</script>

<div class="write_form">
<?
if($mode=="modify") {
?>
	<form name="br_write" method="post" action="write_insert.php?mode=modify&br_num=<?=$br_num?>&page=<?=$page?>&table=<?=$table?>" enctype="multipart/form-data">
<?
} else {
?>
	<form name="br_write" method="post" action="write_insert.php?table=<?=$table?>&page=<?=$page?>" enctype="multipart/form-data">
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
				<td><input class="subjecti" type="text" name="subject" value="<?=$br_title?>"></input></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><textarea class="content" rows="15" cols="80" name="content"><?=$br_content?></textarea></td>
			</tr>
			<tr>
				<th>사진1</th>
				<td><input type="file" name="upfile[]"></input>
				<?php
				if($mode=="modify" && $br_img_0)
				{
				?>
				  <span class="delete_ok">
					<?=$br_img_0?> 파일 등록
					<input type="checkbox" name="del_file[]" value="0">삭제</input>
				  </span>
				<?php
				}
				?>
				</td>
			</tr>
			<tr>
				<th>사진2</th>
				<td><input type="file" name="upfile[]"></input>
				<?php
				if($mode=="modify" && $br_img_1)
				{
				?>
				  <span class="delete_ok">
					<?=$br_img_1?> 파일 등록
					<input type="checkbox" name="del_file[]" value="1">삭제</input>
				  </span>
				<?php
				}
				?>
				</td>
			</tr>
			<tr>
				<th>사진3</th>
				<td><input type="file" name="upfile[]"></input>
				<?php
				if($mode=="modify" && $br_img_2)
				{
				?>
				  <span class="delete_ok">
					<?=$br_img_2?> 파일 등록
					<input type="checkbox" name="del_file[]" value="2">삭제</input>
				  </span>
				<?php
				}
				?>
				</td>
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
			<a href="list.php?page=<?=$page?>">목록보기</a>
		</div>
	</form>
</div>
<?
include("./board_rv_su_f.php");
?>