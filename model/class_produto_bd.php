<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Produto{

	public $id;
	public $nome;
	public $id_empresa;
	public $altura;
	public $largura;
	public $comprimento;
	public $tempo_estimado_conclusao;


	public function add_produtos($nome, $id_empresa, $altura, $largura, $comprimento, $tempo_estimado_conclusao)
	{		
		$this->nome = $nome;
		$this->id_empresa = $id_empresa;
		$this->altura = $altura;
		$this->largura = $largura;
		$this->comprimento = $comprimento;
		$this->tempo_estimado_conclusao = $tempo_estimado_conclusao;
	}

	public function add_produto_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO produtos (nome, id_empresa, altura, largura, comprimento, tempo_estimado_conclusao) VALUES ('%s','%s','%s','%s','%s','%s')";

		$result = $g->tratar_query($query, $this->nome, $this->id_empresa, $this->altura, $this->largura, $this->comprimento, $this->tempo_estimado_conclusao); //inserindo no banco de dados
		
		$query = "SELECT * FROM produtos order by id desc";
		$result = $g->tratar_query($query); //pegando id da ultima insersão
		 
		 if(@mysql_num_rows($result) == 0){
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$id = $row['id'];
	     	return $id;
	     }
	}
	public function atualiza_produto($nome, $id_produto, $altura, $largura, $comprimento, $tempo_estimado_conclusao){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE produtos SET nome = '%s', altura = '%s', largura = '%s', comprimento = '%s', tempo_estimado_conclusao = '%s' WHERE id = '%s'";

		$result = $g->tratar_query($query, $nome, $altura, $largura, $comprimento, $tempo_estimado_conclusao, $id_produto); //inserindo no banco de dados

	}
	public function get_produto_by_name($name){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM produtos WHERE id_empresa=".$_SESSION['id_empresa']." && nome LIKE '%%%s%%' ";
		$query_tra = $g->tratar_query($query, $name);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum produto encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
	}
	public function get_produto_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM produtos WHERE id = '%s' && id_empresa=".$_SESSION['id_empresa'];
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
            return false;            
	     }else{

	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$produto = new Produto();
	     	$produto->id = $row['id'];
	     	$produto->nome = $row['nome'];
            $produto->id_empresa = $row['id_empresa'];
            $produto->altura = $row['altura'];
            $produto->largura = $row['largura'];
            $produto->comprimento = $row['comprimento'];
            $produto->tempo_estimado_conclusao = $row['tempo_estimado_conclusao'];

	     	return $produto;
	     }

	}
	public function get_materiais_produto($id_produto){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM produto_materiais WHERE id_produto = '%s'";
		$query_tra = $g->tratar_query($query, $id_produto);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id_produto'];
			$return[$aux][1] = $result['id_material'];
			$return[$aux][2] = $result['quantidade'];
            $return[$aux][3] = $result['id'];
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			return false;
		}else{
			$sql->close_conn();
			return $return;
		}
	}

	public function get_valor_custo($id_produto){
		// calcular o valor custo baseado nos materiais vinculados ao produto
	}
	

}
 ?>