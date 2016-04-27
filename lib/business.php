<?php

include "dbconnection_.php";

#거의 모든 함수에 db커넥션 함수가 있기때문에 소스를 업로드전에 업로드 해도되는지 곰곰히 생각해봐야한다

class board {		 
	

	#쿼리에 사용하는 변수들
	//테이블명
	public	$q_table ;
	// 조건절의 컬럼명
	public	$q_where ;
	// 조건절의 컬럼값
	public	$q_column ;

    // 검색에 사용하는 변수
	public  $q_sch;
	// 필드명으로 사용하는 변수
	public  $q_fld;

    // 페이징처리와 관련된 변수
	public	$page;
	public	$page_set ;
	public	$block_set ;
	public	$row;


	//최근 대회 번호를 검색한다. 
	function latest_plan(){
		mysqli_query($connect, "set names utf8");
		$arr = array("q_fld"=>"min(pla_idx)", "q_table"=>"plan");

        $result = $this->select_query($arr);

        while($rows = mysqli_fetch_array($result)){
            $latest_pla_idx = $rows['min(pla_idx)'];
        }

        return $latest_pla_idx;

	}

	//check admin_session
	function check_admin_session(){
		if($_SESSION['userlevel']!=10){
			#echo $userlevel;
			echo "<script>alert('관리자 페이지 입니다');</script>";
			#echo ("<meta http-equiv='Refresh' content='0; URL=../su/index.php'>");
			exit;

		}
	}
 
	//check login_session
	function check_login_session(){
		if(!isset($_SESSION['userid'])){
			echo "<script>alert('로그인해주세요');</script>";
			echo ("<meta http-equiv='Refresh' content='0; URL=../member/login.php'>");
			exit;

		}
	}

