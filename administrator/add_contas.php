<?php
include("restrito.php");
include_once("../includes/functions.php");
include_once("../model/class_cliente.php");
include_once("../model/class_conta_bd.php");
include_once("../includes/util.php");


?>
<style>
    .divisoes{
        float: left;
        clear: left;
    }
    
</style>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
<script>

$(document).ready(function(){
    $("#fp").click(function(){
        $("#formulario-apagar").fadeToggle();
        $("#fr").fadeToggle();
        $("#voltar2").fadeToggle();
    });
    $("#fr").click(function(){
        $("#formulario-areceber").fadeToggle();
        $("#fp").fadeToggle();
        $("#voltar1").fadeToggle();
    });
    
    
     $("#vr").click(function(){
        var url = '../ajax/ajax_editar_conta?tipo=areceber';  //caminho do arquivo php que irá buscar as cidades no BD
			          $.get(url, function(dataReturn) {
			            $('#visualizar-conta').html(dataReturn);  //coloco na div o retorno da requisicao
			          });
        
        $("#vp").fadeToggle();
        $("#voltar3").fadeToggle();
    });
        $("#vp").click(function(){
              var url = '../ajax/ajax_editar_conta?tipo=apagar';  //caminho do arquivo php que irá buscar as cidades no BD
			          $.get(url, function(dataReturn) {
			            $('#visualizar-conta').html(dataReturn);  //coloco na div o retorno da requisicao
			          });
       
        $("#vr").fadeToggle();
        $("#voltar4").fadeToggle();
    });
    
    
    
         $("#vrecebidas").click(function(){
        var url = '../ajax/ajax_editar_conta?tipo=buscarrecebidias';  //caminho do arquivo php que irá buscar as cidades no BD
			          $.get(url, function(dataReturn) {
			            $('#visualizar-conta').html(dataReturn);  //coloco na div o retorno da requisicao
			          });
        
        $("#vpagas").fadeToggle();
        $("#voltar5").fadeToggle();
    });
        $("#vpagas").click(function(){
              var url = '../ajax/ajax_editar_conta?tipo=buscarapagas';  //caminho do arquivo php que irá buscar as cidades no BD
			          $.get(url, function(dataReturn) {
			            $('#visualizar-conta').html(dataReturn);  //coloco na div o retorno da requisicao
			          });
       
        $("#vrecebidas").fadeToggle();        
        $("#voltar6").fadeToggle();
    });
    
    
    
  
});
    function confereNegativos(){
      var aux = document.getElementById('num_parcelas').value;
      if(aux <= 0){
        alert("Você não pode adicionar uma conta com menos de uma parcela !")
        document.getElementById('num_parcelas').value = 1;
      }
    }


    function abreEnvio(){
        document.getElementById('abreenvio').hidden = false ;
    }
    
    function visualizaComprovante(str){
      
      var aux = str.split(":")
      var id_conta = aux[0]
      var nome_comprovante = aux[1];
      var id_empresa = aux[2];
        window.open("../images/"+id_empresa+"/comprovantes/"+id_conta+"/"+nome_comprovante);
    }


//    function addContaPaga(id){     
//      
//        var data = document.getElementById(id+'data').value;
//        var aux = data.split("-");
//        var ano = aux[0];
//        var mes = aux[1];
//        var dia = aux[2];
//        
//        var url = '../ajax/ajax_editar_conta?id='+id+'&pago='+1+'&ano='+ano+'&mes='+mes+'&dia='+dia;  //caminho do arquivo php que irá buscar as cidades no BD
//			          $.get(url, function(dataReturn) {
//			            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
//			          });
//    }
//    
 

</script>


