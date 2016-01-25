<?php
include_once('../administrator/restrito.php');
include_once("../model/class_sql.php");

	$sql = new Sql();
	$sql->conn_bd();

	$estado = $_GET['estado'];  //codigo do estado passado por parametro

	$sql = "SELECT * FROM cidade WHERE estado = $estado ORDER BY id";  //consulta todas as cidades que possuem o codigo do estado
	$res = mysql_query($sql);
	if($res)
		$num = mysql_num_rows($res);
	else
		$num = 0;
	//monto um array de cidades
	for ($i = 0; $i < $num; $i++) {
	  $dados = mysql_fetch_array($res);
	  $arrCidades[$dados['id']] = $dados['nome'];
	}
?>


<select name="cidade" id="cidade"  style="width:90%">
  <?php
  	if($dados) {
            echo "<option value='no_sel'></option>";
	    foreach($arrCidades as $value => $nome){
	      ?> 
	      <option  <?php ( isset($_SESSION['obra']['dados']['cidade']) && $_SESSION['obra']['dados']['cidade'] == $value ) ? print 'selected' : '' ?> value='<?php echo $value ?>'><?php echo $nome ?></option>;
	     <?php 
	  	}
        }else
		echo "<option value='no_sel'>Selecione um estado</option>";
?>
</select>