	function registraion_status($arr){

	   # var_dump($arr);

//	    //배열(배열(),배열(),배열()) 의 형태  필드명, 테이블명, 조건절
//        $arr = array("q_fld"=>array("m_id"=>"m.m_id","a_idx"=>"a.ap_pub_num","name"=>"m.m_name","birth"=>"m.m_birth","phone"=>"m.m_phone", "gender"=>"m.m_gender", "pla_idx"=>"a.pla_idx","pla_name"=>"pla_name"),

//                    "q_table"=>array("q_table1"=>"member m","q_table2"=>"apply a"),
//                    "q_where" => array("q_where1"=>"m.m_id", "q_where2"=> "a.mem_id")
						//"page"=>$page,"sch"=>$sch,"fld"=>$fld
//        );
		$fld = $arr['fld'];
        $this->q_fld = $arr['q_fld'];
        $this->q_table = $arr['q_table'];
        $this->q_where = isset($arr['q_where'])? $arr['q_where'] : '';
        $this->page =   $arr['page'];
        $this->q_sch = isset($arr['sch'])? $arr['sch'] : '';

        $this->page_set=10;
        $this->block_set=5;

        $connect = mysqli_connect("localhost", "terra", "terra123","terra");
		mysqli_query($connect, "set names utf8");
      

       	$query = "create view view_apply(mem_name,mem_birth,mem_gender,mem_id,apply_index,applied_plan_index) as ";
       	$query .= "select ". $this->q_fld['name'] ." as mem_name,";
       	$query .=  $this->q_fld['birth'] . " as mem_birth,";
       	$query .=  $this->q_fld['gender']. " as mem_gender,";
       	$query .=  $this->q_fld['m_id'].   " as mem_id,";
       	$query .=  $this->q_fld['a_idx'].  " as apply_index,";
       	$query .=  $this->q_fld['pla_idx'].  " as applied_plan_index ";
       	$query .=  " FROM member m, apply a";
       	$query .= " WHERE " . $this->q_where['q_where1']. " = ". $this->q_where['q_where2'];
       	$query .= " ORDER BY ".$this->q_fld['pla_idx']. " asc";

       	#var_dump($query);
       	if(!$connect->query($query)) echo "view_apply is not created ";

       		


       	###############################################################

       	#무시무시한 뷰와 대회테이블의 조인. 조인한번더할꺼야  이번엔 대회정보까지 가져온다. 중요한건  대회정보가 없으면 대회명 정보 또한 가져올수가 엇다.
		mysqli_query($connect, "set names utf8");
       	$query ="create view view_reg_status(mem_name, mem_gender, mem_id, applied_plan_index, apply_index, pla_name, pla_date ) as
				select v.mem_name	as mem_name, 
				v.mem_gender	as mem_gender, 
				v.mem_id	as mem_id, 
				v.applied_plan_index	as applied_plan_index,
				v.apply_index	as apply_index, 
				p.pla_name	as pla_name, 
				p.pla_date	as pla_date	
				from view_apply v, plan p
				where v.applied_plan_index = p.pla_idx" ;

       
			if(!$connect->query($query)) echo "view_reg_status is not created ";
       	#####################################

		//총 페이지 수
       	$count_query = "select count(apply_index) as total from view_reg_status";
        #var_dump($count_query);
        
        $result = $connect->query($count_query);       

        $row = mysqli_fetch_array($result);
        
        //전체 등록된 신청 수 
        $total = $row['total'];
        #echo "전체 신청수".$total;

       	//페이지의 총 갯수 
       	$total_page = ceil($total/$this->page_set);
       	#echo "total_page :".$total_page."<br>";
       	//묶을 블록 갯수 
       	$total_block = ceil($total_page/$this->block_set);
       	#echo "total_block :".$total_block."<br>";

       	//받은 페이지가 없을경우 1로 초기화
       	if(!$this->page) $this->page=1;

       	// 현재 가리켜야하야하는 페이지 네비게이션(블록)
       	$block = ceil($this->page/$this->block_set);
       	#echo "block :".$block."<br>";
       	//현재 가리키고 있는 블록 글의 시작 인덱스
       	$limit_idx = ($this->page-1) * $this->page_set;
       	#echo "블록글의 시작 :".$limit_idx."<br>";


       	//검색기능 
       		if($this->q_sch!=''){

       			$query = "SELECT * from view_reg_status where ". $fld ." like '%".$this->q_sch ."%' order by  applied_plan_index desc";
				#var_dump($query);

       		/*
				mem_birth :회원의 생년월일,gender : 성별, m_id : 회원아이디(pk), a_idx : 신청테이블의 (pk), pla_idx: 신청테이블의 대회 신청번호 
       		*/
			//("m_id"=>"m.m_id","a_idx"=>"a.ap_pub_num","name"=>"m.m_name","birth"=>"m.m_birth","phone"=>"m.m_phone", "gender"=>"m.m_gender", "pla_idx"=>"a.pla_idx"),
       		

       		}else {
       			#echo "지금은 여기만 생각하자  limit_idx :" . $limit_idx. " pageset :". $this->page_set;
				$query = "SELECT * FROM view_reg_status ORDER BY  applied_plan_index desc LIMIT ".$limit_idx.",". $this->page_set;
	  			 // echo "<br>";
				 #var_dump($query);
       		}

       	$result = $connect->query($query);
       	#var_dump($result);





       	#페이징 번호만드는곳
        $first_page = (($block - 1) * $this->block_set) + 1; // 첫번째 페이지번호 
		$last_page = min ($total_page, $block * $this->block_set) +1; // 마지막 페이지번호 


		$prev_page = $this->page - 1; // 이전페이지 
		$next_page = $this->page + 1; // 다음페이지 
	 
		$prev_block = $block - 1; // 이전블럭 
		$next_block = $block + 1; // 다음블럭 

		// 이전블럭을 블럭의 마지막으로 하려면... 
		$prev_block_page = $prev_block * $this->block_set; // 이전블럭 페이지번호 
		
		// 이전블럭을 블럭의 첫페이지로 하려면... 	
		
		$next_block_page = $next_block * $this->block_set - ($this->block_set - 1); // 다음블럭 페이지번호 

		
		$str_result="<ul>";
	if($prev_block >0){$str_result.="<li class='page page_start'><a href='./list.php?page=1'>처음으로</a></li>";}
	if($prev_page >0 ){$str_result.="<li class='page page_prev'><a href='$_SERVER[PHP_SELF]?page=".$prev_page."'>이전</a></li>";}

	for($i=$first_page; $i<$last_page; $i++){
		if($i == $this->page) {
		$str_result .= '<li class="page current">' . $i . '</li>';
		} else {
		$str_result .= '<li class="page"><a href="./apply.php?page='.$i.'">' . $i . '</a></li>';
		}
	}
	if($next_page <= $total_page){$str_result.="<li class='page page_prev'><a href='$_SERVER[PHP_SELF]?page=".$next_page."'>다음</a></li>";}
	if($next_block<=$total_block){$str_result.="<li class='page page_start'><a href='./list.php?page=".$total_page."'>마지막페이지</a></li>";}
	
	$paging .= '</ul>';
		

		//뷰를 지우는 부분
		$query = "drop view view_apply";
		$re1 = $connect->query($query);
		$query = "drop view view_reg_status";
		$re2 = $connect->query($query);
		#var_dump($re);
		$connect->close();


		#var_dump($str_result);
		#echo "<br>";
		#var_dump($result);
		/*str_result는 페이징의 넘버스, result는 페이징처리한 본문 ,  result_plan_ap_info는 만든 뷰와 대회테이블을 조인한결과  */
		return array ("result_block"=>$str_result,"result_article"=>$result);

	}

