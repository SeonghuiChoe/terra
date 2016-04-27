<?php
  require_once("./board_n_h.php");//메인소스 윗부분

  $table="board_n"; //각 게시판 테이블명
  $col="bn_num"; //각 게시판 인덱스 넘버
  $mode=$_GET["mode"];
  $searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
  $searchText=$_GET["searchText"]; // 페이징 searchText
  $scale=10;//한페이지 글 갯수 정의
  require_once("../lib/paging.php"); // 페이징 PHP 호출

  $upload_dir="../data/"; //이미지 저장경로

  $result=mysql_query($sql_p, $connect);
  $total_record=mysql_num_rows($result);


  if(!$page or $page<1){
    $page=1;
  }

  $start=($page-1)*$scale;
  $number=$total_record-$start;

?>

<div class="list_form">
	<table>
		<tr><th>번호</th><th>제목</th><th>작성자</th><th>등록일</th><th>조회수</th></tr>
		<?php
		if(empty($allPost_p)) 
		echo $emptyData;
		for($i=$start; $i<$start+$scale && $i<$total_record; $i++)
		{
		mysql_data_seek($result, $i);// 가져올 레코드 위치(포인터)로 이동, for문에서 요긴하게 사용됨
		$row=mysql_fetch_array($result);
		$image_name[0]=$row[bn_file_name_0];
		$image_name[1]=$row[bn_file_name_1];
		$image_name[2]=$row[bn_file_name_2];
		$image_copied[0]=$row[bn_file_copied_0];
		$image_copied[1]=$row[bn_file_copied_1];// 첫번째 이미지가 없어도 첨부 이미지 표시
		$image_copied[2]=$row[bn_file_copied_2];

		for ($j=3;$j>=0;$j--){
			if($image_name[$j]!=""){
			$img_name=$image_copied[$j];
			$img_name=$upload_dir.$img_name;		
			}
		}
		$item_num=$row[bn_num];
		$item_id=$row[bn_id];
		$item_name=$row[bn_name];
		$item_nick=$row[bn_nick];
		$item_hit=$row[bn_hit];
		$item_date=$row[bn_regist_day];
		$item_date=date("Y-m-d (H:i)",strtotime($item_date));
		//  $item_date=substr($item_date, 0, 10);// 문자열 자르기(문자열, 자르기 시작지점, 문자개수)
		$item_subject=str_replace(" ", "&nbsp;", $row[bn_subject]);    

		?>
		<tr>
			<td><?=$number?></td>
			<td class="subject"><?=$space?>
			<a href="view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>">
			<? if($item_subject){echo $item_subject;}else{echo "제목없음";}?>
			<?if($image_copied[0]||$image_copied[1]||$image_copied[2]){echo "<img src='../images/img.png' align='center'>";}?></a></td>
			<td><?echo"$item_name($item_id)"?></td>
			<td><?=$item_date ?></td>
			<td><?=$item_hit ?></td>
		</tr>
		<?php
			$number--;
		}
		if(!$_GET["page"])
		$pages=1;
		else
		$pages=$_GET["page"];
		?>
	</table>
</div>

<div id="boardList">
<div class="paging">
	<?php echo "<br>".$paging."<br>" ?>
</div>
<div class="searchBox"> <!-- 게시판별 컬럼명 맞춰야함 -->
	<form action="./list.php" method="GET">
		<select name="searchColumn">
		<option <?php echo $searchColumn=='bn_subject'?'selected="selected"':null?> value="bn_subject">제목</option>
		<option <?php echo $searchColumn=='bn_content'?'selected="selected"':null?> value="bn_content">내용</option>
		<option <?php echo $searchColumn=='bn_name'?'selected="selected"':null?> value="bn_name">작성자</option>
		<option <?php echo $searchColumn=='bn_id'?'selected="selected"':null?> value="bn_id">아이디</option>
		</select>
		<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
		<button type="submit">검색</button>
	</form>
</div>
</div>

<div id="button">
	<?php
	if($userlevel==10){
	?>
	<a href="write_form.php?table=<?=$table?>&page=<?=$page?>">글쓰기</a>
	<?php
	}
	?>
</div>


<?require_once("./board_n_f.php");//메인소스 윗부분?>