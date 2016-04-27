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
	
	if($searchColumn!="" && $searchText!="") {
		$searchSql = ' where ' . $searchColumn . ' like "%' . $searchText . '%"';
	} else {
		$searchSql = '';
	}
	
	/* 검색 끝 */

	$sql_p="select * from member" . $searchSql." order by m_regist_day ".$search;
    $result_p=mysql_query($sql_p, $connect);
	
	$row_p=mysql_num_rows($result_p);
	
	$allPost_p = $row_p; //전체 게시글의 수

	$onePage = $scale; // 한 페이지에 보여줄 게시글의 수.
	$allPage = ceil($allPost_p / $onePage); //전체 페이지의 수
	
	if($page < 1 || $page > $allPage) {
		echo "<script>alert('존재하지 않는 페이지입니다.');history.back();</script>";
		exit;
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
	
	$paging = "<div class='paging_div'>"; // 페이징을 저장할 변수
	
	//첫 페이지가 아니라면 처음 버튼을 생성
	if($page != 1) { 
		$paging .= '<a href="./member_list.php?page=1' . $subString . '"><input type="button" value="처음" class="paging_btn" /></a>';
	}
	//첫 섹션이 아니라면 이전 버튼을 생성
	if($currentSection != 1) { 
		$paging .= '<a href="./member_list.php?page=' . $prevPage . $subString . '">◀</a>';
	}
	
	for($i = $firstPage; $i <= $lastPage; $i++) {
		if($i == $page) {
			$paging .= ' ' . $i . ' ';
		} else {
			$paging .= '&nbsp<a href="./member_list.php?page=' . $i . $subString . '">' . $i . '</a>&nbsp';
		}
	}
	
	//마지막 섹션이 아니라면 다음 버튼을 생성
	if($currentSection != $allSection) { 
		$paging .= '<a href="./member_list.php?page=' . $nextPage . $subString . '">▶</a>';
	}
	
	//마지막 페이지가 아니라면 끝 버튼을 생성
	if($page != $allPage) { 
		$paging .= '<a href="./member_list.php?page=' . $allPage . $subString . '"><input type="button" value="마지막" class="paging_btn" /></a> ';
	}
	$paging .= '</div>';
	
	/* 페이징 끝 */
	
	
	$currentLimit = ($onePage * $page) - $onePage; //몇 번째의 글부터 가져오는지
	$sqlLimit = ' limit ' . $currentLimit . ', ' . $onePage; //limit sql 구문
	
	$sql = 'select * from $table' . $searchSql . ' order by $col desc' . $sqlLimit; //원하는 개수만큼 가져온다. (0번째부터 20번째까지
	$result=mysql_query($sql, $connect);
	}
?>