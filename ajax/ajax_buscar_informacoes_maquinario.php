<?php
session_start();
include_once("../model/class_maquinario_bd.php");

	$nome = $_GET['maquinario'];  //codigo do estado passado por parametro

	$maquinario = new Maquinario();
	$maquinario = $maquinario->get_maquinario_nome($nome);

	if(count($maquinario) == 0){
		return;
	}
	for ($i = 0; $i < count($maquinario); $i++) {
	  $arrMaquinario[$i][0] = $maquinario[$i][0];
	  $arrMaquinario[$i][1] = $maquinario[$i][1];
	  $arrMaquinario[$i][2] = $maquinario[$i][2];
	  $arrMaquinario[$i][3] = $maquinario[$i][3];
	}
?>

<?php if(isset($_GET['param']) && $_GET['param'] == 0){ // EDITAR FUNCIONARIO?>

<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Maquinario</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($maquinario) 
			    foreach($arrMaquinario as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_patrimonio.php?tipo=editar&controle=1&id=".$arrMaquinario[$value][0]."'>".$arrMaquinario[$value][1]." ".$arrMaquinario[$value][2]." ".$arrMaquinario[$value][3]."</a></td></tr>";
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
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Maquinários<span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($maquinario) 
			    foreach($arrMaquinario as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a class='icon_excluir' title='Clique para excluir' onclick='confirma1(".'"'.$arrMaquinario[$value][0].'"'.",".'"'.$arrMaquinario[$value][2].'"'.")'>".$arrMaquinario[$value][1]."  ".$arrMaquinario[$value][2]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>


<?php } ?>