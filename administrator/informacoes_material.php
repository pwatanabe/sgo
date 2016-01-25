<?php
include_once("restrito.php");
include_once("../model/class_material_bd.php");
include_once("../model/class_unidade_medida_bd.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");
include_once("../model/class_config.php");
include_once("../model/class_cidade_bd.php");
include_once("../model/class_tipo_custo_bd.php");
include_once("../model/class_valor_custo_bd.php");
include_once("../model/class_estado_bd.php");
include_once("../model/class_regiao_bd.php");
include_once("../model/class_custo_regiao_bd.php");

?>
<script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
<script type="text/javascript">
    
                        /* Máscaras ER */
            function mascara(o,f){
                v_obj=o
                v_fun=f
                setTimeout("execmascara()",1)
            }
            function execmascara(){
                v_obj.value=v_fun(v_obj.value)
            }
            function mnum(v){
                v=v.replace(/\D/g,"");                                      //Remove tudo o que não é dígito
                return v;
            }
            function mvalor(v){
                v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
                v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
                v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares

                v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
                return v;
            }
    
          function hideall(x){
            if(document.getElementById(x).hidden == true){
                document.getElementById(x).hidden = false;
            }else{
                document.getElementById(x).hidden = true;
                document.getElementById(1).hidden = true;
                document.getElementById(2).hidden = true;
                document.getElementById(3).hidden = true;
                document.getElementById(4).hidden = true;
                document.getElementById("opcoes-materiais").hidden = true;
            }
        }
     
     function ocultaTabela(x){
       
          if(document.getElementById(x).hidden == true){
                document.getElementById(x).hidden = false;
            }else{
                document.getElementById(x).hidden = true;
            }
             alert('Não foi selecionado nenhum estado ou cidade')
     }
     function mostraTabela1(x){
            
            if(document.getElementById(3).hidden == false){
                document.getElementById(3).hidden = true;
            }
            
            
            if(document.getElementById(x).hidden == true){
                document.getElementById(x).hidden = false;
            }else{
                document.getElementById(x).hidden = true;
            }
            
     }
   
     function mostraTabela2(x){
            if(document.getElementById(1).hidden == false){
                document.getElementById(1).hidden = true;
            }
            
            if(document.getElementById(x).hidden == true){
                document.getElementById(x).hidden = false;
            }else{
                document.getElementById(x).hidden = true;
            }
            
     }
        function carregaTipoCusto(tp){
         data = tp.split(":");
          var aux = data[0];
          
          var aux3 = data[2];
       
          
        
      var combo = document.getElementById(aux+":tipo_custo");
      for (var i = 0; i < combo.options.length; i++)
      {
        if (combo.options[i].value == aux3)
        {
          combo.options[i].selected = true;
          
          break;
        }
      }     
    } 
     
    function carregaUf(uf){
         data = uf.split(" ");
          var aux = data[0];
         
          var aux2 = data[1];
        
        
      var combo = document.getElementById(aux2+"xestado");
      for (var i = 0; i < combo.options.length; i++)
      {
        if (combo.options[i].value == aux)
        {
          combo.options[i].selected = true;
          
          break;
        }
      }
      buscar_cidades(aux2+"xestado");
    } 
    
    function buscar_cidades(x){ 
          
          var estado = document.getElementById(x).value;  //codigo do estado escolhido
          data = x.split("x");
          var aux = data[0];
          var aux2 = data[1];
         
          //se encontrou o estado
          if(estado){
            var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
            $.get(url, function(dataReturn) {
              $('#'+aux+'load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
            });
          }
    }
    
    function carregaCidade(){
                var combo = document.getElementById("cidade");
                var cidade = document.getElementById("id_cidade").value;
                
                for (var i = 0; i < combo.length; i++)
                {

                  if (combo.options[i].value == cidade)
                  {
                    combo.options[i].selected = true;
                    break;
                  }
                }      
    }
    
   
	function buscar_materiais(param){
        if(param == 0){//EDITAR
      	   var material = document.getElementById('nome_search').value;
            //se encontrou o estado
            if(material){
            	
              var url = '../ajax/ajax_buscar_informacoes_materiais.php?material='+material+'&param='+param;  //caminho do arquivo php que irá buscar as cidades no BD

              $.get(url, function(dataReturn) {
              	
                $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
              });
            }
        }
        if(param == 1){//EXCLUIR
          var material = document.getElementById('nome_search').value;
            //se encontrou o estado
            if(material){
              
              var url = '../ajax/ajax_buscar_informacoes_materiais.php?material='+material+'&param='+param;  //caminho do arquivo php que irá buscar as cidades no BD

              $.get(url, function(dataReturn) {
                
                $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
              });
            }
        }
    }
    function infoRegiao(id){        
        document.getElementById(id).style.margin = "0";       
    }
    function fechaInfo(id){
        document.getElementById(id).style.margin = "-500";  
    }
    function buscar_editar(tipo){
        var url = '../ajax/ajax_editar_material.php?tipo='+tipo;  //caminho do arquivo php que irá buscar as cidades no BD
        $.get(url, function(dataReturn) {
        	$('#result').html(dataReturn);  //coloco na div o retorno da requisicao
        });
      
    }
</script>

<div class="formulario">
		
	<input type="button" class="button" value="Editar" onclick="buscar_editar('1')">
  <input type="button" class="button" value="Excluir" onclick="buscar_editar('2')">
	<div id="result">
	</div>
                     <div>
                        <?php include_once("../view/material_valor.php"); ?>
                    </div>  
</div>