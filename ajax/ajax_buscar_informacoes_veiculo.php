<?php
session_start();
include_once("../model/class_veiculo_bd.php");

	$nome = $_GET['veiculo'];  //codigo do estado passado por parametro

	$veiculo = new Veiculo();
	$veiculo = $veiculo->get_veiculo_nome($nome);

	if(count($veiculo) == 0){
		return;
	}
	for ($i = 0; $i < count($veiculo); $i++) {
	  $arrVeiculo[$i][0] = $veiculo[$i][0];
	  $arrVeiculo[$i][1] = $veiculo[$i][1];
	  $arrVeiculo[$i][2] = $veiculo[$i][2];
	  $arrVeiculo[$i][3] = $veiculo[$i][3];
	}
?>

<?php if(isset($_GET['param']) && $_GET['param'] == 0){ // EDITAR FUNCIONARIO?>

<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Veiculo</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($veiculo) 
			    foreach($arrVeiculo as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_patrimonio.php?tipo=editar&controle=2&id=".$arrVeiculo[$value][0]."'>".$arrVeiculo[$value][1]." ".$arrVeiculo[$value][2]." ".$arrVeiculo[$value][3]."</a></td></tr>";
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
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Veículo <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($veiculo) 
			    foreach($arrVeiculo as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a class='icon_excluir' title='Clique para excluir' onclick='confirma2(".'"'.$arrVeiculo[$value][0].'"'.",".'"'.$arrVeiculo[$value][2].'"'.")'>".$arrVeiculo[$value][1]."  ".$arrVeiculo[$value][2]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>


<?php } ?>