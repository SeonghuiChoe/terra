<?php
// session.start();  

	include "../../common.php";	
	include _BASE_DIR."/lib/business.php";

$table = "plan";
/*
	prcessing image  


//$upload_dir="../data/";
//$files = $_FILES["upfile"];
//$count = count($files["name"]);

for($i=0; $i<$count; $i++){
    $upfile_name[$i]=$files["name"][$i];
    $upfile_tmp_name[$i]=$files["tmp_name"][$i];
    $upfile_type[$i]=$files["type"][$i];
    $upfile_size[$i]=$files["size"][$i];
    $upfile_error[$i]=$files["error"][$i];

   echo $upfile_name[$i];


    $file=explode(".", $upfile_name[$i]);
    $file_name=$file[0];
    $file_ext=$file[1];

    if(!$upfile_error[$i])
    {
      $new_file_name=date("Y_m_d_H_i_s");
      $new_file_name.="_".$i;
      $copied_file_name[$i]=$new_file_name.".".$file_ext;
      $uploaded_file[$i]=$upload_dir.$copied_file_name[$i];
      
      if($upfile_size[$i]>512000){
        echo("
        <script>
        alert('너무 큽니다. 당신의 야망이');
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
        alert('으음..? 뭔가 이상한데? 파일을 디렉터리로 복사하는걸 실패했어. 다시 적어줘야 겠는걸?');
        </script>
        ");
        exit;
      }


    }
  }
*/

  #보드 클래스 생성
  $planboard = new board();
  #보드 클래스의 image_Fileupload함수를 호출 use in sql statment




// $values from html
$pla_date = isset($_POST['pla_date']) ? $_POST['pla_date'] : '';
$pla_time = isset($_POST['pla_time']) ? $_POST['pla_time'] : '';


#echo "$pla_time";
$pla_place = isset($_POST['pla_place']) ? $_POST['pla_place'] : '';
$pla_distance = isset($_POST['pla_distance']) ? $_POST['pla_distance'] : '';
$pla_name = isset($_POST['pla_name']) ? $_POST['pla_name'] : '';
$pla_period = isset($_POST['pla_period']) ? $_POST['pla_period'] : '';
//$pla_file = isset($_POST['upfile[]']) ? $_POST['upfile[]'] : '';

/*

    만약 upfile[]에 내용이 없을경우 - 이미지 파일을 첨부하지 않았을경우

    image_FileUpload함수를 호출하지 않고
    $uploaded을 ''로 초기화 시킨다. $uploaded[0], $uploade[1] = ''
*/

$upfile = $_FILES;

if($upfile){
$uploaded = $planboard->image_FileUpload();
$uploaded[0] = substr($uploaded[0],3);
$uploaded[1] = substr($uploaded[1],3);
}else{
$uploaded[0] = '';
$uploaded[1] = '';
}





#$time = time();
//now  
$now = date('Y-m-d H:i:s',time());


$date = new DateTime();

//2015-08-05
date_date_set($date, substr($pla_date,0,4),substr($pla_date,5,2),substr($pla_date,8,2) );


// setTime ( int $hour , int $minute [, int $second = 0 ] )
#$date->setTime((int)substr($pla_time,0,2),(int)substr($pla_time,3,2));


$pla_date =date_format($date,'Y-m-d');
//echo $pla_date;




// sql insert into 
/*
INSERT INTO `terra`.`plan` (`pla_idx`, `pla_date`, `pla_place`, `pla_distance`, `pla_period`, `pla_name`, `pla_file_name_0`, `pla_file_name_1`, `pla_file_copied_0`, `pla_file_copied_1`, `pla_reg_date`) 
VALUES (NULL, '2015-08-11', '인천', '10', '2개월', '노네임', '7.jpg', NULL, NULL, NULL, '2015-08-03 00:00:00');

(pla_idx, pla_date, pla_place, pla_distance, pla_period, pla_name, pla_file_name_0, pla_reg_date)

, pla_distance, pla_period, pla_name, pla_file_name_0, pla_reg_date
, $pla_distance,  $pla_period, $pla_name, $pla_file, $now

*/
//var_dump($uploaded[0]);
$sql = "INSERT INTO ".$table." (  pla_date,pla_time,pla_place, pla_distance, pla_period1, pla_name, pla_file_name_0,pla_file_name_1, pla_reg_date) 
                      VALUES('$pla_date','$pla_time', '$pla_place', '$pla_distance',  '$pla_period', '$pla_name', '$uploaded[0]','$uploaded[1]','$now')";
					 

//for($i=0;$i<50;$i++){ //testing paging
# var_dump($sql);
//check database 
if($connect->query($sql)){
	echo "<script>alert('대회등록이 완료되었습니다.');location.href='./plan.php';</script>";	
	// list page redirect
	 #header("Location: http://localhost/terra/su/su_plan/plan.php");

}else{
	echo "something wrong check code<br>";
	echo $connect->connect_error;
	echo $connect->error;
}

//}
$connect->close();

?>