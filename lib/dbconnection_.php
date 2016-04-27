<meta charset="utf-8">
<?php

	
	//new version
	$connect=mysqli_connect("localhost", "terra", "terra123","terra") or die("SQL server에 연결할 수 없습니다.");

	mysqli_query ( $connect, "set names utf8" );


	mysqli_query($connect,"set session character_set_connection=utf8;");
	mysqli_query($connect,"set session character_set_results=utf8;");
	mysqli_query($connect,"set session character_set_client=utf8;");
/*	mysqli_query("SET NAMES 'utf8'");

	
	//old version
	
	$connect=mysql_connect("localhost", "root", "apmsetup") or die("SQL server에 연결할 수 없습니다.");

	if (!$link) {
	    die('Not connected : ' . mysql_error());
	}

	// make foo the current db
	$db_selected = mysql_select_db('terra', $link);
	if (!$db_selected) {
	    die ('Can\'t use foo : ' . mysql_error());
	}
*/






/*
class TopicData{
	protected $connection;

	public function connect(){
		$this->connection = new PDO("mysql:host=localhost;dbname=terra","root","apmsetup");
	}


	/*
		$table = Database table
		$column_name = column name
		$num = index number

	public function getOneTopic($table,$column_name, $num){
		$query = $this->connection->prepare("select * from ".$table."where ".$column_name . "=".$num);
	}
}

	*/



?>