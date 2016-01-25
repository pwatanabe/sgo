
<?php
include("restrito.php");
include("../model/class_patrimonio_bd.php");
include_once("../includes/functions.php");
?>
<html>


<?php Functions::getHead('Pesquisar Patrimonio'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <title>Pesquisar Patrimonio</title>
   <meta charset="UTF-8">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
</head> -->

<body>   
<?php include_once("../view/topo.php"); ?>


     <div class="formulario">
           <div class="title-box" style="float:left"><div style="float:left"><img src="../images/search-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Pesquisar Patrimonio</span></div></div>                                                                
                 <form method="POST" class="pesquisa-campos" id="pesquisa-campos" name="pesquisa-campos" action="pesquisa_patrimonio.php">
                    <table id="table-search">
                      <tr>
                         <td><span >Patrimonio: </span></td>
                         <td><input type="text" id="name_search" name="name_search" title="Digite qual patrimobio deseja procurar..." placeholder="Deixe em branco para pesquisar todos"></td>
                         <td><input type="submit" value="Buscar" class="button"></td>
                      </tr>
                   </table>
                 </form>
          <?php
                if(isset($_POST['name_search'])){
                       $patrimonio = new Patrimonio();
                       $patrimonios = $patrimonio->get_all_patrimonio($_POST['name_search'], $_SESSION['id_empresa']);
                       if($_POST['name_search']==""){
                           $patrimonios = $patrimonio->get_all();
                       }
                                 
                      
                               
                       $patrimonios_geral = new Patrimonio_geral();
                       $geral = $patrimonios_geral->get_patrimonio_geral_nome($_POST['name_search']);
                       $aux = 0;
                      
                 
                         echo '<table class="exibe-pesquisa">';
                         
                          if(count($geral) > 0) {
                              foreach ($geral as $key => $patrimonio_geral){
                                  echo '<tr> 
                                           <td><a href="pesquisa_patrimonio.php?verificador=1&id=' . $geral[$key][0] . '&controle=' . $geral[$key][3] . '">' . $geral[$key][4] . " " . $geral[$key][1] . " " . $geral[$key][2] . '</a></td></tr>';
                               }
                               $aux = $aux + 1;
                          }         
                        
                         if(count($patrimonios) > 0) {
                            foreach($patrimonios as $key => $patrimonio){
                                     echo '<tr>                                
                                     <td><a href="pesquisa_patrimonio.php?verificador=1&id='.$patrimonios[$key][0].'&controle='.$patrimonios[$key][3].'">'.$patrimonios[$key][0]." ".$patrimonios[$key][1]." ".$patrimonios[$key][4].'</a></td></tr>';
                            }
                             echo '</table>';
                             $aux++;
                         }
                         if($aux == 0){
                                     echo '<div class="msg">Nenhum patrimonio encontrado!</div>';    
                         }
                }
              
                
                if(isset($_GET['verificador']) && $_GET['verificador'] == 1){
                      $patrimonio = new Patrimonio();
                      $id = $_GET['id'];
                      $controle = $_GET['controle'];
                      $patrimonio->printPatrimonio($id,$controle);




                }
             ?>
     </div>                         
                                
</body>
</html>