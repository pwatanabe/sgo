<?php
include_once("class_sql.php");
include_once("class_turno_bd.php");
include_once("class_filial_bd.php");
include_once("class_empresa_bd.php");
include_once("class_cbo_bd.php");
include_once("class_epi_bd.php");
require_once(dirname(__FILE__) . "/../global.php");

class Funcionario{
	public $id;
	public $cod_serie;
	public $id_tabela; //id do registro no banco
	public $nome;
	public $cpf;
        public $cnh;
	public $rg;
	public $data_nasc;
	public $telefone;
	public $email;
	public $senha;
	public $id_cbo;
	public $id_endereco;
	public $id_empresa;
	public $id_empresa_filial;
	public $id_turno;
	public $is_admin;
	public $id_dados_bancarios;
	public $data_em_rg;
	public $org_em_rg;
	public $num_tit_eleitor;
	public $email_empresa;
	public $data_adm;
	public $salario_base;
        public $id_valor_custo;
	public $qtd_horas_sem;
	public $num_cart_trab;
	public $num_serie_cart_trab;
	public $uf_cart_trab;
	public $num_pis;
	public $id_supervisor;
	public $data_ini;
	public $data_fim;
	public $estagiario;
	
	public function add_func($id_dados_bancarios, $cod_serie, $nome, $cpf, $cnh, $rg, $data_nasc, $telefone, $email, $senha, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $id_endereco, $data_em_rg, $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor, $data_ini, $data_fim, $estagiario){
			$this->id_dados_bancarios = $id_dados_bancarios;
			$this->cod_serie = $cod_serie;
			$this->nome = $nome;
			$this->cpf = $cpf;
                        $this->cnh = $cnh;
			$this->data_nasc = $data_nasc;
			$this->telefone = $telefone;
			$this->email = $email;
			$this->senha = $senha;
                        $this->id_cbo = $id_cbo;
			$this->id_endereco = $id_endereco;
			$this->id_empresa = $id_empresa;
			$this->id_empresa_filial = $id_empresa_filial;
			$this->id_turno = $id_turno;
			$this->is_admin = $is_admin;
			$this->rg = $rg;
			$this->data_em_rg = $data_em_rg;
			$this->org_em_rg = $org_em_rg;
			$this->num_tit_eleitor = $num_tit_eleitor;
			$this->email_empresa = $email_empresa;
			$this->data_adm = $data_adm;
			$this->salario_base = $salario_base;
                        $this->id_valor_custo = $id_valor_custo;
			$this->qtd_horas_sem = $qtd_horas_sem;
			$this->num_cart_trab = $num_cart_trab;
			$this->num_serie_cart_trab = $num_serie_cart_trab;
			$this->uf_cart_trab = $uf_cart_trab;
			$this->num_pis = $num_pis;
			$this->id_supervisor = $id_supervisor;
			$this->data_ini = $data_ini;
			$this->data_fim = $data_fim;
			$this->estagiario = $estagiario;
	}

	public function add_func_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = "SELECT * FROM funcionario ORDER BY id DESC";
		$result = $g->tratar_query($query);

		$row = mysql_fetch_array($result);//pega o ultimo funcionario cadastrado

		$novo_id = $row['id']+1;//pega o id do ultimo e incrementa 1 para saber o id do proximo

		$query = "INSERT INTO funcionario (id, id_dados_bancarios, cod_serie, nome, cpf, cnh,  rg, data_nasc, telefone, email, senha, id_turno, id_cbo, id_empresa, id_empresa_filial, is_admin, id_endereco, data_em_rg, org_em_rg, num_tit_eleitor, email_empresa, data_adm, salario_base, id_valor_custo, qtd_horas_sem, num_cart_trab, num_serie_cart_trab, id_uf_cart_trab, num_pis, id_supervisor, data_ini, estagiario) 
		                           VALUES (%d,       %d,            '%s',     '%s', '%s', '%s', '%s' , '%s',      '%s',    '%s',  '%s',    %d,       %d,      %d,             %d,           %d,        %d,        '%s',        '%s',         '%s',         '%s',         '%s',      '%s',           %d,              '%s',         '%s',            '%s',                %d,          '%s',     '%s',         '%s',     '%s')";

