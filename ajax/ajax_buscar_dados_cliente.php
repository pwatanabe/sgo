<?php
/**
* Class retorna os dados do cliente selecionado no cadastro de obras Cliente/obra
*/
include_once('../administrator/restrito.php');
include_once("../model/class_sql.php");
include_once("../model/class_cliente.php");
include_once("../model/class_endereco_bd.php");

	
	$id = $_GET['id'];  //codigo do cliente passado por parametro
        
	$cliente = Cliente::get_cliandjur_id($id, $_SESSION['id_empresa']);
       
	$endereco = Endereco::get_endereco($cliente->id_endereco);
  	if($cliente)
  		// echo 'Cliente: '.$cliente->nome_razao_soc;
  		echo '<input type="hidden" name="id_cli" value="'.$id.'">';
	      echo '<span><b>Nome/Razao Social:</b></span> <input readonly name="nome_cli" id="nome_cli" type="text" style="border: 0; width:100%;  height:20px; padding-left:20px;" value="'.$cliente->nome_razao_soc.'"><br />
				<span><b>CPF/CNPJ:</b></span><input readonly  name="cpf_cnpj_cli" id="cpf_cnpj_cli" type="text" style="border: 0; width:100%;  height:20px; padding-left:20px;" value="'.$cliente->cpf_cnpj.'"><br />
				<span><b>Endereço:</b></span><input  readonly  name="rua" id="rua" type="text" style="border: 0; width:100%;  height:20px; padding-left:20px;" value="'.$endereco[0][0].'"><br />
				<span><b>Nº:</b></span><input style="width: 100%; border: 0;  height:20px;  padding-left:20px;" readonly  name="num" id="num" type="text" value="'.$endereco[0][1].'"><br />
	     		<span><b>Telefone:</b></span><input readonly  name="telefone_com" id="telefone_com" type="text" style="border: 0; width:100%;  height:20px;padding-left:20px;" value="'.$cliente->telefone_com.'">';
	     // echo "<option>teste</option>";
	  	
	
?>
	




