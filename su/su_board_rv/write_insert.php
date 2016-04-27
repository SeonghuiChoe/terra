<?
session_start();
include "../../common.php"; 

?>
<meta charset="utf-8">
<?
include ("../lib/dbconn.php");

$userid=$_SESSION["userid"];
$username=$_SESSION["username"];

$table=$_GET["table"];
$br_num=$_GET["br_num"];
$mode=$_GET["mode"];
$page=$_GET["page"];

$subject=$_POST["subject"];
$content=$_POST["content"];
$html_ok=$_POST["html_ok"];


if(!$userid) {
	echo("
	<script>
	window.alert('로그인을 하세요');
	history.go(-1);
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

// 다중 파일, 배열형식
$files=$_FILES["upfile"];
$count=count($files["name"]);
$upload_dir=_BASE_DIR."/data/";

for($i=0; $i<$count; $i++) {
	$upfile_name[$i]=$files["name"][$i];
	$upfile_tmp_name[$i]=$files["tmp_name"][$i];
	$upfile_type[$i]=$files["type"][$i];
	$upfile_size[$i]=$files["size"][$i];
	$upfile_error[$i]=$files["error"][$i];

	$file=explode(".", $upfile_name[$i]);
	$file_name=$file[0];
	$file_ext=$file[1];

	if(!$upfile_error[$i]) {
		$new_file_name=date("Y_m_d_H_i_s");
		$new_file_name.="_".$i;
		$copied_file_name[$i]=$new_file_name.".".$file_ext;
		$uploaded_file[$i]=$upload_dir.$copied_file_name[$i];
	
		if($upfile_size[$i]>5242880) {
			echo("
			<script>
			alert('5MB 이하의 사진파일만 업로드 가능합니다.');
			history.go(-1);
			</script>
			");
			exit;
		}
		if(($upfile_type[$i]!="image/gif") && ($upfile_type[$i]!="image/jpeg") && ($upfile_type[$i]!="image/pjpeg") && ($upfile_type[$i]!="image/png")) {
			echo("
			<script>
			alert('jpg, png, gif 포맷만 업로드 가능, 현재 $upfile_type[$i] 파일형식');
			history.go(-1);
			</script>
			");
			exit;
		}
		if(!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i])) { // 이동할 파일시작, 도착
			echo("
			<script>
			alert('파일을 디렉터리로 복사하는데 실패했습니다. 다시 업로드해주세요.');
			</script>
			");
			exit;
		}
	}
}

if($mode=="modify") {
	$num_checked=count($_POST['del_file']);
	$position=$_POST['del_file'];

	for($i=0; $i<$num_checked; $i++) {
		$index=$position[$i];
		$del_ok[$index]="y";
	}

	$sql="SELECT * FROM $table WHERE br_num=$br_num";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);

	for($i=0; $i<$count; $i++) {
		$filed_org_name="br_img_".$i;
		$filed_real_name="br_copied_".$i;

		$org_name_value=$upfile_name[$i];
		$org_real_value=$copied_file_name[$i];

		if( $del_ok[$i]=="y" ) {
			$delete_field="br_copied_".$i;
			$delete_name=$row[$delete_field];
			$delete_path=$upload_dir.$delete_name;

			unlink($delete_path);//삭제

			$sql="UPDATE $table SET $filed_org_name='$org_name_value', $filed_real_name='$org_real_value' WHERE br_num=$br_num";
			echo $sql;
			mysql_query($sql, $connect);
		} else { // 체크박스 선택 안한 항목에 대해서
			if ( !$upfile_error[$i] ) { // 오류가 없다면 파일 올리기
			$sql="UPDATE $table SET $filed_org_name='$org_name_value', $filed_real_name='$org_real_value' WHERE br_num=$br_num";
			echo $sql;
			mysql_query($sql, $connect);
			}
		}
	}
	$sql="UPDATE $table SET br_is_html='$html_ok', br_title='$subject', br_content='$content' WHERE br_num=$br_num";
	mysql_query($sql, $connect);
} else { // 수정이 아니면
	if($html_ok=="y") {
		$is_html="y";
	} else {
		$is_html="";
		$content=htmlspecialchars($content);
		//html 쓰기상태가 아니니까 html특수기호들을(<, &같은) &amp;로 변환한다.
	}
	$sql="INSERT INTO $table (id, br_name, br_title, br_content, br_reg_date, br_hit, br_is_html, br_img_0, br_img_1, br_img_2, br_copied_0, br_copied_1, br_copied_2)";
	$sql.=" VALUES ('$userid', '$username', '$subject', '$content', now(), 0, '$is_html', '$upfile_name[0]', '$upfile_name[1]', '$upfile_name[2]', '$copied_file_name[0]', '$copied_file_name[1]', '$copied_file_name[2]')";
	mysql_query($sql, $connect);
}
if($mode=="modify") {
	$sql="SELECT * FROM $table WHERE br_num=$br_num";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);
	$image_copied[0]=$row[br_copied_0];
	$image_copied[1]=$row[br_copied_1];
	$image_copied[2]=$row[br_copied_2];
}
mysql_close();
echo("
<script>
location.href='./list.php?table=$table&page=$page';
</script>
");

?>