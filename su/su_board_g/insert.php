<?php
  session_start();
  include "../../common.php";
/*
name="upfile"일때, ('upfile[]'이 아닌 단일 파일일때)
$_FILES["upfile"]["name"]
$_FILES["upfile"]["tmp_name"]
$_FILES["upfile"]["type"]
$_FILES["upfile"]["size"]
$_FILES["upfile"]["error"]
실제 이름, 서버에 올려진 임시 경로와 이름(???.tmp), 파일 형식(image/jpeg), 크기, 오류가 없을땐 0
$upfile_name=$_FILES["upfile"]["name"];
$upfile_tmp_name=$_FILES["upfile"]["tmp_name"];
$upfile_type=$_FILES["upfile"]["type"];
$upfile_size=$_FILES["upfile"]["size"];
$upfile_error=$_FILES["upfile"]["error"];
*/
?>
<meta charset="utf-8">
<?php
  $userid=$_SESSION["userid"];
  $username=$_SESSION["username"];
  $usernick=$_SESSION["usernick"];

  $table=$_GET["table"];
  $mode=$_GET["mode"];
  $page=$_GET["page"];
  $num=$_GET["num"];

  $subject=$_POST["subject"];
  $content=$_POST["content"];
  $upf_chk=$_FILES["upfile"];
  $delf_chk=$_POST["del_file"];
  $html_ok=$_POST["html_ok"];


  if(!$userid){
    echo("
    <script>
    window.alert('로그인을 하십시요');
    location.href='../member/login.php';
    </script>
    ");
    exit;
  }

// 사진이 업로드 안되었을때 유효검사는 인서트페이지에서 처리함.
  if(!($upf_chk["name"][0]||$upf_chk["name"][1]||$upf_chk["name"][2])&&!($mode=="modify")){
    echo("
    <script>
    window.alert('사진을 올려주세요');
    history.go(-1);
	</script>
    ");
	exit;
  }


//  $regist_day=date("Y-m-d (H:i)");


  // 다중 파일, 배열형식
  $files=$_FILES["upfile"];
  $count=count($files["name"]);

  $upload_dir=_BASE_DIR."/data/";

  for($i=0; $i<$count; $i++){
    $upfile_name[$i]=$files["name"][$i];
    $upfile_tmp_name[$i]=$files["tmp_name"][$i];
    $upfile_type[$i]=$files["type"][$i];
    $upfile_size[$i]=$files["size"][$i];
    $upfile_error[$i]=$files["error"][$i];

    $file=explode(".", $upfile_name[$i]);
    $file_name=$file[0];
    $file_ext=$file[1];

    if(!$upfile_error[$i])
    {
      $new_file_name=date("Y_m_d_H_i_s");
      $new_file_name.="_".$i;
      $copied_file_name[$i]=$new_file_name.".".$file_ext;
      $uploaded_file[$i]=$upload_dir.$copied_file_name[$i];
      
      if($upfile_size[$i]>5242880){
        echo("
        <script>
        alert('사진용량이 5M를 넘어서는 안됩니다.');
        history.go(-1);
        </script>
        ");
        exit;
      }
      if(($upfile_type[$i]!="image/gif") && ($upfile_type[$i]!="image/jpeg") && ($upfile_type[$i]!="image/pjpeg") && ($upfile_type[$i]!="image/png")){
        echo("
        <script>
        alert('jpg, png, gif만 업로드가능, 현재 $upfile_type[$i] 파일형식');
        history.go(-1);
        </script>
        ");
        exit;
      }
      if(!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i])){// 이동할 파일 시작, 도착
        echo("
        <script>
        alert('업로드 오류입니다.');
        </script>
        ");
        exit;
      }
    }
  }

  include "../lib/dbconn.php";

  if($mode=="modify"){
    $num_checked=count($_POST['del_file']);
    $position=$_POST['del_file'];//del_file는 배열

    for($i=0; $i<$num_checked; $i++){
      $index=$position[$i];
      $del_ok[$index]="y";
    }

    $sql="select * from $table where bg_num=$num";
    //echo $sql." . ".$del_ok[0];
    $result=mysql_query($sql, $connect);
    $row=mysql_fetch_array($result);


    for($i=0; $i<$count; $i++){
      $filed_org_name="bg_file_name_".$i;
      $filed_real_name="bg_file_copied_".$i;

      $org_name_value=$upfile_name[$i];
      $org_real_value=$copied_file_name[$i];
      
      
      if($del_ok[$i]=="y"){
        $delete_field="bg_file_copied_".$i;
        $delete_name=$row[$delete_field];
        $delete_path=$upload_dir.$delete_name;

        unlink($delete_path);//삭제

        $sql="update $table set ";
        $sql.="$filed_org_name='$org_name_value', $filed_real_name='$org_real_value'";
        $sql.=" where bg_num=$num";
        mysql_query($sql, $connect);
      }else{//체크박스 선택 안한 항목에 대해서
        if(!$upfile_error[$i]){//오류가 없다면 파일 올리기
          $sql="update $table set ";
          $sql.="$filed_org_name='$org_name_value', $filed_real_name='$org_real_value'";
          $sql.=" where bg_num=$num";
          mysql_query($sql, $connect);
        }
      }
    }
    $sql="update $table set bg_is_html='$html_ok',bg_subject='$subject', bg_content='$content' where bg_num=$num";
    mysql_query($sql, $connect);
  }else{// 수정이 아니면
    if($html_ok=="y"){
      $is_html="y";
    }else{
      $is_html="";
      $content=htmlspecialchars($content);//html 쓰기상태가 아니니까 html특수기호들을(<, &같은) &amp;로 변환한다.
    }

    $sql="insert into $table (bg_id, bg_name, bg_nick, bg_subject, bg_content, bg_regist_day, bg_hit, bg_is_html, bg_file_name_0, bg_file_name_1, bg_file_name_2, bg_file_copied_0, bg_file_copied_1, bg_file_copied_2)";
    $sql.=" values('$userid','$username','$usernick','$subject','$content',now(),0,'$is_html','$upfile_name[0]','$upfile_name[1]','$upfile_name[2]','$copied_file_name[0]','$copied_file_name[1]','$copied_file_name[2]')";
    mysql_query($sql, $connect);
  }
// 사진이 결과적으로 한장도 업로드 안되었을때 유효검사 경고창
if($mode=="modify"){
	$sql="select * from $table where bg_num=$num";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);
	$image_copied[0]=$row[bg_file_copied_0];
	$image_copied[1]=$row[bg_file_copied_1];
	$image_copied[2]=$row[bg_file_copied_2];

	
	if(($image_copied[0]=="")&&($image_copied[1]=="")&&($image_copied[2]=="")){
		echo("
		<script>
		window.alert('사진을 최소 1장은 올려주세요');
		history.go(-1);
		</script>
		");
	exit;
	}
  mysql_close();
}
  echo("
  <script>
  location.href='list.php?table=$table&page=1';
  </script>
  ");
?>