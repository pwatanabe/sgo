<?php 
	
class Obra_veiculos{
	public $id;
	public $id_obra;
	public $id_veiculo;

	public function add_veiculo($id_obra, $id_veiculo){
		
		
		$obra_veiculos = new Obra_veiculos();
		$obra_veiculos->id_obra = $id_obra;
		$obra_veiculos->id_veiculo = $id_veiculo;
		
		return $obra_veiculos;

		
	}

	public function add_veiculo_bd(){
		
		$query = "INSERT INTO obra_veiculos ";
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

	public function get_veiculos($id_obra){
		$sql = new Sql();
		$sql->conn_bd();

		$query = "SELECT * FROM obra_veiculos WHERE id_obra = $id_obra";

		$result = mysql_query($query);
		$return = array();
		$aux = 0;
		
		while($row = mysql_fetch_array($result)){
			//tipo:id:quantidade
			$return[$aux] = '2:'.$row['id_veiculo'].':1';
			$aux++;
		}

		return $return;

	}

}

 ?>