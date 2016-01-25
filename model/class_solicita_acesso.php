<?php
include_once("class_sql.php");
require_once(dirname(__FILE__) . "/../global.php");

class Solicita_acesso{

	public $id;
	public $mac;
	public $nome;
	public $telefone;
	public $descricao;
	public $empresa;


	function add_solicitacao($mac, $nome, $telefone, $descricao, $empresa){
		$this->mac = $mac;
		$this->nome = $nome;
		$this->telefone = $telefone;
		$this->descricao = $descricao;
		$this->empresa = $empresa;
	}

	function add_solicitacao_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = $g->tratar_query("INSERT INTO solicitacoes_acesso (mac, nome, telefone, descricao, empresa) VALUES 
			('%s','%s','%s','%s','%s')", $this->mac, $this->nome, $this->telefone, $this->descricao, $this->empresa);

		if($query){
			return true;
		}

		return false;
	}

	public function get_sol_acesso_id($id){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();


		$return = array();

		$query = "SELECT * FROM solicitacoes_acesso WHERE id = '".$id."'";

		$query_ex = mysql_query($query);
		
		$result =  mysql_fetch_array($query_ex);
		
		
		$return[0] = $result['id'];
		$return[1] = $result['mac'];
		$return[2] = $result['nome'];
		$return[3] = $result['telefone'];
		$return[4] = $result['descricao'];
		$return[5] = $result['empresa'];
		
		
		return $return;	
			
		
		
	}

	public function excluir($id){
		$sql = new Sql();
		$sql->conn_bd();

		$query = "DELETE FROM solicitacoes_acesso WHERE id = ".$id;

		if(mysql_query($query)){
			return true;
		}else{
			return false;
		}

	}

	public function permitir_acesso($id_solicitacao, $mac, $descricao){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = 'UPDATE solicitacoes_acesso SET mac = "'.strtoupper($mac).'", permitido = 1 WHERE id = "'.$id_solicitacao.'"';

		if(mysql_query($query)){
			$querytwo = 'INSERT INTO mac_validos (descricao, mac, status_mac) VALUES ("'.$descricao.'","'.strtoupper($mac).'","0")';
			
			if(mysql_query($querytwo)){
				return true;
			}
		}

		return false;
	}

	public function get_solicitacoes(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$aux=0;
		$return = array();
		$query = "SELECT * FROM solicitacoes_acesso WHERE permitido = 0";

		$query_ex = mysql_query($query);
		
		while($result =  mysql_fetch_array($query_ex) ){
			// echo '<script> alert("'.$query.'") </script>';
			
			
				$return[$aux][0] = $result['id'];
				$return[$aux][1] = $result['mac'];
				$return[$aux][2] = $result['nome'];
				$return[$aux][3] = $result['telefone'];
				$return[$aux][4] = $result['descricao'];
				$return[$aux][5] = $result['empresa'];
				
				$aux++;
			
			
		}
		return $return;
	}

}

?>