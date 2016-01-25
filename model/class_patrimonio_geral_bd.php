<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Patrimonio_geral{
	public $id;
	public $nome;
	public $matricula;
	public $marca;
	public $descricao;
	public $quantidade;
	public $valor;
        public $id_valor_custo;
	public $id_empresa;
	public $oculto;

	
	
	public function add_patrimonio_geral($nome, $matricula, $marca, $descricao, $quantidade, $valor, $id_valor_custo, $id_empresa)
	{		
		
		$this->nome = $nome;
		$this->matricula = $matricula;
		$this->marca = $marca;
		$this->descricao = $descricao;
		$this->quantidade = $quantidade;
		$this->valor = $valor;
                $this->id_valor_custo = $id_valor_custo;
		$this->id_empresa = $id_empresa;

	}

	public function add_patrimonio_geral_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO patrimonio_geral (nome, matricula, marca, descricao, quantidade, valor, id_valor_custo, id_empresa, controle) 
                                        VALUES  	( '%s',  '%s',   '%s',   '%s',      '%s',	'%s',	'%s',           '%s',     '0')";

		if($g->tratar_query($query, $this->nome, $this->matricula, $this->marca, $this->descricao, $this->quantidade, $this->valor, $this->id_valor_custo, $this->id_empresa)){
				return true; 
		}else{
				return false;
		} 

	}
	
	public function get_patrimonio_geral_nome($name){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM patrimonio_geral WHERE nome LIKE '%%%s%%' &&  oculto = 0";
		$query_tra = $g->tratar_query($query, $name);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$return[$aux][2] = $result['descricao'];
			$return[$aux][3] = $result['controle'];
                        $return[$aux][4] = $result['matricula'];
                        
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			
		}else{
			$sql->close_conn();
			return $return;
		}
	}

	public function get_patrimonio_geral_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM patrimonio_geral WHERE id = '%s' && oculto =0";
		 $result = $g->tratar_query($query, $id);
		 $patrimonio = new Patrimonio_geral();
		 if(@mysql_num_rows($result) == 0){
            echo 'Nenhum patrimonio encontrado';
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$patrimonio->id= $row['id'];
	     	$patrimonio->nome= $row['nome'];
			$patrimonio->matricula= $row['matricula'];
			$patrimonio->marca= $row['marca'];
			$patrimonio->descricao= $row['descricao'];
			$patrimonio->quantidade= $row['quantidade'];
			$patrimonio->valor= $row['valor'];
                        $patrimonio->id_valor_custo= $row['id_valor_custo'];
			$patrimonio->id_empresa= $row['id_empresa'];
                        
	     	
	     	return $patrimonio;
	     }
	}

	public function atualiza_patrimonio_geral($nome, $matricula, $marca, $descricao, $quantidade, $valor, $id_valor_custo, $id_empresa, $id){
		$sql = new Sql();	
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE patrimonio_geral SET nome='%s', descricao='%s', marca='%s', descricao='%s', quantidade='%s', valor='%s', id_valor_custo = '%s', id_empresa='%s' WHERE id ='%s' ";

		$query_tra = $g->tratar_query($query, $nome, $matricula, $marca, $descricao, $quantidade, $valor, $id_valor_custo, $id_empresa, $id);
		
		if($query_tra){
			return $query_tra;
		}else{
			return false;
		}
		
	}

	public function ocultar_by_id($id){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE patrimonio_geral SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $id);
		if($result){
			echo '<div class="msg">Patrimonio excluido com sucesso!</div>';
		}
	}
//	public function get_patrimonio_geral_by_nome($nome){
//		$sql = new Sql();
//		$sql->conn_bd();
//		$g = new Glob();
//		$aux=0;
//		$return = array();
//		$query = $g->tratar_query("SELECT * FROM patrimonio_geral WHERE oculto = 0 && nome LIKE '%%%s%%'",$nome);
//
//		while($result = mysql_fetch_array($query)){
//		  $return[$aux][0] = $result['id'];
//		  $return[$aux][1] = $result['nome'];
//		  
//		  $aux++;
//		}
//		if($aux == 0){
//		  echo "<div class='msg'>Patrimonio não encontrado !</div>";
//		}else{
//		return $return;
//		}
//    }
}
	
 ?>