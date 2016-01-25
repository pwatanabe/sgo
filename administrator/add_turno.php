
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
 include_once("../includes/functions.php");

function validate(){
   if(!isset($_POST['ini_exp_h']) || $_POST['ini_exp_m'] == ""){
         return false;
   }
   if(!isset($_POST['ini_alm_h']) || $_POST['ini_alm_m'] == ""){
         return false;
   }
   if(!isset($_POST['fim_alm_h']) || $_POST['fim_alm_m'] == ""){
         return false;
   }
   if(!isset($_POST['fim_exp_h']) || $_POST['fim_exp_m'] == ""){
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
   <link rel="stylesheet" type="text/css" href="styles/style.css">   
</head> -->

<?php Functions::getScriptTurno(); ?>

<body>
   
 <?php include_once("../view/topo.php"); ?> 

   <div id="content"> 
            <div class="formulario">  
                    <?php
                 
                 if(isset($_GET['tipo']) && $_GET['tipo'] == "editar"){ //ini if 1 
                  
                    $turno = new Turno();
                    // $turnos = $turno->get_func_by_name($_POST['name_search']);
                    $turno = $turno->getTurnoById($_GET['id']);
                    $nome = $turno->nome;
                                                                        //01234567
                    $ini_exp_h = $turno->ini_exp[0].$turno->ini_exp[1]; //08:00:00
                    $ini_exp_m = $turno->ini_exp[3].$turno->ini_exp[4];
                    $ini_alm_h = $turno->ini_alm[0].$turno->ini_alm[1];
                    $ini_alm_m = $turno->ini_alm[3].$turno->ini_alm[4];
                    $fim_alm_h = $turno->fim_alm[0].$turno->fim_alm[1];
                    $fim_alm_m = $turno->fim_alm[3].$turno->fim_alm[4];
                    $fim_exp_h = $turno->fim_exp[0].$turno->fim_exp[1];
                    $fim_exp_m = $turno->fim_exp[3].$turno->fim_exp[4];

                ?>
                  <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR TURNO</span></div></div>
                  <div class="title">
                  <span style="font-size:14px; color:#555;"><br>Atenção: use o formato de 24 horas para o preenchimento de um novo turno, de 0 à 24 horas e de 0 aos 59 minutos</br></span>
               </div>
                  <form method="POST" class="ad_turno" id="ad_turno" name="ad_turno" action="add_turno.php" onsubmit="return validate(this)">
                  <input type="hidden" id="tipo" name="tipo" value="editar">
                  <input type="hidden" name="confirm_ed" id="confirm_ed" value="1">
                  <input type="hidden" name="id_turno" id="id_turno" value="<?php echo $_GET['id']; ?>">
                  <table border="0">
                     <tr> <td><span>Nome:</span></td> <td ><input style="width:100%" type="text" id="nome" name="nome" style="width:100px;" title="Digite um nome para esse turno" value="<?php echo $nome; ?>"></td></tr> <!-- nome-->
                     <tr> <td ><span>Início expediente:</span></td> <td><input type="text" id="ini_exp_h" name="ini_exp_h" value="<?php echo $ini_exp_h; ?>"><span>h</span><input type="text" id="ini_exp_m" name="ini_exp_m" value="<?php echo $ini_exp_m; ?>"><span>m</span></td></tr> <!-- ini exp -->
                     <tr> <td ><span>Início almoço:</span></td> <td><input type="text" id="ini_alm_h" name="ini_alm_h" value="<?php echo $ini_alm_h; ?>"><span>h</span><input type="text" id="ini_alm_m" name="ini_alm_m" value="<?php echo $ini_alm_m; ?>"><span>m</span></td></tr> <!-- ini alm -->
                     <tr> <td ><span>Fim almoço</span></td> <td><input type="text" id="fim_alm_h" name="fim_alm_h" value="<?php echo $fim_alm_h; ?>"><span>h</span><input type="text" id="fim_alm_m" name="fim_alm_m" value="<?php echo $fim_alm_m; ?>"><span>m</span></td></tr> <!-- fim alm -->
                     <tr> <td ><span>Fim expediente:</span></td> <td><input type="text" id="fim_exp_h" name="fim_exp_h" value="<?php echo $fim_exp_h; ?>"><span>h</span><input type="text" id="fim_exp_m" name="fim_exp_m" value="<?php echo $fim_exp_m; ?>"><span>m</span></td></tr> <!-- fim exp -->
                     
                     <tr>
                        <td colspan="3" style="text-align:center">
                            <input class="button" type="submit" name="button" id="button" value="Editar">
                            <input class="button" name="button" onclick="window.location.href='add_turno.php'" id="button" value="Cancelar">
                        </td>

                     </tr>
                  </table>

               </form>    
                <?php }else{ ?> 
                  <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">CADASTRO DE TURNO</span></div></div>
                  <div class="title">
                  <span style="font-size:14px; color:#555;"><br>Atenção: use o formato de 24 horas para o preenchimento de um novo turno, de 0 à 24 horas e de 0 aos 59 minutos</br></span>
               </div>
                 <form method="POST" class="ad_turno" id="ad_turno" name="ad_turno" action="add_turno.php" onsubmit="return validate(this)">
                <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                  <table border="0">
                     <tr> <td><span>Nome:</span></td> <td ><input style="width:100%" type="text" id="nome" name="nome" style="width:100px;" title="Digite um nome para esse turno"></td></tr> <!-- nome-->
                     <tr> <td ><span>Início expediente:</span></td> <td><input type="text" id="ini_exp_h" name="ini_exp_h"><span>h</span><input type="text" id="ini_exp_m" name="ini_exp_m"><span>m</span></td></tr> <!-- ini exp -->
                     <tr> <td ><span>Sem Almoço</span></td><td><input type="checkbox" name="sem_hor_almoco" id="sem_hor_almoco"></td></tr>
                     <tr id="almoco"> <td><span>Início almoço:</span></td> <td><input type="text" id="ini_alm_h" name="ini_alm_h"><span>h</span><input type="text" id="ini_alm_m" name="ini_alm_m"><span>m</span></td></tr> <!-- ini alm -->
                     <tr id="almoco2"> <td ><span>Fim almoço</span></td> <td><input type="text" id="fim_alm_h" name="fim_alm_h"><span>h</span><input type="text" id="fim_alm_m" name="fim_alm_m"><span>m</span></td></tr> <!-- fim alm -->
                     <tr> <td ><span>Fim expediente:</span></td> <td><input type="text" id="fim_exp_h" name="fim_exp_h"><span>h</span><input type="text" id="fim_exp_m" name="fim_exp_m"><span>m</span></td></tr> <!-- fim exp -->
                     
                     <tr>
                        <td colspan="3" style="text-align:center">
                           <input class="button" type="submit" name="button" id="button" value="Cadastrar">
                           <input class="button" name="button" onclick="window.location.href='principal.php'" id="button" value="Cancelar">
                        </td>
                     </tr>
                  </table>
               </form>

                <?php }?> 

                <?php 
                if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar"){
                      if(validate() || isset($_POST['sem_hor_almoco'])){
                         $turno = new Turno();
                         $nome = $_POST['nome'];
                         $ini_exp = $_POST['ini_exp_h'].":".$_POST['ini_exp_m'].":00";
                         $ini_alm = $_POST['ini_alm_h'].":".$_POST['ini_alm_m'].":00";
                         $fim_alm = $_POST['fim_alm_h'].":".$_POST['fim_alm_m'].":00";
                         $fim_exp = $_POST['fim_exp_h'].":".$_POST['fim_exp_m'].":00";
                         
                         $desc = "Das ".$_POST['ini_exp_h'].":".$_POST['ini_exp_m']." às "
                                 .$_POST['ini_alm_h'].":".$_POST['ini_alm_m']." e das "
                                 .$_POST['fim_alm_h'].":".$_POST['fim_alm_m']." às "
                                 .$_POST['fim_exp_h'].":".$_POST['fim_exp_m'];
                         
                        
                        if(isset($_POST['sem_hor_almoco']) && $_POST['sem_hor_almoco'] == "on"){                             
                             
                             $sem_hor_almoco = 1;
                             $ini_alm = '00:00:00';
                             $fim_alm = '00:00:00';
                             
                             $desc = "Das ".$_POST['ini_exp_h'].":".$_POST['ini_exp_m']." às "                            
                                 .$_POST['fim_exp_h'].":".$_POST['fim_exp_m'];
                        }
                        else{
                           $sem_hor_almoco  = 0;
                        }
                         
                         $turno->cadTurno($nome, $desc, $ini_exp, $ini_alm, $fim_alm, $fim_exp, $sem_hor_almoco);
                         if($turno->add_turno_bd() == true){
                             if(isset($_POST['voltar'])){
                                echo '<script>window.history.back()</script>'; 
                             }
                          echo '<div class="msg">Turno editado com sucesso!</div>';
                        }else{
                           echo '<div class="msg">Adicionado com Sucesso!</div>';
                        }
                      }                 
                    }
                  if(isset($_POST['tipo']) && $_POST['tipo'] == "editar"){                    
                         if(validate()){
                         $turno = new Turno();
                         $id = $_POST['id_turno'];
                         $nome = $_POST['nome'];
                         $ini_exp = $_POST['ini_exp_h'].":".$_POST['ini_exp_m'].":00";
                         $ini_alm = $_POST['ini_alm_h'].":".$_POST['ini_alm_m'].":00";
                         $fim_alm = $_POST['fim_alm_h'].":".$_POST['fim_alm_m'].":00";
                         $fim_exp = $_POST['fim_exp_h'].":".$_POST['fim_exp_m'].":00";
                         $desc = "Das ".$_POST['ini_exp_h'].":".$_POST['ini_exp_m']." às "
                                 .$_POST['ini_alm_h'].":".$_POST['ini_alm_m']." e das "
                                 .$_POST['fim_alm_h'].":".$_POST['fim_alm_m']." às "
                                 .$_POST['fim_exp_h'].":".$_POST['fim_exp_m'];
                         
                        if($turno->atualiza_turno($nome, $id, $desc, $ini_exp, $ini_alm, $fim_alm, $fim_exp)){
                            echo '<div class="msg">Turno atualizado com sucesso!</div>';
                            echo '<script>alert("Turno atualizado com sucesso")</script>';
                        }else{
                            echo '<div class="msg">Falha ao editar turno!</div>';
                        }
                      }                  
                    }
                 ?> 


            </div>         
      <?php include("informacoes_turno.php") ?>
   </div>
</body>
</html>