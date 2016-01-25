<?php
session_start();
include_once("../model/class_cbo_bd.php");


	$descricao = $_GET['descricao'];  //codigo do estado passado por parametro
	

	$cbo = new Cbo();
	$cbo = $cbo->get_cbo_by_codigo_and_desc($descricao);

	//monto um array de cidades
	if(count($cbo) == 0){
		return;
	}

	for ($i = 0; $i < count($cbo); $i++) {
	  $arrCbo[$i][0] = $cbo[$i][0];
	  $arrCbo[$i][1] = $cbo[$i][2];
	}
?>

<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">CBO</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($cbo) 
			    foreach($arrCbo as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_cbo.php?tipo=editar&id=".$arrCbo[$value][0]."'>".$arrCbo[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	// echo '<tr><td style="padding:0;"><hr style="background-color:#eee;"/></td></tr>';
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>