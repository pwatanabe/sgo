<?php

include_once("class_sql.php");
require_once("../phpmailer/phpmailer.class.php");

class Email{
	
	
	public function send($email_func, $msg, $subject){
		$mail = new PHPMailer();
		$mail->IsSMTP(); // @amats Define que a mensagem será SMTP
		$mail->Host = 'mail.controlsystem.com.br'; // @amats  Endereço do servidor SMTP
		$mail->SMTPAuth = true; // @amats  Usa autenticação SMTP? (opcional)
		$mail->Port = 587; // @amats Define a Porta
		$mail->Username = 'ponto@controlsystem.com.br'; // @amats Usuário do servidor SMTP
		$mail->Password = 'j3540771'; // @amats Senha do servidor SMTP

		$mail->From = "ponto@controlsystem.com.br"; // Seu e-mail***************************
		$mail->FromName = "SGO - Sistema de Gerenciamento de Obras"; // Seu nome

		$mail->AddAddress($email_func);

		$mail->IsHTML(true); // @amats Define que o e-mail será enviado como HTML
		$mail->CharSet = 'UTF-8'; // @amats Charset da mensagem (opcional)

		$textbody = nl2br( $msg );
		$mail->Subject  = $subject; // @amats Assunto da mensagem
		$mail->Body = '<hmtl>'.$msg.'</html>';
		$mail->AltBody = $msg;
		// @amats Define os anexos (opcional)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // @amats Insere um anexo
		// @amats Envia o e-mail
		
		return $mail->Send();
	}

	public function enviar_email_func($email_func, $msg){
		$mail = new PHPMailer();
		$mail->IsSMTP(); // @amats Define que a mensagem será SMTP
		$mail->Host = 'mail.controlsystem.com.br'; // @amats  Endereço do servidor SMTP
		$mail->SMTPAuth = true; // @amats  Usa autenticação SMTP? (opcional)
		$mail->Port = 587; // @amats Define a Porta
		$mail->Username = 'ponto@controlsystem.com.br'; // @amats Usuário do servidor SMTP
		$mail->Password = 'j3540771'; // @amats Senha do servidor SMTP

		$mail->From = "ponto@controlsystem.com.br"; // Seu e-mail***************************
		$mail->FromName = "ControlPonto"; // Seu nome

		$mail->AddAddress($email_func);

		$mail->IsHTML(true); // @amats Define que o e-mail será enviado como HTML
		$mail->CharSet = 'UTF-8'; // @amats Charset da mensagem (opcional)

		$textbody = nl2br( $msg );
		$mail->Subject  = "Confirmação de horário - Controlponto"; // @amats Assunto da mensagem
		$mail->Body = '<hmtl>'.$msg.'</html>';
		$mail->AltBody = $msg;
		// @amats Define os anexos (opcional)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // @amats Insere um anexo
		// @amats Envia o e-mail
		
		return $mail->Send();
	}
	public function enviar_email_super($email_super, $msg){
		$mail = new PHPMailer();
		$mail->IsSMTP(); // @amats Define que a mensagem será SMTP
		$mail->Host = 'mail.controlsystem.com.br'; // @amats  Endereço do servidor SMTP
		$mail->SMTPAuth = true; // @amats  Usa autenticação SMTP? (opcional)
		$mail->Port = 587; // @amats Define a Porta
		$mail->Username = 'ponto@controlsystem.com.br'; // @amats Usuário do servidor SMTP
		$mail->Password = 'j3540771'; // @amats Senha do servidor SMTP

		$mail->From = "ponto@controlsystem.com.br"; // Seu e-mail***************************
		$mail->FromName = "ControlPonto"; // Seu nome

		$mail->AddAddress($email_super);

		$mail->IsHTML(true); // @amats Define que o e-mail será enviado como HTML
		$mail->CharSet = 'UTF-8'; // @amats Charset da mensagem (opcional)

		$textbody = nl2br( $msg );
		$mail->Subject  = "Confirmação de horário - Controlponto"; // @amats Assunto da mensagem
		$mail->Body = '<hmtl>'.$msg.'</html>';
		$mail->AltBody = $msg;
		// @amats Define os anexos (opcional)
		// =-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=-=
		//$mail->AddAttachment("c:/temp/documento.pdf", "novo_nome.pdf");  // @amats Insere um anexo
		// @amats Envia o e-mail
		
		return $mail->Send();
	}
	
	
}

 ?>
