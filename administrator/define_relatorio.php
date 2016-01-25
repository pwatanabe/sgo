<?php
include_once("restrito.php");

include_once("../model/class_funcionario_bd.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");
include_once("../includes/functions.php");

?>
<html>


<?php Functions::getHead('Relatórios'); //busca <head></head> da pagina, $title é o titulo da pagina ?>

<!-- <head>
   <title>Relatórios</title>
   <meta charset="UTF-8">
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
</head> -->

<body>


         
            <?php include_once("../view/topo.php"); ?>

            <div class="formulario">
                <div class="title-box" style="float:left"><div style="float:left"><img src="../images/icon-reports.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">RELATÓRIOS</span></div></div>
                <div class="box">
                     <table class="define-relatorio">
                         <tr>
                           <td><a href="../reports/folha_ponto">Folha ponto<span style="font-size: 12px; color:#898989;"> (Imprimir folha ponto do funcionário)</span></a></td>
                         </tr>
                         <tr>
                           <td><a href="../reports/funcionario">Dados do funcionário<span style="font-size: 12px; color:#898989;"> (Imprimir informações de um funcionário)</span></a></td>
                         </tr>
                         <tr>
                          <td><a href="../reports/relatorio?rel=listafunc" title="Gerar PDF" target="_self">Lista de Funcionários<span style="font-size: 12px; color:#898989;"> (Gera uma lista com informações de todos os funcionários)</span></a></td>
                         </tr>
                     </table>
                <div>
            </div>
         

</body>
</html>