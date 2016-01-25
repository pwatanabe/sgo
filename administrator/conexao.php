<?php 
	$conn = mysql_connect("localhost","root","") or print(mysql_error());
	mysql_select_db("bd_control_ponto");
	mysql_query("SET NAMES 'utf8'");
	mysql_query('SET character_set_connection=utf8');
	mysql_query('SET character_set_client=utf8');
	mysql_query('SET character_set_results=utf8');
	return $conn;
 ?>