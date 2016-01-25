<?php 
         
include_once("class_sql.php");
include_once("class_turno_bd.php");
include_once("class_endereco_bd.php");
include_once("class_cidade_bd.php");
require_once(dirname(__FILE__) . "/../global.php");

class Filial{
	public $id;
	public $nome;
	// public $cnpj;
	public $cod_posto;
	public $telefone;
	public $id_endereco;
	public $id_responsavel;
	public $id_empresa;
	
	public function add_filial($nome, $cod_posto, $telefone, $id_endereco, $id_responsavel, $id_empresa){
			$this->nome = $nome;
			// $this->cnpj = $cnpj;
			$this->cod_posto = $cod_posto;
			$this->telefone = $telefone;
			$this->id_endereco = $id_endereco;
			$this->id_responsavel = $id_responsavel;
			$this->id_empresa = $id_empresa;
	}
	public function add_filial_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO filiais (nome, cod_posto, telefone, id_endereco, id_responsavel, id_empresa) VALUES ( '%s', '%s', '%s', '%s', '%s', '%s')";
		
		if($g->tratar_query($query, $this->nome,  $this->cod_posto, $this->telefone, $this->id_endereco, $this->id_responsavel, $this->id_empresa)){
			return true;
		}else{
			return false;
		}
	}
	
	public function atualiza_filial($id, $nome,  $cod_posto, $telefone, $id_endereco, $id_responsavel, $id_empresa){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = "UPDATE filiais SET nome = '%s',  cod_posto = '%s', telefone = '%s', id_endereco = '%s', id_responsavel = '%s', id_empresa = '%s' WHERE id =  '%s'";

		if($g->tratar_query($query, $nome,  $cod_posto, $telefone, $id_endereco, $id_responsavel, $id_empresa, $id)){
			return true;
		}else{
			return false;
		}
	}

	public function get_filial_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM filiais WHERE id = '%s'";

		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$filial = new Filial();
	     	$filial->id = $row['id'];
	     	$filial->nome = $row['nome'];
	     	$filial->cod_posto = $row['cod_posto'];
	     	$filial->telefone = $row['telefone'];
	     	$filial->id_endereco = $row['id_endereco'];
	     	$filial->id_responsavel = $row['id_responsavel'];
	     	$filial->id_empresa = $row['id_empresa'];
	     	
	     	return $filial;
	     }
	}
	public function get_filial_by_cnpj_and_nome($nome){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$return = array();
		$aux=0;
		$query = $g->tratar_query("SELECT * FROM filiais WHERE oculto = 0 && nome LIKE '%%%s%%'", $nome);

		while($result =  mysql_fetch_array($query)){
		 	$return[$aux][0] = $result['id'];
		 	$return[$aux][1] = $result['nome'];
		    $return[$aux][2] = $result['cod_posto'];
		 	$aux++;
		 }
		 if ($aux ==0){		 	
			echo '<div class="msg">Posto não encontrado !</div>';		
		 }
		else{
			 return $return;
			
		}
	}
	public function get_name_all_filial(){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $return = array(array());
		 $aux=0;

		 $query = mysql_query("SELECT * FROM filiais");
		 
		 while($result =  mysql_fetch_array($query)){
		 	$return[$aux][0] = $result['id'];
		 	$return[$aux][1] = $result['nome'];
		 	$aux++;
		 }
		 
		 return $return;
	}

	public function get_filial_by_empresa($id_empresa){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux = 0;
		$return = array();
		$query = "SELECT * FROM filiais WHERE id_empresa = %s";
		$query = $g->tratar_query($query, $id_empresa);

		while($result = mysql_fetch_array($query)){
			
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['cod_posto'];
			$return[$aux][2] = $result['nome'];
			$return[$aux][3] = $result['id_responsavel'];
			$aux++;
		}
		return $return;
	}

	public function ocultar_by_id($id){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE filiais SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $id);
		if($result){
			return true;
		}
	}

	public function printFilial(){
		$endereco = new Endereco();
		$endereco = $endereco->get_endereco_id($this->id_endereco);
		$cidade = new Cidade();
        $cidade = $cidade->get_city_by_id($endereco->id_cidade);
		echo "<table class='table_pesquisa'>";
		echo "<tr><td><span>Nome: </span></td><td><span>".$this->nome."</span></td></tr>";
		echo "<tr><td><span>Telefone: </span></td><td><span>".$this->telefone."</span></td></tr>";
		echo "<tr><td><span>Codigo do posto: </span></td><td><span>".$this->cod_posto."</span></td></tr>";
		echo "<tr><td><span>Rua: </span></td><td><span>".$endereco->rua."</span></td></tr>";
		echo "<tr><td><span>Bairro: </span></td><td><span>".$endereco->bairro."</span></td></tr>";
		echo "<tr><td><span>Cidade: </span></td><td><span>".$cidade->nome."</span></td></tr>";
		echo "</table>";
	}
	
	
}

 ?>