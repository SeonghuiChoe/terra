<?php
  require_once("./board_g_su_h.php");//메인소스 윗부분
  include _BASE_DIR."/common.php";

  $table="board_g"; //각 게시판 테이블명
  $col="bg_num"; //각 게시판 인덱스 넘버
  $ripple="bg_memo"; // 댓글 테이블명 
  $mode=$_GET["mode"];
  $searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
  $searchText=$_GET["searchText"]; // 페이징 searchText
  $scale=10;//한페이지 글 갯수 정의
  require_once("../lib/paging.php"); // 페이징 PHP 호출

  $upload_dir=_BASE_DIR."/data/"; //이미지 저장경로

  $result=mysql_query($sql_p, $connect);
  $total_record=mysql_num_rows($result);


  if(!$page or $page<1){
    $page=1;
  }

  $start=($page-1)*$scale;
  $number=$total_record-$start;

?>
<script>
function checkAll()
{
 var fForm = window.document.delete_form;
 if (fForm.chkAll.checked)
 {
  for (var i=0;i<fForm.list.length;i++)
  {
   fForm.list[i].checked = true;
  }
 }
 else
 {
  for (var i=0;i<fForm.list.length;i++)
  {
   fForm.list[i].checked = false;
  }
 }
}
function onCheckBoxClick()
{
 var fForm = window.document.delete_form;
 var nChecked = 0;
 for (var i=0;i<fForm.list.length;i++)
 {
  if (fForm.list[i].checked)
  {
   nChecked++;
  }
 }
 if (nChecked == fForm.list.length)
 {
  fForm.chkAll.checked = true;
 }
 else
 {
  fForm.chkAll.checked = false;
 }
}
function del(href){
	 var fForm = window.document.delete_form;
	 var nChecked = 0;
	 var values = "&list=";
	 for (var i=0;i<fForm.list.length;i++)
	 {
	  if (fForm.list[i].checked)
	  {
	   nChecked++;
	   values += fForm.list[i].value+"_";
	  }
	 }
	values += "&mode=deleteAll";
	
	if(nChecked <= 0){
		alert("삭제하실 게시글을 선택해주세요.");
	}else{
		if(confirm("정말 삭제하시겠습니까?")){
			document.location.href=href+values;
			}
	}	
}
</script>
<div class="list_form">
	<table><form name="delete_form" action="./list.php" method="GET">
		<tr><th><input type="checkbox" name="chkAll" onclick="javascript:checkAll();"></th><th>번호</th><th>제목</th><th>작성자</th><th>등록일</th><th>조회수</th></tr>
			<?php
			if(empty($allPost_p)) 
				echo $emptyData;
			$a=0;
            for($i=$start; $i<$start+$scale && $i<$total_record; $i++)
            {
              mysql_data_seek($result, $i);// 가져올 레코드 위치(포인터)로 이동, for문에서 요긴하게 사용됨
              $row=mysql_fetch_array($result);
			  $image_name[0]=$row[bg_file_name_0];
			  $image_name[1]=$row[bg_file_name_1];
			  $image_name[2]=$row[bg_file_name_2];
		  	  $image_copied[0]=$row[bg_file_copied_0];
			  $image_copied[1]=$row[bg_file_copied_1];// 첫번째 이미지가 없어도 첨부 이미지 표시
			  $image_copied[2]=$row[bg_file_copied_2];

			  for ($j=3;$j>=0;$j--){
				  if($image_name[$j]!=""){
		  			  $img_name=$image_copied[$j];
					  $img_name=$upload_dir.$img_name;		
				  }
			  }

			  $a++;


              $item_num=$row[bg_num];
              $item_id=$row[bg_id];
              $item_name=$row[bg_name];
              $item_nick=$row[bg_nick];
              $item_hit=$row[bg_hit];
              $item_date=$row[bg_regist_day];
			  $item_date = date("Y-m-d (H:i)",strtotime($item_date));
            //  $item_date=substr($item_date, 0, 10);// 문자열 자르기(문자열, 자르기 시작지점, 문자개수)
              $item_subject=str_replace(" ", "&nbsp;", $row[bg_subject]);
			//  $item_subject=substr($item_subject,0,50);
    
              $sql="select * from $ripple where bgm_parent=$item_num";
              $result2=mysql_query($sql, $connect);
              $num_ripple=mysql_num_rows($result2);
          ?>
            <tr>
			<td><input type="checkbox" name="list" id="list" value="<?=$item_num?>" onclick="javascript:onCheckBoxClick();"></td> <!-- 체크 들어갈 영역 -->
			<td><?=$number?></td>
			<td class="subject"><?=$space?>
			<a href="view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>">
			<? if($item_subject){echo $item_subject;}if($num_ripple){echo"[$num_ripple]";}?>
			</a></td>
			<td><?echo"$item_name($item_id)"?></td>			
			<td id="date"><?=$item_date ?></td>
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
			</div></div>
			<div class="searchBox"> <!-- 게시판별 컬럼명 맞춰야함 -->
				
					<select name="searchColumn">
						<option <?php echo $searchColumn=='bg_subject'?'selected="selected"':null?> value="bg_subject">제목</option>
						<option <?php echo $searchColumn=='bg_content'?'selected="selected"':null?> value="bg_content">내용</option>
						<option <?php echo $searchColumn=='bg_name'?'selected="selected"':null?> value="bg_name">작성자</option>
						<option <?php echo $searchColumn=='bg_id'?'selected="selected"':null?> value="bg_id">아이디</option>
					</select>
					<input type="text" name="searchText" value="<?php echo isset($searchText)?$searchText:null?>">
					<button type="submit">검색</button>
				</form>
			</div>
            <div id="button">
              
              <?php
                if($userlevel==10){
              ?>
              <!--<a href="write_form.php?table=<?=$table?>&page=<?=$page?>">글쓰기</a>-->
			  <a href="javascript:del('delete.php?table=<?=$table?>&page=<?=$page?>');">삭 제</a>
			  </form>

              <?php
                }
              ?>
    
  </div>
  <?require_once("./board_g_su_f.php");?>