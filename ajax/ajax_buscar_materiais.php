<?php
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_material_bd.php");
include_once("../model/class_produto_bd.php");
include_once("../model/class_unidade_medida_bd.php");
include_once("../model/class_custo_regiao_bd.php");
include_once("../model/class_regiao_bd.php");


	$sql = new Sql();
	$sql->conn_bd();
	$acao = isset($_GET['acao']) ? $_GET['acao']:null;
	if(isset($_GET['id_produto'])){// pega e exibe os materiais desse produto
		$id_produto = $_GET['id_produto'];
		$produto = Produto::get_produto_id($id_produto);
		$materiais = Produto::get_materiais_produto($produto->id);
		$valor_total_produto = 0;
		if(!$materiais){
			echo 'Nenhum material cadastrado<br /><br /><input onclick="fechar()" type="button"  class="button" value="Concluir" >';
			return;   
		}
		echo '<div class="formulario" style="width:300px;">
           <table style="width:100%; text-align:center;" border="0">
              <tr><td colspan="3"><b>Materiais usados para '.$produto->nome.'</b></td></tr>';
              echo '<tr><td colspan="3"><div style="overflow-y:scroll; max-height:200px;">';
              echo '<table style="text-align:center">';
              echo '<tr><td><b><span>Nome</span></b></td><td><b><span>Quantidade</span></b></td><td><b><span>Custo por regiao</span></b></td></tr>';
              for($aux = 0; $aux < count($materiais); $aux++){
              	$id_material = explode(':', $materiais[$aux][1]);
              	
              	if($id_material[1] == 'm'){//buscar materiais

					$res = Material::get_material_id($id_material[0]);
					$uni = new Unidade_medida();
					$uni = $uni->get_unidade_medida_by_id($res->id_unidade_medida);
					if(isset($_SESSION['obra']['dados']['regioes']) && $_SESSION['obra']['dados']['regioes'] != 'no_sel'){
						
						$custo = Custo_regiao::get_valor($id_material[0], $_SESSION['obra']['dados']['regioes'], $_SESSION['id_empresa']);
						
						if($custo){
							$valor_total_produto = $valor_total_produto + ($materiais[$aux][2] * $custo);
							$custo = 'R$ '.number_format($custo, 2, ',', '.');

						}else{
							$custo = '<a href="add_material.php?backto=a_pr_o&regiao='.Regiao::get_cod_regiao_by_id($_SESSION['obra']['dados']['regioes']).'" onmouseover="info(\'pop'.$aux.'\')" onmouseout="fecharInfo(\'pop'.$aux.'\')"><span>Defina um valor custo</span></a>
								<div id="pop'.$aux.'" class="pop" style="display:none">
	                                  <div id="titulo'.$aux.'" class="title-info-config"><span>Informações</span></div>
	                                  <div id="content'.$aux.'" class="content-info">Clique para definir um valor custo para esse material nessa região</div>   
	                              </div>
							';
						}
					}else{
						$custo = ' <a href="add_obra?t=a_d_o" onmouseover="info(\'pop'.$aux.'\')" onmouseout="fecharInfo(\'pop'.$aux.'\')"><span>Nenhuma região de trabalho foi definida</span></a>
								<div id="pop'.$aux.'" class="pop" style="display:none">
	                                  <div id="titulo'.$aux.'" class="title-info-config"><span>Informações</span></div>
	                                  <div id="content'.$aux.'" class="content-info">Para exibir o valor custo definido para essa região, primeiro selecione uma cidade na aba <b>Dados da Obra</b></div>   
	                              </div>';
					}



				}else if($id_material[1] == 'p'){// buscar produtos
					$res = Produto::get_produto_id($id_material[0]);
				}
              	
              	if($aux%2==0)//  tabela zebrada
			               echo '<tr style="background-color:#ccc;">';
			    else
			               echo '<tr style="background-color:#ddd;">';

              	echo '<td ><span>'.$res->nome.'</span></td><td><span>'.$materiais[$aux][2].' '.( isset($uni) ?$uni->sigla:'').'</span></td><td >'.$custo.'</td></tr>';
              	
              }
              $margem_lucro = 50;
              echo '</table>';
              echo '</div></td></tr>';
        echo '<tr><td colspan="3"><input onclick="fechar()" type="button"  class="button" value="Concluir" ></td></tr>
            </table>

         </div>
         <table class="table_geral" style="width:100%; text-align:center; border: 1px solid #cdcdcd; padding: 5px;">
            	<tr><td colspan="4"><span><b>Mais Informações sobre '.$produto->nome.'</b></span></td></tr>
            	<tr><td><span><b>Altura</b></span></td><td><span><b>Comprimento</b></span></td><td><span><b>Largura</b></span></td><td title="Tempo estimado de conclusão"><span><b>Tempo</b></span></td></tr>
            	<tr><td><span>'.$produto->altura.'m</span></td><td><span>'.$produto->comprimento.'m</span></td><td><span>'.$produto->largura.'m</span></td><td><span>'.$produto->tempo_estimado_conclusao.' dias</span></td></tr>
            	<tr><td colspan="4" style="text-align:left"><span><b>Valor de custo total: </b>R$ '.number_format($valor_total_produto, 2, ',', '.').'</span></td></tr>
            	<tr>
            		<td colspan="4" style="text-align:left">
            			
            			<a href="add_obra?t=a_d_o" onmouseover="info(\'info_preco_venda_sugerido\')" onmouseout="fecharInfo(\'info_preco_venda_sugerido\')"><span><span><b>Valor de venda sugerido: </b>R$ '.number_format($valor_total_produto + $valor_total_produto * (($margem_lucro/100)), 2, ',', '.').'</span></span></a>
						<div id="info_preco_venda_sugerido" class="pop" style="display:none">
	                          <div id="tituloinfo_preco_venda_sugerido" class="title-info-config"><span>Informações</span></div>
	                          <div id="contentinfo_preco_venda_sugerido" class="content-info">Valor baseado em uma margem de lucro de '.$margem_lucro.'%. Você pode alterar a margem de lucro acessando <i>Configurações Gerais</i> clicando no menu <b>Configurações</b></div>   
	                    </div>
            		</td>
            	</tr>
         </table>';
	}else{
		$nome = $_GET['nome'];  //codigo do estado passado por parametro
		$tipo = $_GET['tipo'];
		if($tipo == 'm')//buscar materiais
			$res = Material::get_material_by_name($nome);
		else if($tipo == 'p')// buscar produtos
			$res = Produto::get_produto_by_name($nome);	
		?>

		<?php if($res){ ?>
			<select name="clientes" id="clientes" size='10' style="height: 100%; width: 100%" onDblClick="selecionaProduto(this.value,'<?php echo $acao ?>')">
			  <?php
			  	if($res) 
				   for($aux = 0; $aux < count($res); $aux++){
				   		if($tipo == 'm')//exibe materiais
				      		echo "<option value='m:".$res[$aux][0]."'>".$res[$aux][1]."</option>";
				      	else if($tipo == 'p')// exibe produtos
				     		echo "<option value='p:".$res[$aux][0]."'>".$res[$aux][1]."</option>";
				  	}
			?>
				
			</select>
	<?php } // fim if($res)
	}//fim else ?>