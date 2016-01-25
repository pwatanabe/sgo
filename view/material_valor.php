        <div class="separador" ><span style="color: #ddd;" class="title">VALORES MATERIAIS X REGIÃO</span> <input type="button" style="background-color: rgba(000,000,000,0.1); border:0; float:right; color:#cc0000" value="Editar" onclick="hideall('opcoes-materiais')" ></div> <!-- HIDEALL PARA MOSTRAR OPÇÕES ACAO ESTA EM CONFIGURACOES -->
        
        <div id="opcoes" style="float:left; width: 100%;">
            <div class="opcoes-materiais" id="opcoes-materiais" hidden="on">
                <div class="materiais"><span>Cadastrar por...</span>
                    <select id="add_valor" name="3" value="Adicionar valor" onchange="mostraTabela1(this.name)">
                        <option value="1">Selecione</option>
                        <option value="2">Região</option>
                    </select>
                </div>
            </div>
        </div>
       
        <div id="3" hidden="on"> 
            
            <form method="GET" action="../administrator/add_material.php">
            <?php
            
            $regioes = new Regiao();
            $regiao = $regioes->get_all_regiao();
            $cidade = new Cidade();
            $estado = new Estado();
            
            
                        foreach ($regiao as $key => $value) { 
                            $nomeestado = $estado->get_name_estado_by_id($regiao[$key][2]);
                            $cidade->get_city_by_id($regiao[$key][3]);
                            $nomecidade = $cidade->nome;
                            ?>
                
                <div class="material-valor-regioes" name="regiao" id="regiao">
                                       
                        <span><?php echo $regiao[$key][0].' '.$regiao[$key][1]?></span>
                        <input type="radio" name="regiao" id="regiao" value="<?php echo $regiao[$key][0] ?>"><img onclick="infoRegiao(<?php echo "'".$regiao[$key][0]."'"; ?>)" style=" float:right; margin-right: 50px;width:20px; height: 20px; padding-bottom: 5px;" src="../images/info.png">
                                      
                </div>            
                        
                <div class="popup" style="margin: -500px" id="<?php echo $regiao[$key][0]; ?>">
                            <table>
                                <div><img style="float:right; width: 20px; height: 20px" onclick="fechaInfo(<?php echo "'".$regiao[$key][0]."'"; ?>)" src="../images/fechar.png"></div>
                                <tr><td><span>Nome:</span></td><td><span><?php echo $regiao[$key][1]?></span></td></tr>
                                <tr><td><span>Estado:</span></td><td><span><?php echo $nomeestado;?></span></td></tr>
                                <tr><td><span>Cidade:</span></td><td><span><?php echo $nomecidade?></span></td></tr>
                                <tr><td><span>Bairro/Zona:</span></td><td><span><?php echo $regiao[$key][4]?></span></td></tr>
                                <tr><td><span>Descricao:</span></td><td><span><?php echo $regiao[$key][5]?></span></td></tr>                                
                            </table>
                        </div>   
                
                <?php $cidade->nome = ""; } ?>
               
                <input style="float:right; width: 80px; margin-right: 50px "type="submit">
            </form>
        </div>
        

        <?php
        if (isset($_GET['regiao']))  {
            $regioes = new Regiao();
            $regiao = $regioes->get_regiao_codigo($_GET['regiao']);
            $id_regiao = $regiao->id;     
            ?>
            <div id="4" >          
                <div id="menu-materiais" name="menu-materiais" class="menu-materiais">
                    <span style="margin-left: 8px;"><b>Nome</span>
                    <span>Unidade</span>                 
                    <span>Valor</span>                    
                    <span style="float:right; margin-top:-5px; color:#ddd;font-weight: bold; font-size: 25px;"><?php echo $regiao->codigo;?></span>
                </div>
                <form method="POST" id="materiais" action="../administrator/salva_materiais_valor.php"> 
                    <?php if(isset($_GET['backto'])){ // se essa variavel estiver setada quer dizer que o arquivo foi chamado da pagina add_obra
                                echo '<input type="hidden" name="backto" value="'.$_GET['backto'].'">';// armazena o endereço para o redirecinamento no final
                            } ?> 
                    <div class="master-materiais">   

                        <?php
                        $custo_regiao = new Custo_regiao();                       
                        $t_c = new Tipo_custo();                        
                        $unidade_medida = new Unidade_medida();                       
                        $material = new Material();
                        $v_c = new Valor_custo();
                        $material = $material->get_all_material();
                        $t_c = $t_c->get_all_tipo_custo();
                        $id_empresa = $_SESSION['id_empresa'];
                        
                        
                        foreach ($material as $key => $value) {
                            $u_m = new Unidade_medida(); //u_m UNIDADE DE MEDIDA
                            $u_m = $u_m->get_unidade_medida_by_id($value[2]);
                            $id_material = $material[$key][0];
                            
                            $valor = $custo_regiao->get_valor($id_material, $id_regiao, $id_empresa);
                                    
                                    
                            ?>
                            <div class="adicionando-valores" style="margin-top: 10px;" >       

                                <div class="materiais">
                                    <input type="hidden" name="<?php echo $id_material.":regiao" ?>" id="<?php echo $id_material.":regiao" ?>" value="<?php echo $regiao->codigo.':'.$regiao->id; ?>">
                                    <input readonly style="width: 20%" type="text" name="<?php echo $id_material.":material" ?>" id="<?php echo $id_material.":material" ?>" value="<?php echo $value[1]; ?>"> 
                                    <input readonly style="width: 10%; margin-left:5px" type="text" name="<?php echo $id_material.":medida" ?>" id="<?php echo $u_m->id.":medida" ?>" value="<?php echo $u_m->sigla ?>"> 
                                    <input style="width: 25%; margin-left: 5px; text-align: left;" type="text" id="<?php echo $id_material.":valor_custo" ?>" name="<?php echo $id_material.":valor_custo" ?>" onkeyup="mascara(this, mvalor);" value="<?php if($valor!= ""){ echo 'R$' . number_format($valor, 2, ',', '.');}?>"> 
                              
                                </div>        
                            </div>

                            <?php
                            $v_c->valor = "";
                        }
                        ?>

                    </div> 
                    <div class="salvar-editar"> 
                       
                    <input type="submit" value="" class="button-tabela-material-salvar"> 
                       
                    </div>
                </form>
            </div>

        <?php }
//        if(!isset($_GET['axestado']) || $_GET['axestado'] == "no_sel" ){
//            
//            echo '<script>ocultaTabela(4)</script>';
//        }
        ?>      

