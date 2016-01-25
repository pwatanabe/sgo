<?php

include_once("../model/class_cbo_bd.php");

?>
<script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
	function buscar_funcionarios(param){
      if(param == 0){   
            var funcionario = document.getElementById('nome_search').value;
            //se encontrou o estado
            if(funcionario){
              
              var url = '../ajax/ajax_buscar_informacoes_funcionario.php?funcionario='+funcionario+'&param='+param;  //caminho do arquivo php que irá buscar as cidades no BD

              $.get(url, function(dataReturn) {
                
                $('#result1').html(dataReturn);  //coloco na div o retorno da requisicao
              });
            }
      }
      if(param == 1){
            var funcionario = document.getElementById('nome_search').value;
            //se encontrou o estado
            if(funcionario){
              
              var url = '../ajax/ajax_buscar_informacoes_funcionario.php?funcionario='+funcionario+'&param='+param;  //caminho do arquivo php que irá buscar as cidades no BD

              $.get(url, function(dataReturn) {
                
                $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
              });
            }
      }
      if(param == 2){
            var funcionario = document.getElementById('nome_search_editar').value;
            //se encontrou o estado
            if(funcionario){
              
              var url = '../ajax/ajax_buscar_informacoes_funcionario.php?funcionario='+funcionario+'&param='+param;  //caminho do arquivo php que irá buscar as cidades no BD

              $.get(url, function(dataReturn) {
                
                $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
              });
            }
      }
    }
    function buscar_editar(tipo){
        var url = '../ajax/ajax_editar_func_epi.php?tipo='+tipo;  //caminho do arquivo php que irá buscar as cidades no BD
        $.get(url, function(dataReturn) {
          if(tipo == 1){
             $('#result1').html(dataReturn);  //coloca resultado em baixo do botão pesquisar
          }else{
             $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
          }
        });
    }
</script>
  <div class="formulario">
  <input type="button" class="button" value="Editar" onclick="buscar_editar('2')">
  <input type="button" class="button" value="Excluir" onclick="buscar_editar('2')">
	
  <?php //Classe result recebe os dados vindos do ajax ?>  
	<div id="result">
  </div>
  </div>