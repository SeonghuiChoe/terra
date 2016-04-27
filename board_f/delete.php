<?
session_start();

include("../lib/dbconn.php");
$table=$_GET["table"];
$bf_num=$_GET["bf_num"];
$upload_dir="../data/";
$mypage=$_GET["mypage"];
$page=$_GET["page"];
$num=$_GET["num"];
$test=$_GET["test"];

$sql="SELECT * FROM $table WHERE bf_num=$bf_num";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

$copied_name[0]=$row[bf_copied_0];
$copied_name[1]=$row[bf_copied_1];
$copied_name[2]=$row[bf_copied_2];

for($i=0; $i<3; $i++){
	if($copied_name[$i]){
		$image_name=$upload_dir.$copied_name[$i];
		unlink($image_name);
	}
}

$sql="DELETE FROM $table WHERE bf_num=$bf_num";
mysql_query($sql, $connect);
mysql_close();

if($mypage) {
echo"<script>location.href='../member/list.php?page=$page&test=$test'</script>";
} else {
echo"<script>location.href='./list.php?table=$table&num=$num&page=$page';</script>";
}
?>