<?php
  require_once("./board_n_h.php");//메인소스 윗부분
  
  $mode=$_GET["mode"];
  $table=$_GET["table"];
  $col="bn_num";
  $num=$_GET["num"];
  $page=$_GET["page"];
  $test=$_GET["test"];

  if(!$userid){
    echo("
    <script>
    window.alert('로그인을 하십시요');
    location.href='../member/login.php';
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

	$total_image_name=$row[bn_file_name_0];
    $item_file=explode(",", $total_image_name);
    $file_cnt=count($item_file);
    //$item_file_1=$row[bn_file_name_1];
    //$item_file_2=$row[bn_file_name_2];
    
	$total_image_copied=$row[bn_file_copied_0];
    $copied_file=explode(",", $total_image_copied);
    //$copied_file_1=$row[bn_file_copied_1];
    //$copied_file_2=$row[bn_file_copied_2];
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
  <script>
	//파일 추가 버튼
	function file_add(){
		
		var parent = document.getElementById("table");
		var node_length = parent.children.length;//왜 1부터지?
		if(node_length > 4) {
			alert("이미지는 5개 이하로 등록 하여야 합니다.");
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
	<?php if($mode=="modify") { ?>
	<form name="board_form" method="post" action="insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>&mypage=<?=$mypage?>&test=<?=$test?>" enctype="multipart/form-data">
	<?php } else { ?>
	<form name="board_form" method="post" action="insert.php?table=<?=$table?>" enctype="multipart/form-data">
	<?php } ?>
		
		<table  id="table">
			<!--<caption>공지사항 등록하기</caption>-->
			<tr>
				<th>작성자</th>
				<td><?echo"$username($userid)"?>&nbsp;|&nbsp;<input type="checkbox" name="html_ok" value="y">HTML 쓰기</input></td>
			</tr>
			<tr>
				<th>제목</th>
				<td><input class="subject" type="text" name="subject" value="<?=$item_subject?>"></input></td>
			</tr>
			<tr>
				<th>내용</th>
				<td><textarea class="content" rows="15" cols="80" name="content"><?=$item_content?></textarea></td>
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

		<!--	<tr>
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
-->
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
			<input type="reset" value="다시쓰기" />
			<input type="button" value="목록보기" onclick="location.href='list.php?page=<?=$page?>'" />
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


<?require_once("./board_n_f.php");?>