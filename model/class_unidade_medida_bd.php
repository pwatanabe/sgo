<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Unidade_medida{
	public $id;
	public $nome;
	public $grandeza;
	public $sigla;

	


	public function add_unidade_medida($nome,$grandeza,$sigla)
	{		
		$this->nome = $nome;	
		$this->grandeza = $grandeza;
		$this->sigla = $sigla;
                return true;
	}
        public function add_unidade_medida_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO unidade_medida (nome, grandeza, sigla) VALUES ('%s','%s','%s')";

		$result = $g->tratar_query($query, $this->nome, $this->grandeza, $this->sigla); //inserindo no banco de dados
		
		$query = "SELECT * FROM unidade_medida order by id desc";
		$result = $g->tratar_query($query); //pegando id da ultima insersão
		 
		 if(@mysql_num_rows($result) == 0){
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$id = $row['id'];
	     	return $id;
	     }
	}
	

	public function get_all_unidade_medida(){
		$sql = new Sql();
		$sql->conn_bd();
		$aux=0;
		$query = mysql_query("SELECT * FROM unidade_medida WHERE oculto = '0'");

		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$return[$aux][2] = $result['sigla'];
                        $return[$aux][3] = $result['grandeza'];
			$aux++;
		}
		return $return;
	}
         
         
        public function get_unidade_medida_by_nome($nome){
             $sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM unidade_medida WHERE oculto = '0' && nome LIKE '%%%s%%'";
		$query_tra = $g->tratar_query($query, $nome);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$return[$aux][2] = $result['sigla'];
                        $return[$aux][3] = $result['grandeza'];
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum  encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
	}
        
        public function atualiza_unidade_medida($nome, $grandeza, $sigla,$id){
       $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();

        $query = "UPDATE unidade_medida SET nome = '%s', grandeza = '%s', sigla ='%s' WHERE id = '%s'";

        if($g->tratar_query($query, $nome, $grandeza, $sigla, $id)){
            return true;
            }else{
          return false;
             }
         }
    
        public function get_unidade_medida_by_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM unidade_medida WHERE id = '%s'";
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
            echo 'Nenhum insumo encontrado';
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$this->id= $row['id'];
	     	$this->nome= $row['nome'];
		$this->sigla= $row['sigla'];
	     	return $this;
	     }
	}
        
        public function ocultar_unidade_medida($id){
            $sql = new Sql();
            $sql->conn_bd();
            $g = new Glob();
            $query = "UPDATE unidade_medida SET oculto = 1 WHERE id = '%s'";
            $result = $g->tratar_query($query, $id);
            
        }

	}
 ?>