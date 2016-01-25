<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Valor_custo{
	public $id;
	public $valor;
    public $id_tipo_custo;
      
	public function add_valor_custo($valor, $id_tipo_custo)
	{		
		$this->valor = $valor;
                $this->id_tipo_custo = $id_tipo_custo;
	}

	public function add_valor_custo_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "INSERT INTO valor_custo (valor, id_tipo_custo) VALUES ('%s', '%s')";

		$result = $g->tratar_query($query, $this->valor, $this->id_tipo_custo); //inserindo no banco de dados
		
		$query = "SELECT * FROM valor_custo order by id desc";
		$result = $g->tratar_query($query); //pegando id da ultima insersão
		 
		 if(@mysql_num_rows($result) == 0){
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$id = $row['id'];
                $id_tipo_custo = $row['id_tipo_custo'];
                $valor = $row['valor'];
	     	return $id;
	     }
	}


	 public function atualiza_valor_custo($valor, $id_tipo_custo, $id){
             
			$sql = new Sql();	
			$sql->conn_bd();
			$g = new Glob();

	        $query = "UPDATE valor_custo SET oculto = 1 WHERE id = $id ";                
			mysql_query($query);               
	        
	        $query = "INSERT INTO valor_custo (valor, id_tipo_custo) VALUES ($valor, $id_tipo_custo)";
	        mysql_query($query); 
	                
	        $query = "SELECT id FROM valor_custo order by id desc";
			$result = mysql_query($query); 
	        
	        $return  = @mysql_fetch_array($result);
	                 
	        $id = $return['id'];
                                      
            return $id;
                     
                
	}
	
	public function get_valor_custo_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM valor_custo WHERE id= '%s'";
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
     
            return false;            
	     }else{
	     	$valor_custo = new Valor_custo();
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$valor_custo->id = $row['id'];
	     	$valor_custo->valor = $row['valor'];  
                $valor_custo->id_tipo_custo = $row['id_tipo_custo'];

	     	return $valor_custo;
	     }

	}
	public function get_all_valor_custo(){
		$sql = new Sql();
		$sql->conn_bd();
		$aux=0;
		$query = mysql_query("SELECT * FROM valor_custo");

		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['valor_custo'];
                        $return[$aux][2] = $result['id_tipo_custo'];
			$aux++;
		}
		return $return;
	}
}
	
 ?>