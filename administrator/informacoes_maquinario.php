<?php

include_once("../model/class_maquinario_bd.php");

?>
<script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
	function buscar_patrimonios(param){
        
        if(param == 0){//EDITAR
      	   var maquinario = document.getElementById('nome_search').value;
            //se encontrou o estado
            if(maquinario){
            	
              var url = '../ajax/ajax_buscar_informacoes_maquinario.php?maquinario='+maquinario+'&param='+param;  //caminho do arquivo php que irá buscar as cidades no BD

              $.get(url, function(dataReturn) {
              	
                $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
              });
            }
        }
        if(param == 1){//EXCLUIR
          var maquinario = document.getElementById('nome_search').value;
            //se encontrou o estado
            if(maquinario){
              
              var url = '../ajax/ajax_buscar_informacoes_maquinario.php?maquinario='+maquinario+'&param='+param;  //caminho do arquivo php que irá buscar as cidades no BD

              $.get(url, function(dataReturn) {
                
                $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
              });
            }
        }
    }
    function buscar_editar(tipo){
        var url = '../ajax/ajax_editar_patrimonio.php?tipo='+tipo;  //caminho do arquivo php que irá buscar as cidades no BD
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