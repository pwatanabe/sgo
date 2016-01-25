<?php 
include_once("class_sql.php");
include_once("class_endereco_bd.php");
include_once("class_cliente.php");
include_once("class_obra_produtos.php");
include_once("class_obra_maquinarios.php");
include_once("class_obra_patrimonios.php");
include_once("class_obra_funcionarios.php");

class Obra{
	public $id_obra;
	public $id;
	public $status;
	public $nome;
	public $data_inicio_previsto;
	public $id_responsavel_obra;
	public $site;
	public $latitude;
	public $longitude;
	public $descricao;
	public $id_empresa;
	public $id_cliente;
	public $id_endereco;
	public $id_regiao_trabalho;
	public $oculto;
	public $inicio_validade;
	public $fim_validade;
	

 	public function add_dados_obra(){
 		$this->id = $this->getNextId();
 		$this->nome = $_SESSION['obra']['dados']['nome'];
 		$this->data_inicio_previsto = $_SESSION['obra']['dados']['data_inicio_previsto'];
 		$this->site = $_SESSION['obra']['dados']['site'];
 		$this->latitude = $_SESSION['obra']['dados']['latitude'];
 		$this->longitude = $_SESSION['obra']['dados']['longitude'];
 		$this->descricao = $_SESSION['obra']['dados']['desc'];
 		$this->id_empresa = $_SESSION['id_empresa'];
 		$this->id_cliente = ( isset($_SESSION['obra']['cliente']['id_cli']) ) ? $_SESSION['obra']['cliente']['id_cli'] : null;
 		$this->id_regiao_trabalho = $_SESSION['obra']['dados']['regioes'];
 		$this->id_responsavel_obra = $_SESSION['obra']['dados']['responsavel_obra'];
 		$endereco = new Endereco();
 		$endereco->add_endereco($_SESSION['obra']['dados']['rua'],$_SESSION['obra']['dados']['num'], 0, $_SESSION['obra']['dados']['bairro'], 0, 0);
 		$this->id_endereco = $endereco->add_endereco_bd();
 		$this->inicio_validade = date('Y-m-d h:i:s');
 	}

 	public function add_dados_obra_bd(){
 		$query = "INSERT INTO obras ";
 		$campos = '(';
 		foreach ($this as $key => $value) {
 			if(!empty($value))
 				$campos .= "$key, ";
 		}
 		$campos = substr($campos, 0 ,-2);
 		$campos .= ')';
		$valores = ' VALUES (';
 		
 		foreach ($this as $key => $value) {
 			$replace = array("'",'*','==','=', '<', '>', '||','/','\\');
 			$value = str_replace($replace, '', $value);
 			if(!empty($value)){
 				$valores .= "'$value', ";
 			}
 		}
 		$valores = substr($valores, 0 ,-2);
 		$valores .= ') ';
		
		$sql = new Sql();
		$sql->conn_bd();

 		mysql_query($query.$campos.$valores) or print (mysql_error());

 		$result = mysql_query("SELECT id FROM obras ORDER BY id DESC");
 		
 		$row = mysql_fetch_array($result);
 		if(!empty($row['id']))
 			return $row['id'];

 		return null;
 	}

 	public function altera_obra(){
 		$sql = new Sql();
		$sql->conn_bd();
 		$query = "UPDATE obra SET oculto = 1 WHERE id = {$this->id} && oculto = 0";
 		mysql_query($query);
 		$this->add_dados_obra();

 	}

