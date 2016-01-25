
<?php
include("restrito.php");
include("../model/class_exame_bd.php");
include_once("../includes/functions.php");
?>
<html>

<?php Functions::getHead('Pesquisar Exames'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <title>Pesquisar Exames</title>
   <meta charset="UTF-8">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
</head> -->

<body>   
<?php include_once("../view/topo.php"); ?>


     <div class="formulario">
           <div class="title-box" style="float:left"><div style="float:left"><img src="../images/search-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Pesquisar Exames</span></div></div>                                                                
                 <form method="POST" class="pesquisa-campos" id="pesquisa-campos" name="pesquisa-campos" action="pesquisa_exames.php">
                    <table id="table-search">
                      <tr>
                         <td><span >Exame: </span></td>
                         <td><input type="text" id="name_search" name="name_search" placeholder="Pesquise em branco para todos os resultados"title="Digite o nome do exame"></td>
                         <td><input type="submit" value="Buscar" class="button"></td>
                      </tr>
                   </table>
                 </form>
          <?php
                if(isset($_POST['name_search'])){
                   $exame = new Exame();
                   $exames = $exame->get_exame_by_desc($_POST['name_search']);
                     echo '<table class="exibe-pesquisa">';
                     if(count($exames)>0)
                     foreach($exames as $key => $exame){
                        echo '<tr>
                                 <td><a href="pesquisa_exames.php?verificador=1&id='.$exames[$key][0].'">'.$exames[$key][1]." ".$exames[$key][2].'</a></td></tr>';
                     }
                     echo '</table>';
                }

                if(isset($_GET['verificador']) && $_GET['verificador'] == 1){
                  $exame = new Exame();
                  $exame = $exame->get_exame_id($_GET['id']);
                  echo $exame->printExames();

                }
             ?>
     </div>                         
                                
</body>
</html>