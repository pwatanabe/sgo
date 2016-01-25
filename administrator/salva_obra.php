<?php 
session_start();
include_once("../model/class_obra.php");
include_once("../model/class_obra_produtos.php");
include_once("../model/class_obra_patrimonios.php");
include_once("../model/class_obra_funcionarios.php");
	
     echo 'Dados Obra: ';
     $obra_dados = new Obra();
     $obra_dados->add_dados_obra();
     $id_obra = $obra_dados->add_dados_obra_bd();
     if($id_obra) echo 'Sucesso<br />';
     //adiciona obra no banco e pega id_obra
     echo '<hr>';
     echo '<br />';
     echo 'Produtos Obra: ';
     $lista_produtos = Obra_produtos::add_obra_produtos($id_obra);
     foreach ($lista_produtos as $key => $value) {
          if($value->add_obra_produtos_bd()){
               echo 'Sucesso<br />';
          }
     }
     // print_r($lista_produtos);
     echo '<hr>';
     echo '<br />';
     echo 'Patrimonios Obra: ';
     Obra_patrimonios::add_patrimonio_bd($id_obra);
     echo '<hr>';
     echo '<br />';
     echo 'Funcionarios Obra: ';
     $lista_funcionarios = Obra_funcionario::add_funcionarios_obra($id_obra);
     foreach ($lista_funcionarios as $key => $value) {
          if($value->add_funcionarios_bd()){
               echo "Sucesso";
          }
     }
     // print_r($lista_funcionarios);

     foreach ($_POST as $key => $value) {
          echo "$key: $value 
          ";
     }

     // $obra_dados->printObraSession();

     // unset($_SESSION['obra']);

     // echo "<script>window.location='add_obra?t=sucess';</script>";
 	