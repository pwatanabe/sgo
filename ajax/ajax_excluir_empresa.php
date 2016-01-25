<?php
session_start();
include_once("../model/class_empresa_bd.php");

$empresa = new Empresa();
$empresa->ocultar_by_id($_GET['id']);

$nome = 'a';//busca os clientes com a letra a
// $tipo = $_GET['tipopess'];
$empresa = $empresa->get_empresa_by_nome_fantasia($nome);

if(count($empresa) == 0){
	return;
}
for ($i = 0; $i < count($empresa); $i++) {
  $arrEmpresa[$i][0] = $empresa[$i][0];
  $arrEmpresa[$i][1] = $empresa[$i][1];
  $arrEmpresa[$i][2] = $empresa[$i][2];
}

?>
<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Empresa <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($empresa) 
			    foreach($arrEmpresa as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a title='Clique para excluir' onclick='confirma(".'"'.$arrEmpresa[$value][0].'"'.",".'"'.$arrEmpresa[$value][2].'"'.")'>".$arrEmpresa[$value][2]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
