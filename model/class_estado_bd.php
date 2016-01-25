<?php

include_once("class_sql.php");
include_once("../global.php");

class Estado{

	public $id;
	public $nome;
	public $uf;
	public $pais;

	public function get_name_all_uf(){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $return = array(array());
		 $aux=0;

		 $query = mysql_query("SELECT * FROM estado");
		 
		 while($result =  mysql_fetch_array($query)){
		 	$return[$aux][0] = $result['id'];
		 	$return[$aux][1] = $result['uf'];
		 	$aux++;
		 }
		 
		 return $return;
	}

	public function get_estado_by_id($id_estado){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("SELECT * FROM estado WHERE id = %d", $id_estado);

		if(@mysql_num_rows($query) == 0){
			return false;
		}else{
			$row = mysql_fetch_array($query, MYSQL_ASSOC);
			$this->id = $row['id'];
			$this->nome = $row['nome'];
			$this->uf = $row['uf'];
			$this->pais = $row['pais'];
		}
		return $this;
	}

	public function get_name_estado_by_id($id_estado){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("SELECT nome FROM estado WHERE id = %d", $id_estado);

		if(@mysql_num_rows($query) == 0){
			return false;
		}else{
			$row = mysql_fetch_array($query, MYSQL_ASSOC);
			
			$nome = $row['nome'];
			
		}
		return $nome;
	}

	public function get_uf_estado_by_id($id_estado){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("SELECT uf FROM estado WHERE id = %d", $id_estado);

		if(@mysql_num_rows($query) == 0){
			return false;
		}else{
			$row = mysql_fetch_array($query, MYSQL_ASSOC);
			
			$uf = $row['uf'];
			
		}
		return $uf;
	}
}
	
 ?>