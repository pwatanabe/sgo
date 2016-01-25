<?php
session_start();

if(isset($_SESSION["id"]) && isset($_SESSION["user"]) && isset($_SESSION["id_empresa"]) && isset($_SESSION['logado']) && $_SESSION['logado'] == md5($_SESSION["id"]) ){
	header("location:principal");
}
include_once("../includes/functions.php");
include_once("../model/class_horarios_bd.php");
?>
<html>

<?php Functions::getHead('Administrator'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
	<title></title>
	<link rel="stylesheet" type="text/css" href="../css/bootstrap.css">
	<link rel="stylesheet" type="text/css" href="styles/style.css">
	
</head> -->

<?php 

		// inicia a tabela de horarios esquecidos, a tabela de horarios esquecidos controla quem registrou ou não registrou o ponto eletronico,
		// essa tabela mantem os registros sempre 10 dias a mais iniciando na data atual
		// esse metodo verifica se existe um registro faltando nessa tabela e atualiza
		Horarios::inicia_horarios_esquecidos();
		
	 ?>

<body class="body-login">
	<!-- <div class='container'> -->
	<div style="margin: 0 auto; width:500px;">
		<div class='content' style="padding: 5; float:left">
			<img src="../images/logo-sgo.png" style="margin: 0 auto; width:350px;">
			<form type="submit" method="POST" action="loggar.php" > 
				<table class="tabelapadrao" id="table_login" border="0" style="width:250px;">
					<tr>
						<td><input class="form-control" style="text-align:center" placeholder="Usuário" type="text" name="id" id="id"></td>
					</tr>
					<tr>
						<td><input class="form-control" style="text-align:center" placeholder="Senha" type="password" name="pass" id="pass"></td>
					</tr>
					<tr>
						<td><input id="btn_entrar" style="width:100px; margin: 0 auto;" class="form-control" name="btn_entrar" type="submit" value="Entrar"><div style="font-size:11px; margin-top:5px;"><a href="../#cadastro">Cadastre-se</a><br /><a href="../view/esqueci_minha_senha">Esqueci minha senha</a><div></td>
					</tr>
				</table>
			</form>
			<?php 
				if(isset($_GET['falha']) && $_GET['falha'] == 'login'){
					echo "<div style='width:100%; height:50px; font-size:14px; color:#b00'><div style='padding:10px;'>Usuário ou senha inválidos!</div></div>";
				}
				if(isset($_GET['falha']) && $_GET['falha'] == 'session'){
					echo "<div style='float:left; width:100%; height:50px; font-size:14px; color:#b00;'><div style='padding:10px;'>Sua sessão expirou!<br />Por favor, efetue o login novamente!</div></div>";
				}
			 ?>
			
		</div>
	</div>
	<!-- </div> -->
</body>
</html>
