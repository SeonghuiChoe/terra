<?
include("./board_rv_su_h.php");
include _BASE_DIR."/common.php";
if ( !$_SESSION['userid'] ) {
	"document.location.href='../index.php'";
}

$table="board_rv"; // 게시판 테이블명
$col="br_num"; // 게시판 인덱스 넘버
$ripple="br_re"; //덧글 테이블명
$mode=$_GET["mode"];

$searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
$searchText=$_GET["searchText"]; // 페이징 searchText
$searchColumn=$_GET["searchColumn"]; //페이징 searchColumn 
$searchText=$_GET["searchText"]; // 페이징 searchText
$scale=10; //한페이지 글 갯수 정의

require_once("../lib/paging.php"); // 페이징 PHP 호출

$sql_p="SELECT * FROM $table" . $searchSql." ORDER BY br_num DESC";
$result=mysql_query($sql_p, $connect);
$total_record=mysql_num_rows($result);

if ( !$page or $page<1 ) {
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
	<tr>
		<th><input type="checkbox" name="chkAll" onclick="javascript:checkAll();"></th>
		<th>번호</th>
		<th>제목</th>
		<th>작성자</th>
		<th>등록일</th>
		<th>조회수</th>
	</tr>
<?
if ( empty ( $allPost_p ) )
echo $emptyData;
for($i=$start; $i<$start+$scale && $i<$total_record; $i++) {
	mysql_data_seek($result, $i); // 가져올 레코드 위치(포인터)로 이동, for문에서 요긴하게 사용됨
	$row=mysql_fetch_array($result);
	$image_copied[0]=$row[br_copied_0];
	$image_copied[1]=$row[br_copied_1];
	$image_copied[2]=$row[br_copied_2];	

	$br_num=$row[br_num];
	$br_id=$row[id];
	$br_name=$row[br_name];
	$br_hit=$row[br_hit];
	$br_date=$row[br_reg_date];
	$br_date1=$row[br_reg_date];
	$br_date=substr($br_date, 0, 10); // 문자열 자르기(문자열, 자르기 시작지점, 문자개수)
	$br_date1=substr($br_date1, 11, 5);
	$br_title=str_replace(" ", "&nbsp;", $row[br_title]);

	$sql="SELECT * FROM $ripple WHERE br_re_parent=$br_num";
	$result2=mysql_query($sql, $connect);
	$num_ripple=mysql_num_rows($result2);

?>
	<tr>
		<td><input type="checkbox" name="list" id="list" value="<?=$br_num?>" onclick="javascript:onCheckBoxClick();"></td> <!-- 체크 들어갈 영역 -->
		<td><?=$number?></td>
		<td class="subject">
		<a href="./view.php?table=<?=$table?>&br_num=<?=$br_num?>&page=<?=$page?>"><?=$br_title?><?if($image_copied[0]||$image_copied[1]||$image_copied[2]){echo " <img src='../../images/img.png' align='center'>";}?>
		<?
		if ( $num_ripple ) {
		echo "&nbsp;[$num_ripple]";}?></a></td>
		<td><?echo "$br_name($br_id)"?></td>
		<td id="date"><?echo "$br_date ($br_date1)"?></td>
		<td><?=$br_hit?></td>
	</tr>
<?
	$number--;
}
if ( !$_GET["page"] ) {
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
		<select name="searchColumn">
			<option <? echo $searchColumn=='br_title'?'selected="selected"':null?> value="br_title">제목</option>
			<option <? echo $searchColumn=='br_content'?'selected="selected"':null?> value="br_content">내용</option>
			<option <?php echo $searchColumn=='br_name'?'selected="selected"':null?> value="br_name">작성자</option>
			<option <?php echo $searchColumn=='br_id'?'selected="selected"':null?> value="br_id">아이디</option>
		</select>
		<input type="text" name="searchText" value="<? echo isset($searchText)?$searchText:null?>">
		<button type="submit">검색</button>
	
</div>
</div>

<div id="button">
	
	<?
	if( $userlevel==1 || $userlevel==10 ){
	?>
	<!--<a href="./write.php?table=<?=$table?>&page=<?=$page?>">글쓰기</a>-->
	<a href="javascript:del('delete.php?table=<?=$table?>&page=<?=$page?>');">삭 제</a></form>
	<?
	}
	?> 
</div>
<?
include("./board_rv_su_f.php");
?>