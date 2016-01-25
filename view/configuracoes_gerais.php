<div class="separador" ><span style="color: #ddd;" class="title">CONFIGURAÇÕES GERAIS</span><input type="button" style="background-color: rgba(000,000,000,0.1); border:0; float:right; color:#cc0000" value="Configurar" onclick="mostraTabela1('config_gerais')" ></div>
<div id="config_gerais" hidden="on" style="float:left; width:100%">   
    



    <div  style="padding:10px;" class="formulario-regiao-titulo">
                <div class="separador" style="padding: 0; padding-top: 5px; margin: 0 auto; float:left; margin-left:25%;  width: 50%;" ><span style="color: #ddd;  font-size: 15px;">Cadastro de Região</span><input id='mostraForm'type="button" style="background-color: rgba(000,000,000,0.1); border:0; float:right; color:#cc0000; padding-bottom: 5px;" value="Configurar" ></div>
    </div>
   
        <?php if(isset($_POST['cadastrar'])){
            $codigo = $_POST['codigo'];
            $nome = $_POST['nome'];
            $id_estado = $_POST['estado'];
            
            $id_cidade = $_POST['cidade'];
            $bairro_zona = $_POST['bairro_zona'];
            $descricao = $_POST['descricao'];
            $id_empresa = $_SESSION['id_empresa'];
            
            
         
            $cad = 0;
            if($id_estado != "no_sel" || $bairro_zona != ""){
                $cad = 1;
            }
            
            
            if($codigo != "" && $cad == 1){
                $regiao = new Regiao();
                $regiao->add_regiao($codigo, $nome, $id_estado, $id_cidade, $bairro_zona, $descricao, $id_empresa);
                $regiao->add_regiao_bd();
            }else if($codigo == ""){
                echo "<div class='msg'>Você precisa um codigo.</div>";
            }else if($id_estado == "no_sel" || $bairro_zona == ""){
                 echo "<div class='msg'>Você precisa uma regiao.</div>";
            }
           
        } ?>      
            <div id="form" hidden="on" id="cadastrar">
            <form method="POST" action="configuracoes">
            <div class="formulario-regiao-dados">
                <span>Código</span><input type="text" id="codigo" name="codigo">
            </div>
            <div class="formulario-regiao-dados">
                <span>Nome</span><input type="text" id="nome" name="nome">
            </div>
            <div class="formulario-regiao-dados">
                <span>Estado</span>
                 <?php //buscar array de CBO
                              $estado = new Estado();
                              $estados = $estado->get_name_all_uf();
                           ?>
                           <select style="width:50%" name="estado" id="estado" onchange="buscar_cidades()" style="width:100%">
                              <option value="no_sel">Selecione um estado</option>
                              <?php 
                                 foreach($estados as $key => $estado){
                                    echo '<option value="'.$estados[$key][0].'">'.$estados[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
            </div>
            <div class="formulario-regiao-dados">
                <span>Cidade</span>
                <div id="load_cidades">
                             <select style="width:50%" name="cidade" id="cidade" style="width:100%">
                               <option value="no_sel">Selecione um estado</option>
                             </select>
                </div>
            </div>
            <div class="formulario-regiao-dados">
                <span>Bairro/Zona</span><input type="text" id="bairro_zona" name="bairro_zona">
            </div>
            <div class="formulario-regiao-dados">
                <span>Descrição</span><textarea cols="3" id="desccricao" width="300px;" name="descricao"></textarea>
            </div>
                     <input   type="hidden" name="cadastrar" value="cadastrar">
            <div>
                <input style="margin: 20px;"  class="button" type="submit" id="cadastrar" name="cadastrar" value="Cadastrar">
            </div>
        </form> 
        </div>    
</div>



