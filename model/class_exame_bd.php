<?php 
         
include_once("class_sql.php");
include_once("class_turno_bd.php");
include_once("class_periodicidade_bd.php");

require_once(dirname(__FILE__) . "/../global.php");

class Exame{
	public $id;
	public $descricao;
	public $id_periodicidade;
	public $id_empresa;
	
	public function add_exame($descricao, $id_periodicidade, $id_empresa){
		$this->descricao = $descricao;
		$this->id_periodicidade = $id_periodicidade;
		$this->id_empresa = $id_empresa;
	}

	public function add_exame_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO exames (descricao, id_periodicidade,id_empresa) VALUES ('%s','%s','%s')";
		return $g->tratar_query($query, $this->descricao, $this->id_periodicidade, $this->id_empresa);
	}
	public function get_exame_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM exames WHERE id = '%s' && id_empresa = ".$_SESSION['id_empresa']." && oculto = 0";
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
            echo 'Nenhum exame encontrado';
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$this->id = $row['id'];
	     	$this->descricao = $row['descricao'];
	     	$this->id_periodicidade = $row['id_periodicidade'];

	     	return $this;
	     }
	}

	public function atualiza_exame($descricao, $id_periodicidade, $id){
		$sql = new Sql();	
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE exames SET descricao = '%s', id_periodicidade='%s' WHERE id = '%s' ";

		return $g->tratar_query($query, $descricao, $id_periodicidade, $id);
	}

	public function ocultar(){
		$sql = new Sql();	
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE exames SET oculto = '1' WHERE id = '%s'";

		return $g->tratar_query($query, $this->id);
	}
	public function ocultar_by_id($id){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE exames SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $id);
		if($result){
			echo '<div class="msg">Exame excluido com sucesso!</div>';
		}
	}
	public function get_exame_by_desc($desc){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$return = array();
		$q = "SELECT * FROM exames WHERE descricao LIKE '%%%s%%' && oculto = 0 && id_empresa = '".$_SESSION['id_empresa']."' ORDER BY descricao";
		$query = $g->tratar_query($q, $desc);
		$aux = 0;
		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['descricao'];
			$return[$aux][2] = $result['id_periodicidade'];

			$aux++;
		}
		if($aux == 0){
			echo '<div class="msg">Nenhum registro encontrado</div>';
		}
		return $return;

	}
	public function get_name_all_exames(){
		$sql = new Sql();
		$sql->conn_bd();
		$aux=0;
		$query = mysql_query("SELECT * FROM exames WHERE id_empresa = ".$_SESSION['id_empresa']." && oculto = 0");
		$return = array();
		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['descricao'];
			$aux++;
		}
		return $return;
	}
	
	public function printExames(){
		$periodiciade = new Periodicidade();
		$periodiciade = $periodiciade->get_periodiciade_id($this->id_periodicidade);
		
		echo "<table class='table_pesquisa'>";
		echo "<tr><td><span>Descrição: </span></td><td><span>".$this->descricao."</span></td></tr>";
		echo "<tr><td><span>Periodiciade: </span></td><td><span>".$periodiciade->periodo."</span></td></tr>";
		echo "</table>";

	}

}

 ?>