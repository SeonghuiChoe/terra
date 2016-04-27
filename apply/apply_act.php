<meta charset="utf-8">
<?php

    session_start();
    $userid = $_SESSION["userid"];
    $username = $_SESSION["username"];
    $userlevel = $_SESSION["userlevel"];

    include "../common.php";
    include _BASE_DIR."/lib/business.php";

    $apply_board = new board();
    $apply_board->check_login_session();

    /* 신청테이블에서 내가 신청한 내역만 뽑아온다.  applied 배열변수에는 신청한 대회관련번호들이 들어간다.  */
    # select pla_idx from appy where  mem_id = $userid
    $arr = array("q_table"=>"apply", "q_condition1"=>"mem_id", "q_condition2"=>$userid,"q_fld"=>"pla_idx");
    $result = $apply_board->select_query($arr);
    // plan 테이블에서 등록된 모든 마라톤  pla_idx를 배열구조로 가져온다.
    $cnt = 0;
    $applied = array();
    while($rows = mysqli_fetch_array($result)){
        $applied[$cnt]=$rows['pla_idx'];
        $cnt++;
    }
    //var_dump($applied); //가져왔다 .


    // 전체 구조 - 내가 신청한 내역 = 내가 신청 가능한 대회 pla_idx값을 가져올수 있다.
    # select pla_idx from plan
    // $arr = array("q_table"=>"plan", "q_fld"=>"pla_idx");
    // $result = $apply_board->select_query($arr);
    // $cnt = 0;
    // $planed = array();
    // while($rows = mysqli_fetch_array($result)){
    //     $planed[$cnt] =$rows['pla_idx'];
    //     $cnt++;
    // }
    // var_dump($planed);

    // 로그인한 사용자의 신청한 값만큼 반복하여 신청한내역에 해당하는 값이 있는지 확인 
    // $cnt = count($applied);
    // for($i=0;$i<$cnt;$i++){
    //     if(isarray($applied[$i],))
    // }



    //$pla_date = isset($_POST['pla_date']) ? $_POST['pla_date'] : '';
    $phone = isset($_POST['phone']) ? $_POST['phone'] : '';
    $email = isset($_POST['email']) ? $_POST['email'] : '';
    $t_size = isset($_POST['t_size']) ? $_POST['t_size'] : '';
    $addr = isset($_POST['addr'])&&isset($_POST['addr0']) ? $_POST['addr'].$_POST['addr0'] : '';
    $addr1 = isset($_POST['addr1']) ? $_POST['addr1'] : '';
    $addr2 = isset($_POST['addr2']) ? $_POST['addr2'] : '';
    $addr3 = isset($_POST['addr3']) ? $_POST['addr3'] : '';
    #$last_update=date("Y-m-d (H:i)");

    #echo $addr2;
   # echo "<Br><Br><Br><Br>";

  
    /* 대회 신청시 변경할 사항이 있으면 변경한다. */
    

    // $arr = array("q_table"=>"member","q_condition2"=>"m_id","q_condition1"=>$userid,
    // "fld"=>array("phone"=>$phone,"addr"=>$addr,"addr1"=>$addr1,"addr2"=>$addr2,"last_update"=>$last_update,"t_size"=>$t_size,"email"=>$email));

    // $result = $apply_board->update_query( $arr);

    //회원정보가 수정되었는지 확인할수있는 부울린 값.
    //echo "회원정보 수정 결과 : ".$result;


    //apply 테이블에 회원번호와 대회번호를 인서트한다.
    /*
       세션에서 유저 id를 가져온다 여기서는 c1회원을 테스트로 삼는다.

    */
    //$userid = "c1";
    //마라톤 대회 번호
    $pla_idx = isset($_POST['num_'])? $_POST['num_'] : null ;
   #var_dump($pla_idx); echo "<Br>"; 
   #var_dump($applied); echo "<Br>";

    //신청한 내역이 있을경우 
    if(in_array($pla_idx,$applied)){
        echo "<script>if(confirm('이미 신청한 내역이 있습니다.\\n나의 신청현황페이지로 갈까요?')){location.href='apply_list.php';}else{history.back();}</script>";
    }else{

        #echo "apply_act의 상세주소는 ";
        #var_dump($addr3);
    //받아온 대회번호로 신청한 내역이 없는 경우 

    $arr =  array("q_table"=>"apply","fld_name"=>array("member_id"=>"mem_id","pla_index"=>"pla_idx","m_phone"=>"m_phone","m_email"=>"m_email","m_tsize"=>"m_tsize","m_addr"=>"m_addr","m_addr1"=>"m_addr1","m_addr2"=>"m_addr2","m_addr3"=>"m_addr3")
                                    ,"fld_value"=>array("mem_id"=>$userid, "pla_idx"=>$pla_idx,"m_phone"=>$phone,"m_email"=>$email,"m_tsize"=>$t_size,"m_addr"=>$addr,"m_addr1"=>$addr1,"m_addr2"=>$addr2, "m_addr3"=>$addr3));

    $result = $apply_board->insert_query($arr);
   # var_dump($arr['fld_value']);
    //대회 신청이 입력되었는지 확인할수있는 부울린 값.
    //    echo  "대회신청 입력 결과 : ".$result;

    //회원신청이 정확히 완료되었는지 리턴한다.

    if($result){
	   echo "<html><head><meta charset='utf-8'></head><body><form name='form1' action='change_member_info_act.php' method='POST'><input type='hidden' name='phone' value='".$phone."'><input type='hidden' name='email' value='".$email."'><input type='hidden' name='t_size' value='".$t_size."'><input type='hidden' name='addr' value='".$addr."'><input type='hidden' name='addr1' value='".$addr1."'><input type='hidden' name='addr2' value='".$addr2."'><input type='hidden' name='addr3' value='".$addr3."'></form></body></html>";
	// list page redirect
	   echo "<script>if(confirm('신청이 완료되었습니다.\\n입력한 회원정보를 나의정보로 업데이트 하시겠습니까?')){document.form1.submit();}else{location.href='apply_list.php';}</script>";
    }
}

?>
