<?php

include_once("class_sql.php");
require_once(dirname(__FILE__) . "/../global.php");

class ObsSupervisor{
	public $id;
	public $id_supervisor;
	public $observacao;

	public function add_obs($id_supervisor, $observacao){
		$this->id_supervisor = $id_supervisor;
		$this->observacao = $observacao;
	}
	public function add_obs_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = "INSERT INTO obs_supervisor (id_supervisor, observacao) VALUES ('%s','%s')";

		if($g->tratar_query($query, $this->id_supervisor, $this->observacao))
			
		$result = mysql_query("SELECT * FROM obs_supervisor ORDER BY id DESC");
		$row = mysql_fetch_array($result, MYSQL_ASSOC);

		return $row['id'];

	}
}
	
 ?>