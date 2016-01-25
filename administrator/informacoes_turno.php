<?php

include_once("../model/class_turno_bd.php");

?>
<script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
	function buscar_turno(){    
  	   var nome = document.getElementById('nome_search').value;
      //se encontrou o estado
      if(nome){
      	
        var url = '../ajax/ajax_buscar_informacoes_turno.php?nome='+nome;  //caminho do arquivo php que irá buscar as cidades no BD

        $.get(url, function(dataReturn) {
        	
          $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
        });
      }
    }
    function buscar_editar(tipo){
        var url = '../ajax/ajax_editar_turno.php?tipo='+tipo;  //caminho do arquivo php que irá buscar as cidades no BD

        $.get(url, function(dataReturn) {
        	$('#result').html(dataReturn);  //coloco na div o retorno da requisicao
        });
      
    }
</script>

<div class="formulario">
		
	<input type="button" class="button" value="Editar" onclick="buscar_editar('1')">
  <input type="button" class="button" value="Excluir" onclick="buscar_editar('2')">
  <!-- <input type="button" class="button" value="Pesquisar" onclick="buscar_editar('3')"> -->
	<div id="result">
	</div>
</div>