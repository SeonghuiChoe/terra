<?
session_start();

include("../lib/dbconn.php");
$table=$_GET["table"];
$br_num=$_GET["br_num"];
$upload_dir="../data/";
$num=$_GET["num"];
$page=$_GET["page"];
$mypage=$_GET["mypage"];
$test=$_GET["test"];

$sql="SELECT * FROM $table WHERE br_num=$br_num";
$result=mysql_query($sql, $connect);
$row=mysql_fetch_array($result);

$total_image_copied=$row[br_copied_0];
$image_copied=explode(",", $total_image_copied);
$file_cnt=count($image_copied);

//$copied_name[0]=$row[br_copied_0];
//$copied_name[1]=$row[br_copied_1];
//$copied_name[2]=$row[br_copied_2];


 for($i=0; $i<$file_cnt; $i++){
    if($image_copied[$i]){
      $image_name=$upload_dir.$image_copied[$i];
      unlink($image_name);
    }
  }

$sql="DELETE FROM $table WHERE br_num=$br_num";
mysql_query($sql, $connect);
mysql_close();

if($mypage) {
echo"<script>location.href='../member/list.php?page=$page&test=$test'</script>";
} else {
echo"<script>location.href='./list.php?table=$table&num=$num&page=$page';</script>";
}
?>