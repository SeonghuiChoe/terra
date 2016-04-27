<?
include("./board_rv_h.php");

include ("../lib/dbconn.php");
$userid=$_SESSION["userid"];
$username=$_SESSION["username"];
$mode=$_GET["mode"];
$table=$_GET["table"];
$br_num=$_GET["br_num"];
$page=$_GET["page"];
$mypage=$_GET["mypage"];
$test=$_GET["test"];

if(!$userid){
	echo("<script>window.alert('로그인을 하십시오');location.href='../member/login.php';</script>");
	exit;
}

if($mode=="modify"){
	$sql="SELECT * FROM $table WHERE br_num=$br_num";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);
	
	$br_title=$row[br_title];
	$br_content=$row[br_content];
	$total_image_name=$row[br_img_0];
	$item_file=explode(",", $total_image_name);
    $file_cnt=count($item_file);
	//$br_img_1=$row[br_img_1];
	//$br_img_2=$row[br_img_2];

	$total_image_copied=$row[br_copied_0];
	$copied_file=explode(",", $total_image_copied);
	//$br_copied_file_1=$row[br_copied_1];
	//$br_copied_file_2=$row[br_copied_2];
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
<script>
	//파일 추가 버튼
	function file_add(){
		
		var parent = document.getElementById("table");
		var node_length = parent.children.length;//왜 1부터지?
		if(node_length > 4) {
			//alert("이미지는 5개 이하로 등록 하여야 합니다.");
		}else{
		var tr = document.createElement("tr");
		var th = document.createElement("th");
		var num = parent.children.length+1;
		var node = document.createTextNode('사진'+num);
		var td = document.createElement("td");
		var input = document.createElement("input");
			input.type = "file";
			input.name = "upfile[]";
		tr.appendChild(th).appendChild(node);
		tr.appendChild(td).appendChild(input);
		document.getElementById("table").appendChild(tr);
		}
		}
		
	//파일 제거 버튼
	function file_del() {
		var parent = document.getElementById("table");
		var node_length = parent.children.length+3;
		var node_length = node_length-1;
		if(node_length <4){
			//alert("이미지를 1개 이상 등록 하여야 합니다.");
		}else{
			var tr = document.getElementsByTagName("tr")[node_length];
			parent.removeChild(tr);
		}
	}

		//파일 추가 버튼
	function file_add2(a){
		var parent = document.getElementById("table");
		var node_length = parent.children.length+a;//왜 1부터지?
		if(node_length > 5) {
			alert("이미지는 5개 이하로 등록 하여야 합니다.");
		}else{
		var tr = document.createElement("tr");
		var th = document.createElement("th");
		var num = parent.children.length+a;
		var node = document.createTextNode('사진'+num);
		var td = document.createElement("td");
		var input = document.createElement("input");
			input.type = "file";
			input.name = "upfile[]";
		tr.appendChild(th).appendChild(node);
		tr.appendChild(td).appendChild(input);
		document.getElementById("table").appendChild(tr);
		}
		}
		
	//파일 제거 버튼		
	function file_del2(a) {
		var parent = document.getElementById("table");
		var node_length = parent.children.length;
		if(node_length < a){
			alert("등록한 이미지는 삭제버튼을 눌러 삭제해주세요.");
		}else{
			var tr = document.getElementsByTagName("tr")[node_length+(a+1)];
			parent.removeChild(tr);
		}
	}

	
</script>

<div class="write_form">
<?
if($mode=="modify") {
?>
	<form name="br_write" method="post" action="write_insert.php?mode=modify&br_num=<?=$br_num?>&page=<?=$page?>&table=<?=$table?>&mypage=<?=$mypage?>&test=<?=$test?>" enctype="multipart/form-data">
<?
} else {
?>
	<form name="br_write" method="post" action="write_insert.php?table=<?=$table?>&page=<?=$page?>" enctype="multipart/form-data">
<?
}
?>
		<table id="table">
			<tr>
				<th>작성자</th>
				<td><?echo"$username($userid)"?>&nbsp;|&nbsp;<input type="checkbox" name="html_ok" value="y">HTML 쓰기</input></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><input class="subject" type="text" name="subject" value="<?=$br_title?>"></input></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><textarea class="content" rows="15" cols="80" name="content"><?=$br_content?></textarea></td>
			</tr>
			<tr>
				<th>사진1</th>
				<td><?if($mode=="modify"){echo "<input type='file' name='upfile[]'></input>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp;";}
				else{echo "<input type='file' name='upfile[]'></input>&nbsp;&nbsp;";}?>

				<?php
				if($mode=="modify" && $item_file)
				{					
				?>
				  <span class="delete_ok"><?=$item_file[0]?> <input type="checkbox" name="del_file[]" value="0">삭제</input>
				  </span>
				<?php
				}
				?>

				<div class="imgplus clearfix">
					<? if(!$mode=="modify"){ ?>
					<a name='file_add' href='javascript:file_add();'><img src="../images/imgp.jpg" alt="" /></a>
					<a name='file_del' href='javascript:file_del();'><img src="../images/imgm.jpg" alt="" /></a>
					<? }else{ ?>
					<a name='file_add' href='javascript:file_add2(<?=$file_cnt?>);'><img src="../images/imgp.jpg" alt="" /></a>
					<a name='file_del' href='javascript:file_del2(<?=$file_cnt?>);'><img src="../images/imgm.jpg" alt="" /></a>
					<? } ?>
				</div>

				</td>
			</tr>

			<?
			for($j=1;$j<$file_cnt;$j++){
				$cnt = $j+1;
				echo "<tr><th>사진".$cnt."</th><td><input type='file' name='upfile[]'>&nbsp;&nbsp;&nbsp;|&nbsp;&nbsp; <span class='delete_ok'>".$item_file[$j]." <input type='checkbox' name='del_file[]' value='".$j."'>삭제</td></tr>";
			}		
			?>

			<!--<tr>
				<th>사진2</th>
				<td><input type="file" name="upfile[]"></input>
				<?php
				if($mode=="modify" && $br_img_1)
				{
				?>
				  <span class="delete_ok">
					<?=$item_file_1?> 파일 등록
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
					<?=$item_file_2?> 파일 등록
					<input type="checkbox" name="del_file[]" value="2">삭제</input>
				  </span>
				<?php
				}
				?>
				</td>
			</tr>
			-->
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
			<input type="button" value="목록보기" onclick="history.back();" />
		</div>
	</form>

<!--
	<? if(!$mode=="modify"){ ?>
				<input type='button' value='파일추가' name='file_add' onclick='file_add();' />
				<input type='button' value='파일제거' name='file_del' onclick='file_del();' />
			<? }else{ ?>
				<input type='button' value='파일추가' name='file_add' onclick='file_add2(<?=$file_cnt?>);' />
				<input type='button' value='파일제거' name='file_del' onclick='file_del2(<?=$file_cnt?>);' />
			<? } ?>
-->
</div>
<?
include("./board_rv_f.php");
?>