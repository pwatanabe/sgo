<?php
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_grupo_bd.php");

	$grupo_nome = $_GET['grupo'];  //codigo do estado passado por parametro


	$grupo = new Grupo();
	$grupo = $grupo->get_grupo_by_nome($grupo_nome);
	//monto um array de cidades
	if(count($grupo) == 0){
		return;
	}
	for ($i = 0; $i < count($grupo); $i++) {
	  $arrGrupo[$i][0] = $grupo[$i][0];
	  $arrGrupo[$i][1] = $grupo[$i][1];
	}
?>
<?php if(isset($_GET['param']) && $_GET['param'] == 0){ // EDITAR FUNCIONARIO?>
<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Editar Grupo</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($grupo) 
			    foreach($arrGrupo as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_grupo.php?tipo=editar&id=".$arrGrupo[$value][0]."'>".$arrGrupo[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	// echo '<tr><td style="padding:0;"><hr style="background-color:#eee;"/></td></tr>';
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>
<?php } else if (isset($_GET['param']) && $_GET['param'] == 1){ // EXCLUIR FUNCIONARIO?>
<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Grupo</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($grupo) 
			    foreach($arrGrupo as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a class='icon_excluir' onclick='confirma(".'"'.$arrGrupo[$value][0].'"'.",".'"'.$arrGrupo[$value][1].'"'.")'>".$arrGrupo[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	// echo '<tr><td style="padding:0;"><hr style="background-color:#eee;"/></td></tr>';
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>

<?php } ?>