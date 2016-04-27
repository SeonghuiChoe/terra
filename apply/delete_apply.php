<meta charset="utf-8">
<?php
	session_start();
	$userid = $_SESSION["userid"];
	$username = $_SESSION["username"];
	$userlevel = $_SESSION["userlevel"];
	include "../common.php";
	include _BASE_DIR."/lib/business.php";

	$num_ = isset($_GET['num_'])? $_GET['num_'] : '';
	#echo $num_;

    $apply_board = new board();
    $apply_board->check_login_session();

    $arr = array("q_table"=>"apply","q_condition1"=>"ap_pub_num","q_condition2"=>$num_);
    $result = $apply_board->delete_query($arr);


    /* delete from apply where ap_pub_num =  ? */

    if($result){
    	echo " <script>window.alert('신청이 정상적으로 취소되었습니다.');location.href='apply_list.php'</script>";
    	#header("Location: http://localhost/terra/apply/apply_list.php");
    }

?>