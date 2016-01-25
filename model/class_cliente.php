<?php
include_once("class_endereco_bd.php");
include_once("class_empresa_bd.php");
include_once("class_sql.php");
include_once("../global.php");
include_once("class_cidade_bd.php");

class Cliente { 

	public $id;
	public $data_nasc_data_fund;
	public $cpf_cnpj;
	public $nome_razao_soc;
	public $telefone_cel;
	public $telefone_com;
	public $id_endereco;
	public $tipo;
	public $rg;
	public $inscricao_estadual;
	public $inscricao_municipal;
	public $responsavel;
	public $cpf_responsavel;
	public $data_nasc_resp;
	public $email_resp;
	public $site;
	public $observacao;
	public $fornecedor;
	public $id_empresa;

	public function add_cliente($nome_razao_soc, $data_nasc_data_fund, $cpf_cnpj, $telefone_cel, $telefone_com, $id_endereco, $tipo, $rg, $inscricao_estadual, $inscricao_municipal, $responsavel, $cpf_responsavel, $data_nasc_resp, $email_resp, $site, $observacao, $fornecedor, $id_empresa){

		$this->nome_razao_soc = $nome_razao_soc;
		$this->data_nasc_data_fund = $data_nasc_data_fund;
		$this->cpf_cnpj = $cpf_cnpj;
		$this->telefone_cel = $telefone_cel;
		$this->telefone_com = $telefone_com;
		$this->id_endereco = $id_endereco;
		$this->tipo = $tipo;
		$this->rg = $rg;
		$this->inscricao_estadual = $inscricao_estadual;
		$this->inscricao_municipal = $inscricao_municipal;
		$this->responsavel = $responsavel;
		$this->cpf_responsavel =$cpf_responsavel;
		$this->data_nasc_resp = $data_nasc_resp;
		$this->email_resp = $email_resp;
		$this->site = $site;
		$this->observacao = $observacao;
		$this->fornecedor = $fornecedor;
		$this->id_empresa = $id_empresa;

	}

	public function add_cliente_bd(){
		$sql= new Sql();
		$sql->conn_bd();

		$g = new Glob();

		$query = "INSERT INTO clientes (nome_razao_soc, data_nasc_data_fund, cpf_cnpj, telefone_cel, telefone_com, id_endereco, tipo, rg, inscricao_estadual, inscricao_municipal, responsavel, cpf_responsavel, data_nasc_responsavel, email_responsavel, site, observacao, fornecedor, id_empresa) 
		                        VALUES (    '%s',           '%s',                '%s',      '%s',         '%s',         '%s',    '%s','%s',       '%s',               '%s',             '%s',           '%s',               '%s',                 '%s',     '%s',    '%s',    '%s',         '%s'     )";
		
		if($g->tratar_query($query, $this->nome_razao_soc, $this->data_nasc_data_fund, $this->cpf_cnpj, $this->telefone_cel,$this->telefone_com, $this->id_endereco, $this->tipo, $this->rg, $this->inscricao_estadual, $this->inscricao_municipal, $this->responsavel, $this->cpf_responsavel, $this->data_nasc_resp, $this->email_resp, $this->site, $this->observacao, $this->fornecedor, $this->id_empresa)){
			return true; 
		}else{
			return false;
		} 
	}
        
	public function get_all_cli($id_empresa){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM clientes WHERE id_empresa='%s' && oculto = 0";
		$query_tra = $g->tratar_query($query, $id_empresa);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome_razao_soc'];
            $return[$aux][2] = $result['tipo'];

			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum cliente encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
	}        
        
