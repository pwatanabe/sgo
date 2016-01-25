<?php
session_start();
include_once("../model/class_funcionario_bd.php");

	$nome = $_GET['funcionario'];  //codigo do estado passado por parametro

	$funcionario = new Funcionario();
	$funcionario = $funcionario->get_func_by_name($nome);

	if(count($funcionario) == 0){
		return;
	}
	for ($i = 0; $i < count($funcionario); $i++) {
		  $arrFuncionario[$i][0] = $funcionario[$i][0];
		  $arrFuncionario[$i][1] = $funcionario[$i][1];
	}
?>

<?php if(isset($_GET['param']) && $_GET['param'] == 0){ // ADICIONAR EPI POR FUNCIONARIO?>

<div class="formulario" style="width:430px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Adicionar <span>(Equipamentos para o funcionário escolhido)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($funcionario) 
			    foreach($arrFuncionario as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_epiXfunc.php?tipo=cadastrar&id=".$arrFuncionario[$value][0]."'>".$arrFuncionario[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>
<?php } else if (isset($_GET['param']) && $_GET['param'] == 1){ // EXCLUIR EPI FUNCIONARIO?>
<div class="formulario" style="width:430px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Funcionários <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($funcionario) 
			    foreach($arrFuncionario as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a class='icon_excluir' title='Clique para excluir' onclick='confirma(".'"'.$arrFuncionario[$value][0].'"'.",".'"'.$arrFuncionario[$value][1].'"'.")'>".$arrFuncionario[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>		  
		</table>
	</div>
</div>

<?php } else if (isset($_GET['param']) && $_GET['param'] == 2){ // EDITAR  EPI FUNCIONARIO?>
<div class="formulario" style="width:430px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Editar <span>(Clique em um registro para alterar)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($funcionario) 
			    foreach($arrFuncionario as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_epiXfunc.php?tipo=editar&id=".$arrFuncionario[$value][0]."'>".$arrFuncionario[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>		  
		</table>
	</div>
</div>
		  


<?php } ?>