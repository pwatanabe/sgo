<?php
session_start();
include_once("../model/class_filial_bd.php");

$filial = new Filial();
$filial-> ocultar_by_id($_GET['id']);

$nome = 'a';//busca os funcionarios com a letra a
$filial = $filial->get_filial_by_cnpj_and_nome($nome);

if(count($filial) == 0){
	return;
}
for ($i = 0; $i < count($filial); $i++) {
  $arrFilial[$i][0] = $filial[$i][0];
  $arrFilial[$i][1] = $filial[$i][1];
}

?>
<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Filiais <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($filial) 
			    foreach($arrFilial as $value => $nome){
			    echo "<tr><td style='padding-left:20px;'><a title='Clique para excluir' onclick='confirma(".'"'.$arrFilial[$value][0].'"'.",".'"'.$arrFilial[$value][1].'"'.")'>".$arrFilial[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
