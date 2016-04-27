<?php
  require_once("./board_n_su_h.php");//메인소스 윗부분

  $usernick=$_SESSION["usernick"];
  $username=$_SESSION["username"];
  $mode=$_GET["mode"];
  $table=$_GET["table"];
  $col="bn_num";
  $num=$_GET["num"];
  $page=$_GET["page"];

  if(!$userid){
    echo("
    <script>
    window.alert('로그인을 하십시요');
    history.go(-1);
    </script>
    ");
    exit;
  }


  if($mode=="modify"){
    $sql="select * from $table where $col=$num";
    $result=mysql_query($sql, $connect);
    $row=mysql_fetch_array($result);
    
    $item_subject=$row[bn_subject];
    $item_content=$row[bn_content];
    $item_file_0=$row[bn_file_name_0];
    $item_file_1=$row[bn_file_name_1];
    $item_file_2=$row[bn_file_name_2];
    
    $copied_file_0=$row[bn_file_copied_0];
    $copied_file_1=$row[bn_file_copied_1];
    $copied_file_2=$row[bn_file_copied_2];
  }
?>
  <script>
  function check_input(){
    if(!document.board_form.subject.value){
      alert("제목을 입력해주세요");
      document.board_form.subject.focus();
      return;
    }
    if(!document.board_form.content.value){
      alert("내용을 입력해주세요");
      document.board_form.content.focus();
      return;
    }

/*	files = document.getElementsByName("upfile[]");
	if ( files[0].value=="" ) {
	    alert("사진을 올려주세요");
        files[0].focus();
        return;
	}

*/ //파일 유효성 검사부분인데 예외 사항이 생겨 인서트로 뺌
    document.board_form.submit();
  }
  </script>


<div class="write_form">
	<?php if($mode=="modify") { ?>
	<form name="board_form" method="post" action="insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>" enctype="multipart/form-data">
	<?php } else { ?>
	<form name="board_form" method="post" action="insert.php?table=<?=$table?>" enctype="multipart/form-data">
	<?php } ?>
		
		<table>
			<!--<caption>공지사항 등록하기</caption>-->
			<tr>
				<th>작성자</th>
				<td><?echo"$username($userid)"?>&nbsp;|&nbsp;<input type="checkbox" name="html_ok" value="y">HTML 쓰기</input></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><input class="subjecti" type="text" name="subject" value="<?=$item_subject?>"></input></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><textarea class="content" rows="15" cols="80" name="content"><?=$item_content?></textarea></td>
			</tr>
			<tr>
				<th>사진1</th>
				<td><input type="file" name="upfile[]"></input>
				<?php
				if($mode=="modify" && $item_file_0)
				{
				?>
				  <span class="delete_ok">
					<?=$item_file_0?> 파일 등록
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
				if($mode=="modify" && $item_file_1)
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
				if($mode=="modify" && $item_file_2)
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
		</table>

		<div id="button">
			<!--<a href="#" onclick="check_input();">입력완료</a>-->
			<?php
			if($mode=="modify"){
			?>
			<input type="button" value="수정하기" onclick="check_input();"/>
			<?php
			} else {
			?>
			<input type="button" value="글올리기" onclick="check_input();"/>
			<?php
				}
			?>
			<input type="reset" value="다시쓰기"  />
			<input type="button" value="목록보기" onclick="location.href='list.php?page=<?=$page?>'" />
		</div>
	</form>
</div>


<?require_once("./board_n_su_f.php");?>