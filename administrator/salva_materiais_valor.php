<?php
session_start();
include_once("../model/class_valor_custo_bd.php");
include_once("../model/class_custo_regiao_bd.php");
include_once("../model/class_tipo_custo_bd.php");
include_once("../model/class_cidade_bd.php");


function moeda($get_valor){    // função para transformar o dado do input igual o do banco

$source = array('.', ',','R$');
$replace = array('', '.','');

$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
return $valor; //retorna o valor formatado para gravar no banco
}
 
 $cont = 0;

foreach ($_POST as $key => $value) { // for each que alimenta as variaveis que precisa adicionar no banco

   if($key == 'backto'){
    // echo "<script>alert('backto');</script>";
        continue;
   }
   
   $tipo = explode(":",$key);
   
   $id_material = $tipo[0];
    
    if($tipo[1] == "regiao"){
        $regiao = explode(":", $value);      
        //*Regiao [0] é Código*//
        //*Regiao [1] é id*//
        $cont++;
    }
    if($tipo[1] == "medida"){
       $medida = $tipo[0];       
        $cont++;        
    }
   
    if($tipo[1] == "valor_custo"){
        $value = moeda($value);        
        $valor_custo = $value;
        $cont++;
    }
 
    if($cont == 3 && $valor_custo != ""){
       
        
        $id_empresa = $_SESSION['id_empresa'];        
        $vlr_custo = new Valor_custo();
        $custo_regiao = new Custo_regiao();
        $natualiza = 0; // Encrementa quando adiciona ou atualiza pra nao atualizar duas vezes
        $tipo_comparacao = "";              
        $valor_comparacao = ""; 
        $id_valor_custo = "";      

               $id_valor_custo = $custo_regiao->get_valor_regiao($id_material, $regiao[1], $id_empresa); // condição para verificar se existe material com preo para essa cidade
              
                   if($id_valor_custo[0][0] != ""){
                       $v_c = new Valor_custo();
                       // echo "<script>alert('".$id_valor_custo[0][0]."');</script>";
                       $v_c = $v_c->get_valor_custo_id($id_valor_custo[0][0]);
                       $tipo_comparacao = $v_c->id_tipo_custo;
                       $valor_comparacao = number_format($v_c->valor, 2, ',', '.');
                       $valor_comparacao = moeda($valor_comparacao);
                       
                   }
                   if($valor_custo != "" && $id_valor_custo[0][0] =="" ){ // condição para adição se não houver materiais para essa cidade                   
                    $vlr_custo->add_valor_custo($valor_custo, 0);
                        $id_vlr_custo = $vlr_custo->add_valor_custo_bd();
                        if($id_material != "" && $id_vlr_custo != "" && $id_empresa != ""){
                            $custo_regiao->add_custo_regiao($id_material, $id_vlr_custo, $regiao[1], $id_empresa);
                            $custo_regiao->add_custo_regiao_bd();
                            $natualiza = 1;
                        }
                  }
                 
                  if($valor_custo != $valor_comparacao &&  $natualiza == 0){ // condição para atualizar o valor custo                      
                    $vlr_custo->add_valor_custo($valor_custo, 0);
                    $id_valor_custo = $vlr_custo->add_valor_custo_bd(); 
                    $custo_regiao->atualiza_custo_regiao_bd($id_valor_custo, $id_material, $regiao[1]);
                    $natualiza = 1;
                  }
                  
        $natualiza = 0;              
        $tipo_comparacao = "";              
        $valor_comparacao = ""; 
        $cont = 0;

    }
    //** COMEÇAR DAQUI PRA BAIXO **//
    
//    if($cont == 4 && $valor_custo !=""){ // inicio do for each se esta com objeto completo e se entra foi encrementado    
//  
//     $id_empresa = $_SESSION['id_empresa'];
//     $cidade = new Cidade();
//     $id_estado = $cidade->get_city_by_id($id_cidade);     
//     $vlr_custo = new Valor_custo();
//     $custo_regiao = new Custo_regiao();
//     $natualiza = 0; // Encrementa quando adiciona ou atualiza pra nao atualizar duas vezes
//     $tipo_comparacao = "";              
//     $valor_comparacao = ""; 
//     $id_valor_custo = "";      
//                   
//            $id_valor_custo = $custo_regiao->get_valor_regiao($id_material, $id_cidade, $id_empresa); // condição para verificar se existe material com preo para essa cidade
//                if($id_valor_custo[0][0] != ""){
//                    $v_c = new Valor_custo();
//                    $v_c = $v_c->get_valor_custo_id($id_valor_custo[0][0]);
//                    $tipo_comparacao = $v_c->id_tipo_custo;
//                    $valor_comparacao = number_format($v_c->valor, 2, ',', '.');
//                    $valor_comparacao = moeda($valor_comparacao);                   
//                }
// 
//                  
//                if($valor_custo != "" && $id_valor_custo[0][0] =="" ){ // condição para adição se não houver materiais para essa cidade                   
//                    $vlr_custo->add_valor_custo($valor_custo, $tipo_custo);
//                        $id_vlr_custo = $vlr_custo->add_valor_custo_bd();
//                        if($id_material != "" && $id_vlr_custo != "" && $id_empresa != ""){
//                            $custo_regiao->add_custo_regiao($id_material, $id_vlr_custo, $id_cidade, $id_estado->estado, $id_empresa);
//                            $custo_regiao->add_custo_regiao_bd();
//                            $natualiza = 1;
//                        }
//                  }
//                  if($valor_custo != $valor_comparacao &&  $natualiza == 0){ // condição para atualizar o valor custo                      
//                    $vlr_custo->add_valor_custo($valor_custo, $tipo_custo);
//                    $id_valor_custo = $vlr_custo->add_valor_custo_bd(); 
//                    $custo_regiao->atualiza_custo_regiao_bd($id_valor_custo, $id_material, $id_cidade);
//                    $natualiza = 1;
//                  }
//             
//                  if($tipo_custo != $tipo_comparacao && $natualiza == 0){ // condição para atualizar o tipo do valor                      
//                    $vlr_custo->add_valor_custo($valor_custo, $tipo_custo);
//                    $id_valor_custo = $vlr_custo->add_valor_custo_bd(); 
//                    $custo_regiao->atualiza_custo_regiao_bd($id_valor_custo, $id_material, $id_cidade);                   
//                  }
//
//     $natualiza = 0;              
//     $tipo_comparacao = "";              
//     $valor_comparacao = ""; 
//     $cont = 0;
//    }        
    if($cont == 3 ){
        $cont = 0;
    }
}
    if(isset($_POST['backto'])){
        echo '<script>window.location = "add_obra?t='.$_POST['backto'].'"</script>';
    }else{
        echo '<script>window.location = "add_material.php?regiao='.$regiao[0].'"</script>';
    }
   

?>