<div class="formulario" style="width:430px;">
	<?php if($_GET['tipo'] == 1){ ?>
		<form method="POST">
			<table style="width:100%">
				<tr>
					<td><span>Funcionario: </span></td>
					<td>
						<input type="text" id="nome_search" name="nome_search">
					</td>
					<td>
						<input type="button" class="button" value="Buscar" onclick="buscar_funcionarios(0)">
				    </td>
			    </tr>
			</table>
					
					
		</form>
	<?php }else if($_GET['tipo'] == 2){ ?>
		<form method="POST">
			<div  style="float:left;">				
				<table style="float:left" class="table-pesquisa">
					<tr>
						<td><span>Funcionário: </span></td>
						<td><input type="text" id="nome_search_editar" name="nome_search"></td><td><input type="button" class="button"value="Buscar" onclick="buscar_funcionarios(2)"></td>
					</tr>
					
				</table>
			</div>	
		</form>	
	<?php }else{ ?>
		<form method="POST">
			<div class="msg" style="float:left;">
				<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
					<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
					<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Pesquisar Funcionário</div>
				</div>
				<table style="float:left" class="table-pesquisa">
				  	<tr><td colspan="2"><span>Digite um CBO para editar:</span><br /></td></tr>
					<tr>
						<td><span>CBO: </span></td>
						<td><input type="text" id="nome_search" name="nome_search"></td><td><input type="button" value="Buscar" onclick=""></td>
					</tr>
					
				</table>
			</div>	
		</form>
	<?php } ?>
</div>