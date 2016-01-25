<?php
include("restrito.php");

include_once("../model/class_sql.php");
include_once("../model/class_epi_bd.php");
include_once("../model/class_empresa_bd.php");
include_once("../includes/functions.php");

function validade(){
  
   if(!isset($_POST['codigo']) || $_POST['codigo'] == ""){
         return false;
   }
   if(!isset($_POST['nome']) || $_POST['nome'] == ""){
         return false;
   }
   if(!isset($_POST['empresa']) || $_POST['empresa'] == ""){
         return false;
   }
   return true;
}

?>
<html>
<script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>



<?php Functions::getHead('Adicionar'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <title>Adicionar</title>
   <meta charset="UTF-8">
   <link rel="stylesheet" type="text/css" href="../administrator/styles/style.css">   
</head> -->

<?php  Functions::getScriptEPI(); ?>
<body>
     
    <div id="content">
            <?php include_once("../view/topo.php"); ?>                                   
            <div class="formulario">             
             <?php if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){ // Edita EPI?>
                    <?php 
                        $id = $_GET['id'];
                        $Epi = new Epi();
                        $Epi = $Epi->get_epi_by_id($id);
                        $codigo = $Epi->codigo;
                        $nome_epi = $Epi->nome_epi;
                        $descricao = $Epi->descricao;
                        $is_epi = $Epi->is_epi;
                        $id_empresa = $Epi->id_empresa;
                        $quantidade = $Epi->quantidade;
                      ?>
                <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR EQUIPAMENTOS</span></div></div>
                       <form method="POST" id="add_epi" action="add_epi.php" onsubmit="return validate(this)">
                            <input type="hidden" id="tipo" name="tipo" value="editar">
                            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">
                            <table border="0" style="width:100%">
                                 <tr>
                                      <td>
                                            <span>EPI:</span>
                                      </td>
                                      <td>
                                            <input style="height:12px;" type="checkbox" title="É um equipamento de proteção individual?" <?php $is_epi?print 'checked':''; ?> name="is_epi" id="is_epi">
                                            <span style="font-size:12px;color:#999;">(Equipamento de proteção individual)</span>
                                      </td>
                                 </tr>
                                 <tr><td><span>Codigo:</span></td><td><input type="text" name="codigo" id="codigo" value="<?php echo $codigo ?>" style="width:100%"> </td></tr>
                                 <tr><td><span>Nome:</span></td><td><input type="text" name="nome" id="nome" value="<?php echo $nome_epi ?>" style="width:100%"> </td></tr>
                                 <tr><td><span>Descricão:</span></td><td><input type="text" name="desc" id="desc" value="<?php echo $descricao ?>" style="width:100%"></td></tr>
                                 <tr><td><span>Quantidade:</span></td><td><input type="number" name="quantidade" id="quantidade" style="width:20%" value="<?php echo $quantidade; ?>"></td></tr>
                                 <tr>
                                      <td><span>Empresa:</span></td>
                                      <!-- <td>
                                          <input type="numeric" name="empresa" id="empresa" value="<?php //echo $id_empresa ?>" style="width:100%">
                                      </td> -->
                                      <td>
                                         <?php //buscar array de Epi
                                            $empresa = new Empresa();
                                            $empresas = $empresa->get_all_empresa();
                                         ?>
                                         <select name="empresa" id="empresa">
                                            <option value="no_sel">Selecione</option>
                                            <?php 
                                               foreach($empresas as $key => $empresa){
                                                  echo '<option value="'.$empresas[$key][0].'">'.$empresas[$key][2].'</option>';
                                               } 
                                            ?>
                                         </select>
                                         <!-- <a href="">Pesquisar</a> -->
                                      </td>
                                      <?php echo '<script>carregaEmpresa("'.$id_empresa.'")</script>'; ?>
                                  </tr>
                                 <tr>
                                    <td colspan="3" style="text-align:center">
                                       <input type="submit" class="button" name="button" id="button" value="Editar">
                                       <input  class="button" name="button" type="button" onclick="window.location.href='add_epi.php'" id="button" value="Cancelar">
                                     </td>
                                  </tr>
                             </table> 
                       </form>              
               <?php }else{ ?>                
                       <form method="POST" class="ad_epi" id="ad_epi" name="ad_epi" action="add_epi.php" onsubmit="return validate(this)">
                        <div class="title-box" style="float:left"><div style="float:left"><img src="../images/icon-add-epi.png" width="60px" style="margin-left:-20px; margin-top:-20px;"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">CADASTRO DE EQUIPAMENTOS</span></div></div>
                        <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                          <table border="0" style="width:100%">
                              <tr><td><span>EPI:</span></td><td><input style="height:12px;" type="checkbox" title="É um equipamento de proteção individual?" name="is_epi" id="is_epi"><span style="font-size:12px;color:#999;">(Equipamento de proteção individual)</span></td></tr>
                              <tr><td><span>Código:</span></td> <td><input type="text" name="codigo" id="epi" style="width:100%"></td></tr>
                              <tr><td><span>Nome:</span></td> <td><input type="text" name="nome" id="epi" style="width:100%"></td></tr>
                              <tr><td><span>Descricão:</span></td><td><input type="text" name="desc" id="desc" style="width:100%"></td></tr>
                              <tr><td><span>Quantidade:</span></td><td><input type="number" name="quantidade" id="quantidade" style="width:20%"></td></tr>
                              <tr>
                                <td><span>Empresa:</span></td></td>
                                <td>
                                   <?php //buscar array de Epi
                                      $empresa = new Empresa();
                                      $empresas = $empresa->get_all_empresa();
                                   ?>
                                   <select name="empresa" id="empresa">
                                      <option value="no_sel">Selecione</option>
                                      <?php 
                                         foreach($empresas as $key => $empresa){
                                            echo '<option value="'.$empresas[$key][0].'">'.$empresas[$key][2].'</option>';
                                         } 
                                      ?>
                                   </select>
                                   <!-- <a href="">Pesquisar</a> -->
                                </td>
                                </tr>                 
                           <tr>
                              <td colspan="3" style="text-align:center">
                                <input type="submit" name="button" class="button" id="button" value="cadastrar">
                                <input type="button" name="button" class="button" onclick="window.location.href='principal.php'" id="button" value="Cancelar">
                              </td>
                           </tr>
                          </table>
                       </form>              
               <?php }?>               
               <?php 
                if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar"){
                  if(validade()){
                     $epi = new Epi();
                     $is_epi = (isset($_POST['is_epi']))?(($_POST['is_epi'])?1:0):0;//Ternário do if(isset($_POST['is_epi'])){if($_POST['is_epi']){$is_epi = 1;}else{$is_epi = 0;}}else{$is_epi = 0;}

                     $epi->add_epi($is_epi, $_POST['codigo'], $_POST['nome'], $_POST['desc'],  $_POST['empresa'], $_POST['quantidade']);
                     // echo $exame->printExames();
                     if($epi->add_epi_bd()){
                        echo '<div class="msg">Cadastrado com sucesso!</div>';
                     }else{
                        echo '<div class="msg">Erro ao cadastrar!</div>';
                     }
                  }
                }else{

                  if(isset($_POST['tipo']) && $_POST['tipo'] == "editar"){                    
                          if(isset($_POST['id'])){

                            if(validade()){
                              $epi = new Epi();
                              $is_epi = (isset($_POST['is_epi']))?(($_POST['is_epi'])?1:0):0;//Ternário do if(isset($_POST['is_epi'])){if($_POST['is_epi']){$is_epi = 1;}else{$is_epi = 0;}}else{$is_epi = 0;}

                              if($epi->atualiza_epi($is_epi, $_POST['codigo'], $_POST['nome'], $_POST['desc'],  $_POST['empresa'], $_POST['quantidade'], $_POST['id'] ) ){
                                 echo '<div class="msg">Atualizado com sucesso!</div>';
                                 echo '<script>alert("EPI atualizado com sucesso")</script>';
                              }else{
                                 echo '<div class="msg">Falha na atualização!</div>';
                              }
                              
                            }//fim validade
                          }//fim ifisset                         
                         }//fim if
                       }//fimelse
                 ?>
            </div>
            <?php include_once("informacoes_epi.php"); ?>       
   </div>

</body>
</html>




