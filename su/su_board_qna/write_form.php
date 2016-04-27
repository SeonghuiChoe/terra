<?php
  require_once("./board_qna_su_h.php");//메인소스 윗부분
  $usernick=$_SESSION["usernick"];
  $username=$_SESSION["username"];
  $mode=$_GET["mode"];
  $table=$_GET["table"];
  $col="bq_num";
  $num=$_GET["num"];
  $page=$_GET["page"];

  if($mode=="modify" || $mode=="response"){
    include _BASE_DIR."/common.php";
    
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
<div class="write_form">
  
          
          <?php
            if($mode=="modify")
            {
          ?>
          <form name="board_form" method="post" action="insert.php?mode=modify&num=<?=$num?>&page=<?=$page?>&table=<?=$table?>">
          
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
			
		</table>
           
            <div id="button">
              <input type="submit" value="글올리기">
			  <input type="button" value="목록보기" onclick="location.href='list.php?page=<?=$page?>'" />
            </div>
          </form>
        </div>
    
  <?require_once("./board_qna_su_f.php");?>