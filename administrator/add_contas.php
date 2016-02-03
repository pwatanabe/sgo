<?php
include("restrito.php");
include_once("../includes/functions.php");
include_once("../model/class_cliente.php");
include_once("../model/class_conta_bd.php");
include_once("../model/class_parcelas_bd.php");
include_once("../model/class_plano_conta.php");
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
    
    
    $("#tipo_data_vencimento").change(function(){        
         var tipo = $("#tipo_data_vencimento").val();
         var parcelas = $("#parcelas").val();
        
        
        var url = '../ajax/ajax_tipo_data_vencimento?tipo='+tipo+'&parcelas='+parcelas;  //caminho do arquivo php que irá buscar as cidades no BD
			          $.get(url, function(dataReturn) {
			            $('#tipo_data').html(dataReturn);  //coloco na div o retorno da requisicao
			          });
//        
        $("#tipo_data").show();
//        $("#voltar3").fadeToggle();
    });
    
    
    $("#tipo_data_vencimento_r").change(function(){
        
         var tipo = $("#tipo_data_vencimento_r").val();
         var parcelas = $("#parcelas_r").val();
        
       
        var url = '../ajax/ajax_tipo_data_vencimento?tipo='+tipo+'&parcelas='+parcelas;  //caminho do arquivo php que irá buscar as cidades no BD
			          $.get(url, function(dataReturn) {
			            $('#tipo_data_r').html(dataReturn);  //coloco na div o retorno da requisicao
			          });
//        
        $("#tipo_data_r").show();
//        $("#voltar3").fadeToggle();
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
      var aux = document.getElementById('parcelas').value;
      if(aux <= 0){
        alert("Você não pode adicionar uma conta com menos de uma parcela !")
        document.getElementById('parcelas').value = 1;
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
    
function fechaParcela() {    
    $("#tipo_data").hide();
    $("#tipo_data_r").hide();
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
            $clsparcelas = new Parcelas();
            $parcelas = array();
            $err = 0;
            
        if(isset($_POST['apagar_areceber']) && $_POST['apagar_areceber'] != "" ){
            
            foreach ($_POST as $key => $value) {
                
                for($i = 1; $i<= $_POST['parcelas']; $i++){
                   
                    if($key == "parcela".$i ){     
                    
                      $parcela[$i] = $value;                      

                    }
                }
          
                
                if($key == "cod"){
                    $cod = $value;
                    }
                    
                    if($key == "select_fornecedor_cliente"){
                    $fornecedor = $value;                       
                    }
                    
                    if($key == "banco"){
                        $banco = $value;
                    }
                    
                    if($key == "valor"){
                    $valor = $value;
                    }
                    
                    if($key == "tipo_de_pagamento"){
                        $tipo_de_pagamento = $value;
                    }
                               
            }
            
            
                
                $contas = new Contas();
                $tipo_a_p = $_POST['apagar_areceber'];
                $descricao = $_POST['desc'];
                $obra = $_POST['obra'];
                $plano = $_POST['plano'];
                $id_parcela = 0;              
                $multa = $_POST['multa'];
                $juros = $_POST['juros'];
                $periodo_juros = $_POST['periodo_juros'];  
                
                if($cod == ""){
                    $err++;
                }
                if($banco == ""){
                    $err++;
                }
                if($valor == ""){
                    $err++;
                }
//                if($tipo_de_pagamento == 0){
//                    $err++;
//                }
              
                if($err == 0){     
                    
                    $contas->add_contas($cod, $descricao, $fornecedor, $obra, $plano, $banco, $valor, $id_parcela, $tipo_de_pagamento, $multa, $juros, $periodo_juros, $tipo_a_p, $id_empresa);
                    $contas->add_contas_bd();
                    $ultima_conta = $contas->get_ultima_conta();
                    
                    
                    
                    if($_POST['parcelas'] > 1 && $_POST['tipo'] == 1 ){
                        
                        for($i = 1; $i<= $_POST['parcelas']; $i++){

                             $comprovante = "";
                             $clsparcelas->add_parcelas($ultima_conta, $parcela[1], $i, $comprovante);
                             $clsparcelas->add_parcelas_bd();

                        }
                    }else{
                         for($i = 1; $i<= $_POST['parcelas']; $i++){

                         $comprovante = "";
                         $clsparcelas->add_parcelas($ultima_conta, $parcela[$i], $i, $comprovante);
                         $clsparcelas->add_parcelas_bd();

                        }
                    }
                    
                   
                
                }else{
                    echo "<script>alert('dados a serem preenchidos')</script>";
                    echo "<script>window.history.back()</script>";
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
                                    <option name="select_fornecedor_cliente" value="no_sel">Selecione</option>
                                    <option name="select_fornecedor_cliente" value="sem_fornecedor">SEM FORNECEDOR</option>
                                    <?php 
                                       $fornecedor = new Cliente();
                                       $fornecedor = $fornecedor->get_all_fornecedor();
                                       for ($i=0; $i < count($fornecedor) ; $i++) { 
                                          echo '<option name="select_fornecedor_cliente" value="'.$fornecedor[$i][0].'">'.$fornecedor[$i][1].'</option>';
                                       }
                                     ?>
                                 </select></td> 
                                 
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
                           <td colspan="2"><span>Plano de Contas:</span></td>
                            <td>
                        <select name='plano' id='plano'>                          
                              <?php
                                $plano_deconta = new PlanoConta();
                                $array = $plano_deconta->get_all_PlanoConta();
                                foreach ($array as $key => $value) {
                                     echo "<option value=".$value->id.">".$value->nome."/".$value->codigo."</option>";
                                }
                                
                            ?>
                        </select>
                            </td>
                       </tr>
                       
                       <tr>
                            <td>
                           <span>Banco</span></td>
                            <td>
                                <input type="text" name='banco' id='banco' >                          
                            </td>                            
                       </tr>
                       <tr>                                             
                           <td><span>Valor: </span></td>
                           <td><input onkeyup="mascara(this, mvalor);" type="text" name="valor" id="valor"></td>
                           <td><span>N° Parecelas: </span></td>
                           <td><input type="number" value="1" onchange="confereNegativos()" name='parcelas' id="parcelas"></td>
                       </tr>
                       <tr>
                           <td><span>Data de vencimento</span></td>
                            <td>
                                <select name="tipo" id="tipo_data_vencimento">
                                    <option value="no_sel">Selecione</option>
                                    <option id="tipo" value="1">Mensal</option>                                                                              
                                    <option id="tipo" value="3">Inserir data por parcela</option>
                                </select>
                            </td>    
                            <td><span>Tipo de pagamento</span></td><td>
                                <select id="tipo_de_pagamento" name="tipo_de_pagamento">
                                    <option value="0">Selecione</option>
                                    <option id="tipo" value="Boleto">Boleto</option>
                                    <option id="tipo" value="Cartão">Cartão</option>                                            
                                    <option id="tipo" value="Crédito em Conta">Crédito em conta</option>
                                    <option id="tipo" value="Cheque">Cheque</option>
                                </select></td>
                       </tr>
                       <div id="tipo_data"></div> 
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
                       
                       <input type="hidden" value="2" id="apagar_areceber" name="apagar_areceber">
                       
                       <table style="width:100%;">
                       <tr>
                           <td><span>Código:</span></td><td><input type="text" id="cod" name="cod"></td>
                           <td><span>Descrição:</span></td><td><textarea id="desc" name="desc"></textarea></td>
                       </tr>
                       <tr><td><span>Cliente:</span></td><td>
                                  <select id="select_fornecedor" name="select_fornecedor_cliente"  style="width:100%" title="Selecione o fornecedor">
                                    <option name="select_fornecedor_cliente" value="no_sel">Selecione</option>
                                    <option name="select_fornecedor_cliente" value="sem_cliente">Sem Cliente</option>
                                    <?php 
                                       $fornecedor = new Cliente();
                                       $fornecedor = $fornecedor->get_all_cliente();
                                       for ($i=0; $i < count($fornecedor) ; $i++) { 
                                          echo '<option name="select_fornecedor_cliente" value="'.$fornecedor[$i][0].'">'.$fornecedor[$i][1].'</option>';
                                       }
                                     ?>
                                 </select></td> 
                                 
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
                           <td colspan="2"><span>Plano de Contas:</span></td>
                            <td>
                        <select name='plano' id='plano'>                          
                              <?php
                                $plano_deconta = new PlanoConta();
                                $array = $plano_deconta->get_all_PlanoConta();
                                foreach ($array as $key => $value) {
                                     echo "<option value=".$value->id.">".$value->nome."/".$value->codigo."</option>";
                                }
                                
                            ?>
                        </select>
                            </td>
                       </tr>
                       
                       <tr>
                            <td>
                           <span>Banco</span></td>
                            <td>
                                <input type="text" name='banco' id='banco' >                          
                            </td>                            
                       </tr>
                       <tr>                                             
                           <td><span>Valor: </span></td>
                           <td><input onkeyup="mascara(this, mvalor);" type="text" name="valor" id="valor"></td>
                           <td><span>N° Parecelas: </span></td>
                           <td><input type="number" value="1" onchange="confereNegativos()" name='parcelas' id="parcelas_r"></td>
                       </tr>
                       <tr>
                           <td><span>Data de vencimento</span></td>
                            <td>
                                <select name="tipo" id="tipo_data_vencimento_r">
                                    <option value="no_sel">Selecione</option>
                                    <option id="tipo" value="1">Mensal</option>                                                                              
                                    <option id="tipo" value="3">Inserir data por parcela</option>
                                </select>
                            </td>    
                            <td><span>Tipo de pagamento</span></td><td>
                                <select id="tipo_de_pagamento" name="tipo_de_pagamento">
                                    <option value="0">Selecione</option>
                                    <option id="tipo" value="Boleto">Boleto</option>
                                    <option id="tipo" value="Cartão">Cartão</option>                                            
                                    <option id="tipo" value="Crédito em Conta">Crédito em conta</option>
                                    <option id="tipo" value="Cheque">Cheque</option>
                                </select></td>
                       </tr>
                       <div id="tipo_data_r"></div> 
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