<?php
/*
* Pagina retorna as obras para a pagina visualizar_obras na busca de obras pelo nome
*/
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_obra.php");
include_once("../global.php");

	$sql = new Sql();
	$sql->conn_bd();
	$g = new Glob();

	$nome = $_GET['nome'];  //codigo do estado passado por parametro
	$tipo = $_GET['tipo'];
	$acao = $_GET['acao'];

	if($tipo == 0)
		$query = "SELECT * FROM obras WHERE nome LIKE '%%%s%%' && id_empresa = '%s' && oculto = 0";
	else
		$query = "SELECT * FROM obras WHERE status = '%s' && id_empresa = '%s' && oculto = 0";
	
	$res = $g->tratar_query($query, $nome, $_SESSION['id_empresa']);
	$arrClientes = array();
	
	if($res)
		$num = mysql_num_rows($res);
	else
		$num = 0;
	//monto um array de cidades
	for ($i = 0; $i < $num; $i++) {
	    
	    $dados = mysql_fetch_array($res);
	    $obra = Obra::getObraId($dados['id']);
	    $arrClientes[] = $obra;
	}
?>


<!-- <select name="obras" id="obras" size='10' style="height: 100%; width: 100%" onchange="selecionaCliente(this.value)"> -->
  <?php
  	if(isset($dados)){
		echo '<table class="table_geral">';
		echo '<tr class="tr-cabecalho"><td>ID</td><td>NOME</td><td>DESCRIÇÃO</td><td>STATUS</td></tr>';
		$contTab = 0;
		    foreach($arrClientes as $key => $obra){
		    	if($contTab % 2 == 0)
		    		echo '<tr class="tr-1">';
		    	else
		    		echo '<tr class="tr-2">';

		    	if($acao == 'edita'){
		    		echo "<td><span><a href='edita_obra?t=a_c_o&id=".$obra->id."' value='{$obra->id}' style='width:100%'>{$obra->id}</a></span></td><td><span><a href='edita_obra?t=a_c_o&id=".$obra->id."' value='{$obra->id}' 
					      style='width:100%'>{$obra->nome}</a></span></td><td><span><a href='edita_obra?t=a_c_o&id=".$obra->id."' value='{$obra->id}' style='width:100%' title='$obra->descricao'>";
					echo  substr($obra->descricao,0,70); (strlen($obra->descricao) > 70) ? print '...' : ''; echo "</a></span></td>";
					echo "<td><a href='edita_obra?t=a_c_o&id=".$obra->id."' value='{$obra->id}' style='width:100%'><span>".Obra::getStatus($obra->status)."</span></a></td>";
			    }else{
			        echo "<td><span><a href='visualizar_obras?id=".$obra->id."' value='{$obra->id}' style='width:100%'>{$obra->id}</a></span></td><td><span><a href='visualizar_obras?id=".$obra->id."' value='{$obra->id}' 
			              style='width:100%'>{$obra->nome}</a></span></td><td><span><a href='visualizar_obras?id=".$obra->id."' value='{$obra->id}' style='width:100%' title='$obra->descricao'>";
			        echo  substr($obra->descricao,0,70); (strlen($obra->descricao) > 70) ? print '...' : ''; echo "</a></span></td>";
			        echo "<td><a href='visualizar_obras?id=".$obra->id."' value='{$obra->id}' style='width:100%'><span>".Obra::getStatus($obra->status)."</span></a></td>";
	            }
	            echo '</tr>';
		     // echo "<option>teste</option>";
	            $contTab++;
		  	}
		echo '</table>';
	}else{
		echo '<table class="table_geral">';
		if($nome != 100)
			echo '<tr class="tr-cabecalho"><td>NENHUM REGISTRO ENCONTRADO</td></tr>';
		else
			echo '<tr class="tr-cabecalho"><td>Busque uma obra</td></tr>';
		echo '</table>';
	}
	
?>
	
<!-- </select> -->