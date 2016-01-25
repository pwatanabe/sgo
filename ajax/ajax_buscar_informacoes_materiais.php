<?php
session_start();
include_once("../model/class_material_bd.php");

	$nome = $_GET['material'];  //codigo do estado passado por parametro

	$material = new Material();
	$material = $material->get_material_by_name($nome);

	if(count($material) == 0){
		return;
	}
	for ($i = 0; $i < count($material); $i++) {
	  $arrMaterial[$i][0] = $material[$i][0];
	  $arrMaterial[$i][1] = $material[$i][1];
	  $arrMaterial[$i][2] = $material[$i][2];
	 
	}
?>

<?php if(isset($_GET['param']) && $_GET['param'] == 0){ // EDITAR FUNCIONARIO?>

<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Material</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($material) 
			    foreach($arrMaterial as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_material.php?tipo=editar&controle=1&id=".$arrMaterial[$value][0]."'>".$arrMaterial[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
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
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Materiais<span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($material) 
			    foreach($arrMaterial as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a class='icon_excluir' title='Clique para excluir' onclick='confirma(".'"'.$arrMaterial[$value][0].'"'.",".'"'.$arrMaterial[$value][1].'"'.")'>".$arrMaterial[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>


<?php } ?>