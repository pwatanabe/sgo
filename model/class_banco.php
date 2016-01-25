<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Banco{

	public $id;
	public $banco;
	public $agencia;
	public $operacao;
	public $conta;


	public function get_banco_by_id($id_banco){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("SELECT * FROM dados_bancarios WHERE id = %d",$id_banco);

		if(@mysql_num_rows($query) == 0){
			return false;
		}else{
			$banco = new Banco();
			$row = mysql_fetch_array($query, MYSQL_ASSOC);
			$banco->id = $row['id'];
			$banco->banco = $row['banco'];
			$banco->agencia = $row['agencia'];
			$banco->operacao = $row['operacao'];
			$banco->conta = $row['conta'];
		}
		return $banco;
	}
	public function atualiza_banco($id_banco, $banco, $agencia, $operacao, $conta){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("UPDATE dados_bancarios SET banco = '%s', agencia = '%s', operacao = '%s', conta = '%s' WHERE id = %d",$banco, $agencia, $operacao, $conta,$id_banco);

		if($query){
			return true;
		}else{
			return false;
		}
		
	}
	public function verifica_banco($id_banco){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("SELECT * FROM dados_bancarios WHERE id = %d", $id_banco);

		if(@mysql_num_rows($query) == 0){
			return false;
		}
		
		return true;
		
		
	}
	public function add_banco($banco, $agencia, $operacao, $conta){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("INSERT INTO dados_bancarios (banco, agencia, operacao, conta) VALUES ('%s','%s','%s','%s')",$banco, $agencia, $operacao, $conta);

		if($query){
			$query = $g->tratar_query("SELECT * FROM dados_bancarios ORDER BY id DESC");

			$row = mysql_fetch_array($query, MYSQL_ASSOC);

			return $row['id'];
		}else{
			return false;
		}

	}

	

}
	
?>