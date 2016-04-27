<?php
  session_start();
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

  $userid=$_SESSION["userid"];
  $username=$_SESSION["username"];
  $usernick=$_SESSION["usernick"];

  $table=$_GET["table"];
  $mode=$_GET["mode"];
  $page=$_GET["page"];
  $num=$_GET["num"];
  $test=$_GET["test"];
  

  $subject=$_POST["subject"];
  $content=$_POST["content"];
  $upf_chk=$_FILES["upfile"];
  $delf_chk=$_POST["del_file"];
  $html_ok=$_POST["html_ok"];


if(!$userid){
	echo("<script>window.alert('로그인을 하십시요');location.href='../member/login.php';</script>");
	exit;
}

$total_upf_chk = count($upf_chk["name"]);

// 사진이 업로드 안되었을때 유효검사는 인서트페이지에서 처리함.
//  $regist_day=date("Y-m-d (H:i)");
// 다중 파일, 배열형식

$count=count($upf_chk["name"]);
$files=$_FILES["upfile"];

$upload_dir="../data/";

$total_uploaded_file ="";
$total_copied_file_name ="";

for($i=0; $i<$total_upf_chk; $i++){
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

if($i==$total_upf_chk || $total_upf_chk-1==$i){
	 $total_uploaded_file .= $upfile_name[$i];
	 $total_copied_file_name .= $copied_file_name[$i];
 }else{
	 $total_uploaded_file .= $upfile_name[$i].",";
	 $total_copied_file_name .= $copied_file_name[$i].",";
 }
  
  if($upfile_size[$i]>5242880){
	echo "<script>alert('사진용량이 5M를 넘어서는 안됩니다.');history.go(-1);</script>";
	exit;
  }
  if(($upfile_type[$i]!="image/gif") && ($upfile_type[$i]!="image/jpeg") && ($upfile_type[$i]!="image/pjpeg") && ($upfile_type[$i]!="image/png")){
	echo "<script>alert('jpg, png, gif만 업로드가능, 현재 $upfile_type[$i] 파일형식');history.go(-1);</script>";
	exit;
  }
  if(!move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i])){// 이동할 파일 시작, 도착
	echo "<script>alert('업로드 오류입니다.');</script>";
	exit;
  }
}
}


include "../lib/dbconn.php";

if($mode=="modify"){	

	$num_checked=count($_POST['del_file']);
	$position=$_POST['del_file'];//del_file는 배열
	
	for($h=0; $h<$num_checked; $h++){
	  $index=$position[$h];
	  $del_ok[$index]="y";
	}	
		
	$sql="select * from $table where bg_num=$num";
	$result=mysql_query($sql, $connect);
	$row=mysql_fetch_array($result);
	
	$total_uploaded_file_add = $row[bg_file_name_0];
	$image_name=explode(",", $total_uploaded_file_add);
	
	$total_copied_file_name_add = $row[bg_file_copied_0];
	$image_copied=explode(",", $total_copied_file_name_add);


	for($j=0; $j<$count; $j++){
	
		  if($del_ok[$j]=="y"){

				if(!$upfile_error[$j]){//사진이 있을때 사진삭제후(실제삭제,경로삭제) 추가
					$delete_path=$upload_dir.$image_copied[$j];
					unlink($delete_path);								
					$total_uploaded_file_add_2[] .= $upfile_name[$j];
					$total_copied_file_name_add2[] .= $copied_file_name[$j];
				}
				elseif($upfile_error[$j]){//사진이 없을때 삭제
					
					$delete_path=$upload_dir.$image_copied[$j];
					unlink($delete_path);
				}


		  }else{//체크박스 선택 안한 항목에 대해서

				if(!$upfile_error[$j]){//사진이 있을때 사진삭제후(실제삭제,경로삭제) 추가
					if($image_name[$j]){
						$delete_path=$upload_dir.$image_copied[$j];
						unlink($delete_path);	
					}									
					$total_uploaded_file_add_2[] .= $upfile_name[$j];
					$total_copied_file_name_add2[] .= $copied_file_name[$j];
				}
				elseif($upfile_error[$j]){//사진이 없을때 추가
					if($image_name[$j]){
					$total_uploaded_file_add_2[] .= $image_name[$j];
					$total_copied_file_name_add2[] .= $image_copied[$j];			
					}
				}		
			
		}
				if($total_uploaded_file_add_2!=""){
					$a = join(",",$total_uploaded_file_add_2);
					$b = join(",",$total_copied_file_name_add2);

					$aa = substr($a,strlen($a)-1,strlen($a));
					if($aa==","){
						$a = substr($a,0,strlen($a) - 1);
					}
					$bb = substr($b,strlen($b)-1,strlen($b));
					if($bb==","){
						$b = substr($b,0,strlen($b) - 1);
					}
				}

				$sql="update $table set ";
				$sql.="bg_file_name_0='".$a."', bg_file_copied_0='".$b."'";
				$sql.=" where bg_num=$num";
				mysql_query($sql, $connect);

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

	$sql="insert into $table (bg_id, bg_name, bg_nick, bg_subject, bg_content, bg_regist_day, bg_hit, bg_is_html, bg_file_name_0, bg_file_copied_0)";
	$sql.=" values('$userid','$username','$usernick','$subject','$content',now(),0,'$is_html','$total_uploaded_file','$total_copied_file_name')";
	mysql_query($sql, $connect);
}


	mysql_close();
	if($_GET['mypage']==1){echo("<script>location.href='../member/list.php?test=$test&page=$page'</script>");}
	else{echo("<script>location.href='list.php?table=$table&page=$page';</script>");} 
  
  ?>
  
  
 
  
  

