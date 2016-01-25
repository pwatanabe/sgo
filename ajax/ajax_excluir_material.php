<?php
session_start();
include_once("../model/class_material_bd.php");

$material = new Material();
$material-> ocultar_by_id($_GET['id']);

$nome = 'a';//busca os funcionarios com a letra a
$material = $material->get_material_by_name($nome);

if(count($material) == 0){
	return;
}
for ($i = 0; $i < count($material); $i++) {
  $arrMaterial[$i][0] = $material[$i][0];
  $arrMaterial[$i][1] = $material[$i][1];
}

?>
<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Material <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($material) 
			    foreach($arrMaterial as $value => $nome){
			    echo "<tr><td style='padding-left:20px;'><a title='Clique para excluir' onclick='confirm(".'"'.$arrMaterial[$value][0].'"'.",".'"'.$arrMaterial[$value][1].'"'.")'>".$arrMaterial[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
