<html>

	<script language="JavaScript"> 
  		// @amats Função para fechar a janela
  		function closeWindow(){
  			alert("Erro reportado com sucesso!");
    		window.close();
 		}
	</script>
	<head>
	</head>
	<body onLoad="closeWindow()">
		<?php
			//@amats Enviar Email
			//@amats Classe para envio de email
			//@amats Email
			// error_reporting (E_ALL);
		 	// @amats Inclui o arquivo class.phpmailer.php localizado na pasta: /var/www/openemr/library/classes/class.phpmailer.php
			// @amats Alterar esse endereço
			require_once("../phpmailer/phpmailer.class.php");
			// @amats Inicia a classe PHPMailer
			$mail = new PHPMailer();
			//@amats Define os dados do servidor e tipo de conexão
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->IsSMTP(); // @amats Define que a mensagem será SMTP
			$mail->Host = 'mail.controlsystem.com.br'; // @amats  Endereço do servidor SMTP
			$mail->SMTPAuth = true; // @amats  Usa autenticação SMTP? (opcional)
			$mail->Port = 587; // @amats Define a Porta
			$mail->Username = 'andre@controlsystem.com.br'; // @amats Usuário do servidor SMTP
			$mail->Password = 'j3540771'; // @amats Senha do servidor SMTP
			// @amats Define o remetente
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->From = "andre@controlsystem.com.br"; // Seu e-mail
			$mail->FromName = "SGO - Sistema de Gerenciamento de Obras"; // Seu nome
			// @amats Define os destinatário(s)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->AddAddress('andre@controlsystem.com.br');
			$mail->AddAddress('andre_matos13@hotmail.com');
			$mail->AddAddress('_lucasoares@outlook.com');
			//$mail->AddCC('ciclano@site.net', 'Ciclano'); // @amats Copias
			//$mail->AddBCC('fulano@dominio.com.br', 'Fulano da Silva'); // @amats  Cópias Ocultas
			// @amats Define os dados técnicos da Mensagem
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->IsHTML(true); // @amats Define que o e-mail será enviado como HTML
			$mail->CharSet = 'UTF-8'; // @amats Charset da mensagem (opcional)
			// @amats Define a mensagem (Texto e Assunto)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			$mail->Subject  = "Mensagem de Erro SGO"; // @amats Assunto da mensagem
			$mail->Body = '<hmtl>
								<b>Página: </b><br />' .$_GET['pag']. 
								'<br /><br />
								<b>Descrição: </b><br />' .$_GET['descricao'].
								'<br /><br /><b>Data/Hora registro: </b>' .Date('d/m/Y h:m:s').
						  '</html>';
			$mail->AltBody = $_POST['descricao'];
			// @amats Define os anexos (opcional)
			// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
			//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // @amats Insere um anexo
			// @amats Envia o e-mail
		
			$enviado = $mail->Send();
			
			// @amats Limpa os destinatários e os anexos
			$mail->ClearAllRecipients();
			$mail->ClearAttachments();
			// @amats Exibe uma mensagem de resultado
			if ($enviado) {
				// @amats Chama a função que exibe a mensagem e fecha a janela
				closeWindow();
			} else {
				echo "Não foi possível enviar o e-mail.";
				echo "<b>Informações do erro:</b> " . $mail->ErrorInfo;
			} 
		?>
	</body>

</html>