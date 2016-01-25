<?php
include_once("../model/class_sql.php");
require_once("../global.php");

class Veiculo{

	public $id;
	public $matricula;
	public $chassi;
	public $renavam;
	public $placa;
	public $id_marca;
	public $modelo;
	public $ano;
	public $id_cor;
	public $valor;
        public $id_valor_custo;
	public $data_compra;
	public $seguro;	
	public $km_inicial;
	public $tipo_combustivel;
	public $id_empresa;
	public $id_fornecedor;
	public $id_responsavel;
	public $oculto;

	public function add_veiculo($matricula, $chassi, $renavam, $placa, $id_marca, $modelo, $ano, $id_cor, $valor, $id_valor_custo ,$data_compra, $seguro, $data_ini_seg, $data_fim_seg, $km_inicial, $tipo_combustivel, $id_empresa, $id_fornecedor, $id_responsavel){
			
			$this->matricula = $matricula;
			$this->chassi = $chassi;
			$this->renavam = $renavam;
			$this->placa = $placa;
			$this->id_marca = $id_marca;
			$this->modelo = $modelo;
			$this->ano = $ano;
			$this->id_cor = $id_cor;
			$this->valor = $valor;
                        $this->id_valor_custo = $id_valor_custo;
			$this->data_compra = $data_compra;
			$this->seguro = $seguro;			
			$this->km_inicial = $km_inicial;
			$this->tipo_combustivel = $tipo_combustivel;
			$this->id_empresa = $id_empresa;
			$this->id_fornecedor = $id_fornecedor;
			$this->id_responsavel= $id_responsavel;
			$this->data_ini_seg = $data_ini_seg;
			$this->data_fim_seg = $data_fim_seg;
	}

	public function add_veiculo_bd(){
			$sql = new Sql();
			$sql->conn_bd();
			$g = new Glob();
			$query = "INSERT INTO veiculo(matricula, chassi, renavam, placa, id_marca, modelo, ano, id_cor, valor, id_valor_custo, data_compra, seguro, data_ini_seg, data_fim_seg, km_inicial, tipo_combustivel, id_empresa, id_fornecedor, id_responsavel, controle)
									VALUES ('%s',	  '%s',	  '%s',   '%s',	'%s',	'%s',  '%s','%s','%s',  '%s',  	'%s',         '%s',		'%s',		'%s',			'%s',		'%s',			       '%s',    '%s',            '%s'	, '2')";
			if($g->tratar_query($query, $this->matricula, $this->chassi, $this->renavam, $this->placa, $this->id_marca, $this->modelo, $this->ano, $this->id_cor, $this->valor, $this->id_valor_custo, $this->data_compra, $this->seguro, $this->data_ini_seg, $this->data_fim_seg, $this->km_inicial, $this->tipo_combustivel, $this->id_empresa, $this->id_fornecedor, $this->id_responsavel)){
			return true; 
		}else{
			return false;
		} 
	}
	public function get_veiculo_nome($name){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM veiculo WHERE modelo LIKE '%%%s%%' &&  oculto = 0 && id_empresa=".$_SESSION['id_empresa'];
		$query_tra = $g->tratar_query($query, $name);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['matricula'];
			$return[$aux][2] = $result['modelo'];
			$return[$aux][3] = $result['id_marca'];
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum veículo encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
	}

