<?php
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_maquinario_bd.php");
include_once("../model/class_veiculo_bd.php");
include_once("../model/class_patrimonio_geral_bd.php");
include_once("../model/class_funcionario_bd.php");


	
	$id = $_GET['id'];  //codigo do estado passado por parametro
	$tipo = $_GET['tipo'];

	$total = 0;
	
  //verifica se ainda não existe patrimonio cadastrado
	if(!isset($_SESSION['obra']['patrimonio'])){
  		//obra recebe a concatenação do tipo:id:quantidade
  		$_SESSION['obra']['patrimonio'][0] = $tipo.':'.$id.':1';
      if($tipo == 1){ //maquinario
            $res = Maquinario::get_maquinario_id($id);
            
            if(Funcionario::verifica_func_id($res->id_responsavel)){ //verifica se existe esse responsavel cadastrado
                $verifica = 0;
                if(isset($_SESSION['obra']['funcionario'])){//verifica se existe algum funcionario cadastrado
                    for($aux = 0; $aux < count($_SESSION['obra']['funcionario']) ; $aux++ ){
                        if($res->id_responsavel == $_SESSION['obra']['funcionario'][$aux]){// percorre o vetor e verifica se existe um igual
                          $verifica++;
                        }
                    }
                    if($verifica == 0){                    
                        $_SESSION['obra']['funcionario'][(isset($_SESSION['obra']['funcionario']))?count($_SESSION['obra']['funcionario']):0] = $res->id_responsavel;//adicionando na obra o funcionario responsavel pelo patrimonio
                    }
                }else{
                    $_SESSION['obra']['funcionario'][(isset($_SESSION['obra']['funcionario']))?count($_SESSION['obra']['funcionario']):0] = $res->id_responsavel;//adicionando na obra o funcionario responsavel pelo patrimonio
                }
            }
      }else if($tipo == 2){ //veiculos
            $res = Veiculo::get_veiculo_id($id);
            if(Funcionario::verifica_func_id($res->id_responsavel)){//verifica se existe esse responsavel cadastrado
                $verifica = 0;
                if(isset($_SESSION['obra']['funcionario'])){//verifica se existe algum funcionario cadastrado
                    for($aux = 0; $aux < count($_SESSION['obra']['funcionario']) ; $aux++ ){
                        if($res->id_responsavel == $_SESSION['obra']['funcionario'][$aux]){
                          $verifica++;
                        }
                    }
                    if($verifica == 0){

                        $_SESSION['obra']['funcionario'][(isset($_SESSION['obra']['funcionario']))?count($_SESSION['obra']['funcionario']):0] = $res->id_responsavel;//adicionando na obra o funcionario responsavel pelo patrimonio
                        
                    }
                }else{
                    $_SESSION['obra']['funcionario'][(isset($_SESSION['obra']['funcionario']))?count($_SESSION['obra']['funcionario']):0] = $res->id_responsavel;//adicionando na obra o funcionario responsavel pelo patrimonio
                }
            }
      }
	}else{
  		$total = count( $_SESSION['obra']['patrimonio'] );
      $verifica = 0;// verificará se existe um
      for($aux = 0; $aux < count( $_SESSION['obra']['patrimonio'] ); $aux++){//percorre o array
          $id_array = explode(":", $_SESSION['obra']['patrimonio'][$aux]);// pega id do patrimonio da posição atual
          if($id == $id_array[1] && $tipo == $id_array[0]){
            $verifica++;
          }
      }
      if($verifica > 0){
  		  echo '<script>alert("Você já adicionou esse patrimonio")</script>';
      }else{
          $_SESSION['obra']['patrimonio'][$total] = $tipo.':'.$id.':1';
          //verifica se é maquinario ou veiculo para adicionar seus respectivos responsaveis à obra
          if($tipo == 1){// maquinario
                $res = Maquinario::get_maquinario_id($id);
                if(Funcionario::verifica_func_id($res->id_responsavel)){//verifica se existe esse responsavel cadastrado
                    $verifica = 0;
                    if(isset($_SESSION['obra']['funcionario'])){ //verifica se existe algum funcionario cadastrado
                        for($aux = 0; $aux < count($_SESSION['obra']['funcionario']) ; $aux++ ){
                            if($res->id_responsavel == $_SESSION['obra']['funcionario'][$aux]){// percorre o vetor e verifica se existe um igual
                              $verifica++;
                            }
                        }
                        if($verifica == 0){
                            
                            $_SESSION['obra']['funcionario'][(isset($_SESSION['obra']['funcionario']))?count($_SESSION['obra']['funcionario']):0] = $res->id_responsavel;//adicionando na obra o funcionario responsavel pelo patrimonio
                        }
                    }else{
                        $_SESSION['obra']['funcionario'][(isset($_SESSION['obra']['funcionario']))?count($_SESSION['obra']['funcionario']):0] = $res->id_responsavel;//adicionando na obra o funcionario responsavel pelo patrimonio
                    }
                }
          }else if($tipo == 2){//veiculos
                $res = Veiculo::get_veiculo_id($id);
                if(Funcionario::verifica_func_id($res->id_responsavel)){//verifica se existe esse responsavel cadastrado
                    $verifica = 0;

                    if(isset($_SESSION['obra']['funcionario'])){//verifica se existe algum funcionario cadastrado
                        for($aux = 0; $aux < count($_SESSION['obra']['funcionario']) ; $aux++ ){
                            if($res->id_responsavel == $_SESSION['obra']['funcionario'][$aux]){
                              $verifica++;
                            }
                        }
                        if($verifica == 0){
                            $_SESSION['obra']['funcionario'][(isset($_SESSION['obra']['funcionario']))?count($_SESSION['obra']['funcionario']):0] = $res->id_responsavel;//adicionando na obra o funcionario responsavel pelo patrimonio
                        }
                    }else{
                          $_SESSION['obra']['funcionario'][(isset($_SESSION['obra']['funcionario']))?count($_SESSION['obra']['funcionario']):0] = $res->id_responsavel;//adicionando na obra o funcionario responsavel pelo patrimonio
                    }
                }
          }
      }
	}
  
  


	echo '<table style="width:100%">';
  	for($aux = 0; $aux < count($_SESSION['obra']['patrimonio']); $aux++){
  		$tipo_id_qtd = explode(':', $_SESSION['obra']['patrimonio'][$aux]);
  	    // echo 'ID: '.$tipo_id_qtd[1].' Tipo: '.$tipo_id_qtd[0].' Quantidade: '.$tipo_id_qtd[2].'<br />';

  		if($aux%2==0)
           echo '<tr style="background-color:#ccc;">';
      else
          echo '<tr style="background-color:#ddd;">';
  		if($tipo_id_qtd[0] == 0){
  			 $res = Patrimonio_geral::get_patrimonio_geral_id($tipo_id_qtd[1]);
  			 echo '<td ><span>'.$res->nome.': </span></td><td><input  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'" onchange="increment(this.id,\'patrimonio\')" style="width:30%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
  		}else if($tipo_id_qtd[0] == 1){
  			 $res = Maquinario::get_maquinario_id($tipo_id_qtd[1]);
         echo '<td><span>'.$res->modelo.': </span></td><td><input readonly  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'"  onchange="increment(this.id,\'patrimonio\')" style="width:30%" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
  		}else{
  			 $res = Veiculo::get_veiculo_id($tipo_id_qtd[1]);
  			 echo '<td><span>'.$res->modelo.': </span></td><td><input readonly  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'"  onchange="increment(this.id,\'patrimonio\')" style="width:30%" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
  		}
  		echo '</tr>';
  		// if(count($patrimonio)>1)
  		// 	for($aux = 0; $aux < count($patrimonio); $aux++ ){
  		// 			echo 'id '. $patrimonio[$aux][1].'<br />';
  		// 	}
  		// else
  		// 	echo 'id '. $patrimonio[0][1].'<br />';
  	}
  	echo '</table>';
      // echo 'ID: '.$id.' TIPO: '.$tipo.'<br />';
  		
	  	
	
?>



