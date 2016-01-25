<?php 
header('Content-Type: text/html; charset=utf-8');

class Sql{
	public $conn;

	public function conn_bd(){
		$this->conn = mysql_connect("localhost","root","") or print(mysql_error());
		mysql_select_db("bd_viacampus");
		mysql_query("SET NAMES 'utf8'");
		mysql_query('SET character_set_connection=utf8');
		mysql_query('SET character_set_client=utf8');
		mysql_query('SET character_set_results=utf8');
		
	}
	public function close_conn(){
		mysql_close($this->conn) or print(mysql_error());
	}
}
?>