	function select_query($arr){
		#var_dump($arr);
		
		


		$this->q_table =$arr["q_table"]; //매개변수로 받은 $arr =  array("q_table"=>"apply","fld"=>array("mem_id"=>$userid, "pla_idx"=>$pla_idx)); 테이블명 member
		$this->q_fld = $arr["q_fld"]; 	//갖고올 필드들 연락처, 이메일, 티셔츠, 주소
		$this->q_where =isset($arr["q_condition2"])? $arr["q_condition2"]:'';                                   //매개변수로 받은 조건절 mem_id
		$this->q_sch = isset($arr["q_condition1"])? $arr["q_condition1"]:''; // where절에서 지정할 조건절

		$connect = mysqli_connect("localhost", "terra", "terra123","terra");
		mysqli_query($connect, "set names utf8");


		//조건문이 없을경우
		$query = "SELECT ".$this->q_fld." from ".$this->q_table;
		#echo $query;
		//조건문이 있을경우
		if($this->q_where!=''){
		$query .= " where ". $this->q_sch ."='".$this->q_where ."'";
		}



		#var_dump($query);
		$result =	$connect->query($query);

		#var_dump($result);

		$connect->close();



		return $result;
	}

	function delete_query($arr){
		/* delete from apply where ap_pub_num =  ? */
		$q_table = $arr["q_table"];
		$q_where = $arr["q_condition1"];
		$q_field = $arr["q_condition2"];

		$connect = mysqli_connect("localhost", "terra", "terra123","terra");
		mysqli_query($connect, "set names utf8");
		$query = "delete from ".$q_table . " where ". $q_where. " = ". $q_field;
		#var_dump($query);
		$result = $connect->query($query);
		return $result;
	}


	function insert_query($arr){

    //	     $arr =  array("q_table"=>"apply","fld_name"=>array("member_id"=>"mem_id","pla_index"=>"pla_idx"),
    //                                        "fld_value"=>array("mem_id"=>$userid, "pla_idx"=>$pla_idx));


		#echo "티셔츠 사이즈  근데 왜 자꾸 2값만 들어가니 ".$arr['fld_value']['m_tsize'];

    $this->q_table = $arr["q_table"];
    $q_fld_name = $arr["fld_name"];
    $q_fld_value = $arr["fld_value"];

    /*
	 array("q_table"=>"apply","fld_name"=>array("member_id"=>"mem_id","pla_index"=>"pla_idx","m_phone"=>"m_phone","m_email"=>"m_email","m_tsize"=>"m_tsize","m_addr"=>"m_addr","m_addr1"=>"m_addr1","m_addr2"=>"m_addr2")
                                    ,"fld_value"=>array("mem_id"=>$userid, "pla_idx"=>$pla_idx,"m_phone"=>$phone,"m_email"=>$email,"m_tsize"=>$t_size,"m_addr"=>$addr,"m_addr1"=>$addr1,"m_addr2"=>$m_addr2));

	
	$arr =  array("q_table"=>"apply","fld_name"=>array("member_id"=>"mem_id","pla_index"=>"pla_idx","m_phone"=>"m_phone","m_email"=>"m_email","m_tsize"=>"m_tsize","m_addr"=>"m_addr","m_addr1"=>"m_addr1","m_addr2"=>"m_addr2","m_addr3"=>"m_addr3")
                                    ,"fld_value"=>array("mem_id"=>$userid, "pla_idx"=>$pla_idx,"m_phone"=>$phone,"m_email"=>$email,"m_tsize"=>$t_size,"m_addr"=>$addr,"m_addr1"=>$addr1,"m_addr2"=>$addr2,"m_addr3"=>$addr3));

    */
	#var_dump($q_fld_value);
	#echo "비지니스에서 상세주소는". $q_fld_value['m_addr2'];
    $query = "insert into ".$this->q_table."  (".$q_fld_name['member_id'] ." , ". $q_fld_name['pla_index']. ",". $q_fld_name['m_phone']. ",". $q_fld_name['m_email']. ",". $q_fld_name['m_tsize']. ",". $q_fld_name['m_addr']. ",". $q_fld_name['m_addr1']. ",". $q_fld_name['m_addr2'] . ",". $q_fld_name['m_addr3'] .")";
    $query .= " values ('". $q_fld_value['mem_id'] ."' , '" . $q_fld_value['pla_idx']."' , '" . $q_fld_value['m_phone']. "' , '" . $q_fld_value['m_email']. "' , '". $q_fld_value['m_tsize']."' , '" . $q_fld_value['m_addr']. "' , '". $q_fld_value['m_addr1']."','" . $q_fld_value['m_addr2']."','" . $q_fld_value['m_addr3']."')"; 

    #var_dump($query);
    $connect = mysqli_connect("localhost", "terra", "terra123","terra");
	mysqli_query($connect, "set names utf8");
    $result = $connect->query($query);

    return $result;

	}

