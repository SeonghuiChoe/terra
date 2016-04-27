<?
session_start();

include "../lib/dbconn.php";

$page=$_GET['page'];
$table=$_GET["table"];
$bf_num=$_GET["bf_num"];
$bf_re_num=$_GET["bf_re_num"];

$sql="DELETE FROM bf_re WHERE bf_re_num=$bf_re_num";
echo $bf_re_num."<br>";
echo $sql;
mysql_query($sql, $connect);


echo ("
<script>
location.href='./view.php?table=$table&bf_num=$bf_num&page=$page';
</script>
");
mysql_close();
?>