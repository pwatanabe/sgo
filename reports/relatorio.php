
<?php
//Definindo os dados para conexÃ£o e seleÃ§Ã£o da base de dados
include_once("../administrator/restrito.php");
include_once("../model/class_sql.php");
require_once('dompdf/dompdf_config.inc.php');
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_empresa_bd.php");
include_once("../model/class_endereco_bd.php");
include_once("../model/class_cbo_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_estado_bd.php");
include_once("../model/class_horarios_bd.php");

$sql = new Sql();
$sql->conn_bd(); 
//ConexÃ£o com o banco de dados com base nos dados fornecidos anteriormente.
function converter($data){
	$data = explode("-", $data);
	$return = $data[2]."/".$data[1]."/".$data[0];
	
	return $return;
}

function converterHora($total_segundos){
			$hora = sprintf("%02s",floor($total_segundos / (60*60)));
			$total_segundos = ($total_segundos % (60*60));
			
			$minuto = sprintf("%02s",floor ($total_segundos / 60 ));
			$total_segundos = ($total_segundos % 60);
			
			$hora_minuto = $hora.":".$minuto;
			return $hora_minuto;
}

function select_mes($i){
	switch($i){
		case 0:
			return "Janeiro";
		break;
		case 1:
			return "Fevereiro";
		break;
		case 2:
			return "Março";
		break;
		case 3:
			return "Abril";
		break;
		case 4:
			return "Maio";
		break;
		case 5:
			return "Junho";
		break;
		case 6:
			return "Julho";
		break;
		case 7:
			return "Agosto";
		break;
		case 8:
			return "Setembro";
		break;
		case 9:
			return "Outubro";
		break;
		case 10:
			return "Novembro";
		break;
		case 11:
			return "Dezembro";
		break;
	}

}

	if($_GET['rel'] == 'funcionario'){ 
		$id = isset($_GET['id']) ? (int)$_GET['id'] : false;
		 
		//Query simples para busca dos dados
		$busca = mysql_query("SELECT * FROM funcionario WHERE id = '$id'")or die(mysql_error());
		//VerificaÃ§Ã£o das linhas encontradas.

		$ver = mysql_fetch_array($busca);

		$query_endereco = mysql_query("SELECT * FROM endereco WHERE id = ".$ver['id_endereco']);
		$horario = mysql_query("SELECT * FROM turno WHERE id = ".$ver['id_turno']);

		$ver_end = mysql_fetch_array($query_endereco);
		$ver_turno = mysql_fetch_array($horario);

		?>
		<?php
		$html='
		<html>
		<style type="text/css">
		
		<head>
			<meta charset="UTF-8">
		</head>
			<body style="font-family:Arial">
				<div style="margin-left:20px; margin-top:20px;">
			';
			 	$situacao = ($ver['oculto'])?'Oculto':'Ativo';
				$html.='<table  border="1">
							<tr>
								<td><strong>Funcionário: </strong></td><td>'.$ver['nome'].'</td>
							</tr>
							<tr>
								<td><strong>CPF: </strong></td><td>'.$ver['cpf'].'</td>
							</tr>
							<tr>
								<td><strong>Data Nasc: </strong></td><td>'.$ver['data_nasc'].'</td>
							</tr>
							<tr>
							<td><b>Turno: </b></td><td style="padding-right:20px">'.$ver_turno['descricao'].'</td>
							</tr>
							<tr>
							<td><strong>Situação: </strong>  </td><td>'.$situacao.'</td>
						</tr>
				
					
					<tr><td style="font-size:18px" colspan="2"><b>Contato</b></td></tr>
					
						
						<tr>
							<td><strong>Endereço: </strong> </td><td>'.$ver_end['rua'].'</td>
						</tr>
						<tr>
							<td><strong>Número: </strong> </td><td>'.$ver_end['numero'].'</td>
						</tr>
						<tr>
							<td><strong>Email: </strong> </td><td>'.$ver['email'].'</td>
						</tr>
						
						<tr>
							<td><strong>Tel: </strong> </td><td>'.$ver['telefone'].'</td>
						</tr>
						
					
				</table>
				</div>
				<hr />
				<p>Viacampos - Todos os Direitos Reservados.<br></p>
			</body>
		</html>';
		?>
		<?php
		mysql_free_result($busca);
		 
		//Aqui nós chamamos a class do dompdf
		// require_once('dompdf/dompdf_config.inc.php');
		 
		//É fundamental definir o TIMEZONE de nossa região para que não tenhamos problemas com a geração.
		date_default_timezone_set('America/Sao_Paulo');
		 
		//Aqui eu estou decodificando o tipo de charset do documento, para evitar erros nos acentos das letras e etc.
		$html = utf8_decode($html);
		 
		//Instanciamos a class do dompdf para o processo
		$dompdf= new DOMPDF();
		 
		//Aqui nós damos um LOAD (carregamos) todos os nossos dados e formatações para geração do PDF
		$dompdf->load_html($html);
		 
		//Aqui nós damos início ao processo de exportação (renderizar)
		$dompdf->render();
		 
		//por final forçamos o download do documento, coloquei a nomenclatura com a data e mais um string no final.
		$dompdf->stream(date('d/m/Y').'_funcionario.pdf');
	}else if($_GET['rel'] == 'listafunc'){
		$sql = new Sql();
		$sql->conn_bd(); 
		$busca = mysql_query("SELECT * FROM funcionario WHERE id_empresa = '".$_SESSION['id_empresa']."' ORDER BY nome ASC")or die(mysql_error());
		
		?>
		
		<?php $html .= '
		<html>
		
		<head>
			
		</head>
		<body style="font-size:9px;">
			<div style="margin-left:20px; margin-top:20px;">
			<table border="1">
			<tr><td colspan="9" style="text-align:center"><b>LISTA DE FUNCIONÁRIOS</b></td></tr>
				<tr>
					<td ><b>ID</b></td><td><b>Nome</b></td><td><b>CPF</b></td><td><b>Data Nasc</b></td><td><b>Telefone</b></td><td><b>Email</b></td><td><b>Empresa</b></td><td><b>Cod. CBO</b></td><td style="padding-right:10px"><b>Situação</b></td>
				</tr>';
		?>
				<?php 
					while($ver = mysql_fetch_array($busca)){
						$empresa = mysql_query("SELECT * FROM filiais WHERE id = ".$ver['id_empresa']);
						$row_empresa = mysql_fetch_array($empresa);
						$cbo =  mysql_query("SELECT * FROM cbo WHERE id = ".$ver['id_cbo']);
						$row_cbo = mysql_fetch_array($cbo);
						$situacao = $ver['oculto']?"Oculto":"Ativo";
						$html  .= '<tr>';
						$html  .= '<td>'.$ver['id'].'</td><td>'.$ver['nome'].'</td><td>'.$ver['cpf'].'</td><td>'.$ver['data_nasc'].'</td><td>'.$ver['telefone'].'</td><td>'.$ver['email'].'</td><td>'.$row_empresa['nome'].'</td><td>'.$row_cbo['codigo'].'</td><td>'.$situacao.'</td>';
						$html  .= '</tr>';
					}
		$html  .= '</table>
			</div>
		</body>
		</html>';

		//Aqui nós chamamos a class do dompdf
		// require_once('dompdf/dompdf_config.inc.php');
		 
		//É fundamental definir o TIMEZONE de nossa região para que não tenhamos problemas com a geração.
		date_default_timezone_set('America/Sao_Paulo');
		 
		//Aqui eu estou decodificando o tipo de charset do documento, para evitar erros nos acentos das letras e etc.
		$html = utf8_decode($html);
		 
		//Instanciamos a class do dompdf para o processo
		$dompdf= new DOMPDF();
		 
		//Aqui nós damos um LOAD (carregamos) todos os nossos dados e formatações para geração do PDF
		$dompdf->load_html($html);
		 
		//Aqui nós damos início ao processo de exportação (renderizar)
		$dompdf->render();
		 
		//por final forçamos o download do documento, coloquei a nomenclatura com a data e mais um string no final.
		$dompdf->stream(date('d/m/Y').'_lista_funcionario.pdf');
	}else if($_GET['rel'] == 'folhaponto'){

		$id_func = $_POST['id_func'];


		if(($_POST['mes']+1) < 10){
			$mes = '0'.($_POST['mes']+1);
		}else{
			$mes = $_POST['mes']+1;
		}
		$ano = $_POST['ano'];
		$string_mes = select_mes($_POST['mes']);
		// $ano = $_POST['ano'];

		$data = $ano.'-'.$mes.'-01 00:00:00';//busca o registro do mes referente

		$funcionario = new Funcionario();
		$funcionario = $funcionario->get_func_historico_id($id_func, $data);
		$empresa = new Empresa();
		$empresa = $empresa->get_empresa_by_id($funcionario->id_empresa);
		$endereco = new Endereco();
		$endereco = $endereco->get_endereco($empresa->id_endereco);
		$cidade = new Cidade();
		$cidade = $cidade->get_city_by_id($endereco[0][2]);
		$estado = new Estado();
		$estado = $estado->get_estado_by_id($endereco[0][3]);
		$cbo = new Cbo();
		$cbo = $cbo->get_cbo_by_id($funcionario->id_cbo);
		$turno = new Turno();
		$turno = $turno->getTurnoById($funcionario->id_turno);
		$inicio_exp = '';
		$inicio_alm = '';
		$fim_alm = '';
		$fim_exp = '';
		$total_horas_normais = '';
		
		$html = '<html>
				<head>
				</head>
				<body>
					<div class="content" style="width:100%; style="text-align: center; padding:1px"; background-color:#dedede; font-family: Arial">
						<span style="margin: 0 auto; font-size: 18px;"><b>FOLHA DE PONTO INDIVIDUAL DE TRABALHO</b></span>
						<table border="1" style="font-size:9px; width:100%; font-family: Arial">
							<tr>
								<td colspan="4" style="padding:1px"><div style="font-size:6">EMPREGADOR / NOME - EMPRESA:</div><div><b>'.strtoupper($empresa->razao_social).'</b></div></td><td  style="padding:1px"><div style="font-size:6">CEI/CNPJ:</div><div><b>'.$empresa->cnpj.'</b></div></td>
							</tr>
							<tr>
								<td style="padding:1px"><div style="font-size:6">ENDEREÇO / LOGRADOURO:</div><div><b>'.$endereco[0][0].'</b></div></td><td  style="padding:1px"><div style="font-size:6">Nº:</div><div><b>'.$endereco[0][1].'</b></div></td><td  style="padding:1px"><div style="font-size:6">BAIRRO / DISTRO:</div><div><b>'.$endereco[0][4].'</b></div></td><td  style="padding:1px"><div style="font-size:6">CIDADE:</div><div><b>'.$cidade->nome.'</b></div></td><td  style="padding:1px"><div style="font-size:6">UF:</div><div><b>'.$estado->uf.'</b></div></td>
							</tr>
							<tr>
								<td colspan="3" style="padding:1px"><div style="font-size:6">EMPREGADO:</div><div><b>'.$funcionario->nome.'</b></div></td><td  style="padding:1px"><div style="font-size:6">CTPS / C.I. Nº e SÉRIE:</div><div><b>'.$funcionario->num_cart_trab.'</b></div></td><td style="padding:1px"><div style="font-size:6">DATA DE ADMISSÃO:</div><div><b>'.converter($funcionario->data_adm).'</b></div></td>
							</tr>
							<tr>
								<td colspan="3" style="padding:1px"><div style="font-size:6">FUNÇÃO:</div><div><b>'.$cbo->descricao.'</b></div></td><td  style="padding:1px"><div style="font-size:6">SALÁRIO BASE R$:</div><div><b>'.$funcionario->salario_base.'</b></div></td><td style="padding:1px"><div style="font-size:6">QUANTIDADE DE HORAS SEMANAIS:</div><div><b>'.$funcionario->qtd_horas_sem.'</b></div></td>
							</tr>
							<tr>
								<td colspan="2" style="padding:1px"><div style="font-size:6">HORÁRIO DE TRABALHO:</div><div><b>'.$turno->desc.'</b></div></td><td  style="padding:1px"><div style="font-size:6"></div><div></div></td><td style="padding:1px"><div style="font-size:6">MÊS:</div><div><b>'.strtoupper($string_mes).'</b></div></td><td><div style="font-size:6">ANO:</div><div><b>'.$ano.'</b></div></td>
							</tr>
						</table>

						<table border="1" style="font-size:8px; width:100%; text-align:center">
							<tr>
								<td rowspan="2" style="font-size:6px">DIAS</td>
								<td rowspan="2">ENTRADA MANHÃ</td>
								<td colspan="2">ALMOÇO</td>
								<td rowspan="2">SAÍDA<BR />TARDE</td>
								<td rowspan="2">TOTAL HS NORMAIS</td>
								<td colspan="2">EXTRAS</td>
								<td rowspan="2">TOTAL HS EXTRAS</td>
								<td rowspan="2">ASSINATURA OU VISTO DO(A) EMPREGADO(A)</td>
							</tr>
							<tr>
								<td>SAÍDA</td>
								<td>RETORNO</td>
								<td style="border-color:#fff;"></td>
								<td style="border-color:#fff;"></td>
								<td>ENTRADA</td>
								<td>SAÍDA</td>
	
							</tr>';
						$horario = new Horarios();
						$data = $ano.'-'.$mes; // Ex: 2015-07
						$horarios = $horario->get_horario_by_func_and_data($funcionario->id, $data);
						//0123-56-89
						$array = array();

						for($aux=0; $aux < count($horarios); $aux++){
							
							for($dia = 1; $dia <= 31; $dia++){
								if($dia < 10){
									$data = $ano.'-'.$mes.'-0'.$dia;
								}else{
									$data = $ano.'-'.$mes.'-'.$dia;
								}
								if($data == $horarios[$aux][2]){

									if($horarios[$aux][4] == 1){//entrando
										$array[$dia][1] = $horarios[$aux][3];
									}else if($horarios[$aux][4] == 2){//saindo almoco
										$array[$dia][2] = $horarios[$aux][3];
									}else if($horarios[$aux][4] == 3){//voltando almoco
										$array[$dia][3] = $horarios[$aux][3];
									}else{//encerrando expediente
										$array[$dia][0] = $horarios[$aux][3];
									}
									
								}
							}
						}

						$total_horas_am = '';
						$total_horas_pm = '';
						for($dia = 1; $dia <= 31; $dia++){
								if(isset($array[$dia][1]))
									$inicio_exp  = strtotime($array[$dia][1]);
								if(isset($array[$dia][2]))
 									$inicio_alm    = strtotime($array[$dia][2]);

 								if(isset($array[$dia][3]))
									$fim_alm = strtotime($array[$dia][3]);
								if(isset($array[$dia][0]))
									$fim_exp = strtotime($array[$dia][0]);

								$cont = 0;// se os tipos foram preenchidos cont++
								
								if(isset($inicio_alm) && $inicio_alm != '' && isset($inicio_exp) && $inicio_exp != ''){
									$total_horas_am = ($inicio_alm - $inicio_exp);
									$cont++;
								}
								if(isset($fim_exp) && $fim_exp != '' && isset($fim_alm) && $fim_alm != ''){
									$total_horas_pm = ($fim_exp - $fim_alm);	
									$cont++;
								}
								
								echo $total_horas_am.' : '.$total_horas_pm;;
								

								if($cont == 2){//se todos os horarios foram preenchidos
									$time = $total_horas_am + $total_horas_pm;
									$total_horas_normais = converterHora($time);
								}else{
									$total_horas_normais = '';
									
								}
								
								
								if(isset($array[$dia][1]))
									$inicio_exp = date('H:i:s', $inicio_exp);
								if(isset($array[$dia][2]))
									$inicio_alm = date('H:i:s', $inicio_alm);
								if(isset($array[$dia][3]))
									$fim_alm = date('H:i:s', $fim_alm);
								if(isset($array[$dia][0]))
									$fim_exp = date('H:i:s', $fim_exp);


								$html .= "<tr><td>".$dia.
										 "</td><td>".$inicio_exp.
										 "</td><td>".$inicio_alm.
										 "</td><td>".$fim_alm.
										 "</td><td>".$fim_exp.
										 "</td><td>". $total_horas_normais.
										 "</td><td> </td><td> </td><td> </td><td></td></tr>";
								$inicio_exp = '';
								$inicio_alm = '';
								$fim_alm = '';
								$fim_exp = '';
						}
						
					$html .= '
						<tr>
							<td colspan="5">TOTAIS</td><td></td><td></td><td></td><td></td><td></td>
						</tr>
						<tr>
							<td colspan="5" style="height:20px; padding-top:10px">VISTO GERENCIA</td><td colspan="5"></td>
						</tr>
						</table>
					</div>					
				</body>
			</html>';

	    // echo $html;

		date_default_timezone_set('America/Sao_Paulo');
		 
		//Aqui eu estou decodificando o tipo de charset do documento, para evitar erros nos acentos das letras e etc.
		$html = utf8_decode($html);
		 
		//Instanciamos a class do dompdf para o processo
		$dompdf= new DOMPDF();
		 
		//Aqui nós damos um LOAD (carregamos) todos os nossos dados e formatações para geração do PDF
		$dompdf->load_html($html);
		 
		//Aqui nós damos início ao processo de exportação (renderizar)
		$dompdf->render();
		 
		//por final forçamos o download do documento, coloquei a nomenclatura com a data e mais um string no final.
	    $nome_func = explode(" ", $funcionario->nome);
	    $dompdf->stream('FolhaPonto_'.$string_mes.'_'.$nome_func[0].'.pdf');

		
	}


?>