<html>
    <?php Functions::getHead('Adicionar');?>
    <?php Functions::getScriptContas();?>
    <?php Functions::getPaginacao();?>
  
    
    <body>
        <?php include_once("../view/topo.php"); ?>

        <div id="result"></div>
        
            <div class='formulario' style="width:50%;">                
               <div class="title-box" style="float:left"><div style="float:left"><img src="../images/user_add.png" width="60px" style="margin-left:-20px; margin-top:-20px;"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">CADASTRO DE CONTAS</span></div></div>
               
            <?php
            $contas = new Contas();
            
            
            if(isset($_POST['apagar_areceber']) && $_POST['apagar_areceber'] != "" ){
                
                foreach ($_POST as $key => $value) {                          
                    
                             if($key == 'cod' && isset($value)){
                                $cod = $value;                                 
                             }
                             if($key == 'desc' && isset($value)){
                                $desc = $value;                                
                             }
                              if($key == 'select_fornecedor' && isset($value)){
                                $select_fornecedor = $value;                                
                             }
                               if($key == 'sem_fornecedor_cliente' && isset($value)){
                                $sem_fornecedor_cliente = 'Sem fornecedor ou cliente';                                
                             }
                               if($key == 'obra' && isset($value)){
                                $obra = $value;                                 
                             }
                               if($key == 'valor' && isset($value)){
                                $source = array('.', ',','R$');
                                $replace = array('', '.','');
                                $valor = str_replace($source, $replace, $value); //remove os pontos e substitui a virgula pelo ponto                                                              
                             }
                               if($key == 'multa' && isset($value)){
                                $source = array('.', ',','R$');
                                $replace = array('', '.','');
                                $multa = str_replace($source, $replace, $value);                              
                             }
                              if($key == 'banco' && isset($value)){
                                $banco = $value;                                
                             }                            
                               if($key == 'num_parcelas' && isset($value)){
                                $num_parcelas = $value;                                
                             }
                               if($key == 'data' && isset($value)){                                   
                                $data = $value;                                
                             }
                                if($key == 'juros' && isset($value)){
                                $source = array('.', ',','R$');
                                $replace = array('', '.','');    
                                $juros = str_replace($source, $replace, $value);                                
                             } 
                             
                            if($key == 'periodo_juros' && isset($value)){
                                $periodo_juros = $value;                                 
                             } 
                               if($key == 'apagar_areceber' && isset($value)){
                                $tipo = $value;                                
                             } 
                             $id_empresa = $_SESSION['id_empresa'];
                         } 
                         
                         if(isset($sem_fornecedor_cliente) && $sem_fornecedor_cliente != ""){
                             $id_fornecedor = $sem_fornecedor_cliente;
                         }else{
                            if(isset($_POST['select_fornecedor_cliente']))
                             $id_fornecedor = $_POST['select_fornecedor_cliente'];                             
                         }
                         
                        
                         if(isset($cod) && $cod != "" && isset($valor) && $valor != "" && isset($data) && $data != "" && isset($banco) && $banco != ""){
               
                         $contas->add_contas($cod, $desc, $id_fornecedor, $obra, $banco, $valor, $multa, $data, $num_parcelas, $juros, $periodo_juros, $tipo, $id_empresa);
                      
                         $contas->add_contas_bd();
                         }else {
                             
                             echo '<div class="msg">Por favor preencha os seguintes campos : <br>';
                             $err = 0;                            
                             
                             if($cod == ""){
                                 echo 'Codigo<br>';                                 
                             }
                             if($valor == ""){
                                 echo 'Valor<br>';
                             }
                             if($data == ""){
                                 echo 'Data<br>';
                             }
                             if($banco == ""){
                                 echo 'Banco<br>';
                             }
                         }
            }       
            ?>
                  
               <div style="margin-top:50px; background-color:rgba(50,200,50,0.3); "><span style="font-family: sans-serif; font-size: 20pt;">Cadastrar Contas</span></div>
               <Nav style="padding:20px;">
                   <a hidden="on" id="voltar1" href="add_contas.php">Voltar</a> <a id="fp" href="#formulario-apagar">À pagar</a> | <a id="fr" href="#formulario-areceber">À receber</a><a hidden="on" id="voltar2" href="add_contas.php">Voltar</a>                  
               </nav>
                       
               <div hidden="on" id="formulario-apagar">
                   <div class="title"><h3>À Pagar</h3></div>
                   <form method="Post" action="add_contas.php">
                       
                       <input type="hidden" value="1" id="apagar_areceber" name="apagar_areceber">
                       
                       <table style="width:100%;">
                       <tr>
                           <td><span>Código:</span></td><td><input type="text" id="cod" name="cod"></td>
                           <td><span>Descrição:</span></td><td><textarea id="desc" name="desc"></textarea></td>
                       </tr>
                       <tr><td><span>Forncedor:</span></td><td>
                                  <select id="select_fornecedor" name="select_fornecedor_cliente"  style="width:100%" title="Selecione o fornecedor">
                                    <option value="no_sel">Selecione</option>
                                    <?php 
                                       $fornecedor = new Cliente();
                                       $fornecedor = $fornecedor->get_all_fornecedor();
                                       for ($i=0; $i < count($fornecedor) ; $i++) { 
                                          echo '<option value="'.$fornecedor[$i][0].'">'.$fornecedor[$i][1].'</option>';
                                       }
                                     ?>
                                 </select></td> 
                                 <td><span>Sem Fornecedor</span></td><td><input type="checkbox" id="sem_fornecedor_cliente" name='sem_fornecedor_cliente' type="fornecedor não consta no cadastrado"></td>
                       </tr>
                       <tr>
                           <td colspan="2"><span>Pagamento relacionado a obra:</span></td>
                            <td>
                        <select name='obra' id='obra'>
                           <option value='obrax'>Obra x</option> 
                            <option value='obray'>Obra y</option>
                        </select>
                            </td>
                       </tr>
                       <tr>
                            <td>
                           <span>Banco</span></td>
                            <td>
                                <input type="text" name='banco' id='banco' >                          
                            </td>
                            <td><span>Data do vencimento: </span></td>
                            <td><input type="date" name="data" id="data"></td>
                       </tr>
                       <tr>                                             
                           <td><span>Valor: </span></td>
                           <td><input onkeyup="mascara(this, mvalor);" type="text" name="valor" id="valor"></td>
                           <td><span>N° Parecelas: </span></td>
                           <td><input type="number" value="1" onchange="confereNegativos()" name='num_parcelas' id="num_parcelas"></td>
                       </tr>
                       <tr>
                           <td><span>Multa por Atraso:</span></td><td><input onkeyup="mascara(this, mvalor);" type="text" id="multa" name="multa"></td>
                           <td><span>Juros:</span></td><td><input type="text" id="juros" name="juros" onkeyup="mascara(this, mvalor);"></td><td>
                                                                                            <select id="periodo_juros" name="periodo_juros" style="width: 100px;">
                                                                                                <option value="anual">Diário</option>
                                                                                                <option value="mensal">Mensal</option>
                                                                                                <option value="anual">Anual</option>
                                                                                            </select></td>
                            
                       </tr>
                       
                       </table>
                       
                       <div  id="editar" hidden="on" style="margin:0 auto; margin-top:30px;">
                           <input type="hidden" type="atualizar" value="atualizar">
                           <input type="button" class="button" value="Cancelar"><input class="button" type="submit" value="Guardar">
                       </div>
                      
                       
                       <div id="adicionar" style="margin:0 auto; margin-top:30px;"><input type="button" class="button" value="Cancelar"><input class="button" type="submit" value="Guardar"></div>
                   </form>
              </div>
                
               <div hidden="on" id="formulario-areceber">
                   
                   <div class="title"><h3>À Receber</h3></div>
                   <form method="Post" action="add_contas.php">
                       
                       <input type="hidden" value="2" name="apagar_areceber" id="apagar_areceber">
                       
                       <table style="width:100%;">
                       <tr>
                           <td><span>Código:</span></td><td><input type="text" id="cod" name="cod"></td>
                           <td><span>Descrição:</span></td><td><textarea id="desc" name="desc"></textarea></td>
                       </tr>
                       
                        <tr><td><span>Cliente:</span></td><td>
                                  <select id="select_fornecedor" name="select_fornecedor_cliente"  style="width:100%" title="Selecione o fornecedor">
                                    <option value="no_sel">Selecione</option>
                                    <?php 
                                       $fornecedor = new Cliente();
                                       $fornecedor = $fornecedor->get_all_cliente();
                                       for ($i=0; $i < count($fornecedor) ; $i++) { 
                                          echo '<option value="'.$fornecedor[$i][0].'">'.$fornecedor[$i][1].'</option>';
                                       }
                                     ?>
                                 </select></td> 
                                 <td><span>Sem Cliente</span></td><td><input type="checkbox" name='sem_fornecedor_cliente' type="fornecedor não consta no cadastrado"></td>
                       </tr>
                       <tr>
                           <td colspan="2"><span>Pagamento relacionado a obra:</span></td>
                           <td style="width: 100px;">
                        <select name='obra' id='obra'>
                           <option value='obrax'>Obra x</option> 
                            <option value='obray'>Obra y</option>
                        </select>
                            </td>
                       </tr>
                     <tr>
                         <td>
                           <span>Banco</span></td>
                            <td>
                                <input type="text" name='banco' id='banco' >                          
                            </td>
                            <td><span>Data do vencimento: </span></td>
                            <td><input type="date" name="data" id="data"></td>
                       </tr>
                       <tr>                                             
                           <td><span>Valor: </span></td>
                           <td><input onkeyup="mascara(this, mvalor);" type="text" name="valor" id="valor"></td>
                           <td><span>N° Parecelas: </span></td>
                           <td><input type="number" value="1" onchange="confereNegativos()" name='num_parcelas' id="num_parcelas"></td>
                           
                           
                       </tr>
                       <tr>
                           <td><span>Multa por Atraso:</span></td><td><input onkeyup="mascara(this, mvalor);" type="text" id="multa" name="multa"></td>
                           <td><span>Juros:</span></td><td><input onkeyup="mascara(this, mvalor);" type="text" id="juros" name="juros"></td><td>
                                                                                            <select id="periodo_juros" name="periodo_juros" style="width: 100px;">
                                                                                                <option value="mensal">Mensal</option>
                                                                                               <option value="anual">Anual</option>
                                                                                                <option value="diaria">Ao dia</option>
                                                                                            </select>
                           </td>
                            
                       </tr>
                       
                       </table>
                        <div id="editar" hidden="on" style="margin:0 auto; margin-top:30px;">
                             <input type="hidden" type="atualizar" value="atualizar">
                             <input type="button" class="button" value="Cancelar"><input class="button" type="submit" value="Guardar">
                         </div>
                        <div id="adicionar" style="margin:0 auto; margin-top:30px;"><input type="button" class="button" value="Cancelar"><input class="button" type="submit" value="Guardar"></div>
                   </form>
               </div> 
               
                <div class="col-5">
                    <div class="center">
                        <div id="ver_contas" style="background-color:rgba(50,200,50,0.3); "><span style="font-family: sans-serif; font-size: 20pt;">Ver Contas</span></div>
                        <nav>
                            <a hidden="on" id="voltar3"  href="add_contas.php">Voltar</a> <a id="vp" href="#ver_contas">À pagar</a> | <a id="vr" href="#ver_contas">À receber</a><a hidden="on" id="voltar4" href="add_contas.php">Voltar</a>                  
                        </nav>
                    </div>
                 </div>
                <div class="col-5">
                   <div class="center">
                        <div id="finalizadas" style="background-color:rgba(50,200,50,0.3); "><span style="font-family: sans-serif; font-size: 20pt;">Ver Contas Finalizadas</span></div>
                        <nav>
                           <a hidden="on" id="voltar5"  href="add_contas.php">Voltar</a> <a id="vpagas" href="#ver_pagas">Pagas</a> | <a id="vrecebidas" href="#ver_recebidas">Recebidas</a><a hidden="on" id="voltar6" href="add_contas.php">Voltar</a>                  
                        </nav>
                    </div>
                </div>

               </div>
                <div class="center" >
                    <div class="col-8">
                     <div id="visualizar-conta"></div>
                     </div>
                </div>
                <div style="height: 50px;" class="center">
                </div>  
    </body>
</html>