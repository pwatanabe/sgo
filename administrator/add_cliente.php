<?php
include("restrito.php"); 


// 0 = Acesso Total
// 1 = Acesso ViaCampos
// 2 = Acesso ControlPonto


// if($_SESSION['nivel_acesso'] == 0 || $_SESSION['nivel_acesso'] == 1){

// }

require_once("../model/class_cliente.php");
require_once("../model/class_endereco_bd.php");
require_once("../model/class_estado_bd.php");
require_once("../model/class_cidade_bd.php");
include_once("../includes/functions.php");
include_once("../includes/util.php");

 ?>

<html>

<?php 

	function validade(){

		if(isset($_POST['nome'])){return true;}else{return false;}
		if(isset($_POST['data_nasc'])){return true;}else{return false;}
		if(isset($_POST['cpf'])){return true;}else{return false;}
		if(isset($_POST['tel'])){return true;}else{return false;}
		if(isset($_POST['bairro'])){return true;}else{return false;}
		if(isset($_POST['rua'])){return true;}else{return false;}
		if(isset($_POST['numero'])){return true;}else{return false;}
		if(isset($_POST['cidade'])){return true;}else{return false;}
		if(isset($_POST['cep'])){return true;}else{return false;}

	}
 ?>

<?php Functions::getHead('Adicionar'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
	 <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
	 <link rel="stylesheet" type="text/css" href="styles/style.css">
</head> -->

<?php Functions::getScriptCliente(); ?>

<body onload="disparaLoadCidade(), carregaMascaras()">			

	
			<?php include_once("../view/topo.php"); ?>
			<div class='formulario' style="width:500px;">
			<input type="hidden" id="today" value="<?php echo Date('Y-m-d'); ?>">
			<?php if(isset($_GET['tipo']) && $_GET['tipo'] == "editar"){ //editar cliente pessoa fisica?>
					 <div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR CLIENTE</span></div></div>

                    <?php 
                     $cli = new Cliente();
                     $cli = $cli->get_cli_id($_GET['id']);//buscando funcionario no banco
                     $endereco = new Endereco();
                     $endereco = $endereco->get_endereco( $cli->id_endereco );
                     
                      echo '<input type="hidden" id="id_cidade" value="'.$endereco[0][2].'">';
                    

                   ?>
    				<form form method="POST" id="add_cliente" action="add_cliente.php" onsubmit="return valida(this)">
    					  
    					  <input type="hidden" name="tipo_post" value="editar_pessoa_fisica"><?php //input envia o tipo da requisição, se é add cliente,  edita cliente p/fisica ou edita cliente p/juridica ?>
		                  <input type="hidden" id="id_cli" name="id_cli" value="<?php echo $cli->id; ?>">
		                  <input type="hidden" id="id_endereco" name="id_endereco" value="<?php echo $cli->id_endereco; ?>">
					            <table id="table_dados_pes" class="table_dados_pes" border="0" >
					               <tr><td colspan="2" padding-top:='10px'><span class="dados_cadastrais_title"><b>Dados Cadastrais</b><span></td></tr>
					               <tr> <td ><span>Tipo:</span></td> <td>  
						               <?php if($cli->fornecedor){ ?>
					                          		<input type="checkbox" id="fornecedor" checked name="fornecedor" style="height:12px;"><span>Fornecedor</span>
					                   <?php }else{ ?>
					                          		<input type="checkbox" id="fornecedor"  name="fornecedor" style="height:12px;"><span>Fornecedor</span>
					                   <?php } ?>
					           	   </tr>
					                <tr> <td ><span>Nome:</span></td><td colspan="3"><input style="width:100%" type="text" id="nome" name="nome" value="<?php echo $cli->nome; ?>" ></td></tr>
					                <tr> <td ><span>Data Nasc:</span></td> <td><input type="date" id="data_nasc" name="data_nasc" value="<?php echo $cli->data_nasc ?>" ></td></tr>
					                <tr> <td ><span>CPF:</span></td><td><input type="text" id="cpf" name="cpf" value="<?php echo $cli->cpf ?>" ></td></tr> 
					                <tr> <td ><span>Celular:</span></td> <td><input type="text" id="cel" name="cel" value="<?php echo $cli->telefone_cel ?>"></td></tr> 
					                <tr> <td ><span>Telefone:</span></td> <td><input type="text" id="com" name="com"value="<?php echo $cli->telefone_com ?>"></td></tr>                         
					                <tr> <td ><span>RG:</span></td> <td><input type="text" id="rg" name="rg" value="<?php echo $cli->rg ?>" ></td></tr>  
					                <tr> <td colspan="2"><span><b>Endereço</b></span></td></tr>
                                                        <tr> <td ><span>Rua: </span></td><td colspan="3"><input style="width:100%" value="<?php echo $endereco[0][0]; ?>" type="text" id="rua" name="rua" > </td></tr>       
					                <tr> <td ><span>Bairro:</span></td> <td><input type="text" id="bairro" name="bairro"  value="<?php echo $endereco[0][4]; ?>" ></td></tr> 
					                <tr> <td ><span>Numero: </span></td><td colspan="2"><input  style="width:25%" value="<?php echo $endereco[0][1]; ?>" type="number" id="numero" name="numero" > <span>Complemento: </span> <input  style="width:50%" value="<?php echo $endereco[0][6]; ?>" type="text" id="complemento" name="complemento" ></td></tr> 
					                
					                <tr> <td ><span>UF:</span></td> 
					                  <td>
					                    <select id="estado" name="estado" onchange="buscar_cidades()">
					                      <option>Selecione o Estado</option>
					                      <?php 
					                         $estado = new Estado();
					                         $estado = $estado->get_name_all_uf();
					                         for( $aux = 0; $aux < count($estado) ; $aux++){
					                          echo '<option value="'.$estado[$aux][0].'">'.$estado[$aux][1].'</option>';
					                         }
					                      ?>
					                    </select>
					                  </td>
					                  <?php echo "<script> carregaUf(".$endereco[0][3].");</script>"; ?>
					                </tr> 
					                <tr> 
					                  <td><span>Cidade:</span></td>
					                  <td>
					                    <div id="load_cidades">
					                        <select name="cidade" id="cidade">
					                          <option value="">Selecione UF</option>
					                        </select>
					                      </div>
					                  </td>
					                  <?php echo "<script> buscar_cid('".$endereco[0][3]."'); </script>";  ?>
					                </tr>                     
					                <tr> <td ><span>CEP:</span></td> <td><input type="number" id="cep" name="cep" value="<?php echo $endereco[0][5]; ?>"></td></tr> 
					                <tr> <td ><span>Site:</span></td> <td><input type="text" id="site" name="site" value="<?php echo $cli->site ?>" ></td></tr>
					                <tr><td colspan="2"><span><b>Responsável</b></span></td></tr>
					                <tr> <td ><span>Nome:</span></td> <td><input type="text" id="nome_resp" name="nome_resp" value="<?php echo $cli->responsavel ?>" ></td></tr> 
					                <tr> <td ><span>CPF:</span></td> <td><input type="text" id="cpf_resp" name="cpf_resp" value="<?php echo $cli->cpf_responsavel ?>" ></td></tr> 
					                <tr> <td ><span>Data Nascimento:</span></td> <td><input type="date" id="datanasc_resp" name="datanasc_resp" value="<?php echo $cli->data_nasc_responsavel ?>" ></td></tr> 
					                <tr> <td ><span>E-mail:</span></td> <td><input type="text" id="email_resp" name="email_resp" value="<?php echo $cli->email_resp ?>"></td></tr>                     
					                <tr><td colspan="2"><span><b>Observação</b></span></td></tr>                     
					                <tr><td colspan="4"><textarea align="center" rows="4" cols="50" id="observacao" name="observacao"><?php echo $cli->observacao ?></textarea></td></tr>                    
					                <tr>
					                    	 <td colspan="2" style="text-align:center">
					                    	 	<input  class="button" type="submit" value="Salvar">
					                    	 	<input class="button" type="button" name="button" onclick="window.location.href='add_cliente.php'" id="button" value="Cancomar">
					                    	 </td>
					                    </tr> 
					           	 </table>
					        </form>



				<?php }else if(isset($_GET['tipo']) && $_GET['tipo'] == "editarj"){ //editar cliente pessoa juridica?>
							<div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">EDITAR CLIENTE JURIDICO</span></div></div>
							<?php 
			                     $cli = new Cliente();
			                     $cli = $cli->get_cli_jur_id($_GET['id']);//buscando funcionario no banco
			                     $endereco = new Endereco();
			                     $endereco = $endereco->get_endereco( $cli->id_endereco );
			                     echo '<input type="hidden" id="id_cidade" value="'.$endereco[0][2].'">';
			                ?>
						    <form form method="POST" id="edita_cliente_jur" action="add_cliente.php" onsubmit="return valida(this)">
						    		<input type="hidden" name="tipo_post" value="editar_pessoa_juridica"><?php //input envia o tipo da requisição, se é add cliente,  edita cliente p/fisica ou edita cliente p/juridica ?>
						            <input type="hidden" id="id_cli" name="id_cli" value="<?php echo $cli->id; ?>">
						            <input type="hidden" id="id_endereco" name="id_endereco"  value="<?php echo $cli->id_endereco; ?>">
						            <table id="table_dados_pes" class="table_dados_pes" border="0" >
						               <tr><td colspan="2" padding-top:='10px'><span class="dados_cadastrais_title"><b>Dados Cadastrais</b><span></td></tr>
						               <tr> <td ><span>Tipo:</span></td> <td>  
						               <?php if($cli->fornecedor){ ?>
					                          		<input type="checkbox" style="height:12px;" id="fornecedor" checked name="fornecedor"><span>Fornecedor</span>
					                   <?php }else{ ?>
					                          		<input type="checkbox" style="height:12px;" id="fornecedor"  name="fornecedor"><span>Fornecedor</span>
					                   <?php } ?>
					           	   		</tr>
						               <tr> <td ><div id="razao_nome"><span>Razao Social:</span></div></td><td><input type="text" id="nome" name="nome" value="<?php echo $cli->nome; ?>" ></td></tr>
						                   <tr> <td ><div id="data_fun_data_nasc"><span>Data registro: </span></div></td> <td><input type="date" id="data_nasc" readonly name="data_nasc" value="<?php echo $cli->data_nasc_data_fund ?>" ></td></tr>
						                   <tr> <td ><div id="cnpj_cpf"><span>CNPJ:</span></div></td><td><input type="text" id="cnpj" name="cnpj" value="<?php echo $cli->cpf ?>" ></td></tr> 
						                   <tr> <td ><span>Celular:</span></td> <td><input type="text" id="cel" name="cel" value="<?php echo $cli->telefone_cel ?>"></td></tr> 
						                   <tr> <td ><span>Telefone:</span></td> <td><input type="text" id="com" name="com"value="<?php echo $cli->telefone_com ?>"></td></tr>                         
						                   <tr> <td ><div id="inscricao_estadual_rg"><span>Inscrição Estadual:</span></div></td> <td><input type="text" id="inscricao_estadual" name="inscricao_estadual" value="<?php echo $cli->inscricao_estadual ?>" ></td></tr>
						                    <tr><td><div id="inscricao_municipal_rg"><span>Inscrição Municipal:</span></div></td><td><input type="text" id="inscricao_municipal" name="inscricao_municipal" value="<?php echo $cli->inscricao_municipal ?>"></td></tr>  
						                          <tr><td colspan="2"><span><b>Endereço</b></span></td></tr>
						                          <tr> <td ><span>Bairro:</span></td> <td><input type="text" id="bairro" name="bairro"  value="<?php echo $endereco[0][4]; ?>" ></td></tr> 
						                          <tr><td> <span>Rua: </span></td><td colspan="3"><input style="width:100%" value="<?php echo $endereco[0][0]; ?>" type="text" id="rua" name="rua" > </td></tr>        
						                          <tr><td> <span>Numero: </span></td><td colspan="2"><input  style="width:25%" value="<?php echo $endereco[0][1]; ?>" type="number" id="numero" name="numero" > <span>Complemento: </span> <input  style="width:50%" value="<?php echo $endereco[0][6]; ?>" type="text" id="complemento" name="complemento" ></td></tr> 
						                          <tr> <td ><span>UF:</span></td> 
						                            <td>
						                              <select id="estado" name="estado" onchange="buscar_cidades()">
						                                <option>Selecione o Estado</option>
						                                <?php 
						                                   $estado = new Estado();
						                                   $estado = $estado->get_name_all_uf();
						                                   for( $aux = 0; $aux < count($estado) ; $aux++){
						                                    echo '<option value="'.$estado[$aux][0].'">'.$estado[$aux][1].'</option>';
						                                   }
						                                ?>
						                              </select>
						                            </td>
						                            <?php echo "<script> carregaUf(".$endereco[0][3].");</script>"; ?>
						                          </tr> 
						                          <tr> 
						                            <td><span>Cidade:</span></td>
						                            <td>
						                              <div id="load_cidades">
						                                  <select name="cidade" id="cidade">
						                                    <option value="">Selecione UF</option>
						                                  </select>
						                                </div>
						                            </td>
						                            <?php echo "<script> buscar_cid('".$endereco[0][3]."'); </script>";  ?>
						                          </tr>                     
						                          <tr> <td ><span>CEP:</span></td> <td><input type="number" id="cep" name="cep" value="<?php echo $endereco[0][5]; ?>"></td></tr> 
						                          <tr> <td ><span>Site:</span></td> <td><input type="text" id="site" name="site" value="<?php echo $cli->site ?>" ></td></tr>
						                          <tr><td colspan="2"><span><b>Responsável</b></span></td></tr>
						                          <tr> <td ><span>Nome:</span></td> <td><input type="text" id="nome_resp" name="nome_resp" value="<?php echo $cli->responsavel ?>" ></td></tr> 
						                          <tr> <td ><span>CPF:</span></td> <td><input type="text" id="cpf_resp" name="cpf_resp" value="<?php echo $cli->cpf_responsavel ?>" ></td></tr> 
						                          <tr> <td ><span>Data Nascimento:</span></td> <td><input type="date" id="datanasc_resp" name="datanasc_resp" value="<?php echo $cli->data_nasc_responsavel ?>" ></td></tr> 
						                          <tr> <td ><span>E-mail:</span></td> <td><input type="text" id="email_resp" name="email_resp" value="<?php echo $cli->email_resp ?>"></td></tr>                     
						                          <tr><td colspan="2"><span><b>Observação</b></span></td></tr>                     
						                          <tr><td colspan="2"> <div align="center"><textarea align="center" rows="4" cols="50" id="observacao" name="observacao"><?php echo $cli->observacao ?></textarea></div> </td></tr>                     
						                          <tr>
							                    	 <td colspan="2" style="text-align:center">
							                    	 	<input  class="button" type="submit" value="Salvar">
							                    	 	<input class="button" type="button" name="button" onclick="window.location.href='principal.php'" id="button" value="Cancelar">
							                    	 </td>
							                    </tr> 
						            </table>
						        </form>
				<?php }else{ //adicionar cliente?>

						<div class="title-box" style="float:left"><div style="float:left"><img src="../images/user_add.png" width="60px" style="margin-left:-20px; margin-top:-20px;"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">CADASTRO DE CLIENTE</span></div></div>
						<form form method="POST" id="add_cliente" action="add_cliente.php" onsubmit="return valida(this)">
								<input type="hidden" name="tipo_post" value="add_cliente"><?php //input envia o tipo da requisição, se é add cliente,  edita cliente p/fisica ou edita cliente p/juridica ?>
								<table border="0" style="width:100%" >
									 <tr><td colspan="2" padding-top:='10px'><span class="dados_cadastrais_title"><b>Dados Cadastrais</b><span></td></tr>
									 <tr> <td ><span>Tipo:</span></td>
									 	  <td> 	
											 <input type="radio" style="height:12px;" onclick="tipo_form()" id="pessoa_fisica" name="tipo" value="0"><span>Pessoa Física</span>
											 <input type="radio" style="height:12px;" onclick="tipo_form()" id="pessoa_juridica" name="tipo" value="1"checked><span>Pessoa Juridica</span>
											 <input type="checkbox" style="height:12px;" onclick="tipo_form()" id="fornecedor" name="fornecedor"><span>Fornecedor</span>
										 </td>
									 </tr>
									 <tr> <td > <div id="razao_nome"><span>Razão Social:</span></div> </td><td><input type="text" id="nome" name="nome" ></td></tr>
							         <tr> <td > <div id="data_fun_data_nasc"><span>Data registro: </span></div> </td> <td><input type="date" disabled id="data_nasc" name="data_nasc" value="<?php echo Date("Y-m-d") ?>"></td></tr>
							         <tr> <td > <div id="cnpj_cpf"><span>CNPJ:</span></div> </td><td><input type="text" id="cnpj" name="cnpj" ><input type="hidden" id="cpf" name="cpf"  ></td></tr> 
							         <tr> <td > <span>Celular:</span> </td> <td><input type="text" id="cel" name="cel" ></td></tr> 
							         <tr> <td > <span>Telefone:</span> </td> <td><input type="text" id="com" name="com" ></td></tr>			                    
							         <tr> <td > <div id="inscricao_estadual_rg"><span>Inscrição Estadual:</span></div> </td> <td><input type="number" id="inscricao_estadual" name="inscricao_estadual" > <input type="hidden" id="rg" name="rg"  ></td></tr>			                     
							         <tr> <td > <div id="inscricao_municipal_nulo"><span>Inscrição Municipal:</span></div> </td> <td><input type="number" id="inscricao_municipal" name="inscricao_municipal" ></td></tr></div>        
					                    <tr><td colspan="2"><span><b>Endereço</b></span> </td></tr>
					                    <tr><td><span>Bairro:</span></td> <td><input type="text" id="bairro" name="bairro" ></td></tr>
                                                            <tr><td><span>Rua:</span></td> <td><input type="text" id="rua" name="rua" ></td></tr>
					                    <tr><td><span>Numero: </span></td><td><input style="width:25%" type="number" id="numero" name="numero"></td></tr>
                                                            <tr><td><span>Complemento:</span></td><td><input  type="text" id="complemento" name="complemento"></td></tr>
					                    
					                    <tr> <td ><span>UF:</span></td> 
					                    	<td>
					                    		<select id="estado" name="estado" onchange="buscar_cidades()">
					                    			<option>Selecione o Estado</option>
					                    			<?php 
					                    				 $estado = new Estado();
					                    				 $estado = $estado->get_name_all_uf();
					                    				 for( $aux = 0; $aux < count($estado) ; $aux++){
					                    				 	echo '<option value="'.$estado[$aux][0].'">'.$estado[$aux][1].'</option>';
					                    				 }
					                    			?>
					                    		</select>
					                    	</td>
					                    </tr> 
					                    <tr> 
					                    	<td><span>Cidade:</span></td>
					                    	<td>
					                    		<div id="load_cidades">
					                            <select name="cidade" id="cidade">
					                              <option value="">Selecione UF</option>
					                            </select>
					                          </div>
					                    	</td>
					                    </tr>                     
					                    <tr> <td ><span>CEP:</span></td> <td><input type="text" id="cep" name="cep" ></td></tr> 
					                    <tr> <td ><span>Site:</span></td> <td><input type="text" id="site" name="site" ></td></tr>
					                    <tr><td colspan="2"><span><b>Responsável</b></span></td></tr>
					                    <tr> <td ><span>Nome:</span></td> <td><input type="text" id="nome_resp" name="nome_resp" ></td></tr> 
					                    <tr> <td ><span>CPF:</span></td> <td><input type="text" id="cpf_resp" name="cpf_resp" ></td></tr> 
					                    <tr> <td ><span>Data Nascimento:</span></td> <td><input type="date" id="datanasc_resp" name="datanasc_resp" ></td></tr> 
					                    <tr> <td ><span>E-mail:</span></td> <td><input type="text" id="email_resp" name="email_resp" ></td></tr>                     
					                    <tr><td colspan="2"><span><b>Observação</b></span></td></tr>                     
					                    <tr><td colspan="2"> <div align="center"><textarea align="center" rows="4" cols="50" id="observacao" name="observacao" ></textarea></div> </td></tr>                     
					                    <tr>
					                    	 <td colspan="2" style="text-align:center">
					                    	 	<input  class="button" type="submit" value="Cadastrar">
					                    	 	<input class="button" name="button" type="button" onclick="window.location.href='principal.php'" id="button" value="Cancelar">
					                    	 </td>
					                    </tr> 

								</table>
						</form>
					<?php } //fim else?>

				<?php
				if(isset($_POST['tipo_post']) && $_POST['tipo_post'] == 'editar_pessoa_fisica'){
					
					if(validade()){// validate do editar cliente pessoa fisica
	                    
	                        $endereco = new Endereco();                        
	                        $cliente = new Cliente();
	                        $id = $_POST['id_cli'];
	                        $nome_razao_soc = $_POST['nome'];
	                        $data_nasc_data_fund = data_padrao_americano($_POST['data_nasc']); 
	                        $cpf_cnpj = $_POST['cpf']; 
	                        $telefone_cel = $_POST['cel'];
	                        $telefone_com = $_POST['com'];                        
	                        $rg = $_POST['rg'];
	                        $tipo= 0;
	                        $responsavel = $_POST['nome_resp'];
	                        $cpf_responsavel = $_POST['cpf_resp'];
	                        $data_nasc_resp = data_padrao_americano($_POST['datanasc_resp']);
	                        $email_resp = $_POST['email_resp'];
	                        $site = $_POST['site'];
	                        $observacao = $_POST['observacao'];
	                        
	                        $fornecedor = (isset($_POST['fornecedor']))?(($_POST['fornecedor'])?1:0):0;
                        
	                        //recebendo endereco
	                        $rua = $_POST['rua'];
	                        $numero = $_POST['numero'];
	                        $id_cidade = $_POST['cidade'];
	                        $bairro = $_POST['bairro'];
	                        $cep = $_POST['cep'];
                                $complemento = $_POST['complemento'];
	                        

	                        $existe_endereco = $endereco->verifica_endereco($_POST['id_endereco']);

	                       if($existe_endereco){
	                            $endereco->atualiza_endereco($rua, $numero, $id_cidade, $_POST['id_endereco'], $bairro, $cep, $complemento );
	                            $id_endereco = $_POST['id_endereco'];
	                        }else{
	                            $endereco->add_endereco($rua, $numero, $id_cidade, $bairro, $cep, $complemento);
	                            $id_endereco = $endereco->add_endereco_bd();
	                        }

	                       if($cliente->atualiza_cli($id, $nome_razao_soc, $cpf_cnpj, $data_nasc_data_fund, $cpf_cnpj, $telefone_cel, $telefone_com, $tipo, $rg, $id_endereco,  $responsavel, $cpf_responsavel, $data_nasc_resp, $site, $observacao, $fornecedor)){
	                          echo '<div class="msg">Cliente atualizado com sucesso</div>';
	                          echo '<script>alert("Cliente atualizado com sucesso")</script>';
	                       }else{
	                          echo '<div class="msg">Falha ao atualizar funcionário</div>';
	                       }
	                    }//fim validate
                 }//fim if isset($_POST['tipo_post']) && $_POST['tipo_post'] == 'editar_pessoa_fisica'


                 if(isset($_POST['tipo_post']) && $_POST['tipo_post'] == 'editar_pessoa_juridica'){//id editar pessoa juridica
                 	if(validade()){
                       
                      
                        $endereco = new Endereco();                        
                        $cliente = new Cliente();
                        $id = $_POST['id_cli'];
                        $nome_razao_soc = $_POST['nome'];
                        $data_nasc_data_fund = data_padrao_americano($_POST['data_nasc']); 
                        $cpf_cnpj = $_POST['cnpj']; 
                        $telefone_cel = $_POST['cel'];
                        $telefone_com = $_POST['com'];                        
                        $inscricao_estadual = $_POST['inscricao_estadual'];
                        $inscricao_municipal = $_POST['inscricao_municipal'];
                        $tipo = 1;
                        $responsavel = $_POST['nome_resp'];
                        $cpf_responsavel = $_POST['cpf_resp'];
                        $data_nasc_resp = data_padrao_americano($_POST['datanasc_resp']);
                        $email_resp = $_POST['email_resp'];
                        $site = $_POST['site'];
                        $observacao = $_POST['observacao'];
                        $fornecedor = (isset($_POST['fornecedor']))?(($_POST['fornecedor'])?1:0):0;
                        
                        
                        //recebendo endereco
                        $rua = $_POST['rua'];
                        $numero = $_POST['numero'];
                        $id_cidade = $_POST['cidade'];
                        $bairro = $_POST['bairro'];
                        $cep = $_POST['cep'];
                        echo $complemento = $_POST['complemento'];

                        $existe_endereco = $endereco->verifica_endereco($_POST['id_endereco']);

                       if($existe_endereco){
                            $endereco->atualiza_endereco($rua, $numero, $id_cidade, $_POST['id_endereco'], $bairro, $cep, $complemento );
                            $id_endereco = $_POST['id_endereco'];
                        }else{
                            $endereco->add_endereco($rua, $numero, $id_cidade, $bairro, $cep, $complemento);
                            $id_endereco = $endereco->add_endereco_bd();
                        }

                       if($cliente->atualiza_cli_jur($id, $nome_razao_soc, $cpf_cnpj, $data_nasc_data_fund, $cpf_cnpj, $telefone_cel, $telefone_com, $tipo, $inscricao_estadual, $inscricao_municipal, $id_endereco,  $responsavel, $cpf_responsavel, $data_nasc_resp, $site, $observacao, $fornecedor, $email_resp)){
                          echo '<div class="msg">Cliente atualizado com sucesso</div>';
                          echo '<script>alert("Cliente atualizado com sucesso")</script>';
                       }else{
                          echo '<div class="msg">Falha ao atualizar Cliente</div>';
                       }
                    }//fim if validate
                 }//fim if isset($_POST['tipo_post']) && $_POST['tipo_post'] == 'editar_pessoa_juridica'

                 if(isset($_POST['tipo_post']) && $_POST['tipo_post'] == 'add_cliente'){
						if(validade())//validate do add cliente
						{

							//recebendo cliente
							//dados com logica
							if($_POST['tipo'] == 0){
								$cpf_cnpj = $_POST['cpf'];
								$data_nasc_data_fund = (isset($_POST['data_nasc'])) ? data_padrao_americano($_POST['data_nasc']) : '';
							}else if($_POST['tipo'] == 1){		
								$cpf_cnpj = $_POST['cnpj'];
								$data_nasc_data_fund = Date('Y-m-d');
							}

							

							//dados sem logica
							$cliente = new Cliente();
							$nome_razao_soc = $_POST['nome'];

							//$cpf_cnpj = $_POST['cnpj'];	
							$telefone_cel = $_POST['cel'];
							$telefone_com = $_POST['com'];
							$tipo = $_POST['tipo'];

							$rg = $_POST['rg'];
							$inscricao_estadual = $_POST['inscricao_estadual'];
							$inscricao_municipal = $_POST['inscricao_municipal'];
							$responsavel = $_POST['nome_resp'];
							$cpf_responsavel = $_POST['cpf_resp'];
							$data_nasc_resp = data_padrao_americano($_POST['datanasc_resp']);
							$email_resp = $_POST['email_resp'];
							$site = $_POST['site'];
							$observacao = $_POST['observacao'];					
							$fornecedor = (isset($_POST['fornecedor']))?(($_POST['fornecedor'])?1:0):0;
							
							//recebendo endereco
							$endereco = new Endereco();
							$bairro = $_POST['bairro'];
							$rua = $_POST['rua'];
							$numero = $_POST['numero'];
							$cidade_id = $_POST['cidade'];
							$cep = $_POST['cep'];	
                                                        $complemento = $_POST['complemento'];
							$endereco->add_endereco($rua, $numero, $cidade_id, $bairro, $cep, $complemento);	
							$id_endereco = $endereco->add_endereco_bd();
							$id_empresa = $_SESSION['id_empresa'];
							


							$cliente->add_cliente($nome_razao_soc, $data_nasc_data_fund, $cpf_cnpj, $telefone_cel, $telefone_com, $id_endereco, $tipo, $rg, $inscricao_estadual, $inscricao_municipal, $responsavel, $cpf_responsavel, $data_nasc_resp, $email_resp, $site, $observacao, $fornecedor, $id_empresa);
							
							if($cliente->add_cliente_bd()){
								echo "<div class='msg'>Cliente adicionado com sucesso!</div>";
							}else{
								echo "<div class='msg'>Falha ao adicionar cliente!</div>";
							}
						}//fim validate
					}//fim isset($_POST['tipo_post']) && $_POST['tipo_post'] == 'editar_pessoa_fisica'

				?>





			</div>




			<?php include("informacoes_cliente.php"); ?>
	 
</body>
</html>