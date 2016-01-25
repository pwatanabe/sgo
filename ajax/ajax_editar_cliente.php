<div class="formulario" style="width:450px;">
	<?php if($_GET['tipo'] == 1){ ?>
		<form method="POST">
			
			<div class="msg" style="float:left;">
				<div style="float:left; background-color:rgba(50,200,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
					<div style="float:left; margin-left:5px;"><img src="../images/search-icon.png" style="width:40px;"></div>
					<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Pesquisar e Editar</div>
				</div>
				<table style="float:left" class="table-pesquisa">
				  	<tr><td colspan="2"><span>Digite um nome para editar:</span><br /></td></tr>
				  	<tr><td> <input style="height:12px;" type="radio" id="pessoafisica" name="pessoatipo" checked><span>Pessoa Fisica</span></td><td> <input type="radio" style="height:12px;" id="pessoajuridica" name="pessoatipo"><span>Pessoa Juridica</span></td></tr>
					<tr>
						<td><span>Nome: </span></td>
						<td><input type="text" id="nome_search" name="nome_search"></td><td><input type="button" class="button" value="Buscar" onclick="buscar_clientes(document.getElementById('pessoafisica').checked?0:1,'0')"></td>
					</tr>
					
				</table>
			</div>			
		</form>
	<?php }else if($_GET['tipo'] == 2){ ?>
		<form method="POST">
			<div class="msg" style="float:left;">
				<div style="float:left; background-color:rgba(200,50,50,0.3); width:100%; height:43px; text-align:left; margin-top:-20px;">
					<div style="float:left; margin-left:5px;"><img src="../images/delete.png" style="width:35px; margin-top:3px;"></div>
					<div style="float:left; margin-left:5px; margin-top:10px; font-size:18px; color:#333;">Pesquisar e Excluir</div>
				</div>
				<table style="float:left" class="table-pesquisa">
				  	<tr><td colspan="2"><span>Digite um nome para excluir:</span><br /></td></tr>
					<tr><td> <input style="height:12px;" type="radio" id="pessoafisica" name="pessoatipo" checked><span>Pessoa Fisica</span></td><td> <input type="radio" style="height:12px;" id="pessoajuridica" name="pessoatipo"><span>Pessoa Juridica</span></td></tr>
					<tr>
						<td><span>Nome: </span></td>
						<td><input type="text" id="nome_search" name="nome_search"></td><td><input type="button" class="button" value="Buscar" onclick="buscar_clientes(document.getElementById('pessoafisica').checked?0:1,'1')"></td>
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
				  	<tr><td colspan="2"><span>Digite um nome para editar:</span><br /></td></tr>
					<tr>
						<td><span>Nome: </span></td>
						<td><input type="text" id="nome_search" name="nome_search"></td><td><input type="button" class="button" value="Buscar" onclick=""></td>
					</tr>
					
				</table>
			</div>	
		</form>
	<?php } ?>
</div>