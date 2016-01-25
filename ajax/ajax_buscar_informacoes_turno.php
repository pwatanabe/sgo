<?php

include_once("../model/class_sql.php");
include_once("../model/class_turno_bd.php");

	$nome = $_GET['nome'];  //codigo do estado passado por parametro
	$turno = new Turno();
	$turno = $turno->getTurnoByName($nome);
	//monto um array de cidades
	if(count($turno) == 0){
		return;
	}
	for ($i = 0; $i < count($turno); $i++) {
	  $arrTurno[$i][0] = $turno[$i][0];
	  $arrTurno[$i][1] = $turno[$i][1];
	}
?>

<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Turno</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($turno) 
			    foreach($arrTurno as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_turno.php?tipo=editar&id=".$arrTurno[$value][0]."'>".$arrTurno[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	// echo '<tr><td style="padding:0;"><hr style="background-color:#eee;"/></td></tr>';
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>