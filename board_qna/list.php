<?php
  require_once("./board_qna_h.php");//메인소스 윗부분
  include "../lib/dbconn.php";
  $table="board_qna";
  $col="bq_num";
  $mode=$_GET["mode"];
  $searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
  $searchText=$_GET["searchText"]; // 페이징 searchText
  $scale=10;//한페이지 글 갯수 정의
  require_once("../lib/paging.php"); // 페이징 PHP 호출
  $sql_p="select * from $table" . $searchSql." order by bq_group_num desc, bq_ord asc";
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

              $item_num=$row[bq_num];
              $item_id=$row[bq_id];
              $item_name=$row[bq_name];
              $item_nick=$row[bq_nick];
              $item_hit=$row[bq_hit];
              $item_date=$row[bq_regist_day];
			  $item_date=date("Y-m-d (H:i)",strtotime($item_date));
        //    $item_date=substr($item_date, 0, 10);// 문자열 자르기(문자열, 자르기 시작지점, 문자개수)
              $item_subject=str_replace(" ", "&nbsp;", $row[bq_subject]);
		//	  $item_subject=substr($item_subject,0,100);
              $item_depth=$row[bq_depth];
    
              $space="";
              for($j=0; $j<$item_depth; $j++){
                $space="&nbsp;&nbsp;".$space;
              }
			  if ($j!=0)
				  $space.="<span class='red' style='color:red;'>┗[답변]</span>";
			  //┗(Re)답글 표시
          ?>
			<tr>
				<td><?=$number?></td>
				<td class="subject"><?=$space?>
                <a href="view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>">
                <? if($item_subject){echo $item_subject;}else{echo "제목없음";}?>
                </a></td>
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
						<option <?php echo $searchColumn=='bq_subject'?'selected="selected"':null?> value="bq_subject">제목</option>
						<option <?php echo $searchColumn=='bq_content'?'selected="selected"':null?> value="bq_content">내용</option>
						<option <?php echo $searchColumn=='bq_name'?'selected="selected"':null?> value="bq_name">작성자</option>
						<option <?php echo $searchColumn=='bq_id'?'selected="selected"':null?> value="bq_id">아이디</option>
					</select>
					<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
					<button type="submit">검색</button>
				</form>
			</div>
			</div>

            <div id="button">
              
              <?php
                if($userid){
              ?>
              <a href="write_form.php?table=<?=$table?>&page=<?=$page?>">글쓰기</a>
              <?php
                }
              ?>
            </div>
          


<?require_once("./board_qna_f.php");//메인소스 윗부분?>