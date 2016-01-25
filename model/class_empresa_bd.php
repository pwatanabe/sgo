<?php 

include_once("class_sql.php");
require_once(dirname(__FILE__) . "/../global.php");
include_once("class_cidade_bd.php");
include_once("class_funcionario_bd.php");

class Empresa{
    public $id;
    public $cnpj;
    public $razao_social;
    public $nome_fantasia;
    public $ins_estadual;
    public $ins_municipal;
    public $id_endereco;
    public $telefone;
    public $id_responsavel;
    public $nivel_acesso;

    public function add_empresa($cnpj, $razao_social, $nome_fantasia, $ins_estadual, $ins_municipal,  $telefone, $id_responsavel, $id_endereco, $nivel_acesso){
          $this->cnpj = $cnpj;
          $this->razao_social = $razao_social;
          $this->nome_fantasia = $nome_fantasia;
          $this->ins_estadual = $ins_estadual;
          $this->ins_municipal = $ins_municipal;
          $this->id_endereco = $id_endereco;
          $this->telefone = $telefone;
          $this->id_responsavel = $id_responsavel;
          $this->nivel_acesso = $nivel_acesso;
    }

    public function add_empresa_bd(){
          $sql = new Sql();
          $sql->conn_bd();
          $g = new Glob();
          $return = array();
          $query = "SELECT * FROM empresa order by id desc";
          $result = $g->tratar_query($query);
          $row = mysql_fetch_array($result, MYSQL_ASSOC);
          $id = $row['id']+1;

          $query = "INSERT INTO empresa (id, cnpj, razao_social, nome_fantasia, ins_estadual, ins_municipal, telefone, id_responsavel, id_endereco, nivel_acesso, id_empresa) VALUES ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s', '%s')";
          if($g->tratar_query($query, $id, $this->cnpj, $this->razao_social, $this->nome_fantasia, $this->ins_estadual, $this->ins_municipal,  $this->telefone, $this->id_responsavel, $this->id_endereco, $this->nivel_acesso, $_SESSION['id_empresa'])){
            return true;
          }else{
            return false;
          }
    }

    public function add_empresa_parcial($nome_fantasia, $razao_soc, $cnpj, $id){

          $this->nome_fantasia = $nome_fantasia;
          $this->razao_social = $razao_soc;
          $this->cnpj = $cnpj;
          $this->id_responsavel = $id;
    }

    public function add_empresa_parcial_bd(){
          $sql = new Sql();
          $sql->conn_bd();
          $g = new Glob();
          $return = array();
          $query = "SELECT * FROM empresa order by id desc";
          $result = $g->tratar_query($query);
          $row = mysql_fetch_array($result, MYSQL_ASSOC);
          $id = $row['id']+1;


          $query = "INSERT INTO empresa(id, nome_fantasia, razao_social, cnpj, id_responsavel, id_empresa) VALUES ('%s', '%s', '%s', '%s', '%s', '%s')";

          if ($g->tratar_query($query, $id, $this->nome_fantasia, $this->razao_social, $this->cnpj, $this->id_responsavel, $id)){
            return true;
          }else{
            return false;
          }
    }

    public function busca_ultimo_id_empresa(){
          $sql = new Sql();
          $sql->conn_bd();
          $g = new Glob();

          $query = "SELECT * FROM empresa order by id desc";
          $result = $g->tratar_query($query); 
          
           
           if(@mysql_num_rows($result) == 0){                
                  return 1;
             }else{      
              $row = mysql_fetch_array($result, MYSQL_ASSOC);
              $id = $row['id']+1;
              return $id;
             }
          }

    public function get_all_empresa(){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $aux=0;
        $return = array();
        $query = $g->tratar_query("SELECT * FROM empresa WHERE oculto = 0 && id_empresa = ".$_SESSION['id_empresa']);

        while($result = mysql_fetch_array($query)){
          $return[$aux][0] = $result['id'];
          $return[$aux][1] = $result['cnpj'];
          $return[$aux][2] = $result['nome_fantasia'];
          $aux++;
        }
        return $return;
        
    }
    public function get_empresa_by_nome_fantasia($nome){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $aux=0;
        $return = array();
        $query = $g->tratar_query("SELECT * FROM empresa WHERE oculto = 0 && id_empresa = ".$_SESSION['id_empresa']." && nome_fantasia LIKE '%%%s%%'", $nome);

        while($result = mysql_fetch_array($query)){
          $return[$aux][0] = $result['id'];
          $return[$aux][1] = $result['cnpj'];
          $return[$aux][2] = $result['nome_fantasia'];
          $aux++;
        }
        if($aux == 0){
          echo "<div class='msg'>Empresa não encontrada !</div>";
        }else{
        return $return;
        }
    }

    public function atualiza_empresa($id, $cnpj, $razao_social, $nome_fantasia, $ins_estadual, $ins_municipal, $telefone, $id_responsavel, $id_endereco){
       $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();

        $query = "UPDATE empresa SET cnpj = '%s', razao_social = '%s', nome_fantasia = '%s', ins_estadual = '%s', ins_municipal = '%s', telefone = '%s', id_responsavel = '%s', id_endereco = '%s' WHERE id = '%s'";

        if($g->tratar_query($query, $cnpj, $razao_social, $nome_fantasia, $ins_estadual, $ins_municipal, $telefone, $id_responsavel, $id_endereco, $id)){
            return true;
        }else{
          return false;
        }
    }

