<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Cor{
	public $id;
	public $nome;
	


	public function add_cor($nome)
	{		
		$this->nome = $nome;		
	}

	public function add_cor_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO cores (nome) VALUES ('%s')";

		$result = $g->tratar_query($query, $this->nome); //inserindo no banco de dados
		
		$query = "SELECT * FROM cores order by id desc";
		$result = $g->tratar_query($query); //pegando id da ultima insersão
		 
		 if(@mysql_num_rows($result) == 0){
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$id = $row['id'];
	     	return $id;
	     }
	}


	 public function atualiza_cor($nome, $id){
		$sql = new Sql();	
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE cores SET nome = '%s' WHERE id = '%s' ";

		return $g->tratar_query($query, $nome, $id);
	}
	
	public function get_cor_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM cores WHERE id= '%s'";
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
     
            return false;            
	     }else{

	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$this->id = $row['id'];
	     	$this->nome = $row['nome'];          	

	     	return $this;
	     }

	}
	public function get_all_cor(){
		$sql = new Sql();
		$sql->conn_bd();
		$aux=0;
		$query = mysql_query("SELECT * FROM cores");

		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$aux++;
		}
		return $return;
	}
}
	
 ?>