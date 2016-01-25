<?php

session_start();

		// echo 'teste'. $_SESSION['login'];
		unset($_SESSION['id']);
		unset($_SESSION['pass']);
		$_SESSION['logado'] = false;
		unset($_SESSION['logado']);
		header('location:index');

 ?>