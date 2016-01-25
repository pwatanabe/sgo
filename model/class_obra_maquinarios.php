<?php 
	
class Obra_maquinarios{
	public $id;
	public $id_obra;
	public $id_maquinario;

	public function add_maquinario($id_obra, $id_maquinario){
		
		
		$obra_maquinarios = new Obra_maquinarios();
		$obra_maquinarios->id_obra = $id_obra;
		$obra_maquinarios->id_maquinario = $id_maquinario;
		
		return $obra_maquinarios;

		
	}

	public function add_maquinario_bd(){

		$query = "INSERT INTO obra_maquinarios ";
 		$campos = '(';
 		foreach ($this as $key => $value) {
 			if(!empty($value))
 				$campos .= "$key, ";
 		}
 		$campos = substr($campos, 0 ,-2);
 		$campos .= ')';
		$valores = ' VALUES (';
 		
 		foreach ($this as $key => $value) {
 			$replace = array("'",'*','==', '<', '>', '||','/','\\');
 			$value = str_replace($replace, '', $value);
 			if(!empty($value)){
 				$valores .= "'$value', ";
 			}
 		}
 		$valores = substr($valores, 0 ,-2);
 		$valores .= ') ';
		
		$sql = new Sql();
		$sql->conn_bd();
				

 		if(mysql_query($query.$campos.$valores) or print (mysql_error()))
 			return true;

 		return false;

	}

	public function get_maquinarios_obra($id_obra){
		$sql = new Sql();
		$sql->conn_bd();

		$query = "SELECT * FROM obra_maquinarios WHERE id_obra = $id_obra";

		$result = mysql_query($query);
		$return = array();
		$aux = 0;
		
		while($row = mysql_fetch_array($result)){
			//tipo:id:quantidade
			$return[$aux] = '1:'.$row['id_maquinario'].':1';
			$aux++;
		}

		return $return;

	}

}

 ?>