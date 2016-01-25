<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Grupo{

	public $id;
	public $nome;
	public $descricao;


	public function add_grupo($nome, $descricao)
	{		
		$this->nome = $nome;
		$this->descricao = $descricao;
	}

	public function add_grupo_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO grupo (nome, descricao) VALUES ('%s','%s')";
		return $g->tratar_query($query, $this->nome, $this->descricao);
	}

	public function atualiza_grupo($nome, $descricao, $id){
		$sql = new Sql();	
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE grupo SET nome = '%s', descricao='%s' WHERE id = '%s' ";

		return $g->tratar_query($query, $nome, $descricao, $id);
	}

	public function ocultar_by_id($id){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE grupo SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $id);
		if($result){
			echo '<div class="msg">Grupo excluido com sucesso!</div>';
		}
	}

	 public function get_grupo_by_nome($nome){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $aux=0;
        $return = array();
        $query = $g->tratar_query("SELECT * FROM grupo WHERE oculto = 0 && nome LIKE '%%%s%%'",$nome);

        while($result = mysql_fetch_array($query)){
          $return[$aux][0] = $result['id'];
          $return[$aux][1] = $result['nome'];
          $return[$aux][2] = $result['descricao'];
          $aux++;
        }
        if($aux == 0){
          echo "<div class='msg'>Grupo não encontrada !</div>";
        }else{
        return $return;
        }
    }

	public function get_grupo_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM grupo WHERE id = '%s' && oculto=0";
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
            echo 'Nenhum grupo encontrado';
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$this->id = $row['id'];
	     	$this->descricao = $row['descricao'];
	     	$this->nome = $row['nome'];

	     	return $this;
	     }
	}

	public function get_name_all_grupo(){
		$sql = new Sql();
		$sql->conn_bd();
		$aux=0;
		$query = mysql_query("SELECT * FROM grupo WHERE oculto = 0");

		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$aux++;
		}
		return $return;
	}
	
	public function printGrupo(){
		$texto .= "Nome: ".$this->nome."<br />";
		$texto .= "Descricao: ".$this->descricao."<br />";
		
		return $texto;
	}


}
 ?>