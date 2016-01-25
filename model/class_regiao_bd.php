<?php
include_once("../model/class_sql.php");
require_once("../global.php");

class Regiao{
    public $id;
    public $codigo;
    public $nome;
    public $id_estado;
    public $id_cidade;
    public $bairro_zona;
    public $descricao;
    public $id_empresa;

    public function add_regiao($codigo, $nome, $id_estado, $id_cidade, $bairro_zona, $descricao, $id_empresa)
	{	
                $this->codigo = $codigo;
		$this->nome = $nome;
                $this->id_estado = $id_estado;
                $this->id_cidade = $id_cidade;
                $this->bairro_zona = $bairro_zona;
                $this->descricao = $descricao;
                $this->id_empresa = $id_empresa;
	}
    public function add_regiao_bd(){        
                $sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
               
                        
		$query = "INSERT INTO regiao_trabalho (codigo, nome, id_estado, id_cidade, bairro_zona, descricao, id_empresa) VALUES ('%s','%s','%s','%s','%s','%s','%s')";
               
                if($g->tratar_query($query, $this->codigo , $this->nome, $this->id_estado, $this->id_cidade, $this->bairro_zona, $this->descricao, $this->id_empresa)){
                   return true; 
                }else{
                    return false;
                    } 
        }
    public function atualiza_regiao($codigo, $nome, $id_estado, $id_cidade, $bairro_zona, $descricao){
		$sql = new Sql();	
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE regiao_trabalho SET nome = '%s', id_estado = '%s', id_cidade = '%s', bairro_zona = '%s', descricao = '%s' WHERE codigo = '%s' ";

		return $g->tratar_query($query, $nome, $id_estado, $id_cidade, $bairro_zona, $descricao, $codigo);
    }
    
    public function get_regiao_codigo($codigo){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM regiao_trabalho WHERE codigo = '%s' && id_empresa=".$_SESSION['id_empresa'];
		 $result = $g->tratar_query($query, $codigo);
		 
		 if(@mysql_num_rows($result) == 0){
     
            return false;            
	     }else{

	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$regiao = new Regiao();
            $regiao->id = $row['id'];
            $regiao->codigo = $row['codigo'];
			$regiao->nome = $row['nome'];
            $regiao->id_estado = $row['id_estado'];
            $regiao->id_cidade = $row['id_cidade'];
            $regiao->bairro_zona = $row['bairro_zona'];
            $regiao->descricao = $row['descricao'];
            $regiao->id_empresa = $row['id_empresa'];

	     	return $regiao;
	     }

	}

	public function get_name_regiao_by_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT nome FROM regiao_trabalho WHERE id = '%s' && id_empresa=".$_SESSION['id_empresa'];
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
     
            return false;            
	     }else{

	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	
	     	return $row['nome'];
	     }

	}

	public function get_cod_regiao_by_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT codigo FROM regiao_trabalho WHERE id = '%s' && id_empresa=".$_SESSION['id_empresa'];
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
     
            return false;            
	     }else{

	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	
	     	return $row['codigo'];
	     }

	}
    
    public function get_all_regiao(){
		$sql = new Sql();
		$sql->conn_bd();
		$aux=0;
		$query = mysql_query("SELECT * FROM regiao_trabalho WHERE oculto = 0 && id_empresa = '".$_SESSION['id_empresa']."'");
                $return = array();
		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['codigo'];
			$return[$aux][1] = $result['nome'];
			$return[$aux][2] = $result['id_estado'];
            $return[$aux][3] = $result['id_cidade'];
            $return[$aux][4] = $result['bairro_zona'];
            $return[$aux][5] = $result['descricao'];
            $return[$aux][6] = $result['id'];
			$aux++;
		}
		return $return;
    }
            
    public function ocultar_by_id($codigo){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE regiao_trabalho SET oculto = 1 WHERE codigo = '%s'";
		$result = $g->tratar_query($query, $codigo);
		if($result){
			echo '<div class="msg" id="msg">Você não atenderá mais está região !</div>';
		}
    }


}
    
?>

