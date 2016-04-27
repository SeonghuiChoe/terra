<?php
  require_once("./board_qna_h.php");//메인소스 윗부분
  
  $mode=$_GET["mode"];
  $table=$_GET["table"];
  $col="bq_num";
  $num=$_GET["num"];
  $page=$_GET["page"];
  $mypage=$_GET["mypage"];
  $test=$_GET["test"];
   
    if(!$userid){
    echo("<script>window.alert('로그인을 하십시요');location.href='../member/login.php';</script>");
    exit;
  }

  if($mode=="modify" || $mode=="response"){
    include "../lib/dbconn.php";
    
    $sql="select * from $table where $col=$num";
    $result=mysql_query($sql, $connect);
    $row=mysql_fetch_array($result);
    
    $item_subject=$row[bq_subject];
    $item_content=$row[bq_content];
    
    if($mode=="response"){
      $item_subject="".$item_subject;
      $item_content=">".$item_content;
      $item_content=str_replace("\n","\n>",$item_content);
      $item_content="\n\n".$item_content;
    }
    mysql_close();
  }
?>
<script>
function check_input() {
	if(!document.board_form.subject.value) {
		alert("제목을 입력하세요");
		document.board_form.subject.focus();
		return;
	}
	if(!document.board_form.content.value) {
		alert("내용을 입력하세요");
		document.board_form.content.focus();
		return;
	}
	document.board_form.submit();
}
</script>
<div class="write_form">
  
          <?php
            if($mode=="modify")
            {
          ?>
          <form name="board_form" method="post" action="insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>&mypage=<?=$mypage?>&test=<?=$test?>">
          
          <?php
            }else if($mode=="response")
            {
          ?>
          <form name="board_form" method="post" action="insert.php?mode=response&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>">
          <?php
            }else{
          ?>
          <form name="board_form" method="post" action="insert.php?table=<?=$table?>&page=<?=$page?>">
          <?php
            }
          ?>
		  <table>
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
              <input type="button" value="목록보기" onclick="location.href='list.php?page=<?=$page?>'" />
            </div>
          </form>
        </div>
    
  <?require_once("./board_qna_f.php");?>