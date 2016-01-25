<?php
session_start();
include_once("../model/class_patrimonio_bd.php");


$patrimonio = new Patrimonio();
$patrimonio->ocultar_by_id($_GET['id']);

$nome = 'a';//busca os clientes com a letra a

$patrimonio = $patrimonio->get_patrimonio_by_nome($nome);

if(count($patrimonio) == 0){
	return;
}
for ($i = 0; $i < count($patrimonio); $i++) {
  $arrPatrimonio[$i][0] = $patrimonio[$i][0];
  $arrPatrimonio[$i][1] = $patrimonio[$i][1];
}

?>
<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Patrimonio <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($patrimonio) 
			    foreach($arrPatrimonio as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a title='Clique para excluir' onclick='confirma(".'"'.$arrPatrimonio[$value][0].'"'.",".'"'.$arrPatrimonio[$value][1].'"'.")'>".$arrPatrimonio[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