    public function get_empresa_by_cnpj($cnpj){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        
        $query = $g->tratar_query("SELECT * FROM empresa WHERE oculto = 0 && cnpj = '%s'", $cnpj);

        if(@mysql_num_rows($query) == 0){
            return false;
       }else{

          $row = mysql_fetch_array($query, MYSQL_ASSOC);
          $this->id = $row['id'];
          $this->cnpj = $row['cnpj'];
          $this->razao_social = $row['razao_social'];
          $this->nome_fantasia = $row['nome_fantasia'];
          $this->ins_estadual = $row['ins_estadual'];
          $this->ins_municipal = $row['ins_municipal'];
          $this->id_endereco = $row['id_endereco'];
          $this->telefone = $row['telefone'];
          $this->id_responsavel = $row['id_responsavel'];

          return $this;
       }
    }

    public function get_empresa_by_id($id){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        
        $query = $g->tratar_query("SELECT * FROM empresa WHERE oculto = 0 && id = '%s'", $id);

        if(@mysql_num_rows($query) == 0){
            return false;
       }else{
          $row = mysql_fetch_array($query, MYSQL_ASSOC);
          $this->id = $row['id'];
          $this->cnpj = $row['cnpj'];
          $this->razao_social = $row['razao_social'];
          $this->nome_fantasia = $row['nome_fantasia'];
          $this->ins_estadual = $row['ins_estadual'];
          $this->ins_municipal = $row['ins_municipal'];
          $this->id_endereco = $row['id_endereco'];
          $this->telefone = $row['telefone'];
          $this->id_responsavel = $row['id_responsavel'];

          return $this;
       }
    }

    public function get_nome_by_id($id){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        
        $query = $g->tratar_query("SELECT nome_fantasia FROM empresa WHERE oculto = 0 && id = '%s'", $id);

        if(@mysql_num_rows($query) == 0){
            return false;
       }else{
          $row = mysql_fetch_array($query, MYSQL_ASSOC);
          return $row['nome_fantasia'];
       }
    }

    public function ocultar(){
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();

        if($g->tratar_query("UPDATE empresa SET oculto = 1 WHERE id = '%s'", $this->id)){
          return true;
        }else{
          return false;
        }
    }

    public function ocultar_by_id($id){        
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        if($_SESSION['id_empresa'] != $id){
        $query = "UPDATE empresa SET oculto = 1 WHERE id = %s";
        $result = $g->tratar_query($query, $id);
        if($result){
          echo '<div class="msg"> Empresa excluída com sucesso!</div>';
        }}else{
                    echo '<script>alert("Você não pode excluír esta empresa")</script>';
        }
        }

    public function printEmpresa(){
      
      $filial = new Filial();
      $filiais = $filial->get_filial_by_empresa($this->id);
      $endereco = new Endereco();
      $endereco = $endereco->get_endereco($this->id_endereco);
      $cidade = new Cidade();
      $city = $cidade->get_city_by_id($endereco[0][2]);
      $string_endereco = "Rua ".$endereco[0][0].", Nº ".$endereco[0][1]." - ".$city->nome;
      $responsavel = new Funcionario();
      $responsavel = $responsavel->get_func_id($this->id_responsavel);
      $texto ='';
      $texto .= "<table class='table_pesquisa'>
        <tr>
          <td><span><b>ID</b></span></td>
          <td><span>$this->id</span></td>
        </tr>
        <tr>
          <td><span><b>CNPJ</b></span></td>
          <td><span>$this->cnpj</span></td>
        </tr>
        <tr>
          <td><span><b>Razão Social</b></span></td>
          <td><span>$this->razao_social</span></td>
        </tr>
        <tr>
          <td><span><b>Nome Fantasia</b></span></td>
          <td><span>$this->nome_fantasia</span></td>
        </tr>
        <tr>
          <td><span><b>Ins. Estadual</b></span></td>
          <td><span>$this->ins_estadual</span></td>
        </tr>
        <tr>
          <td><span><b>Ins. Municipal</b></span></td>
          <td><span>$this->ins_municipal</span></td>
        </tr>
        <tr>
          <td><span><b>Endereço</b></span></td>
          <td><span>$string_endereco</span></td>
        </tr>
        <tr>
          <td><span><b>Telefone</b></span></td>
          <td><span>$this->telefone</span></td>
        </tr>
        <tr>
          <td><span><b>Responsável</b></span></td>
          <td><span>$responsavel->nome</span></td>
        </tr>";

        if(count($filiais) > 0){
            $texto .=  "<tr>
                      <td colspan='2'><span><b>Filiais</b></span></td>
                    <tr>";
            foreach ($filiais as $key => $filial) {
                $texto .= '<tr>';
                $texto .= "<td colspan='2' style='padding-left:20px;'><span>".$filiais[$key][1]." - ".$filiais[$key][2]."</span></td>";
                $texto .= '</tr>';
        }
        }
        
        

        $texto .= "</table>";

    
      return $texto;
    }
}

 ?>