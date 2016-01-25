<?php
/*
* Pagina retorna os clientes para a pagina add_obra na busca de clientes pelo nome
*/
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_cliente.php");
include_once("../global.php");

	$sql = new Sql();
	$sql->conn_bd();
	$g = new Glob();

	$nome = $_GET['nome'];  //codigo do estado passado por parametro

	$query = "SELECT * FROM clientes WHERE nome_razao_soc LIKE '%%%s%%' && id_empresa='%s' && oculto = 0 && (tipo = '%s' || tipo = '%s')";
	$res = $g->tratar_query($query, $nome, $_SESSION['id_empresa'], 0, 1);
	
	
	if($res)
		$num = mysql_num_rows($res);
	else
		$num = 0;
	//monto um array de cidades
	for ($i = 0; $i < $num; $i++) {
		// echo '<script>alert("achou")<script>';
	    $dados = mysql_fetch_array($res);
	    $arrClientes[$dados['id']] = $dados['nome_razao_soc'];
	}
?>


<select name="clientes" id="clientes" size='10' style="height: 100%; width: 100%" onchange="selecionaCliente(this.value)">
  <?php
  	if($dados) 
	    foreach($arrClientes as $value => $nome){
              // $value = $value.",".$_SESSION['id_empresa'];  
	      echo "<option value='{$value}'>{$nome}</option>";
	     // echo "<option>teste</option>";
	  	}
	
?>
	
</select>