<?php
include_once("../model/class_sql.php");

	$sql = new Sql();
	$sql->conn_bd();

	$empresa = $_GET['empresa'];  //codigo do estado passado por parametro

	$sql = "SELECT * FROM filiais WHERE id_empresa = $empresa ORDER BY id";  //consulta todos as filiais da empresa
	$res = mysql_query($sql);
	if($res)
		$num = mysql_num_rows($res);
	else
		$num =0;
	//monto um array de cidades
	for ($i = 0; $i < $num; $i++) {
	  $dados = mysql_fetch_array($res);
	  $arrFiliais[$dados['id']] = $dados['nome'];
	}
?>


<select name="empresa_filial" id="empresa_filial">
	<option value="no_sel">Selecione um posto</option>
  <?php
  	if($dados) 
	    foreach($arrFiliais as $value => $nome){
	      echo "<option value='{$value}'>{$nome}</option>";
	     // echo "<option>teste</option>";
	  	}
	
?>
</select>