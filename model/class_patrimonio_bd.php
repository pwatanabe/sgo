<?php
require_once("../global.php");
include_once("../model/class_sql.php");
include_once("../model/class_empresa_bd.php");
include_once("../model/class_cliente.php");
include_once("../model/class_grupo_bd.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_maquinario_bd.php");
include_once("../model/class_veiculo_bd.php");
include_once("../model/class_cor_bd.php");
include_once("../model/class_marca_bd.php");
include_once("../model/class_patrimonio_geral_bd.php");

class Patrimonio{
//	public $id;
//	public $id_custo;
//	public $id_grupo;		
//	public $id_responsavel;
//	public $id_fornecedor;
//	public $id_empresa;	
//	public $valor_compra;
//	public $nome;
//	public $descricao;
//	public function add_patrimonio($id_custo, $id_grupo, $id_responsavel, $id_fornecedor, $id_empresa, $valor_compra, $nome, $descricao){
//		
//		$this->id_custo = $id_custo;
//		$this->id_grupo = $id_grupo;		
//		$this->id_responsavel = $id_responsavel;
//		$this->id_fornecedor = $id_fornecedor;
//		$this->id_empresa = $id_empresa;		
//		$this->valor_compra = $valor_compra;
//		$this->nome = $nome;
//		$this->descricao = $descricao;
//	}
//	
//	public function add_patrimonio_bd(){
//		$sql = new Sql();
//		$sql->conn_bd();
//		$g = new Glob();
//
//		$query = "INSERT INTO patrimonio (id_custo, id_grupo, id_responsavel, id_fornecedor, id_empresa, valor_compra, nome, descricao)
//									VALUES ( '%s',		'%s',	'%s',			'%s',			'%s',		'%s',	    '%s',	    '%s' )";
//
//		if($g->tratar_query($query, $this->id_custo, $this->id_grupo, $this->id_responsavel, $this->id_fornecedor, $this->id_empresa, $this->valor_compra, $this->nome, $this->descricao)){
//			return true; 
//		}else{
//			return false;
//		} 
//	}
        public function get_all(){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $aux=0;
        $return = array();
        $query = "SELECT id, modelo, fabricante, controle, matricula  FROM maquinario as e where id_empresa = '%s' union SELECT id, modelo, id_marca, controle, matricula FROM veiculo as f where id_empresa = '%s'" ;
        $query = $g->tratar_query($query,$_SESSION['id_empresa'],$_SESSION['id_empresa']);
        
        
        if(!$query){
        	echo "<div class='msg'>Patrimonio não encontrado !</div>";
        	return;
        }

        while($result = mysql_fetch_array($query)){
        		
	          $return[$aux][0] = $result['id'];
	          $return[$aux][1] = $result['modelo'];
	          $return[$aux][2] = $result['fabricante'];
	          $return[$aux][3] = $result['controle'];
	          $return[$aux][4] = $result['matricula'];
	          $aux++;
        }
       
        return $return;
        
    }
	public function get_all_patrimonio($modelo,$id_empresa){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $aux=0;
        $return = array();
        $query = "SELECT id, modelo, fabricante, controle, matricula  FROM maquinario as e where e.modelo like '%%%s%%' && id_empresa = '%s' union SELECT id, modelo, id_marca, controle, matricula FROM veiculo as f where f.modelo like '%%%s%%' && id_empresa = '%s'" ;
        $query = $g->tratar_query($query, $modelo, $id_empresa, $modelo, $id_empresa);
        $result = mysql_fetch_array($query);
        
        if(!$query){
        	echo "<div class='msg'>Patrimonio não encontrado !</div>";
        	return;
        }

        while($result = mysql_fetch_array($query)){
        		
	          $return[$aux][0] = $result['id'];
	          $return[$aux][1] = $result['modelo'];
	          $return[$aux][2] = $result['fabricante'];
	          $return[$aux][3] = $result['controle'];
	          $return[$aux][4] = $result['matricula'];
	          $aux++;
        }
       
        return $return;
        
    }
    public function get_name_patrimonio_id($id){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $aux=0;
        $return = array();
        $query = "SELECT id, modelo, fabricante, tipo  FROM maquinario as e where e.id = %d union SELECT id, modelo, id_marca, tipo FROM veiculo as f where f.id = %d";
        $query_tra = $g->tratar_query($query, $id, $id);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['modelo'];
			$return[$aux][2] = $result['tipo'];
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum patrimonio encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
        
    }
    public function get_patrimonio_nome($name){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM patrimonio WHERE nome LIKE '%%%s%%' &&  oculto = 0";
		$query_tra = $g->tratar_query($query, $name);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$return[$aux][2] = $result['id_fornecedor'];
                        
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum patrimonio encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
	}
    

