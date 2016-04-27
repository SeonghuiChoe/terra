<?php
  require_once("./board_g_h.php");//메인소스 윗부분

  $table="board_g"; //각 게시판 테이블명
  $col="bg_num"; //각 게시판 인덱스 넘버
  $ripple="bg_memo"; // 댓글 테이블명 
  $mode=$_GET["mode"];
  $searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
  $searchText=$_GET["searchText"]; // 페이징 searchText
  $scale=9;//한페이지 글 갯수 정의
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
  <div id="sub_wraper">
  
    <div id="sub_content">
      <div id="col1">
      </div>
      <div id="col2">
          <div class="clear"></div>
          <div id="list_content">
		  <div id="pic">
		  <table>
			<tr>
          <?php
			if(empty($allPost_p)) 
				echo $emptyData;
			$a=0;
            for($i=$start; $i<$start+$scale && $i<$total_record; $i++)
            {
              mysql_data_seek($result, $i);// 가져올 레코드 위치(포인터)로 이동, for문에서 요긴하게 사용됨
              $row=mysql_fetch_array($result);
			  
			  $total_image_name=$row[bg_file_name_0];		  
			  $image_name=explode(",", $total_image_name);
			  $file_cnt=count($image_name);			  
			  //$image_name[1]=$row[bg_file_name_1];
			  //$image_name[2]=$row[bg_file_name_2];
			  
		  	  $total_image_copied=$row[bg_file_copied_0];
			  $image_copied=explode(",", $total_image_copied);
			  //$image_copied[1]=$row[bg_file_copied_1];// 첫번째 이미지가 없어도 첨부 이미지 표시
			  //$image_copied[2]=$row[bg_file_copied_2];

			  for ($j=$file_cnt;$j>=0;$j--){
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
            //  $item_date=substr($item_date, 0, 10);// 문자열 자르기(문자열, 자르기 시작지점, 문자개수)
              $item_subject=str_replace(" ", "&nbsp;", $row[bg_subject]);
			//  $item_subject=substr($item_subject,0,50);
    
              $sql="select * from $ripple where bgm_parent=$item_num";
              $result2=mysql_query($sql, $connect);
              $num_ripple=mysql_num_rows($result2);
          ?>
                
				
				<td><a href="view.php?table=<?=$table?>&num=<?=$item_num?>&page=<?=$page?>">
				<?echo "<img src='$img_name' width='220'>"."<br>";?>
				<div id="itsub1"><p><?echo $item_subject?><br></p></div></a>
				<div id="itsub2">
				<?echo"
				<p>$item_name($item_id)<br></p>
				<p>조회:$item_hit 댓글:$num_ripple<br></p>
				<p>$item_date<br></p>";?></div></td>
				
				<?if(($a%3)!=0){echo"";}
				else{
				echo"</tr><tr>";
				}?>
			

				
                  
                
              </div>
            </div>
          <?php
              $number--;
            }
			?>
			</tr>
			</table>
          <?
            if(!$_GET["page"])
              $pages=1;
            else
              $pages=$_GET["page"];
          ?>
            
                         
            </div> 
			<div id="boardList">
			<div class="paging">
				<?php echo "<br>".$paging."<br>" ?>
			</div></div>
			<div class="searchBox"> <!-- 게시판별 컬럼명 맞춰야함 -->
				<form action="./list.php" method="GET">
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
                if($userid){
              ?>
              <a href="write_form.php?table=<?=$table?>&page=<?=$page?>">글쓰기</a>
              <?php
                }
              ?>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div><br><br><br>
  <?require_once("./board_g_f.php");?>