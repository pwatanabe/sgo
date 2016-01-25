<?php 
         
include_once("class_sql.php");
include_once("class_turno_bd.php");
require_once(dirname(__FILE__) . "/../global.php");

class Periodicidade{
	public $id;
	public $periodo;
	
	public function get_name_all_periodo(){
		$sql = new Sql();
		$sql->conn_bd();
		$aux=0;
		$query = mysql_query("SELECT * FROM periodicidade");

		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['periodo'];
			$aux++;
		}
		return $return;
	}
	public function get_periodiciade_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM periodicidade WHERE id= '%s'";
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
     
            return false;            
	     }else{

	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$this->id = $row['id'];
	     	$this->periodo = $row['periodo'];
	     

	     	return $this;
	     }

	}
	
}

 ?>