	public function get_cli_by_name($name, $tipo){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM clientes WHERE nome_razao_soc LIKE '%%%s%%' && tipo = '%s' && id_empresa='%s' && oculto = 0";
		$query_tra = $g->tratar_query($query, $name, $tipo, $_SESSION['id_empresa']);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome_razao_soc'];

			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum cliente encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
	}
	public function get_cliandjur_id($id, $id_empresa){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();
                 
		 $query = 'SELECT * FROM clientes WHERE id= "%s" && oculto=0 && id_empresa= "%s"' ;
		 $result = $g->tratar_query($query, $id ,$id_empresa);
		 
		 if(@mysql_num_rows($result) == 0){
            return false;            
	     }else{
	     	$cliente = new Cliente();
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);

	     	$cliente->id = $row['id'];
	     	$cliente->nome_razao_soc = $row['nome_razao_soc'];
	     	$cliente->data_nasc_data_fund = $row['data_nasc_data_fund'];
	     	$cliente->cpf_cnpj = $row['cpf_cnpj'];
	     	$cliente->telefone_cel = $row['telefone_cel'];	
	     	$cliente->telefone_com = $row['telefone_com'];
	     	$cliente->rg = $row['rg'];  
	     	$cliente->id_endereco = $row['id_endereco'];
	     	$cliente->tipo = $row['tipo'];	 
	     	$cliente->responsavel = $row['responsavel'];
	     	$cliente->cpf_responsavel = $row['cpf_responsavel'];
	     	$cliente->data_nasc_responsavel = $row['data_nasc_responsavel'];
	     	$cliente->email_resp= $row['email_responsavel'];
	     	$cliente->observacao = $row['observacao'];
	     	$cliente->site = $row['site'];
	     	$cliente->fornecedor = $row['fornecedor'];
	     	$cliente->id_empresa = $row['id_empresa'];
	     	
	     	return $cliente;
	     }

	}

	public function get_cli_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM clientes WHERE id= '%s' && tipo = 0 && oculto=0" ;
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
            return false;            
	     }else{
	     	$cliente = new Cliente();
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$cliente->id = $row['id'];
	     	$cliente->nome = $row['nome_razao_soc'];
	     	$cliente->data_nasc = $row['data_nasc_data_fund'];
	     	$cliente->cpf = $row['cpf_cnpj'];
	     	$cliente->telefone_cel = $row['telefone_cel'];	
	     	$cliente->telefone_com = $row['telefone_com'];
	     	$cliente->rg = $row['rg'];  
	     	$cliente->id_endereco = $row['id_endereco'];
	     	$cliente->tipo = $row['tipo'];	 
	     	$cliente->responsavel = $row['responsavel'];
	     	$cliente->cpf_responsavel = $row['cpf_responsavel'];
	     	$cliente->data_nasc_responsavel = $row['data_nasc_responsavel'];
	     	$cliente->email_resp= $row['email_responsavel'];
	     	$cliente->observacao = $row['observacao'];
	     	$cliente->site = $row['site'];
	     	$cliente->fornecedor = $row['fornecedor'];
	     	$cliente->id_empresa = $row['id_empresa'];

	     	return $cliente;
	     }

	}


	public function atualiza_cli($id, $nome, $cpf, $data_nasc_data_fund, $cpf_cnpj, $telefone_cel, $telefone_com, $tipo, $rg, $id_endereco,  $responsavel, $cpf_responsavel, $data_nasc_responsavel, $site, $observacao, $fornecedor){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		
		$query = "UPDATE clientes SET nome_razao_soc='%s', cpf_cnpj='%s', data_nasc_data_fund='%s', cpf_cnpj='%s', telefone_cel='%s', telefone_com='%s', tipo='%s', rg='%s', id_endereco='%s', responsavel='%s', cpf_responsavel ='%s', data_nasc_responsavel='%s', site='%s', observacao='%s', fornecedor='%s' WHERE id = '%s'";
		
		// printf($query, $nome, $cpf, $data_nasc, $telefone, $email, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $id_endereco, $id);
		
		$query_tra = $g->tratar_query($query, $nome, $cpf, $data_nasc_data_fund, $cpf_cnpj, $telefone_cel, $telefone_com, $tipo, $rg, $id_endereco,  $responsavel, $cpf_responsavel, $data_nasc_responsavel, $site, $observacao, $fornecedor, $id);
		
		if($query_tra){
			return $query_tra;
		}else{
			return false;
		}
		
	}

	public function get_cli_jur_by_name($name){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM clientes WHERE nome_razao_soc LIKE '%%%s%%' && tipo = 1 && oculto = 0";
		$query_tra = $g->tratar_query($query, $name);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome_razao_soc'];
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum cliente encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
	}
	
	public function ocultar_by_id($id){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE clientes SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $id);
		if($result){
			return true;
		}
	}

	public function get_cli_jur_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();

		 $query = "SELECT * FROM clientes WHERE id= '%s' && tipo =1";
		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
     
            return false;            
	     }else{

	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$this->id = $row['id'];
	     	$this->nome = $row['nome_razao_soc'];
	     	$this->data_nasc_data_fund = $row['data_nasc_data_fund'];
	     	$this->cpf = $row['cpf_cnpj'];
	     	$this->telefone_cel = $row['telefone_cel'];	
	     	$this->telefone_com = $row['telefone_com'];
	     	$this->inscricao_estadual = $row['inscricao_estadual'];
	     	$this->inscricao_municipal=$row['inscricao_municipal'];  
	     	$this->id_endereco = $row['id_endereco'];
	     	$this->tipo = $row['tipo'];	 
	     	$this->responsavel = $row['responsavel'];
	     	$this->cpf_responsavel = $row['cpf_responsavel'];
	     	$this->data_nasc_responsavel = $row['data_nasc_responsavel'];
	     	$this->email_resp= $row['email_responsavel'];
	     	$this->observacao = $row['observacao'];
	     	$this->site = $row['site'];
	     	$this->fornecedor = $row['fornecedor'];
	     	$this->id_empresa = $row['id_empresa'];
	     	return $this;
	     }

	}

	public function atualiza_cli_jur($id, $nome, $cpf, $data_nasc_data_fund, $cpf_cnpj, $telefone_cel, $telefone_com, $tipo, $inscricao_estadual, $inscricao_municipal, $id_endereco,  $responsavel, $cpf_responsavel, $data_nasc_responsavel, $site, $observacao, $fornecedor, $email_resp ){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		
		$query = "UPDATE clientes SET nome_razao_soc='%s', cpf_cnpj='%s', data_nasc_data_fund='%s', cpf_cnpj='%s', telefone_cel='%s', telefone_com='%s', tipo='%s', inscricao_estadual='%s', inscricao_municipal='%s', id_endereco='%s', responsavel='%s', cpf_responsavel ='%s', data_nasc_responsavel='%s', site='%s', observacao='%s', fornecedor='%s', email_responsavel='%s' WHERE id = '%s'";
		
		// printf($query, $nome, $cpf, $data_nasc, $telefone, $email, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $id_endereco, $id);
		
		$query_tra = $g->tratar_query($query, $nome, $cpf, $data_nasc_data_fund, $cpf_cnpj, $telefone_cel, $telefone_com, $tipo, $inscricao_estadual, $inscricao_municipal, $id_endereco,  $responsavel, $cpf_responsavel, $data_nasc_responsavel, $site, $observacao, $fornecedor,$email_resp, $id);
		if($query_tra){
			}
		return $query_tra;
	}

	public function pesquisa_cli_by_name($name_razao_soc ,$tipo ,$id_empresa){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux=0;
		$query = "SELECT * FROM clientes WHERE nome_razao_soc LIKE '%%%s%%' && tipo = '%s' && id_empresa='%s' && oculto=0";
		$query_tra = $g->tratar_query($query, $name_razao_soc, $tipo, $id_empresa);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome_razao_soc'];
			$aux++;
		}
		if($aux == 0){
			$sql->close_conn();
			echo '<div class="msg">Nenhum cliente encontrado!</div>';
		}else{
			$sql->close_conn();
			return $return;
		}
	}
        
        public function get_all_cliente(){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $aux=0;
      
        $query = $g->tratar_query("SELECT * FROM clientes WHERE oculto = 0 && fornecedor = 0 && id_empresa = ".$_SESSION['id_empresa']."");

        while($result = mysql_fetch_array($query)){
          $return[$aux][0] = $result['id'];
          $return[$aux][1] = $result['nome_razao_soc'];          
          $aux++;
        }
        return $return;
        
    }
    public function get_all_fornecedor(){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $return = array();
		 $aux=0;

		 //"SELECT * FROM turno as turno WHERE nome LIKE '%%%s%%' && oculto = 0 && NOT EXISTS (SELECT id FROM funcionario WHERE id_turno = turno.id";

		 $query = mysql_query("SELECT * FROM clientes WHERE oculto = 0 && fornecedor = 1 && id_empresa = ".$_SESSION['id_empresa']."");
		 
		 while($result =  mysql_fetch_array($query)){
		 	$return[$aux][0] = $result['id'];
		 	$return[$aux][1] = $result['nome_razao_soc'];
		 	
		 	$aux++;
		 }
		
		 
		 return $return;
	}
    
 //    public function get_cli_by_id($id){
	// 	 $sql = new Sql();
	// 	 $sql->conn_bd();
	// 	 $g = new Glob();

	// 	 $query = "SELECT * FROM clientes where id = '%s' && fornecedor = 1 && id_empresa = ".$_SESSION['id_empresa']."" ;
	// 	 $result = $g->tratar_query($query, $id);
		 
	// 	 if(@mysql_num_rows($result) == 0){
     
 //            return false;            
	//      }else{

	//      	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	//      	$this->id = $row['id'];
	//      	$this->nome_fornecedor = $row['nome_razao_soc'];	     	
	//      	return $this;
	//      }

	// }    
        public function get_name_by_id($id){
        	$sql = new Sql();
			$sql->conn_bd();
			$g = new Glob();
			$query = "SELECT nome_razao_soc FROM clientes where id = '%s' && id_empresa = ".$_SESSION['id_empresa'] ;
			$result = $g->tratar_query($query, $id);
			if(@mysql_num_rows($result) == 0){
			      return false;            
			}else{
				$row = mysql_fetch_array($result, MYSQL_ASSOC);				
				return $row['nome_razao_soc'];	     	
			}

        }
 //    public function get_all_cli_by_id($id){
	// 	 $sql = new Sql();
	// 	 $sql->conn_bd();
	// 	 $g = new Glob();

	// 	 $query = "SELECT * FROM clientes where id = '$id'" ;		
	// 	 $result = mysql_query($query);
		
                 
 //                 while ($row = mysql_fetch_row($result)) {                     
 //                     return $row;
 //                }

	// }

	public function printCli_Jur(){	
	 	

		$endereco = new Endereco();
		$endereco = $endereco->get_endereco_id($this->id_endereco);
                $empresa = new Empresa();
                $empresa = $empresa->get_empresa_by_id($this->id_empresa);
                $cidade = new Cidade();
                $cidade = $cidade->get_city_by_id($endereco->id_cidade);
	
		$texto ="";
		$texto .= "<table class='table_pesquisa'><tr>";
		$texto .= "<td><span><b>ID: </b></span></td><td><span>".$this->id."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Nome: </b></span></td><td><span>".$this->nome."</span></td>";
		$texto .= "</tr>";		
		$texto .= "<tr>";
		$texto .= "<td><span><b>Telefone Celular: </b></span></td><td><span>".$this->telefone_cel."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Telefone Comercial: </b></span></td><td><span>".$this->telefone_com."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>CNPJ: </b></span></td><td><span>".$this->cpf."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Inscricão Estadual: </b></span></td><td><span>".$this->inscricao_estadual."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Inscricao Municipal: </b></span></td><td><span>".$this->inscricao_municipal."</span></td>";		
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Site: </b></span></td><td><span>".$this->site."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Data de Fundação: </b></span></td><td><span>".$this->data_nasc_data_fund."</span></td>";
		$texto .= "</tr>";		
		$texto .= "<tr>";
		$texto .= "<td><span><b>Rua: </b></span></td><td><span>".$endereco->rua."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>CEP: </b></span></td><td><span>".$endereco->cep."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Bairro: </b></span></td><td><span>".$endereco->bairro."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Numero </b></span></td><td><span>".$endereco->numero."</span></td>";
		$texto .= "</tr>";		
		$texto .= "<tr>";
		$texto .= "<td><span><b>Cidade: </b></span></td><td><span>".$cidade->nome."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Responsavel: </b></span></td><td><span>".$this->responsavel."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>CPF: </b></span></td><td><span>".$this->cpf_responsavel."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Email: </b></span></td><td><span>".$this->email_resp."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Observações: </b></span></td><td><span>".$this->observacao."</span></td>";
		$texto .= "</tr>";		
		if($this->fornecedor == 0){
			echo "";
		}elseif ($this->fornecedor==1){
			$texto .= "<tr>";
		$texto .= "<td><span><b>Forncedor: </b></span></td><td><span>".$this->fornecedor."</span></td>";	
		$texto .= "</tr>";	
		}									
		$texto .= "</table>";
	
 		return $texto;
	 }

	public function printCli(){
		

		$endereco = new Endereco();
		$endereco = $endereco->get_endereco_id($this->id_endereco);
        $empresa = new Empresa();
        $empresa = $empresa->get_empresa_by_id($this->id_empresa);
        $cidade = new Cidade();
        $cidade = $cidade->get_city_by_id($endereco->id_cidade);

		$texto ="";
		$texto .= "<table class='table_pesquisa'><tr>";
		$texto .= "<td><span><b>ID </b></span></td><td><span>".$this->id."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Empresa </b></span></td><td><span>".$empresa->nome_fantasia."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Nome </b></span></td><td><span>".$this->nome."</span></td>";
		$texto .= "</tr>";		
		$texto .= "<tr>";
		$texto .= "<td><span><b>Telefone </b></span></td><td><span>".$this->telefone_cel."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Telefone Comercial </b></span></td><td><span>".$this->telefone_com."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>CPF </b></span></td><td><span>".$this->cpf."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Site </b></span></td><td><span>".$this->site."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Data Nasc </b></span></td><td><span>".$this->data_nasc."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>RG </b></span></td><td><span>".$this->rg."</span></td>";		
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Rua </b></span></td><td><span>".$endereco->rua."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>CEP </b></span></td><td><span>".$endereco->cep."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Bairro </b></span></td><td><span>".$endereco->bairro."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Numero </b></span></td><td><span>".$endereco->numero."</span></td>";
		$texto .= "</tr>";		
		$texto .= "<tr>";
		$texto .= "<td><span><b>Cidade </b></span></td><td><span>".$cidade->nome."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Responsavel </b></span></td><td><span>".$this->responsavel."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>CPF </b></span></td><td><span>".$this->cpf_responsavel."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td><span><b>Email </b></span></td><td><span>".$this->email_resp."</span></td>";
		$texto .= "<tr>";		
		$texto .= "<td><span><b>Observações </b></span></td><td><span>".$this->observacao."</span></td>";
		$texto .= "</tr>";		
		if($this->fornecedor == 0){
			echo "";
		}elseif ($this->fornecedor==1){
			$texto .= "<tr>";
		$texto .= "<td><span><b>Forncedor </b></span></td><td><span>".$this->fornecedor."</span></td>";	
		$texto .= "</tr>";	
		}
									
		$texto .= "</table>";
	
 		return $texto;
	 }
}
	


?>