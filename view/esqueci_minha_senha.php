<?php
include_once('../model/class_email.php'); 
include_once("../model/class_sql.php");
include_once("../model/class_token.php");
?>
<html>
<head>
	<title>Redefinir senha</title>

	<link rel="stylesheet" type="text/css" href="../style.css">
	<!-- Bootstrap Core CSS -->
    <link href="../css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="../css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript">
	function valida(f){
		for(i = 0; i < f.length ; i++){
			if(f[i].name == 'email'){
				if(f[i].value == ''){
					f[i].style.border = '1px solid #f00';
					return false;
				}
			}
		}
		return true;
	}
</script>
<style type="text/css">
body{
	background: url('../images/shattered.png');
}
table tr td{
	padding:10px;
}
</style>
<body>
	<nav class="navbar navbar-default navbar-fixed-top topnav" role="navigation">
        <div class="container topnav">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand topnav" href="../index.php#about">SGO - Sistema de Gerenciamento de Obras / Redefinir senha</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
           <!--  <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="../#about">Home</a>
                    </li>
                </ul>
            </div> -->
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav><br />
    <div style="margin-top:200px;">
    	<div style="width:35%;  min-width:300px; border: 1px solid #cdcdcd; padding: 20px; margin: 0 auto; box-shadow:1px 1px 10px #898989; border-radius:5px;">
    		<form action="esqueci_minha_senha.php" method="POST" onsubmit="return valida(this)">
		    	<table style="margin: 0 auto; width: 100%; ">
		    		<tr><td style="color:#787878">Digite o e-mail que foi cadastrado para você no sistema SGO</td></tr>
		    		<tr>
		    			<td><input placeholder="Email" name="email" class="form-control" type="email" required></td>
		    		</tr>
		    		<tr>
		    			<td><input class="form-control" type="submit" value="Enviar"></td>
		    		</tr>	
		    	</table>
		    </form>
		    <div style="text-align:center">
		    	<?php 
		    	  if(isset($_POST['email'])){
		    	  			if(Token::verifica_email($_POST['email'])){
							    		$sql = new Sql();
							    		$sql->conn_bd();

							    		$email = new Email();
							    		$token = md5($_POST['email'].date('Y-m-d'));
							    		
							    		$class_token = new Token();
							    		$class_token->add_token($token, date('Y-m-d h:i:s'), '0');
							    		if($class_token->add_token_bd()){
							    			// echo "<script>alert('Token adicionado no banco');</script>";
							    		}
							    		
							    		$msg = 'Clique no link abaixo para redefinir sua senha<br />';
							    		$msg .= '<a href="http://localhost/viacampos/redefinir_senha.php?token='.$token.'">Clique aqui</a>';

							    		$headers = "MIME-Version: 1.1\r\n";
										$headers .= "Content-type: text/plain; charset=iso-8859-1\r\n";
										$headers .= "From: andre_matos13@hotmail.com\r\n"; // remetente
										$headers .= 'Bcc: andre_matos13@hotmail.com' . "\r\n";

										$enviado = $email->send($_POST['email'], $msg, 'Redefinição de senha');

										if($enviado){
											echo 'Um email foi enviado com sucesso para '.$_POST['email'].'<br />Verifique seu email para mais informações';
										}else{
											echo 'Falha ao enviar email';
										}

								}else{
									echo '<p style="color:#933">Atenção! Esse email não esta cadastrado em nosso banco de dados</p>';
								}
						    		
						    		// // echo $token;
						    		// echo '<br />';
						    		// echo md5($_POST['email'].date('Y-m-d')).' - '.$_POST['email'].date('Y-m-d');echo '<br />';
						    		// echo md5('andre_matos13@hotmail.com2015-10-23'). ' - '. 'andre_matos13@hotmail.com2015-10-23';
					}
			     ?>
		    </div>
    	</div>
    </div>
    

</body>
</html>