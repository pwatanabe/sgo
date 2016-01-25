<?php
session_start();
include_once("../model/class_produto_bd.php");

	$nome = $_GET['produto'];  //codigo do estado passado por parametro

	$produto = new Produto();
	$produto = $produto->get_produto_by_name($nome);

	if(count($produto) == 0){
		return;
	}
	for ($i = 0; $i < count($produto); $i++) {
	  $arrProduto[$i][0] = $produto[$i][0];
	  $arrProduto[$i][1] = $produto[$i][1];
	}
?>

<?php if(isset($_GET['param']) && $_GET['param'] == 0){ // EDITAR FUNCIONARIO?>

<div class="formulario" style="width:450px">
	<div class="msg" style="float:left">
		<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
			<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
			<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">produto</div>
		</div>
		<table style="float:left" class="table-pesquisa">
		  <?php
		  	$cont=0;
		  	if($produto) 
			    foreach($arrProduto as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a href='add_produto.php?tipo=editar&id=".$arrProduto[$value][0]."'>".$arrProduto[$value][1]."</a></td></tr>";
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
		  	if($produto) 
			    foreach($arrProduto as $value => $nome){
			      echo "<tr><td style='padding-left:20px;'><a class='icon_excluir' title='Clique para excluir' onclick='confirma(".'"'.$arrProduto[$value][0].'"'.",".'"'.$arrProduto[$value][1].'"'.")'>".$arrProduto[$value][1]."</a></td></tr>";
			     	$cont++;
			  	}
			  	echo '<tr><td style="padding-left:20px; font-size: 12px; color:#777;">'.$cont. " registro(s) encontrado(s)</td></tr>";
		   ?>
		  
		</table>
	</div>
</div>


<?php } ?>