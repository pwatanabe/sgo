<?php
include_once("class_conta_bd.php");
include_once("class_sql.php");
include_once("../global.php");

class Parcelas{
    
    public $id_conta;
    public $data;
    public $parcela_n;
    public $comprovante;
    public $status;
        
        public function add_parcelas($id_conta, $data, $parcela_n){
        
            $this->id_conta = $id_conta;
            $this->data = $data;
            $this->parcela_n = $parcela_n;            
            $this->id_empresa = $_SESSION['id_empresa'];
        }
        
        public function add_parcelas_bd(){
                $sql= new Sql();
		$sql->conn_bd();
                $g = new Glob();
                
                $query = "INSERT INTO parcelas (id_conta, data, parcela_n, id_empresa) 
		                     VALUES ( '%s', '%s',   '%s', '%s')";
                if($g->tratar_query($query, $this->id_conta, $this->data, $this->parcela_n, $this->id_empresa)){                    
                    return true;
		}else{
                    return false;
		} 
        }
        
        public function get_parcelas($id_conta){
                $sql= new Sql();
		$sql->conn_bd();
                $g = new Glob();
                
                $parcelas = new Parcelas;
                
                $query = "SELECT * FROM parcelas WHERE id_conta = ".$id_conta." ORDER BY parcela_n ASC";
                $lista = array();
                $result = mysql_query($query);
                $i = 0;
                while ($row = mysql_fetch_array($result, MYSQLI_ASSOC)){  
                    
                    $lista['data'] = $row['data'];
                    $lista['parcela_n'] = $row['parcela_n'];
                    $lista['status'] = $row['status'];
                    $lista['comprovante'] = $row['comprovante'];
                   
                     if(!empty($lista)){
                            $lista2[$i] = $lista;
                            $i++;
                            
                    }
                }
               return $lista2;
                
        }
//                public function get_parcelas($id_conta){
//                $sql= new Sql();
//		$sql->conn_bd();
//                $g = new Glob();
//                
//                $parcelas = new Parcelas;
//                
//                $query = "SELECT * FROM parcelas WHERE id_conta = ".$id_conta." && status = 0 ORDER BY parcela_n ASC";
//                $lista = array();
//                $result = mysql_query($query);
//                
//                while ($row = mysql_fetch_array($result, MYSQLI_ASSOC)){  
//                    
//                $data[] = $row['data'];
//                $parcela[] = $row['parcela_n'];
//                $status[] = $row['status']; 
//                }
//                if(!empty($data) || !empty($parcela) ){
//                    $lista[1] = $data;
//                    $lista[2] = $parcela;
//                    $lista[3] = $status;
//                    return $lista;
//                }
//                
//        }
        
        
        public function get_parcelas_pagas($id_conta){
                $sql= new Sql();
		$sql->conn_bd();
                $g = new Glob(); 
                
                $query = "SELECT * FROM parcelas WHERE id_conta = ".$id_conta." && status = 1 ORDER BY parcela_n ASC";
                $lista = array();
                
                $result = mysql_query($query);
                
                while ($row = mysql_fetch_array($result, MYSQLI_ASSOC)){  
                    
                $data[] = $row['data'];
                $parcela[] = $row['parcela_n'];
                 
                }
                if(!empty($data) || !empty($parcela) ){
                    $lista[1] = $data;
                    $lista[2] = $parcela;
                    return $lista;
                }
                
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
        
        
        function confere_kitacao($id_conta){
                $sql= new Sql();
		$sql->conn_bd();
                
                $query = "SELECT * FROM parcelas WHERE id_conta = ".$id_conta." && status = 0";
                $result = mysql_query($query);
                $row = mysql_num_rows($result);
                 
                       
//                    $conta = new Contas();
//                    $conta->set_conta_paga($id_conta);
               
               return $row;
        }
        
        public function updateComprovante($id,$parcela,$nome_comprovante){
                $sql= new Sql();
		$sql->conn_bd();
                
                
//                $query = 'UPDATE parcelas SET data = "'.$data.'" , comprovante = "'.$nome_comprovante.'" WHERE parcela_n = '.$parcela.' && id_conta = '.$id.'';
                $query = 'UPDATE parcelas SET status = 1, comprovante = "'.$nome_comprovante.'" WHERE parcela_n = "'.$parcela.'"  && id_conta = "'.$id.'" '; 
               
                
                mysql_query($query);
                    
               
                
            
        }
        
}