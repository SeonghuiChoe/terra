<?php
/* 페이징 시작 */
	//페이지 get 변수가 있다면 받아오고, 없다면 1페이지를 보여준다.
	if(isset($_GET['page'])) {
		$page = $_GET['page'];
	} else {
		$page = 1;
	}
	
	/* 검색 시작 */

	if(isset($_GET['searchColumn'])) {
		$searchColumn = $_GET['searchColumn'];
		$subString .= '&amp;searchColumn=' . $searchColumn;
	}
	if(isset($_GET['searchText'])) {
		$searchText = $_GET['searchText'];
		$subString .= '&amp;searchText=' . $searchText;
	}
	
	if(isset($searchColumn) && isset($searchText)) {
		if($test=="total"){$searchSql1 = ' and bn_subject like "%' . $searchText . '%"';$searchSql2 = ' and bf_title like "%' . $searchText . '%"';$searchSql3 = ' and bg_subject like "%' . $searchText . '%"';$searchSql4 = ' and bq_subject like "%' . $searchText . '%"';$searchSql5 = ' and br_title like "%' . $searchText . '%"';}
		else{$searchSql = ' and ' . $searchColumn . ' like "%' . $searchText . '%"';}		
	} else {
		$searchSql = '';
	}
	
	/* 검색 끝 */
	
	$sql_p="select *from $test where $id='$userid'".$searchSql." order by $orderby ".$search;

	$sql_p2 ="select bn_num AS num, bn_subject AS title, bn_regist_day AS regist, bn_hit AS hit, category from board_n where bn_id='$userid'".$searchSql1." UNION ALL ";
	$sql_p2 .="select bf_num AS num, bf_title AS title, bf_reg_date AS regist, bf_hit AS hit, category from board_f where id='$userid'".$searchSql2."  UNION ALL ";
	$sql_p2 .="select bg_num AS num, bg_subject AS title, bg_regist_day AS regist, bg_hit, category AS hit from board_g where bg_id='$userid'".$searchSql3."  UNION ALL ";
	$sql_p2 .="select bq_num AS num, bq_subject AS title, bq_regist_day AS regist, bq_hit, category AS hit from board_qna where bq_id='$userid'".$searchSql4."  UNION ALL ";
	$sql_p2 .="select br_num AS num, br_title AS title, br_reg_date AS regist, br_hit AS hit, category from board_rv where id='$userid'".$searchSql5." order by regist ".$search;
	#echo $sql_p2;
	if($test=="total"){$result_p=mysql_query($sql_p2, $connect);}	else{$result_p=mysql_query($sql_p, $connect);}
	$row_p=mysql_num_rows($result_p);
	
	$allPost_p = $row_p; //전체 게시글의 수

	$onePage = $scale; // 한 페이지에 보여줄 게시글의 수.
	$allPage = ceil($allPost_p / $onePage); //전체 페이지의 수
	
	if($page < 1 || $page > $allPage) {
		#echo "게시글이 존재하지 않습니다.";
		#exit;
	}else{

	$oneSection = 5; //한번에 보여줄 총 페이지 개수(1 ~ 10, 11 ~ 20 ...)
	$currentSection = ceil($page / $oneSection); //현재 섹션
	$allSection = ceil($allPage / $oneSection); //전체 섹션의 수
	
	$firstPage = ($currentSection * $oneSection) - ($oneSection - 1); //현재 섹션의 처음 페이지
	
	if($currentSection == $allSection) {
		$lastPage = $allPage; //현재 섹션이 마지막 섹션이라면 $allPage가 마지막 페이지가 된다.
	} else {
		$lastPage = $currentSection * $oneSection; //현재 섹션의 마지막 페이지
	}
	
	$prevPage = (($currentSection - 1) * $oneSection); //이전 페이지, 11~20일 때 이전을 누르면 10 페이지로 이동.
	$nextPage = (($currentSection + 1) * $oneSection) - ($oneSection - 1); //다음 페이지, 11~20일 때 다음을 누르면 21 페이지로 이동.
	
	$paging = "<ul>"; // 페이징을 저장할 변수
	
	//첫 페이지가 아니라면 처음 버튼을 생성
	if($page != 1) { 
		$paging .= '<li class="page page_start"><a href="./list.php?test='.$test.'&page=1'.$subString . '">처음</a></li>';
	}
	//첫 섹션이 아니라면 이전 버튼을 생성
	if($currentSection != 1) { 
		$paging .= '<li class="page page_prev"><a href="./list.php?test='.$test.'&page=' . $prevPage. $subString . '">이전</a></li>';
	}
	
	for($i = $firstPage; $i <= $lastPage; $i++) {
		if($i == $page) {
			$paging .= '<li class="page current">' . $i . '</li>';
		} else {
			$paging .= '<li class="page"><a href="./list.php?test='.$test.'&page=' . $i . $subString . '">' . $i . '</a></li>';
		}
	}
	
	//마지막 섹션이 아니라면 다음 버튼을 생성
	if($currentSection != $allSection) { 
		$paging .= '<li class="page page_next"><a href="./list.php?test='.$test.'&page=' . $nextPage . $subString . '">다음</a></li>';
	}
	
	//마지막 페이지가 아니라면 끝 버튼을 생성
	if($page != $allPage) { 
		$paging .= '<li class="page page_end"><a href="./list.php?test='.$test.'&page=' . $allPage . $subString . '">마지막</a></li> ';
	}
	$paging .= '</ul>';
	
	/* 페이징 끝 */
	
	
	$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
	$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문
	
	$sql = 'select * from $table' . $searchSql . ' order by $col desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
	$result=mysql_query($sql, $connect);
	}
?>