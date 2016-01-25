
<?php
include("restrito.php");
include("../model/class_epi_bd.php");
include_once("../includes/functions.php");
?>
<html>


<?php Functions::getHead('Pesquisar Equipamentos'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <title>Pesquisar EPI</title>
   <meta charset="UTF-8">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
</head> -->

<body>   
<?php include_once("../view/topo.php"); ?>


        <div class="formulario">
               <div class="title-box" style="float:left"><div style="float:left"><img src="../images/search-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Pesquisar Equipamentos</span></div></div>
                    <form method="POST" class="pesquisa-campos" id="pesquisa-campos" name="pesquisa-campos" action="pesquisa_epi.php">
                       <table id="table-search">
                         <tr>
                            <td><span>Nome: </span></td>
                            <td><input type="text" id="name_search" placeholder="Pesquise em branco para todos os resultados" name="name_search" title="Digite nome do equipamento queepi deseja pesquisar"></td>
                            <td><input type="submit" value="Buscar" class="button"></td>
                         </tr>
                      </table>
                    </form>
             <?php
                   if(isset($_POST['name_search'])){
                      $epi = new Epi();
                      $epis = $epi->get_epi_by_name($_POST['name_search']);
                        echo '<table class="exibe-pesquisa">';
                        $aux = 0;
                        if(count($epis)>0)
                        foreach($epis as $key => $epi){
                          if($aux%2 == 0)
                             echo '<tr style="background-color:#bbb">';
                          else
                              echo '<tr style="background-color:#cbcbcb">'; 

                           echo '<td><a href="pesquisa_epi.php?verificador=1&id='.$epis[$key][0].'">'.$epis[$key][1]." - ".$epis[$key][2].'</a></td></tr>';
                           $aux++;
                        }
                        echo '</table>';
                   }

                   if(isset($_GET['verificador']) && $_GET['verificador'] == 1){
                     $epi = new Epi();
                     $epi = $epi->get_epi_by_id($_GET['id']);
                     echo $epi->printEpi();

                   }
                ?>
        </div>                         
                                
</body>
</html>