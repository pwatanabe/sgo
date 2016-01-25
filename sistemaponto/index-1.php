<?php
session_start();
include_once("../model/class_token.php");
// if(!isset($_SESSION['ac_lib_a_cp']) && $_SESSION['ac_lib_a_cp'] != true){
// 	if(!Token::validar($_POST['ToSPo'], $_POST['MaSPo'])){
// 		// header('location:../view/erro.php');
// 	}
// }
// Token::invalidar_token($_POST['ToSPo']); // invalida o token usado
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_empresa_bd.php");
include_once("../model/class_filial_bd.php");
include_once("../model/class_email.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");
include_once("../model/class_config.php");
include_once("../global.php");


?>

<html>

<head>
	<title>ControlPonto</title>
	<meta charset="UTF-8">
	<link rel="stylesheet" type="text/css" href="style.css">
	<script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
	<link href='http://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Wallpoet' rel='stylesheet' type='text/css'>
</head>

<script type="text/javascript">
	
	function validate(f){
      var erro = 0;
      var msg;
      for(i=0; i < f.length ; i++){
        if(f[i].name == "observacao"){
          if(f[i].value == ''){
            f[i].style.border = "1px solid #FF0000";
            msg = "Por favor! Preencha uma observação";
            erro++;
          }
        }
      }
      if(erro > 0){
        alert(msg);
        return false;
      }else{
        return true;  
      }
      
    }
	
	function verificaHora(){
		var texto;
		var data = new Date();
		var hora = data.getHours();
		var minuto = data.getMinutes();
		var segundo = data.getSeconds();
		<?php date_default_timezone_set('America/Sao_Paulo'); ?>
		var h = <?php echo date('H');?>;
		var m = <?php echo date('i');?>;
		var s = <?php echo date('s');?>;
		if(h != hora || (minuto > m+1 || minuto < m-1) ){
			alert("O horário deste computador está diferente do horario do servidor, por favor, atualize o horario para um melhor desempenho!\n Hora do servidor: "+h+":"+m);
		}
	}

	function getHoraServdor(){
		if(s>=59){
	   		s=-1;
	   		m=m+1;
			if(m>=60){
				m=00;
				h=h+1;
				if(h>=24){
					h=00;
				}
			}
		}
		s=s+1;

		if(h<=9){xh="0"+h;}else{xh=h;}
		if(m<=9){xm="0"+m;}else{xm=m;}
		if(s<=9){xs="0"+s;}else{xs=s;}
		// alert(xh+":"+ xm +":"+ xs);
		var hora = xh+":"+ xm +":"+ xs;
	}

	var h = <?php echo date('H');?>;
	var m = <?php echo date('i');?>;
	var s = <?php echo date('s');?>;

	function moveRelogio(){

		var data = new Date();

		var hora = data.getHours();
		var minuto = data.getMinutes();
		var segundo = data.getSeconds();
		
		if(hora<=9) hora = "0"+hora;
		if(minuto<=9) minuto = "0"+minuto;
		if(segundo<=9) segundo = "0"+segundo;

		var horaImp = hora+":"+minuto+":"+segundo;

		document.getElementById("txtRelogio").value = horaImp;
		setTimeout("moveRelogio()", 1000);

	}
	
	function del(tempo){
		//alert("apagado");

		document.getElementById("alerta").innerHTML='';
		document.getElementById("alerta").style.color="#070";
		
		setTimeout("del()",tempo);
		
	}
	function limCamp(){
		document.getElementById("nome").value = "";
		document.getElementById("pass").value = "";
	}
	function enabledNo(){
		document.getElementById("nome").disabled = true;
		document.getElementById("pass").disabled = true;
	}
	function enabledYes(){
		document.getElementById("nome").disabled = false;
		document.getElementById("pass").disabled = false;
	}
	function reload(){
		location.href = "index.php";

	}
	function exibe_error(){
		alert('chamou')
    	document.getElementById("back-popup").style.display = "block";
        document.getElementById("popup").style.display = "block";

    }
    function fecha_error(){
        document.getElementById("back-popup").style.display = "none";
        document.getElementById("popup").style.display = "none";
        // window.location='index.php';
    }
    // inicio mascaras
    function mascara(o,f){
          v_obj=o
          v_fun=f
        setTimeout("execmascara()",1)
    }
    function execmascara(){
        v_obj.value=v_fun(v_obj.value)
    }

    function mcpf(v){
       if(v.length >=15){  
         v = v.substring(0,(v.length - 1));
         return v;
       }
       v=v.replace(/\D/g,""); 
       v=v.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})/,"$1.$2.$3-$4");
       return v;
    }
    
    // window.onload = function(){
      
    //   document.getElementById("cpf").onkeypress = function(){ 
    //       mascara( this, mcpf );
    //   }
      
    // }
   // fim mascaras

   function maskCPF(){
   		document.getElementById("cpf").onkeypress = function(){ 
          mascara( this, mcpf );
        }
   }

	function desabilita(){
		
		document.getElementById('btn_entrar').disabled = true;
		document.getElementById('btn_entrar').value = "";
		document.getElementById('btn_entrar').className = "btn_aguarde";

		var formulario = document.getElementById('formulario_login');
		formulario.submit();
		
	}
	function habilita(){
		document.getElementById('btn_entrar').disabled = false;
		document.getElementById('btn_entrar').value = "Enviar";
	}

