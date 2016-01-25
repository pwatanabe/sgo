
<?php
include("restrito.php");
include("../model/class_cliente.php");
include_once("../includes/functions.php");
?>
<html>

<?php Functions::getHead('Pesquisar Cliente'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <title>Pesquisar Cliente</title>
   <meta charset="UTF-8">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
</head> -->

<body>   
<?php include_once("../view/topo.php"); ?>


           <div class="formulario">
                     <div class="title-box" style="float:left"><div style="float:left"><img src="../images/search-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Pesquisar Cliente</span></div></div>                                                                
                           <form method="POST" class="pesquisa-campos" id="pesquisa-campos" name="pesquisa-campos" action="pesquisa_cli.php">
                                <table id="table-search">
                                  <tr>
                                    <td colspan="3">
                                             <select name="tipo" class="select">
                                                 <option   value="2">Selecione o tipo de Cliente</option>
                                                 <option   value="0">Cliente Pessoa Fisica</option>
                                                 <option   value="1">Cliente Pessoa Juridica</option>
                                             </select>
                                         </td>
                                  </tr>
                                  <tr>
                                      <td><span><b>Cliente:</b> </span></td>
                                     <td><input type="text" id="name_search" name="name_search" placeholder="Escolha um tipo e digite o nome, ou pesquise todos em branco."></td>
                                     <td><input type="submit" value="Buscar" class="button"></td>
                                  </tr>
                                 </table>
                           </form>
                    <?php
                    
                        
                     if(isset($_POST['name_search'])){
                            
                           if($_POST['tipo']==0){
                               $cli = new Cliente();
                               $tipo = $_POST['tipo'];

                               $clis = $cli->pesquisa_cli_by_name($_POST['name_search'], $tipo, $_SESSION['id_empresa']);
                                       echo '<table class="exibe-pesquisa">';
                                       $aux = 0;
                              if(count($clis)>0)
                               foreach($clis as $key => $cli){
                                  if($aux%2 == 0)
                                       echo '<tr style="background-color:#bbb">';
                                  else
                                      echo '<tr style="background-color:#cbcbcb">';
                                  echo '<td><a href="pesquisa_cli.php?verificador=1&id='.$clis[$key][0].'">'.$clis[$key][0]." ".$clis[$key][1].'</a></td></tr>';
                                  $aux++;
                               }
                               echo '</table>';
                          }                         
                          if($_POST['tipo']==1){
                             $cli = new Cliente();
                                 $tipo = $_POST['tipo'];
                                 $clis = $cli->pesquisa_cli_by_name($_POST['name_search'], $tipo, $_SESSION['id_empresa']);
                                 if($clis != ""){
                                   echo '<table class="exibe-pesquisa">';
                                   $aux = 0;
                                   if(count($clis)>0)
                                       foreach($clis as $key => $cli){
                                          if($aux%2 == 0)
                                             echo '<tr style="background-color:#bbb">';
                                          else
                                              echo '<tr style="background-color:#cbcbcb">';

                                          echo '<td><a href="pesquisa_cli.php?verificador=2&id='.$clis[$key][0].'">'.$clis[$key][0]." ".$clis[$key][1].'</a></td></tr>';
                                    $aux++;
                                   }
                                 }
                                 echo '</table>';
                          }
                          if($_POST['tipo']==2){
                                    if(isset($_POST['name_serach'])== ""){
                                    $cli = new Cliente();
                                    $clis = $cli->get_all_cli($_SESSION['id_empresa']);
                               
                                    echo '<table class="exibe-pesquisa">';
                                    $aux = 0;
                                    if(count($clis)>0)
                                    foreach($clis as $key => $cli){
                                    if($clis[$key][2] ==0){
                                       $verificador = 1;
                                       }
                                       if($clis[$key][2] ==1){
                                       $verificador = 2;    
                                       } 
                                  if($aux%2 == 0)
                                       echo '<tr style="background-color:#bbb">';
                                  else
                                      echo '<tr style="background-color:#cbcbcb">';
                                  echo '<td><a href="pesquisa_cli.php?verificador='.$verificador.'&id='.$clis[$key][0].'">'.$clis[$key][0]." ".$clis[$key][1].'</a></td></tr>';
                                  $aux++;
                               }
                               echo '</table>';
                               echo '<div class="msg"> Você pode selecionario um tipo de Cliente</div>';
                             }
                          }
                   }
                   $cli = new Cliente();
                   if(isset($_GET['verificador']) && $_GET['verificador'] == 1){
                        
                         
                         $cli = $cli->get_cli_id($_GET['id']);
                         echo $cli->printCli();
                      }elseif(isset($_GET['verificador']) && $_GET['verificador'] == 2){
                        
                         // $cli = new Cliente();
                         $cli = $cli->get_cli_jur_id($_GET['id']);
                         
                         echo $cli->printCli_Jur();
                      }

                     ?>                          
           </div>
                         
                                
</body>
</html>