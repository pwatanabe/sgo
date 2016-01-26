<?php
session_start();
if(!isset($_SESSION['logado']) && isset($_SESSION['logado']) && $_SESSION['logado'] == md5($_SESSION["id"])){
   header('location:../index.php');
}
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");

?>
<html>

<head>
   <title>Relatórios</title>
   <meta charset="UTF-8">
   <link rel="stylesheet" type="text/css" href="../administrator/styles/style.css">
   <link href='http://fonts.googleapis.com/css?family=Michroma' rel='stylesheet' type='text/css'>
   <link href='http://fonts.googleapis.com/css?family=Wallpoet' rel='stylesheet' type='text/css'>
</head>

<body>

 		<?php include_once("../view/topo.php"); ?>
         <div class="formulario" style="width:93%">
	            <div class="content-right" style="width:95%" >
			            	<?php
							//Definindo os dados para conexão e seleção da base de dados
							$sql = new Sql();
							$sql->conn_bd();
							 
							
							 if(isset($_GET['rel']) && $_GET['rel'] == 'funcionario'){
							 		$meses = array();
							 		$meses_qtd = 12;
							 		for($i=0; $i <= $meses_qtd; $i++){
							 			switch($i){
							 				case 0:
							 					$meses[$i] = "Janeiro";
							 				break;
							 				case 1:
							 					$meses[$i] = "Fevereiro";
							 				break;
							 				case 2:
							 					$meses[$i] = "Março";
							 				break;
							 				case 3:
							 					$meses[$i] = "Abril";
							 				break;
							 				case 4:
							 					$meses[$i] = "Maio";
							 				break;
							 				case 5:
							 					$meses[$i] = "Junho";
							 				break;
							 				case 6:
							 					$meses[$i] = "Julho";
							 				break;
							 				case 7:
							 					$meses[$i] = "Agosto";
							 				break;
							 				case 8:
							 					$meses[$i] = "Setembro";
							 				break;
							 				case 9:
							 					$meses[$i] = "Outubro";
							 				break;
							 				case 10:
							 					$meses[$i] = "Novembro";
							 				break;
							 				case 11:
							 					$meses[$i] = "Dezembro";
							 				break;
							 			}
							 		}
							 		
							 		?>
										<form method="POST" action="relatorio.php?rel=folhaponto">
											<input type="hidden" id="id_func" name="id_func" value="<?php echo $_GET['id']; ?>">
											<table>
												<tr>
													<td colspan="3">Selecione o Mês e o Ano:</td>
												</tr>
												<tr>
													<td><span>Mês: </span></td>
													<td>
														<select name="mes" id="mes">
															<?php 
																for($i=0; $i<count($meses); $i++){
																	echo '<option value="'.$i.'"">'.$meses[$i].'</option>';
																}
															 ?>
															
														</select>
													</td>
													<td>
														<select name="ano" id="ano">
															<?php 
															    $ano = date("Y");
																for($i=2015; $i <= $ano; $i++){
																	echo '<option value="'.$i.'">'.$i.'</option>';
																}
															 ?>
															
														</select>
													</td>
												</tr>
												<tr>
													<td colspan="2"><input type="submit" value="Gerar folha ponto"></td>
												</tr>
											</table>

										</form>

							 		<?php



							 }else{
									//Query simples para busca dos dados
									$busca = mysql_query("SELECT * FROM funcionario WHERE oculto = 0 ORDER BY id DESC") or die(mysql_error());
									//Verificação das linhas encontradas.
									if(mysql_num_rows($busca) > 0)
									{
										$cor_table = 0;
									?>
									 <div style="overflow-y:scroll; border: 1px solid#ababab">
										<table width="100%"  cellpadding="0" cellspacing="0" id="listacliente" style="text-align:center; font-size: 13px;">
											<tr>
												<td>ID</td><td>Nome</td><td>CPF</td><td>Email</td><td>Status</td><td></td>
											</tr>
											<?php
											while ($ver = mysql_fetch_assoc($busca)){
											?>
											 
											<?php if($cor_table%2 == 0){ ?> 
												<tr align="center" valign="middle" style="background-color:#bbb;" onMouseOver="style.backgroundColor='rgba(255,255,255,0.7)'" onMouseOut="style.backgroundColor='#bbb'">
											<?php }else{ ?>
												<tr align="center" valign="middle" style="background-color:#ccc;" onMouseOver="style.backgroundColor='rgba(255,255,255,0.7)'" onMouseOut="style.backgroundColor='#ccc'">
											<?php } ?>
												<td ><?php echo $ver['id']; ?></td>
												<td ><?php echo $ver['nome']; ?></td>
												<td ><?php echo $ver['cpf']; ?></td>
												<td ><?php echo $ver['email']; ?></td>
												<td ><?php $ver['oculto']=='1' ? print '<strong><span style="color:red">Oculto</span></strong>' : print '<strong><span style="color:#093">Ativo</span></strong>'; ?>
												</td>
												<td width="80">
													<a href="folha_ponto.php?rel=funcionario&id=<?php echo $ver['id']; ?>" title="Clique para selecionar"
													target="_self">Selecionar</a>
												</td>
											</tr>
											<?php 
												$cor_table++;
										}  ?>
										</table>
									 </div>
									<?php
									}else{
										//Caso não tenha registros a consulta, exibimos a mensagem.
										print 'Sem Registros';
										 
										}
									
							 }
									?>
	


            </div>
         
      </div>
   </div>
</body>
</html>









