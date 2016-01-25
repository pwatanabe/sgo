<?php 
include_once("class_sql.php");
require_once(dirname(__FILE__) . "/../global.php");

class CboXexames{

	public $id;
	public $id_cbo;
	public $id_exame;
	
	public function add_cbo_x_exames($array_id_exames, $id_cbo){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = "INSERT INTO cbo_exames (id_cbo, id_exame) VALUES ('%s','%s')";
		for ($i=0; $i < count($array_id_exames) ; $i++) { 
			$g->tratar_query($query, $id_cbo, $array_id_exames[$i]);	
		}

	}
	public function atualiza_cbo_x_exames($id_cbo, $array_id_exames){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		
		mysql_query("DELETE FROM cbo_exames WHERE id_cbo = ".$id_cbo);
	
		$this->add_cbo_x_exames($array_id_exames, $id_cbo);

	}


}


?>