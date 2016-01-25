<?php
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_epi_bd.php");

	$sql = new Sql();
	$sql->conn_bd();

	$nome_epi = $_GET['nome_epi'];  //codigo do estado passado por parametro
		
	$epi = new Epi();
	$epi = $epi->get_epi_by_name($nome_epi);

	if(count($epi) == 0){
		echo "<div class='msg' style='margin-top: 20px;'>Nenhum Registro encontrado!</div>";
		return;
	}
	for ($i = 0; $i < count($epi); $i++) {
	  $arrEpi[$i][0] = $epi[$i][0];
	  $arrEpi[$i][1] = $epi[$i][1];
	}
?>


<?php if(isset($_GET['param']) && $_GET['param'] == 0){ // EDITAR FUNCIONARIO?>

<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">EPI</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($epi) 
			    foreach($arrEpi as $value => $epi){
			      echo "<tr><td style='padding-left:20px;'><a href='add_epi.php?tipo=editar&id=".$arrEpi[$value][0]."'>".$arrEpi[$value][1]."</a></td></tr>";
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
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Excluir Epi <span>(Clique em um registro para excluir)</span></div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($epi) 
			    foreach($arrEpi as $value => $nome_epi){
			      echo "<tr><td style='padding-left:20px;'><a class='icon_excluir' title='Clique para excluir' onclick='confirma(".'"'.$arrEpi[$value][0].'"'.",".'"'.$arrEpi[$value][1].'"'.")'>".$arrEpi[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>


<?php } ?>



<!-- <div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Funcionários</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($epi) 
			    foreach($arrEpi as $value => $epi){
			      echo "<tr><td style='padding-left:20px;'><a href='add_epi.php?tipo=editar&id=".$arrEpi[$value][0]."'>".$arrEpi[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}			  	
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div> -->