<?php
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_maquinario_bd.php");
include_once("../model/class_veiculo_bd.php");
include_once("../model/class_patrimonio_geral_bd.php");


	
	$id = $_GET['id'];  //codigo do estado passado por parametro
	$quantidade = $_GET['qtd'];
  $tipo = isset($_GET['tipo']) ? $_GET['tipo'] : null;
  $whatarray = isset($_GET['whatarray']) ? $_GET['whatarray'] : null;

  if($whatarray == 'patrimonio'){//para incrementar patrimonio
      for($aux = 0; $aux < count($_SESSION['obra']['patrimonio']); $aux++){
            $tipo_id = explode(":", $_SESSION['obra']['patrimonio'][$aux]);
            
            if($tipo_id[1] == $id && $tipo_id[0] == $tipo){
              // echo $tipo.':'.$id.':'.$quantidade.' Incrementa<br>';
               $_SESSION['obra']['patrimonio'][$aux] = $tipo.':'.$id.':'.$quantidade;
            }
      }
  }else if($whatarray == 'produto'){//para incrementar produto
      for($aux = 0; $aux < count($_SESSION['obra']['produto']); $aux++){
            $id_qtd = explode(":", $_SESSION['obra']['produto'][$aux]);
            if($id_qtd[0] == $id){
               $_SESSION['obra']['produto'][$aux] = $id.':'.$quantidade;
            }
      }
  }
	  	
	
?>

