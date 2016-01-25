
<?php
include("restrito.php");
include("../model/class_patrimonio_bd.php");
include_once("../includes/functions.php");
?>
<html>

<?php Functions::getHead('Pesquisar Veiculos'); //busca <head></head> da pagina, $title é o titulo da pagina ?>

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
                         <td><input type="text" id="name_search" name="name_search" title="Digite qual patrimobio deseja procurar..."></td>
                         <td><input type="submit" value="Buscar" class="button"></td>
                      </tr>
                   </table>
                 </form>
          <?php
                if(isset($_POST['name_search']) && $_POST['name_search'] != ""){
                   $patrimonio = new Patrimonio();
                   $patrimonios = $patrimonio->get_all_patrimonio($_POST['name_search']);
                     echo '<table class="exibe-pesquisa">';
                     if(count($patrimonios)>0)
                     foreach($patrimonios as $key => $patrimonio){
                        echo '<tr>
                                 <td><a href="pesquisa_patrimonio.php?verificador=1&id='.$patrimonios[$key][0].'">'.$patrimonios[$key][0]." ".$patrimonios[$key][1]." ".$patrimonios[$key][2].'</a></td></tr>';
                     }
                     echo '</table>';
                }

                if(isset($_GET['verificador']) && $_GET['verificador'] == 1){
                  $patrimonio = new Patrimonio();
                  $patrimonio = $patrimonio->get_patrimonio_id($_GET['id']);
                  echo $patrimonio->printPatrimonio();

                }
             ?>
     </div>                         
                                
</body>
</html>