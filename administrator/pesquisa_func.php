
<?php
include("restrito.php");
include("../model/class_cliente.php");
include("../model/class_valor_custo_bd.php");
include_once("../includes/functions.php");

?>
<html>

<?php Functions::getHead('Pesquisar Funcionário'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <title>Pesquisar Funcionario</title>
   <meta charset="UTF-8">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
</head> -->

<body>   
<?php include_once("../view/topo.php"); ?>


                    <div class="formulario">
                          <div class="title-box" style="float:left"><div style="float:left"><img src="../images/search-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Pesquisar Funcionario</span></div></div>                                                                
                                    <form method="POST" class="pesquisa-campos" id="pesquisa-campos" name="pesquisa-campos" action="pesquisa_func.php">
                                         <table id="table-search">
                                             <tr>                                             
                                                <td><span>Funcionario Nome: </span></td>
                                                <td><input style="width:100%" type="text" id="name_search" name="name_search" placeholder="Pesquise em branco para todos os registros."></td>
                                                <td><input type="submit" class="button" value="Buscar"></td>
                                             </tr>
                                          </table>
                                    </form>
                         <?php

                          if(isset($_POST['name_search'])){
                               $func = new Funcionario();    
                                                  
                                $funcs = $func->get_func_by_name($_POST['name_search'], $_SESSION['id_empresa']);
                                
                                echo '<table class="exibe-pesquisa">';
                                echo '<tr><td>ID</td><td>Nome</td></tr>';
                                $aux = 0;
                                if(count($funcs)>0)
                                foreach($funcs as $key => $func){
                                  if($aux%2 == 0)
                                       echo '<tr style="background-color:#bbb">';
                                  else
                                      echo '<tr style="background-color:#cbcbcb">';

                                    echo '<td><a href="pesquisa_func.php?verificador=1&id='.$funcs[$key][0].'">'.$funcs[$key][0].'</a></td><td><a href="pesquisa_func.php?verificador=1&id='.$funcs[$key][0].'">'.$funcs[$key][1].'</a></td>
                                        </tr>';
                                  $aux++;
                                }
                                echo '</table>';
                           
                           }
                           if(isset($_GET['verificador']) && $_GET['verificador'] == 1){
                             
                               $func = new Funcionario();
                               $func = $func->get_func_id($_GET['id']);
                                echo $func->printFunc();
                                
                                $_SESSION['func']['id_funcionario']= $_GET['id'];
                                
                            }
                            
                          ?>
                         
                     </div>
                     
                     <?php 
                     if(isset($_GET['id'])){
                     include("../view/historico_funcionario.php"); 
                     }
                     ?>  
                       
</body>
</html>