	function update_query($arr){


	    $this->q_table =$arr["q_table"];
	    $this->q_fld = $arr["fld"];
	    $this->q_where =$arr["q_condition2"];
	    $this->q_sch = $arr["q_condition1"];

	    $phone = $this->q_fld['phone'];
	    $addr = $this->q_fld['addr'];
	    $addr1 = $this->q_fld['addr1'];
	    $addr2 = $this->q_fld['addr2'];
		$addr3 = $this->q_fld['addr3'];
	    $email = $this->q_fld['email'];
	    $last_update = $this->q_fld['last_update'];
	    $t_size = $this->q_fld['t_size'];

	    $connect = mysqli_connect("localhost", "terra", "terra123","terra");
		mysqli_query($connect, "set names utf8");

	    $query = "update ". $this->q_table .  " set ";
	    $query .= " m_phone=?, m_addr=?, m_addr1=?, m_addr2=?, m_addr3=?, m_email=?, m_last_update=?, m_tsize=?";
	    $query .= " where ".$this->q_where."=?";




        $statement = $connect->prepare($query);
        $statement->bind_param('ssssssdss',$phone,$addr,$addr1,$addr2,$addr3,$email,$last_update,$t_size,$this->q_sch);
        $flag = $statement->execute();
        $connect->close();

        return $flag;

	}


