<html>
<head>
  <title>Erro</title>
</head>
<style type="text/css">
body{
	background: url('../images/clock2.jpg') no-repeat;
	background-size: 100%;
	background-color: #cdcdcd;
	
}
.solicita_acesso{
	height:0px;
	background-color: rgba(255,255,255,0.4);
	/*background: url("../images/shattered.png");*/
	color:#efefef;
	border-radius: 5px;
	transition: 1s all;
	border: 0px;
	overflow: hidden;
	/*font-size: 0px;*/
	margin-top: 10px;
}
.content{
	/*border: 1px solid;*/
	padding: 10px;
}
.bloco-msg{
	width:50%;
	max-width:50%;
	/*border: 1px solid;*/
	background-color:rgba(255,255,255,0.5);
	box-shadow: 0px 0px 2px #cdcdcd;
	margin: 0 auto;
	border-radius: 5px;
	text-align:center;
	padding: 10px;
	font-family: Arial;

}
.bloco-msg a:hover{
	cursor:pointer;
	text-shadow:0px 0px 3px #333;
}
.bloco-msg-title{
	/*background-color:#D20707;*/
	box-shadow: 0px 0px 2px #cdcdcd;
	border-radius: 4px;
	padding: 2px;
}
#formulario{
	padding:10px;
}
#formulario input, textarea{
	border: 1px solid#cdcdcd;
	border-radius: 5px;
	padding: 5px;
	background-color:rgba(255,255,255,0.2);
}
.button{
	width: 100px;
}
</style>
<script type="text/javascript">
	function exibe(id){
		// document.getElementById(id).style.fontSize = '16px';
		document.getElementById(id).style.height = '320px';
		document.getElementById(id).style.padding = '10px';
		document.getElementById(id).style.color = '#333';
		document.getElementById(id).style.border = '1px solid #cdcdcd';
	}
	function oculta(id){
		// document.getElementById(id).style.fontSize = '0px';
		document.getElementById(id).style.padding = '0px';
		document.getElementById(id).style.height = '0px';
		document.getElementById(id).style.color = '#efefef';
		document.getElementById(id).style.border = '0px';
	}
</script>
<?php 
	function valida(){
		if(!isset($_POST['nome']) || $_POST['nome'] == ''){
			return false;
		}
		if(!isset($_POST['empresa']) || $_POST['empresa'] == ''){
			return false;
		}
		if(!isset($_POST['descricao']) || $_POST['descricao'] == ''){
			return false;
		}
		if(!isset($_POST['telefone']) || $_POST['telefone'] == ''){
			return false;
		}
		return true;
} ?>
<body>
	<div class="content">
		<div class="bloco-msg">
			<?php if(valida()){ 
					include_once('../model/class_solicita_acesso.php');
					
					isset($_POST['mNeUs']) ? $mac = $_POST['mNeUs'] : $mac = null;
					$nome = $_POST['nome'];
					$telefone = $_POST['telefone'];
					$descricao = $_POST['descricao'];
					$empresa = $_POST['empresa'];

					$solicita_acesso = new Solicita_acesso();
					$solicita_acesso->add_solicitacao($mac, $nome, $telefone, $descricao, $empresa);
					if($solicita_acesso->add_solicitacao_bd()){
						echo '<div class="bloco-msg-title"><p><b>Solicitação enviada com sucesso</b></p></div>
					
								<p>Por favor aguarde, entraremos em contato o mais rápido possivel</p>';
					}

			 }else{ ?>
					<div class="bloco-msg-title"><p><b>Acesso Negado</b></p></div>
					
					<p>Desculpe, você não pode acessar o ControlPonto desse computador.</p>

					<a onclick="exibe('solicita_acesso')">Solicitar acesso a este computador</a>
					<div class="solicita_acesso" id="solicita_acesso">

						Por favor, preencha os dados abaixo e clique em enviar para solicitar acesso ao sistema a partir deste computador.
						<div id="formulario">
							<form method="POST" action="erro.php">
								<table style="width:100%; max-width:100%">
									<tr>
										<td><b>Nome:</b></td>
										<td style="width:70%"><input type="text" name="nome" required></td>
									</tr>
									<tr>
										<td><b>Empresa/Posto de trabalho:</b></td>
										<td><input type="text" name="empresa" required></td>
									</tr>
									<tr>
										<td><b>Telefone:</b></td>
										<td><input type="text" name="telefone" required></td>
									</tr>
									<tr>
										<td colspan="2"><b>Descrição:</b><br />
										<textarea style="width:100%; max-width:100%; max-height:100px; height:100px" name="descricao" required></textarea></td>
									</tr>
									<tr>
										<td colspan="2" style="text-align:center"><input type="submit" class="button" value="Enviar"> <input type="button" class="button" onclick="oculta('solicita_acesso')" value="Cancelar"></td>
									</tr>
									
								</table>
							</form>
						</div>
						
					</div>
				</div>
			<?php } ?>
		
	</div>
</body>
</html>