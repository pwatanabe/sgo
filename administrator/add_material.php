<?php
include("restrito.php"); 

include_once("../model/class_sql.php");
include_once("../model/class_empresa_bd.php");
include_once("../model/class_unidade_medida_bd.php");
include_once("../model/class_material_bd.php");
include_once("../includes/functions.php");


function validate(){
   if(!isset($_POST['nome']) || $_POST['nome'] == ""){
        return false;
   	}
   		   return true;
    }
function formata_salario($valor){
    $replace = array(".","R$ ");
    $string = str_replace($replace, "", $valor);

    $replace = array(",");
    $string = str_replace($replace, ".", $string);
    
    $return = $string;
    return $return;
}

function verificaValor($valor){
        
    if(!strpos($valor, '.')){// se não existe . na string (EX R$ 15) tem que adicionar .00 para ficar (R$ 15.00)
       $valor .= '.00';

    /**** Comments else if ****
      se (tamanho da string) - (posisão do ponto) for < 3 
      EX:
      len ->  12345
      str ->  100.5
      pos ->  01234
      
      len == 5; pos == 3;

      (5-3) == 2; 2 < 3

    */
    }else if(strlen($valor) - strpos($valor, '.') < 3){
        $valor .= '0';
    }
    
    return $valor;
}
    
    
 ?>

<html>
    
<?php Functions::getHead('Adicionar'); //busca <head></head> da pagina, $title é o titulo da pagina ?>

<!-- <head>
	 <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
	 <link rel="stylesheet" type="text/css" href="styles/style.css">

</head> -->

<?php Functions::getScriptMaterial(); ?>

