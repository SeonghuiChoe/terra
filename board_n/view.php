<?php
  require_once("./board_n_h.php");//메인소스 윗부분

  $table=$_GET["table"];
  $num=$_GET["num"];
  $page=$_GET["page"];
  $userid=$_SESSION["userid"];
  $userlevel=$_SESSION["userlevel"];
  $upload_dir="../data/";
  $mypage=$_GET["mypage"];
  $test=$_GET["test"];


  if(!$num){
    echo("<script>history.go(-1);</script>");
    exit;
  }


  $sql="select * from $table where bn_num=$num";
  $result=mysql_query($sql, $connect);
  $row=mysql_fetch_array($result);

  $item_num=$row[bn_num];
  $item_id=$row[bn_id];
  $item_name=$row[bn_name];
  $item_nick=$row[bn_nick];
  $item_hit=$row[bn_hit];

  $total_image_name=$row[bn_file_name_0];
  $image_name=explode(",", $total_image_name);
  $file_cnt=count($image_name);
  //$image_name[1]=$row[bg_file_name_1];
  //$image_name[2]=$row[bg_file_name_2];

  $total_image_copied=$row[bn_file_copied_0];
  $image_copied=explode(",", $total_image_copied);

  //$image_copied[1]=$row[bg_file_copied_1];
  //$image_copied[2]=$row[bg_file_copied_2];

  $item_date=$row[bn_regist_day];
  $item_date=date("Y-m-d (H:i)",strtotime($item_date));
  $item_subject=str_replace(" ","&nbsp;", $row[bn_subject]);
  $item_content=$row[bn_content];
  $is_html=$row[bn_is_html];

  if($is_html!="y"){
    $item_content=str_replace(" ","&nbsp;",$item_content);
    $item_content=str_replace("\n","<br>",$item_content);
  }

  for($i=0; $i<3; $i++){
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
  $sql="update $table set bn_hit=$new_hit where bn_num=$num";
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
</table>
</div>

<div id="button">
	<a href="list.php?table=<?=$table?>&page=<?=$page?>">목록보기</a>
	<?php
	if($userlevel==10)
	{
	?>
	<a href="write_form.php?table=<?=$table?>&mode=modify&num=<?=$num?>&page=<?=$page?>&mypage=<?=$mypage?>&test=<?=$test?>">수정하기</a>
	<a href="javascript:del('delete.php?table=<?=$table?>&num=<?=$num?>&page=<?=$page?>&mypage=<?=$mypage?>&test=<?=$test?>')">삭제하기</a>
	<?php
	}
	?>
</div>



<?require_once("./board_n_f.php");//메인소스 윗부분?>