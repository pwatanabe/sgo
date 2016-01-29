<?php
include_once("class_conta_bd.php");
include_once("class_sql.php");
include_once("../global.php");

class PlanoConta{
    
    public $nome;
    public $codigo;
    public $oculto;
    public $id_empresa;
    
    public function add_PlanoConta($nome, $codigo, $id_empresa){
        
        $this->nome = $nome;
        $this->codigo = $codigo;
        $this->id_empresa = $id_empresa;
    }
    
    public function add_PlanoContabd(){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        
        $query = "INSERT INTO plano_conta (nome, codigo, id_empresa) 
		                     VALUES ( '%s',     '%s',   '%s')";
        
        if($g->tratar_query($query, $this->nome, $this->codigo, $this->id_empresa)){
            return true;
        }else{
            return false;
        }
        
    }
    
    public function get_all_PlanoConta(){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        
        $query = "SELECT * FROM plano_conta where id_empresa=".$_SESSION['id_empresa']." && oculto = 0 ";
        
        $result = mysql_query($query);
        
        $array = array();
        
        while ($row = mysql_fetch_array($result)){
            $plano_conta = new PlanoConta();
            $plano_conta->id = $row['id'];
            $plano_conta->nome = $row['nome'];
            $plano_conta->codigo = $row['codigo'];
            $array[] = $plano_conta;
        }
        return $array;
    }
    
}