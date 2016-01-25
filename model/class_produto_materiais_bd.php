<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class ProdutosMateriais{

	public $id;
	public $id_material;
	public $id_produto;
	public $quantidade;


	public function add_produtos_materiais($id_produto, $id_material, $quantidade)
	{		
		$produtosMateriais = new ProdutosMateriais();
		$produtosMateriais->id_material = $id_material;
		$produtosMateriais->id_produto = $id_produto;
		$produtosMateriais->quantidade = $quantidade;
		return $produtosMateriais;
	}

	public function add_produtos_materiais_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO produto_materiais(id_produto, id_material, quantidade) VALUES ('%s','%s','%s')";

		$result = $g->tratar_query($query, $this->id_produto, $this->id_material, $this->quantidade); //inserindo no banco de dados

		 
		 if(!$result){
            $sql->close_conn();
            return false;
	     }else{
	     	$sql->close_conn();
	     	return true;
	     }
	}
	public function limpa_materiais_produto($id_produto){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "DELETE FROM produto_materiais WHERE id_produto = '%s'";
		$result = $g->tratar_query($query,$id_produto);

	}

	

}
 ?>