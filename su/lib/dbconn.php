<?php

	$connect=mysql_connect("localhost", "terra", "terra123") or die("SQL server에 연결할 수 없습니다.");

	mysql_query("set session character_set_connection=utf8;");
	mysql_query("set session character_set_results=utf8;");
	mysql_query("set session character_set_client=utf8;");
	mysql_query("SET NAMES 'utf8'");

	mysql_select_db("terra",$connect);
?>