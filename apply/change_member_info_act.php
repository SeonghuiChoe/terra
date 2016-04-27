<meta charset="utf-8">
<?php
  session_start();
  $userid = $_SESSION["userid"];
  $username = $_SESSION["username"];
  $userlevel = $_SESSION["userlevel"];
  include "../common.php";
  include _BASE_DIR."/lib/business.php";


    $applyboard = new board();
    $applyboard->check_login_session();

    //$pla_date = isset($_POST['pla_date']) ? $_POST['pla_date'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $t_size = isset($_POST['t_size']) ? $_POST['t_size'] : '';
    $addr = isset($_POST['addr']) ? $_POST['addr'] : '';
    $addr1 = isset($_POST['addr1']) ? $_POST['addr1'] : '';
    $addr2 = isset($_POST['addr2']) ? $_POST['addr2'] : '';
	$addr3 = isset($_POST['addr3']) ? $_POST['addr3'] : '';
    $last_update=date("Y-m-d (H:i)");



    /* 세션에서 받아온 유저 아이디  */
    //$userid="c1";

    $arr = array("q_table"=>"member","q_condition2"=>"m_id","q_condition1"=>$userid,
    "fld"=>array("phone"=>$phone,"addr"=>$addr,"addr1"=>$addr1,"addr2"=>$addr2,"addr3"=>$addr3,"last_update"=>$last_update,"t_size"=>$t_size,"email"=>$email));

    $result = $applyboard->update_query( $arr);

    //수정이 완료된후 다시 apply_form.php로 이동
     echo "<script>alert('수정이 완료되었습니다.');location.href='apply_list.php';</script>";
?>