		$result = $g->tratar_query($query,$novo_id, $this->id_dados_bancarios, $this->cod_serie,
			                       $this->nome, $this->cpf, $this->cnh, $this->rg, $this->data_nasc, $this->telefone, $this->email, $this->senha, $this->id_turno, $this->id_cbo, $this->id_empresa,
			                       $this->id_empresa_filial, $this->is_admin, $this->id_endereco, $this->data_em_rg, $this->org_em_rg, $this->num_tit_eleitor, $this->email_empresa, $this->data_adm, $this->salario_base, $this->id_valor_custo, $this->qtd_horas_sem, $this->num_cart_trab, $this->num_serie_cart_trab, $this->uf_cart_trab, $this->num_pis, $this->id_supervisor, $this->data_ini, $this->estagiario);
		if($result){
			return true;
		}else{
			return false;
		}

	}

	public function add_func_parcial($nome, $email, $cpf, $telefone, $senha, $id_empresa){
		$this->nome = $nome;
		$this->email = $email;
		$this->cpf = $cpf;
		$this->telefone = $telefone;
		$this->senha = $senha;
		$this->id_empresa = $id_empresa;

	}

	public function add_func_parcial_bd(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = "SELECT * FROM funcionario ORDER BY id DESC";
		$result = $g->tratar_query($query);

		$row = mysql_fetch_array($result, MYSQL_ASSOC);//pega o ultimo funcionario cadastrado

		$novo_id = $row['id']+1;

		$query = "INSERT INTO funcionario (id, nome, email, cpf, telefone, senha, id_empresa, is_admin) VALUES ('%s', '%s', '%s', '%s', '%s', '%s', '%s', '1')";
		
		$result = $g->tratar_query($query, $novo_id, $this->nome, $this->email, $this->cpf, $this->telefone, $this->senha, $this->id_empresa);		
		 
		 if($result){
			return true;
		}else{
			return false;
		}
	}

	 public function busca_ultimo_id_funcionario(){
          $sql = new Sql();
          $sql->conn_bd();
          $g = new Glob();
          
          $query = "SELECT * FROM funcionario order by id desc";
          $result = $g->tratar_query($query); 
          
           
           if(@mysql_num_rows($result) == 0){
                  return 1;
             }else{
      
              $row = mysql_fetch_array($result, MYSQL_ASSOC);
              $id = $row['id']+1;
              return $id;
             }
          }

	public function get_func_id($id){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();
		 // date_default_timezone_set('America/Sao_Paulo');
		 $data = date('Y-m-d 00:00:00');
		 $query = "SELECT * FROM funcionario WHERE id = '%s' && (('%s' >= data_ini && '%s' < data_fim) || data_fim = '0000-00-00 00:00:00')";
		 $result = $g->tratar_query($query, $id, $data, $data);

		 $func = new Funcionario();
		 if(@mysql_num_rows($result) == 0){
            return false;
	     }else{

	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	
	     	$func->id = $row['id'];
	     	$func->cod_serie = $row['cod_serie'];
	     	$func->id_tabela = $row['id_tabela'];
	     	$func->nome = $row['nome'];
	     	$func->cpf = $row['cpf'];
                $func->cnh = $row['cnh'];
	     	$func->email = $row['email'];
	     	$func->telefone = $row['telefone'];
	     	$func->data_nasc = $row['data_nasc'];
	     	$func->senha = $row['senha'];
	     	$func->id_cbo = $row['id_cbo'];
	     	$func->id_endereco = $row['id_endereco'];
	     	$func->id_empresa = $row['id_empresa'];
	     	$func->id_empresa_filial = $row['id_empresa_filial'];
	     	$func->telefone = $row['telefone'];
	     	$func->id_turno = $row['id_turno'];
	     	$func->is_admin = $row['is_admin'];
	     	$func->id_dados_bancarios = $row['id_dados_bancarios'];
	     	$func->rg = $row['rg'];
			$func->data_em_rg = $row['data_em_rg'];
			$func->org_em_rg = $row['org_em_rg'];
			$func->num_tit_eleitor = $row['num_tit_eleitor'];
			$func->email_empresa = $row['email_empresa'];
			$func->data_adm = $row['data_adm'];
			$func->salario_base = $row['salario_base'];
                        $func->id_valor_custo = $row['id_valor_custo'];
			$func->qtd_horas_sem = $row['qtd_horas_sem'];
			$func->num_cart_trab = $row['num_cart_trab'];
			$func->num_serie_cart_trab = $row['num_serie_cart_trab'];
			$func->uf_cart_trab = $row['id_uf_cart_trab'];
			$func->num_pis = $row['num_pis'];
			$func->id_supervisor = $row['id_supervisor'];
			$func->data_ini = $row['data_ini'];
			$func->data_fim = $row['data_fim'];
			$func->estagiario = $row['estagiario'];
	     	
	     	return $func;
	     }
	}

	public function get_func_historico_id($id, $data){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();
		 $data = date('Y-m-d 00:00:00');
		 $query = "SELECT * FROM funcionario WHERE id= '%s' ";

		 $result = $g->tratar_query($query, $id);
		 
		 if(@mysql_num_rows($result) == 0){
            echo 'Nenhum funcionário encontrado';
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$this->id_tabela = $row['id_tabela'];
	     	$this->id = $row['id'];
	     	$this->nome = $row['nome'];
	     	$this->cpf = $row['cpf'];
                $this->cnh = $row['cnh'];
	     	$this->email = $row['email'];
	     	$this->telefone = $row['telefone'];
	     	$this->data_nasc = $row['data_nasc'];
	     	$this->senha = $row['senha'];
	     	$this->id_cbo = $row['id_cbo'];
	     	$this->id_endereco = $row['id_endereco'];
	     	$this->id_empresa = $row['id_empresa'];
	     	$this->id_empresa_filial = $row['id_empresa_filial'];
	     	$this->telefone = $row['telefone'];
	     	$this->id_turno = $row['id_turno'];
	     	$this->is_admin = $row['is_admin'];
	     	$this->rg = $row['rg'];
			$this->data_em_rg = $row['data_em_rg'];
			$this->org_em_rg = $row['org_em_rg'];
			$this->num_tit_eleitor = $row['num_tit_eleitor'];
			$this->email_empresa = $row['email_empresa'];
			$this->data_adm = $row['data_adm'];
			$this->salario_base = $row['salario_base'];
			$this->qtd_horas_sem = $row['qtd_horas_sem'];
			$this->num_cart_trab = $row['num_cart_trab'];
			$this->num_serie_cart_trab = $row['num_serie_cart_trab'];
			$this->uf_cart_trab = $row['id_uf_cart_trab'];
			$this->num_pis = $row['num_pis'];
			$this->id_supervisor = $row['id_supervisor'];
			$this->estagiario = $row['estagiario'];
			$this->data_ini = $row['data_ini'];
			$this->data_fim = $row['data_fim'];

	     	return $this;
	     }
	}

	public function get_func_cpf($cpf){
		 $sql = new Sql();
		 $sql->conn_bd();
		 $g = new Glob();
		 $data = date('Y-m-d 00:00:00');
		 $query = "SELECT * FROM funcionario WHERE cpf = '%s' && (('%s' >= data_ini && '%s' < data_fim) || data_fim = '0000-00-00 00:00:00')";
		 $result = $g->tratar_query($query, $cpf, $data, $data);
		 
		 if(@mysql_num_rows($result) == 0){
            echo 'Nenhum funcionário encontrado';
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$this->id_tabela = $row['id_tabela'];
	     	$this->id = $row['id'];
	     	$this->nome = $row['nome'];
	     	$this->cpf = $row['cpf'];
                $this->cnh = $row['cnh'];
	     	$this->email = $row['email'];
	     	$this->telefone = $row['telefone'];
	     	$this->data_nasc = $row['data_nasc'];
	     	$this->senha = $row['senha'];
	     	$this->id_cbo = $row['id_cbo'];
	     	$this->id_endereco = $row['id_endereco'];
	     	$this->id_empresa = $row['id_empresa'];
	     	$this->id_empresa_filial = $row['id_empresa_filial'];
	     	$this->telefone = $row['telefone'];
	     	$this->id_turno = $row['id_turno'];
	     	$this->is_admin = $row['is_admin'];
	     	$this->rg = $row['rg'];
			$this->data_em_rg = $row['data_em_rg'];
			$this->org_em_rg = $row['org_em_rg'];
			$this->num_tit_eleitor = $row['num_tit_eleitor'];
			$this->email_empresa = $row['email_empresa'];
			$this->data_adm = $row['data_adm'];
			$this->salario_base = $row['salario_base'];
			$this->qtd_horas_sem = $row['qtd_horas_sem'];
			$this->num_cart_trab = $row['num_cart_trab'];
			$this->num_serie_cart_trab = $row['num_serie_cart_trab'];
			$this->uf_cart_trab = $row['id_uf_cart_trab'];
			$this->num_pis = $row['num_pis'];
			$this->id_supervisor = $row['id_supervisor'];
			$this->estagiario = $row['estagiario'];
			$this->data_ini = $row['data_ini'];
			$this->data_fim = $row['data_fim'];

	     	return $this;
	     }
	}

	public function get_admin(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$aux = 0;
		$query = "SELECT * FROM funcionario WHERE oculto = 0 && is_admin = 1 && id_empresa = ".$_SESSION['id_empresa']." ORDER BY nome ASC";
		
		$query_tra = $g->tratar_query($query);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$aux++;
		}
		return $return;
	}
	public function aniversariantes_mes($data){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$mes = '-'.$data[3].$data[4].'-';
		$aux = 0;
		$query = "SELECT * FROM funcionario WHERE data_nasc LIKE '%%%s%%' && oculto = 0 && id_empresa = ".$_SESSION['id_empresa']." ORDER BY data_nasc ASC";
		
		$query_tra = $g->tratar_query($query, $mes);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$return[$aux][2] = $result['data_nasc'];
			$aux++;
		}


		return $return;
	}

	public function verifica_func($cpf, $pass){
		
		$sql = new Sql();
		$sql->conn_bd();

		$g = new Glob();
		
		//criptografia md5() no campo senha
		$query = "SELECT id FROM funcionario WHERE cpf='%s' && senha = md5('%s') && oculto = 0";
		
		$result = $g->tratar_query($query,$cpf,$pass);// recebe query tratada
		
		if(@mysql_num_rows($result) == 0){
           
            return false;
            
        }else{
        	
        	return true;
        }
	}

	public function verifica_func_id($id){
		
		$sql = new Sql();
		$sql->conn_bd();

		$g = new Glob();
		
		//criptografia md5() no campo senha
		$query = "SELECT id FROM funcionario WHERE id = '%s' && oculto = 0";
		
		$result = $g->tratar_query($query,$id);// recebe query tratada
		
		if(@mysql_num_rows($result) == 0){
           
            return false;
            
        }else{
        	
        	return true;
        }
	}

	public function verifica_func_admin($id, $pass){
		
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		//criptografia md5() no campo senha
		$query = "SELECT COUNT(id) as cont FROM funcionario WHERE id = %s && senha = md5('%s') && is_admin = 1 && oculto = 0";

		$result = $g->tratar_query($query, $id, $pass);// recebe query tratada

		$row = mysql_fetch_array($result);

		if($row['cont'] == 0){
            return false;
        }else{
        	return true;
        }
	}
	


	public function get_ultimos_func($qtd){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$return = array();
		$aux=0;
		$query = "SELECT * FROM funcionario WHERE oculto = 0 && id_empresa = '".$_SESSION['id_empresa']."' ORDER BY id_tabela DESC LIMIT $qtd";
		$query_tra = $g->tratar_query($query);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$aux++;
		}
		if($aux == 0){
			echo '<div class="msg">Nenhum funcionário encontrado!</div>';
		}else{
			return $return;
		}

	}

	// array(21) {
	// 	[0]=> string(1) "5" 
	// 	["id"]=> string(2) "15"
	// 	[1]=> string(3) "123"
	// 	["codigo"]=> string(3) "123" 
	// 	[2]=> string(7) "Óculos" 
	// 	["nome_epi"]=> string(7) "Óculos" 
	// 	[3]=> string(16) "Óculos de solda" 
	// 	["descricao"]=> string(16) "Óculos de solda" 
	// 	[4]=> string(1) "5" 
	// 	["id_empresa"]=> string(1) "5" 
	// 	[5]=> string(1) "1" 
	// 	["epi"]=> string(1) "1" 
	// 	[6]=> string(2) "15" 
	// 	[7]=> string(2) "18" 
	// 	["id_func"]=> string(2) "18" 
	// 	[8]=> string(1) "5" 
	// 	["id_epi"]=> string(1) "5" 
	// 	[9]=> string(10) "2015-08-10" 
	// 	["data_entrega"]=> string(10) "2015-08-10" 
	// 	[10]=> string(1) "1" 
	// 	["quantidade"]=> string(1) "1" 
	// } array(21) { 
	// 	[0]=> string(1) "5" 
	// 	["id"]=> string(2) "20" 
	// 	[1]=> string(3) "123" 
	// 	["codigo"]=> string(3) "123" 
	// 	[2]=> string(7) "Óculos" 
	// 	["nome_epi"]=> string(7) "Óculos" 
	// 	[3]=> string(16) "Óculos de solda" 
	// 	["descricao"]=> string(16) "Óculos de solda" 
	// 	[4]=> string(1) "5" 
	// 	["id_empresa"]=> string(1) "5" 
	// 	[5]=> string(1) "1" 
	// 	["epi"]=> string(1) "1" 
	// 	[6]=> string(2) "20" 
	// 	[7]=> string(2) "18" 
	// 	["id_func"]=> string(2) "18" 
	// 	[8]=> string(1) "5" 
	// 	["id_epi"]=> string(1) "5" 
	// 	[9]=> string(10) "2015-08-14" 
	// 	["data_entrega"]=> string(10) "2015-08-14" 
	// 	[10]=> string(2) "12" 
	// 	["quantidade"]=> string(2) "12" 
	// } array(21) { 
	// 	[0]=> string(1) "6" 
	// 	["id"]=> string(2) "13" 
	// 	[1]=> string(3) "124" 
	// 	["codigo"]=> string(3) "124" 
	// 	[2]=> string(6) "Camisa" 
	// 	["nome_epi"]=> string(6) "Camisa" 
	// 	[3]=> string(17) "Camisa da empresa" 
	// 	["descricao"]=> string(17) "Camisa da empresa" 
	// 	[4]=> string(1) "5" 
	// 	["id_empresa"]=> string(1) "5" 
	// 	[5]=> string(1) "0" 
	// 	["epi"]=> string(1) "0" 
	// 	[6]=> string(2) "13" 
	// 	[7]=> string(2) "18" 
	// 	["id_func"]=> string(2) "18" 
	// 	[8]=> string(1) "6" 
	// 	["id_epi"]=> string(1) "6" 
	// 	[9]=> string(10) "2015-08-07" 
	// 	["data_entrega"]=> string(10) "2015-08-07" 
	// 	[10]=> string(1) "3" 
	// 	["quantidade"]=> string(1) "3" 
	// }
        
    public function get_all_id_func(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$funcionarios = array();
		$aux=0;
		$query = "SELECT id FROM funcionario WHERE oculto = 0";
		$query_tra = $g->tratar_query($query);

		if($query_tra)
			while($result =  mysql_fetch_array($query_tra)){
				$return[$aux][0] = $result['id'];
				$aux++;
			}
		if($aux == 0){
			echo '<div class="msg">Nenhum funcionário encontrado!</div>';
		}else{
			return $return;
		}

	}    
	
	public function get_func_by_name($name){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$return = array();
		$aux=0;
		$query = "SELECT * FROM funcionario WHERE nome LIKE '%%%s%%' && oculto = 0 && id_empresa = '".$_SESSION['id_empresa']."'";
		$query_tra = $g->tratar_query($query, $name);

		while($result =  mysql_fetch_array($query_tra)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$aux++;
		}
		if($aux == 0){
			echo '<div class="msg">Nenhum funcionário encontrado!</div>';
		}else{
			return $return;
		}

	}
	public function ocultar(){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "UPDATE funcionario SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $this->id);
		if($result){
			echo '<div class="msg">Funcionário excluido com sucesso!</div>';
		}
	}

	public function ocultar_by_id($id){
                
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
                if($_SESSION['id_funcionario'] != $id){
		$query = "UPDATE funcionario SET oculto = 1 WHERE id = %s";
		$result = $g->tratar_query($query, $id);
		if($result){
			echo '<div class="msg">Funcionário excluido com sucesso!</div>';
                    }
                }else{
                    echo '<script>alert("Você não excluír este funcionário")</script>';
                }
	}
        
        public function get_historico_func_by_id($id){
                $sql = new Sql();
				$sql->conn_bd();
				$g = new Glob();                
                $result = array();
                $aux =0;
                $query = "SELECT * FROM funcionario WHERE id='%s' ORDER BY id_tabela ASC"; 
                
			$query_tra = $g->tratar_query($query, $id);

			while($result =  mysql_fetch_array($query_tra)){
				$return[$aux][0] = $result['id'];
				$return[$aux][1] = $result['nome'];
                                $return[$aux][2] = $result['cod_serie'];
                                $return[$aux][3] = $result['salario_base'];
                                $return[$aux][4] = $result['id_endereco'];
                                $return[$aux][5] = $result['id_cbo'];
                                $return[$aux][6] = $result['data_dem'];
                                $return[$aux][7] = $result['qtd_horas_sem'];
                                $return[$aux][8] = $result['data_fim'];
                                $return[$aux][9] = $result['id_supervisor'];
                                $return[$aux][10] = $result['id_turno'];
                                $return[$aux][11] = $result['is_admin'];
                                $return[$aux][12] = $result['email'];
                                $return[$aux][13] = $result['data_ini'];
	                        $return[$aux][14] = $result['id_valor_custo'];
	                        
	                        
				$aux++;
			}
			if($aux == 0){
		        return false; 
			}else{
				return $return;
			}
        }
