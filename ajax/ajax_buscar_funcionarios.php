<?php
/*
* Pagina retorna os funcionarios para a pagina add_obra na busca de funcionarios pelo nome
*/
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_cliente.php");
include_once("../global.php");

	$sql = new Sql();
	$sql->conn_bd();
	$g = new Glob();

	$nome = $_GET['nome'];  //codigo do funcionarios passado por parametro

	$query = "SELECT * FROM funcionario WHERE nome LIKE '%%%s%%' && id_empresa='%s' && oculto = 0";
	$res = $g->tratar_query($query, $nome, $_SESSION['id_empresa']);
	
	
	if($res)
		$num = mysql_num_rows($res);
	else
		$num = 0;
	//monto um array de cidades
	for ($i = 0; $i < $num; $i++) {
		// echo '<script>alert("achou")<script>';
	    $dados = mysql_fetch_array($res);
	    $arrClientes[$dados['id']] = $dados['nome'];
	}
?>


<select name="funcionarios" id="funcionarios" size='10' style="height: 100%; width: 100%" onDblClick="selecionaFuncionarios(this.value)">
  <?php
  	if($dados) 
	    foreach($arrClientes as $value => $nome){
	      echo "<option value='{$value}'>{$nome}</option>";
	     // echo "<option>teste</option>";
	  	}
	
?>
	
</select>