<body>	
			<?php include_once("../view/topo.php"); ?>

			<div id="content">                                               
            <div class="formulario">
            
            <?php if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){?>
            	<?php 
                     $id = $_GET['id'];
                     $material = new Material();
                     $material = $material->get_material_id($id);
                     $id = $material->id;
                     $nome = $material->nome;
                     $u_m = new Unidade_medida(); //u_m UNIDADE DE MEDIDA
                     $u_m = $u_m->get_unidade_medida_by_id($material->id_unidade_medida);
            	 ?>

                <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR MATERIAL</span></div></div>
                       <form method="POST" id="add_material" action="add_material" onsubmit="return validate(this)">
                            
                            <input type="hidden" id="tipo" name="tipo" value="editar">
                            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">                             
                            <table border="0">
                                <tr><td><span>Nome:</span></td> <td><input type="text" name="nome" id="nome"  value="<?php echo $nome ?>"></td></tr>  
                                
                                <tr><td><span>Unidade de medida:</span></td><td><select id="medida" name="medida"  style="width:100%">
                                    <option value="no_sel">Selecione</option>
                                    <?php 
                                       $medida = new Unidade_medida();
                                       $medida = $medida->get_all_unidade_medida();
                                       for ($i=0; $i < count($medida) ; $i++) { 
                                          echo '<option value="'.$medida[$i][0].'">'.$medida[$i][2].'</option>';
                                       }
                                     ?>
                                       <?php echo "<script> carregaU_M('".$u_m->id."'); </script>" ?> 
                                 </select><td></tr>
                            
                           <tr><td colspan="3" style="text-align:center"><input type="submit" name="button" class="button" id="button" value="Editar"> <input type="button" name="button" class="button" onclick="window.location.href='add_material'" id="button" value="Cancelar"></td></tr>  
                            </table>                            
                       </form>              
            <?php }else{ ?>       
                
                
               
                
                       <form method="POST" class="add_material" id="add_material" name="add_material" action="add_material" onsubmit="return valida(this)">
                        <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">MATERIAIS</span></div></div>
                         <div id="menu-materiais" name="menu-materiais" class="menu-materiais">
                    <span style="margin-left: 15%;"><b>Nome</span>
                    <span style="margin-left: 4%;">Unidade</span>
                    <span style="margin-left: 2%;">Empresa</span>
                    
                    

                </div>
                         <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                        <?php 
                        $limite = 1;
                        if(isset($_POST['quantidade'])){
                            $limite = $_POST['quantidade'];
                        }
                       
                        ?> 
                         
                         <div><span style='margin-top:20px;'>Quantos materias deseja adicionar ?</span>
                            <select name="quantidade" style='margin-top:20px; margin-left: 20px;'>
                                <option value='5'>5</option>
                                <option value='10'>10</option>
                                <option value='15'>15</option>                                
                            </select>
                             <input type="submit" value="ir">
                        </div>
                        <?php
                        
                       for($j = 0 ; $j<$limite; $j++){ //* Dentro deste for os J e contador para deixar os names e ids de input *//
                             ?>
                         
                          <table border="0">                          
                            <tr><td><input type="text" name="<?php echo $j.":nome" ?>" id="<?php echo $j.":nome" ?>"></td><td>
                                  <select id="<?php echo $j.":medida" ?>" name="<?php echo $j.":medida" ?>"  style="width:100%">
                                    <option value="no_sel">Selecione</option>
                                    <?php 
                                       $medida = new Unidade_medida();
                                       $medida = $medida->get_all_unidade_medida();
                                       for ($i=0; $i < count($medida) ; $i++) { 
                                          echo '<option value="'.$medida[$i][0].'">'.$medida[$i][2].'</option>';
                                       }
                                     ?>
                                     
                                 </select></td>
                                 
                              <td>
                                  <select id="<?php echo $j.":empresa" ?>" name="<?php echo $j.":empresa" ?>"  style="width:100%">
                                    <option value="no_sel">Selecione</option>
                                    <?php 
                                       $empresa = new Empresa();
                                       $empresa = $empresa->get_all_empresa();
                                       for ($i=0; $i < count($empresa) ; $i++) { 
                                          echo '<option value="'.$empresa[$i][0].'">'.$empresa[$i][2].'</option>';
                                       }      
                                     ?>                                      
                                 </select>
                                          <?php echo "<script>carregaEmp(".$_SESSION['id_empresa'].','.$j.")</script>"; ?>
                              </td>
                              </tr>
                              
                             
                          </table>
                            <?php
                        }
                        ?>
                      
                          <div colspan="3" style=" margin-top: 10px;"><input type="submit" name="button" class="button" id="button" value="Cadastrar">
                          <input type="button" name="button" class="button" onclick="window.location.href='add_material'" id="button" value="Cancelar"></div>
                       </form>      
     
            <?php }?>               
			
			<?php 
                        
                if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar"){ //* Recebendo comando POST e verificando condição para adição
                    
                    $i = 0; $adicionados=0;
                    foreach ($_POST as $key => $value){
                        
                        if($key != "quantidade" && $key != "tipo" && $key != "button" ){ /* Comando para não ajudar o array sem entrtar quantidade tipo e button**/
                         
                         $data = explode(":",$key);
                                                    
                          if($data[1] == "nome"){
                              
                             $nome = $value;
                             $i++;
                          }
                           if($data[1] == "medida"){
                               $medida = $value;
                             $i++;
                          }
                           if($data[1] == "empresa"){                              
                               $empresa = $value."<br>";
                              $i++;
                          }
                          if($i == 3){                                                                  /*condição de adição, quando naa estiver vazio*/
                              if($nome != "" && $medida != "no_sel" && $empresa != "no_sel"){
                                $material = new Material();
                                $material->add_material($nome, $medida, $empresa);
                                if($material->add_material_bd()){
                                    $adicionados++;
                                }
                                }
                            $i = 0;
                          }                          
                         }
                        }
                        if($adicionados != 0){
                            echo '<script>alert("Adicionado com sucesso!")</script>';
                        }
                    }
                   
                if(isset($_POST['tipo']) && $_POST['tipo'] == "editar"){
                    
                	if(isset($_POST['id'])){
                              
                            if(validate()){
                               $valor_custo = new Valor_custo();
                               $material = new Material();
                               $id = $_POST['id'];
                               $nome = $_POST['nome'];
                               $id_unidade_medida = $_POST['medida'];
                     
                              if($material->atualiza_material($nome, $id_unidade_medida, $id )){                                 
                              }else{
                                 echo '<div class="msg">Falha na atualização!</div>';
                              }
                              
	                       }
	                   }                         
                        }
	           	
		 		?>
	 	    </div> 
                         <?php include_once("informacoes_material.php") ?> 
                    </div> 

</body>
</html>