<?
session_start();

include("../lib/dbconn.php");

$userid=$_SESSION["userid"];
$username=$_SESSION["username"];
$bf_re_content=$_POST["ripple_content"];
$table=$_GET["table"];
$ripple=$_GET["ripple"];
$bf_num=$_GET["bf_num"];
$page=$_GET['page'];

if ( !$userid ) {
	echo("
	<script>
	window.alert('로그인 후 덧글을 작성할 수 있습니다.');
	location.href='../member/login.php';
	</script>
	");
	exit;
}

$sql="INSERT INTO $ripple (bf_re_parent, id, bf_re_name, bf_re_content, bf_re_reg_date) ";
$sql.="VALUES ('$bf_num', '$userid', '$username', '$bf_re_content', now())";
mysql_query($sql, $connect);

echo("
<script>
location.href = './view.php?table=$table&bf_num=$bf_num&page=$page';
</script>
");
mysql_close();
?>