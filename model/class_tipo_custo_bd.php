<?php

include_once("../model/class_sql.php");
require_once("../global.php");

class Tipo_custo {

    public $id;
    public $tipo;
    

    public function add_tipo_custo($tipo) {
        $this->tipo = $tipo;        
    }

    public function add_tipo_custo_bd() {
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $query = "INSERT INTO tipo_custo (tipo) VALUES ('%s')";

        $result = $g->tratar_query($query, $this->tipo); //inserindo no banco de dados

        $query = "SELECT * FROM tipo_custo order by id desc";
        $result = $g->tratar_query($query); //pegando id da ultima insersão

        if (@mysql_num_rows($result) == 0) {
            return false;
        } else {
            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $id = $row['id'];
            $tipo = $row['tipo'];
           
            return $id;
        }
    }

    public function atualiza_tipo_custo($tipo, $id) {
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();
        $query = "UPDATE tipo_custo SET tipo = '%s' WHERE id = '%s' ";

        return $g->tratar_query($query, $tipo, $id);
    }

    public function get_tipo_custo_id($id) {
        $sql = new Sql();
        $sql->conn_bd();
        $g = new Glob();

        $query = "SELECT * FROM tipo WHERE id= '%s'";
        $result = $g->tratar_query($query, $id);

        if (@mysql_num_rows($result) == 0) {

            return false;
        } else {

            $row = mysql_fetch_array($result, MYSQL_ASSOC);
            $this->id = $row['id'];
            $this->tipo = $row['tipo'];
           
            return $this;
        }
    }

    public function get_all_tipo_custo() {
        $sql = new Sql();
        $sql->conn_bd();
        $aux = 0;
        $query = mysql_query("SELECT * FROM tipo_custo");

        while ($result = mysql_fetch_array($query)) {
            $return[$aux][0] = $result['id'];
            $return[$aux][1] = $result['tipo'];
           
            $aux++;
        }
        return $return;
    }

}

?>