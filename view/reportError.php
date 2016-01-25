
<div class='formulario' style="background-color:rgba(200,200,200,0.8); box-shadow: 5px 5px 10px #333; border: 5px solid#ababab; border-radius:5px;">

	<h1 style='text-align:center; font-family:Arial; font-size:20px'>Reportar erro</h1>	



	<form method="post" action='reportMailError.php' id="form_error" name="form_error">

		<hr style='margin-top:-10px'>
		<table>
			<tr><td></td></tr>
			<div class='form-input' style="text-align:left"><b>Página</b>: <input type='text' placeholder="Digite o endereço da pagina..." value="<?php echo $_SERVER['REQUEST_URI']; ?>" title="Endereço da pagina onde se encontra o erro" name='pag' id='pag' style="width:100%; color:#9a9a9a"></div>

		<div class='form-input' style="text-align:left"><b>Descrição do erro</b></div><br /><div class='form-input' style="text-align:left"><textarea name='descricao' id='descricao' style="border-radius: 5px; width:100%; max-width:100%; height:100px; max-height:150px" placeholder="Descreva o erro encontrado..."></textarea></div>

		</table>
		<br /><br />

		<input class="button" name="submit" value="Enviar" onclick="submitForm(this.form)" type="button"> <input class="button" type="button" value="Cancelar" onclick="fecha_error()" type="button"> <br />

	</form>



</div>
