<?php
include("restrito.php"); 

include_once("../model/class_sql.php");
include("../model/class_grupo_bd.php");

function validate(){
   if(!isset($_POST['desc']) || $_POST['desc'] == ""){
        return false;
   	}
   		return true;
}
 ?>

<html>
<head>
	 <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
	 <link rel="stylesheet" type="text/css" href="styles/style.css">

</head>
<script type="text/javascript">

	function confirma(id,nome, tipopess){
       if(confirm("Excluir Grupo "+nome+" , tem certeza?") ){
          var url = '../ajax/ajax_excluir_grupo.php?id='+id+'&nome='+nome+'&tipopess='+tipopess;  //caminho do arquivo php que irá buscar as cidades no BD
          
          $.get(url, function(dataReturn) {
          	
            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
          });
       }
    }
</script>

<body>	
			<?php include_once("../view/topo.php"); ?>

			<div id="content">                                               
            <div class="formulario">
            <?php if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){?>
            	<?php 
            		 $id = $_GET['id'];
                     $grupo = new Grupo();
                     $grupo = $grupo->get_grupo_id($id);
                     $id = $grupo->id;
                     $nome = $grupo->nome;
                     $descricao = $grupo->descricao;
            	 ?>

                <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR GRUPO GRUPO</span></div></div>
                       <form method="POST" id="add_grupo" action="add_grupo.php" onsubmit="return validate(this)">
                            <input type="hidden" id="tipo" name="tipo" value="editar">
                            <input type="hidden" id="id" name="id" value="<?php echo $id ?>">                            
                            <table border="0">
                            	<tr><td><span>Nome:</span></td> <td><input type="text" name="grupo" id="grupo"  value="<?php echo $nome ?>"></td></tr>
                            <tr><td><span>Descricão:</span></td><td><input type="text" name="desc" id="desc" value="<?php echo $descricao ?>"></td></tr>
                           <tr><td colspan="3" style="text-align:center"><input type="submit" name="button" class="button" id="button" value="editar"> <input type="button" name="button" class="button" onclick="window.location.href='add_grupo.php'" id="button" value="Cancelar"></td></tr>  
                            </table>                            
                       </form>              
            <?php }else{ ?>              
                       <form method="POST" class="add_grupo" id="add_grupo" name="add_grupo" action="add_grupo.php" onsubmit="return validate(this)">
                        <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">CRIAR GRUPO</span></div></div>
                        <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                          <table border="0">                          
                          		<tr><td><span>Nome:</span></td> <td><input type="text" name="grupo" id="grupo"></td></tr>
                             	<tr><td><span>Descricão:</span></td><td><input type="text" name="desc" id="desc"></td></tr>
                          </table>
                          <tr><td colspan="3" style="text-align:center"><input type="submit" name="button" class="button" id="button" value="cadastrar"> <input type="button" name="button" class="button" onclick="window.location.href='add_grupo.php'" id="button" value="Cancelar"></td></tr>
                       </form>          
                       
            <?php }?>               
			
			<?php 
                if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar"){
                   if(validate()){
                     $grupo = new Grupo();
                     $grupo->add_grupo($_POST['grupo'], $_POST['desc']);                    
                     if($grupo->add_grupo_bd()){
                        echo '<div class="msg">Cadastrado com sucesso!</div>';
                     }else{
                        echo '<div class="msg">Erro ao cadastrar!</div>';
                     }

                  	}else{
                
                        echo '<div class="msg">Erro ao cadastrar!</div>';
                     }                  
                }
                if(isset($_POST['tipo']) && $_POST['tipo'] == "editar"){
                	if(isset($_POST['id'])){

                            if(validate()){

                              $grupo = new Grupo();
                              if($grupo->atualiza_grupo($_POST['grupo'], $_POST['desc'], $_POST['id'] ) ){
                                 echo '<div class="msg">Atualizado com sucesso!</div>';
                              }else{
                                 echo '<div class="msg">Falha na atualização!</div>';
                              }
                              
	                       }
	                   }                         
	           		}
	           	
		 		?>
	 	    </div> 
	 	    <?php include("informacoes_grupo.php") ?> 
	 		</div> 
</body>
</html>