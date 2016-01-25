<?php
// echo '<script> alert("'.dirname(__FILE__).'"); </script>';
include_once(dirname(__FILE__)."/class_sql.php");
include_once("../global.php");

class Config{

  public $id;
  public $id_empresa;
  public $temp_limit_atraso;
  public $exibe_box_atrasos;
  public $exibe_box_sem_registros;
  public $caminho_logo;


  public function add_config($id_empresa, $temp_limit_atraso, $exibe_box_atrasos, $exibe_box_sem_registros, $caminho_logo){
      $this->id_empresa = $id_empresa;
      $this->temp_limit_atraso = $temp_limit_atraso;
      $this->exibe_box_atrasos = $exibe_box_atrasos;
      $this->exibe_box_sem_registros = $exibe_box_sem_registros;
      $this->caminho_logo = $caminho_logo;
  }

  public function add_config_bd(){
      $sql = new Sql();
      $sql->conn_bd();
      $g = new Glob();
      $query = "INSERT INTO config (id_empresa, temp_limit_atraso, exibe_box_atrasos, exibe_box_sem_registros) VALUES 
                                   (    '%s'  ,        '%s'      ,       '%s'       ,              '%s'      )";

      if($g->tratar_query($query, $this->id_empresa, $this->temp_limit_atraso, $this->exibe_box_atrasos, $this->exibe_box_sem_registros)){
         return true;
      }else{
         return false;
      }
  }


  public function get_config($desc, $id_empresa){
      $sql = new Sql();
      $sql->conn_bd();

      
      $query = mysql_query("SELECT $desc FROM config WHERE id_empresa = ".$id_empresa);
      

      $result = mysql_fetch_array($query);

      $sql->close_conn();
      
      return $result[$desc];
      
  }
  public function atualizaConfig($campo, $valor){
      $sql = new Sql();
      $sql->conn_bd();
      $g = new Glob();
      $query = "UPDATE config SET $campo = '%s' WHERE id_empresa = '".$_SESSION['id_empresa']."' ";
      if($g->tratar_query($query, $valor)){
        $_SESSION['temp_limit_atraso'] = $valor;
        return true;
      }else{
        return false;
      }
      $sql->close_conn();

  }

}
?>