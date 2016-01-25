<?php
session_start();
include_once("../model/class_epi_bd.php");

$epi = new Epi();
$epi->ocultar_by_id($_GET['id']);

$nome_epi = 'a';//busca os clientes com a letra a
// $tipo = $_GET['tipopess'];
$epi = $epi->get_epi_by_name($nome_epi);

if(count($epi) == 0){
	return;
}
for ($i = 0; $i < count($epi); $i++) {
  $arrEpi[$i][0] = $epi[$i][0];
  $arrEpi[$i][1] = $epi[$i][1];
 
}

?>
<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Epi <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($epi) 
			    foreach($arrEpi as $value => $nome_epi){
			      echo "<tr><td style='padding-left:20px;'><a title='Clique para excluir' onclick='confirma(".'"'.$arrEpi[$value][0].'"'.",".'"'.$arrEpi[$value][1].'"'.")'>".$arrEpi[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