	public function atualiza_patrimonio($nome, $descricao, $id_grupo, $id_fornecedor, $id_responsavel, $id_empresa, $id_custo, $valor_compra, $id){
		$sql = new Sql();	
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE patrimonio SET nome='%s', descricao='%s', id_grupo='%s', id_fornecedor='%s', id_responsavel='%s', id_empresa='%s', id_custo='%s', valor_compra='%s' WHERE id ='%s' ";

		$query_tra = $g->tratar_query($query, $nome, $descricao, $id_grupo, $id_fornecedor, $id_responsavel, $id_empresa, $id_custo, $valor_compra, $id);
		
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
		$query = "UPDATE patrimonio SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $id);
		if($result){
			echo '<div class="msg">Patrimonio excluido com sucesso!</div>';
		}
	}

	public function buscaPatrimonio($id, $controle){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT id, modelo, fabricante, controle FROM maquinario as e where e.id = '%s' && e.controle = '%s' union SELECT id, modelo, id_marca, controle FROM veiculo as f where f.id = '%s' && f.controle = '%s'";
		$query_tra = $g->tratar_query($query, $id, $controle, $id, $controle);

		$result =  mysql_fetch_array($query_tra);
			// print_r($result);
			$return[0] = $result['id'];
			$return[1] = $result['modelo'];
			$return[2] = $result['fabricante'];
			$return[3] = $result['controle'];
			
		
		
			return $return;
		
	}
	

