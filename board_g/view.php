<?php
  require_once("./board_g_h.php");

  include "../lib/dbconn.php";

  $table=$_GET["table"];
  $num=$_GET["num"];
  if($_GET["bg_num"]){$num=$_GET["bg_num"];}
  $page=$_GET["page"];
  $userid=$_SESSION["userid"];
  $userlevel=$_SESSION["userlevel"];
  $upload_dir="../data/";
  $ripple="bg_memo";
  $mypage=$_GET["mypage"];  
  $test=$_GET["test"];  

  if(!$num){
    echo("<script>history.go(-1);</script>");exit;
	}

  $sql="select * from $table where bg_num=$num";
  $result=mysql_query($sql, $connect);
  $row=mysql_fetch_array($result);

  $item_num=$row[bg_num];
  $item_id=$row[bg_id];
  $item_name=$row[bg_name];
  $item_nick=$row[bg_nick];
  $item_hit=$row[bg_hit];

  $total_image_name=$row[bg_file_name_0];
  $image_name=explode(",", $total_image_name);
  $file_cnt=count($image_name);
  //$image_name[1]=$row[bg_file_name_1];
  //$image_name[2]=$row[bg_file_name_2];

  $total_image_copied=$row[bg_file_copied_0];
  $image_copied=explode(",", $total_image_copied);

  //$image_copied[1]=$row[bg_file_copied_1];
  //$image_copied[2]=$row[bg_file_copied_2];

  $item_date=$row[bg_regist_day];
  $item_date=date("Y-m-d (H:i)",strtotime($item_date));
  $item_subject=str_replace(" ","&nbsp;", $row[bg_subject]);
  $item_content=$row[bg_content];
  $is_html=$row[bg_is_html];

  if($is_html!="y"){
    $item_content=str_replace(" ","&nbsp;",$item_content);
    $item_content=str_replace("\n","<br>",$item_content);
  }

  for($i=0; $i<$file_cnt; $i++){
    if($image_copied[$i]){
	  $imageinfo=GetImageSize($upload_dir.$image_copied[$i]);// 배열로 크기와 형식을 반환      
      $image_width[$i]=$imageinfo[0];
      $image_height[$i]=$imageinfo[1];
      $image_type[$i]=$imageinfo[2];
      
      if($image_width[$i]>790){
        $image_width[$i]=790;
      }
     }else{
       $image_width[$i]="";
       $image_height[$i]="";
       $image_type[$i]="";
     }
  }   

  $new_hit=$item_hit+1;
  $sql="update $table set bg_hit=$new_hit where bg_num=$num";
  mysql_query($sql, $connect);
?>
  <script>
  function check_input(){
    if(!document.ripple_form.ripple_content.value){
      alert("덧글 내용이 누락되었습니다");
      document.ripple_form.ripple_content.focus();
      return;
    }
    document.ripple_form.submit();
  }
  function del(href){
    if(confirm("삭제하겠습니까?")){
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
		<?php
            for($i=0; $i<$file_cnt; $i++){
              if($image_copied[$i]){
                $img_name=$image_copied[$i];
                $img_name=$upload_dir.$img_name;
                $img_width=$image_width[$i];
                
                echo "<img src='$img_name' width='$img_width'>"."<br><br>";
              }
            }
          ?>
          <?=$item_content?>
		</td>
	</tr>
</table><br><br>
      <!-- 리플 복붙 시작 -->
<div id="ripple">
          <div id="ripple2">
            <?php
              $sql="select * from $ripple where bgm_parent='$item_num'";
              $ripple_result=mysql_query($sql);
        
              while($row_ripple=mysql_fetch_array($ripple_result)){
                $ripple_num=$row_ripple[bgm_num];
                $ripple_id=$row_ripple[bgm_id];
				$ripple_name=$row_ripple[bgm_name];
                $ripple_nick=$row_ripple[bgm_nick];
                $ripple_content=str_replace("n", "<br>", $row_ripple[bgm_content]);
                $ripple_content=str_replace(" ", "&nbsp;", $ripple_content);
                $ripple_date=$row_ripple[bgm_regist_day];
            ?>
            <div id="ripple_title">
              <ul>
              <li><?echo"$ripple_name($ripple_id)"?> &nbsp;|&nbsp; <?=$ripple_date ?></li>
              <li id="ripple_del">
                <?php
                  if($userlevel==10 || $userid==$ripple_id){ ?>
                    <a href="javascript:del('delete_ripple.php?table=<?=$table?>&num=<?=$item_num?>&ripple_num=<?=$ripple_num?>&page=<?=$page?>')">[덧글 삭제]</a>
					<?}?>
  
  			 
              </li>
              </ul>
            </div>
            <div id="ripple_content"><?=$ripple_content?></div>
            <?
              }// while end
              mysql_close();
            ?>
			<div id="ripple_form">
				<form name="ripple_form" method="post" action="insert_ripple.php?table=<?=$table?>&ripple=<?=$ripple?>&num=<?=$item_num?>&page=<?=$page?>">
					<div id="ripple_insert">
						<div id="ripple_textarea" class="text">
							<textarea id="ripple_content" name="ripple_content"></textarea><span id="remaining">(<span id="count">0</span>/<span id="max">300</span>)</span>
						</div>
						<div id="ripple_button">
							<a href="javascript:check_input()">덧글 쓰기</a>
						</div>
					</div><!-- ripple_insert end -->
				</form>
			</div>
  	</div> <!-- ripple2 end -->
</div>
<br/>
      <!-- 리플 복붙 끝 -->
        <div id="button">
          <a href="list.php?table=<?=$table?>&page=<?=$page?>">목록보기</a>
          <?php
            if($userid==$item_id or $userlevel==10)
            {
          ?>
          <a href="write_form.php?table=<?=$table?>&mode=modify&num=<?=$num?>&page=<?=$page?>&mypage=<?=$mypage?>&test=<?=$test?>">수정하기</a>
          <a href="javascript:del('delete.php?table=<?=$table?>&num=<?=$num?>&page=<?=$page?>&mypage=<?=$mypage?>&test=<?=$test?>')">삭제하기</a>
          <?php
            }
            if($userid)
            {
          ?>
          <!--<a href="write_form.php?table=<?=$table?>">글쓰기</a>-->
          <?php
            }
          ?>
        </div><br><br>

<?require_once("./board_g_f.php");//메인소스 윗부분?>