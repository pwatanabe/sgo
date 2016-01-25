<script type="text/javascript">
    function expand(id_obg, id_btn){
        if(document.getElementById(id_obg).className == 'colapse'){
            // document.getElementById(id_obg).style.display = 'none';
            document.getElementById(id_obg).className = 'expand';
            document.getElementById(id_btn).text = '(Ocultar)';
            document.getElementById(id_btn).style.color = "#773333";
        }else{
            // document.getElementById(id_obg).style.display = 'block';
            document.getElementById(id_obg).className = 'colapse';
            document.getElementById(id_btn).text = '(Expandir)';
            document.getElementById(id_btn).style.color = "#337733";
        }
        
    }

</script>
<?php 
    
    $funcionario = new Funcionario(); 
    $funcionario = $funcionario->get_historico_func_by_id($_GET['id']); // Busca de todos os funcionarios que estao com oculto = 1\\
    if($funcionario){// se existe historico exibe
 ?>

        <div style="float:left; margin-left: 10px; width:40%;">
            <div style="float:left; width:100%;" class="historico" id="historico">
            <div style="float:left; clear:left; width: 98.5%; padding-left: 10px; padding-bottom: 10px; padding-top: 10px; background:url('../images/footer_lodyas.png'); margin-bottom:5px; box-shadow: 0px 0px 5px #ababab; text-align:center; color:#cdcdcd; border-radius:5px;"><b><span>HISTÓRICO DE ATUALIZAÇÕES</span></b></div>
            <?php
                $aux = 0;
                foreach ($funcionario as $key => $alterados) {  // Percorre o array de funcionario 
                    
                    ?>
                            <?php
                            //****** Descrição de campos ******
                            //$return[$aux][0] = id
                            //$return[$aux][1] = nome
                            //$return[$aux][2] = cod_serie
                            //$return[$aux][3] = salario_base
                            //$return[$aux][4] = id_endereco
                            //$return[$aux][5] = id_cbo
                            //$return[$aux][6] = data_dem
                            //$return[$aux][7] = qtd_horas_sem
                            //$return[$aux][8] = data_fim
                            //$return[$aux][9] = id_supervisor
                            //$return[$aux][10] = id_turno
                            //$return[$aux][11] = is_admin
                            //$return[$aux][12] = email
                            //$return[$aux][13] = data_ini
                            //$return[$aux][14] = id_valor_custo
                            
                            $turno = new Turno();
                            $turno = $turno->getTurnoById($alterados[10]);
                            $cbo = new CBO();
                            $cbo = $cbo->get_cbo_by_id($alterados[5]);
                            
                            if($alterados[11] == 1) // logica para imprimir administrador
                            {
                                $adm = "SIM";
                            }else{
                                $adm = "NÃO";
                            }
                              
                            $valor_custo = new Valor_custo();
                            $valor_custo = $valor_custo->get_valor_custo_id($alterados[14]);
                            
                            // $data = explode('-', $alterados[8]);
                            // $data_fim = $data[2].'/'.$data[1].'/'.$data[0];

                            $data_hora_ini = explode(' ', $alterados[13]);
                            $expl_date_ini = explode('-', $data_hora_ini[0]);
                            $data_ini = $expl_date_ini[2].'/'.$expl_date_ini[1].'/'.$expl_date_ini[0];
                            $data_ini .= '</b> às <b>'.$data_hora_ini[1];
                            
                            if($alterados[8] != '0000-00-00 00:00:00'){
                                $data_hora_fim = explode(' ', $alterados[8]);
                                $expl_date_fim = explode('-', $data_hora_fim[0]);
                                $data_fim = $expl_date_fim[2].'/'.$expl_date_fim[1].'/'.$expl_date_fim[0];
                                $data_fim .= '</b> às <b>'.$data_hora_fim[1];
                            }else{
                                $data_fim = 'Indeterminado';
                            }



                            // $data_ini = $alterados[13];
                            // $data_fim = $alterados[8];
                            
                                   
                            ?>
                        
                           
                            <div style="float:left; clear:left; width: 98.5%; padding-left: 10px; padding-bottom: 10px; padding-top: 10px; background-color:rgba(217,219,219,0.5); margin-bottom:5px; box-shadow: 0px 0px 5px #ababab"> <div style="float:left; width: 30%; font-size:15px;" ><span><b>Data do registro </b></span></div> <div style="float:left; font-size:15px;"> <span> <?php echo 'De <b>'.$data_ini. '</b> até <b>'.$data_fim ?> </b> </span></div> <div style="float:left; font-size:15px; margin-left:20px;"><span><b> <a id="<?php echo 'btn'.$aux ?>" name="<?php echo 'exp'.$aux ?>" onclick="expand(this.name, this.id)" style="cursor:pointer; color:#373;">(Expandir)</a></b></span></div></div>
                            <div class="colapse" id="<?php echo 'exp'.$aux ?>" >
                                    <div class="historico-itens"> <div style="float:left; width: 35%;"><span><b>Salario Base</b></span></div>                    <div style="float:left"><span><?php echo $alterados[3].",00"; ?></span></div></div>               
                                    <div class="historico-itens"> <div style="float:left; width: 35%;"><span><b>Turno</b></span></div>                           <div style="float:left"><span><?php echo $turno->nome; ?></span></div></div>
                                    <div class="historico-itens"> <div style="float:left; width: 35%;"><span><b>CBO</b></span></div>                             <div style="float:left"><span><?php echo $cbo->descricao; ?></span></div></div>
                                    <div class="historico-itens"> <div style="float:left; width: 35%;"><span><b>Administrador</b></span></div>                   <div style="float:left"><span><?php echo $adm; ?></span></div></div>
                                    <div class="historico-itens"> <div style="float:left; width: 35%;"><span><b>Jornada de trabalho(semanal)</b></span></div>    <div style="float:left"><span><?php echo $alterados[7]." Horas" ?> </span></div></div>
                                    <div class="historico-itens"> <div style="float:left; width: 35%;"><span><b>Email</b></span></div>                           <div style="float:left"><span><?php echo $alterados[12] ?></span></div></div>
                                    <div class="historico-itens"> <div style="float:left; width: 35%;"><span><b>Valor de Custo</b></span></div>                  <div style="float:left"><span><?php echo $valor_custo->valor ?></span></div></div>
                            </div>
                    
                    
          <?php $aux++;
             } ?>
                
            </div>
        </div>
<?php }// fim if($funcionario)?>
