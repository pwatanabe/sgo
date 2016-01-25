
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
?>
<html>

<?php Functions::getHead('Pesquisar Turno'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <title>Pesquisar Turno</title>
   <meta charset="UTF-8">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
</head> -->

<body>   
<?php include_once("../view/topo.php"); ?>

           <div class="formulario">
                    <div class="title-box" style="float:left"><div style="float:left"><img src="../images/search-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Pesquisar Turno</span></div></div>
                    <form method="POST" class="pesquisa-campos" id="pesquisa-campos" name="pesquisa-campos" action="pesquisa_turno.php">
                        <table border="0" style="width:100%; background-color:rgba(150,150,150,0.5); padding: 10 5 10 5">
                            <tr>
                              <td>
                                <span style="font-size:14px">Pesquisar por:</span>
                              </td>
                            </tr>
                            <tr>
                              <td colspan="3" style="">
                                <input style="height:12px; width:12px;" type="radio" name="rdo" value="0" checked><span>Nome</span>
                                <input style="height:12px; width:12px;" type="radio" name="rdo" value="1"><span>Ini. Expediente</span>
                                <input style="height:12px; width:12px;" type="radio" name="rdo" value="2"><span>Ini. Almoço</span>
                                <input style="height:12px; width:12px;" type="radio" name="rdo" value="3"><span>Fim Almoço</span>
                                <input style="height:12px; width:12px;" type="radio" name="rdo" value="4"><span>Fim Expediente</span>
                              </td>
                            </tr>
                             <tr>
                                <td style="padding-top: 20px;"><span >Código ou Descrição: </span>
                                  <input type="text"  id="name_search" name="name_search" title="Digite o código ou a descrição para pesquisar">
                                  <input type="submit" class="button" value="Buscar">
                                </td>
                             </tr>
                        </table>
                      </form>
               <?php
                     if(isset($_POST['name_search']) && $_POST['name_search'] != ""){
                        $turno = new Turno();
                        switch($_POST['rdo']){
                          case 0://nome
                            $turno = $turno->getTurnoByName($_POST['name_search']);
                            break;
                          case 1:// ini exp
                            $turno = $turno->getTurnoBy($_POST['name_search'], 1);
                            break;
                          case 2:// ini alm
                            $turno = $turno->getTurnoBy($_POST['name_search'], 2);
                            break;
                          case 3: // fim alm
                            $turno = $turno->getTurnoBy($_POST['name_search'], 3);
                            break;
                          case 4: // fim exp
                            $turno = $turno->getTurnoBy($_POST['name_search'], 4);
                            break;
                          
                        }
                        switch($_POST['rdo']){
                          case 0:
                                echo '<table class="exibe-pesquisa">';
                                $aux = 0;
                                for($aux=0; $aux < count($turno); $aux++){
                                    if($aux%2 == 0)
                                         echo '<tr style="background-color:#bbb">';
                                    else
                                        echo '<tr style="background-color:#cbcbcb">';
                                    echo '<td><a href="pesquisa_turno.php?verificador=1&id='.$turno[$aux][0].'">'.$turno[$aux][0].' - <b>'.$turno[$aux][1].'</b></td>';
                                    echo '</tr>';
                                    $aux++;
                                }
                                echo '</table>';
                                if(count($turno) == 0)
                                    echo '<div class="msg">Nenhum turno encontrado</div>';
                                break;
                          case 1:
                                echo '<table class="exibe-pesquisa">';
                                $aux = 0;
                                for($aux=0; $aux < count($turno); $aux++){
                                  if($aux%2 == 0)
                                         echo '<tr style="background-color:#bbb">';
                                    else
                                        echo '<tr style="background-color:#cbcbcb">';
                                  echo '<td><a href="pesquisa_turno.php?verificador=1&id='.$turno[$aux][0].'">'.$turno[$aux][0].' - '.$turno[$aux][1].' [ Início expediente: <b>'.$turno[$aux][3].'</b> ]</td>';
                                  echo '</tr>';
                                  $aux++;
                                }
                                echo '</table>';
                                if(count($turno) == 0)
                                    echo '<div class="msg">Nenhum turno encontrado</div>';
                                break;
                          case 2:
                                echo '<table class="exibe-pesquisa">';
                                $aux = 0;
                                for($aux=0; $aux < count($turno); $aux++){
                                  if($aux%2 == 0)
                                         echo '<tr style="background-color:#bbb">';
                                    else
                                        echo '<tr style="background-color:#cbcbcb">';
                                  echo '<td><a href="pesquisa_turno.php?verificador=1&id='.$turno[$aux][0].'">'.$turno[$aux][0].' - '.$turno[$aux][1].' [ Início almoço: <b>'.$turno[$aux][4].'</b> ]</td>';
                                  echo '</tr>';
                                  $aux++;
                                }
                                echo '</table>';
                                if(count($turno) == 0)
                                    echo '<div class="msg">Nenhum turno encontrado</div>';
                                break;
                          case 3:
                                echo '<table class="exibe-pesquisa">';
                                $aux = 0;
                                for($aux=0; $aux < count($turno); $aux++){
                                 if($aux%2 == 0)
                                         echo '<tr style="background-color:#bbb">';
                                    else
                                        echo '<tr style="background-color:#cbcbcb">';
                                  echo '<td><a href="pesquisa_turno.php?verificador=1&id='.$turno[$aux][0].'">'.$turno[$aux][0].' - '.$turno[$aux][1].' [ Fim almoço: <b>'.$turno[$aux][5].'</b> ]</td>';
                                  echo '</tr>';
                                  $aux++;
                                }
                                echo '</table>';
                                if(count($turno) == 0)
                                    echo '<div class="msg">Nenhum turno encontrado</div>';
                                break;
                          case 4:
                                echo '<table class="exibe-pesquisa">';
                                $aux = 0;
                                for($aux=0; $aux < count($turno); $aux++){
                                 if($aux%2 == 0)
                                         echo '<tr style="background-color:#bbb">';
                                    else
                                        echo '<tr style="background-color:#cbcbcb">';
                                  echo '<td><a href="pesquisa_turno.php?verificador=1&id='.$turno[$aux][0].'">'.$turno[$aux][0].' - '.$turno[$aux][1].' [ Fim expediente: <b>'.$turno[$aux][6].'</b> ]</td>';
                                  echo '</tr>';
                                  $aux++;
                                }
                                echo '</table>';
                                if(count($turno) == 0)
                                    echo '<div class="msg">Nenhum turno encontrado</div>';
                                break;
                        }
                     }

                     if(isset($_GET['verificador']) && $_GET['verificador'] == 1){
                         $turno = new Turno();
                         $turno = $turno->getTurnoById($_GET['id']);
                         if(count($turno) > 0)
                            echo $turno->printTurno();
                         else
                            echo '<div class="msg">Nenhum turno encontrado</div>';

                     }
                  ?>
                          </div>                         
                                
</body>
</html>