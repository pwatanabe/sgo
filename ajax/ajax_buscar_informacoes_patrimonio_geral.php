<?php
session_start();
include_once("../model/class_patrimonio_geral_bd.php");

	$nome = $_GET['patrimonio_geral'];  //codigo do estado passado por parametro

	$patrimonio_geral = new Patrimonio_geral();
	$patrimonio_geral = $patrimonio_geral->get_patrimonio_geral_nome($nome);

	if(count($patrimonio_geral) == 0){
		
                echo '<div class="msg">Nenhum patrimonio encontrado!</div>';
                return;
	}
	for ($i = 0; $i < count($patrimonio_geral); $i++) {
	  $arrPatrimonio_geral[$i][0] = $patrimonio_geral[$i][0];
	  $arrPatrimonio_geral[$i][1] = $patrimonio_geral[$i][1];
	  $arrPatrimonio_geral[$i][2] = $patrimonio_geral[$i][2];
	  $arrPatrimonio_geral[$i][3] = $patrimonio_geral[$i][3];
	}
?>

<?php if(isset($_GET['param']) && $_GET['param'] == 0){ // EDITAR FUNCIONARIO?>

<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Patrimonio</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
                       
		  	if($patrimonio_geral) 
			    foreach($arrPatrimonio_geral as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_patrimonio.php?tipo=editar&controle=0&id=".$arrPatrimonio_geral[$value][0]."'>".$arrPatrimonio_geral[$value][1]." ".$arrPatrimonio_geral[$value][2]." ".$arrPatrimonio_geral[$value][3]."</a></td></tr>";
			     	$cont++;
			  	}
			  	  echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>
<?php } else if (isset($_GET['param']) && $_GET['param'] == 1){ // EXCLUIR FUNCIONARIO?>
<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Patrimonio <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($patrimonio_geral) 
			    foreach($arrPatrimonio_geral as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a class='icon_excluir' title='Clique para excluir' onclick='confirma0(".'"'.$arrPatrimonio_geral[$value][0].'"'.",".'"'.$arrPatrimonio_geral[$value][2].'"'.")'>".$arrPatrimonio_geral[$value][1]."  ".$arrPatrimonio_geral[$value][2]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>


<?php } ?>