</script>


<style type="text/css">
	
</style>
<body onload="moveRelogio(), verificaHora(), maskCPF()">
	<?php 

		// inicia a tabela de horarios esquecidos, a tabela de horarios esquecidos controla quem registrou ou não registrou o ponto eletronico,
		// essa tabela mantem os registros sempre 10 dias a mais iniciando na data atual
		// esse metodo verifica se existe um registro faltando nessa tabela e atualiza
		Horarios::inicia_horarios_esquecidos();
		
	 ?>

	<div class="container">
		
		<div class="content">
			<div class="logo">
				<img src="../images/logo.png" width="400px">
			</div>
			<div class="date" style="margin-bottom: 5px">
				<span><?php echo date("d/m/Y"); ?></span>
			</div>
			<div class="time">
				<input type="text" id="txtRelogio" disabled name="relogio" size="10"> 
			</div>
			
			<div class="form_login">
				<?php include_once("../view/form_login.php"); ?>
			</div>
			
			<div class="alerta" id="alerta">
				<?php 
					//entra nesse if caso o funcionario esteja atrasado ou adiantado
					if(isset($_POST['table_obs'])){//gravar observação no banco
						$sql = new Sql();
						$conn = $sql->conn_bd();
						$g = new Glob();
						$horarios = new Horarios();
						$msgmail = '';
						

						$hora = $_POST['hora'];
						$data = $_POST['data'];
						$tipo = $_POST['tipo'];
						$id_funcionario = $_POST['id_func'];
						$observacao = $_POST['observacao'];
						$situacao_tempo = $_POST['situacao_tempo'];
						$atrasado_ou_adiantado = $_POST['atrasado_ou_adiantado'];
						$funcionario = new Funcionario();
						$funcionario = $funcionario->get_func_id($id_funcionario);

						$turno = new Turno();//instanciando um novo turno
						$turno = $turno->getTurnoById($funcionario->id_turno);

						$horario = new Horarios();
						// echo "<script>alert('adiantado');</script>";

						if($tipo != $_POST['tipo_ordem']){
							if($tipo == 1){
								$hora_login = $hora;
								$hora_turno = $turno->ini_exp;
								$situacao_tempo = '+'.$horario->dif_horario($hora_turno, $hora_login);
							}else if($tipo == 2){
								$hora_login = $hora;
								$hora_turno = $turno->ini_alm;
								$situacao_tempo = '+'.$horario->dif_horario($hora_turno, $hora_login);
							}else if($tipo == 3){
								$hora_login = $hora;
								$hora_turno = $turno->fim_alm;
								$situacao_tempo = '+'.$horario->dif_horario($hora_turno, $hora_login);
							}else{
								$hora_login = $hora;
								$hora_turno = $turno->fim_exp;
								$situacao_tempo = '+'.$horario->dif_horario($hora_turno, $hora_login);
							}
								
						}



						$horarios->cadHorario($hora, $data, $tipo, $id_funcionario, $observacao, $situacao_tempo);
						$horarios->insertHorarioBd();

						

						$empresa = new Empresa();
						$empresa = $empresa->get_empresa_by_id($funcionario->id_empresa);
						$msg = '';
						$posto_trabalho = new Filial();
						$posto_trabalho = $posto_trabalho->get_filial_id($funcionario->id_empresa_filial);

						$data = explode("-", $data);
						$data = $data[2]."/".$data[1]."/".$data[0];

						$email_send = new Email();

						$msgmail .= "<table><tr><td><b>Empresa: </b>".$empresa->nome_fantasia."</td><td><b>CNPJ: </b>".$empresa->cnpj."</td></tr>";
						
						if($posto_trabalho)
							$msgmail .= "<tr><td colspan='2'><b>Posto de trabalho: </b>".$posto_trabalho->nome."</td></tr>";
						$msgmail .= "<tr><td colspan='2'>";
						if($tipo == 1){
							$msgmail .= "Iniciando o expediente";
							$msg .= 'Você esta iniciando o expediente '.substr($situacao_tempo, 1);
							if($atrasado_ou_adiantado == 'atrasado'){
								$msg .= ' atrasado';
							}else{
								$msg .= ' adiantado';
							}
						}else if($tipo == 2){
							$msgmail .= "saindo para almoço";
							$msg .= 'Você esta iniciando o almoço '.substr($situacao_tempo, 1);
							if($atrasado_ou_adiantado == 'atrasado'){
								$msg .= ' atrasado';
							}else{
								$msg .= ' adiantado';
							}
						}else if($tipo == 3){
							$msgmail .= "Encerrando o almoço";
							$msg .= 'Você esta encerrando o almoço '.substr($situacao_tempo, 1);
							if($atrasado_ou_adiantado == 'atrasado'){
								$msg .= ' atrasado';
							}else{
								$msg .= ' adiantado';
							}
						}else{
							$msgmail .= "Encerrando o expediente";
							$msg .= 'Você esta encerrando o expediente '.substr($situacao_tempo, 1);
							if($atrasado_ou_adiantado == 'atrasado'){
								$msg .= ' atrasado';
							}else{
								$msg .= ' adiantado';
							}
						}
						$msgmail .= " às ".$hora." no dia ".$data."</td></tr>";
						$msgmail .= "<tr><td colspan='2'>".$msg."</td></tr>";
						$msgmail .= "</table>";
						
						if($email_send->enviar_email_func($funcionario->email, $msgmail) ){
							// echo "<script>alert('Sucesso ao enviar email');</script>";
							// if($tipo == 1){
							// 	echo  'Bom trabalho '.$funcionario->nome;
							// }else if($tipo == 2){
							// 	echo  'Bom almoço '.$funcionario->nome;
							// }else if($tipo == 3){
							// 	echo  'Bom trabalho '.$funcionario->nome;
							// }else{
							// 	echo  'Bom descanço '.$funcionario->nome;
							// }
						}else{
							echo "<script>alert('Erro ao enviar email para ".$funcionario->email."');</script>";
							if($funcionario->email == ''){
								// echo 'Erro ao enviar email<br />';
								// echo $funcionario->nome.' não possui um email cadastrado';
							}else{
								// echo 'Erro ao enviar email<br />';
							}

						}

						//echo '<script> alert("Gravar observação no banco"); </script>';
						// $query = "SELECT * FROM horarios WHERE id_funcionario = '%s' ORDER BY id desc";// pegando o ultimo horario inserido

						// $result = $g->tratar_query($query, $_POST['id_func']);

						// $row = mysql_fetch_array($result, MYSQL_ASSOC);

						// $text = $_POST['obs'];
						// $id_hor = $row['id'];
						// $query = "UPDATE horarios SET observacao_funcionario = '%s' WHERE id = '%s'"; 
						// $g->tratar_query($query, $text, $id_hor);

						// $sql->close_conn($conn);
						echo "<script>habilita()</script>";// habilita o botão enviar
						echo '<script> enabledYes();</script>';
					}
				 ?>


				<?php
					
					// $INTERVALO_MIN = 10;// tempo minimo entre um registro e outro
					
					if(isset($_POST['cpf']) && isset($_POST['pass'])){
						// echo "<script>desabilita()</script>";// desabilita o botão enviar para não ser possivel clicar duas vezes

						$cpf = $_POST["cpf"];
						// $id = $_POST["cpf"];
						$pass = $_POST["pass"];
						$situacao_tempo; // recebe o tempo de atraso ou de adiantamento
						$func = new Funcionario();
						$funcAux = new Funcionario();
						$atrasado = false; // se esta ou não atrasado
						$adiantado = false; // se esta ou não adiantado
						$tipo;
						
						if( $func->verifica_func($cpf, $pass) ) {  // verificando se senha e usuario correspondem
							// echo "<script>alert('verificou');</script>";
							$funcAux = $func->get_func_cpf($cpf);
							$config = new Config();
							$TEMP_LIMIT_ATRASO = $config->get_config("temp_limit_atraso", $funcAux->id_empresa);// tempo limite de atraso ou adiantamento aceito
							echo "<script>alert('$TEMP_LIMIT_ATRASO');</script>";
							$id = $funcAux->id;
							//verificar horarios
							$turno = new Turno();//instanciando um novo turno
							$turno = $turno->getTurnoById($funcAux->id_turno);

							$horarios = new Horarios();
							

							date_default_timezone_set('America/Sao_Paulo');
							$hora = date("H:i:s");
							$data = date("Y-m-d");
							/* 
							 1 = iniciou o expediente
							 
							 2 = saiu pro almoco
							 3 = encerrou o almoco

							 0 = encerrou o expediente
							 */
							$msg="";

							$email_send = new Email();
							
							$supervisor = new Funcionario();
							if($funcAux->id_supervisor != 0)
								$supervisor = $supervisor->get_func_id($funcAux->id_supervisor);
							
							$switch = $horarios->getTipoUltimoHorarioFunc($id, $data);//pega o valor do ultimo horario registrado



							if($turno->sem_hor_almoco == 1 && $switch == 1){// verifica se não possui horario de almoco e se o ultimo horario registrado é igual a 1 <span>iniciando expediente</span>)
								$switch = 3; //switch recebe 3 para pular o horario de almoço
							}
							switch($switch){
								case 0:
																	
										$tipo = 1;//iniciou o expediente
									
										/* inicio verificações de horario */
									    $hora_login = $hora;
										$hora_turno = $turno->ini_exp;

										// echo "<script>alert('antes');</script>";
										 $situacao_tempo = '';
										 $msg_supervisor = '';
									     if($horarios->verifica_atraso($hora_turno, $hora_login)){ // hora de entrada determinada para o funcionario for menor ou igual a hora que ele está entrando
									  		// echo "<script>alert('entrou');</script>";
									  		
									     	$atraso = '';
									     	if($horarios->get_hora_atraso($hora_turno, $hora_login) != null){
									     		$atraso .= $horarios->get_hora_atraso($hora_turno, $hora_login)."h";
									     	}
									     	if($horarios->get_min_atraso($hora_turno, $hora_login) != null){
									     		$atraso .= $horarios->get_min_atraso($hora_turno, $hora_login)."m";
									     	}

									     	$situacao_tempo .= "+".$atraso;// tempo que chegou atrasado

									     	if($horarios->get_hora_atraso($hora_turno, $hora_login) > 0 || 
									     		$horarios->get_min_atraso($hora_turno, $hora_login) > $TEMP_LIMIT_ATRASO){
									     		
									     		$atrasado_ou_adiantado = 'atrasado';
									     		$msg_supervisor .= "<table>";
									     	    $msg_supervisor .= "<tr><td>Funcionário ".$funcAux->nome." está iniciando o expediente ".$atraso." atrasado</td></tr>";
									     	    $msg_supervisor .= "</table>";

									     	    if($supervisor)
										     		if($email_send->enviar_email_super($supervisor->email_empresa, $msg_supervisor)){
										     			echo 'sucesso';
										     		}else{
										     			echo 'falha ao enviar email para o supervisor';
										     		}


									     		echo '<script> del(600000);</script>';
									     		
									     		//msg é exibida no view/table_obs.php
									     		$msg .= "Você está iniciando o expediente $atraso atrasado<br />";
									     		$msg .= "<span>Escolha uma das opções abaixo referente a sua ação atual<br /></span>";
									     		if(strtotime($turno->ini_exp) < strtotime($hora_login)){
									     			$msg .= "<input type='radio' value='1' id='tipo' name='tipo' checked><span>Iniciando expediente</span>";
									     		}
									     		if(strtotime($turno->ini_alm) < strtotime($hora_login)){
									     			$msg .= "<input type='radio' value='2' id='tipo' name='tipo'><span>Saindo para almoço</span>";
									     		}
									     		if(strtotime($turno->fim_alm) < strtotime($hora_login)){
									     			$msg .= "<input type='radio' value='3' id='tipo' name='tipo'><span>Encerrando do almoço</span>";
									     		}
									     		if(strtotime($turno->fim_exp) < strtotime($hora_login)){
									     			$msg .= "<input type='radio' value='0' id='tipo' name='tipo'><span>Encerrando expediente</span>";
									     		}
									     		$msg_email = "Você está iniciando o expediente $atraso atrasado";
									     		$atrasado = true;
									     	}else{
									     		echo '<script> del(10000); </script>';
									     	}
									     	
									     }else if ( $horarios->verifica_antecedencia($hora_turno, $hora_login) ){//caso adiantado
									     	$hora_adi = $horarios->get_hora_ant($hora_turno, $hora_login)."h".$horarios->get_minutos_ant($hora_turno, $hora_login)."m";
									     	$situacao_tempo .= "-".$hora_adi; // tempo que chegou adiantado
									     	
									     	if($horarios->get_hora_ant($hora_turno, $hora_login) > 0 || 
									     		$horarios->get_minutos_ant($hora_turno, $hora_login) > $TEMP_LIMIT_ATRASO){
									     		// echo '<script>alert("Atenção! Você está a mais de 10 minutos atrasado");</script>';
									     		$atrasado_ou_adiantado = 'adiantado';
									     		$msg_supervisor .= "<table>";
									     	    $msg_supervisor .= "<tr><td>Funcionário ".$funcAux->nome." está iniciando o expediente ".$hora_adi." adiantado</td></tr>";
									     	    $msg_supervisor .= "</table>";

									     	    if($supervisor)
										     		if($email_send->enviar_email_super($supervisor->email_empresa, $msg_supervisor)){
										     			echo 'sucesso';
										     		}else{
										     			echo 'falha ao enviar email para o supervisor';
										     		}

									     		echo '<script> del(600000);</script>';
									     		//msg é exibida no view/table_obs.php
									     		$msg .= "Você está iniciando o expediente $hora_adi adiantado <input type='hidden' value='1' id='tipo' name='tipo'>";
									     		$msg_email = "Você está iniciando o expediente $hora_adi adiantado";
									     		$adiantado = true;
									     	}else{
									     		echo '<script> del(10000);</script>';
									     	}
									     }

									     // $tempo_con = mktime(date('H', $hora_turno) - date('H', $hora_login), date('i', $hora_turno) - date('i', $hora_login), date('s', $hora_turno) - date('s', $hora_login));

									     // $diferenca = date('H:i:s', $tempo_con);

									// if($hora != $turno->ini_exp){
										// $msg .= "Voce está entrando com $diferenca de diferença";
									// }
									/* fim verificações de horario */
								break;
								case 1:
									$tipo=2;//saiu pro almoço
									/* inicio verificações de horario */
									     $hora_login = $hora;
									     $hora_turno = $turno->ini_alm;
									     // $
									     // if(1 == 1){
									     // 	echo "<script>alert('".$switch."');</script>";
									     // }else
									     $situacao_tempo = '';
									     $msg_supervisor = '';
									     if($horarios->verifica_atraso($hora_turno, $hora_login)){// hora de entrada determinada para o funcionario for menor ou igual a hora que ele está entrando
									  		// echo '<script> alert("entrou verifica atraso"); </script>';
									     	
									     	$atraso = '';
									     	if($horarios->get_hora_atraso($hora_turno, $hora_login) != null){
									     		$atraso .= $horarios->get_hora_atraso($hora_turno, $hora_login)."h";
									     	}
									     	if($horarios->get_min_atraso($hora_turno, $hora_login) != null){
									     		$atraso .= $horarios->get_min_atraso($hora_turno, $hora_login)."m";
									     	}

									     	$situacao_tempo .= "+".$atraso;// tempo que chegou atrasado
									     	// $msg .= "hora: ". $horarios->get_hora_atraso($hora_turno, $hora_login)." Minuto: ".$horarios->get_min_atraso($hora_turno, $hora_login);
									     	if($horarios->get_hora_atraso($hora_turno, $hora_login) > 0 || $horarios->get_min_atraso($hora_turno, $hora_login) > $TEMP_LIMIT_ATRASO){
									     		// echo '<script>alert("Atenção! Você está a mais de 10 minutos atrasado");</script>';
									     		$atrasado_ou_adiantado = 'atrasado';
									     		$msg_supervisor .= "<table>";
									     	    $msg_supervisor .= "<tr><td>Funcionário ".$funcAux->nome." está saindo para o almoço ".$atraso." atrasado</td></tr>";
									     	    $msg_supervisor .= "</table>";

									     	    if($supervisor)
										     		if($email_send->enviar_email_super($supervisor->email_empresa, $msg_supervisor)){
										     			echo 'sucesso';
										     		}else{
										     			echo 'falha';
										     		}

									     		echo '<script> del(600000);</script>';
									     		
									     		//msg é exibida no view/table_obs.php
									     		$msg .= "Você está saindo para almoço $atraso atrasado</span><br />";
									     		$msg .= "<span>Escolha uma das opções abaixo referente a sua ação atual<br /></span>";
									     		if(strtotime($turno->ini_alm) < strtotime($hora_login)){
										     		$msg .= "<input type='radio' value='2' id='tipo' name='tipo' checked><span>Saindo para almoço</span>";
										     	}
										     	if(strtotime($turno->fim_alm) < strtotime($hora_login)){
										     		$msg .= "<input type='radio' value='3' id='tipo' name='tipo'><span>Encerrando do almoço</span>";
										     	}
										     	if(strtotime($turno->fim_exp) < strtotime($hora_login)){
										     		$msg .= "<input type='radio' value='0' id='tipo' name='tipo'><span>Encerrando expediente</span>";
										     	}
									     		$msg_email = "Você está saindo para almoço $atraso atrasado";
									     		$atrasado = true;
									     	}else{
									     		echo '<script> del(10000); </script>';
									     	}
									     	
									     	

									     }else if ( $horarios->verifica_antecedencia($hora_turno, $hora_login) ){//caso adiantado
									     	
									     	$hora_adi = $horarios->get_hora_ant($hora_turno, $hora_login)."h".$horarios->get_minutos_ant($hora_turno, $hora_login)."m";
									     	$situacao_tempo .= "-".$hora_adi; // tempo que chegou adiantado
									     	$msg_supervisor .= '';
									     	if($horarios->get_hora_ant($hora_turno, $hora_login) > 0 || 
									     		$horarios->get_minutos_ant($hora_turno, $hora_login) > $TEMP_LIMIT_ATRASO){
									     		// echo '<script>alert("Atenção! Você está a mais de 10 minutos atrasado");</script>';
									     		$atrasado_ou_adiantado = 'adiantado';
									     		$msg_supervisor .= "<table>";
									     	    $msg_supervisor .= "<tr><td>Funcionário ".$funcAux->nome." está saindo para almoço ".$hora_adi." adiantado</td></tr>";
									     	    $msg_supervisor .= "</table>";

									     	    if($supervisor)
										     		if($email_send->enviar_email_super($supervisor->email_empresa, $msg_supervisor)){
										     			echo 'sucesso';
										     		}else{
										     			echo 'falha ao enviar email para o supervisor';
										     		}

									     		echo '<script> del(600000);</script>';
									     		
									     		$msg .= "Você está saindo para almoço $hora_adi adiantado <input type='hidden' value='2' id='tipo' name='tipo'>";
									     		$msg_email = "Você está saindo para almoço $hora_adi adiantado";
									     		$adiantado = true;
									     	}else{
									     		echo '<script> del(10000);</script>';
									     	}

									     	

									     }
									/* fim verificações de horario */
								break;
								case 2:
									$tipo=3;//voltou do almoço
									$hora_login = $hora;
									$hora_turno = $turno->fim_alm;
									/* inicio verificações de horario */
									$situacao_tempo = '';
									$msg_supervisor = '';
									if($horarios->verifica_atraso($hora_turno, $hora_login)){// hora de entrada determinada para o funcionario for menor ou igual a hora que ele está entrando
									  
									     	$atraso = '';
									     	if($horarios->get_hora_atraso($hora_turno, $hora_login) != null){
									     		$atraso .= $horarios->get_hora_atraso($hora_turno, $hora_login)."h";
									     	}
									     	if($horarios->get_min_atraso($hora_turno, $hora_login) != null){
									     		$atraso .= $horarios->get_min_atraso($hora_turno, $hora_login)."m";
									     	}

									     	$situacao_tempo .= "+".$atraso;// tempo que chegou atrasado

									     	if($horarios->get_hora_atraso($hora_turno, $hora_login) > 0 || 
									     		$horarios->get_min_atraso($hora_turno, $hora_login) > $TEMP_LIMIT_ATRASO){
									     		// echo '<script>alert("Atenção! Você está a mais de 10 minutos atrasado");</script>';
									     		$atrasado_ou_adiantado = 'atrasado';
									     		$msg_supervisor .= "<table>";
									     	    $msg_supervisor .= "<tr><td>Funcionário ".$funcAux->nome." está voltando do almoço ".$atraso." atrasado</td></tr>";
									     	    $msg_supervisor .= "</table>";

										     	if($supervisor)
										     		if($email_send->enviar_email_super($supervisor->email_empresa, $msg_supervisor)){
										     			echo 'sucesso';
										     		}else{
										     			echo 'falha';
										     		}


									     	    echo '<script> del(600000);</script>';
									     		
									     		//msg é exibida no view/table_obs.php
									     		$msg .= "Você está encerrando o almoço $atraso atrasado<br />";
									     		$msg .= "<span>Escolha uma das opções abaixo referente a sua ação atual<br /></span>";
									     		if(strtotime($turno->fim_alm) < strtotime($hora_login)){
										     		$msg .= "<input type='radio' value='3' id='tipo' name='tipo' checked><span>Encerrando do almoço</span>";
										     	}
										     	if(strtotime($turno->fim_exp) < strtotime($hora_login)){
										     		$msg .= "<input type='radio' value='0' id='tipo' name='tipo'><span>Encerrando expediente</span>";
										     	}
									     		$msg_email = "Você está encerrando o almoço $atraso atrasado";
									     		$atrasado = true;
									     	}else{
									     		echo '<script> del(10000);</script>';
									     	}
									     	
									     }else if ( $horarios->verifica_antecedencia($hora_turno, $hora_login) ){//caso adiantado
									     	
									     	$hora_adi = $horarios->get_hora_ant($hora_turno, $hora_login)."h".$horarios->get_minutos_ant($hora_turno, $hora_login)."m";
									     	$situacao_tempo .= "-".$hora_adi; // tempo que chegou adiantado

									     	
									     	if($horarios->get_hora_ant($hora_turno, $hora_login) > 0 || 
									     		$horarios->get_minutos_ant($hora_turno, $hora_login) > $TEMP_LIMIT_ATRASO){
									     		// echo '<script>alert("Atenção! Você está a mais de 10 minutos atrasado");</script>';
									     		$atrasado_ou_adiantado = 'adiantado';
									     		$msg_supervisor .= "<table>";
									     	    $msg_supervisor .= "<tr><td>Funcionário ".$funcAux->nome." está encerrando o almoço ".$hora_adi." adiantado</td></tr>";
									     	    $msg_supervisor .= "</table>";

									     	    if($supervisor)
										     		if($email_send->enviar_email_super($supervisor->email_empresa, $msg_supervisor)){
										     			echo 'sucesso';
										     		}else{
										     			echo 'falha';
										     		}

									     		echo '<script> del(600000);</script>';
									     		
									     		$msg .= "Você está encerrando o almoço $hora_adi adiantado <input type='hidden' value='3' id='tipo' name='tipo'>";
									     		$msg_email = "Você está encerrando o almoço $hora_adi adiantado";
									     		$adiantado = true;
									     	}else{
									     		echo '<script> del(10000);</script>';
									     	}


									     }
									/* fim verificações de horario */

								break;
								case 3:
									$tipo=0;//encerrou o expediente
									$hora_login = $hora;
									$hora_turno = $turno->fim_exp;
									/* inicio verificações de horario */
									$situacao_tempo = '';
									$msg_supervisor = '';
									   if($horarios->verifica_atraso($hora_turno, $hora_login)){// hora de entrada determinada para o funcionario for menor ou igual a hora que ele está entrando
									  	echo "<script>alert('entrou aqui');</script>";
									     	$atraso = '';
									     	if($horarios->get_hora_atraso($hora_turno, $hora_login) != null){
									     		$atraso .= $horarios->get_hora_atraso($hora_turno, $hora_login)."h";
									     	}
									     	if($horarios->get_min_atraso($hora_turno, $hora_login) != null){
									     		$atraso .= $horarios->get_min_atraso($hora_turno, $hora_login)."m";
									     	}


									     	$situacao_tempo .= "+".$atraso;// tempo que chegou atrasado

									     	if($horarios->get_hora_atraso($hora_turno, $hora_login) > 0 || 
									     		$horarios->get_min_atraso($hora_turno, $hora_login) > $TEMP_LIMIT_ATRASO){
									     		// echo '<script>alert("Atenção! Você está a mais de 10 minutos atrasado");</script>';
									     		
									     		$atrasado_ou_adiantado = 'atrasado';
									     		$msg_supervisor .= "<table>";
									     	    $msg_supervisor .= "<tr><td>Funcionário ".$funcAux->nome." está encerrando o expediente ".$atraso." atrasado</td></tr>";
									     	    $msg_supervisor .= "</table>";

									     	    if($supervisor)
										     		if($email_send->enviar_email_super($supervisor->email_empresa, $msg_supervisor)){
										     			echo 'sucesso';
										     		}else{
										     			echo 'falha';
										     		}

									     		echo '<script> del(600000);</script>';
										     	

										     	$msg .= "Você está encerrando o expediente $atraso atrasado<br />";
										     	$msg .= "<input type='hidden' value='0' id='tipo' name='tipo'>";
										     	$msg_email = "Você está encerrando o expediente $atraso atrasado";
										     	$atrasado = true;
									     	}else{
									     		echo '<script> del(10000);</script>';
									     	}
									     	
									     	

									    }else if ( $horarios->verifica_antecedencia($hora_turno, $hora_login) ){ //caso adiantado
									     	// caso não tenha hora ou minuto não exibe nada
									     	echo "<script>alert('entrou aqui 2');</script>";
									     	$hora_ant = $horarios->get_hora_ant($hora_turno, $hora_login); // pega hora antecedencia
									     	$min_ant = $horarios->get_minutos_ant($hora_turno, $hora_login); // pega minuto antecedencia

									     	$hora_adi = '';
									     	if($hora_ant){
									     		$hora_adi .= $hora_ant .= "h";
									     	}
									     	if($min_ant){
									     		$hora_adi .= $min_ant.'m';
									     	}

									     	// $hora_adi = $hora_ant.$min_ant;
									     	//____________________________________________

									     	$situacao_tempo .= "-".$hora_adi; // tempo que chegou adiantado
									     	
									     	if($horarios->get_hora_ant($hora_turno, $hora_login) > 0 || 
									     		$horarios->get_minutos_ant($hora_turno, $hora_login) > $TEMP_LIMIT_ATRASO){
									     		// echo '<script>alert("Atenção! Você está a mais de 10 minutos atrasado");</script>';
									     		$atrasado_ou_adiantado = 'adiantado';
									     		$msg_supervisor .= "<table>";
									     	    $msg_supervisor .= "<tr><td>Funcionário ".$funcAux->nome." está encerrando o expediente ".$hora_adi." adiantado</td></tr>";
									     	    $msg_supervisor .= "</table>";

									     	    if($supervisor)
										     		if($email_send->enviar_email_super($supervisor->email_empresa, $msg_supervisor)){
										     			echo 'sucesso';
										     		}else{
										     			echo 'falha';
										     		}

									     		echo '<script> del(600000);</script>';
									     		//msg é exibida no view/table_obs.php
									     		$msg .= "Você está encerrando o expediente $hora_adi adiantado <input type='hidden' value='0' id='tipo' name='tipo'>";
									     		$msg_email = "Você está encerrando o expediente $hora_adi adiantado";
									     		$adiantado = true;
									     	}else{
									     		echo '<script> del(10000);</script>';
									     	}


									     }
									/* fim verificações de horario */
								break;
								default:
									$tipo=1;//a primeira vez que ele usa o ponto é de manhã
								break;
							}
							
							$id_funcionario = $id;
							
							$data = date("Y-m-d");
							
							if($atrasado || $adiantado){//caso atrasado ou adiantado

								include_once("../view/table_obs.php");

							}else{// caso esteja no horario

								$email_send = new Email();
								$observacao = '';

								$horarios->cadHorario($hora, $data, $tipo, $id_funcionario, $observacao, $situacao_tempo);
								$horarios->insertHorarioBd();

								$empresa = new Empresa();
								$empresa = $empresa->get_empresa_by_id($funcAux->id_empresa);

								$posto_trabalho = new Filial();
								$posto_trabalho = $posto_trabalho->get_filial_id($funcAux->id_empresa_filial);

								$data = explode("-", $data);
								$data = $data[2]."/".$data[1]."/".$data[0];

								$msgmail = "<table><tr><td><b>Empresa: </b>".$empresa->nome_fantasia."</td><td><b>CNPJ: </b>".$empresa->cnpj."</td></tr>";

								if($posto_trabalho)
									$msgmail .= "<tr><td colspan='2'><b>Posto de trabalho: </b>".$posto_trabalho->nome."</td></tr>";
								$msgmail .= "<tr><td colspan='2'>";
								if($tipo == 1){
									$msgmail .= "Iniciando o expediente";
								}else if($tipo == 2){
									$msgmail .= "saindo para almoço";
								}else if($tipo == 3){
									$msgmail .= "Encerrando o almoço";
								}else{
									$msgmail .= "Encerrando o expediente";

								}
								$msgmail .= " às ".$hora." no dia ".$data."</td></tr>";
								$msgmail .= "<tr><td colspan='2'>".$msg."</td></tr>";
								$msgmail .= "</table>";
								
								if($email_send->enviar_email_func($funcAux->email, $msgmail)){
									if($tipo == 1){
										echo  'Bom trabalho '.$funcAux->nome;
									}else if($tipo == 2){
										echo  'Bom almoço '.$funcAux->nome;
									}else if($tipo == 3){
										echo  'Bom trabalho '.$funcAux->nome;
									}else{
										echo  'Bom descanço '.$funcAux->nome;
									}
								}else{
									echo "<script>alert('Erro ao enviar email para ".$funcAux->email."');</script>";
								}
								echo "<script>habilita()</script>";// habilita o botão enviar
							}
							


							
							// if($turno->sem_hor_almoco == 1){//se não possui horario de almoço pula para o tipo 3 
							// 	$tipo = 3;
							// }
							// $funcionario = new Funcionario();
							// $funcionario = $funcionario->get_func_id($id_funcionario);
							
							// $empresa = new Empresa();
							// $empresa = $empresa->get_empresa_by_id($funcAux->id_empresa);

							// $posto_trabalho = new Filial();
							// $posto_trabalho = $posto_trabalho->get_filial_id($funcAux->id_empresa_filial);

							// $data = explode("-", $data);
							// $data = $data[2]."/".$data[1]."/".$data[0];

							// $email_send = new Email();

							// if($tipo == 1){
							// 	// echo 'BOM TRABALHO '. strtoupper($funcAux->nome) .'<br />';
							// 	$msgmail .= "<table><tr><td><b>Empresa: </b>".$empresa->nome_fantasia."</td><td><b>CNPJ: </b>".$empresa->cnpj."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'><b>Posto de trabalho: </b>".$posto_trabalho->nome."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'>Iniciando o expediente às ".$hora." no dia ".$data."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'>".$msg."</td></tr>";
							// 	$msgmail .= "</table>";
								
							// 	if($email_send->enviar_email_func($funcAux->email, $msgmail) ){
							// 		// echo "Sucesso";
							// 	}else{
							// 		// echo "falha";
							// 	}

								
							// }else if($tipo == 2){
							// 	// echo 'BOM ALMOÇO '. strtoupper($funcAux->nome) .'<br />';
							// 	$msgmail .= "<table><tr><td><b>Empresa: </b>".$empresa->nome_fantasia."</td><td><b>CNPJ: </b>".$empresa->cnpj."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'><b>Posto de trabalho: </b>".$posto_trabalho->nome."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'>saindo para almoço às ".$hora." no dia ".$data."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'>".$msg."</td></tr>";
							// 	$msgmail .= "</table>";
								
							// 	if($email_send->enviar_email_func($funcAux->email, $msgmail) ){
							// 		// echo "Sucesso";
							// 	}else{
							// 		// echo "falha";
							// 	}

							// 	// echo $msg."<br />";
							// }else if($tipo == 3){
							// 	// echo 'BOM TRABALHO '. strtoupper($funcAux->nome) .'<br />';
							// 	$msgmail .= "<table><tr><td><b>Empresa: </b>".$empresa->nome_fantasia."</td><td><b>CNPJ: </b>".$empresa->cnpj."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'><b>Posto de trabalho: </b>".$posto_trabalho->nome."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'>Encerrando o almoço às ".$hora." no dia ".$data."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'>".$msg."</td></tr>";
							// 	$msgmail .= "</table>";
								
							// 	if($email_send->enviar_email_func($funcAux->email, $msgmail) ){
							// 		// echo "Sucesso";
							// 	}else{
							// 		// echo "falha";
							// 	}

							// 	// echo '<div style="border: 1px solid; padding: 10px; width: 600px; background-color:rgba(255,255,255,0.7)">'. $msg. '</div>';
							// }else{
							// 	// echo 'BOM DESCANÇO '. strtoupper($funcAux->nome) .'<br />';
							// 	$msgmail .= "<table><tr><td><b>Empresa: </b>".$empresa->nome_fantasia."</td><td><b>CNPJ: </b>".$empresa->cnpj."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'><b>Posto de trabalho: </b>".$posto_trabalho->nome."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'>Encerrando o expediente às ".$hora." no dia ".$data."</td></tr>";
							// 	$msgmail .= "<tr><td colspan='2'>".$msg."</td></tr>";
							// 	$msgmail .= "</table>";
								
							// 	if($email_send->enviar_email_func($funcAux->email, $msgmail) ){
							// 		// echo "Sucesso";
							// 	}else{
							// 		// echo "falha";
							// 	}

							// 	// echo '<div style="border: 1px solid; padding: 10px; width: 600px; background-color:rgba(255,255,255,0.7)">'. $msg. '</div>';
							// }

						}else{
							echo "<script>habilita()</script>";// habilita o botão enviar
							echo '<script>del(5000); limCamp();</script>';
							echo 'Por favor digite corretamente seus dados';
						}
					}
				 ?>
			</div>
		</div>
		<!-- <div class="back-popup" id="back-popup" style="position:absolute; z-index: 1">
		</div>
		<div id="popup" class="popup">
		    <div style=" text-align: justify; float:left; margin-top:10px;">
		    	<div style="border: 1px solid; padding: 10px; width: 590px"><?php echo $msg ?></div>
		    	<div style="border: 1px solid; padding: 10px; text-align:center"><input type="button" onclick="fecha_error()" value='Gravar'></div>
		    </div>
		</div> -->
	</div>
	

</body>
</html>