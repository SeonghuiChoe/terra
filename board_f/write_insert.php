<?
session_start();
?>
<meta charset="utf-8">
<?
include ("../lib/dbconn.php");

$userid=$_SESSION["userid"];
$username=$_SESSION["username"];

$table=$_GET["table"];
$num=$_GET["bf_num"];
$mode=$_GET["mode"];
$page=$_GET["page"];
$test=$_GET["test"];  

$subject=$_POST["subject"];
$content=$_POST["content"];
$html_ok=$_POST["html_ok"];

if(!$userid) {
	echo("
	<script>
	window.alert('로그인을 하세요');
	location.href='../member/login.php';
	</script>
	");
	exit;
}

if(!$subject) {
	echo("
	<script>
	window.alert('제목을 입력하세요');
	history.go(-1);
	</script>
	");
	exit;
}

if(!$content) {
	echo("
	<script>
	window.alert('내용을 입력하세요');
	history.go(-1);
	</script>
	");
	exit;
}
if ($mode=="modify") {
	$sql="UPDATE $table SET bf_is_html='$html_ok', bf_title='$subject', bf_content='$content' where bf_num='$num'";
	mysql_query($sql, $connect);
	} else { //그냥 수정이 아니면(글쓰기 상태이면)
		if($html_ok=="y") {
			$is_html="y";
		} else {
			$is_html="";
			$content=htmlspecialchars($content);//html 쓰기상태가 아니니까 html특수기호들을(<, &같은) &amp;로 변환한다. 일반 인설트
		}
		$sql="INSERT INTO $table(id, bf_name, bf_title, bf_content, bf_reg_date, bf_hit, bf_is_html)";
		$sql.=" VALUES('$userid', '$username', '$subject', '$content', now(), 0, '$is_html')";
			mysql_query($sql, $connect);
}

	mysql_close();
	if($_GET['mypage']==1){echo("<script>location.href='../member/list.php?page=$page&test=$test'</script>");}
	else{echo("<script>location.href='list.php?table=$table&page=$page';</script>");}
		
?>