// $data_em_rg , $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis




	public function atualiza_func($id, $id_dados_bancarios, $cod_serie, $id_tabela, $nome, $cpf, $data_nasc, $id_endereco, $telefone, $email, $senha, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $rg, $data_em_rg, $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor, $estagiario){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		
		echo "<script>alert('atualiza: ".$estagiario."');</script>";
		$temp = Funcionario::get_func_id($id);
		$cont = 0; //conta se algum dado importante foi alterado
		$true = false;
		foreach ($temp as $key => $value) {
			if($key == 'estagiario' && $temp->$key != $estagiario){// verifica se data_nascimento foi alterado
				echo "<script>alert('aqui');</script>";
				$cont++;
			}else if($key == 'data_nasc' && $temp->$key != $data_nasc){// verifica se data_nascimento foi alterado
				$cont++;
			}else if($key == 'id_empresa' && $temp->$key != $id_empresa){// verifica se empresa foi alterada
				$cont++;
			}else if($key == 'id_turno' && $temp->$key != $id_turno){// verifica se turno foi alterado
				$cont++;
			}else if($key == 'id_cbo' && $temp->$key != $id_cbo){// verifica se turno foi alterado
				$cont++;
			}else if($key == 'is_admin' && $temp->$key != $is_admin){// verifica se turno foi alterado
				$cont++;
			}else if($key == 'salario_base' && $temp->$key != $salario_base){// verifica se turno foi alterado
				$cont++;
			}else if($key == 'qtd_horas_sem' && $temp->$key != $qtd_horas_sem){// verifica se turno foi alterado
				$cont++;
            }else if($key == 'id_valor_custo' && $temp->$key != $id_valor_custo){
                $cont++;
			}else if($key == 'data_ini' && $temp->$key == '0000-00-00 00:00:00'){// se data_ini for 0000-00-00 é a primeira alteração e não precisa gerar historico
				$true = true;
			}
		}
		
		if($cont > 0 && !$true){ //se cont > 0 um dos dados importantes foi alterado e necessita gerar histórico, e se true for verdadeiro quer dizer que é a primeira alteração e não precisa gerar historico
			$sql = new Sql();
			$sql->conn_bd();
			$g = new Glob();

			
			$mes_alteracao = date('m');
			
			// verifica quantos dias tem no mes de alteração (28 30 31) para setar a data fim do registro

			if($mes_alteracao == '01' || $mes_alteracao == '03' || $mes_alteracao == '05' || $mes_alteracao == '07' || $mes_alteracao == '08' || $mes_alteracao == '10' || $mes_alteracao == '12'){// meses com 31 dias
					$data_fim = date('Y').'-'.$mes_alteracao.'-31 23:59:00';
			}else if($mes_alteracao == '04' || $mes_alteracao == '06' || $mes_alteracao == '09' || $mes_alteracao == '11'){// meses com 30 dias
					$data_fim = date('Y').'-'.$mes_alteracao.'-30 23:59:00';
			}else if($mes_alteracao == '02'){// meses com 28 dias
					$data_fim = date('Y').'-'.$mes_alteracao.'-28 23:59:00';
			}
			
			//data inicial do novo registro deve ser dia primeiro do proximo mes
			$data_ini = date('Y').'-'.date('m', strtotime("+1 Month", strtotime(date('Y-m-d 00:00:00')) ) ).'-01 00:00:00';
			
			
			/* 
				Verifica se ja existe essa data ini pra esse funcionario, se ja existe atualiza o registro existente
			*/
			$sql = "SELECT id_tabela FROM funcionario WHERE data_ini = '".$data_ini."' && id = '".$id."' && oculto = 0";// busca se esse funcionario ja foi atualizado esse mes
			$result = mysql_query($sql);

			$row = mysql_fetch_array($result);

			if($row['id_tabela'] != 0 && $row['id_tabela'] != null){ // se ja existe uma alteração, deve ser atualizado esse registro e não criar um novo
				$id_tabela = $row['id_tabela'];
				$aux=0;
			
				$query = "UPDATE funcionario SET nome='%s', id_dados_bancarios = %d, cod_serie = '%s', cpf='%s', data_nasc='%s', id_endereco = '%s', telefone = '%s', email = '%s', id_empresa = '%s', id_empresa_filial = '%s', id_turno = '%s', id_cbo = '%s', is_admin = '%s', rg = '%s', data_em_rg = '%s' , org_em_rg = '%s', num_tit_eleitor = '%s', email_empresa = '%s', data_adm = '%s', salario_base = '%s', id_valor_custo = '%s', qtd_horas_sem = '%s', num_cart_trab = '%s', num_serie_cart_trab = '%s', id_uf_cart_trab = '%s', num_pis = '%s', id_supervisor = '%s', estagiario = '%s'";
												     // $nome,    $cpf,       $data_nasc,       $telefone,      $email,       $id_empresa_filial,        $id_turno,    $id_cbo,        $is_admin,        $data_em_rg ,     $org_em_rg,          $num_tit_eleitor,    $email_empresa,       $data_adm,        $salario_base,     $qtd_horas_sem,       $num_cart_trab,       $num_serie_cart_trab,        $uf_cart_trab,   $num_pis, $id

				if($senha != ""){
					$query .= ", senha = '%s' ";
					$aux++;
				}

				$query .= "WHERE id_tabela = '%s' and oculto = 0";
				
				if($aux == 0){// se aux == 0 a senha não foi alterada então não precisa enviar o parametro $senha
					$query_tra = $g->tratar_query($query, $nome, $id_dados_bancarios, $cod_serie, $cpf, $data_nasc, $id_endereco, $telefone, $email, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $rg, $data_em_rg , $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor,$estagiario,          $id_tabela);
				}else{
					$query_tra = $g->tratar_query($query, $nome, $id_dados_bancarios, $cod_serie, $cpf, $data_nasc, $id_endereco, $telefone, $email, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $rg, $data_em_rg , $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor,$estagiario,         $senha, $id_tabela);
				}

				if($true){// se true, é a primeira alteração então é necessario adicionar a data_ini do registro
					$query = "UPDATE funcionario SET data_ini='%s' WHERE id_tabela = '%s' and oculto = 0";
					$g->tratar_query($query, date("Y-m-d H:i:s"), $id_tabela);
				}
				echo "<script>alert('Atenção, essa alteração só será valida à partir do dia ".date('d/m/Y',strtotime($data_ini))."');</script>";
				return $query_tra;

			}
			/* 
				Fim
			*/

			echo "<script>alert('Atenção, essa alteração só será valida à partir do dia ".date('d/m/Y',strtotime($data_ini))."');</script>";


			$query = "UPDATE funcionario SET oculto = 1, data_fim = '%s' WHERE id_tabela = %s";
			$result = $g->tratar_query($query, $data_fim, $id_tabela);
			$aux = 0;
			$query_tra = false;
			if($senha == ""){
					$query = "INSERT INTO funcionario (id, id_dados_bancarios, cod_serie,  nome, cpf, rg, data_nasc, telefone, email,  senha, id_turno, id_cbo, id_empresa, id_empresa_filial, is_admin, id_endereco, data_em_rg, org_em_rg, num_tit_eleitor, email_empresa, data_adm, salario_base, id_valor_custo, qtd_horas_sem, num_cart_trab, num_serie_cart_trab, id_uf_cart_trab, num_pis, id_supervisor, data_ini, estagiario) 
				                               VALUES ('%s',     %d          ,   '%s'   ,  '%s', '%s', '%s', '%s',      '%s',     '%s', '%s'  ,  %d,       %d,      %d,             %d,            %d,        %d,        '%s',        '%s',         '%s',         '%s',         '%s',      '%s',          %d,               '%s',     '%s',            '%s',                %d,           '%s',     '%s',           '%s',     '%s')";

				    $query_tra = $g->tratar_query($query, $id, $id_dados_bancarios, $cod_serie, $nome, $cpf, $rg, $data_nasc, $telefone, $email, $temp->senha, $id_turno, $id_cbo, $id_empresa, $id_empresa_filial, $is_admin, $id_endereco, $data_em_rg, $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor, $data_ini, $estagiario);
			
			}else{
					$query = "INSERT INTO funcionario (id, id_dados_bancarios, cod_serie, nome, cpf, rg, data_nasc, telefone, email,  senha, id_turno, id_cbo, id_empresa, id_empresa_filial, is_admin, id_endereco, data_em_rg, org_em_rg, num_tit_eleitor, email_empresa, data_adm, salario_base, id_valor_custo, qtd_horas_sem, num_cart_trab, num_serie_cart_trab, id_uf_cart_trab, num_pis, id_supervisor, data_ini, estagiario) 
				                               VALUES ('%s',       %d,             '%s',  '%s', '%s', '%s', '%s',      '%s',   '%s',   '%s',    %d,       %d,      %d,             %d,           %d,        %d,        '%s',        '%s',         '%s',         '%s',         '%s',      '%s',          %d,              '%s',       '%s',            '%s',                %d,           '%s',     '%s',          '%s',      '%s')";

				    $query_tra = $g->tratar_query($query, $id, $id_dados_bancarios, $cod_serie, $nome, $cpf, $rg, $data_nasc, $telefone, $email, $senha, $id_turno, $id_cbo, $id_empresa, $id_empresa_filial, $is_admin, $id_endereco, $data_em_rg, $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor, $data_ini, $estagiario);
			}

		    return $query_tra;

			//se foi alterado algo importante tem que adicionar um novo registro com as novas alterações e manter o antigo
			// Funcionario::add_func($id, $nome, $cpf, $data_nasc, $id_endereco, $telefone, $email, $senha, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $rg, $data_em_rg, $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor);

		}else{

			$aux=0;
			
			$query = "UPDATE funcionario SET nome='%s', id_dados_bancarios = %d, cod_serie = '%s', cpf='%s', data_nasc='%s', id_endereco = '%s', telefone = '%s', email = '%s', id_empresa = '%s', id_empresa_filial = '%s', id_turno = '%s', id_cbo = '%s', is_admin = '%s', rg = '%s', data_em_rg = '%s' , org_em_rg = '%s', num_tit_eleitor = '%s', email_empresa = '%s', data_adm = '%s', salario_base = '%s', id_valor_custo = '%s', qtd_horas_sem = '%s', num_cart_trab = '%s', num_serie_cart_trab = '%s', id_uf_cart_trab = '%s', num_pis = '%s', id_supervisor = '%s', estagiario = '%s'";
											     // $nome,    $cpf,       $data_nasc,       $telefone,      $email,       $id_empresa_filial,        $id_turno,    $id_cbo,        $is_admin,        $data_em_rg ,     $org_em_rg,          $num_tit_eleitor,    $email_empresa,       $data_adm,        $salario_base,     $qtd_horas_sem,       $num_cart_trab,       $num_serie_cart_trab,        $uf_cart_trab,   $num_pis, $id

			if($senha != ""){
				$query .= ", senha = '%s' ";
				$aux++;
			}

			$query .= "WHERE id_tabela = '%s' and oculto = 0";
			
			if($aux == 0){// se aux == 0 a senha não foi alterada então não precisa enviar o parametro $senha
				$query_tra = $g->tratar_query($query, $nome, $id_dados_bancarios, $cod_serie, $cpf, $data_nasc, $id_endereco, $telefone, $email, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $rg, $data_em_rg , $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor,$estagiario,          $id_tabela);
			}else{
				$query_tra = $g->tratar_query($query, $nome, $id_dados_bancarios, $cod_serie, $cpf, $data_nasc, $id_endereco, $telefone, $email, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $rg, $data_em_rg , $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor,$estagiario,         $senha, $id_tabela);
			}

			if($true){// se true, é a primeira alteração então é necessario adicionar a data_ini do registro
				$query = "UPDATE funcionario SET data_ini='%s' WHERE id_tabela = '%s' and oculto = 0";
				$g->tratar_query($query, date("Y-m-d H:i:s"), $id_tabela);
			}

			return $query_tra;
		}
	}

	public function get_all_func_emp(){
		$sql = new Sql();
		$sql->conn_bd();
		$aux=0;
		$query = mysql_query("SELECT * FROM funcionario WHERE oculto = 0 && id_empresa = '".$_SESSION['id_empresa']."'");

		while($result = mysql_fetch_array($query)){
			$return[$aux][0] = $result['id'];
			$return[$aux][1] = $result['nome'];
			$aux++;
		}
		return $return;
            
	}

	public function get_nome_by_id($id){
		
		$sql = new Sql();
		$sql->conn_bd();
		$aux = 0;
		$return = array();
		$query = "SELECT nome, id_turno FROM funcionario WHERE id = ".$id." && oculto = 0";

		$result = mysql_query($query);

		if(@mysql_num_rows($result) == 0){
            // echo 'Nenhum funcionário encontrado';
            return false;
	     }else{
	     	$row = mysql_fetch_array($result, MYSQL_ASSOC);
	     	$return[0] = $row['nome'];
	     	$return[1] = $row['id_turno'];
	     }
		return $return;

	}
	public function verificaCodDup($cod){
		$sql = new Sql();
		$sql->conn_bd();
		$aux = 0;
		$return = array();
		$query = "SELECT COUNT(id) as cont FROM funcionario WHERE cod_serie = '".$cod."'";

		$result = mysql_query($query);

		$row = mysql_fetch_array($result);

		if($row['cont'] == 0){// se não existe duplicado
			return false;
		}else{// se existe duplicado
			return true;
		}


	}
	function verificaValor($get_valor){    // função para transformar o dado do input igual o do banco

        $source = array('.', ',','R$');
        $replace = array('', '.','');

        $valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
        
        return $valor; //retorna o valor formatado para gravar no banco
        }

	public function printFunc(){
        $empresa = new Empresa();
        $empresa->get_empresa_by_id($this->id_empresa);
        $valor_custo = new Valor_custo();
        $valor_custo->get_valor_custo_id($this->id_valor_custo);
        $vlr = $this->verificaValor($valor_custo->valor);        
        if($vlr == ""){$vlr = 0.0;}
        $sal = $this->verificaValor($this->salario_base);
        $filial = Filial::get_filial_id($this->id_empresa_filial);
        $cbo = new Cbo();
        $cbo->get_cbo_by_id($this->id_cbo);
        $turno = new Turno();
        $turno->getTurnoById($this->id_turno);
        $u = new Epi();
		$epi_func = $u->get_epi_func($this->id);

        $texto = "";
		$texto .= "<table class='table_pesquisa'><tr>";
		$texto .= "<td colspan='2'><b><span>ID: <span></b></td><td><span><span>".$this->id."</span><td><span>Cod_Serie</span></td><td><span>".$this->cod_serie."</span></td></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>Nome: <span></b></td><td colspan='3'><span>".$this->nome."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>Telefone: <span></b></td><td colspan='3'><span>".$this->telefone."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>CPF: <span></b></td><td colspan='3'><span>".$this->cpf."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>Data de Nascimento: <span></b></td><td colspan='3'><span>".$this->data_nasc."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>Email:<span> </b></td><td colspan='3'><span>".$this->email."</span></td>";
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>Empresa: <span></b></td><td colspan='3'><span>".$empresa->nome_fantasia."</span></td>";
		$texto .= "</tr>";

		if($filial){
			$texto .= "<tr>";
			$texto .= "<td colspan='2'><b><span>Filial: <span></b></td><td colspan='3><span>".$filial->nome."</span></td>";
			$texto .= "</tr>";
		}
		$texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>Salário base: <span></b></td><td colspan='3'><span>R$ ".number_format($sal, 2,',','.')."</span></td>";
		$texto .= "</tr>";
                $texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>Valor de Custo: <span></b></td><td colspan='3'><span>R$ ".number_format($vlr, 2, ',', '.')."</span></td>";;
		$texto .= "</tr>";
		$texto .= "<tr>";
                if(isset($cbo->descricao)){
		$texto .= "<td colspan='2'><b><span>CBO: <span></b></td><td colspan='3'><span>".$cbo->descricao."</span></td>";
                }
		$texto .= "</tr>";
		$texto .= "<tr>";
		$texto .= "<td colspan='2'><b><span>Turno: <span></b></td><td colspan='3'><span>".$turno->nome." - ". $turno->desc."</span></td>";
		$texto .= "</tr>";
		if(count($epi_func)>0){
			$texto .= '<tr> <td colspan="5"><span><b>Equipamentos do funcionário:</b></span></td></tr>';
			$texto .= '<tr> <td><span>ID</span></td> <td><span>Nome</span></td> <td><span>Data da entrega</span></td><td><span>Quantidade</span></td></tr>';
                      foreach ($epi_func as $key => $value) {
                       $texto .= '<tr><td><span>'.$epi_func[$key]->id.'</span></td><td><span>'.$epi_func[$key]->nome_epi.'</span></td><td><span>'.$epi_func[$key]->data_entrega.'</span></td><td><span>'.$epi_func[$key]->quantidade.'</span></td></tr>';
                      } 
		}
                
		$texto .= "</table>";
		return $texto;
	}
	
}

 ?>