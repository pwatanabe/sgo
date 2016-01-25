<?php
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_maquinario_bd.php");
include_once("../model/class_veiculo_bd.php");
include_once("../model/class_patrimonio_geral_bd.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_material_bd.php");
include_once("../model/class_unidade_medida_bd.php");
include_once("../model/class_produto_bd.php");
	
	$id = $_GET['id'];  //codigo do array passado por parametro
	$whatarray = $_GET['whatarray'];// que array? especifica em qual array sera feita a exclusão: funcionario, patrimonio
  $acao = isset($_GET['acao']) ? $_GET['acao'] : null;
	$total = 0;
	$cont = 0;
        
        if($whatarray == 'material'){// se for igual produto exclui os materiais do adicionar produto
            if($acao == 'cadastrar'){// se for cadastrar exclui a session do cadastrar
                  for($aux = 0; $aux < count($_SESSION['produto'][$whatarray]); $aux++){//percorrendo array escolhido
                  
                    if($_SESSION['produto'][$whatarray][$aux] == $id){// quando encontrar o id escolhido

                        unset($_SESSION['produto'][$whatarray][$aux]);// unset posição do array que contem o id à ser excluido
                    }
                  }
                  foreach ($_SESSION['produto'][$whatarray] as $key => $value) { // percorre o array e reordena-o
                     $array[$cont] = $value;
                     $cont++;
                  }

                  if(isset($array) && count($array > 0))//se existir array
                    $_SESSION['produto'][$whatarray] = $array;// session = array

                  echo '<table style="width:100%" >';
                    for($aux = 0; $aux < count($_SESSION['produto'][$whatarray]); $aux++){ // percorre array de material       
                        if($aux%2==0)//if else para tabela zebrada
                           echo '<tr style="background-color:#ccc;">';
                        else
                           echo '<tr style="background-color:#ddd;">';
                                 $id_qtd_tipo = explode(":",$_SESSION['produto'][$whatarray][$aux]); // separa os valores id e quantidade
                              if($id_qtd_tipo[2] == 'm'){// se for material
                                   $res = new Material();
                                   $res = Material::get_material_id($id_qtd_tipo[0]);
                                   $uni = new Unidade_medida();
                                   $uni = $uni->get_unidade_medida_by_id($res->id_unidade_medida);
                                   echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id)" style="width:70%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"> <span>'.$uni->sigla.'</span></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\', \'cadastrar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                              }else if($id_qtd_tipo[2] == 'p'){// se for produto
                                   $res = new Produto();
                                   $res = $res->get_produto_id($id_qtd_tipo[0]);
                                   echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id)" style="width:70%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\', \'cadastrar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                              }
                              
                          echo '</tr>';
                    }
                    echo '</table>';
            }else{// se for editar exclui a session do editar
                  for($aux = 0; $aux < count($_SESSION['produto']['editar'][$whatarray]); $aux++){//percorrendo array escolhido
                  
                    if($_SESSION['produto']['editar'][$whatarray][$aux] == $id){// quando encontrar o id escolhido

                        unset($_SESSION['produto']['editar'][$whatarray][$aux]);// unset posição do array que contem o id à ser excluido
                    }
                  }
                  foreach ($_SESSION['produto']['editar'][$whatarray] as $key => $value) { // percorre o array e reordena-o
                     $array[$cont] = $value;
                     $cont++;
                  }

                  if(isset($array) && count($array > 0))//se existir array
                    $_SESSION['produto']['editar'][$whatarray] = $array;// session = array

                  echo '<table style="width:100%" >';
                    for($aux = 0; $aux < count($_SESSION['produto']['editar'][$whatarray]); $aux++){ // percorre array de material       
                        if($aux%2==0)//if else para tabela zebrada
                           echo '<tr style="background-color:#ccc;">';
                        else
                           echo '<tr style="background-color:#ddd;">';
                                 $id_qtd_tipo = explode(":",$_SESSION['produto']['editar'][$whatarray][$aux]); // separa os valores id e quantidade
                              if($id_qtd_tipo[2] == 'm'){// se for material
                                   $res = new Material();
                                   $res = Material::get_material_id($id_qtd_tipo[0]);
                                   $uni = new Unidade_medida();
                                   $uni = $uni->get_unidade_medida_by_id($res->id_unidade_medida);
                                   echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id)" style="width:70%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"> <span>'.$uni->sigla.'</span></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\', \'editar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                              }else if($id_qtd_tipo[2] == 'p'){// se for produto
                                   $res = new Produto();
                                   $res = $res->get_produto_id($id_qtd_tipo[0]);
                                   echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id)" style="width:70%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\', \'editar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                              }
                              
                          echo '</tr>';
                    }
                    echo '</table>';
            }


        }else{ // se não, exclui o array de obra
            for($aux = 0; $aux < count($_SESSION['obra'][$whatarray]); $aux++){ //percorrendo array escolhido
            
                if($_SESSION['obra'][$whatarray][$aux] == $id){// quando encontrar o id escolhido

                    unset($_SESSION['obra'][$whatarray][$aux]);// unset posição do array que contem o id à ser excluido
                }
            }
            foreach ($_SESSION['obra'][$whatarray] as $key => $value) { // percorre o array e reordena-o
               $array[$cont] = $value;
               $cont++;
            }

            if(isset($array) && count($array > 0))//se existir array
              $_SESSION['obra'][$whatarray] = $array;// session = array

              echo '<table style="width:100%" >';
              for($aux = 0; $aux < count($_SESSION['obra'][$whatarray]); $aux++){        
                  if($aux%2==0)
                     echo '<tr style="background-color:#ccc;">';
                  else
                    echo '<tr style="background-color:#ddd;">';
                        if($whatarray == 'patrimonio'){// se for array de patrimonio verifica o tipo
                            //$_SESSION['obra']['patrimonio'][$aux] = 'qtd:id:tipo';
                            $tipo_id_qtd = explode(':', $_SESSION['obra'][$whatarray][$aux]);

                            if($tipo_id_qtd[0] == 0){
                               $res = Patrimonio_geral::get_patrimonio_geral_id($tipo_id_qtd[1]);
                               echo '<td ><span>'.$res->nome.': </span></td><td><input  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'" onchange="increment(this.id)" style="width:30%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                            }else if($tipo_id_qtd[0] == 1){
                               $res = Maquinario::get_maquinario_id($tipo_id_qtd[1]);
                               echo '<td><span>'.$res->modelo.': </span></td><td><input readonly  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'"  onchange="increment(this.id)" style="width:30%" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                            }else{
                               $res = Veiculo::get_veiculo_id($tipo_id_qtd[1]);
                               echo '<td><span>'.$res->modelo.': </span></td><td><input readonly  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'"  onchange="increment(this.id)" style="width:30%" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                            }
                        }else if($whatarray == 'funcionario'){ // se for funcionario exibe funcionarios
                            $res = Funcionario::get_func_id($_SESSION['obra'][$whatarray][$aux]);
                            echo '<td ><span>'.$res->nome.': </span></td><td style="text-align:center"><a id="'.$res->id.'" style="cursor: pointer" onclick="apagar(this.id,\''.$whatarray.'\')"><img style="width:15px" src="../images/delete.png"></a></td>';          
                        }else if($whatarray == 'produto'){ // se for produto exibe produtos
                            $id_qtd = explode(':', $_SESSION['obra'][$whatarray][$aux]);// pega id e qtd que estão concatenados na session
                            $res = new Produto();
                            $res = $res->get_produto_id($id_qtd[0]);
                            echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd[1].'" onchange="increment(this.id,\'produto\')" style="background-color: rgba(230,230,230,0.5); width: 70px" type="number" value="'.$id_qtd[1].'"></td><td><a name="'.$res->id.'" title="Clique aqui para ver os materiais desse produto" onclick="exibe(this.name)" style="cursor:pointer"><span>Ver materiais</span></a></td><td><a name="'.$res->id.':'.$id_qtd[1].'" style="cursor:pointer"  onclick="apagar(this.name,\'produto\')"><img style="width:15px" src="../images/delete.png"></a></td>';

                        }
                      
                    echo '</tr>';
              }
              echo '</table>';
        }

  
      
  		
	  	
	
?>