 	public function set_session($id_obra){
		$sql = new Sql();
		$sql->conn_bd();

		unset($_SESSION['obra']);

		$query = "SELECT * FROM obras WHERE id = $id_obra AND oculto = 0";

		$result = mysql_query($query);

		$row_dados_obra = mysql_fetch_array($result);


 		$_SESSION['obra']['status'] = $row_dados_obra['status'];
 		$_SESSION['obra']['dados']['nome'] = $row_dados_obra['nome'];
 		$_SESSION['obra']['dados']['site'] = $row_dados_obra['site'];
 		$_SESSION['obra']['dados']['data_inicio_previsto'] = $row_dados_obra['data_inicio_previsto'];
 		
 		$endereco = new Endereco();
 		$endereco->get_endereco_id($row_dados_obra['id_endereco']);

 		$_SESSION['obra']['dados']['rua'] = $endereco->rua;
 		$_SESSION['obra']['dados']['num'] = $endereco->numero;
 		$_SESSION['obra']['dados']['desc'] = $row_dados_obra['descricao'];
 		$_SESSION['obra']['dados']['latitude'] = $row_dados_obra['latitude'];
 		$_SESSION['obra']['dados']['longitude'] = $row_dados_obra['longitude'];
 		$_SESSION['obra']['dados']['bairro'] = $endereco->bairro;
 		


 		$_SESSION['obra']['dados']['regioes'] = $row_dados_obra['id_regiao_trabalho'];
 		$_SESSION['obra']['dados']['responsavel_obra'] = $row_dados_obra['id_responsavel_obra'];

 		$cliente = Cliente::get_cliandjur_id($row_dados_obra['id_cliente'], $_SESSION['id_empresa']);



 		$_SESSION['obra']['cliente']['id_cli'] = $cliente->id;
 		$_SESSION['obra']['cliente']['nome_cli'] = $cliente->nome_razao_soc;
 		$_SESSION['obra']['cliente']['cpf_cnpj_cli'] = $cliente->cpf_cnpj;

 		$endereco = new Endereco();
 		$endereco->get_endereco_id($cliente->id_endereco);

 		$_SESSION['obra']['cliente']['rua'] = $endereco->rua;
 		$_SESSION['obra']['cliente']['num'] = $endereco->numero;
 		$_SESSION['obra']['cliente']['telefone_com'] = $cliente->telefone_com;

 		
 		$produtos = Obra_produtos::get_produtos_obra($id_obra);
 		
 		foreach ($produtos as $key => $value) {
 			$_SESSION['obra']['produto'][$key] = $value;
 		}

 		$patrimonios = Obra_patrimonios::get_patrimonios($id_obra);
		
 		foreach ($patrimonios as $key => $value) {
 			$_SESSION['obra']['patrimonio'][$key] = $value;
 		}
 		
 		$funcionarios = Obra_funcionario::get_funcionarios_obra($id_obra);
 		
 		foreach ($funcionarios as $key => $value) {
 			$_SESSION['obra']['funcionario'][$key] = $value;
 		}

 	}

 	public function printObraSession(){
 		echo '<table border="1">';
 		foreach ($_SESSION['obra'] as $key => $value) {
 			echo '<tr><td colspan="2" style="text-align:center"><b>'.$key.'</b></td></tr>';
 			echo '<tr><td><b>key</b></td><td><b>value</b></td></tr>';
 			if(is_array($value)){
 				foreach ($value as $key2 => $value2) {
 					if(is_array($value2)){
 						foreach ($value2 as $key3 => $value3) {
 							if(is_array($value3)){
 								echo "<script>alert('existe mais um array');</script>";
 							}else{
 								echo '<tr><td>'.$key3.'</td><td>'.$value3.'</td></tr>';	
 							}
 						}
 					}else{
 						echo '<tr><td>'.$key2.'</td><td>'.$value2.'</td></tr>';			
 					}
 				}
 			}else{
 				echo '<tr><td>'.$key.'</td><td>'.$value.'</td></tr>';		
 			}
 			
 		}
 		echo '</table>';
 		print_r($_SESSION['obra']);
 	}

 	public function getObraId($id){
 		$sql = new Sql();
 		$sql->conn_bd();

 		$result = mysql_query("SELECT * FROM obras WHERE id = $id && oculto = 0");

 		$row = mysql_fetch_array($result);

 		$obra = new Obra();
		$obra->id = $row['id'];
 		$obra->nome = $row['nome'];
		$obra->data_inicio_previsto = $row['data_inicio_previsto'];
		$obra->id_responsavel_obra = $row['id_responsavel_obra'];
		$obra->site = $row['site'];
		$obra->latitude = $row['latitude'];
		$obra->longitude = $row['longitude'];
		$obra->descricao = $row['descricao'];
		$obra->id_empresa = $row['id_empresa'];
		$obra->id_cliente = $row['id_cliente'];
		$obra->id_endereco = $row['id_endereco'];
		$obra->id_regiao_trabalho = $row['id_regiao_trabalho'];
		$obra->oculto = $row['oculto'];
		$obra->status = $row['status'];

		return $obra;
 	}
 	

 	public function getStatus($tipo){
 		if($tipo == 0){
 			return "Orçamento";
 		}else if($tipo == 1){
 			return "Aprovada";
 		}else if($tipo == 2){
 			return "Cancelada";
 		}else if($tipo == 3){
 			return "Em execução";
 		}else{
 			return "Finalizada";
 		}
 	}

 	public function getNextId(){
 		$sql = new Sql();
 		$sql->conn_bd();

 		$result = mysql_query("SELECT id FROM obras ORDER BY id DESC");

 		$row = mysql_fetch_array($result);

 		return ($row['id']+1);
 	}

 	
}

?>