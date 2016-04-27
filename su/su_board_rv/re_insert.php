<?
session_start();

include("../lib/dbconn.php");
$page=$_GET['page'];
$userid=$_SESSION["userid"];
$username=$_SESSION["username"];
$br_re_content=$_POST["ripple_content"];
$table=$_GET["table"];
$ripple=$_GET["ripple"];
$br_num=$_GET["br_num"];

if ( !$userid ) {
	echo("
	<script>
	window.alert('로그인 후 덧글을 작성할 수 있습니다.');
	history.go(-1);
	</script>
	");
	exit;
}

$sql="INSERT INTO $ripple (br_re_parent, id, br_re_name, br_re_content, br_re_reg_date) ";
$sql.="VALUES ('$br_num', '$userid', '$username', '$br_re_content', now())";
mysql_query($sql, $connect);

echo("
<script>
location.href = './view.php?table=$table&br_num=$br_num&page=$page';
</script>
");
mysql_close();
?>