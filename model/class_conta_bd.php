<?php
include_once("class_sql.php");
include_once("../global.php");

function carregalista($result){ 
    
     $lista = array();
    
                while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
                $conta = new Contas();
                $conta->id = $row['id'];
                $conta->codigo = $row['codigo'];
                $conta->tipo = $row['tipo'];
                $conta->valor = $row['valor'];
                $conta->juros = $row['juros'];
                $conta->periodo_juros = $row ['periodo_juros'];
                $conta->fornecedor_cliente = $row['fornecedor_cliente'];
                $conta->data_vencimento = $row['data_vencimento'];               
                $conta->descricao = $row['descricao'];
                $conta->obra = $row['obra'];
                $conta->banco = $row['banco'];           
                $conta->parcelas = $row['parcelas'];
                
                $conta->status = $row['status'];  
                
                $lista[] = $conta; 
            }
            return $lista;
}


    class Contas{
        public $id;
	public $codigo;
        public $descricao;
	public $fornecedor_cliente;
	public $id_obra;
        public $plano;
	public $banco;
	public $valor;
	public $multa;
	public $id_parcela;
	public $parcelas;   
	public $juros;
        public $periodo_juros;      
        public $tipo_de_pagamento;
	public $oculto;
        public $tipo_a_p_r;
        public $id_empresa;
	
        public function add_contas($cod, $desc, $fornecedor, $obra, $plano, $banco, $valor, $id_parcela, $tipo_de_pagamento, $multa, $juros, $periodo_juros, $tipo_a_p_r, $id_empresa){
                                    
            
            $this->codigo = $cod;
            $this->descricao = $desc;
            $this->fornecedor_cliente = $fornecedor;
            $this->id_obra = $obra;
            $this->plano = $plano;
            $this->banco = $banco;
            $this->valor = $valor;
            $this->id_parcela = $id_parcela;
            $this->tipo_de_pagamento = $tipo_de_pagamento;   
            $this->multa = $multa;                     
            $this->juros = $juros;
            $this->periodo_juros = $periodo_juros;
            $this->tipo_a_p_r = $tipo_a_p_r;
            $this->id_empresa = $id_empresa;
            
        }
        
        public function add_contas_bd(){
                $sql= new Sql();
		$sql->conn_bd();

		$g = new Glob();                
		$query = "INSERT INTO contas (codigo, descricao, fornecedor_cliente, obra, plano_de_conta, banco, valor, id_parcela, tipo_de_pagamento, multa, juros, periodo_juros, tipo_a_p_r, id_empresa) 
		                      VALUES ( '%s',     '%s',         '%s',         '%s',  '%s', '%s',   '%s',    '%s',    '%s',  '%s',   '%s',     '%s',    '%s',   '%s')";
		 
		if($g->tratar_query($query,  $this->codigo, $this->descricao, $this->fornecedor_cliente, $this->id_obra, $this->plano ,$this->banco, $this->valor, $this->id_parcela, $this->tipo_de_pagamento, $this->multa, $this->juros, $this->periodo_juros, $this->tipo_a_p_r, $this->id_empresa)){
			echo "<script>alert('adicionou')</script>";
                        return true; 
                        
		}else{
                    echo "<script>alert('nao adiciou')</script>";
			return false;
		} 
        }
        
        public function get_ultima_conta(){
                $sql= new Sql();
		$sql->conn_bd();
		$g = new Glob(); 
                
                $query = "SELECT MAX(id) FROM contas";
                
                $result = mysql_query($query);
                
                $id = mysql_fetch_row($result);
                
                return $id[0];
            
        }


        public function ver_contas_apagar(){
            $sql= new Sql();
            $sql->conn_bd();
            $g = new Glob();
            
            $query = "SELECT * FROM contas WHERE tipo = 1 && id_empresa = ".$_SESSION['id_empresa']." && oculto = 0 && status = 0";
            
            $result = $g->tratar_query($query);
            
            $lista = array();
            
            $lista = carregalista($result);
            

            return $lista;
        }
        
        public function ver_contas_areceber(){
            $sql= new Sql();
            $sql->conn_bd();
            $g = new Glob();
            
            $query = "SELECT * FROM contas WHERE tipo = 2 && id_empresa = ".$_SESSION['id_empresa']." && oculto = 0 && status = 0";
            
            $result = $g->tratar_query($query);
            
            $lista = array();
            
            $lista = carregalista($result);
            
            return $lista;
        }
        
        public function ver_contas_recebidas(){
            $sql= new Sql();
            $sql->conn_bd();
            $g = new Glob();
            
            $query = "SELECT * FROM contas WHERE tipo = 2 && id_empresa = ".$_SESSION['id_empresa']." && oculto = 0 && status = 1";
            
            $result = $g->tratar_query($query);
            
            $lista = array();
            
            $lista = carregalista($result);
            
            return $lista;
        }
        
        public function ver_contas_pagas(){
            $sql= new Sql();
            $sql->conn_bd();
            $g = new Glob();
            
            $query = "SELECT * FROM contas WHERE tipo = 1 && id_empresa = ".$_SESSION['id_empresa']." && oculto = 0 && status = 1";
            
            $result = $g->tratar_query($query);
            
            $lista = array();
            
            $lista = carregalista($result);
            
            return $lista;
        }
        
    public function set_conta_paga($id){
            $sql= new Sql();
            $sql->conn_bd();
            $g = new Glob();
            $query = 'UPDATE contas SET status = 1 WHERE id = '.$id.' && id_empresa = '.$_SESSION['id_empresa'].'';
            $result = $g->tratar_query($query);          
           
         }
       
    }

?>