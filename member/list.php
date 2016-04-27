<?require_once("./list_h.php");?>

<?php
$searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
$searchText=$_GET["searchText"]; // 페이징 searchText
$scale=10;//한페이지 글 갯수 정의

$search=$_GET["search"];
if(!$search){$search="desc";}
$test=$_GET["test"];
if(!$test){$test="total";}
if($test=="board_f"){$orderby="bf_reg_date";$id="id";}elseif($test=="board_g"){$orderby="bg_regist_day";$id="bg_id";}elseif($test=="board_qna"){$orderby="bq_regist_day";$id="bq_id";}elseif($test=="board_rv"){$orderby="br_reg_date";$id="id";}elseif($test=="total"){$id="bn_id";}elseif($test=="board_n"){$orderby="bn_regist_day";$id="bn_id";}

require_once("../lib/my_paging.php"); // 페이징 PHP 호출
 
if($test=="total"){$result=mysql_query($sql_p2, $connect);}
else{$result=mysql_query($sql_p, $connect);}
$total_record=mysql_num_rows($result);

if(!$page or $page<1){
$page=1;
}

$start=($page-1)*$scale;
$number=$total_record-$start;

if($page < 1 || $page > $allPage) {
?>
<div class="mypage_list_con"><p>

	<form class="mypage_list_form" action="./list.php" method="GET">
	<select name="search">
	<option <?php echo $search=='desc'?'selected="selected"':null?> value="desc">최신글</option>
	<option <?php echo $search=='asc'?'selected="selected"':null?> value="asc">등록일</option>
	</select>
	<select name="test">
			<?if($userlevel==10){$arr_tsize=array("total"=>"전체보기","board_n"=>"공지사항","board_f"=>"자유게시판","board_g"=>"갤러리","board_qna"=>"Q&A","board_rv"=>"대회후기");}else{$arr_tsize=array("total"=>"전체보기","board_f"=>"자유게시판","board_g"=>"갤러리","board_qna"=>"Q&A","board_rv"=>"대회후기");}?>
			<?foreach($arr_tsize as $key=>$val){$selected=$test==$key ? " selected":"";?><option value="<?=$key?>"<?=$selected?>><?=$val?></option><?}?>
	</select>
	<button type="submit">검색</button>
	</form>
	</div>

<? 
	echo "<table class='member_list_table'><tr><th class='th0'>번호</th><th class='th1'>카테고리</th><th class='th2'>제목</th><th class='th3'>등록날짜</th><th class='th4'>조회수</th><th class='m_d'>삭제</th></tr><tr><td colspan='6'>게시글이 존재하지 않습니다.</td></tr></table>";	
}else{
?>
	<div class="mypage_list_con"><p>
	<?if($test=='board_f'){echo "자유게시판";}elseif($test=='board_g'){echo "갤러리";}elseif($test=='board_qna'){echo "Q&A";}elseif($test=='board_rv'){echo "대회후기";}elseif($test=='board_n'){echo "공지사항";}else{echo "전체";}?>에서 총 <?=$total_record?>개의 게시글이 있습니다.</p>
	<form class="mypage_list_form" action="./list.php" method="GET">
	<select name="search">
	<option <?php echo $search=='desc'?'selected="selected"':null?> value="desc">최신글</option>
	<option <?php echo $search=='asc'?'selected="selected"':null?> value="asc">등록일</option>
	</select>
	<select name="test">
			<?if($userlevel==10){$arr_tsize=array("total"=>"전체보기","board_n"=>"공지사항","board_f"=>"자유게시판","board_g"=>"갤러리","board_qna"=>"Q&A","board_rv"=>"대회후기");}else{$arr_tsize=array("total"=>"전체보기","board_f"=>"자유게시판","board_g"=>"갤러리","board_qna"=>"Q&A","board_rv"=>"대회후기");}?>
			<?foreach($arr_tsize as $key=>$val){$selected=$test==$key ? " selected":"";?><option value="<?=$key?>"<?=$selected?>><?=$val?></option><?}?>
	</select>
	<button type="submit">검색</button>
	</form>
	</div>

	<? if(empty($allPost_p)){echo "게시글이 없습니다.";}else{
	echo "<table class='member_list_table'><tr><th class='th0'>번호</th><th class='th1'>카테고리</th><th class='th2'>제목</th><th class='th3'>등록날짜</th><th class='th4'>조회수</th><th class='m_d'>삭제</th></tr>";


		for($i=$start; $i<$start+$scale && $i<$total_record; $i++){
		mysql_data_seek($result,$i);
		$row = mysql_fetch_assoc($result);
		if($test=="board_n"){$title=str_replace(" ", "&nbsp;", $row[bn_subject]);$date=$row[bn_regist_day];$hit=$row[bn_hit];$num_n='bn_num';$num=$row[bn_num];$category='공지사항';}
		if($test=="board_f"){$title=str_replace(" ", "&nbsp;", $row[bf_title]);$date=$row[bf_reg_date];$hit=$row[bf_hit];$num_n='bf_num';$num=$row[bf_num];$category='자유게시판';}
		elseif($test=="board_g"){$title=str_replace(" ", "&nbsp;", $row[bg_subject]);$date=$row[bg_regist_day];$hit=$row[bg_hit];$num_n='bg_num';$num=$row[bg_num];$category='갤러리';}
		elseif($test=="board_qna"){$title=str_replace(" ", "&nbsp;", $row[bq_subject]);$date=$row[bq_regist_day];$hit=$row[bq_hit];$num_n='bq_num';$num=$row[bq_num];$category='Q&A';}
		elseif($test=="board_rv"){$title=str_replace(" ", "&nbsp;", $row[br_title]);$date=$row[br_reg_date];$hit=$row[br_hit];$num_n='br_num';$num=$row[br_num];$category='대회후기';}
		elseif($test=="total"){$title=str_replace(" ", "&nbsp;", $row[title]);$date=$row[regist];$hit=$row[hit];$num=$row[num];
			if($row[category]=='board_f'){$category='자유게시판';$num_n='bf_num';}elseif($row[category]=="board_n"){$category='공지사항';$num_n='bn_num';}elseif($row[category]=="board_g"){$category='갤러리';$num_n='bg_num';}elseif($row[category]=="board_qna"){$category='Q&A';$num_n='bq_num';}elseif($row[category]=="board_rv"){$category='대회후기';$num_n='br_num';}
			}
		$title=substr($title,0,150);/*100으로 하면 이상한글자 나옴*/
		$date=date("Y-m-d (H:i)",strtotime($date));
		
		?>
		<tr><td><?= $number ?></td><td><?= $category ?></td><td class="left"><a href="../<? if($test=='total'){echo $row[category];}else{echo $test;}?>/view.php?table=<? if($test=='total'){echo $row[category];}else{echo $test;}?>&<?=$num_n?>=<?=$num?>&mypage=1&page=<?=$page?>&test=<?=$test?>"><?= $title ?></a></td><td><?= $date ?></td><td><?= $hit ?></td><td><a href="../<? if($test=='total'){echo $row[category]."/delete.php?table=".$row[category];}else{echo $test."/delete.php?table=".$test;}?>&<?=$num_n?>=<?=$num?>&mypage=1&page=<?=$page?>" onclick="return confirm('삭제 하시겠습니까?');"><input type="button" value="삭제" class="su_btn" /></a></td></tr>
		
		<?  $number--;}
#if($test=="total"){if()}else{echo $test;}
	}
	?>
	</table>
	<?

	if(!$_GET["page"])
	$pages=1;
	else
	$pages=$_GET["page"];
	?>

	<div id="boardList"><!-- paging search -->
	<div class="paging">
	<?php echo "<br>".$paging."<br>" ?>
	</div></div>
	<div class="searchBox"> <!-- 게시판별 컬럼명 맞춰야함 -->
	<form action="./list.php" method="GET">
	<input type="hidden" value="<?=$test?>" name="test">
	<input type="hidden" value="<?=$search?>" name="search">
	<select name="searchColumn">
	<option <?php echo $searchColumn=='bn_subject'||'bf_title'||'bg_title'||'bq_subject'||'br_title'||'title'?'selected="selected"':null;?> value="<?if($test=='board_f'){echo 'bf_title';}elseif($test=='board_n'){echo 'bn_subject';}elseif($test=='board_g'){echo 'bg_subject';}elseif($test=='board_qna'){echo 'bq_subject';}elseif($test=="board_rv"){echo 'br_title';}elseif($test=="total"){echo 'title';}?>">제목</option>
	</select>

	<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
	<button type="submit">검색</button>
	</form>

	</div><!-- div_searchBox -->
	</div><!-- member_list_center_searchBox -->

	

<?php
mysql_close();?>

<?
}
require_once("./mypage_f.php");
?>