	public function get_veiculo_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM veiculo WHERE id = '%s' && oculto =0 && id_empresa=".$_SESSION['id_empresa'];
		 $result = $g->tratar_query($query, $id);
		 $veiculo = new Veiculo();
		 if(@mysql_num_rows($result) == 0){
            echo 'Nenhum veículo encontrado';
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$veiculo->id= $row['id'];
	     	$veiculo->matricula= $row['matricula'];
			$veiculo->renavam= $row['renavam'];
			$veiculo->placa= $row['placa'];
			$veiculo->chassi= $row['chassi'];
			$veiculo->id_marca = $row['id_marca'];
			$veiculo->modelo=  $row['modelo'];
			$veiculo->id_cor= $row['id_cor'];
			$veiculo->ano= $row['ano'];
			$veiculo->tipo_combustivel= $row['tipo_combustivel'];
			$veiculo->data_compra = $row['data_compra'];
			$veiculo->valor = $row['valor'];
                        $veiculo->id_valor_custo = $row['id_valor_custo'];
			$veiculo->seguro= $row['seguro'];
			$veiculo->data_ini_seg = $row['data_ini_seg'];
			$veiculo->data_fim_seg = $row['data_fim_seg'];
			$veiculo->km_inicial= $row['km_inicial'];
			$veiculo->id_fornecedor= $row['id_fornecedor'];
			$veiculo->id_empresa= $row['id_empresa'];
			$veiculo->id_responsavel= $row['id_responsavel'];
                        
	     	
	     	return $veiculo;
	     }
	}	
	
	public function atualiza_veiculo($matricula, $chassi, $renavam, $placa, $id_marca, $modelo, $ano, $id_cor, $valor, $id_valor_custo ,$data_compra, $seguro, $data_ini_seg, $data_fim_seg, $km_inicial, $tipo_combustivel, $id_empresa, $id_fornecedor, $id_responsavel, $id){
		$sql = new Sql();	
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE veiculo SET matricula='%s', chassi='%s', renavam='%s', placa='%s', id_marca='%s', modelo='%s', ano='%s', id_cor='%s', valor='%s', id_valor_custo = '%s', data_compra='%s', seguro='%s', data_ini_seg='%s', data_fim_seg='%s', km_inicial='%s', tipo_combustivel='%s', id_empresa='%s', id_fornecedor='%s', id_responsavel='%s' WHERE id ='%s' ";

		$query_tra = $g->tratar_query($query, $matricula, $chassi, $renavam, $placa, $id_marca, $modelo, $ano, $id_cor, $valor, $id_valor_custo, $data_compra, $seguro, $data_ini_seg, $data_fim_seg, $km_inicial, $tipo_combustivel, $id_empresa, $id_fornecedor, $id_responsavel ,$id);
		
		if($query_tra){
			return $query_tra;
		}else{
			return false;
		}
		
	}

	public function ocultar_by_id($id){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE veiculo SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $id);
		if($result){
			echo '<div class="msg">veículo excluído com sucesso!</div>';
		}
	}
	
	public function get_veiculo_by_nome($modelo){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $aux=0;
        $return = array();
        $query = $g->tratar_query("SELECT * FROM veiculo WHERE oculto = 0 && modelo LIKE '%%%s%%'",$modelo);

        while($result = mysql_fetch_array($query)){
          $return[$aux][0] = $result['id'];
          $return[$aux][1] = $result['modelo'];
          
          $aux++;
        }
        if($aux == 0){
          echo "<div class='msg'>Veículo não encontrada !</div>";
        }else{
        return $return;
        }
    }
	// public function get_veiculo_chassi($chassi){
	// 		$sql = new Sql();
	//         $sql->conn_bd();
	//         $g = new Glob();
	//         $aux=0;
	//         $return = array();
	//         $query = $g->tratar_query("SELECT * FROM veiculo WHERE oculto = 0 && chassi LIKE '%%%s%%'",$chassi);

	//         while($result = mysql_fetch_array($query)){
	//           $return[$aux][0] = $result['matricula'];
	//           $return[$aux][1] = $result['chassi'];
	//           $return[$aux][2] = $result['modelo'];
	//           $return[$aux][3] = $result['id_marca'];
	//           $return[$aux][4] = $result['id_cor'];
	//           $aux++;
	//         }
	//         if($aux == 0){
	//           echo "<div class='msg'> nao encontrou veiculos !</div>";
	//         }else{
	//         return $return;
	//         }
	// 	}
	// public function get_all_veiculo(){
	// 	$sql = new Sql();
	// 	$sql = conn_bd();
	// 	$g = new Glob();
	// 	$query = "SELECT * FROM veiculo WHERE oculto = 0 and id_empresa='".$_SESSION['id_empresa']."'";

	// 	while($result = mysql_fetch_array($query)){
	//           $return[$aux][0] = $result['matricula'];	          
	//           $return[$aux][1] = $result['modelo'];
	//           $return[$aux][2] = $result['id_marca'];
	//           $return[$aux][3] = $result['id_cor'];
	//           $aux++;
	//         }
	//         if($aux == 0){
	//           echo "<div class='msg'>Nenhum veiculo cadastrado !</div>";
	//         }else{
	//         return $return;
	//         }
	// 	}

	// public function printVeiculo(/*$id_veiculo*/){
	// 	// $empresa = new Empresa();
	// 	// $empresa = $empresa->get_empresa_by_id($this->id_empresa);		
	// 	// $responsavel = new Funcionario();
 //  		// $responsavel = $responsavel->get_func_id($this->id_responsavel);
 //  		// $veiculo = new Veículo();
 //  		// $veiculo = $veiculo->get_veiculo_id($id_veiculo);
 //      	$texto = "";
	// 	$texto .= "<table class='table_pesquisa'><tr>";
	// 	$texto .= "<td colspan='2'><b><span>Matricula: <span></b></td><td colspan='2'><span><span>".$this->matricula."</span></td>";
	// 	$texto .= "</tr>";
	// 	$texto .= "<tr>";
	// 	$texto .= "<td colspan='2'><b><span>Modelo: <span></b></td><td><span>".$this->modelo."</span> <td><span>Cor: <span></b></td> <td><span>".$this->id_cor."</span></td></td>";
	// 	$texto .= "</tr>";
	// 	$texto .= "<tr>";
	// 	$texto .= "<td colspan='2'><b><span>Marca: <span></b></td><td><span><span>".$this->id_marca."</span> <td><span>Marca: <span></b></td> <td><span><span>".$this->id_marca."</span></td></td>";
	// 	$texto .= "</tr>";	
	// 	$texto .= "</table>";
	// 	return $texto;	}

}
 ?>