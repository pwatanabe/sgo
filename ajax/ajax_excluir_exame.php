<?php
session_start();
include_once("../model/class_exame_bd.php");

$exame = new Exame();
$exame->ocultar_by_id($_GET['id']);

$nome = 'a';//busca os clientes com a letra a

$exame = $exame->get_exame_by_desc($nome);

if(count($exame) == 0){
	return;
}
for ($i = 0; $i < count($exame); $i++) {
  $arrExame[$i][0] = $exame[$i][0];
  $arrExame[$i][1] = $exame[$i][1];
}

?>
<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Clientes <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($exame) 
			    foreach($arrExame as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a title='Clique para excluir' onclick='confirma(".'"'.$arrExame[$value][0].'"'.",".'"'.$arrExame[$value][1].'"'.")'>".$arrExame[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
