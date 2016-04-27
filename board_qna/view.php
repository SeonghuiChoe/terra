<?php
  require_once("./board_qna_h.php");//메인소스 윗부분

  $table=$_GET["table"];
  $num=$_GET["num"];
  if($_GET["bq_num"]){
	$num = $_GET["bq_num"];
  }  
  $page=$_GET["page"];
  $userid=$_SESSION["userid"];
  $userlevel=$_SESSION["userlevel"];
  $mypage=$_GET["mypage"];
  $test=$_GET["test"];

  
  if(!$num){
    echo("<script>history.go(-1);</script>");
    exit;
  }

  include "../lib/dbconn.php";

  $sql="select * from $table where bq_num=$num";
  $result=mysql_query($sql, $connect);
  $row=mysql_fetch_array($result);

  $item_num=$row[bq_num];
  $item_id=$row[bq_id];
  $item_name=$row[bq_name];
  $item_nick=$row[bq_nick];
  $item_hit=$row[bq_hit];
  $item_date=$row[bq_regist_day];
  $item_date=date("Y-m-d (H:i)",strtotime($item_date));
  $item_subject=str_replace(" ","&nbsp;", $row[bq_subject]);
  $item_content=$row[bq_content];
  $is_html=$row[bq_is_html];
  $item_depth=$row[bq_depth];

  if($is_html!="y"){
    $item_content=str_replace(" ","&nbsp;",$item_content);
    $item_content=str_replace("\n","<br>",$item_content);
  }

  $new_hit=$item_hit+1;
  $sql="update $table set bq_hit=$new_hit where bq_num=$num";
  mysql_query($sql, $connect);
?>
  <script>
  function del(href){
    if(confirm("정말 삭제하시겠습니까?")){
      document.location.href=href;
    }
  }
  </script>
  <div class="view_form">
	<table>
		<tr>
			<th><?=$item_subject?></th>
		</tr>
		<tr>
			<td>
			<?echo"$item_name($item_id)"?>&nbsp;&nbsp;|&nbsp;&nbsp;조회수 : <?=$item_hit?>&nbsp;&nbsp;|&nbsp;&nbsp;<?=$item_date?>
			</td>
		</tr>
		<tr>
			<td>
			<?=$item_content?>
			</td>
		</tr>
	</table>
  </div>
 
        <div id="button">
          <a href="list.php?page=<?=$page?>">목록보기</a>
          <?php
            if($userid==$item_id or $userlevel==10)
            {
          ?>
          <a href="write_form.php?table=<?=$table?>&mode=modify&num=<?=$num?>&page=<?=$page?>&mypage=<?=$mypage?>&test=<?=$test?>">수정하기</a>
          <a href="javascript:del('delete.php?table=<?=$table?>&num=<?=$num?>&page=<?=$page?>&mypage=<?=$mypage?>&test=<?=$test?>')">삭제하기</a>
		  <?php
			}
            if($userid!=$item_id && $userlevel==10)
            {
				if($userid)
				{
					if($item_depth<2){ //답글 2개까지만 제한
          ?>
		  
						 <a href="write_form.php?table=<?=$table?>&mode=response&num=<?=$num?>&page=<?=$page?>">답변하기</a>
					<?}?>
          <?
				}
			
			}
          ?>
        </div>
  
  <?require_once("./board_qna_f.php");//메인소스 아래부분?>