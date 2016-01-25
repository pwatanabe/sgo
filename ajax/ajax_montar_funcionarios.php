<?php
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_maquinario_bd.php");
include_once("../model/class_veiculo_bd.php");
include_once("../model/class_patrimonio_geral_bd.php");
include_once("../model/class_funcionario_bd.php");

	
	$id = $_GET['id'];  //codigo do estado passado por parametro
	
	$total = 0;
	
  //verifica se ainda não existe funcionario cadastrado
	if(!isset($_SESSION['obra']['funcionario'])){
  		//obra recebe a concatenação do tipo:id:quantidade
  		$_SESSION['obra']['funcionario'][0] = $id;
	}else{
  		$total = count( $_SESSION['obra']['funcionario'] );
  		$verifica = 0;// verificará se existe um
      for($aux = 0; $aux < $total ; $aux++){//percorre o array
          $id_array = $_SESSION['obra']['funcionario'][$aux];// pega id do patrimonio da posição atual
          if($id == $id_array){
            $verifica++;
          }
      }
      if($verifica > 0){
        echo '<script>alert("Você já adicionou esse funcionario")</script>';
      }else{
          $_SESSION['obra']['funcionario'][$total] = $id;
      }
	}
  

	echo '<table style="width:100%" >';
  	for($aux = 0; $aux < count($_SESSION['obra']['funcionario']); $aux++){
      	    // echo 'ID: '.$tipo_id_qtd[1].' Tipo: '.$tipo_id_qtd[0].' Quantidade: '.$tipo_id_qtd[2].'<br />';
      	if($aux%2==0)
           echo '<tr style="background-color:#ccc;">';
        else
          echo '<tr style="background-color:#ddd;">';
      			 $res = Funcionario::get_func_id($_SESSION['obra']['funcionario'][$aux]);
      			 echo '<td ><span>'.$res->nome.': </span></td><td style="text-align:center"><a style="cursor:pointer" id="'.$res->id.'" onclick="apagar(this.id,\'funcionario\')"> <img style="width:15px" src="../images/delete.png"></a></td>';      		
      		echo '</tr>';
  	}
  	echo '</table>';
      // echo 'ID: '.$id.' TIPO: '.$tipo.'<br />';
  		
	  	
	
?>



