<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class ProdutosMateriais{

	public $id;
	public $id_material;
	public $id_produto;
	public $quantidade;


	public function add_produtos_materiais( $id_produto, $id_material, $quantidade)
	{		
		
		$this->id_material = $id_material;
		$this->id_produto = $id_produto;
		$this->$quantidade = $quantidade;
	}

	public function add_produtos_materiais_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO produtos_materiais (id_material, id_produto, quantidade) VALUES ('%s','%s','%s')";

		$result = $g->tratar_query($query, $this->id_material, $this->id_produto, $this->$quantidade); //inserindo no banco de dados
		
		$query = "SELECT * FROM produtos_materiais ORDER BY id DESC";
		$result = $g->tratar_query($query); //pegando id da ultima insersão
		 
		 if(@mysql_num_rows($result) == 0){
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$id = $row['id'];
	     	return $id;
	     }
	}

	

}
 ?>