	public function printPatrimonio($id, $controle){
		$patrimonio = new Patrimonio();

		$result=$patrimonio->buscaPatrimonio($id,$controle);

		if($result[3]== 2){

			$veiculo = new Veiculo();
			$veiculo = $veiculo->get_veiculo_id($id);
		
			$cliente = new CLiente();
			$cliente = $cliente->get_cli_by_id($veiculo->id_fornecedor);

			$func = new Funcionario();
                        $func = $func->get_nome_by_id($veiculo->id_responsavel); 

                        $empresa = new Empresa();
                        $empresa = $empresa->get_empresa_by_id($veiculo->id_empresa);

                        $cor = new Cor();
                        $cor = $cor->get_cor_id($veiculo->id_cor);

                        $marca = new Marca();
                        $marca = $marca->get_marca_id($veiculo->id_marca);
			
			echo "<table class='table_pesquisa'>";
			echo "<tr><td><span><b>Matricula <b/></span></td><td><span>".$veiculo->matricula."</span></td></tr>";
			echo "<tr><td><span><b>Chassi_Nserie <b/></span></td><td><span>".$veiculo->chassi."</span></td></tr>";
			echo "<tr><td><span><b>Modelo <b/></span></td><td><span>".$veiculo->modelo."</span></td></tr>";
			echo "<tr><td><span><b>Tipo Consumo <b/></span></td><td><span>".$veiculo->tipo_combustivel."</span></td></tr>";
			echo "<tr><td><span><b>Cor <b/></span></td><td><span>".$cor->nome."</span></td></tr>";
			echo "<tr><td><span><b>Fabricante <b/></span></td><td><span>".$marca->nome."</span></td></tr>";
			echo "<tr><td><span><b>Data de Compra <b/></span></td><td><span>".$veiculo->data_compra."</span></td></tr>";
			echo "<tr><td><span><b>Data inicio do seguro <b/></span></td><td><span>".$veiculo->data_ini_seg."</span></td></tr>";
			echo "<tr><td><span><b>Data Fim do seguro <b/></span></td><td><span>".$veiculo->data_fim_seg."</span></td></tr>";			
			echo "<tr><td><span><b>Responsável <b/></span></td><td><span>".$func[0]."</span></td></tr>";			
			echo "<tr><td><span><b>Forncedor <b/></span></td><td><span>".$cliente->nome_fornecedor."</span></td></tr>";
			echo "<tr><td><span><b>Empresa Responsável <b/></span></td><td><span>".$empresa->nome_fantasia."</span></td></tr>";			
		
			
			echo "VEÍCULO";
		}
	    if($result[3]==1){
	    	// $maquinario = array();

	    	$maquinario = new Maquinario();
			$maquinario = $maquinario->get_maquinario_id($id);
                            
			$cliente = new Cliente();
                        
			$fornecedor = $cliente->get_cli_by_id($maquinario->id_fornecedor);
                        
			$func = new Funcionario();
            $func = $func->get_nome_by_id($maquinario->id_responsavel); 

            $empresa = new Empresa();
            $empresa = $empresa->get_empresa_by_id($maquinario->id_empresa);

            $cor = new Cor();
            $cor = $cor->get_cor_id($maquinario->id_cor);
                        
			echo "<table class='table_pesquisa'>";
			echo "<tr><td><span><b>Matricula <b/></span></td><td><span>".$maquinario->matricula."</span></td></tr>";
			echo "<tr><td><span><b>Chassi_Nserie <b/></span></td><td><span>".$maquinario->chassi_nserie."</span></td></tr>";
			echo "<tr><td><span><b>Modelo <b/></span></td><td><span>".$maquinario->modelo."</span></td></tr>";
			echo "<tr><td><span><b>Tipo Consumo <b/></span></td><td><span>".$maquinario->tipo_consumo."</span></td></tr>";
			echo "<tr><td><span><b>Cor <b/></span></td><td><span>".$cor->nome."</span></td></tr>";
			echo "<tr><td><span><b>Fabricante <b/></span></td><td><span>".$maquinario->fabricante."</span></td></tr>";
			echo "<tr><td><span><b>Data de Compra <b/></span></td><td><span>".$maquinario->data_compra."</span></td></tr>";
			echo "<tr><td><span><b>Data inicio do seguro <b/></span></td><td><span>".$maquinario->data_ini_seg."</span></td></tr>";
			echo "<tr><td><span><b>Cdata Fim do seguro <b/></span></td><td><span>".$maquinario->data_fim_seg."</span></td></tr>";			
			echo "<tr><td><span><b>Responsável <b/></span></td><td><span>".$func[0]."</span></td></tr>";
			echo "<tr><td><span><b>Forncedor <b/></span></td><td><span>".$fornecedor->nome_fornecedor."</span></td></tr>";
			echo "<tr><td><span><b>Empresa Responsável <b/></span></td><td><span>".$empresa->nome_fantasia."</span></td></tr>";
			
			echo "<tr><td><span><b>Observação<b/></span></td><td><span>".$maquinario->observacao."</span></td></tr>";
			
			echo "MAQUINARIO";
		}

		if($result[3]==0){

			$patrimonio_geral = new Patrimonio_geral();
			$patrimonio_geral = $patrimonio_geral->get_patrimonio_geral_id($id);

      		$empresa = new Empresa();
      		$empresa = $empresa->get_empresa_by_id($patrimonio_geral->id_empresa);

      		
			
			echo "<table class='table_pesquisa'>";
			echo "<tr><td><span><b>Matricula <b/></span></td><td><span>".$patrimonio_geral->matricula."</span></td></tr>";
			echo "<tr><td><span><b>Nome <b/></span></td><td><span>".$patrimonio_geral->nome."</span></td></tr>";
			echo "<tr><td><span><b>Quantidade <b/></span></td><td><span>".$patrimonio_geral->quantidade."</span></td></tr>";
			echo "<tr><td><span><b>Marca<b/></span></td><td><span>".$patrimonio_geral->marca."</span></td></tr>";
			echo "<tr><td><span><b>Valor <b/></span></td><td><span>".$patrimonio_geral->valor."</span></td></tr>";
			echo "<tr><td><span><b>Descrião <b/></span></td><td><span>".$patrimonio_geral->descricao."</span></td></tr>";
					
		
			
			echo "PATRIMONIO GERAL";
		}
	 }

}

	
	
 ?>