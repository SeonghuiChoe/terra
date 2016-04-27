<?php
	define('_BASE_DIR',dirname(__FILE__));		// 서비스 현재폴더 루트  절대경로
	include _BASE_DIR."/lib/dbconn.php";

	//절대경로를 URL로 바꿔준다 이거한다고 하루를 꼬박 날려버림 ㅜㅜ (img src,a href 에 활용)
	$dirname=str_replace( $_SERVER[DOCUMENT_ROOT], '' ,str_replace('\\','/', dirname(__FILE__)) ); 
	$cfg[url] = 'http://' .$_SERVER[HTTP_HOST]. $dirname;

	//세션에 저장되어 있는 $this_page를 $pre_page 변수에 저장하고 현재 페이지를 $this_page 세션에 저장
	session_start();
	$pre_page=$_SESSION['this_page'];
	unset($_SESSION['this_page']);
	//흐미 mysql 5.4이상부터는 session_unregister 안먹힘...주의 바람
	

	if($_SERVER['QUERY_STRING']){
		$this_page=urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?".$_SERVER['QUERY_STRING']);
	}else{
	$this_page=urlencode("http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']);
	}
	$_SESSION["this_page"]=$this_page;
//값확인하고 싶을때
//echo " -pre- ".$pre_page."  -this- ".$this_page;




?>