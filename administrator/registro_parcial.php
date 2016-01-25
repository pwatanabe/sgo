
<?php
include_once("../global.php");
include_once("../model/class_sql.php");
include_once("../model/class_config.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_empresa_bd.php");
require_once("../phpmailer/phpmailer.class.php");

		function validate(){
		  if(!isset($_POST['nome']) || $_POST['nome'] == ""){
		        return false;
		    }  
		   if(!isset($_POST['email']) || $_POST['email'] == ""){
		       return false;
		   }
		   if(!isset($_POST['cpf']) || $_POST['cpf'] == ""){
		       return false;
		   }
		   if(!isset($_POST['telefone']) || $_POST['telefone'] == ""){
		       return false;
		   }
		   if(!isset($_POST['senha']) || $_POST['senha'] == ""){
		       return false;
		   }
		   if(!isset($_POST['senha1']) || $_POST['senha1'] == ""){
		       return false;
		   }
		   if ($_POST['senha'] != $_POST['senha1']) {
		     	return false;
		     }  
		   if(!isset($_POST['nome_fantasia']) || $_POST['nome_fantasia'] == ""){
		       return false;
		   }
		   if(!isset($_POST['razao_soc']) || $_POST['razao_soc'] == ""){
		       return false;
		   }
		   if(!isset($_POST['cnpj']) || $_POST['cnpj'] == ""){
		       return false;
		   }
		   return true;
		}
		
		if (validate()){
			
		
		    $nome = $_POST['nome'];
		    $email = $_POST['email'];
		    $cpf = $_POST['cpf'];
		    $telefone = $_POST['telefone'];
		    $senha = $_POST['senha'];
		    $senhaoriginal = $senha; // CODIGO SERA RETIRADO APENAS PARA TESTE !!!!!!!!
		    $senha = md5($senha);
		
		    '<br>'.$nome_fantasia = $_POST['nome_fantasia'];
		    $razao_soc = $_POST['razao_soc'];
		    $cnpj = $_POST['cnpj'];
		
		    
		    $funcionario = new Funcionario();
			$empresa = new Empresa();
		    
		    $id_empresa = $empresa->busca_ultimo_id_empresa(); /*resgata o ultimo id para cirar novo id de empresa*/
			
			$config = new Config();
		   	$config->add_config($id_empresa, 10, 1, 1); // inicia as configurações para essa empresa
		    $config->add_config_bd(); // inicia as configurações para essa empresa


		    $funcionario->add_func_parcial($nome, $email, $cpf, $telefone, $senha, $id_empresa);
		    $funcionario->add_func_parcial_bd();
		    
		
		
		    
		    $id_responsavel = $funcionario->busca_ultimo_id_funcionario();	/*resgata o ultimo id para cirar novo id de funcionario*/
		
		    $empresa->add_empresa_parcial($nome_fantasia, $razao_soc, $cnpj, $id_responsavel);
		    $empresa->add_empresa_parcial_bd();
			
		    // Inicia a classe PHPMailer
			$mail = new PHPMailer();
			
			$mail->IsSMTP(); // @amats Define que a mensagem será SMTP
			$mail->Host = 'mail.controlsystem.com.br'; // @amats  Endereço do servidor SMTP
			$mail->SMTPAuth = true; // @amats  Usa autenticação SMTP? (opcional)
			$mail->Port = 587; // @amats Define a Porta
			$mail->Username = 'andre@controlsystem.com.br'; // @amats Usuário do servidor SMTP
			$mail->Password = 'j3540771';
			// Define o remetente
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->From = "andre@controlsystem.com.br"; // Seu e-mail
			$mail->FromName = "SGO - Sistema de Gerenciamento de Obras"; // Seu nome
			// Define os destinatário(s)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->AddAddress($email);
			
			//$mail->AddCC('ciclano@site.net', 'Ciclano'); // Copia
			//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // Cópia Oculta
			// Define os dados técnicos da Mensagem
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->IsHTML(true); // Define que o e-mail será enviado como HTML
			$mail->CharSet = 'UTF-8';
			//$mail->CharSet = 'iso-8859-1'; // Charset da mensagem (opcional)
			// Define a mensagem (Texto e Assunto)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$id_responsavel = $id_responsavel - 1; //codigo para enviar id corrigido//
			$mail->Subject  = "Cadastro efetuado com sucesso"; // Assunto da mensagem
			$mail->Body = "
						<p><b>Obrigado!</b></p>
						<p>Seu cadastro foi efetuado com sucesso no Sistema de Gerenciamento de Obras. <br >
						Seu id para login é ".$id_responsavel.".<br><br>

						Para melhor aproveitamento do software é necessario que finalize seu cadastro.<br />

						Att.<br />

						Equipe ControlSystem";
			$mail->AltBody = "Seu id para login é ".$id_responsavel." ALTBODY \r\n :)";
			// Define os anexos (opcional)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // Insere um anexo
			// Envia o e-mail
			$enviado = $mail->Send();
			// Limpa os destinatários e os anexos
			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
			// Exibe uma mensagem de resultado
			if ($enviado) {
			  echo "E-mail enviado com sucesso!";
			} else {
			  echo "Não foi possível enviar o e-mail.";
			  echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
			}
			
			
		    $redirect = "../index.php?cadastro=ok&nome=".$nome."&login=".$id_responsavel;

			header("location:$redirect");
			

		}else{			
			$redirect = "../index.php?#cadastro";
			header("location:$redirect");
		}
		
		?>  
					
			 
		