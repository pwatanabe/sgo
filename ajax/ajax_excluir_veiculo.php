<?php
session_start();
include_once("../model/class_veiculo_bd.php");


$veiculo = new Veiculo();
$veiculo->ocultar_by_id($_GET['id']);

$nome = 'a';//busca os clientes com a letra a

$veiculo = $veiculo->get_veiculo_by_nome($nome);

if(count($veiculo) == 0){
	return;
}
for ($i = 0; $i < count($veiculo); $i++) {
  $arrVeiculo[$i][0] = $veiculo[$i][0];
  $arrVeiculo[$i][1] = $veiculo[$i][1];
}

?>
<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Veiculo <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($veiculo) 
			    foreach($arrVeiculo as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a title='Clique para excluir' onclick='confirma2(".'"'.$arrVeiculo[$value][0].'"'.",".'"'.$arrVeiculo[$value][1].'"'.")'>".$arrVeiculo[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