	//시간남으면 매개변수들 배열화  Array[0=>$q_table,1=>$q_where,2=>$q_column] 
	function search_and_paging($arr){

		//var_dump($arr);
		$this->q_table =$arr["q_table"];
		//$this->q_where =$arr["q_where"];
		$this->q_column = $arr["q_column"];
		$this->q_sch = $arr["sch"];
		$this->q_fld = $arr["q_fld"];


		$this->page =   $arr["page"];	


		$this->page_set=10;
		$this->block_set=5;

	#쿼리에 사용하는 변수들 0=테이블명 ,1=쿼리조건,2=검색할 컬럼명 or 정렬기준컬럼  연관배열로도 쓸수있다.
	
	

	
	//$this->$q_where = $q_where;
	//$this->$q_where =$arguments[];

	$connect = mysqli_connect("localhost", "terra", "terra123","terra");
	mysqli_query($connect, "set names utf8");
	/* 
	paging setting

	*/
	#$q_table ="plan";
	#$q_column="pla_idx";
	
	

	$count_query = "SELECT count(".$this->q_column.") as total from ".$this->q_table;


	
	$result = $connect->query($count_query);
	$row = mysqli_fetch_array($result);

	//전체 등록된 글 수
	$total = $row['total'];

	//페이지의 총갯수
	$total_page = ceil($total / $this->page_set );

	//페이지의 block's number
	//$this->block_set=$total_page-1;

	//숫자로 표현된 페이지 네비게이션을 여기선 블록이라 부른다. 그 블록의 갯수

	$total_block = ceil($total_page/$this->block_set);

	//($get)매개변수로 넘어온 페이지가 없으면 1로 초기화
	if (!$this->page) $this->page = 1; 

	//현재 가리켜야 하는 페이지 네비게이션(블록)
	$block = ceil($this->page/$this->block_set);

	//현재 가리키고 있는 블록의 글의 시작 인덱스
	$limit_idx = ($this->page-1) * $this->page_set;
	#echo "<script>alert($limit_idx);</script>";
	
	//조건 분기 ->  검색 / 일반 

	//var_dump($this->q_table,$this->q_fld,$this->q_sch,$this->q_column);
	//var_dump($this->q_sch!='');

	if($this->q_sch!=''){
	    //검색기능이 있는 쿼리문
		//SELECT * from plan where pla_idxlike '%90%' order by pla_idx desc' 
		//SELECT * from plan where pla_idx like '%90%' order by pla_idx desc;

		$query = "SELECT * from ".$this->q_table." where ". $this->q_fld ." like '%".$this->q_sch ."%' order by ".$this->q_column. " desc";
		var_dump($query);
	}else{
		// 현재페이지 쿼리
		//echo "당신이 찾는글이 없습니다. 다른방식으로 검색을 해보세요~?";
		$query = "SELECT * FROM ".$this->q_table ." ORDER BY ".$this->q_column. " asc LIMIT ".$limit_idx.",". $this->page_set;
	}


	//$query = "SELECT * FROM ".$this->q_table ." ORDER BY ".$this->q_column. " DESC LIMIT ".$limit_idx.",". $this->page_set;
	

	$result = $connect->query($query);

	//var_dump($result);

	$rows = mysqli_num_rows($result);


	/*
	while($row = mysqli_fetch_array($result)){
		echo $row[$q_column]. "\n";
	}
	*/

	// 페이지번호 & 블럭 설정 
	$first_page = (($block - 1) * $this->block_set) + 1; // 첫번째 페이지번호 
	$last_page = min ($total_page, $block * $this->block_set) +1; // 마지막 페이지번호 


	$prev_page = $this->page - 1; // 이전페이지 
	$next_page = $this->page + 1; // 다음페이지 
 
	$prev_block = $block - 1; // 이전블럭 
	$next_block = $block + 1; // 다음블럭 

	// 이전블럭을 블럭의 마지막으로 하려면... 
	$prev_block_page = $prev_block * $this->block_set; // 이전블럭 페이지번호 
	
	// 이전블럭을 블럭의 첫페이지로 하려면... 	
	
	$next_block_page = $next_block * $this->block_set - ($this->block_set - 1); // 다음블럭 페이지번호 

	
	$str_result="<ul>";
	if($prev_block >0){$str_result.="<li class='page page_start'><a href='./plan.php?page=1'>처음으로</a></li>";}
	if($prev_page >0 ){$str_result.="<li class='page page_prev'><a href='./plan.php??page=".$prev_page."'>이전</a></li>";}

	for($i=$first_page; $i<$last_page; $i++){
		if($i == $this->page) {
		$str_result .= '<li class="page current">' . $i . '</li>';
		} else {
		$str_result .= '<li class="page"><a href="./plan.php?page='.$i.'">' . $i . '</a></li>';
		}
	}
	if($next_page <= $total_page){$str_result.="<li class='page page_prev'><a href='./plan.php??page=".$next_page."'>다음</a></li>";}
	if($next_block<=$total_block){$str_result.="<li class='page page_start'><a href='./plan.php?page=".$total_page."'>마지막페이지</a></li>";}
	
	$paging .= '</ul>';

	$connect->close();
	return array ("result_block"=>$str_result,"result_article"=>$result);

	}

/*
	file upload
	return array uploaded_file[]
*/
	function image_FileUpload(){

		// $ROOT = dirname(__FILE__);
		// $ROOT = addslashes($ROOT);
		 //var_dump($ROOT);
		define('_BASE_DIR',dirname(__FILE__));
		$ROOT = addslashes(_BASE_DIR);
		$upload_dir=  "../../data";
		$files = $_FILES["upfile"];
		$count = count($files["name"]);

    		for($i=0; $i<$count; $i++){
		    $upfile_name[$i]=$files["name"][$i];
		    $upfile_tmp_name[$i]=$files["tmp_name"][$i];
		    $upfile_type[$i]=$files["type"][$i];
		    $upfile_size[$i]=$files["size"][$i];
		    $upfile_error[$i]=$files["error"][$i];

	   //	echo $upfile_name[$i];


		    $file=explode(".", $upfile_name[$i]);
		    $file_name=$file[0];
		    $file_ext=$file[1];

		    if(!$upfile_error[$i])
		    {
		      $new_file_name=date("/Y_m_d_H_i_s");
		      $new_file_name.="_".$i;
		      $copied_file_name[$i]=$new_file_name.".".$file_ext;
		      $uploaded_file[$i]=$upload_dir.$copied_file_name[$i];
		      
		      if($upfile_size[$i]>2512000){		        
		      	echo("
		        <script>alert('너무 큽니다. 당신의 야망이');history.go(-1);</script>
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
		      
		      move_uploaded_file($upfile_tmp_name[$i], $uploaded_file[$i]);// 이동할 파일 시작, 도착
		             
	      	}


		    }	

	  return $uploaded_file;
	}

	


}




