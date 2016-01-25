<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Cidade{
	public $id;
	public $nome;
	public $estado;

	public function get_name_all_city(){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $return = array(array());
		 $aux=0;

		 $query = mysql_query("SELECT * FROM cidade");
		 
		 while($result =  mysql_fetch_array($query)){
		 	$return[$aux][0] = $result['id'];
		 	$return[$aux][1] = $result['descricao'];
		 	$aux++;
		 }
		 
		 return $return;
	}

	public function get_city_by_id($id_cidade){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("SELECT * FROM cidade WHERE id = %d", $id_cidade);

		if(@mysql_num_rows($query) == 0){
			return false;
		}else{
			$row = mysql_fetch_array($query, MYSQL_ASSOC);
			$this->id = $row['id'];
			$this->nome = $row['nome'];
			$this->estado = $row['estado'];
		}
		return $this;
	}
	public function get_name_city_by_id($id_cidade){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("SELECT nome FROM cidade WHERE id = %d", $id_cidade);

		if(@mysql_num_rows($query) == 0){
			return false;
		}else{
			$row = mysql_fetch_array($query, MYSQL_ASSOC);
			$nome = $row['nome'];

		}
		return $nome;
	}
	public function get_city_by_nome($nome){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("SELECT * FROM cidade WHERE nome = %s", $nome);

		if(@mysql_num_rows($query) == 0){
			return false;
		}else{
			$row = mysql_fetch_array($query, MYSQL_ASSOC);
			$this->id = $row['id'];
			$this->nome = $row['nome'];
			$this->estado = $row['estado'];		
		}
		return $this;
	}
	

}
	
 ?>