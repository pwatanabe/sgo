<?php
//CLIENTE > DADOS DA OBRA > PRODUTOS > MATERIAIS > PATRIMONIOS > FUNCIONARIOS
include("restrito.php"); 

include_once("../model/class_sql.php");
include_once("../model/class_grupo_bd.php");
include_once("../model/class_maquinario_bd.php");
include_once("../model/class_veiculo_bd.php");
include_once("../model/class_patrimonio_geral_bd.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_produto_bd.php");
include_once("../model/class_cbo_bd.php");
include_once("../model/class_estado_bd.php");
include_once("../includes/functions.php");
include_once("../includes/util.php");
include_once("../model/class_regiao_bd.php");
include_once("../model/class_obra.php");

function validate(){
   if(!isset($_POST['desc']) || $_POST['desc'] == ""){
        return false;
   	}
   		return true;
}
 ?>

<html>

<?php Functions::getHead('Adicionar'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
	<script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
	<link rel="stylesheet" type="text/css" href="styles/style.css">

</head> -->

<script type="text/javascript">
    function expandir_ocultar(id){
      var id_box = 'id-'+id;
      var campodateini = 'dateini-'+id;
      var campodatefim = 'datefim-'+id;
      var select = 'etapa-'+id;

      if(document.getElementById(id_box).style.display == 'none'){
        document.getElementById(id_box).style.display = '';
        document.getElementById(campodateini).disabled = true;
        document.getElementById(campodatefim).disabled = true;
        document.getElementById(select).disabled = true;
      }else{
        document.getElementById(id_box).style.display = 'none';
        document.getElementById(campodateini).disabled = false;
        document.getElementById(campodatefim).disabled = false;
        document.getElementById(select).disabled = false;
      }
    }
    function preencheCronograma(id_produto){
        var data_i = document.getElementById("dateini-"+id_produto).value;
        var data_f = document.getElementById("datefim-"+id_produto).value;
        var etapa = document.getElementById("etapa-"+id_produto).value;
        var url = '../ajax/ajax_cronograma.php?id_produto='+id_produto+'&data_ini='+data_i+'&data_fim='+data_f+'&etapa='+etapa;
                  $.get(url, function(dataReturn) {
                    $('#result-ajax').html(dataReturn);
                        // window.location.href='add_func.php';
                  });

        // var data_i = document.getElementById("dateini-"+id_produto).value;
        // var data_f = document.getElementById("datefim-"+id_produto).value;

        // data_fim = data_f.split('-');
        // data_ini = data_i.split('-');

        // date_comp_fim = new Date(data_fim[0], data_fim[1], data_fim[2]);
        // date_comp_ini = new Date(data_ini[0], data_ini[1], data_ini[2]);

        // var verdadeiro = true;
        // var cont = 0;
        // while(verdadeiro){
        //     if(date_comp_ini.getTime() <= date_comp_fim.getTime()){

        //         date_id = date_comp_ini.getFullYear();
                
        //         if(date_comp_ini.getMonth() < 10){
        //             date_id += '-0'+date_comp_ini.getMonth();
        //         }else{
        //             date_id += '-'+date_comp_ini.getMonth();
        //         }

        //         if(date_comp_ini.getDate() < 10){
        //             date_id += '-0'+date_comp_ini.getDate();
        //         }else{
        //             date_id += '-'+date_comp_ini.getDate();
        //         }

        //         document.getElementById(id_produto+'-'+date_id).style.backgroundColor = '';
        //         document.getElementById(id_produto+'-'+date_id).style.borderRadius = '';

        //         document.getElementById(id_produto+'-'+date_id).style.backgroundColor = 'rgba(0, 100, 0, 0.71)';
                
        //         if(cont == 0){
        //             document.getElementById(id_produto+'-'+date_id).style.borderRadius = "8px 0px 0px 8px";
        //         }
        //         // alert(date_id)
        //         cont++;
        //         // date_comp_ini.setDate(SomarData(date_comp_ini,1));
        //         // alert(date_comp_ini +' ' +date_comp_ini.getTime()+(86400*1000));
        //         date_comp_ini.setTime(date_comp_ini.getTime()+(86400*1000));
        //     }else{
        //         verdadeiro = false;
        //         document.getElementById('tr-'+id_produto).title = "INFORMAÇÕES DA TAREFA\nData de inicio: " + data_i + "\nData Final: "+data_f+" \nEssa tarefa levará "+cont+" dia(s) para ficar pronta";
                
        //         document.getElementById(id_produto+'-'+date_id).style.borderRadius = "0px 8px 8px 0px";

        //         if(cont == 1){
        //             document.getElementById(id_produto+'-'+date_id).style.borderRadius = "8px 8px 8px 8px"; 
        //         }
        //     }
        // }
        

    }
     // mascaras
          function mascara(o,f){
              v_obj=o
              v_fun=f
              setTimeout("execmascara()",1) 
          }
          function execmascara(){
              v_obj.value=v_fun(v_obj.value)
          }
          function date(v){
               if(v.length >=10){      
                 v = v.substring(0,(v.length - 1));
                 return v;
               }
               v=v.replace(/\D/g,""); 
               v=v.replace(/^(\d{2})(\d{2})(\d{4})/,"$3-$2-$1");  
               return v;
           }
           
           function id( el ){
             return document.getElementById( el );
           }
           function exeMasc(){ 
              id('data_inicio_previsto').onkeypress = function(){ 
                  mascara( this, date );
              }
           }
          // fim mascaras
    function submeter(){
      qtd = document.getElementById('etapas').value;
      window.location = 'add_obra.php?t=a_cr_o&etapas=' + qtd;
    }
</script>

<?php  Functions::getScriptObra(); ?>



<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDPnNgPERfFRTJYYW4zt9lZ0njBseIdi1I&callback=initMap" async defer></script>

<body onload="exeMasc()">	
			<?php include_once("../view/topo.php"); ?>


            <div style="margin-left: -800px; transition-duration: 0.8s; position: absolute; width:700px; height: 500px; z-index: 2; border: 1px solid#fff" id="map"></div>    
  

            <div class="formulario" style="width:43%;" id="form_obra">
              <div class="title-box" style="float:left;width:100%"><div style="float:left"><img src="../images/add.png" width="35px" style="margin-left:5px;"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">NOVA OBRA</span></div></div>
              
              <div id="popup" class="popup" style="float:left; width:380px; position:absolute">
                   <div class="formulario" style="width:300px; min-width:300px; max-height:450px; overflow-y:scroll">
                     <table style="width:100%; text-align:center;" border="0">
                        <!-- <input type="hidden" id="id_banco" name="id_banco" value="<?php echo $banco->id ?>"> -->
                        <tr><td colspan='2'><b>Materiais</b></td></tr>
                        <tr><td colspan='2'><input onclick="fechar()" type="button"  class="button" value="Concluir" ></td></tr>
                      </table>
                   </div>
              </div>
              
              <?php 
                    if(isset($_GET['t']) && $_GET['t'] == 'c'){
                        unset($_SESSION['obra']);
                        echo '<div class="msg">
                                  <form  action="add_obra">
                                    <input type="hidden" id="t" name="t" value="a_c_o">
                                    Cadastramento cancelado!<br /><br />
                                    <input type="submit"  value="Nova Obra" class="button"> <input type="button" onclick="window.location.href=\'principal\'" value="Início" class="button">
                                  </form> 
                              </div>';
                    }
               ?>
            <?php if(isset($_GET['t']) && $_GET['t'] == 'a_c_o'){ // add clientes da obra?>
            	         <?php 
                          $_SESSION['obra']['status'] = 0; 
                          $_SESSION['obra']['situacao_cadastramento'] = 'a_c_o';
                        ?>
                       <form  action="add_obra" onsubmit="return validate(this)">

                        
                              <input type="hidden" id="t" name="t" value="a_d_o">

                              <div class="bloco-1" id="dados_obra">            
                                  <!-- <div class="ativo"><div class="ativo-text">Cadastre os dados da obra</div></div> -->
                              		<?php include_once("../view/sub-menu-obra.php"); ?>

                                  <div class="desc-bloco">
                                      <span>Selecione o cliente </span>
                                  </div>
                                  <div class="body-bloco">
                                      <div class="form-input left">
                                          <div class="form-input">
                                              <span><b>Nome/Razao Social: </b></span><input type="text" placeholder="Digite para pesquisar..." id="nome" style="width:65%"> <input type="button" value="Buscar" onclick="buscarClientes()">
                                          </div>
                                          <div class="form-input" id="form-input-select" style="border: 1px solid#bbb; height:200px;">
                                              <select size="10" style="height: 100%; width: 100%">
                                              </select>
                                          </div>
                                          <div class="form-input">
                                              <span style="color:#787878; font-size:12px;">(Clique para selecionar)</span>
                                          </div>
                                      </div>
                                      <div class="form-input right">
                                          <div class="form-input">
                                              <span><b>Dados do cliente selecionado: </b></span>
                                          </div>
                                          <div class="form-input" id="form-input-dados" style="border: 1px solid#bbb; height:200px; padding: 10px;">
                                              <input type="hidden" name="id_cli" value="<?php (isset($_SESSION['obra']['cliente']['id_cli']))?print $_SESSION['obra']['cliente']['id_cli']:''; ?>">
                                              <span><b>Nome/Razao Social:</b></span><input readonly  name="nome_cli" id="nome_cli" type="text" style="border: 0; width: 100%; height: 20px; padding-left:20px;" value="<?php (isset($_SESSION['obra']['cliente']['nome_cli']))?print $_SESSION['obra']['cliente']['nome_cli']:''; ?>"><br />
                                              <span><b>CPF/CNPJ:</b></span><input readonly  name="cpf_cnpj_cli" id="cpf_cnpj_cli" type="text" style="border: 0; width: 100%; height: 20px; padding-left:20px;" value="<?php (isset($_SESSION['obra']['cliente']['cpf_cnpj_cli']))?print $_SESSION['obra']['cliente']['cpf_cnpj_cli']:''; ?>"><br />
                                              <span><b>Endereço:</b></span><input style="border: 0px; width: 100%;height: 20px; padding-left:20px;" readonly  name="rua" id="rua" type="text" value="<?php (isset($_SESSION['obra']['cliente']['rua']))?print $_SESSION['obra']['cliente']['rua']:''; ?>"><br />
                                              <span><b>Nº:</b></span><input style="border: 0px; width: 100%; height:20px; padding-left:20px;" readonly  name="num" id="num" type="text" style="border: 0; width:100%; height: 20px;"value="<?php (isset($_SESSION['obra']['cliente']['num']))?print $_SESSION['obra']['cliente']['num']:''; ?>"><br />
                                              <span><b>Telefone:</b></span><input style="border: 0px; width: 100%; height:20px; padding-left:20px;" readonly  name="telefone_com" id="telefone_com" type="text" style="border: 0; width:100%"value="<?php (isset($_SESSION['obra']['cliente']['telefone_com']))?print $_SESSION['obra']['cliente']['telefone_com']:''; ?>"><br />
                                          </div>
                                      </div>
                                      
                                      <div class="form-input" style="margin: 10px; text-align:center;  width:97%">
                                         <!-- <input type="button"  onclick="javascript:window.history.back()" class="voltar" value="Voltar"> --> <input class="avancar" type="submit" value="Avançar">
                                      </div>
                                  </div>
                              </div>
                              <div class="form-input">
                                    <div class="buttons">
                                        <!-- <input type="submit" name="button" class="button" id="button" value="Cadastrar"> --> <input type="button" name="button" class="button" onclick="cancel()" id="button" value="Cancelar">
                                    </div>
                              </div>
                       </form>          
                       
            <?php }else if(isset($_GET['t']) && $_GET['t'] == 'a_d_o'){ //add dados da obra?>
                      <?php
                        $_SESSION['obra']['situacao_cadastramento'] = 'a_d_o';
                      ?>
                      <form  action="add_obra" onsubmit="return validate(this)">
                               <input type="hidden" id="t" name="t" value="a_pr_o">
                              <?php
                                  isset($_GET['id_cli']) ? $_SESSION['obra']['cliente']['id_cli'] = $_GET['id_cli'] : '';
                                  isset($_GET['nome_cli']) ? $_SESSION['obra']['cliente']['nome_cli'] = $_GET['nome_cli'] : '';
                                  isset($_GET['cpf_cnpj_cli']) ? $_SESSION['obra']['cliente']['cpf_cnpj_cli'] = $_GET['cpf_cnpj_cli'] : '';
                                  isset($_GET['rua']) ? $_SESSION['obra']['cliente']['rua'] = $_GET['rua'] : '';
                                  isset($_GET['num']) ? $_SESSION['obra']['cliente']['num'] = $_GET['num'] : '';
                                  isset($_GET['telefone_com']) ? $_SESSION['obra']['cliente']['telefone_com'] = $_GET['telefone_com'] : '';
                                  
                                  
                               ?>
                              
                              <div class="bloco-1" id="dados_obra">            
                                  <!-- <div class="ativo"><div class="ativo-text">Cadastre os dados da obra</div></div> -->
                                  <?php include_once("../view/sub-menu-obra.php"); ?>

                                  <div class="desc-bloco">
                                      <span>Preencha os principais dados da obra</span>
                                  </div>
                                  <div class="body-bloco" style="padding:10px;">
                                      <div class="form-input" style="width:45%">
                                          <span>Nome:</span><br /><input  type="text" placeholder="Digite o nome da obra..." name="nome" id="nome" value="<?php (isset($_SESSION['obra']['dados']['nome']))?print $_SESSION['obra']['dados']['nome']:''; ?>" style="width:100%">
                                      </div>
                                      <div class="form-input" style="width:40%; margin-left: 10px;">
                                          <span>Data inicio:</span><br /><input type="date" name="data_inicio_previsto" id="data_inicio_previsto" value="<?php (isset($_SESSION['obra']['dados']['data_inicio_previsto']))?print $_SESSION['obra']['dados']['data_inicio_previsto']:''; ?>" style="width:100%; ">
                                      </div>  
                                      <div class="form-input" style="width:45%">
                                          <span>Responsavel pela obra :</span><br />
                                          <select id="responsavel_obra" name="responsavel_obra"  style="background-color: #dedede;width:100%">
                                            <option value="no_sel">Selecione</option>
                                                <?php 
                                                   $func = new Funcionario();
                                                   $func = $func->get_all_func_emp();
                                                   for ($i=0; $i < count($func) ; $i++) { 
                                                      echo '<option value="'.$func[$i][0].'">'.$func[$i][1].'</option>';
                                                   }
                                                 ?>
                                             <?php echo "<script> carregaF_O('".$_SESSION['obra']['dados']['responsavel_obra']."'); </script>" ?>
                                             </select>
                                      </div>
                                      <div class="form-input" style="width:40%; margin-left: 10px;">
                                          <span>Site:</span><br /><input type="text" name="site" id="site" placeholder="INDEFINIDO..." value="<?php (isset($_SESSION['obra']['dados']['site']))?print $_SESSION['obra']['dados']['site']:''; ?>">
                                      </div>  
                                      <div class="form-input" style="width:45%">
                                          <span>Latitude:</span><br /><input  type="text" placeholder="Digite a latitude..." id="lat"  name="latitude"   onchange="initMap()"  value="<?php (isset($_SESSION['obra']['dados']['latitude']))?print $_SESSION['obra']['dados']['latitude']:''; ?>"> <!-- SE A SESSION JA TEM LATITUDE MOSTRA A DA SESSION SE NAO MOSTRA VAZIO  ON CLICK PARA CHAMAR A FUNCAO DE MOSTRAR MAPA -->
                                      </div>
                                      <div class="form-input" style="width:40%; margin-left: 10px;">
                                          <span>Longitude:</span><br /><input type="text" placeholder="Digite a longitude..."id="long"  name="longitude" onchange="initMap()" value="<?php (isset($_SESSION['obra']['dados']['longitude']))?print $_SESSION['obra']['dados']['longitude']:''; ?>"><input style="margin-left:10px" type="button" value="Ver Local" onclick="mostraLocal()"> <!-- SE A SESSION JA TEM LONGITUDE E MOSTRA A DA SESSION SE NAO MOSTRA VAZIO  ON CLICK PARA CHAMAR A FUNCAO DE MOSTRAR MAPA -->
                                      </div>
                                      <div class="form-input" style="width:45%">
                                          <span>Bairro:</span><br /><input  type="text" placeholder="Bairro" name="bairro" id="bairro" value="<?php (isset($_SESSION['obra']['dados']['bairro']))?print $_SESSION['obra']['dados']['bairro']:''; ?>" style="width:100%; text-transform: capitalize">
                                      </div>
                                      <div class="form-input" style="width:45%; margin-left: 10px;">
                                          <span>Região de trabalho:</span><br />
                                          <?php
                                              $regioes = Regiao::get_all_regiao();

                                          ?>
                                          <select id="regioes" name="regioes" onchange="buscar_cidades(this.value)" style="width:90%">
                                                <option value="no_sel">Selecione</option>
                                                <?php for($aux = 0 ; $aux < count($regioes) ; $aux++){ ?>
                                                    <option <?php ( isset($_SESSION['obra']['dados']['regioes']) && $_SESSION['obra']['dados']['regioes'] == $regioes[$aux][6] ) ? print 'selected' : '' ?> value="<?php echo $regioes[$aux][6]; ?>"><?php echo $regioes[$aux][1]; ?></option>
                                                <?php } ?>
                                                
                                          </select>
                                          <!-- <input type="text" name="cidade" placeholder="Cidade" id="cidade" value="<?php (isset($_SESSION['obra']['dados']['cidade']))?print $_SESSION['obra']['dados']['cidade']:''; ?>" style="width:100%; text-transform: capitalize"> -->
                                      </div>
                                      <div class="form-input" style="width:60%">
                                          <span>Rua:</span><br /><input type="text" placeholder="" name="rua" id="rua" style="width:100%" value="<?php (isset($_SESSION['obra']['dados']['rua']))?print $_SESSION['obra']['dados']['rua']:'' ?>">
                                      </div>
                                      <div class="form-input" style="width:25%; margin-left: 10px;">
                                          <span>Nº:</span><br /><input type="number" name="num" id="num"  style="width:100%; " value="<?php (isset($_SESSION['obra']['dados']['num']))?print $_SESSION['obra']['dados']['num']:'' ?>">
                                      </div>
                                      <div class="form-input">
                                          <span>Descricão:</span><br /><textarea type="text" placeholder="Descreva os principais detalhes da obra..." name="desc" id="desc"  style="width:90%; max-width:90%; height: 10%;max-height: 100px; padding: 2px;"><?php (isset($_SESSION['obra']['dados']['desc']))?print $_SESSION['obra']['dados']['desc']:'' ?></textarea>
                                      </div>
                                      
                                      <div class="form-input" style="margin: 10px; text-align:center;  width:97%">
                                         <input type="button"  onclick="javascript:window.history.back()" class="voltar" value="Voltar"> <input class="avancar" type="submit" value="Avançar">
                                      </div>
                                  </div>
                              </div>
                             
                              <div class="buttons" style="text-align:center">
                                  <input type="submit" name="button" class="button" id="button" value="Cadastrar"> <input type="button" name="button" class="button" onclick="cancel()" id="button" value="Cancelar">
                              </div>
                       </form>
			      <?php }else if(isset($_GET['t']) && $_GET['t'] == 'a_pr_o'){ //add produtos da obra?>
                        <?php
                          $_SESSION['obra']['situacao_cadastramento'] = 'a_pr_o';
                        ?>
                        <form  action="add_obra" onsubmit="return validate(this)">
                               <input type="hidden" id="t" name="t" value="a_p_o">
                              <?php
                                  isset($_GET['nome']) ? $_SESSION['obra']['dados']['nome'] = $_GET['nome'] : '';
                                  isset($_GET['site']) ? $_SESSION['obra']['dados']['site'] = $_GET['site'] : '';
                                  isset($_GET['data_inicio_previsto']) ? $_SESSION['obra']['dados']['data_inicio_previsto'] = $_GET['data_inicio_previsto'] : '';
                                  isset($_GET['rua']) ? $_SESSION['obra']['dados']['rua'] = $_GET['rua'] : '';
                                  isset($_GET['num']) ? $_SESSION['obra']['dados']['num'] = $_GET['num'] : '';
                                  isset($_GET['desc']) ? $_SESSION['obra']['dados']['desc'] = $_GET['desc'] : '';
                                  isset($_GET['latitude']) ? $_SESSION['obra']['dados']['latitude'] = $_GET['latitude'] : '';  /* GET PARA PEGAR O VALOR DA SESSION DADA PELA PAGINA ANTERIOR */
                                  isset($_GET['longitude']) ? $_SESSION['obra']['dados']['longitude'] = $_GET['longitude'] : ''; /* GET PARA PEGAR O VALOR DA SESSION DADA PELA PAGINA ANTERIOR */
                                  isset($_GET['bairro']) ? $_SESSION['obra']['dados']['bairro'] = $_GET['bairro'] : '';
                                  isset($_GET['regioes']) ? $_SESSION['obra']['dados']['regioes'] = $_GET['regioes'] : '';
                                  isset($_GET['responsavel_obra']) ? $_SESSION['obra']['dados']['responsavel_obra'] = $_GET['responsavel_obra'] : '';
                                  
                               ?>
                        
                              <div class="bloco-1" id="dados_obra">            
                                  <!-- <div class="ativo"><div class="ativo-text">Cadastre os dados da obra</div></div> -->
                                  <?php include_once("../view/sub-menu-obra.php"); ?>

                                  <div class="desc-bloco">
                                      <span>Selecione os Produtos </span>
                                  </div>
                                  <div class="body-bloco">
                                      <div class="form-input left">
                                          <div class="form-input">
                                              <span><b>Nome: </b></span><br /><input type="text" placeholder="Digite para pesquisar..." id="nome" style="width:60%"> <input type="button" value="Buscar" onclick="buscarProdutos()"> <span><b>Novo: </b></span><img style="width:15px; cursor: pointer;" onclick="novo_produto()" src="../images/add.png">
                                          </div>
                                          <div class="form-input" id="form-input-select" style="border: 1px solid#bbb; height:200px;">
                                              <select size="10" style="height: 100%; width: 100%">
                                              </select>
                                          </div>
                                          <div class="form-input">
                                              <span style="color:#787878; font-size:12px;">(Duplo clique para selecionar)</span>
                                          </div>
                                      </div>
                                      <div class="form-input right">
                                          <div class="form-input">
                                              <span><b>Produtos selecionados: </b></span>
                                          </div>
                                          <div class="form-input" id="form-input-dados" style="border: 1px solid#bbb;  padding: 10px;">
                                                <?php 

                                                  if(isset($_SESSION['obra']['produto'])){
                                                      echo '<table>';
                                                      for($aux = 0; $aux < count($_SESSION['obra']['produto']); $aux++){
                                                        $id_qtd = explode(':', $_SESSION['obra']['produto'][$aux]);

                                                        if($aux%2==0)
                                                                   echo '<tr style="background-color:#ccc;">';
                                                            else
                                                                  echo '<tr style="background-color:#ddd;">';
                                                                
                                                         $res = new Produto();
                                                         $res = $res->get_produto_id($id_qtd[0]);
                                                         echo '<td ><div><span>'.$res->nome.'<br />'.$res->altura.'m x '.$res->comprimento.'m x '.$res->largura.'m </span></div></td><td><input  id="'.$res->id.':'.$id_qtd[1].'" onchange="increment(this.id,\'produto\')" style="width:70px; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd[1].'"></td><td><a name="'.$res->id.'" title="Clique aqui para ver os materiais desse produto" onclick="exibe(this.name)" style="cursor:pointer"><span>Ver materiais</span></a></td><td><a name="'.$res->id.':'.$id_qtd[1].'" style="cursor:pointer"  onclick="apagar(this.name,\'produto\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                                                            
                                                          echo '</tr>';
                                                      }
                                                      echo '</table>';
                                                }

                                                 ?>
                                          </div>
                                      </div>
                                      
                                      <div class="form-input" style="margin: 10px; text-align:center;  width:97%">
                                         <input type="button"  onclick="javascript:window.history.back()" class="voltar" value="Voltar"> <input class="avancar" type="submit" value="Avançar">
                                      </div>
                                  </div>
                              </div>
                             
                              <div class="buttons" style="text-align:center;">
                                  <input type="submit" name="button" class="button" id="button" value="Cadastrar"> <input type="button" name="button" class="button" onclick="cancel()" id="button" value="Cancelar">
                              </div>
                       </form>

			      <?php }else if(isset($_GET['t']) && $_GET['t'] == 'a_p_o'){ //add patrimonios da obra?>
                      <?php
                        $_SESSION['obra']['situacao_cadastramento'] = 'a_p_o';
                      ?>
                      <form  action="add_obra" onsubmit="return validate(this)">
                               <input type="hidden" id="t" name="t" value="a_f_o">
                              <?php
                                  // $_SESSION['obra']['dados']['nome'] = $_GET['nome'];
                                  // $_SESSION['obra']['dados']['data_inicio_previsto'] = $_GET['data_inicio_previsto'];
                                  // $_SESSION['obra']['dados']['rua'] = $_GET['rua'];
                                  // $_SESSION['obra']['dados']['num'] = $_GET['num'];
                                  // $_SESSION['obra']['dados']['desc'] = $_GET['desc'];
                               ?>
                              
                              <div class="bloco-1" id="dados_obra">            
                                  <!-- <div class="ativo"><div class="ativo-text">Cadastre os dados da obra</div></div> -->
                                  <?php include_once("../view/sub-menu-obra.php"); ?>

                                  <div class="desc-bloco">
                                      <span>Selecione os Patrimonios</span>
                                  </div>
                                  <div class="body-bloco">
                                      <div class="form-input left">
                                          <div class="form-input">
                                              <div class="form-input" style="background-color:rgba(200,200,200,0.5); padding: 10px 0px 10px 0px;">
                                                  <input type="hidden" id="tipo" value="2">
                                                  <span><b>Tipo: </b></span>
                                                  <input type="radio" name="tipo" id="veiculo" style="height:12px;" value="veiculo" checked onclick="mudaTipo('2')"><span>Veículo</span><input onclick="mudaTipo('1')" type="radio" name="tipo" value="maquinario" id="maquinario" style="height:12px;"><span>Maquinario</span><input onclick="mudaTipo('0')" style="height:12px;" value="geral" name="tipo" id="geral" type="radio"><span>Geral</span><br />
                                              </div>
                                              <span><b>Nome: </b></span><br /><input type="text" placeholder="Digite para pesquisar..." id="nome" style="width:65%"> <input type="button" value="Buscar" onclick="buscarPatrimonios()">
                                          </div>
                                          <div class="form-input" id="form-input-select" style="border: 1px solid#bbb; height:200px;">
                                              <select size="10" style="height: 100%; width: 100%">
                                              </select>
                                          </div>
                                          <div class="form-input">
                                              <span style="color:#787878; font-size:12px;">(Duplo clique para selecionar)</span>
                                          </div>
                                      </div>
                                      <div class="form-input right">
                                          <div class="form-input">
                                              <span><b>Patrimonios selecionados: </b></span>
                                          </div>
                                          <div class="form-input" id="form-input-dados" style="border: 1px solid#bbb;  padding: 10px;">
                                                <?php 
                                                    echo '<table style="width:100%">';
                                                    if(isset($_SESSION['obra']['patrimonio']))//se conter dados de patrimonio na sessão executa o for percorrendo e exibindo os dados com as quantidades
                                                        for($aux = 0; $aux < count($_SESSION['obra']['patrimonio']); $aux++){
                                                            //variavel tipo_id_qtd = os valores da sessão
                                                            $tipo_id_qtd = explode(':', $_SESSION['obra']['patrimonio'][$aux]);

                                                            if($aux%2==0)
                                                               echo '<tr style="background-color:#ccc;">';
                                                            else
                                                              echo '<tr style="background-color:#ddd;">';
                                                            if($tipo_id_qtd[0] == 0){
                                                               $res = Patrimonio_geral::get_patrimonio_geral_id($tipo_id_qtd[1]);
                                                               echo '<td ><span>'.$res->nome.': </span></td><td><input  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'" onchange="increment(this.id, \'patrimonio\')" style="width:30%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                                                            }else if($tipo_id_qtd[0] == 1){
                                                               $res = Maquinario::get_maquinario_id($tipo_id_qtd[1]);
                                                               echo '<td><span>'.$res->modelo.': </span></td><td><input readonly  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'"  onchange="increment(this.id, \'patrimonio\')" style="width:30%" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                                                            }else{
                                                               $res = Veiculo::get_veiculo_id($tipo_id_qtd[1]);
                                                               echo '<td><span>'.$res->modelo.': </span></td><td><input readonly  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'"  onchange="increment(this.id, \'patrimonio\')" style="width:30%" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                                                            }
                                                            echo '</tr>';

                                                        }
                                                        echo '</table>';

                                                 ?>
                                          </div>
                                      </div>
                                      
                                      <div class="form-input" style="margin: 10px; text-align:center;  width:97%">
                                         <input type="button"  onclick="javascript:window.history.back()" class="voltar" value="Voltar"> <input class="avancar" type="submit" value="Avançar">
                                      </div>
                                  </div>
                              </div>
                             
                              <div class="buttons" style="text-align:center">
                                  <input type="submit" name="button" class="button" id="button" value="Cadastrar"> <input type="button" name="button" class="button" onclick="cancel()" id="button" value="Cancelar">
                              </div>
                       </form>
      
            <?php }else if(isset($_GET['t']) && $_GET['t'] == 'a_f_o'){ //add funcionarios da obra?>
                      <?php
                        $_SESSION['obra']['situacao_cadastramento'] = 'a_f_o';
                      ?>
                        <form  action="add_obra" onsubmit="return validate(this)">
                               <input type="hidden" id="t" name="t" value="a_cr_o">
                              <?php
                                  // $_SESSION['obra']['dados']['nome'] = $_GET['nome'];
                                  // $_SESSION['obra']['dados']['data_inicio_previsto'] = $_GET['data_inicio_previsto'];
                                  // $_SESSION['obra']['dados']['rua'] = $_GET['rua'];
                                  // $_SESSION['obra']['dados']['num'] = $_GET['num'];
                                  // $_SESSION['obra']['dados']['desc'] = $_GET['desc'];
                                  
                               ?>
                              
                              <!-- <div class="situacao">                                  
                                      <div class="situacao-box"><div>Dados da obra</div></div>
                                      <div class="situacao-box"><div>Dados da obra</div></div>
                                      <div class="situacao-box"><div>Dados da obra</div></div>
                                      <div class="situacao-box"><div>Dados da obra</div></div>
                              </div> -->
                              <div class="bloco-1" id="dados_obra">            
                                  <!-- <div class="ativo"><div class="ativo-text">Cadastre os dados da obra</div></div> -->
                                  <?php include_once("../view/sub-menu-obra.php"); ?>

                                  <div class="desc-bloco">
                                      <span>Selecione os Funcionarios que trabalharam nessa obra</span>
                                  </div>
                                  <div class="body-bloco">
                                      <div class="form-input left">
                                          <div class="form-input">
                                              <span><b>Nome: </b></span><br /><input type="text" placeholder="Digite para pesquisar..." id="nome" style="width:65%"> <input type="button" value="Buscar" onclick="buscarFuncionario()">
                                          </div>
                                          <div class="form-input" id="form-input-select" style="border: 1px solid#bbb; height:200px;">
                                              <select size="10" style="height: 100%; width: 100%">
                                              </select>
                                          </div>
                                          <div class="form-input">
                                              <span style="color:#787878; font-size:12px;">(Duplo clique para selecionar)</span>
                                          </div>
                                      </div>
                                      <div class="form-input right">
                                          <div class="form-input">
                                              <span><b>Funcionarios selecionados: </b></span>
                                          </div>
                                          <div class="form-input" id="form-input-dados" style="border: 1px solid#bbb;  padding: 10px;">
                                                <?php
                                                     if(isset($_SESSION['obra']['funcionario'])){ 
                                                          echo '<table style="width:100%" >';
                                                          for($aux = 0; $aux < count($_SESSION['obra']['funcionario']); $aux++){
                                                              if($aux%2==0)
                                                                 echo '<tr style="background-color:#ccc;">';
                                                              else
                                                                echo '<tr style="background-color:#ddd;">';
                                                                   $res = Funcionario::get_func_id($_SESSION['obra']['funcionario'][$aux]);
                                                                   echo '<td ><span>'.$res->nome.': </span></td><td style="text-align:center"><a style="cursor:pointer" id="'.$res->id.'" onclick="apagar(this.id,\'funcionario\')"><img style="width:15px" src="../images/delete.png"></a></td>';         
                                                                echo '</tr>';
                                                          }
                                                          echo '</table>';
                                                      }
                                                 ?>
                                          </div>
                                      </div>
                                      
                                      <div class="form-input" style="margin: 10px; text-align:center;  width:97%">
                                         <input type="button"  onclick="javascript:window.history.back()" class="voltar" value="Voltar"> <input class="avancar" type="submit" value="Avançar">
                                      </div>
                                  </div>
                              </div>
                             
                              <div class="buttons" style="text-align:center">
                                  <input type="submit" name="button" class="button" id="button" value="Cadastrar"> <input type="button" name="button" class="button" onclick="cancel()" id="button" value="Cancelar">
                              </div>
                       </form>
              
              <?php }else if(isset($_GET['t']) && $_GET['t'] == 'a_cr_o'){ //add cronograma da obra?>
                      <?php
                        $_SESSION['obra']['situacao_cadastramento'] = 'a_cr_o';

                        // echo "<script>ajusta('form_obra','+');</script>";
                      ?>
                        <form  action="salva_obra" onsubmit="return validate(this)" method="POST">
                               <input type="hidden" id="t" name="t" value="final">
                              <?php
                                  // $_SESSION['obra']['dados']['nome'] = $_GET['nome'];
                                  // $_SESSION['obra']['dados']['data_inicio_previsto'] = $_GET['data_inicio_previsto'];
                                  // $_SESSION['obra']['dados']['rua'] = $_GET['rua'];
                                  // $_SESSION['obra']['dados']['num'] = $_GET['num'];
                                  // $_SESSION['obra']['dados']['desc'] = $_GET['desc'];
                                  
                               ?>
                              
                              <!-- <div class="situacao">                                  
                                      <div class="situacao-box"><div>Dados da obra</div></div>
                                      <div class="situacao-box"><div>Dados da obra</div></div>
                                      <div class="situacao-box"><div>Dados da obra</div></div>
                                      <div class="situacao-box"><div>Dados da obra</div></div>
                              </div> -->
                              <div class="bloco-1" id="dados_obra">            
                                  <!-- <div class="ativo"><div class="ativo-text">Cadastre os dados da obra</div></div> -->
                                  <?php include_once("../view/sub-menu-obra.php"); ?>
                                  <div class="desc-bloco">
                                      <span>Cadastramento para variáveis de tempo</span>
                                  </div>
                                  <div class="body-bloco">
                                      <?php 
                                        if(isset($_GET['etapas']) && $_GET['etapas'] > 0){
                                            $_SESSION['obra']['etapas'] = $_GET['etapas'];
                                        }
                                        if(!isset($_SESSION['obra']['etapas'])){
                                            $_SESSION['obra']['etapas'] = 1;
                                        }

                                       ?>
                                      <?php if(isset($_SESSION['obra']['dados']['data_inicio_previsto']) && $_SESSION['obra']['dados']['data_inicio_previsto'] != ''){ // verifica se a data inicio da obra foi cadastrada
                                                
                                                if(isset($_SESSION['obra']['produto']) && count($_SESSION['obra']['produto']) > 0){ // verifica se existe algum produto cadastrado
    
                                                            // if(isset($_SESSION['obra']['etapas']) && $_SESSION['obra']['etapas'] > 0){ // verifica se ja foi definido a quantidade de etapas
  
                                              ?>
                                            
                                                      <div class="form-input" style="border-bottom:1px solid#cdcdcd">

                                                          <table style="margin-left:10px; margin-bottom:10px; ">
                                                            <tr><td><span>Defina a quantidade de etapas</span></td><td colspan = '3'><input type="number" name="etapas" id="etapas" value="<?php (isset($_SESSION['obra']['etapas'])) ? print $_SESSION['obra']['etapas'] : print '1' ?>"> <span><a onclick="submeter()">Definir</a></span></td></tr>
                                                                <tr><td><span><b>Produto</b></span></td><td><span><b>Quantidade</b></span></td><td style="text-align:center"><span><b>Inicio</b></span></td><td style="text-align:center"><span><b>Fim</b></span></td></tr>
                                                            <?php //busca todos os produtos da obra 

                                                                for($aux = 0; $aux < count($_SESSION['obra']['produto']); $aux++){
                                                                  $id_qtd = explode(':', $_SESSION['obra']['produto'][$aux]);

                                                                   echo '<tr>';
                                                                          
                                                                   $res = new Produto();
                                                                   $res = $res->get_produto_id($id_qtd[0]);
                                                                   echo '<td style="width:200px;"><div style="width:100%">
                                                                              <a name="'.$res->id.'" title="Clique aqui para ver os materiais desse produto" onclick="exibe(this.name)" style="cursor:pointer"><span>'.$res->nome.' '.$res->altura.'m x '.$res->comprimento.'m x '.$res->largura.'m </span></a></div></td>
                                                                              <td style="text-align:center"><span>'.$id_qtd[1].'</span></td>
                                                                              <td><input type="date" name="data_ini" id="dateini-'.$res->id.'"></td>
                                                                              <td><input type="date" name="data_fim" id="datefim-'.$res->id.'" onchange="preencheCronograma(\''.$res->id.'\')"></td>';
                                                                          echo '<td><select id="etapa-'.$res->id.'" onchange="preencheCronograma(\''.$res->id.'\')">';
                                                                          for($i = 0 ; $i < $_SESSION['obra']['etapas'] ; $i++){
                                                                              echo '<option name="data_fim"  value="'.($i+1).'" >Etapa '.($i+1).'</option>';
                                                                          }
                                                                          echo '</select></td>';
                                                                          if($id_qtd[1] > 1)
                                                                            echo '<td><span><a onclick="expandir_ocultar(\''.$res->id.'\')">Expandir<a></span></td>';
                                                                      
                                                                    echo '</tr>';
                                                                    if($id_qtd[1] > 1){
                                                                      echo '<tr id="id-'.$res->id.'" style="display: none">';
                                                                        echo '<td colspan="6">
                                                                                <table border="0" style="background-color:#cdcdcd">';
                                                                                     // echo '<tr><td><span><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span></td><td><span><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span></td><td style="text-align:center"><span><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span></td><td style="text-align:center"><span><b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</b></span></td></tr>';
                                                                                      for($y = 0; $y < $id_qtd[1] ; $y++){
                                                                                          
                                                                                              echo '<tr><td style="width:200px;"><div style="width:100%">
                                                                                                <a name="'.$res->id.'" title="Clique aqui para ver os materiais desse produto" onclick="exibe(this.name)" style="cursor:pointer"><span style="margin-left:10px;">'.$res->nome.' parte ' .($y+1). '</span></a></div></td>
                                                                                                <td style="text-align:center; width:70px;" ><span>1</span></td>
                                                                                                <td><input type="date" name="data_ini" id="dateini-'.$res->id.'"></td>
                                                                                                <td><input type="date" name="data_fim" id="datefim-'.$res->id.'" onchange="preencheCronograma(\''.$res->id.'\')"></td>';
                                                                                                echo '<td><select id="etapa-'.$res->id.'" onchange="preencheCronograma(\''.$res->id.'\')">';
                                                                                                for($i = 0 ; $i < $_SESSION['obra']['etapas'] ; $i++){
                                                                                                    echo '<option name="data_fim"  value="'.($i+1).'" >Etapa '.($i+1).'</option>';
                                                                                                }
                                                                                                echo '</select></td></tr>';
                                                                                          
                                                                                      }
                                                                        echo '</table></td>';
                                                                      echo '</tr>';
                                                                    }
                                                                            
                                                                }

                                                            ?>
                                                          </table>
                                                      </div>

                                                      <div class="form-input" id="result-ajax">
                                                          <!-- <div style="overflow-x: scroll; ">
                                                            
                                                          </div> -->
                                                      </div>
                                      <?php 
                                                        // }else{
                                                        //       echo '<div style="text-align:center; padding: 10px">Por favor, defina em quantas etapas você deseja realizar essa obra<br /><input type="number" name="etapas" id="etapas"> <a onclick="submeter()">Definir</a> </div>';      
                                                        // }
                                                }else{// else produtos
                                                    echo '<div style="text-align:center; padding: 10px">Atenção, você precisa selecionar pelo menos um produto para poder adicionar um cronograma<br /><a href="add_obra?t=a_pr_o">Você pode adicionar um produto clicando aqui!</a>!</div>';
                                                }
                                          }else{// else inicio da obra
                                                echo '<div style="text-align:center; padding: 10px">Atenção, você precisa definir o início da obra para poder adicionar um cronograma<br /><a href="add_obra?t=a_d_o">Você pode definir a data de início clicando aqui</a>!</div>';

                                          } ?>
                                      <div class="form-input" style="margin: 10px; text-align:center;  width:97%">
                                         <input type="button"  onclick="javascript:window.history.back()" class="voltar" value="Voltar"> <input class="avancar" type="submit" value="Avançar">
                                      </div>
                                  </div>
                              </div>
                             
                              <div class="buttons" style="text-align:center">
                                  <input type="submit" name="button" class="button" id="button" value="Cadastrar"> <input type="button" name="button" class="button" onclick="cancel()" id="button" value="Cancelar">
                              </div>
                       </form>

            <?php   }else if(isset($_GET['t']) && $_GET['t'] == 'sucess'){ //add cronograma da obra?>
                          <h2>Obra cadastrada com sucesso</h2>


            <?php   } ?>

	 	    </div>
         <div class="formulario" style="width:43%;">
            <div class="bloco-1">
                <div class="form-input">
                    <div class="form-input"><b>DADOS DO CADASTRAMENTO</b></div>
                    <?php if(isset($_SESSION['obra']['status']) && $_SESSION['obra']['status'] == 0 ){
                          echo '<div class="form-input">(ORÇAMENTO)</div>';
                          
                    } ?>

                </div>
                <div class="body-bloco">
                  <?php if(isset($_SESSION['obra']['cliente'])){?>
                        <div class="form-input" style="border-bottom: 1px solid#aaa">
                              <span style="margin-left:10px;"><b>Cliente</b></span> <span><a name="btn_cli" id="btn_cli" onclick="expand('dados_cli',this.id)" style="cursor: pointer; color:#773333"> (Ocultar)</a></span>
                        </div>
                        <div class="form-input" id="dados_cli" style="padding: 0px 0px 5px 10px; padding-left:20px;">
                            <?php if(isset($_SESSION['obra']['cliente']['nome_cli']) && $_SESSION['obra']['cliente']['nome_cli'] != '' ){ ?>
                                        <span><b>Nome/Razão Social: </b></span><input readonly   type="text" style="border: 0" value="<?php (isset($_SESSION['obra']['cliente']['nome_cli']))?print $_SESSION['obra']['cliente']['nome_cli']:''; ?>"><br />
                            <?php }if(isset($_SESSION['obra']['cliente']['cpf_cnpj_cli']) && $_SESSION['obra']['cliente']['cpf_cnpj_cli'] != ''){ ?>
                                        <span><b>CPF/CNPJ: </b></span><input readonly   type="text" style="border: 0" value="<?php (isset($_SESSION['obra']['cliente']['cpf_cnpj_cli']))?print $_SESSION['obra']['cliente']['cpf_cnpj_cli']:''; ?>"><br />
                            <?php }if(isset($_SESSION['obra']['cliente']['rua']) && $_SESSION['obra']['cliente']['rua'] != ''){ ?>
                                        <span><b>Endereço: </b></span><input readonly   type="text" style="border: 0" value="<?php (isset($_SESSION['obra']['cliente']['rua']))?print $_SESSION['obra']['cliente']['rua']:''.(isset($_SESSION['obra']['cliente']['num']))?print ', '.$_SESSION['obra']['cliente']['num']:''; ?>"><br />
                            <?php }if(isset($_SESSION['obra']['cliente']['telefone_com']) && $_SESSION['obra']['cliente']['telefone_com'] != ''){ ?>
                                        <span><b>Telefone: </b></span><input readonly   type="text" style="border: 0" value="<?php (isset($_SESSION['obra']['cliente']['telefone_com']))?print $_SESSION['obra']['cliente']['telefone_com']:''; ?>"><br />
                            <?php } ?>
                        </div>
                    <?php } ?>
                    <?php if(isset($_SESSION['obra']['dados']) && count($_SESSION['obra']['dados']) > 0){?>
                            <div class="form-input" style="border-bottom: 1px solid#aaa">
                                  <span style="margin-left:10px;"><b>Dados da Obra</b></span> <span><a name="btn_dados_obra" id="btn_dados_obra" onclick="expand('ex_dados_obra',this.id)" style="cursor: pointer; color:#773333">(Ocultar)</a></span>
                            </div>
                            <div class="form-input" id="ex_dados_obra" style="padding: 0px 0px 10px 10px; padding-left:20px;">
                                <?php if(isset($_SESSION['obra']['dados']['nome']) && $_SESSION['obra']['dados']['nome'] != ''){ ?>
                                            <span><b>Nome: </b></span><span><?php (isset($_SESSION['obra']['dados']['nome']))?print $_SESSION['obra']['dados']['nome']:''; ?></span>
                                
                                <?php }if(isset($_SESSION['obra']['dados']['responsavel_obra']) && $_SESSION['obra']['dados']['responsavel_obra'] != ''){ 
                                            $resp_obra = Funcionario::get_nome_by_id($_SESSION['obra']['dados']['responsavel_obra']);
                                  ?>
                                            &nbsp;&nbsp;&nbsp;&nbsp;<span><b>Responsavel pela obra: </b></span><span><?php (isset($_SESSION['obra']['dados']['responsavel_obra']))?print $resp_obra[0]:''; ?></span><br />
                                
                                <?php }if(isset($_SESSION['obra']['dados']['data_inicio_previsto']) && $_SESSION['obra']['dados']['data_inicio_previsto'] != ''){ ?>
                                            <span><b>Data Inicio: </b></span><span><?php (isset($_SESSION['obra']['dados']['data_inicio_previsto']))?print Date('d/m/Y',strtotime($_SESSION['obra']['dados']['data_inicio_previsto'])):''; ?></span><br />
                                
                                <?php }if(isset($_SESSION['obra']['dados']['rua']) && $_SESSION['obra']['dados']['rua'] != ''){ ?>
                                            <span><b>Endereço: </b></span><span><?php (isset($_SESSION['obra']['dados']['rua']))?print $_SESSION['obra']['dados']['rua']:''.(isset($_SESSION['obra']['dados']['num']))?print ', '.$_SESSION['obra']['dados']['num']:''; ?></span><br />
                                
                                <?php }if(isset($_SESSION['obra']['dados']['bairro']) && $_SESSION['obra']['dados']['bairro'] != ''){ ?>
                                        <span><b>Bairro: </b></span><span><?php (isset($_SESSION['obra']['dados']['bairro']))?print $_SESSION['obra']['dados']['bairro']:''?></span><br />
                                
                                <?php }if(isset($_SESSION['obra']['dados']['regioes']) && $_SESSION['obra']['dados']['regioes'] != ''){ ?>
                                        <span><b>Região de trabalho: </b></span><span><?php echo Regiao::get_name_regiao_by_id($_SESSION['obra']['dados']['regioes']) ?></span>
                                        
                                <?php }if(isset($_SESSION['obra']['dados']['latitude']) && $_SESSION['obra']['dados']['latitude'] != '' && isset($_SESSION['obra']['dados']['longitude']) && $_SESSION['obra']['dados']['latitude'] != ''  ){ ?> <!-- CONDIÇÃO PARA VER SE EXISTE DADOS DE LATITUDE NA SESSION -->
                                        <br /><span><b>Coordenadas: </b></span><span><input type="hidden" id="long" value="<?php echo $_SESSION['obra']['dados']['longitude'] ?>"><input type="hidden" id="lat" value="<?php echo $_SESSION['obra']['dados']['latitude'] ?>"><?php (isset($_SESSION['obra']['dados']['latitude']))?print 'Lat.: '.$_SESSION['obra']['dados']['latitude']:''?></span> <span><?php (isset($_SESSION['obra']['dados']['longitude']))?print 'Long.: '.$_SESSION['obra']['dados']['longitude']:''?></span><input  style="margin-left: 10px;"type="button" onclick="mostraLocal()" value="Ver local"><br /> <!-- MONSTRA A DIV PARA VISUALIZAÇÃO DO MAPA -->
                                        <!-- LINHA DE CIMA PARA PRINTAR NA TELA AS CORDENADAS COM ID DE LAT E LONG POR QUE O ONCLICK CHAMA A INITMAP() E A INITMAP() PRECISA DE CAMPOS LAT E LONG COM VALORES SETADOS CONDIÇÃO PARA VER SE EXISTE DADOS DE LATITUDE NA SESSION -->
                                <?php }if(isset($_SESSION['obra']['dados']['desc']) && $_SESSION['obra']['dados']['desc'] != ''){// se existe descrição ?>
                                            <span><b>Descrição: </b></span><br />
                                                <textarea style="padding: 1px 0px 2px 10px;width:90%; min-width: 90%; max-width:95%; max-height:15%; height: 5%; border: 0" readonly><?php (isset($_SESSION['obra']['dados']['desc']))?print $_SESSION['obra']['dados']['desc']:''; ?></textarea>
                                <?php } ?>
                            </div>
                   <?php } ?>
                   <?php if(isset($_SESSION['obra']['produto']) && count($_SESSION['obra']['produto']) > 0){?>
                            <div class="form-input" style="border-bottom: 1px solid#aaa">
                                  <span style="margin-left:10px;"><b>Produtos/Obra</b></span> <span><a name="btn_prod_obra" id="btn_prod_obra" onclick="expand('prod_obra',this.id)" style="cursor: pointer; color:#773333">(Ocultar)</a></span>
                            </div>
                            <div class="form-input" id="prod_obra" style="padding: 0px 0px 10px 10px; padding-left:20px;">
                                <?php 

                                                  if(isset($_SESSION['obra']['produto'])){
                                                      echo '<table style="text-align:center; width:90%">';

                                                      echo '<tr style="background-color:#ddd;"><td><span><b>Nome</b></span></td><td><span><b>Quantidade</b></span></td></tr>';
                                                      for($aux = 0; $aux < count($_SESSION['obra']['produto']); $aux++){
                                                        $id_qtd = explode(':', $_SESSION['obra']['produto'][$aux]);

                                                        if($aux%2==0)
                                                                   echo '<tr style="background-color:#ccc;">';
                                                            else
                                                                  echo '<tr style="background-color:#ddd; ">';
                                                                
                                                         $res = new Produto();
                                                         $res = $res->get_produto_id($id_qtd[0]);
                                                         echo '<td style="padding: 3 10 3 10px;"><span>'.$res->nome.' </span><a name="'.$res->id.'" title="Clique aqui para ver os materiais desse produto" onclick="exibe(this.name)" style="cursor:pointer"><span> (ver materiais)</span></a></td><td style="padding: 3 10 3 10px;"><span>'.$id_qtd[1].'</span></td>';
                                                            
                                                          echo '</tr>';
                                                      }
                                                      echo '</table>';
                                                }

                                                 ?>
                            </div>
                   <?php } ?>
                   <?php if(isset($_SESSION['obra']['patrimonio']) && count($_SESSION['obra']['patrimonio']) > 0){?>
                            <div class="form-input" style="border-bottom: 1px solid#aaa">
                                  <span style="margin-left:10px;"><b>Patrimonios/Obra</b></span> <span><a name="btn_pat_obra" id="btn_pat_obra" onclick="expand('pat_obra',this.id)" style="cursor: pointer; color:#773333">(Ocultar)</a></span>
                            </div>
                            <div class="form-input" id="pat_obra" style="padding: 0px 0px 10px 10px; padding-left:20px; ">
                                <?php 
                                      echo '<table style="text-align:center; width:90%">';
                                            echo '<tr style="background-color:#ddd;"><td><span><b>Nome / Responsável</b></span></td><td><span><b>Quantidade</b></span></td></tr>';
                                      for($aux = 0; $aux < count($_SESSION['obra']['patrimonio']); $aux++){
                                                 //variavel tipo_id_qtd = os valores da sessão
                                                 $tipo_id_qtd = explode(':', $_SESSION['obra']['patrimonio'][$aux]);
                                                 if($aux%2==0)
                                                          echo '<tr style="background-color:#ccc;">';
                                                 else
                                                          echo '<tr style="background-color:#ddd; ">';
                                                 if($tipo_id_qtd[0] == 0){
                                                    $res = Patrimonio_geral::get_patrimonio_geral_id($tipo_id_qtd[1]);
                                                    // echo '<li style="margin-left:10px;"><span>'.$res->nome.': </span><input readonly style="width:30%; border: 0" type="number" value="'.$tipo_id_qtd[2].'"></li>';
                                                    echo '<td style="padding: 3 10 3 10px;"><span>'.$res->nome.' </span></td><td style="padding: 3 10 3 10px;"><span>'.$tipo_id_qtd[2].'</span></td>';
                                                 }else if($tipo_id_qtd[0] == 1){
                                                    $res = Maquinario::get_maquinario_id($tipo_id_qtd[1]);
                                                    $func_res = Funcionario::get_nome_by_id($res->id_responsavel);
                                                    // echo '<li style="margin-left:10px;"><span>'.$res->modelo.': </span><input readonly style="width:30%; border: 0" type="number" value="'.$tipo_id_qtd[2].'"></li>';
                                                    echo '<td style="padding: 3 10 3 10px;"><span>'.$res->modelo.' / '.$func_res[0].' </span></td><td style="padding: 3 10 3 10px;"><span>'.$tipo_id_qtd[2].'</span></td>';
                                                 }else{
                                                    $res = Veiculo::get_veiculo_id($tipo_id_qtd[1]);
                                                    // echo "<script>alert('".$res->id_responsavel."');</script>";
                                                    $func_res = Funcionario::get_nome_by_id($res->id_responsavel);
                                                    // if($func_res !=){
                                                      // echo '<li style="margin-left:10px;"><span>'.$res->modelo.': </span><input readonly style="width:30%; border: 0" type="number" value="'.$tipo_id_qtd[2].'"></li>';
                                                      echo '<td style="padding: 3 10 3 10px;"><span>'.$res->modelo.' / '.$func_res[0].' </span></td><td style="padding: 3 10 3 10px;"><span>'.$tipo_id_qtd[2].'</span></td>';
                                                    // }
                                                 }
                                                 echo '</tr>';
                                                 
                                                 // if(count($patrimonio)>1)
                                                 //  for($aux = 0; $aux < count($patrimonio); $aux++ ){
                                                 //      echo 'id '. $patrimonio[$aux][1].'<br />';
                                                 //  }
                                                 // else
                                                 //  echo 'id '. $patrimonio[0][1].'<br />';
                                      }
                                      echo '</table>';
                                    
                                 ?>
                            </div>
                   <?php } ?>
                   <?php if(isset($_SESSION['obra']['funcionario']) && count($_SESSION['obra']['funcionario']) > 0){?>
                            <div class="form-input" style="border-bottom: 1px solid#aaa; padding-bottom:10px;">
                                  <span style="margin-left:10px;"><b>Funcionários/Obra</b></span> <span><a name="btn_func_obra" id="btn_func_obra" onclick="expand('func_obra',this.id)" style="cursor: pointer; color:#773333">(Ocultar)</a></span>
                            </div>
                            <div class="form-input" id="func_obra" style="padding: 0px 0px 10px 10px; padding-left:20px;">
                                <?php 
                                      echo '<table style="text-align:center; width:90%">';
                                            echo '<tr style="background-color:#ddd;"><td><span><b>Nome</b></span></td><td><span><b>Cargo</b></span></td></tr>';
                                      for($aux = 0; $aux < count($_SESSION['obra']['funcionario']); $aux++){
                                                 //variavel tipo_id_qtd = os valores da sessão
                                                 // echo '<li style="margin-left:10px;"><span>'.Funcionario::get_nome_by_id($_SESSION['obra']['funcionario'][$aux]).'</span></li>';
                                          if($aux%2==0)
                                               echo '<tr style="background-color:#ccc;">';
                                          else
                                               echo '<tr style="background-color:#ddd; ">';
                                          // buscarcargo
                                             $funcionario = Funcionario::get_func_id($_SESSION['obra']['funcionario'][$aux]);
                                             $cbo = new Cbo();
                                             $cbo = $cbo->get_cbo_by_id($funcionario->id_cbo);
                                                echo '<td style="padding: 3 10 3 10px;"><span>'.$funcionario->nome.' </span></td><td style="padding: 3 10 3 10px;"><span>'.$cbo->descricao.'</span></td>';
                                                echo '</tr>';
                                      }
                                      
                                      echo '</table>';
                                 ?>
                            </div>
                   <?php } ?>
                </div>
            </div>
         </div>
   <div id="fundo" hidden="on" style="background-color:rgba(0,0,0,0.8); margin-top: -9px; margin-left: -9px; width:100%; height: 100%; position: absolute; z-index: 1" >
       <span  onclick="fechar()" style="cursor:pointer; color:floralwhite; float:right; margin-top:10px; margin-right:10px; z-index: 1"> Fechar</span>
   </div>  
    
    
	 	    <?php //include("informacoes_grupo.php") ?> 
    
  
</body>

</html>