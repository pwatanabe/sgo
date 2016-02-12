<?php
session_start();
include_once("../includes/functions.php");
include_once("../model/class_cliente.php");
include_once("../model/class_conta_bd.php");
include_once("../model/class_parcelas_bd.php");
include_once("../includes/util.php");
include_once("../model/class_obra.php");

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
                        if (move_uploaded_file($_FILES['arquivo']['tmp_name'], $uploadfile)){
                                    echo "Arquivo válido e enviado com sucesso.\n";  
                                    echo '<script>window.location = "../administrator/add_contas"</script>'; 
                         }
                                    
                         
                   }                   
             }

    if(isset($_POST['enviacomprovante'])){
      
        $parcelas = new Parcelas();        
        $parcelas->updateComprovante($_POST['id'],$_POST['parcela_n'],$nome_comprovante);
        echo '<script>window.location = "../administrator/add_contas"</script>';
   
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
                                                   
                         $parcelas->add_parcelas_bd();
                           
                         echo '<script>window.location = "../administrator/add_contas"</script>';  

 }
       
     
              
                
    
    if(isset($_GET['tipo'])){
    ?> 
<div id="visualizar-conta">
    <script>
    function ver_parc(id){
        $("#parcelas"+id).fadeToggle();
    }    
       
   
    </script>
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
                    $style2 = 'background-color: rgba(25,100,25,0.3);';
                    $i = 0;
                    ?>
                   
                   <?php foreach ($conta as $key => $value) {
                    if($value->status != 1){                       
                       $parcelas = new Parcelas();                      
                        $row = $parcelas->confere_kitacao($value->id);
                         if($row == 0){
                                $conta = new Contas();
                                $conta->set_conta_paga($value->id);                              
                         continue;
                         } 
                     }
                     
                     
                    $i++;                 
                    $clis = new Cliente();
                    $cli = $clis->get_all_cli_by_id($value->fornecedor_cliente);
                    if($value->tipo_a_p_r == 1){
                            if($cli[1]== ""){
                            $cli[1]= 'Sem Fornecedor';
                        }
                    }else{
                            if($cli[1]== ""){
                            $cli[1]= 'Sem Cliente';
                        }
                    }
                   ?>
                    
          
                
    
                    
                    <div id="contas" class="tabela-contas-apagar" style="<?php  if($i % 2 == 1){echo $style1;}else{ echo $style2;} ?> ">                               
                        <div  id="<?php echo $i ?>" >                             
                            <input type="hidden" id="id" name="id" value="<?php echo $value->id ?>">
                                <div  class="row">                                     
                                    <div  class="center">
                                         <div class="col-5">
                                             <div class="item"><label>Cod: </label><label><?php echo $value->codigo  ?></label></div>
                                         </div>
                                         <div class="col-5"><div class="item">
                                            <?php if($value->tipo_a_p_r == 1){ echo "<label>Fornecedor: </label> "; }else{ echo "<label>Cliente: </label>"; } ?>
                                                 
                                            <label><?php echo $cli[1]; ?></label></div>
                                             
                                         </div>
                                         <div class="col-5">
                                             <div class="item"><label>Valor: </label> <label><?php echo 'R$ '.number_format($value->valor, 2, ',', '.') ?></label> </div>
                                         </div>     
                                          <div class="col-3">
                                             <div class="item"><label>Juros: </label> <label><?php echo $value->juros.'('.$value->periodo_juros.')'; ?></label> </div>
                                         </div>
                                        
                                    </div>
                                </div>
                            <div class="row">
                                     <div class="center">                                         
                                          <div class="col-5">
                                             <div class="item"><label>Banco: </label> <label><?php echo $value->banco ?></label></div>
                                        </div>
                                        <div class="col-5">
                                                    <?php
                                                    $obra = new Obra();
                                                    if($value->obra == 0){
                                                        $obra->nome = "Obra não foi relacionada !";
                                                    }else{
                                                    $obra = $obra->getObraId($value->obra);
                                                    }
                                                    ?>
                                             <div class="item"><label>Obra: </label><label><?php echo $obra->nome; ?></label></div>
                                        </div>
                                         <div class="col-10">
                                             <div class="item"><textarea style="min-height: 60px; max-height: 150px; min-width:290px; max-width: 290px;" name="observacao" id="observacao" placeholder="Conta paga antecipada.. atrasada.. e informações gerais." ><?php echo $value->descricao ?></textarea></div>
                                         </div>
                                         
                                         <input style="border-radius: 5px; cursor: pointer; border: 0; box-shadow: 0px 5px 5px 0px rgba(0,0,0,0.75); margin:10px; width: 150px; height: 30px;" type="button" onclick="ver_parc(<?php echo $value->id; ?>)" id="ver_parc" value="Parcelas">
                                         
                                     <div id="<?php echo "parcelas".$value->id; ?>" hidden="on">
                                         
                                        <?php 
                                        
                                        $parcelas = new Parcelas();
                                        $lista = array();
                                        $p = $parcelas->get_parcelas($value->id);
                                        $color = "background-color: #cccccc";   $color2 = "background-color: #00ba65"; $j = 1;
                                                
                                        if($p != ""){
                                         
                                            echo ' <div class="col-10">
                                             <div class="item"><label>Escolha um arquivo e envie para deixar a data paga: </label></div>
                                             </div>';
                                        foreach ($p as $key => $parc) {
                                        
                                                ?>
                                        <div class="col-4" style="<?php if($parc['status']== 0){  echo $color;}else{echo $color2;} ?>; margin: 10px; padding: 5px; border:solid 1px;">
                                             <form action="../ajax/ajax_editar_conta.php" method='POST' enctype="multipart/form-data" >        
                                                     <table style="margin: 10px;">
                                                           <input type="hidden" name="enviacomprovante">
                                                           <input type="hidden" name="id" value="<?php echo $value->id; ?>">
                                                        <tr><td><label>Parcela: </label></td><td><input style="background-color: #cccccc; border: 0; " name="parcela_n" type="text" readonly value="<?php echo $parc['parcela_n']; ?>"></td></tr>
                                                        <tr><td><label>Data: </label></td><td><input style="background-color: #cccccc; border: 0; " name="data" readonly type="text" value="<?php echo data_padrao_brasileiro($parc['data']); ?>"></td><tr>
                                                        
                                                        
                                                        <tr><td><label>Comprovante: </label></td><td><input type="file" name="arquivo" id='arquivo'></td></tr>                                                        
                                                       <?php if($parc['comprovante'] != ""){ ?>
                                                        <tr><td><input type="button" value="Ver Comprovante" id="1" onclick="visualizaComprovante('<?php echo $value->id.":".$parc['comprovante'].":".$_SESSION['id_empresa']; ?>')"></td>          
                                                        <?php }?>                                                            
                                                        <?php if($parc['status'] !=  1){ ?>
                                                        <tr><td><input type="submit" id="salvar" value="Pagar"></td></tr>
                                                        <?php }else { ?>
                                                        <td><input type="submit" id="att" value="Atualizar"></td></tr>
                                                        <?php }?>
                                                    </table>
                                              </form>
                                        </div>
                                   
                                         
                                                <?php  $j++; }}  ?> 
                                       
                                           </div>    
                                         
<!--                                         <div class="col-5">
                                             <div class="item"><label>Data de vencimento: </label> <label><?php ?></label></div>
                                        </div>-->
                                         
                                         
                                         
                                         
                                       
                                         
                                     </div>   
                               </div>          
                                                            
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


