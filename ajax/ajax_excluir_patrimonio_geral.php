<?php
session_start();
include_once("../model/class_patrimonio_geral_bd.php");

$patrimonio_geral = new Patrimonio_geral();
$patrimonio_geral->ocultar_by_id($_GET['id']);

$nome = 'a';//busca os clientes com a letra a

$patrimonio_geral = $patrimonio_geral->get_patrimonio_geral_nome($nome);

if(count($patrimonio_geral) == 0){
	return;
}
for ($i = 0; $i < count($patrimonio_geral); $i++) {
  $arrPatrimonio_geral[$i][0] = $patrimonio_geral[$i][0];
  $arrPatrimonio_geral[$i][1] = $patrimonio_geral[$i][1];
}

?>
<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Patrimonio Geral <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($patrimonio_geral) 
			    foreach($arrPatrimonio_geral as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a title='Clique para excluir' onclick='confirma0(".'"'.$arrPatrimonio_geral[$value][0].'"'.",".'"'.$arrPatrimonio_geral[$value][1].'"'.")'>".$arrPatrimonio_geral[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
