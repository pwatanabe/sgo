
<?php
include("restrito.php");

include_once("../model/class_funcionario_bd.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");
include_once("../model/class_filial_bd.php");
include_once("../model/class_cbo_bd.php");
include_once("../model/class_cidade_bd.php");
include_once("../model/class_estado_bd.php");
include_once("../model/class_endereco_bd.php");
include_once("../model/class_exame_bd.php");
include_once("../model/class_cboXexames.php");
include_once("../model/class_rend_double_select.php");
include_once("../includes/functions.php");

function validate(){
   if(!isset($_POST['codigo']) || $_POST['codigo'] == ""){
         return false;
   }
   if(!isset($_POST['descricao']) || $_POST['descricao'] == ""){
         return false;
   }
   return true;
}

?>
<html>


<?php Functions::getHead('Adicionar'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <title>Adicionar</title>
   <meta charset="UTF-8">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
   
</head> -->
<?php  Functions::getScriptCBO(); //carrega funções javascript da pagina ?>
<body>
   
   <?php include_once("../view/topo.php"); ?>
    
                   
            <div class="formulario">
                <?php if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){ ?>  
                   <?php 
                        $id = $_GET['id'];
                        $cbo = new Cbo();
                        $cbo = $cbo->get_cbo_by_id($id);
                        $codigo = $cbo->codigo;
                        $descricao = $cbo->descricao;
                        
                      ?>

               <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR CBO</span></div></div>
                  <form method="POST" id="add_cbo" action="add_cbo.php" onsubmit="return validate(this)">
                        <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                         <input type="hidden" id="tipo" name="tipo" value="editar">
                        <table border="0" style="width:100%">
                           <!-- <tr> <td><span>Descrição:</span></td> <td ><input type="text" id="desc" name="desc" style="width:100px;"></td><td><span style="font-size:12px; color:#555;">(Ex. de descrição: Das 8:00 às 12:00 e das 13:00 às 18:00)</span></td></tr> <!- nome -->
                           <tr> <td ><span>Codigo:</span></td> <td><input type="text" id="codigo" name="codigo" value="<?php echo $codigo; ?>"></td></tr> <!-- ini exp -->
                           <tr> <td ><span>Descrição:</span></td> <td><input type="text" id="descricao" name="descricao" value="<?php echo $descricao; ?>"></td></tr> <!-- ini exp -->
                           <tr><td colspan="2"><span>Selecione os exames necessários para essa função:</span></td></tr>
                           <tr>
                              <td colspan="2">
                                 <!-- <select id="exames" name="exames[]" size="5" multiple style="width:270px"> -->
                                    <?php
                                       $exame = new Exame();
                                       $exames = $exame->get_name_all_exames();
                                       
                                       for ($i=0; $i < count($exames); $i++) { 
                                          $data[$i] = array("id"=>$exames[$i][0], "name"=>$exames[$i][1]);
                                       }
                                       $exames_cbo = $cbo->get_exames_cbo($cbo->id);
                                       $data_selected = array();
                                       for ($i=0; $i < count($exames_cbo); $i++) { 
                                          $data_selected[$i] = array("id"=>$exames_cbo[$i][0], "name"=>$exames_cbo[$i][1]);
                                       }
                                       $aux=0;
                                       $aux_temp=0;
                                       $temp = array();
                                       for($i=0; $i < count($exames); $i++){
                                         
                                          for($y=0; $y < count($data_selected); $y++){
                                            
                                            if($exames[$i][0] == $data_selected[$y]["id"]){
                                              
                                              $aux++;
                                            }
                                          }
                                          if($aux == 0){
                                            
                                            $temp[$aux_temp]["id"] = $exames[$i][0];
                                            $temp[$aux_temp]["name"] = $exames[$i][1];
                                            $aux_temp++;
                                          }
                                          $aux=0;
                                          
                                       }
                                       $data = $temp;
                                       RendDoubleSelect::showDoubleDropDown($data, $data_selected, "id", "name", "", 
                                              "sel_exames1", "selecionados", "hd_exames", "130px", 
                                             "Exames", "Selecionados");
                                     ?>
                                 <!-- </select> -->
                              </td>
                           </tr>

                           <tr>
                              <td colspan="3" style="text-align:center">
                                <input type="submit" onclick="selectAll()" name="button" class="button" id="button" value="Editar">
                                <input class="button" name="button" onclick="window.location.href='add_cbo.php'" id="button" value="Cancelar">
                              </td>
                            </tr>
                        </table>
                     </form>
                  <?php }else{ ?>
                <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">ADICIONAR CBO - CLASSIFICAÇÃO BRASILEIRA <BR> DE OCUPAÇÕES</span></div></div>
               <form method="POST" id="add_cbo" action="add_cbo.php" onsubmit="return validate(this)">
                  <table border="0" style="width:100%">
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
                          <input class="button" name="button" onclick="window.location.href='principal.php'" id="button" value="Cancelar">
                        </td>
                     </tr>
                  </table>
               </form>
               <?php }?> 

                 <?php 
              if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar"){
                  
                 if(validate()){
                     
                     $cboXexames = new CboXexames();
                     $cbo = new Cbo();
                     $cbo->add_cbo($_POST['codigo'], $_POST['descricao'],$id = $_SESSION['id_empresa']);
                     $id_cbo = $cbo->add_cbo_bd();// id do registro cadastrado
                      if(isset($_POST['voltar'])){
                                echo '<script>window.history.back()</script>'; 
                             }
                     $id_exames = isset($_POST['selecionados']) ? $_POST['selecionados'] : null;

                     if ($cboXexames->add_cbo_x_exames($id_exames, $id_cbo)){
                        echo '<div class="msg">Atualizado com sucesso!</div>';
                     }
                  }
                }else{
                   if(isset($_POST['tipo']) && $_POST['tipo'] == "editar"){
                          if(isset($_POST['id'])){
                            if(validate()){
                              $cbo = new Cbo();
                              $cbo_x_exames = new CboXexames();
                              $array_id_exames =  array();
                              if($cbo->atualiza_cbo($_POST['id'], $_POST['codigo'], $_POST['descricao'])){
                                 if(isset($_POST['selecionados']))
                                    $array_id_exames = $_POST['selecionados'];

                                 if($cbo_x_exames->atualiza_cbo_x_exames($_POST['id'], $array_id_exames)){
                                    echo '<div class="msg">Atualizado com sucesso!</div>';
                                    echo '<script>alert("CBO atualizado com sucesso")</script>';
                                 }
                              }else{
                                 echo '<div class="msg">Falha na atualização!</div>';
                              }
                              
                            }
                          }                       
                     }
                     }                
                  ?>
            </div>
         
            <?php include ("informacoes_cbo.php") ?>
   
</body>
</html>