<?php
session_start();
include_once("../includes/functions.php");
include_once("../model/class_cliente.php");
include_once("../model/class_conta_bd.php");
include_once("../model/class_parcelas_bd.php");
include_once("../includes/util.php");

function confere($num,$id){
$parcelas = new Parcelas();
$p = $parcelas->get_parcelas_pagas($id);
    for($i = 0; $i< count($p); $i++){
        if($p[$i] == $num){         
            return $num;
        }
    }
}
$id = "";
$qtd_pagas = "" ;
$data = "";
$parcela_n = "";
$nome_comprovante  = "";

     


    if(isset($_FILES['arquivo']) && $_FILES['arquivo']['name'] != '' ){
          $nome_comprovante = $_FILES['arquivo']['name'];
        
          $id = $_POST['id'];
          if(isset($_FILES['arquivo'])){
                        $uploaddir = "../images/".$_SESSION['id_empresa']."/comprovantes/".$id."/";
                        $uploadfile = $uploaddir . basename($_FILES['arquivo']['name']);
                        echo '<pre>';
                              if(!is_dir($uploaddir)){  
                                 
                                mkdir($uploaddir);
                                }
                        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)) {
                                    echo "Arquivo válido e enviado com sucesso.\n";                                
                         }
                       
  
        }
    }
    
    if(isset($_POST['enviacomprovante'])){
    
    
    $parcelas = new Parcelas(); 
    $parcelas->updateComprovante($_POST['id'],$_POST['parcela'],$_POST['data'],$nome_comprovante);
   
}  
    
   if(isset($_POST['parcela'])){
       
        foreach ($_POST as $key => $value) {  

                         if($key == 'data'){
                           $data = $value;

                         }
                         if($key == 'id'){
                            $id_conta = $value;

                         }
                         if($key == 'parcela_n'){
                            $parcela_n = $value;
                         }

                 }   
                        
                         $parcelas = new Parcelas(); 
                         $parcelas->add_parcelas($id_conta, $data, $parcela_n, $nome_comprovante); 
                         if($parcelas->add_parcelas_bd()){
                             $contas = new Contas();
                         }
                         echo '<script>window.location = "../administrator/add_contas"</script>';  

 }
       
     
              
                
    
    if(isset($_GET['tipo'])){
    ?> 
<div id="visualizar-conta">
        <?php Functions::getPaginacao();?>
      <?php
                    if($_GET['tipo'] == 'apagar'){
                    $contas = new Contas();                    
                    $conta = $contas->ver_contas_apagar(); 
                    empty($conta)? print "<div class='msg' id='visualizar-conta'>Nâo foi encontado nenhum resultado para sua pesquisa</div>" : '';
                    }
                    
                    if($_GET['tipo'] == 'areceber'){
                    $contas = new Contas();                    
                    $conta = $contas->ver_contas_areceber();
                    empty($conta)? print "<div class='msg' id='visualizar-conta'>Nâo foi encontado nenhum resultado para sua pesquisa</div>" : '';
                    }
                    
                    if($_GET['tipo'] == 'buscarrecebidias'){                        
                    $contas = new Contas();                    
                    $conta = $contas->ver_contas_recebidas();                   
                    empty($conta)? print "<div class='msg' id='visualizar-conta'>Nâo foi encontado nenhum resultado para sua pesquisa</div>" : '';
                    }
                    
                    if($_GET['tipo'] == 'buscarapagas'){                       
                    $contas = new Contas();                    
                    $conta = $contas->ver_contas_pagas();
                    empty($conta)? print "<div class='msg' id='visualizar-conta'>Nâo foi encontado nenhum resultado para sua pesquisa</div>" : '';
                    }
                    
                    $style1 = 'background-color: rgba(50,200,50,0.3);';
                    $i = 0;
                    ?>
                   
                   <?php foreach ($conta as $key => $value) { 
                    $i++;                 
                    $clis = new Cliente();
                    $cli = $clis->get_all_cli_by_id($value->fornecedor_cliente);
                    if($cli[1]== ""){
                        $cli[1]= 'Fornecedor não cadastrado';
                    }
                   ?>
                    
                    <div id="contas" class="tabela-contas-apagar" style="<?php  if($i % 2 == 1){echo $style1;} ?> ">                               
                        <div  id="<?php echo $i ?>" >                             
                            <input type="hidden" id="id" name="id" value="<?php echo $value->id ?>">
                                <div  class="row">                                     
                                    <div  class="center">
                                         <div class="col-5">
                                             <div class="item"><label>Cod: </label><label><?php echo $value->codigo  ?></label></div>
                                         </div>
                                         <div class="col-5">
                                             <div class="item"><label>Fornecedor: </label> <label><?php echo $cli[1]; ?></label></div>
                                         </div>
                                         <div class="col-5">
                                             <div class="item"><label>Valor: </label> <label><?php echo'R$ ' . number_format($value->valor, 2, ',', '.') ?></label> </div>
                                         </div>     
                                          <div class="col-3">
                                             <div class="item"><label>Juros: </label> <label><?php echo $value->juros.'('.$value->periodo_juros.')'; ?></label> </div>
                                         </div>
                                        
                                    </div>
                                </div>
                                 <div class="row">
                                     <div class="center">
                                         <div class="col-5">
                                             <div class="item"><label>Data de vencimento: </label> <label><?php echo data_padrao_brasileiro($value->data_vencimento) ?></label></div>
                                        </div>
                                         <div class="col-5">
                                             <div class="item"><label>Banco: </label> <label><?php echo $value->banco ?></label></div>
                                        </div>
                                        <div class="col-5">
                                             <div class="item"><label>Obra: </label> <label><?php echo $value->obra ?></label></div>
                                        </div>
                                         
                                        <?php
                                        if(isset($value->status) && $value->status == 1 && isset($value->tipo) && $value->tipo == 1){ ?> 
                                         <div class="row">
                                             <div class="col-10">
                                                 <div class="item">
                                                     <div class="col-2">Parcelas: </div>
                                                         <div class="col-8">    
                                                            <?php                                                                        
                                                                $parcelas = new Parcelas();
                                                                $p = $parcelas->get_parcelas_pagas($value->id);
                                                                    for($index = 1; $index <= $value->parcelas; $index++){
                                                                        $num = confere($index, $value->id);                                                                       
                                                                        if($num == $index){
                                                                           $nome = $c = $parcelas->get_comprovante($value->id, $num);
                                                                           $envia = $value->id.':'.$nome.':'.$_SESSION['id_empresa'];
                                                                           ?>
                                                                <?php if($nome!=""){ ?>                                                                  
                                                                  <input type="button" id="1" value="<?php echo $index ?>" onclick="visualizaComprovante('<?php echo $envia; ?>')">
                                                                <?php } ?>
                                                                <?php if($nome==""){ ?>                                                                  
                                                                  <input type="button" style="background-color: red;" id="1" value="<?php echo $index ?>" onclick="abreEnvio()">
                                                                    <div hidden style="height: 150px; width: 500px" id="abreenvio">
                                                                      <form action="../ajax/ajax_editar_conta.php" method='POST' enctype="multipart/form-data" >
                                                                          <input type="hidden" name="enviacomprovante">
                                                                          <input type="hidden" name="id" value="<?php echo $value->id; ?>">
                                                                          <input type="hidden" name="parcela" value="<?php echo $index; ?>">
                                                                            <div class="col-5">
                                                                                <div class="item">
                                                                                    <label>Data do pagamento: </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <div class="item">
                                                                                    <input type="date" name='data' id="data">
                                                                                </div>
                                                                            </div>
                                                                           <div class="col-10">
                                                                                <div class="item"><label>Enviar Comprovante: </label><input type="file" name="arquivo" id='arquivo'></div>                                                                                
                                                                            </div>
                                                                          <div class="col-10">
                                                                                <div class="item">
                                                                                    <input type="submit" class="button" id="salvar" value="Enviar">
                                                                                </div>
                                                                            </div>
                                                                      </form>
                                                                  
                                                                  </div>
                                                            
                                                                <?php } ?>                                                             
                                                                        
                                                                           <?php                                                                           
                                                                        }
                                                                        
                                                                    }
       //                                                                   
                                                            ?> 
                                                        </div>
                                                        <div class="col-10">
                                                            <label>Clique para visualizar o comprovante...</label>
                                                        </div>
                                                 </div>
                                             </div>
                                         </div>
                                         
                                         
                                         
                                         
                                         
                                         

                                        <?php } if(isset($value->status) && $value->status == 1 && isset($value->tipo) && $value->tipo == 2){?> 
                                                                           <div class="row">
                                             <div class="col-10">
                                                 <div class="item">
                                                     <div class="col-2">Parcelas: </div>
                                                         <div class="col-8">    
                                                            <?php                                                                        
                                                                $parcelas = new Parcelas();
                                                                $p = $parcelas->get_parcelas_pagas($value->id);
                                                                    for($index = 1; $index <= $value->parcelas; $index++){
                                                                        $num = confere($index, $value->id);                                                                       
                                                                        if($num == $index){
                                                                           $nome = $c = $parcelas->get_comprovante($value->id, $num);
                                                                           $envia = $value->id.':'.$nome.':'.$_SESSION['id_empresa'];
                                                                           ?>
                                                                <?php if($nome!=""){ ?>                                                                  
                                                                  <input type="button" id="1" value="<?php echo $index ?>" onclick="visualizaComprovante('<?php echo $envia; ?>')">
                                                                <?php } ?>
                                                                <?php if($nome==""){ ?>                                                                  
                                                                  <input type="button" style="background-color: red;" id="1" value="<?php echo $index ?>" onclick="abreEnvio()">
                                                                    <div hidden style="height: 150px; width: 500px" id="abreenvio">
                                                                      <form action="../ajax/ajax_editar_conta.php" method='POST' enctype="multipart/form-data" >
                                                                          <input type="hidden" name="enviacomprovante">
                                                                          <input type="hidden" name="id" value="<?php echo $value->id; ?>">
                                                                          <input type="hidden" name="parcela" value="<?php echo $index; ?>">
                                                                            <div class="col-5">
                                                                                <div class="item">
                                                                                    <label>Data do pagamento: </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <div class="item">
                                                                                    <input type="date" name='data' id="data">
                                                                                </div>
                                                                            </div>
                                                                           <div class="col-10">
                                                                                <div class="item"><label>Enviar Comprovante: </label><input type="file" name="arquivo" id='arquivo'></div>                                                                                
                                                                            </div>
                                                                          <div class="col-10">
                                                                                <div class="item">
                                                                                    <input type="submit" class="button" id="salvar" value="Enviar">
                                                                                </div>
                                                                            </div>
                                                                      </form>
                                                                  
                                                                  </div>
                                                            
                                                                <?php } ?>                                                             
                                                                        
                                                                           <?php                                                                           
                                                                        }
                                                                        
                                                                    }
       //                                                                   
                                                            ?> 
                                                        </div>
                                                        <div class="col-10">
                                                            <label>Clique para visualizar o comprovante...</label>
                                                        </div>
                                                 </div>
                                             </div>
                                         </div>
                                                        
                                        <?php } ?>   
                                         <div class="col-5">
                                            <div class="item"><label>Parcelas: <?php echo $value->parcelas ?></label></div>
                                        </div> 
                                       
                                                        
                                        <div class="col-10">
                                            <div class="item"><label>Descrição: </label></div>
                                        </div>  
                                        <div class="col-10">
                                            <div class="item"><textarea style="position:relative; z-index: 200;" row="2" cols="50"> <?php echo $value->descricao ?> </textarea></div>
                                        </div>
                                     </div>
                                 </div>
                                        <?php
                                        if(isset($value->status) && $value->status == 0 && isset($value->tipo) && $value->tipo == 1){?>
                                        <form action="../ajax/ajax_editar_conta.php" method='POST' enctype="multipart/form-data" >
                                            <input type="hidden" name="parcela" id="parcela" value="parcela">
                                            <input type="hidden" name="id" id="id" value="<?php echo $value->id; ?>">
                                         
                                            <div class="row">                                                 
                                                <div style="margin-left: 0px; padding-top: 10px; padding-left: 20px; background-color: rgba(50,200,50,0.6);" class="center">   
                                                    
                                                     <div class="col-10"><div class="item"><label>Adicionar à contas pagas</label></div></div>
                                                <div class="row"> 
                                                    <div  class="row">
                                                     <div><div class="item"><label>Data do pagamento:</label> <input type="date" name='data' id="data"></div></div>
                                                        <div class="col-2" style="width: 15%;">                                                     
                                                            <div class="item"><label>Pagar parcela: </label>                                                    
                                                                <select id="parcela_n" name="parcela_n">       
                                                                             <?php                                                                        
                                                                        $parcelas = new Parcelas();
                                                                        $p = $parcelas->get_parcelas_pagas($value->id);
                                                                        for($index = 1; $index <= $value->parcelas; $index++){
                                                                            $num = confere($index, $value->id);
                                                                            if($num != $index){
                                                                                echo '<option value='.$index.'>'.$index.'</option>';
                                                                            }
                                                                        }
//                                                                   
                                                                        ?> 
                                                                </select> 
                                                            </div>
                                                            
                                                        </div> 
                                                      
                                                     <div class="col-5">
                                                         <div class="item"><label>Comprovante: </label><input type="file" name="arquivo" id='arquivo'></div>
                                                     </div>
                                                     </div>
                                                     <div class="col-10"><div class="row"><div  class="col-2"><label>Parcelas pagas: </label></div>
                                                 
                                                        <div class="col-8">    
                                                            <?php                                                                        
                                                                $parcelas = new Parcelas();
                                                                $p = $parcelas->get_parcelas_pagas($value->id);
                                                                    for($index = 1; $index <= $value->parcelas; $index++){
                                                                        $num = confere($index, $value->id);                                                                       
                                                                        if($num == $index){
                                                                           $nome = $c = $parcelas->get_comprovante($value->id, $num);
                                                                           $envia = $value->id.':'.$nome.':'.$_SESSION['id_empresa'];
                                                                           ?>
                                                                <?php if($nome!=""){ ?>                                                                  
                                                                  <input type="button" id="1" value="<?php echo $index ?>" onclick="visualizaComprovante('<?php echo $envia; ?>')">
                                                                <?php } ?>
                                                                <?php if($nome==""){ ?>                                                                  
                                                                  <input type="button" style="background-color: red;" id="1" value="<?php echo $index ?>" onclick="abreEnvio()">
                                                                    <div hidden style="height: 150px; width: 500px" id="abreenvio">
                                                                      <form action="../ajax/ajax_editar_conta.php" method='POST' enctype="multipart/form-data" >
                                                                          <input type="hidden" name="enviacomprovante">
                                                                          <input type="hidden" name="id" value="<?php echo $value->id; ?>">
                                                                          <input type="hidden" name="parcela" value="<?php echo $index; ?>">
                                                                            <div class="col-5">
                                                                                <div class="item">
                                                                                    <label>Data do pagamento: </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <div class="item">
                                                                                    <input type="date" name='data' id="data">
                                                                                </div>
                                                                            </div>
                                                                           <div class="col-10">
                                                                                <div class="item"><label>Enviar Comprovante: </label><input type="file" name="arquivo" id='arquivo'></div>                                                                                
                                                                            </div>
                                                                          <div class="col-10">
                                                                                <div class="item">
                                                                                    <input type="submit" class="button" id="salvar" value="Enviar">
                                                                                </div>
                                                                            </div>
                                                                    
                                                                  </div>
                                                            
                                                                <?php } ?>                                                             
                                                                        
                                                                           <?php                                                                           
                                                                        }
                                                                        
                                                                    }
       //                                                                   
                                                            ?> 
                                                        </div>
                                                    </div>
                                                     </div>
                                                     </div>
                                                     <div class="row">
                                                        <div class="col-10">
                                                            <div class="item">
                                                                <input type="submit" class="button" id="salvar" value="salvar">
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                        <?php } if(isset($value->status) && $value->status == 0 && isset($value->tipo) && $value->tipo == 2){?>
                                        <form action="../ajax/ajax_editar_conta.php" method='POST' enctype="multipart/form-data" >
                                            <input type="hidden" name="parcela" id="parcela" value="parcela">
                                            <input type="hidden" name="id" id="id" value="<?php echo $value->id; ?>">
                                         
                                            <div class="row">                                                 
                                                <div style="margin-left: 0px; padding-top: 10px; padding-left: 20px; background-color: rgba(50,200,50,0.6);" class="center">   
                                                    
                                                     <div class="col-10"><div class="item"><label>Adicionar à contas recebidas</label></div></div>
                                                <div class="row"> 
                                                    <div  class="row">
                                                     <div><div class="item"><label>Data do pagamento:</label> <input type="date" name='data' id="data"></div></div>
                                                        <div class="col-2" style="width: 15%;">                                                     
                                                            <div class="item"><label>Pagar parcela: </label>                                                    
                                                                <select id="parcela_n" name="parcela_n">       
                                                                             <?php                                                                        
                                                                        $parcelas = new Parcelas();
                                                                        $p = $parcelas->get_parcelas_pagas($value->id);
                                                                        for($index = 1; $index <= $value->parcelas; $index++){
                                                                            $num = confere($index, $value->id);
                                                                            if($num != $index){
                                                                                echo '<option value='.$index.'>'.$index.'</option>';
                                                                            }
                                                                        }
//                                                                   
                                                                        ?> 
                                                                </select> 
                                                            </div>
                                                            
                                                        </div> 
                                                      
                                                     <div class="col-5">
                                                         <div class="item"><label>Comprovante: </label><input type="file" name="arquivo" id='arquivo'></div>
                                                     </div>
                                                     </div>
                                                     <div class="col-10"><div class="row"><div  class="col-2"><label>Parcelas pagas: </label></div>
                                                 
                                                        <div class="col-8">    
                                                            <?php                                                                        
                                                                $parcelas = new Parcelas();
                                                                $p = $parcelas->get_parcelas_pagas($value->id);
                                                                    for($index = 1; $index <= $value->parcelas; $index++){
                                                                        $num = confere($index, $value->id);                                                                       
                                                                        if($num == $index){
                                                                           $nome = $c = $parcelas->get_comprovante($value->id, $num);
                                                                           $envia = $value->id.':'.$nome.':'.$_SESSION['id_empresa'];
                                                                           ?>
                                                                <?php if($nome!=""){ ?>                                                                  
                                                                  <input type="button" id="1" value="<?php echo $index ?>" onclick="visualizaComprovante('<?php echo $envia; ?>')">
                                                                <?php } ?>
                                                                <?php if($nome==""){ ?>                                                                  
                                                                  <input type="button" style="background-color: red;" id="1" value="<?php echo $index ?>" onclick="abreEnvio()">
                                                                    <div hidden style="height: 150px; width: 500px" id="abreenvio">
                                                                      <form action="../ajax/ajax_editar_conta.php" method='POST' enctype="multipart/form-data" >
                                                                          <input type="hidden" name="enviacomprovante">
                                                                          <input type="hidden" name="id" value="<?php echo $value->id; ?>">
                                                                          <input type="hidden" name="parcela" value="<?php echo $index; ?>">
                                                                            <div class="col-5">
                                                                                <div class="item">
                                                                                    <label>Data do pagamento: </label>
                                                                                </div>
                                                                            </div>
                                                                            <div class="col-3">
                                                                                <div class="item">
                                                                                    <input type="date" name='data' id="data">
                                                                                </div>
                                                                            </div>
                                                                           <div class="col-10">
                                                                                <div class="item"><label>Enviar Comprovante: </label><input type="file" name="arquivo" id='arquivo'></div>                                                                                
                                                                            </div>
                                                                          <div class="col-10">
                                                                                <div class="item">
                                                                                    <input type="submit" class="button" id="salvar" value="Enviar">
                                                                                </div>
                                                                            </div>
                                                                    
                                                                  </div>
                                                            
                                                                <?php } ?>                                                             
                                                                        
                                                                           <?php                                                                           
                                                                        }
                                                                        
                                                                    }
       //                                                                   
                                                            ?> 
                                                        </div>
                                                    </div>
                                                     </div>
                                                     </div>
                                                     <div class="row">
                                                        <div class="col-10">
                                                            <div class="item">
                                                                <input type="submit" class="button" id="salvar" value="salvar">
                                                            </div>
                                                        </div>  
                                                    </div>
                                                </div>
                                            </div>
                                        </form>
                                       <?php } ?>                                  
                            </div>                        
                        </div>
                   
                       <?php } ?>
                   <div style="float: left;"><input type="button" class="button" value="Voltar" style="color: floralwhite" id="back"></div><div style="float:right"><input type="button" style="color: floralwhite" class="button" value="proximo" id="next"></div>
                   <?php    
                            
                            echo '<script>paginar('.$i.','.'2'.')</script>';
                     ?>
                   
    </div>
    <?php
    }
   ?>


