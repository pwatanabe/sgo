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
 include_once("../model/class_periodicidade_bd.php");
 include_once("../model/class_exame_bd.php");
 include_once("../includes/functions.php");

function validate(){
   if(!isset($_POST['descricao']) || $_POST['descricao'] == ""){
         return false;
   }
   if(!isset($_POST['periodo']) || $_POST['periodo'] == "no_sel"){
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

<?php Functions::getScriptExames(); ?>
<body>
     
    <div id="content">
            <?php include_once("../view/topo.php"); ?>
                       
            <div class="formulario">             
             <?php if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){ ?>
                    <?php 
                      $id = $_GET['id'];
                      $exame = new Exame();
                      $exame = $exame->get_exame_id($id);
                      $id = $exame->id;
                      $descricao = $exame->descricao;
                      $id_periodicidade = $exame->id_periodicidade;
                       ?>
                <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR EXAME</span></div></div>
                 <form method="POST" id="add_cbo" action="add_exames.php" onsubmit="return validate(this)">
                          <input type="hidden" id="tipo" name="tipo" value="editar">
                          <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                          <table border="0" style="width:100%">
                             <!-- <tr> <td><span>Descrição:</span></td> <td ><input type="text" id="desc" name="desc" style="width:100px;"></td><td><span style="font-size:12px; color:#555;">(Ex. de descrição: Das 8:00 às 12:00 e das 13:00 às 18:00)</span></td></tr> <!- nome -->
                             <!-- <tr> <td ><span>ID:</span></td> <td> <span> <?php echo $id ?> </span> </td></tr> <!- ini exp -->
                             <tr> <td ><span>Descrição:</span></td> <td><input type="text" id="descricao" name="descricao" value="<?php echo $descricao; ?>"></td></tr> <!-- ini exp -->
                             <tr>
                                <td><span>Periodicidade:</span></td>
                                <td>
                                   <select id="periodo" name="periodo">
                                        <option value="no_sel">Selecione a periodicidade</option>
                                        <?php
                                          $periodicidade = new Periodicidade();
                                          $periodos = $periodicidade->get_name_all_periodo();
                                          for ($i=0; $i < count($periodos); $i++) { 
                                            echo '<option value="'.$periodos[$i][0].'">'.$periodos[$i][1].'</option>';
                                          }
                                         ?>
                                  </select> <span> dias</span>
                                </td>
                                <?php echo "<script> carregaPeriodo('".$id_periodicidade."') </script>";  ?>
                             </tr>
                             <tr>
                                <td colspan="3" style="text-align:center">
                                    <input class="button" type="submit" name="button" id="button" value="Editar">
                                    <input class="button" name="button" type="button" onclick="window.location.href='add_exame.php'" id="button" value="Cancelar">
                                </td>
                              </tr>
                          </table>
                       </form>              
               <?php }else{ ?>                
               <form method="POST" class="ad_exame" id="ad_exame" name="ad_exame" action="add_exames.php" onsubmit="return validate(this)">
                <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">CADASTRO DE EXAME</span></div></div>
                <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                  <table border="0" style="width:100%">
                     <!-- <tr> <td><span>Descrição:</span></td> <td ><input type="text" id="desc" name="desc" style="width:100px;"></td><td><span style="font-size:12px; color:#555;">(Ex. de descrição: Das 8:00 às 12:00 e das 13:00 às 18:00)</span></td></tr> <!- nome -->
                     <tr> <td ><span>Descrição:</span></td> <td><input type="text" id="descricao" name="descricao"></td></tr> <!-- ini exp -->
                     <tr>
                        <td ><span>Periodicidade:</span></td>
                        <?php 
                            $periodo = new Periodicidade();
                            $periodos = $periodo->get_name_all_periodo();
                         ?>
                        <td>
                           <select name="periodo" id="periodo">
                              <option value="no_sel">Selecione a periodicidade</option>
                              <?php
                                 for($aux=0; $aux < count($periodos); $aux++) {
                                       echo '<option value="'.$periodos[$aux][0].'">'.$periodos[$aux][1]. ' Dias</option>';
                                 } 
                              ?>
                           </select>
                        </td>
                     </tr>
                     
                     <tr>
                        <td colspan="3" style="text-align:center">
                           <input class="button" type="submit" name="button" id="button" value="Cadastrar">
                           <input class="button" name="button" type="button" onclick="window.location.href='principal.php'" id="button" value="Cancelar">
                         </td>
                      </tr>
                  </table>
               </form>              
               <?php }?>               
               <?php 
                if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar"){
                  if(validate()){
                     $exame = new Exame();
                     $exame->add_exame($_POST['descricao'], $_POST['periodo'], $id = $_SESSION['id_empresa']);

                     // echo $exame->printExames();
                     if($exame->add_exame_bd()){
                        echo '<div class="msg">Cadastrado com sucesso!</div>';
                     }else{
                        echo '<div class="msg">Erro ao cadastrar!</div>';
                     }

                  }
                }else{
                  if(isset($_POST['tipo']) && $_POST['tipo'] == "editar"){                    
                          if(isset($_POST['id'])){

                            if(validate()){

                              $exame = new Exame();
                              if($exame->atualiza_exame($_POST['descricao'], $_POST['periodo'], $_POST['id'] ) ){
                                 echo '<div class="msg">Atualizado com sucesso!</div>';
                                 echo '<script>alert("Exame atualizado com sucesso")</script>';
                              }else{
                                 echo '<div class="msg">Falha na atualização!</div>';
                              }
                              
                            }
                          }                         
                  }
                }
                 ?> 
            </div>
             <?php include("informacoes_exames.php") ?>               
   </div>

</body>
</html>




