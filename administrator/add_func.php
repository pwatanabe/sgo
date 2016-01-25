<?php
session_start();
include("restrito.php");
include_once("../model/class_exame_bd.php");
include_once("../model/class_cboXexames.php");
include_once("../model/class_rend_double_select.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");
include_once("../model/class_filial_bd.php");
include_once("../model/class_cbo_bd.php");
include_once("../model/class_cidade_bd.php");
include_once("../model/class_estado_bd.php");
include_once("../model/class_endereco_bd.php");
include_once("../model/class_empresa_bd.php");
include_once("../model/class_banco.php");
include_once("../model/class_valor_custo_bd.php");
include_once("../model/class_tipo_custo_bd.php");
include_once("../includes/functions.php");
include_once("../includes/util.php");

function validate(){
   if(!isset($_POST['codigo']) || $_POST['codigo'] == ""){
         return false;
   }
   if(!isset($_POST['nome']) || $_POST['nome'] == ""){
         return false;
   }
   if(!isset($_POST['cpf']) || $_POST['cpf'] == ""){
       return false;
   }
   if(!isset($_POST['telefone']) || $_POST['telefone'] == ""){
       return false;
   }
   if(!isset($_POST['valor_custo']) || $_POST['valor_custo'] == ""){
       return false;
   }
    if(!isset($_POST['tipo_custo']) || $_POST['tipo_custo'] == ""){
       return false;
   }
   if(!isset($_POST['email']) || $_POST['email'] == ""){
       return false;
   }
   // if(!isset($_POST['senha']) || $_POST['senha'] == ""){
   //     return false;
   // }
   if(!isset($_POST['empresa_filial']) || $_POST['empresa_filial'] == "Selecione a empresa_filial"){
       return false;
   }
   if(!isset($_POST['turno']) || $_POST['turno'] == "Selecione um turno"){
       return false;
   }
   if(!isset($_POST['cbo']) || $_POST['cbo'] == "Selecione um cbo"){
       return false;
   }
   if(!isset($_POST['rua']) || $_POST['rua'] == ""){
       return false;
   }
   if(!isset($_POST['num']) || $_POST['num'] == ""){
       return false;
   }
   if(!isset($_POST['estado']) || $_POST['estado'] == "Selecione um estado"){
       return false;
   }
   if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar" && Funcionario::verificaCodDup($_POST['codigo'])){
      echo "<script>alert('Codigo Duplicado');</script>";
      return false;
   }

   return true;
}

function moeda($get_valor){    // função para desmembrar e guardar no banco

$source = array('.', ',','R$');
$replace = array('', '.','');

$valor = str_replace($source, $replace, $get_valor); //remove os pontos e substitui a virgula pelo ponto
return $valor; //retorna o valor formatado para gravar no banco
}

?>
<html>

<?php Functions::getHead('Adicionar'); //busca <head></head> da pagina, $title é o titulo da pagina ?>

<!-- <head>
   <title>Adicionar</title>
   <meta charset="UTF-8">
   
   <link rel="stylesheet" type="text/css" href="styles/style.css">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   
   <link href='http://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
   <link href='http://fonts.googleapis.com/css?family=Wallpoet' rel='stylesheet' type='text/css'>

</head> -->

<?php  Functions::getScriptFuncionario(); //carrega funções javascript da pagina?>


<script>
$(document).ready(function(){
    $("#mostracbo").click(function(){
        $("#divcbo").fadeToggle();       
    });  
      $("#mostraturno").click(function(){
        $("#divturno").fadeToggle();       
    });  
    
    $("#sem_hor_almoco").click(function(){
        $("#almoco").fadeToggle();
        $("#ini_alm_h").val("");
        $("#ini_alm_m").val("");
        $("#fim_alm_h").val("");
        $("#fim_alm_m").val("");
        $("#almoco2").fadeToggle();
    });  
    
});
 

</script>

