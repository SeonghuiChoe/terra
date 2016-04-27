<?
session_start();

include "../lib/dbconn.php";

$page=$_GET['page'];
$table=$_GET["table"];
$br_num=$_GET["br_num"];
$br_re_num=$_GET["br_re_num"];

$sql="DELETE FROM br_re WHERE br_re_num=$br_re_num";
echo $br_re_num."<br>";
echo $sql;
mysql_query($sql, $connect);

echo ("
<script>
location.href='./view.php?table=$table&br_num=$br_num&page=$page';
</script>
");
mysql_close();
?>