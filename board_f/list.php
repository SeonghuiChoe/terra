<?
include("./board_f_h.php");

if ( !$_SESSION['userid'] ) {
	"document.location.href='../index.php'";
}

include("../lib/dbconn.php");
$table="board_f"; // 게시판 테이블명
$col="bf_num"; // 게시판 인덱스 넘버
$ripple="bf_re"; // 덧글 테이블명
$mode=$_GET["mode"];

$searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
$searchText=$_GET["searchText"]; // 페이징 searchText
$searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
$searchText=$_GET["searchText"]; // 페이징 searchText
$scale=10; //한페이지 글 갯수 정의

require_once("../lib/paging.php"); // 페이징 PHP 호출

$sql_p="SELECT * FROM $table" . $searchSql." ORDER BY bf_num DESC";
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
	<tr>
		<th>번호</th>
		<th>제목</th>
		<th>작성자</th>
		<th>등록일</th>
		<th>조회수</th>
	</tr>
<?
if(empty($allPost_p))
echo $emptyData;
for($i=$start; $i<$start+$scale && $i<$total_record; $i++) {
	mysql_data_seek($result, $i); // 가져올 레코드 위치(포인터)로 이동, for문에서 요긴하게 사용됨
	$row=mysql_fetch_array($result);

	$bf_num=$row[bf_num];
	$bf_id=$row[id];
	$bf_name=$row[bf_name];
	$bf_hit=$row[bf_hit];
	$bf_date=$row[bf_reg_date];
	$bf_date1=$row[bf_reg_date];
	$bf_date=substr($bf_date, 0, 10); // 문자열 자르기(문자열, 자르기 시작지점, 문자개수)
	$bf_date1=substr($bf_date1, 11, 5);
	$bf_title=str_replace(" ", "&nbsp;", $row[bf_title]);

	$sql="SELECT * FROM $ripple WHERE bf_re_parent=$bf_num";
	$result2=mysql_query($sql, $connect);
	$num_ripple=mysql_num_rows($result2);

?>
	<tr>
		<td><?=$number?></td>
		<td class="subject">
		<a href="./view.php?table=<?=$table?>&bf_num=<?=$bf_num?>&page=<?=$page?>"><?=$bf_title?>
		<?
		if ($num_ripple) {
		echo "&nbsp;[$num_ripple]";}?></a></td>
		<td><?echo "$bf_name($bf_id)"?></td>
		<td><? echo "$bf_date ($bf_date1)"?></td>
		<td><?=$bf_hit?></td>
	</tr>
<?
	$number--;
}
if(!$_GET["page"]) {
	$pages=1;
} else {
	$pages=$_GET["page"];
}
?>
</table>
</div>

<div id="boardList">
	<div class="paging"><? echo "<br>".$paging."<br>" ?></div>
<div class="searchBox"> <!-- 게시판별 컬럼명 맞춰야함 -->
	<form action="list.php" method="GET">
		<select name="searchColumn">
			<option <? echo $searchColumn=='bf_title'?'selected="selected"':null?> value="bf_title">제목</option>
			<option <? echo $searchColumn=='bf_content'?'selected="selected"':null?> value="bf_content">내용</option>
			<option <?php echo $searchColumn=='bf_name'?'selected="selected"':null?> value="bf_name">작성자</option>
			<option <?php echo $searchColumn=='bf_id'?'selected="selected"':null?> value="bf_id">아이디</option>
		</select>
		<input type="text" name="searchText" value="<? echo isset($searchText)?$searchText:null?>">
		<button type="submit">검색</button>
	</form>
</div>
</div>

<div id="button">
	<?
	if( $userlevel==1 || $userlevel==10 ){
	?>
	<a href="./write.php?table=<?=$table?>&page=<?=$page?>">글쓰기</a>
	<?
	}
	?> 
</div>
<?
include("./board_f_f.php");
?>