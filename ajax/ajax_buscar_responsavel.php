<?php
include_once("../model/class_sql.php");

	$sql = new Sql();
	$sql->conn_bd();

	$empresa = $_GET['empresa'];  //codigo do estado passado por parametro

	$sql = "SELECT * FROM funcionario WHERE id_empresa = $empresa ORDER BY id";  //consulta todas as cidades que possuem o codigo do estado
	$res = mysql_query($sql);
	if($res)
		$num = mysql_num_rows($res);
	else
		$num = 0;
	//monto um array de cidades
	for ($i = 0; $i < $num; $i++) {
	  $dados = mysql_fetch_array($res);
	  $arrFuncionario[$dados['id']] = $dados['nome'];
	}
?>


<select name="responsavel" id="responsavel">
  <?php
  	if($dados) 
	    foreach($arrFuncionario as $value => $nome){
	      echo "<option value='{$value}'>{$nome}</option>";
	     // echo "<option>teste</option>";
	  	}
	else
		echo "<option value='no_sel'>Selecione um Responsável</option>";
?>
</select>