<body onload="disparaLoadCidade(), carregaMascaras()">


            <?php include_once("../view/topo.php"); ?>
              <?php 
                  //verifica se todas as dependencias do funcionario estão cadastradas
                  $cbo = new Cbo();
                  $cbos = $cbo->get_name_all_cbo();
                  $cont = 0;
                  $msg = 'ATENÇÃO!\n\nPara cadastrar um funcionário é necessario:\n\n';
                  if(!$cbos){
                     $msg .= ($cont+1).'º Cadastrar um CBO (Cadastro Brasileiro de Ocupações)\n';
                     $cont++;
                  }

                  $turno = new Turno();
                  $turnos = $turno->get_name_all_turno();

                  if(!$turnos){
                     $msg .= ($cont+1).'º Cadastrar um Turno';
                     $cont++;
                  }
                  
                  if($cont > 0)
                    echo '<script>alert("'.$msg.'");</script>';
               ?>
            
              <?php if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){ ?> <!-- EDITAR FUNCIONARIO -->
                <div class='formulario' style="width:500px;">
                  <?php 
                     $func = new Funcionario();
                     $func = $func->get_func_id($_GET['id']);//buscando funcionario no banco
                     $endereco = new Endereco();
                     $endereco = $endereco->get_endereco( $func->id_endereco );
                     $banco = Banco::get_banco_by_id($func->id_dados_bancarios);
                     
                     if($func->id_valor_custo != 0){                                            
                        $valor_custo = new Valor_custo();
                        $valor_custo = $valor_custo->get_valor_custo_id($func->id_valor_custo);
                     }else{
                          $valor_custo = new Valor_custo();                          
                     }
                      // $endereco[0][0] Rua
                      // $endereco[0][1] Numero
                      // $endereco[0][2] Cidade
                      // $endereco[0][3] Estado

                     echo '<input type="hidden" id="id_cidade" value="'.$endereco[0][2].'">';
                     echo '<input type="hidden" id="id_posto" value="'.$func->id_empresa_filial.'">';
                    
                     
                     // echo $func->printFunc();
                   ?>
                  <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="60px" style="margin-left:-20px; margin-top:-20px;"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR FUNCIONÁRIO</span></div></div>
                  <form method="POST" id="ad_func" name="ad_func" action="add_func" onsubmit="return valida(this)">
                    <div id="popup" class="popup" style="float:left">
                      <div class="formulario" style="width:350px; min-width:350px;">
                        <table style="width:100%; text-align:center;" border="0">
                            <input type="hidden" id="id_banco" name="id_banco" value="<?php echo $banco->id ?>">
                           <tr><td colspan='2'><b>Dados Bancários</b></td></tr>
                           <tr><td><label>Banco:</label></td><td><input type="text" style="width:100%" name="banco" value="<?php  ($banco)?print $banco->banco:'' ?>"></td></tr>
                           <tr><td><label>Ag:</label></td><td><input type="text" style="width:100%" name="agencia" value="<?php ($banco)?print $banco->agencia:'' ?>"></td></tr>
                            <tr><td> <label>Op:</label></td><td><input type="text" style="width:100%" name="operacao" value="<?php ($banco)?print $banco->operacao:'' ?>"></td></tr>
                           <tr><td><label>Conta:</label></td><td><input type="text" style="width:100%" name="conta" value="<?php ($banco)?print $banco->conta:'' ?>"></td></tr>
                           <tr><td colspan='2'><input onclick="fechar()" type="button"  class="button" value="Concluir" ></td></tr>
                         </table>
                      </div>
                </div>
                  <input type="hidden" id="tipo" name="tipo" value="editar">
                  <input type="hidden" id="id_func" name="id_tabela" value="<?php echo $func->id_tabela; ?>">
                  <input type="hidden" id="id_func" name="id_func" value="<?php echo $func->id; ?>">
                  <input type="hidden" id="id_endereco" name="id_endereco" value="<?php echo $func->id_endereco; ?>">
                  <input type="hidden" id="id_custo" name="id_custo" value="<?php echo $valor_custo->id ?>">
                  <table border='0'>
                    <tr><td colspan="4" style="padding-top:10px; padding-bottom:10px;"><span style="color:#565656">Atenção: Se o campo senha ficar em branco a senha não sera alterada</span></td></tr>
                     <tr> <td><span>Estagiario:</span></td> <td colspan="3"><input class="checkbox" type="checkbox" <?php ($func->estagiario == 1) ? print 'checked': print '' ?> value="<?php ($func->estagiario == 1)?print '1': print '0' ?>" id="estagiario" onclick="mudaValor()" name="estagiario"></td></tr> <!-- estagiario -->
                     <tr> <td><span>Código:*</span></td> <td colspan="3"><input autofocus style="width:100%; text-transform: uppercase" type="text" id="codigo" name="codigo" value="<?php echo $func->cod_serie; ?>"></td></tr> <!-- cod_serie -->
                     <tr> <td><span>Nome:*</span></td> <td colspan="3"><input style="width:100%" type="text" id="nome" name="nome" value="<?php echo $func->nome; ?>"></td></tr> <!-- nome -->
                     <tr> <td><span>CPF:*</span></td> <td colspan="3"><input style="width:100%" type="text" id="cpf" name="cpf" value="<?php echo $func->cpf; ?>"></td></tr> <!-- CPF -->
                     <tr> <td><span>CNH:</span></td> <td colspan="3"><input style="width:100%" type="text" id="cnh" name="cnh" value="<?php echo $func->cnh; ?>"></td></tr> <!-- CPF -->
                     <tr> <td><span>RG:</span></td> <td><input type="text" id="rg" name="rg" value="<?php echo $func->rg; ?>"></td><td><span>Org.Em:</span></td><td><input style="width:100px; text-transform: uppercase;" type="text" id="org_em_rg" name="org_em_rg" value="<?php echo $func->org_em_rg; ?>"></td></tr> <!-- RG -->
                     <tr> <td><span>Data Em. RG:</span></td> <td colspan="3"><input type="date" id="data_em_rg" name="data_em_rg" value="<?php echo $func->data_em_rg; ?>" title="Data de emissão do RG"></td></tr> <!-- data de emissão do rg -->
                     <tr> <td><span>Título Eleitoral:</span></td> <td colspan="3"><input type="text" id="titu_eleitoral" name="titu_eleitoral" value="<?php echo $func->num_tit_eleitor; ?>"></td></tr> <!-- Numero do titulo eleitoral -->
                     <tr> <td><span>Data Nasc.:*</span></td> <td><input type="date" id="data_nasc" name="data_nasc" value="<?php echo $func->data_nasc; ?>"></td></tr> <!-- data nacimento -->
                     <tr> <td><span>Telefone:*</span></td> <td><input type="text" id="telefone" name="telefone" value="<?php echo $func->telefone; ?>"></td></tr> <!-- telefone -->
                     <tr> <td><span>Email Pessoal:*</span></td> <td colspan="3"><input style="width:100%" type="email" id="email" name="email" value="<?php echo $func->email; ?>"></td></tr> <!-- email -->
                     <tr> <td><span>Email Empresarial:*</span></td> <td colspan="3"><input style="width:100%" type="email" id="email_emp" name="email_emp" value="<?php echo $func->email_empresa; ?>"></td></tr> <!-- email empresarial -->
                     <tr> <td><span>Senha:*</span></td> <td><input type="text" id="senha" name="senha"></td></tr> <!-- senha -->
                     <tr>
                        <td><span>Empresa:*</span></td>
                        <td colspan="3">
                           <?php //buscar array de CBO
                              $empresa = new Empresa();
                              $empresas = $empresa->get_all_empresa();
                           ?>
                           <select name="empresa" id="empresa" onchange="carrega_postos()" style="width:130px">
                              <?php 
                                 foreach($empresas as $key => $empresa){
                                    echo '<option value="'.$empresas[$key][0].'">'.$empresas[$key][2].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        <span>Data Adm.:*</span><input type="date" id="data_admissao" style="width: 130px;" name="data_admissao" value="<?php echo $func->data_adm; ?>" title="Data de admissão do funcionário"></td>
                        <?php echo "<script> carregaEmpresa('".$func->id_empresa."') </script>";  ?>
                     </tr>
                     <tr>
                        <td><span>Posto de trabalho:</span></td>
                        <td colspan="3">
                           <div id="load_postos">
                             <select name="empresa_filial" id="empresa_filial">
                               <option value="no_sel">Selecione uma empresa</option>
                             </select>
                           </div>
                        </td>
                        <?php echo '<script> buscar_postos('.$func->id_empresa.'); </script>'; ?> 
                     </tr>
                     
                     <tr> <td colspan="4"><span><a title="Clique aqui para cadastrar dados bancários" onclick="exibe()" style="cursor:pointer"><div style="float:left"><img width="20px;" src="../images/icon-edita.png"></div><div style="float:left; margin-top:3px; margin-left:5px;">Editar dados bancários</div></a></span></td> </tr>
                     <tr> <td><span><div id="salario">Salário Base:</div></span></td> <td><input type="text" id="sal_base" onkeyup="mascara(this, mvalor);" name="sal_base" value="<?php if($func->salario_base!= ""){ echo'R$ ' . number_format($func->salario_base, 2, ',', '.');}?>" required></td></tr> <!-- Salário base -->
                     <tr><td><span>Valor de Custo:</span></td><td><input type="text" onkeyup="mascara(this, mvalor);" name="valor_custo" id="valor_custo" value="<?php if($valor_custo->valor != ""){ echo 'R$ ' . number_format($valor_custo->valor, 2, ',' , '.'); }?>"></td>
                                  <td>
                                    <select id="tipo_custo" name="tipo_custo"  style="width:100%">
                                    <option value="no_sel">Selecione</option>
                                        <?php 
                                           $tipo_custo = new Tipo_custo();
                                           $tipo_custo = $tipo_custo->get_all_tipo_custo();                                       
                                           foreach ($tipo_custo as $key => $value) {
                                               echo '<option value="'.$value[0].'">'.$value[1].'</option>';
                                           }
    //                                       for ($i=0; $i < count($empresa) ; $i++) { 
    //                                          echo '<option value="'.$empresa[$i][0].'">'.$empresa[$i][2].'</option>';
    //                                       }
                                         ?>
                                        <?php echo "<script> carregaTipo_custo('".$valor_custo->id_tipo_custo."'); </script>" ?> 
                                    </select>
                                  </td>
                              </tr>
                     
                     <tr> <td><span>Qtd. Horas Semanais:*</span></td> <td><input type="number" id="qtd_horas_sem" name="qtd_horas_sem" value="<?php echo $func->qtd_horas_sem; ?>"></td></tr> <!-- Quantidade de horas semanais -->
                     <tr> <td><span>Nº PIS:</span></td> <td colspan="3"><input type="text" id="pis" name="pis" value="<?php echo $func->num_pis; ?>"></td></tr> <!-- Numero do PIS -->
                     <tr> 
                        <td><span>Num. Cart. Trab.:</span></td>
                        <td><input type="text" id="num_cart_trab" name="num_cart_trab" value="<?php echo $func->num_cart_trab; ?>"></td>
                        <td colspan="2">
                           <?php //buscar array estados
                              $estado = new Estado();
                              $estados = $estado->get_name_all_uf();
                           ?>
                           <select name="uf_cart_trab" id="uf_cart_trab">
                              <option>Selecione UF</option>
                              <?php 
                                 foreach($estados as $key => $estado){
                                    echo '<option value="'.$estados[$key][0].'">'.$estados[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                        </td>
                        <?php echo "<script> carregaUf_CartTrab('".$func->uf_cart_trab."') </script>";  ?>
                     </tr> <!-- numero da carteira de trabalho -->
                     <tr> <td><span>Num. Série Cart. Trab.:</span></td> <td><input type="text" id="num_serie_cart_trab" name="num_serie_cart_trab" value="<?php echo $func->num_serie_cart_trab; ?>"></td></tr> <!-- numero da carteira de trabalho -->
                     <tr>
                        <td><span>Turno:*</span></td>
                        <td colspan="3">
                           <?php //buscar array de CBO
                              $turno = new Turno();
                              $turnos = $turno->get_name_all_turno();
                           ?>
                           <select name="turno" id="turno" style="width:100%">
                              <option>Selecione um turno</option>
                              <?php 
                                 foreach($turnos as $key => $turno){
                                    echo '<option value="'.$turnos[$key][0].'">'.$turnos[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                       <td><a href="#divturno" id="mostraturno"><img style="cursor: pointer" width="25px" height="25px"src="../images/add.png"></a></td>
                        <?php echo "<script>carregaTurno('".$func->id_turno."') </script>";  ?>
                     </tr>
                     <tr>
                        <td><span>CBO:*</span></td>
                        <td colspan="3">
                           <?php //buscar array de CBO
                              $cbo = new Cbo();
                              $cbos = $cbo->get_name_all_cbo();
                           ?>
                           <select name="cbo" id="cbo" style="width:100%" >
                              <option>Selecione um cbo</option>
                              <?php 
                                 foreach($cbos as $key => $cbo){
                                    echo '<option value="'.$cbos[$key][0].'">'.$cbos[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                        <td><a href="#divcbo" id="mostracbo"><img style="cursor: pointer" width="25px" height="25px"src="../images/add.png"></a></td>
                        <?php echo "<script> carregaCBO('".$func->id_cbo."') </script>";  ?>
                     </tr>
                     <tr>
                        <td> <span>Rua:* </span></td><td colspan="3"><input style="width:260px" type="text" id="rua" name="rua" value="<?php echo $endereco[0][0]; ?>" > <span>Nº:*</span> <input style="width:60px;" type="number" id="num" name="num" value="<?php echo $endereco[0][1]; ?>"> </td>
                     </tr>
                      <tr>
                        <td> <span>Bairro:* </span></td><td colspan="3"><input style="width:210px" type="text" id="bairro" name="bairro" style="width:200px" value="<?php echo $endereco[0][4]; ?>"> <span> CEP </span> <input style="width:100px;" type="text" id="cep" name="cep" value="<?php echo $endereco[0][5]; ?>"> </td>
                     </tr>
                     <tr><td><span>Complemento: </span> </td><td><input  style="width:50%" value="<?php echo $endereco[0][6]; ?>" type="text" id="complemento" name="complemento" ></td></tr> 
                     <tr>
                        <td><span>Estado:*</span></td>
                        <td>
                           <?php 
                              $estado = new Estado();
                              $estados = $estado->get_name_all_uf();
                                
                           ?>
                           <select name="estado" id="estado" onchange="buscar_cidades()">
                              <option value="no_sel">Selecione um estado</option>
                              <?php 
                                 foreach($estados as $key => $estado){
                                    echo '<option value="'.$estados[$key][0].'">'.$estados[$key][1].'</option>';
                                 }
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                        <?php echo "<script> carregaUf('".$endereco[0][3]."') </script>";  ?>
                     </tr>
                     <tr>
                        <td><span>Cidade:*</span></td>
                        <td colspan="3">
                           <div id="load_cidades">
                             <select name="cidade" id="cidade">
                               <option value="0">Selecione um estado</option>
                             </select>
                           </div>
                        </td>
                        <?php echo "<script> buscar_cid('".$endereco[0][3]."'); </script>";  ?>
                     </tr>
                     <tr>
                        <td><span>Supervisor:</span></td>
                        <td>
                           <?php 
                              $admin = new Funcionario();
                              $supervisores = $admin->get_admin();
                           ?>
                           <select name="superv" id="superv">
                              <option>Selecione um supervisor</option>
                              <?php 
                                 foreach($supervisores as $key => $admin){
                                    echo '<option value="'.$supervisores[$key][0].'">'.$supervisores[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                        <?php echo "<script> carregaSuperv('".$func->id_supervisor."') </script>";  ?>
                     </tr>
                     <tr> <td><span>Tornar adiministrador:</span></td>
                          <td>
                            <?php if($func->is_admin == 1){ ?>
                            <input type="checkbox" name="is_admin" checked id="is_admin">
                            <?php }else{ ?>
                            <input type="checkbox" name="is_admin" id="is_admin">
                            <?php } ?>

                          </td> </tr>
                     <tr> 
                           <td colspan="4" style="text-align:center"><input type="submit" name="button" class="button" id="button" value="Salvar">
                             <input class="button" type="button" name="button" onclick="window.location.href='add_func'" id="button" value="Cancelar">
                           </td>
                      </tr>
                  </table>
               </form>
             </div>
             <?php 
                  include_once("informacoes_func.php"); 
                  //exibe uma tabela com dados do funcionario
                  echo '<div class="formulario dir">';
                      
                      $u = new Epi();
                      $epi_func = $u->get_epi_func($func->id);
                      $aux=0;
                      echo '<div style="float:right; margin-top:-10px;"><a title="Clique para adicionar ou alterar equipamentos desse funcionário" href="add_epiXfunc?tipo=cadastrar&id='.$func->id.'"> <div style="float:left"><img style="height:20px;" src="../images/icon-edita.png" ></div><div style="padding-botton:10px; float:left;padding-top:5px;"><span>Editar</span></div></a></div>';
                      echo '<table class="exibe_equipamentos" border="0">';
                      echo '<tr><td colspan="4" style="padding:10px;"><span><b><a title="Clique para adicionar ou alterar equipamentos desse funcionário" href="add_epiXfunc?tipo=cadastrar&id='.$func->id.'">EQUIPAMENTOS CADASTRADOS PARA '.strtoupper($func->nome).'</a></b></span></td></tr>';
                      echo '<tr> <td><span><b>ID</b></span></td> <td><span><b>Nome</b></span></td> <td><span><b>Data da entrega</b></span></td><td><span><b>Quantidade</b></span></td></tr>';
                      foreach ($epi_func as $key => $value) {
                         if($aux%2 == 0)//verifica se o numero é par ou impar, para imprimir a tabela zebrada
                            echo '<tr style="background-color:#aaa"><td><span>'.$epi_func[$key]->id.'</span></td><td><span>'.$epi_func[$key]->nome_epi.'</span></td><td><span>'.$epi_func[$key]->data_entrega.'</span></td><td><span>'.$epi_func[$key]->quantidade.'</span></td></tr>';
                         else
                            echo '<tr style="background-color:#ccc"><td><span>'.$epi_func[$key]->id.'</span></td><td><span>'.$epi_func[$key]->nome_epi.'</span></td><td><span>'.$epi_func[$key]->data_entrega.'</span></td><td><span>'.$epi_func[$key]->quantidade.'</span></td></tr>';
                          $aux++;
                          if($aux>=10)break;
                      }
                      if(count($epi_func) == 0){//nenhum equipamento cadastrado
                          echo '<tr><td colspan="4"><div class="msg">Nenhum equipamento cadastrado</div></td></tr>';
                      }
                      echo '</table>';
                  echo '</div>';
             ?>

              <?php }else{ ?> <!-- CADASTRAR FUNCIONARIO -->
              
              <div class='formulario' style="width:500px;">
                
               <div class="title-box" style="float:left"><div style="float:left"><img src="../images/user_add.png" width="60px" style="margin-left:-20px; margin-top:-20px;"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">CADASTRO DE FUNCIONÁRIOS</span></div></div>
               
               <form method="POST" class="ad_func" name="ad_func" action="add_func" onsubmit="return valida(this)">
                <div id="popup" class="popup" style="float:left">
                      <div class="formulario" style="width:350px; min-width:350px;">
                        <table style="width:100%; text-align:center" border="0">
                           <tr><td colspan='2'><b>Dados Bancários</b></td></tr>
                           <tr><td><label>Banco:</label></td><td><input type="text" name="banco"></td></tr>
                           <tr><td><label>Ag:</label></td><td><input type="text" name="agencia"></td></tr>
                            <tr><td> <label>Op:</label></td><td><input type="text" name="operacao"></td></tr>
                           <tr><td><label>Conta:</label></td><td><input type="text" name="conta"></td></tr>
                           <tr><td colspan='2'><input onclick="fechar()" type="button" class="button" value="Concluir"></td></tr>
                         </table>
                      </div>
                </div>
                <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                  <table border="0">
                    <tr> <td><span>Estagiário:</span></td> <td colspan="3"><input class="checkbox" type="checkbox" value="0" id="estagiario" onclick="mudaValor()" name="estagiario"></td></tr> <!-- estagiario -->
                    <tr> <td><span>Código:*</span></td> <td colspan="3"><input autofocus style="width:100%; text-transform: uppercase" type="text" id="codigo" name="codigo"></td></tr> <!-- cod_serie -->
                     <tr>
                        <td>
                          <span>Nome:*</span>
                        </td>
                        <td colspan="3">
                            <input type="text" id="nome" name="nome" style="width:100%;">
                        </td>
                     </tr> <!-- nome -->
                     <!-- campo input com texto dentro -->
                     <!-- <tr> <td><span>CPF:*</span></td> <td colspan="3"><input style="width:100%;" type="text" id="cpf" name="cpf" value='Insira seu email aqui' onclick="this.value='';" onblur="javascript:if (this.value=='') {this.value='Insira seu email aqui'};"></td></tr> -->
                     <tr> <td><span>CPF:*</span></td> <td colspan="3"><input style="width:100%;" type="text" id="cpf" name="cpf"></td></tr> <!-- CPF -->
                     <tr> <td><span>CNH:</span></td> <td colspan="3"><input style="width:100%;" type="text" id="cnh" name="cnh"></td></tr> <!-- CPF -->
                     <tr> <td><span>RG:</span></td> <td><input type="text" id="rg" name="rg"></td><td><span>Org.Emissor:</span></td><td><input style="width:100%; text-transform: uppercase" type="text" id="org_em_rg" name="org_em_rg" ></td></tr> <!-- RG -->
                     <tr> <td><span>Data Em. RG:</span></td> <td colspan="3"><input type="date" id="data_em_rg" name="data_em_rg"  title="Data de emissão do RG"></td></tr> <!-- data de emissão do rg -->
                     <tr> <td><span>Título Eleitoral:</span></td> <td colspan="3"><input type="text" id="titu_eleitoral" name="titu_eleitoral" ></td></tr> <!-- Numero do titulo eleitoral -->
                     <tr> <td><span>Data Nasc.:*</span></td> <td><input type="date" id="data_nasc" name="data_nasc"></td></tr> <!-- data nacimento -->
                     <tr> <td><span>Telefone:*</span></td> <td><input type="text" id="telefone" name="telefone" ></td></tr> <!-- telefone -->
                     <tr> <td><span>Email Pessoal:*</span></td> <td colspan="3"><input style="width:100%;" type="email" id="email" name="email"></td></tr> <!-- email -->
                     <tr> <td><span>Email empresarial:*</span></td> <td colspan="3"><input style="width:100%;" type="email" id="email_emp" name="email_emp"></td></tr> <!-- email empresa_filialrial -->
                     <tr> <td><span>Senha:*</span></td> <td colspan="3"><input type="password" id="senha" name="senha"></td></tr> <!-- senha -->
                     <tr>
                        <td><span>Empresa:*</span></td>
                        <td colspan="3">
                           <?php //buscar array de CBO
                              $empresa = new Empresa();
                              $empresas = $empresa->get_all_empresa();
                           ?>
                           <select name="empresa" id="empresa" onchange="carrega_postos()">
                              <?php 
                                 foreach($empresas as $key => $empresa){
                                    echo '<option value="'.$empresas[$key][0].'">'.$empresas[$key][2].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        
                        <span>Data Adm.:*</span><input type="date" id="data_admissao" style="width: 130px;" name="data_admissao"  title="Data de admissão do funcionário"></td>
                     </tr>
                     <tr>
                        <td><span>Posto de trabalho:</span></td>
                        <td colspan="3">
                           <div id="load_postos">
                             <select name="empresa_filial" id="empresa_filial">
                               <option value="no_sel">Selecione uma empresa</option>
                             </select>
                           </div>
                        </td>
                     </tr>
                     <tr> <td colspan="4"><span><a onclick="exibe()" title="Clique aqui para editar dados bancários" style="cursor:pointer"><div style="float:left"><img width="20px;" src="../images/add.png"></div><div style="float:left; margin-top:3px; margin-left:5px;">Cadastrar dados bancários</div></a></span></td> </tr>
                     <tr> <td><span><div id="salario">Salário Base:</div></span></td> <td><input type="text" onkeyup="mascara(this, mvalor);" id="sal_base" name="sal_base" required></td></tr> <!-- Salário base -->
                     
                     <tr><td><span>Valor de Custo:</span></td> <td><input onkeyup="mascara(this, mvalor);" type="text" name="valor_custo" id="valor_custo"></td>
                                  <td>
                                      <select id="tipo_custo" name="tipo_custo"  style="width:100%">
                                    <option value="no_sel">Selecione</option>
                                    <?php 
                                       $tipo_custo = new Tipo_custo();
                                       $tipo_custo = $tipo_custo->get_all_tipo_custo();                                       
                                       foreach ($tipo_custo as $key => $value) {
                                           echo '<option value="'.$value[0].'">'.$value[1].'</option>';
                                       }
//                                       for ($i=0; $i < count($empresa) ; $i++) { 
//                                          echo '<option value="'.$empresa[$i][0].'">'.$empresa[$i][2].'</option>';
//                                       }
                                     ?>
                                 </select>
                                      
                                  </td>
                              </tr>
                     
                     <tr> <td><span>Qtd. Horas Semanais:*</span></td> <td><input type="number" id="qtd_horas_sem" name="qtd_horas_sem" ></td></tr> <!-- Quantidade de horas semanais -->
                     <tr> <td><span>Nº PIS:</span></td> <td colspan="3"><input type="text" id="pis" name="pis" ></td></tr> <!-- Numero do PIS -->
                     <tr> 
                        <td><span>Nº Cart. Trab.:</span></td>
                        <td colspan="3"><input type="text" id="num_cart_trab" name="num_cart_trab" style="width:30%;" ><span> Nº Série <span><input type="text" id="num_serie_cart_trab" name="num_serie_cart_trab" style="width:80px">
                        
                           <?php //buscar array estados
                              $estado = new Estado();
                              $estados = $estado->get_name_all_uf();
                              
                           ?>
                           <select name="uf_cart_trab" id="uf_cart_trab">
                              <option>Selecione UF</option>
                              <?php 
                                 foreach($estados as $key => $estado){
                                    echo '<option value="'.$estados[$key][0].'">'.$estados[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                        </td>
                     </tr> <!-- numero da carteira de trabalho -->
                     <!-- <tr> <td><span>Num. Série Cart. Trab.:</span></td> <td><input type="text" id="num_serie_cart_trab" name="num_serie_cart_trab"></td></tr>  numero da carteira de trabalho -->
                     <tr>
                        <td><span>Turno:*</span></td>
                        <td colspan="3">
                           <?php //buscar array de CBO
                              $turno = new Turno();
                              $turnos = $turno->get_name_all_turno();
                           ?>
                           <select name="turno" id="turno">
                              <option>Selecione um turno</option>
                              <?php 
                                 foreach($turnos as $key => $turno){
                                    echo '<option value="'.$turnos[$key][0].'">'.$turnos[$key][2].' - ' .$turnos[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                        <td><a href="#divturno" id="mostraturno"><img style="cursor: pointer" width="25px" height="25px"src="../images/add.png"></a></td>
                     </tr>
                     <tr>
                        <td><span>CBO:*</span></td>
                        <td colspan="3">
                           <?php //buscar array de CBO
                              $cbo = new Cbo();
                              $cbos = $cbo->get_name_all_cbo();
                           ?>
                           <select name="cbo" id="cbo" style="width:80%">
                              <option>Selecione um cbo</option>
                              <?php 
                                 foreach($cbos as $key => $cbo){
                                    echo '<option value="'.$cbos[$key][0].'">'.$cbos[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                        <td><a href="#divcbo" id="mostracbo"><img style="cursor: pointer" width="25px" height="25px"src="../images/add.png"></a></td>
                     </tr>
                   
                     <tr>
                        <td> <span>Rua:* </span></td><td colspan="3"><input type="text" id="rua" name="rua" style="width:70%"> <span> Nº:* </span> <input style="width:65px;" type="number" id="num" name="num" > </td>
                     </tr>
                     <tr>
                        <td> <span>Bairro:* </span></td><td colspan="3"><input type="text" id="bairro" name="bairro" style="width:65%"> <span> CEP </span> <input style="width:80px;" type="text" id="cep" name="cep" > </td>
                     </tr>
                     <tr><td><span>Complemento: </span> </td><td><input  style="width:50%" value="" type="text" id="complemento" name="complemento" ></td></tr> 
                     <tr>
                        <td><span>Estado:*</span></td>
                        <td>
                           <?php //buscar array de CBO
                              $estado = new Estado();
                              $estados = $estado->get_name_all_uf();
                           ?>
                           <select name="estado" id="estado" onchange="buscar_cidades()">
                              <option value="no_sel">Selecione um estado</option>
                              <?php 
                                 foreach($estados as $key => $estado){
                                    echo '<option value="'.$estados[$key][0].'">'.$estados[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                     </tr>
                     <tr>
                        <td><span>Cidade:*</span></td>
                        <td colspan="3">
                           <div id="load_cidades">
                             <select name="cidade" id="cidade">
                               <option value="">Selecione um estado</option>
                             </select>
                           </div>
                        </td>
                     </tr>
                     <tr>
                        <td><span>Supervisor:</span></td>
                        <td colspan="3">
                           <?php //buscar array de CBO
                              $admin = new Funcionario();
                              $supervisores = $admin->get_admin();
                           ?>
                           <select name="superv" id="superv">
                              <option>Selecione um supervisor</option>
                              <?php 
                                 foreach($supervisores as $key => $admin){
                                    echo '<option value="'.$supervisores[$key][0].'">'.$supervisores[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                     </tr>
                     <tr> 
                          <td>
                            <span>Tornar adiministrador:</span></td><td><input type="checkbox" name="is_admin" id="is_admin"></td> </tr>
                     <tr> 
                           <td colspan="4" style="text-align:center"><input type="submit" name="button" class="button" id="button" value="Cadastrar">
                             <input class="button" type="button" name="button" onclick="window.location.href='principal'" id="button" value="Cancelar">
                           </td>
                      </tr>
                  </table>
                  
               </form>

               <?php //fica dentro do cadastrar porque depois que altera o funcionario entra nesse if

                if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar"){
                        
                        if(validate()){
                           $func = new Funcionario();
                           $end = new Endereco();
                           $cod_serie = $_POST['codigo'];
                           $rua = $_POST['rua'];
                           $numero = $_POST['num'];
                           $id_cidade = $_POST['cidade'];
                           $bairro = $_POST['bairro'];
                           $cep = $_POST['cep'];
                           $complemento = $_POST['complemento'];
                           $is_admin = 0;
                           $cnh = $_POST['cnh'];
                           $end->add_endereco($rua, $numero, $id_cidade, $bairro, $cep, $complemento);
                           
                           $id_endereco = $end->add_endereco_bd();

                           $banco = strtoupper($_POST['banco']);
                           $agencia = $_POST['agencia'];
                           $operacao = $_POST['operacao'];
                           $conta = $_POST['conta'];
                           $id_banco = Banco::add_banco($banco, $agencia, $operacao, $conta);

                           $nome = $_POST['nome'];
                           $cpf = $_POST['cpf'];
                           $rg = $_POST['rg'];
                           
                           $data_nasc = data_padrao_americano($_POST['data_nasc']);
                           
                           $telefone = $_POST['telefone'];
                           $email = $_POST['email'];
                           $senha = md5($_POST['senha']);
                           $id_empresa = $_POST['empresa'];
                           $id_empresa_filial = $_POST['empresa_filial'];
                           $id_turno = $_POST['turno'];
                           
                           $data_em_rg = data_padrao_americano($_POST['data_em_rg']);


                           $org_em_rg = strtoupper($_POST['org_em_rg']);
                           $num_tit_eleitor = $_POST['titu_eleitoral'];
                           $email_empresa_filial = $_POST['email_emp'];
                           
                           $data_adm = data_padrao_americano($_POST['data_admissao']);


                           $salario_base = moeda($_POST['sal_base']);
                           
                           $valor_custo = new Valor_custo();                                        
                           if(isset($_POST['valor_custo'])!= ""){
                                $id_tipo_custo = $_POST['tipo_custo'];
                                $valor = $_POST['valor_custo'];
                                $valor = moeda($valor);
                                $valor_custo->add_valor_custo($valor, $id_tipo_custo);
                                $id_valor_custo = $valor_custo->add_valor_custo_bd();
                           }
                           
                           
                           
                           $qtd_horas_sem = $_POST['qtd_horas_sem'];
                           $num_cart_trab = $_POST['num_cart_trab'];
                           $num_serie_cart_trab = $_POST['num_serie_cart_trab'] ;
                           $uf_cart_trab = $_POST['uf_cart_trab'];
                           $num_pis = $_POST['pis'];
                           $id_supervisor = $_POST['superv'];

                           $id_cbo = $_POST['cbo'];
                           $is_admin = (isset($_POST['is_admin']))?(($_POST['is_admin'])?1:0):0;
                           $data_ini = date("Y-m-d H:i:s");
                           $data_fim = "0000-00-00";
                           $estagiario = (isset($_POST['estagiario']))?1:0;

                           $func->add_func($id_banco, $cod_serie, $nome, $cpf, $cnh, $rg, $data_nasc, $telefone, $email, $senha, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $id_endereco, $data_em_rg, $org_em_rg, $num_tit_eleitor, $email_empresa_filial, $data_adm, $salario_base, $id_valor_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor, $data_ini, $data_fim, $estagiario);
                           // echo $func->printFunc();
                           if($func->add_func_bd()){
                               echo '<div class="msg">Funcionário cadastrado com sucesso!</div>';
                           }else{
                                echo '<div class="msg">Falha ao cadastrar funcionário!</div>';
                           }
                        }
                  }

                  if(isset($_POST['tipo']) && $_POST['tipo'] == 'editar'){
                    
                      if(validate()){
                        
                           $func = new Funcionario();
                           $endereco = new Endereco();
                           $valor_custo = new Valor_custo();
                           

                           $cod_serie = $_POST['codigo'];
                           $id = $_POST['id_func'];
                           $id_tabela = $_POST['id_tabela'];
                           $nome = $_POST['nome'];
                           $cpf = $_POST['cpf'];

                           $data_nasc = data_padrao_americano($_POST['data_nasc']);

                           $telefone = $_POST['telefone'];
                           $email = $_POST['email'];
                           if(isset($_POST['senha']) && $_POST['senha'] != '')
                                $senha = md5($_POST['senha']);
                           else
                                $senha ='';
                           $id_empresa = $_POST['empresa'];
                           $id_empresa_filial = $_POST['empresa_filial'];
                           $id_turno = $_POST['turno'];
                           $id_cbo = $_POST['cbo'];
                           $is_admin = (isset($_POST['is_admin']))?(($_POST['is_admin'])?1:0):0;

                           $rg = $_POST['rg'];
                           
                           $data_em_rg = data_padrao_americano($_POST['data_em_rg']);

                           $org_em_rg = strtoupper($_POST['org_em_rg']);
                           $num_tit_eleitor = $_POST['titu_eleitoral'];
                           $email_empresa = $_POST['email_emp'];
                           
                           $data_adm = data_padrao_americano($_POST['data_admissao']);
                           
                           $salario_base = moeda($_POST['sal_base']);  // retorna salario formatado
                           
                           $id_custo = $_POST['id_custo'];
                           $estagiario = ($_POST['estagiario'])?1:0;
                               
                           if(isset($_POST['valor_custo']) != ""){
                                $Ftemp = Funcionario::get_func_id($id);
                                $valorCustoTemp = Valor_custo::get_valor_custo_id($Ftemp->id_valor_custo);
                                
                                if(moeda(number_format($valorCustoTemp->valor, 2, ',' , '.')) != moeda($_POST['valor_custo'])){ // valor custo só é atualizado se o valor alterado for diferente do valor atual
                                    $id_tipo_custo = $_POST['tipo_custo'];
                                    $valor = $_POST['valor_custo'];
                                    $valor = moeda($valor);
                                    
                                    $id_custo = $valor_custo->atualiza_valor_custo($valor, $id_tipo_custo, $id_custo);
                                }else{
                                    $id_custo = $Ftemp->id_valor_custo;
                                }
                              
                           };
                           
                           $qtd_horas_sem = $_POST['qtd_horas_sem'];
                           $num_cart_trab = $_POST['num_cart_trab'];
                           $num_serie_cart_trab = $_POST['num_serie_cart_trab'] ;
                           $uf_cart_trab = $_POST['uf_cart_trab'];
                           $num_pis = $_POST['pis'];
                           $id_supervisor = $_POST['superv'];

                           //************** ATUALIZA ENDERECO ******************
                           $rua = $_POST['rua'];
                           $numero = $_POST['num'];
                           $id_cidade = $_POST['cidade'];
                           $bairro = $_POST['bairro'];
                           $cep = $_POST['cep'];
                           $complemento = $_POST['complemento'];

                           $existe_endereco = $endereco->verifica_endereco($_POST['id_endereco']);

                           if($existe_endereco){//Se já existe um endereço  cadastrado (ATUALIZA)
                                $endereco->atualiza_endereco($rua, $numero, $id_cidade, $_POST['id_endereco'], $bairro, $cep, $complemento );
                                $id_endereco = $_POST['id_endereco'];
                           }else{//Se NÃO existe um endereço  cadastrado (ADICIONA)
                                $endereco->add_endereco($rua, $numero, $id_cidade, $bairro, $cep, $complemento);
                                $id_endereco = $endereco->add_endereco_bd();
                           }
                           //************** FIM ATUALIZA ENDERECO ******************
                           
                           //************** ATUALIZA DADOS BANCáRIOS ******************
                           $id_banco = $_POST['id_banco'];
                           $banco = strtoupper($_POST['banco']);
                           $agencia = $_POST['agencia'];
                           $operacao = $_POST['operacao'];
                           $conta = $_POST['conta'];

                           if(Banco::verifica_banco($id_banco)){
                              Banco::atualiza_banco($id_banco, $banco, $agencia, $operacao, $conta);//atualizando banco
                              $id_dados_bancarios = $id_banco;
                              // echo 'Banco: '.$id_dados_bancarios.' atualizado com sucesso';
                           }else{
                              $id_dados_bancarios = Banco::add_banco($banco, $agencia, $operacao, $conta);//adicionando banco
                              // echo 'Banco: '.$id_dados_bancarios.' adicionado com sucesso';
                           }
                           
                           //************** FIM ATUALIZA DADOS BANCáRIOS ******************

                           if($func->atualiza_func($id, $id_dados_bancarios, $cod_serie, $id_tabela, $nome, $cpf, $data_nasc, $id_endereco, $telefone, $email, $senha, $id_empresa, $id_empresa_filial, $id_turno, $id_cbo, $is_admin, $rg, $data_em_rg, $org_em_rg, $num_tit_eleitor, $email_empresa, $data_adm, $salario_base, $id_custo, $qtd_horas_sem, $num_cart_trab, $num_serie_cart_trab, $uf_cart_trab, $num_pis, $id_supervisor, $estagiario)){
                              echo '<div class="msg">Funcionário atualizado com sucesso</div>';
                              echo '<script>alert("Funcionário atualizado com sucesso")</script>';
                              echo '<script>window.location.href=\'principal\'</script>';
                           }else{
                              echo '<div class="msg">Falha ao atualizar funcionário</div>';
                           }
                    }
                }


                ?>

             </div>
             <?php include_once("informacoes_func.php"); ?>
   
          <?php }?>
              
     
              
        <div hidden id="divcbo">
            <div class="formulario">
              
                <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">ADICIONAR CBO - CLASSIFICAÇÃO BRASILEIRA <BR> DE OCUPAÇÕES</span></div></div>
               <form method="POST" id="add_cbo" action="add_cbo.php" onsubmit="return validate(this)">
                  <table border="0" style="width:100%">
                      <input type="hidden" id="voltar" name="voltar" value="voltar"> 
                      <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                     <!-- <tr> <td><span>Descrição:</span></td> <td ><input type="text" id="desc" name="desc" style="width:100px;"></td><td><span style="font-size:12px; color:#555;">(Ex. de descrição: Das 8:00 às 12:00 e das 13:00 às 18:00)</span></td></tr> <!- nome -->
                     <tr> <td ><span>Codigo:</span></td> <td><input type="text" id="codigo" name="codigo"></td></tr> <!-- ini exp -->
                     <tr> <td ><span>Descrição:</span></td> <td><input type="text" id="descricao" name="descricao"></td></tr> <!-- ini exp -->
                     <tr><td colspan="2"><span>Selecione os exames necessários para essa função:</span></td></tr>
                     <tr>
                        <td colspan="2">
                           <!-- <select id="exames" name="exames[]" size="5" multiple style="width:270px"> -->
                              <?php
                                 $exame = new Exame();
                                 $exames = $exame->get_name_all_exames();
                                 $data = array();
                                 
                                 for ($i=0; $i < count($exames); $i++) { 
                                    $data[$i] = array("id"=>$exames[$i][0], "name"=>$exames[$i][1]);
                                 }

                                 $data_selected = array();  

                                 RendDoubleSelect::showDoubleDropDown($data, $data_selected, "id", "name", "", 
                                        "sel_exames1", "selecionados", "hd_exames", "130px", 
                                       "Exames", "Selecionados");
                               ?>
                           <!-- </select> -->
                        </td>
                     </tr>
                     <!-- <tr><td colspan="2"><span style="color:#898989">Segure Ctrl para múltiplas seleções</span></td></tr>   -->
                     <tr>
                        <td colspan="3" style="text-align:center">
                          <input class="button" type="submit" onclick="selectAll()" name="button" id="button" value="Cadastrar">                          
                        </td>
                     </tr>
                  </table>
               </form>
            


            </div>
                  </div>
              <div hidden id="divturno">
                  <div class="formulario">
                  <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">CADASTRO DE TURNO</span></div></div>
                  <div class="title">
                  <span style="font-size:14px; color:#555;"><br>Atenção: use o formato de 24 horas para o preenchimento de um novo turno, de 0 à 24 horas e de 0 aos 59 minutos</br></span>
               </div>
                 <form method="POST" class="ad_turno" id="ad_turno" name="ad_turno" action="add_turno.php" onsubmit="return validate(this)">
                <input type="hidden" id="voltar" name="voltar" value="voltar">     
                <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                  <table border="0">
                     <tr> <td ><span>Nome:</span></td> <td ><input style="width:100%" type="text" id="nome" name="nome" style="width:100px;" title="Digite um nome para esse turno"></td></tr> <!-- nome-->
                     <tr> <td ><span>Início expediente:</span></td> <td><input type="text" id="ini_exp_h" name="ini_exp_h"><span>h</span><input type="text" id="ini_exp_m" name="ini_exp_m"><span>m</span></td></tr> <!-- ini exp -->
                     <tr> <td ><span>Sem Almoço</span></td><td><input type="checkbox" name="sem_hor_almoco" id="sem_hor_almoco"></td></tr>
                     <tr id="almoco"> <td><span>Início almoço:</span></td> <td><input type="text" id="ini_alm_h" name="ini_alm_h"><span>h</span><input type="text" id="ini_alm_m" name="ini_alm_m"><span>m</span></td></tr> <!-- ini alm -->
                     <tr id="almoco2"> <td ><span>Fim almoço</span></td> <td><input type="text" id="fim_alm_h" name="fim_alm_h"><span>h</span><input type="text" id="fim_alm_m" name="fim_alm_m"><span>m</span></td></tr> <!-- fim alm -->
                     <tr> <td ><span>Fim expediente:</span></td> <td><input type="text" id="fim_exp_h" name="fim_exp_h"><span>h</span><input type="text" id="fim_exp_m" name="fim_exp_m"><span>m</span></td></tr> <!-- fim exp -->                     
                     <tr>
                        <td colspan="3" style="text-align:center">
                           <input class="button" type="submit" name="button" id="button" value="Cadastrar">                           
                        </td>
                     </tr>
                  </table>
               </form>
                  </div>
              </div>
  
          
</body>
</html>