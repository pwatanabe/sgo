<?php
include_once("restrito.php");
include_once("../model/class_unidade_medida_bd.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");
include_once("../model/class_config.php");
include_once("../model/class_cidade_bd.php");
include_once("../model/class_estado_bd.php");
include_once("../model/class_material_bd.php");
include_once("../model/class_regiao_bd.php");
include_once("../config.php");
include_once("../includes/functions.php");
?>
<html>
<?php 


	function validateUniMed(){
		if(isset($_POST['nome'])){return true;}else{return false;}
		if(isset($_POST['grandeza'])){return true;}else{return false;}
		if(isset($_POST['sigla'])){return true;}else{return false;}
	}
 
    
  function validate(){
      if(isset($_POST['temp_limit_atraso'])){
        if($_POST['temp_limit_atraso'] >= 0 && $_POST['temp_limit_atraso'] <= 60){
         $string = $_POST['temp_limit_atraso'];

    
         if(!preg_match("/^([0-59]+)$/i",$string)){
            echo '<div class="msg">Por favor, digite um valor de 0 à 59</div>';
            return false;
         }
         
         return true;
      }else{
          echo '<div class="msg">Por favor, digite um valor de 0 à 59</div>';
          return false;  
      }
    }
  }
 ?>

<?php Functions::getHead('Configurações'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
   
    <head>
        <script>
               
</script>
    </head>

<link rel="stylesheet" type="text/css" href="styles/config_gerais.css"> 

<?php Functions::getScriptConfiguracoes(); ?>



<body>

            <?php include_once("../view/topo.php"); ?>
    <div class="formulario">
             
               
        <div class="title-box"><div style="float:left"><img src="../images/config.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Configurações</span></div></div>
                  
        <div>
        <?php include_once("../view/ponto.php"); ?> 
        </div>

        <div>
        <?php include_once("../view/unidade_medida.php"); ?> 
        </div>
        
        <div>
        <?php include_once("../view/layout.php"); ?>
        </div>
        
        <div>            
        <?php include_once("../view/configuracoes_gerais.php"); ?>
        </div>
       
                   
     </div>
</body>
</html>