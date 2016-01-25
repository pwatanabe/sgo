<html>
<?php
//CLIENTE > DADOS DA OBRA > PRODUTOS > MATERIAIS > PATRIMONIOS > FUNCIONARIOS
include("restrito.php"); 

include_once("../model/class_sql.php");
include_once("../model/class_grupo_bd.php");
include_once("../model/class_maquinario_bd.php");
include_once("../model/class_veiculo_bd.php");
include_once("../model/class_patrimonio_geral_bd.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_material_bd.php");
include_once("../model/class_unidade_medida_bd.php");
include_once("../model/class_produto_bd.php");
include_once("../model/class_produto_materiais_bd.php");
include_once("../includes/functions.php");

function validate(){
   if(!isset($_POST['nome']) || $_POST['nome'] == ""){
        return false;
    }
    return true;
}
 ?>


<?php Functions::getHead('Adicionar'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">

</head> -->

<?php Functions::getScriptProduto(); ?>
<body>
  
      <?php include_once("../view/topo.php"); ?>
              <div id="apagar" style="float:left"></div>
            <?php

                if(isset($_POST['t']) && $_POST['t'] == 'cadastrar'){
                    $cont=0; //conta se todos os materiais foram adicionados com sucesso
                    $materiais = $_SESSION['produto']['material'];
                    $sucesso = false; // verifica se o produto foi adicionado com sucesso
                    if(validate()){
                        $produto = new Produto();
                        $produto_materiais = new  ProdutosMateriais();                      
                        // print_r($_SESSION['produto']['material']);
                        $nome = $_POST['nome'];
                        $id_empresa = $_SESSION['id_empresa'];
                        $altura = $_POST['altura'];
                        $comprimento = $_POST['comprimento'];
                        $largura = $_POST['largura'];
                        $tempo_estimado_conclusao = $_POST['temp_estim_conclusao'];

                        $produto->add_produtos($nome, $id_empresa, $altura, $largura, $comprimento, $tempo_estimado_conclusao);//inserindo dados no objeto
                        $id_produto = $produto->add_produto_bd();
                        
                        if($id_produto){
                          $sucesso = 'Cadastrado';

                          for($aux = 0; $aux < count($materiais); $aux++){
                              // echo '<br />'.$materiais[$aux];
                              $id_qtd_tipo = explode(":", $materiais[$aux]);
                              

                              $id_material = $id_qtd_tipo[0].':'.$id_qtd_tipo[2];


                              $produto_materiais = $produto_materiais->add_produtos_materiais($id_produto, $id_material, $id_qtd_tipo[1]);
                              // $sucesso = $produto_materiais->add_produtos_materiais_bd();
                              
                              if($produto_materiais->add_produtos_materiais_bd()){
                                 $cont++;
                              }
                          }
                          unset($_SESSION['produto']);
                        }
                    }
                }else if(isset($_POST['t']) && $_POST['t'] == 'editar'){
                    $cont=0; //conta se todos os materiais foram adicionados com sucesso
                    $materiais = $_SESSION['produto']['editar']['material'];
                    $sucesso = false; // verifica se o produto foi adicionado com sucesso
                    if(validate()){
                        $produto = new Produto();
                        $produto_materiais = new  ProdutosMateriais();                      
                        // print_r($_SESSION['produto']['material']);
                        
                        $nome = $_POST['nome'];
                        $id_produto = $_POST['id_produto'];
                        $altura = $_POST['altura'];
                        $comprimento = $_POST['comprimento'];
                        $largura = $_POST['largura'];
                        $tempo_estimado_conclusao = $_POST['temp_estim_conclusao'];
                        $produto = $produto->atualiza_produto($nome, $id_produto, $altura, $largura, $comprimento, $tempo_estimado_conclusao);
                        
                        if($id_produto){
                          $sucesso = 'Atualizado';
                          $produto_materiais->limpa_materiais_produto($id_produto);
                          for($aux = 0; $aux < count($materiais); $aux++){
                              // echo '<br />'.$materiais[$aux];
                              $id_qtd_tipo = explode(":", $materiais[$aux]);
                              

                              $id_material = $id_qtd_tipo[0].':'.$id_qtd_tipo[2];


                              $produto_materiais = $produto_materiais->add_produtos_materiais($id_produto, $id_material, $id_qtd_tipo[1]);
                              // $sucesso = $produto_materiais->add_produtos_materiais_bd();
                              
                              if($produto_materiais->add_produtos_materiais_bd()){
                                 $cont++;
                              }
                          }
                          unset($_SESSION['produto']);
                        }
                    }
                    
                }
           ?>
         <script>alert('Tratar os campos altura, comprimento, largura e tempo estimado de conclusão');</script>
            <div class="formulario" style="width:500px;">
              <div class="title-box" style="float:left;width:100%"><div style="float:left"><img src="../images/add.png" width="35px" style="margin-left:5px;"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">ADICIONAR PRODUTO</span></div></div>
              <?php 
                    if(isset($_GET['t']) && $_GET['t'] == 'c'){
                        unset($_SESSION['produto']);
                    }
               ?>
               <?php if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){ ?>
              
                      <form  action="add_produto.php" method="POST" onsubmit="return validate(this)">

                                <?php
                                    unset($_SESSION['produto']['editar']);
                                    $produto = new Produto();
                                    $produto = $produto->get_produto_id($_GET['id']);
                                    $aux = 0;
                                    $materiais = $produto->get_materiais_produto($produto->id);
                                    
                                    if($materiais){
                                        foreach ($materiais as $key => $value) {
                                            foreach ($value as $key => $material) {
                                                if($key == 1){
                                                    $id_tipo = explode(':', $material);                                             
                                                }
                                                if($key == 2){
                                                    $quantidade = $material;                                             
                                                }
                                            }
                                            $_SESSION['produto']['editar']['material'][$aux] = $id_tipo[0].':'.$quantidade.':'.$id_tipo[1];
                                            $aux++;
                                        }          
                                    }                        
                               ?>
                              <input type="hidden" id="t" name="t" value="editar">
                               <input type="hidden" id="id_produto" name="id_produto" value="<?php echo $produto->id ?>">
                              <div class="bloco-1" id="dados_obra">            
                                  <!-- <div class="ativo"><div class="ativo-text">Cadastre os dados da obra</div></div> -->
                                  
                                  <div class="desc-bloco">
                                      <span style="float:left; margin-left: 10px;"><a href="#" onmouseover="info('pop2')" onmouseout="fecharInfo('pop2')"><img width='15px' src="../images/info-icon.png"> Dica</a></span> <span> Selecione os Materiais necessários para esse produto </span>
                                      <!-- <div class="cont" style="margin-left:480px;"><a name="exibe_box_atrasos" onclick="oculta(this.name)"><img width="20px" src="../images/icon-fechar.png" ></a> -->
                                      <div id="pop2" class="pop" style="display:none">
                                          <div id="titulo2" class="title-info-config"><span>Dicas útil</span></div>
                                          <div id="content2" class="content-info">Cadastre um produto com medidas padrões, que possa ser usado em varias obras.<br /> <b>Ex: </b>Parede 1m x 1m x 0,20m<br />
                                            Essa parede possui 1m², no cadastramento de obras pode ser definido qual a quantidade desse produto será usado<br />
                                            <b>Ex: </b>5 Paredes = 5m²</div>   
                                      </div>
                                     <!-- </div> -->
                                  </div>
                                  <div class="body-bloco">
                                      <div class="form-input left">
                                          <div class="form-input">
                                              <div class="form-input" style="background-color:rgba(210,210,210,0.5); padding: 10px 0px 10px 5px; border: 1px solid#bbb;">
                                                  <span><b>Nome: </b></span><input type="text" placeholder="Digite o nome do produto" id="nome" name="nome" style="width:75%" value="<?php echo $produto->nome ?>">    
                                                  <table>
                                                      <tr><td><span><b>Altura</b></span></td><td><span><b>Comprimento</b></span></td><td><span><b>Largura</b></span></td></tr>
                                                      <tr>
                                                          <td><input type="text" id="altura" name="altura" style="width:100%" placeholder="Metros" title="Digite a altura em metros" value="<?php echo $produto->altura ?>"></td>
                                                          <td><input type="text" id="comprimento" name="comprimento" style="width:100%" placeholder="Metros" title="Digite o comprimento em metros" value="<?php echo $produto->comprimento ?>"></td>
                                                          <td><input type="text" id="largura" name="largura" style="width:100%" placeholder="Metros" title="Digite a largura em metros" value="<?php echo $produto->largura ?>"></td>
                                                      </tr>
                                                      <tr><td colspan="3"><span><b>Tempo estimado de conclusão</b></span></td></tr>
                                                      <tr>
                                                          <td colspan="3"><input type="text" id="temp_estim_conclusao" name="temp_estim_conclusao" style="width:50%" placeholder="Horas" title="Digite o tempo de conclusão estimado para esse produto" value="<?php echo $produto->tempo_estimado_conclusao ?>"><span> Horas</span></td>
                                                      </tr>
                                                    
                                                  </table>
                                              </div>
                                              <span><b>Pesquisar materiais: </b></span><br />
                                              <input type="radio" style="height:12px" checked name="tipo_material" id="m"><span>Materiais</span><input type="radio" name="tipo_material" id="p" style="height:12px"><span>Produtos</span>
                                              <input type="text" placeholder="Digite para pesquisar..." title="Digite o nome do material para pesquisar" id="nome_pesquisa" style="width:65%"> <input type="button" value="Buscar" onclick="buscarMateriais('editaproduto')">
                                          </div>
                                          <div class="form-input" id="form-input-select" style="border: 1px solid#bbb; height:200px;">
                                              <select size="10" style="height: 100%; width: 100%">
                                              </select>
                                          </div>
                                      </div>
                                      <div class="form-input right">
                                          <div class="form-input">
                                              <span><b>Materiais selecionados: </b></span>
                                          </div>
                                          <div class="form-input" id="form-input-dados" style="border: 1px solid#bbb;  padding: 10px;">
                                                <?php 
                                                if(isset($_SESSION['produto']['editar']['material'])){
                                                  echo '<table>';
                                                      for($aux = 0; $aux < count($_SESSION['produto']['editar']['material']); $aux++){
                                                        $id_qtd_tipo = explode(':', $_SESSION['produto']['editar']['material'][$aux]);
                                                          // echo 'ID: '.$tipo_id_qtd_tipo[1].' Tipo: '.$tipo_id_qtd_tipo[0].' Quantidade: '.$tipo_id_qtd_tipo[2].'<br />';

                                                        if($aux%2==0)
                                                               echo '<tr style="background-color:#ccc;">';
                                                        else
                                                              echo '<tr style="background-color:#ddd;">';
                                                            if($id_qtd_tipo[2] == 'm'){// se for material
                                                                  $res = new Material();
                                                                  $res = Material::get_material_id($id_qtd_tipo[0]);
                                                                  $uni = new Unidade_medida();
                                                                  $uni = $uni->get_unidade_medida_by_id($res->id_unidade_medida);
                                                                  echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id, \'editar\')" style="width:50%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"> <span>'.$uni->sigla.'</span></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\',\'editar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                                                            }else if($id_qtd_tipo[2] == 'p'){// se for produto
                                                                  $res = new Produto();
                                                                  $res = $res->get_produto_id($id_qtd_tipo[0]);
                                                                  echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id, \'editar\')" style="width:50%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\',\'editar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                                                            }
                                                        echo '</tr>';
                                                      }
                                                      echo '</table>';
                                                }
                                                 ?>
                                          </div>
                                      </div>
                                   </div>
                              </div>
                             
                              <div class="buttons" style="text-align:center">
                                  <input type="submit" name="button" class="button" id="button" value="Salvar"> <input type="button" name="button" class="button" onclick="cancel()" id="button" value="Cancelar">
                              </div>
                              
                       </form>
      
                       
                        <?php 
                            if(isset($sucesso) && $sucesso == true && count($materiais) == $cont){
                              echo '<div class="msg">Produto '.$_POST['nome'].' adicionado com sucesso</div>';
                              
                            }
                            if(isset($sucesso) && !$sucesso && isset($_POST['nome'])){
                              echo '<div class="msg">'.(count($materiais)-$cont).' materiais não foram adicionados</div>';
                            }
                         ?>
                        
              <?php }else{ ?>
                
                      <form  action="add_produto.php" method="POST" onsubmit="return validate(this)">
                               <input type="hidden" id="t" name="t" value="cadastrar">
                              <?php
                                  // $_SESSION['obra']['dados']['nome'] = $_GET['nome'];
                                  // $_SESSION['obra']['dados']['data_inicio_previsto'] = $_GET['data_inicio_previsto'];
                                  // $_SESSION['obra']['dados']['rua'] = $_GET['rua'];
                                  // $_SESSION['obra']['dados']['num'] = $_GET['num'];
                                  // $_SESSION['obra']['dados']['desc'] = $_GET['desc'];
                                  
                               ?>
                              
                              <div class="bloco-1" id="dados_obra">            
                                  <!-- <div class="ativo"><div class="ativo-text">Cadastre os dados da obra</div></div> -->
                                  
                                  <div class="desc-bloco">
                                      <span style="float:left; margin-left: 10px;"><a href="#" onmouseover="info('pop2')" onmouseout="fecharInfo('pop2')"><img width='15px' src="../images/info-icon.png"> Dica</a></span> <span> Selecione os Materiais necessários para esse produto </span>
                                      <!-- <div class="cont" style="margin-left:480px;"><a name="exibe_box_atrasos" onclick="oculta(this.name)"><img width="20px" src="../images/icon-fechar.png" ></a> -->
                                      <div id="pop2" class="pop" style="display:none">
                                          <div id="titulo2" class="title-info-config"><span>Dicas útil</span></div>
                                          <div id="content2" class="content-info">Cadastre um produto com medidas padrões, que possa ser usado em varias obras.<br /> <b>Ex: </b>Parede 1m x 1m x 0,20m<br />
                                            Essa parede possui 1m², no cadastramento de obras pode ser definido qual a quantidade desse produto será usado<br />
                                            <b>Ex: </b>5 Paredes = 5m²</div>   
                                      </div>
                                     <!-- </div> -->
                                  </div>
                                  <div class="body-bloco">
                                      <div class="form-input left">
                                          <div class="form-input">
                                              <div class="form-input" style="background-color:rgba(210,210,210,0.5); padding: 10px 5px 10px 5px; border: 1px solid#bbb;">
                                                  <span><b>Nome: </b></span><input type="text" placeholder="Digite o nome do produto" id="nome" name="nome" style="width:75%">    
                                                   <table>
                                                      <tr><td><span><b>Altura</b></span></td><td><span><b>Comprimento</b></span></td><td><span><b>Largura</b></span></td></tr>
                                                      <tr>
                                                          <td><input type="text" id="altura" name="altura" style="width:100%" placeholder="Metros" title="Digite a altura em metros"></td>
                                                          <td><input type="text" id="comprimento" name="comprimento" style="width:100%" placeholder="Metros" title="Digite o comprimento em metros"></td>
                                                          <td><input type="text" id="largura" name="largura" style="width:100%" placeholder="Metros" title="Digite a largura em metros"></td>
                                                      </tr>
                                                      <tr><td colspan="3"><span><b>Tempo estimado de conclusão</b></span></td></tr>
                                                      <tr>
                                                          <td colspan="3"><input type="text" id="temp_estim_conclusao" name="temp_estim_conclusao" style="width:50%" placeholder="Horas" title="Digite o tempo de conclusão estimado para esse produto"><span> Horas</span></td>
                                                      </tr>
                                                    
                                                  </table>
                                              </div>
                                              <span><b>Pesquisar materiais: </b></span><br />
                                              <input type="radio" style="height:12px" checked name="tipo_material" id="m"><span>Materiais</span><input type="radio" name="tipo_material" id="p" style="height:12px"><span>Produtos</span>
                                              <input type="text" placeholder="Digite para pesquisar..." title="Digite o nome do material para pesquisar" id="nome_pesquisa" style="width:65%"> <input type="button" value="Buscar" onclick="buscarMateriais('addproduto')">
                                          </div>
                                          <div class="form-input" id="form-input-select" style="border: 1px solid#bbb; height:120px;">
                                              <select size="10" style="height: 100%; width: 100%">
                                              </select>
                                          </div>
                                          
                                      </div>
                                      <div class="form-input right">
                                          <div class="form-input">
                                              <span><b>Materiais selecionados: </b></span>
                                          </div>
                                          <div class="form-input" id="form-input-dados" style="border: 1px solid#bbb;  padding: 10px; ">
                                                <?php 
                                                if(isset($_SESSION['produto']['material'])){
                                                  echo '<table>';
                                                      for($aux = 0; $aux < count($_SESSION['produto']['material']); $aux++){
                                                        $id_qtd_tipo = explode(':', $_SESSION['produto']['material'][$aux]);
                                                          // echo 'ID: '.$tipo_id_qtd_tipo[1].' Tipo: '.$tipo_id_qtd_tipo[0].' Quantidade: '.$tipo_id_qtd_tipo[2].'<br />';

                                                        if($aux%2==0)
                                                               echo '<tr style="background-color:#ccc;">';
                                                        else
                                                              echo '<tr style="background-color:#ddd;">';
                                                            if($id_qtd_tipo[2] == 'm'){// se for material
                                                                  $res = new Material();
                                                                  $res = Material::get_material_id($id_qtd_tipo[0]);
                                                                  $uni = new Unidade_medida();
                                                                  $uni = $uni->get_unidade_medida_by_id($res->id_unidade_medida);
                                                                  echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id,\'cadastrar\')" style="width:50%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"> <span>'.$uni->sigla.'</span></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\',\'cadastrar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                                                            }else if($id_qtd_tipo[2] == 'p'){// se for produto
                                                                  $res = new Produto();
                                                                  $res = $res->get_produto_id($id_qtd_tipo[0]);
                                                                  echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id, \'cadastrar\')" style="width:50%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\', \'cadastrar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
                                                            }
                                                        echo '</tr>';
                                                      }
                                                      echo '</table>';
                                                }
                                                 ?>
                                          </div>
                                      </div>
                                   </div>
                              </div>
                             
                              <div class="buttons" style="text-align:center">
                                  <input type="submit" name="button" class="button" id="button" value="cadastrar"> <input type="button" name="button" class="button" onclick="cancel()" id="button" value="Cancelar">
                              </div>
                              
                       </form>
      
                       
                        <?php


                            if(isset($sucesso) && $sucesso != false && count($materiais) == $cont){
                              echo '<div class="msg">Produto '.$_POST['nome'].' '.$sucesso.' com sucesso</div>';
                              
                            }
                            if(isset($sucesso) && !$sucesso && isset($_POST['nome'])){
                              echo '<div class="msg">'.(count($materiais)-$cont).' materiais não foram adicionados</div>';
                            }
                         ?>
              <?php } ?>
              
            

        </div>
         
        <?php include_once("informacoes_produto.php"); ?>
      
</body>
</html>