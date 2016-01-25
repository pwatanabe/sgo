<?php
include_once("model/class_sql.php");
require_once("global.php");
include_once("model/class_token.php");

?>
<html>
<head>
	<title>Redefinir senha</title>

	<link rel="stylesheet" type="text/css" href="style.css">
	<!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">
</head>
<script type="text/javascript">
	function valida(f){
		var erros = 0;
		for(i = 0; i < f.length ; i++){
			if(f[i].name == 'senha1'){
				if(f[i].value == ''){
					f[i].style.border = '1px solid #f00';
					erros++;
				}
			}
			if(f[i].name == 'senha2'){
				if(f[i].value != ''){
					if(f[i-1].value != f[i].value){
						f[i-1].style.border = '1px solid #f00';
						f[i].style.border = '1px solid #f00';
						erros++;
					}
				}else{
					f[i].style.border = '1px solid #f00';
					erros++;
				}
			}
		}
		if(erros == 0){
			return true;
		}else{
			return false;
		}
		
	}
</script>
<style type="text/css">
body{
	background: url('images/shattered.png');
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
                <a class="navbar-brand topnav" href="index.php#about">SGO - Sistema de Gerenciamento de Obras / Redefinir senha</a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">
                    <li>
                        <a href="index.php#about">Home</a>
                    </li>
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
    </nav><br />
<?php


	$g = new Glob();

	if(isset($_GET['token']) && $_GET['token'] != ''){
        $sql = new Sql();
		$sql->conn_bd();
		$token = $_GET['token'];
		if(Token::verificaToken($token)){

				
				$sql = "SELECT * from funcionario WHERE md5(concat_ws('',email, CURRENT_DATE)) = '".$token."' && oculto = 0";

				$result = mysql_query($sql) or print(mysql_error());

				$row = mysql_fetch_array($result);

				if($row['nome'] != ''){
					echo "Funcionario ".$row['nome'];
				}

				$token = (isset($_GET['token'])) ? $_GET['token'] : null;
				?>

				<div style="margin-top:200px;">
			    	<div style="width:35%;  min-width:300px; border: 1px solid #cdcdcd; padding: 20px; margin: 0 auto; box-shadow:1px 1px 10px #898989; border-radius:5px;">
			    		<form action="redefinir_senha.php" method="POST" onsubmit="return valida(this)">
					    	<input type="hidden" name="token" value="<?php echo $token ?>">
					    	<table style="margin: 0 auto; width: 100%; ">
					    		<tr><td style="color:#787878">Insira a nova senha</td></tr>
					    		<tr>
					    			<td><input placeholder="Nova senha" name="senha1" class="form-control" type="password" required></td>
					    		</tr>
					    		<tr>
					    			<td><input placeholder="Repita a senha" name="senha2" class="form-control" type="password" required></td>
					    		</tr>
					    		<tr>
					    			<td><input class="form-control" type="submit" value="Enviar"></td>
					    		</tr>	
					    	</table>
					    </form>
			    	</div>
			    </div>


				<?php
	    }else{ ?>
	    		<div style="margin-top:200px;">
			    	<div style="width:35%;  min-width:300px; border: 1px solid #cdcdcd; padding: 20px; margin: 0 auto; box-shadow:1px 1px 10px #898989; border-radius:5px;">
			    		<form action="redefinir_senha.php" method="POST" onsubmit="return valida(this)">
					    	<input type="hidden" name="token" value="<?php echo $token ?>">
					    	<table style="margin: 0 auto; width: 100%; ">
					    		<tr><td style="color:#787878; text-align:center"><b>Atenção</b><br />O link de redefinição de sua senha não é válido ou já foi usado.</td></tr>
 							</table>
					    </form>
			    	</div>
			    </div>
	    <?php }
	}
	if(isset($_POST['senha1']) && isset($_POST['senha2'])){
		if($_POST['senha1'] == $_POST['senha2']){
			$sql = new Sql();
			$sql->conn_bd();
			$sql = "UPDATE funcionario SET senha = md5('".$_POST['senha2']."') WHERE md5(concat_ws('',email, CURRENT_DATE)) = '".$_POST['token']."' && oculto = 0";
			$resultFun = mysql_query($sql) or print(mysql_error());
			$sql = "UPDATE token SET invalido = '1' WHERE token = '".$_POST['token']."'";
			$resultTok = mysql_query($sql) or print(mysql_error());
			if($resultFun){
				echo "<script>alert('A senha foi alterada com sucesso'); window.location='/viacampos/administrator/'</script>";
			}
			
		}else{
			echo "<script>alert('As senhas são diferentes');</script>";
		}
	}

 ?>
 </body>
 </html>