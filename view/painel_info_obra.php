<?php if(isset($_SESSION['obra']['dados'])){ ?>
<div class="content-right">
         <div class="box-atrasos">
          <div style="float:left;width:100%"><div style="float:left"><img src="../images/info.png" width="50px" style="margin-left:5px; margin-top:-20px;margin-left:-20px; "></div><div style="float:left; margin-top:10px; margin-left:10px; "><span style="width:120px" class="title"><b>Informações Obra</b></span></div></div>
<?php    // print_r($_SESSION['obra']['cliente']);

      if (isset($_SESSION['obra']['dados'])){
        $obras = $_SESSION['obra']['dados'];
            ?>
            <div clas="msg-descricao"><span style="color: #003300;"> <b>Dados da Obra</b></span></div>
            <div class="descricao" id="nome">                 <span>Nome:           </span><span>                 <?php echo $obras['nome'];                 if($obras['nome']==""){echo "<script>hidden('nome')</script>";}?></span></div>
            <div class="descricao" id="data_inicio_previsto"> <span>Data de Início: </span><span>                 <?php echo $obras['data_inicio_previsto']; if($obras['data_inicio_previsto']==""){echo "<script>hidden('data_inicio_previsto')</script>";}?></span></div>            
            <div class="descricao" id="localizacao">        <span>Coordenadas:      </span><span>                 <?php echo "Lat: ".$obras['lat']." | Long: ".$obras['long']; if($obras['lat']==""){echo "<script>hidden('localizacao')</script>";}?></span><img title="Ver mapa !" style="float:left; cursor: pointer; " width="36px" height="25px" onclick="mostraLocal()" src="../images/local.png"></div>
            <input type="hidden" id="lat" value="<?php (isset($obras['lat']))?print $obras['lat']:''; ?>">
            <input type="hidden" id="long" value="<?php (isset($obras['long']))?print $obras['long']:''; ?>">
            <div class="descricao" id="desc" style="border:0"><span>Descrição:      </span><textarea readonly type="text" id="desc" ><?php echo $obras['desc'];?></textarea><?php if($obras['desc']==""){echo "<script>hidden('desc')</script>";} ?></div>
            
            <?php 
      }else{
            ?>

            <div clas="msg-descricao"><span style="color: #003300;"> <b>Sem informações</b></span><br><a href="http://localhost/viacampos/administrator/add_obra?t=a_c_o"><img style="width:25px;"src = "../images/add.png"></a></div>
            
            <?php 
      }

      if(isset($_SESSION['obra']['funcionario'])){
        $funcionario = $_SESSION['obra']['funcionario'];
        ?>
            <div class="msg-descricao"><span style="color: #003300;float:left; margin-left:10;"><b>Funcionários</b></span></div>
            <div class="msg-descricao"><a style="font-size:14px; cursor:pointer" name="popup" onclick="exibe(this.name)" >Expandir</a></div>
        <?php 
      }

      if (isset($_SESSION['obra']['patrimonio'])){
           for($aux = 0; $aux < 1; $aux++){
            ?>
            <div class="msg-descricao"><span style="margin-left:10; color: #003300;float:left;"><b>Patrimonio</b></span></div>
            <div class="msg-descricao"><a style="font-size:14px;cursor:pointer" name="popup-patrimonio" onclick="exibe(this.name)">Expandir</a></div>
            <?php  
           }
                                                                                
      }

      if (isset($_SESSION['obra']['cliente'])){
        $cliente = $_SESSION['obra']['cliente'];
        ?>
            <div class="msg-descricao"><span style="color: #003300;"><b>Dados do cliente vinculado à obra</b></span></div>
            <div class="descricao" id="nome_cli"><span>Cliente: </span><span type="text" id="rua" ><?php echo $cliente['nome_cli'];                 if($cliente['nome_cli']==""){echo "<script>hidden('nome_cli')</script>";}?></span></div>
            <div class="descricao" id="telefone_com"><span>Telefone: </span><span type="text" id="telefone_com"><?php echo $cliente['telefone_com'];    if($cliente['telefone_com']==""){echo "<script>hidden('telefone_com')</script>";}?></span></div>            
            
        <?php
      }
      ?>
        </div>
</div>


<!-- popup -->
      <div id="popup" class="popup-painel" style="float:left">
                      
                  <!-- eSTRUTURA DE REPETIÇÃO PARA ALIMENTAR OS NOMES E INFORMAÇÕES DO FUNCIONARIO -->
                  <?php  
                  if(isset($_SESSION['obra']['funcionario'])){
                   for($aux = 0; $aux < count($funcionario); $aux++){
                      
                    $res = Funcionario::get_func_id($funcionario[$aux]);          
                    ?>          
                            <div class="colum-funcionario"><input readonlytype="text" value="<?php  echo $res->nome; ?>"><a href="pesquisa_func?verificador=1&id=<?php echo $res->id ?>">Detalhes</a></div>
                           
                      <?php } ?>
                    <?php } ?>  
                            <tr><td><input onclick="fechar_patrimonio(this.name)" name="popup" type="button" class="button" style="clear: both; float:left; margin-top:10px;" value="Concluir"></td></tr>
      </div>


      <div id="popup-patrimonio" class="popup-painel" style="float:left">
          
       <?php  
        if (isset($_SESSION['obra']['patrimonio'])) {
           for($aux = 0; $aux < count($_SESSION['obra']['patrimonio']); $aux++){
                       $tipo_id_qtd = explode(':', $_SESSION['obra']['patrimonio'][$aux]);                                               
                                                 if($tipo_id_qtd[0] == 0){
                                                  $res = Patrimonio_geral::get_patrimonio_geral_id($tipo_id_qtd[1]);
                                                  echo '<div class="colum-funcionario"><input style="font-weight:bold" readonly type="text" value="Geral" >  <input readonly type="text" value="'.$res->nome.'"><a id="patrimonio" href="pesquisa_patrimonio?verificador=1&id='.$res->id.'&controle=0">detalhes</a>  </div>';                                                  
                                                 }else if($tipo_id_qtd[0] == 1){
                                                  $res = Maquinario::get_maquinario_id($tipo_id_qtd[1]);
                                                  echo '<div class="colum-funcionario"> <input style="font-weight:bold" readonly type="text" value="Maquinário" >  <input readonly type="text" value="'.$res->modelo.'"><a id="patrimonio" href="pesquisa_patrimonio?verificador=1&id='.$res->id.'&controle=1">detalhes</a>  </div>';
                                                 }else{
                                                  $res = Veiculo::get_veiculo_id($tipo_id_qtd[1]);
                                                  echo '<div class="colum-funcionario"><input style="font-weight:bold" readonly type="text" value="Veículo">  <input readonly type="text" value="'.$res->modelo.'"><a id="patrimonio" href="pesquisa_patrimonio?verificador=1&id='.$res->id.'&controle=2">detalhes</a>  </div>';
                                                 }
                                               }
        }      
         ?>          
                 <tr><td><input name="popup-patrimonio"  onclick="fechar_patrimonio(this.name)" type="button"  class="button" style="clear: both; float:left; margin-top:10px;" value="Concluir"></td></tr>
      </div>
        <!-- fimpopup -->
<?php } ?>