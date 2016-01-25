<?php
include_once("class_conta_bd.php");
include_once("class_sql.php");
include_once("../global.php");

class Parcelas{
    
    public $id_conta;
    public $data;
    public $parcela_n;
    public $comprovante;
        
        public function add_parcelas($id_conta, $data, $parcela_n, $comprovante){
        
            $this->id_conta = $id_conta;
            $this->data = $data;
            $this->parcela_n = $parcela_n;
            $this->comprovante = $comprovante;
        }
        
        public function add_parcelas_bd(){
                $sql= new Sql();
		$sql->conn_bd();
                $g = new Glob();
  
            
                Parcelas::confere_ultimaparcela($this->id_conta);
                
                
                $query = "INSERT INTO parcelas (id_conta, data, parcela_n, comprovante) 
		                     VALUES ( '%s',     '%s',   '%s',  '%s')";
                if($g->tratar_query($query, $this->id_conta, $this->data, $this->parcela_n, $this->comprovante)){                    
                    return true;
		}else{
                    return false;
		} 
        }
        
        public function get_parcelas_pagas($id_conta){
                $sql= new Sql();
		$sql->conn_bd();
                $g = new Glob(); 
                
                $query = "SELECT parcela_n FROM parcelas WHERE id_conta = ".$id_conta." ORDER BY parcela_n ASC";
                $lista = array();
                
                $result = mysql_query($query);
                while ($return = mysql_fetch_array($result)){
                    $lista[] = $return['parcela_n']; 
                }
                
                return $lista;
                
        }
                public function get_comprovante($id_conta, $parc){
                $sql= new Sql();
		$sql->conn_bd();
                $g = new Glob(); 
                
                $query = "SELECT comprovante FROM parcelas WHERE id_conta = ".$id_conta." && parcela_n = ".$parc."";
                $result = mysql_query($query);
                $result = mysql_fetch_array($result);
                return $result['comprovante'];
                
        }
        
        
        public function confere_ultimaparcela($id_conta){
                $sql= new Sql();
		$sql->conn_bd();
                
                $query = "SELECT * FROM parcelas WHERE id_conta = ".$id_conta."";
                $result = mysql_query($query);
                $row = mysql_num_rows($result);
               
                 
                $query = "SELECT parcelas FROM contas WHERE id = ".$id_conta." ";
                
                $result = mysql_query($query);
                $result = mysql_fetch_array($result);
               
                $aux = $result[0] - $row ; 
                 
                if($aux === 1){
          
                    $conta = new Contas();
                    $conta->set_conta_paga($id_conta);
                }
               
        }
        
        public function updateComprovante($id,$parcela,$data,$nome_comprovante){
                $sql= new Sql();
		$sql->conn_bd();
                
                
                $query = 'UPDATE parcelas SET data = "'.$data.'" , comprovante = "'.$nome_comprovante.'" WHERE parcela_n = '.$parcela.' && id_conta = '.$id.'';
               
                
                mysql_query($query);
                    
               
                
            
        }
        
}