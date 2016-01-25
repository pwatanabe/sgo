<?php 
	
class Obra_patrimoniogerais{
	public $id;
	public $id_obra;
	public $id_patrimonioGeral;
	public $quantidade;

	public function add_patrimoniogeral($id_obra, $id_patrimonio, $quantidade){
		
		$obra_patrimoniogerais = new Obra_patrimoniogerais();
		$obra_patrimoniogerais->id_obra = $id_obra;
		$obra_patrimoniogerais->id_patrimonioGeral = $id_patrimonio;
		$obra_patrimoniogerais->quantidade = $quantidade;
		
		return $obra_patrimoniogerais;

	}

	public function add_patrimoniogeral_bd(){
		
		$query = "INSERT INTO obra_patrimoniogerais ";
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

	public function get_patrimoniosGerais($id_obra){
		$sql = new Sql();
		$sql->conn_bd();

		$query = "SELECT * FROM obra_patrimoniogerais WHERE id_obra = $id_obra";

		$result = mysql_query($query);
		$return = array();
		$aux = 0;
		
		while($row = mysql_fetch_array($result)){
			//tipo:id:quantidade
			$return[$aux] = '0:'.$row['id_patrimonioGeral'].':'.$row['quantidade'];
			$aux++;
		}

		return $return;

	}

}

 ?>