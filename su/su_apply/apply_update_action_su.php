<?php

    session_start();
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    $userlevel = $_SESSION["userlevel"];

	include "../../common.php";
    include _BASE_DIR."/lib/business.php";
	
    $apply_board = new board();
    $apply_board -> check_admin_session();

    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $t_size = isset($_POST['t_size']) ? (int)$_POST['t_size'] : '';
    $addr = isset($_POST['addr'])&&isset($_POST['addr0']) ? $_POST['addr'].$_POST['addr0'] : '';
    $addr1 = isset($_POST['addr1']) ? $_POST['addr1'] : '';
    $addr2 = isset($_POST['addr2']) ? $_POST['addr2'] : '';
    $addr3 = isset($_POST['addr3']) ? $_POST['addr3'] : '';

    $pla_idx = isset($_POST['num_'])? $_POST['num_'] : null ;

    //var_dump($pla_idx);

     
    	$query = "update apply set ";
	    $query .= "m_addr=?, m_addr1=?, m_addr2=?,m_addr3=?, m_email=?, m_tsize=?, m_phone=?";
	    $query .= " where ap_pub_num=?";
	    $statement = $connect->prepare($query);

	    $statement->bind_param('sssssiss',$addr,$addr1,$addr2,$addr3,$email,$t_size,$phone,$pla_idx);
	    $flag = $statement-> execute();


	    if($flag){

	    	echo "<script>alert('정상적으로 수정되었습니다.');location.href='./apply.php';</script>";
	    }else{
	    	echo "<script>alert('뭔가 잘못됬습니다.');</script>";
	    }

    /* 
	
	function update_query($arr){


	   




        $statement = $connect->prepare($query);



        $statement->bind_param('sssssdss',$phone,$addr,$addr1,$addr2,$email,$last_update,$t_size,$this->q_sch);


        $flag = $statement->execute();





        $connect->close();

        return $flag;

	}


    */