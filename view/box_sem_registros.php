<script type="text/javascript">
    function exibe_oculta(id){
        if(id == 'funcionario'){
          document.getElementById('intervalo_datas').style.display = 'none';
        }else{
          document.getElementById('funcionario').style.display = 'none';
        }
        if(document.getElementById(id).style.display == 'none')
            document.getElementById(id).style.display = '';
        else
            document.getElementById(id).style.display = 'none';
    }


</script>
<?php

      // falta calcular a diferença de horario para colocar na coluna situação na tabela horarios
      
      if(isset($_POST['atualiza']) && $_POST['atualiza'] == 'box_sem_registros'){
           $data = $_POST['data'];
           $tipo = $_POST['tipo'];
           $hora = $_POST['hora'];
           $turno = $_POST['turno'];
           $id_funcionario = $_POST['id_funcionario'];
           $id_supervisor = $_POST['id_supervisor'];
           $observacao = $_POST['observacao'];
           $horario = new Horarios();
           
           //se hora turno > hora login quer dizer que estou adiantado
           if(strtotime($turno) > strtotime($hora)){
              $situacao = '-'.$horario->dif_horario($hora, $turno);
           }else{//se hora turno < hora login quer dizer que estou adiantado
              $situacao = '+'.$horario->dif_horario($turno, $hora);
           }
           
           $obs = new ObsSupervisor();

           $obs->add_obs($id_supervisor, $observacao);

           $id_obs = $obs->add_obs_bd();


          if($horario->corrige_horario($data, $tipo, $hora, $id_funcionario, $id_obs, $situacao)){
                echo "<script>window.location='principal';</script>";
          }else{
                // echo "<script>alert('Falha');</script>";
          }
          
      }
      if(isset($_POST['funcionario']) && $_POST['funcionario'] != ''){

            $nome = $_POST['funcionario'];
            get_esquecidos($nome, 2, $nome);
                    
                    
      }else if(isset($_POST['ini']) && $_POST['ini'] != '' && isset($_POST['fim']) && $_POST['fim'] != ''){
            
            $data = data_padrao_americano($_POST['ini']);
            $data2 = data_padrao_americano($_POST['fim']);

            get_esquecidos($data, 3, $data2);
                    
                    
      }else if(isset($_GET['desc']) && $_GET['desc'] == 'mes'){
            
            $data = date('Y-m');
            get_esquecidos($data, 1, $data);
                    
                    
      }else if(isset($_GET['desc']) && $_GET['desc'] == 'sem_registros'){
            $funcionario = new Funcionario();
            $turno = new Turno();
            
            $funcionario = $funcionario->get_func_id($_GET['id_func']);
            
            $turno = $turno->getTurnoById($funcionario->id_turno);

            if($_GET['tipo'] == 1){
                $tipo = 'iniciar o expediente';
                $hora_turno = $turno->ini_exp;
            }else if($_GET['tipo'] == 2){
                $tipo = 'iniciar do almoço';
                $hora_turno = $turno->ini_alm;
            }else if($_GET['tipo'] == 3){
                $tipo = 'encerrar o almoço';
                $hora_turno = $turno->fim_alm;
            }else{
                $tipo = 'encerrar o expediente';
                $hora_turno = $turno->fim_exp;
            } 
            echo '<div class="content-right" >
                    <div class="box-atrasos" style="">';
                echo '<table style="width:100%" border="0" >';
                echo '<tr><td style="text-align:center"><b>CORRIGIR HORÁRIO ESQUECIDO</b></td></tr>';
                echo '<tr>';
                echo '<td><b>Funcionário: </b>'.$funcionario->nome.'</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td>Esqueceu de <b>'.$tipo.' </b></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td><b>Turno: </b>'.$turno->desc.'</td>';
                echo '</tr>';
                echo '<tr><td style="background-color:rgba(200,200,200,0.5); text-align:center; padding:5px; border: 1px solid#cdcdcd;">Preencha o horário correto e adicione uma observação para o registro nos campos abaixo</td></tr>';
                

                echo '<form method="post" action="principal" onsubmit="return validate(this)">';
                echo '<input type="hidden" name="tipo" value="'.$_GET['tipo'].'">';
                echo '<input type="hidden" name="id_funcionario" value="'.$funcionario->id.'">';
                echo '<input type="hidden" name="id_supervisor" value="'.$funcionario->id_supervisor.'">';
                echo '<input type="hidden" name="turno" value="'.$hora_turno.'">';
                echo '<input type="hidden" name="data" value="'.$_GET['data'].'">';
                echo '<input type="hidden" name="atualiza" value="box_sem_registros">';

                echo '<tr>';
                echo '<td><b>Hora:* </b>';
                        echo '<input type="time" name="hora" style="border: 1px solid#cdcdcd; border-radius: 5px; padding-left:10px">';
                echo '</td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td><b>Observação:*</b></td>';
                echo '</tr>';
                echo '<tr>';
                echo '<td style="text-align:center"><textarea id="observacao" name="observacao" style="width: 500px; height:50px; resize:none;"></textarea></td>';
                echo '</tr>';
                echo '<tr><td style="text-align:center"><input type="submit" class="button" value="Salvar"> <input class="button" type="button" value="Cancelar" onclick="window.location.href=\'principal\'"></td></tr>';
                echo '</form>';
                echo '</table>';
                
            echo '</div></div>';
        }else{
              $data = date('Y-m-d');
              get_esquecidos($data, 0, $data);
        }//fim else

        function get_esquecidos($data, $tipo, $data2){
                  // echo 'Aguarde...';
                  $horario = new Horarios();
                  
                  $array = $horario->get_registros_esquecidos($data, $tipo, $data2);

                  $config = new Config();
                  $TEMP_LIMIT_ATRASO = $config->get_config("temp_limit_atraso", $_SESSION['id_empresa']);// tempo limite de atraso ou adiantamento aceito
                 // echo "<script>alert('".count($array)."');</script>";

                  if(count($array) > 0){ // verifica se existe registro
                     echo '<div class="content-right" id="content-right">
                    <div class="box-atrasos" style="">';
                         echo '<div class="cont" style="margin-left:480px;"><a name="exibe_box_sem_registros" onclick="oculta(this.name)"><img width="20px" src="../images/icon-fechar.png" onmouseover="info(\'pop1\')" onmouseout="fecharInfo(\'pop1\')"></a>
                              <div id="pop1" class="pop" style="display:none">
                                  <div id="titulo1" class="title-info-config"><span>Informações</span></div>
                                  <div id="content1" class="content-info">Clique para ocultar esse bloco, você pode exibi-lo novamente a qualquer momento em:<br /><b>Configurações > Layout</b></div>   
                              </div>
                         </div>';


                         echo '<table class="table-atrasos" border="0" style="box-shadow:0px 0px 5px #ccc;">';
                         // echo '<tr><td colspan="4"><img src="../images/rel.png"></td></tr>';
                         // if($tipo == 0){
                              echo '<tr><td colspan="4">';
                              echo '<a href="principal" style="font-size:12px">Ver hoje</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="principal?desc=mes" style="font-size:12px">Ver mês inteiro</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="exibe_oculta(\'intervalo_datas\')" style="cursor: pointer; font-size:12px">Ver por período</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="exibe_oculta(\'funcionario\')" style="cursor: pointer;font-size:12px">Ver por funcionário</a>';
                              echo '<br />';
                              if($tipo == 0)
                                  echo '<span style="color:#aaa">Exibindo registros de hoje '.date("d/m/Y").'</span><br />';
                              else if($tipo == 1)
                                  echo '<span style="color:#aaa">Exibindo registros para o mês '.date("m/Y").'</span><br />';
                              else
                                  echo '<span style="color:#aaa">Exibindo registros de '.date("d/m/Y",strtotime($data)).' até '.date("d/m/Y",strtotime($data2)).'</span><br />';
                              echo '</td></tr>';

                         // }else{
                         //      echo '<tr><td colspan="4">'.date("m/Y").'<br />'. '<a href="principal" style="font-size:12px">Ver hoje</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="exibe_oculta(\'intervalo_datas\')" style="font-size:12px">Ver por período</a>'.'</td></tr>';
                         // }
                         echo '<tr id="intervalo_datas" style="display:none; ">
                                <td colspan="4">
                                    <form name="dataini_datafim" action="principal" method="POST">
                                      <span>Inicio: </span> <input  onclick="carregaMascaras()" type="date" name="ini" id="ini" style="border: 1px solid#cdcdcd; border-radius: 5px">&nbsp;&nbsp;<span>Fim: </span><input  onclick="carregaMascaras()" id="fim" name="fim" style="border: 1px solid#cdcdcd; border-radius: 5px" type="date"> <input type="submit" value="Buscar">
                                    <form>
                                </td>
                              </tr>';
                         echo '<tr id="funcionario" style="display:none; ">
                                <td colspan="4">
                                    <form name="nome_func" action="principal" method="POST">
                                      <span>Nome: </span> <input type="text" name="funcionario" style="padding-left:5px;border: 1px solid#cdcdcd; border-radius: 5px"> <input type="submit" value="Buscar">
                                    <form>
                                </td>
                              </tr>';
                         echo '<tr><td colspan="4"><b>Atenção</b></td></tr>';
                         echo '<tr><td colspan="4"><span>Os funcionários abaixo esqueceram ou não bateram o ponto</span></td></tr>';
                         
                         
                         $title = 'Clique para justificar o atraso';
                         $funcionario = new Funcionario();
                         $turno = new Turno();
                         $table_color = 0; // para fazer a tabela zebrada
                         $total_registros = 0;
                         echo '<tr>
                         <td colspan="4">';
                         echo '<div style="overflow-y: scroll; height: 190px;">';
                         echo '<table style="text-align:center; width:100%" border="0">';
                         echo '<tr><td><b>Funcionário</b></td><td><b>Tipo</b></td>';
                         if($tipo == 1){
                            echo  '<td><b>Data</b></td>';
                         }
                         echo '</tr>';
                         for($aux = 0; $aux < count($array); $aux++){
                                /*
                                  $array[$aux][0] -> 'id'
                                  $array[$aux][1] -> 'data'
                                  $array[$aux][2] -> 'id_funcionario'
                                  $array[$aux][3] -> 'tipo_1'
                                  $array[$aux][4] -> 'tipo_2'
                                  $array[$aux][5] -> 'tipo_3'
                                  $array[$aux][6] -> 'tipo_0'
                                */
                                  
                                $nome_turno_funcionario = $funcionario->get_nome_by_id($array[$aux][2]);
                                $turno = $turno->getTurnoById($nome_turno_funcionario[1]);
                                
                                $hora = strtotime(date('H:i:s'));
                                $hora_turno['ini_exp'] = strtotime($turno->ini_exp)+$TEMP_LIMIT_ATRASO*60;
                                $hora_turno['ini_alm'] = strtotime($turno->ini_alm)+$TEMP_LIMIT_ATRASO*60;
                                $hora_turno['fim_alm'] = strtotime($turno->fim_alm)+$TEMP_LIMIT_ATRASO*60;
                                $hora_turno['fim_exp'] = strtotime($turno->fim_exp)+$TEMP_LIMIT_ATRASO*60;
                                // echo $hora;
                                
                                if($array[$aux][3] == 0 && ($hora > $hora_turno['ini_exp'] || strtotime($data) < strtotime($array[$aux][1]))  ){ //tipo_1
                                      
                                      if(date('D',strtotime($array[$aux][1])) != 'Sun' && date('D',strtotime($array[$aux][1])) != 'Sat'){
                                          if($table_color%2 == 0){
                                              echo '<tr style="background-color:#eee">'; $table_color++;                      
                                          }else{
                                              echo '<tr style="background-color:#dedede">'; $table_color++;
                                          }
                                      }else{
                                              echo '<tr style="background-color:rgba(250,10,10,0.3)">'; 
                                      }
                                      echo '<td class="rows-content"><a href="principal?desc=sem_registros&tipo=1&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>'.$nome_turno_funcionario[0].'</b></a></td><td class="rows-content"><a href="principal?desc=sem_registros&tipo=1&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>Inicio expediente</b></a></td>';
                                      if($tipo == 1 || $tipo == 3){
                                          echo '<td class="rows-content"><a href="principal?desc=sem_registros&tipo=1&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>'.date('d/m/Y',strtotime($array[$aux][1])).'</b></a></td>';
                                      }
                                      echo '</tr>';
                                      $total_registros++;
                                }
                                if($array[$aux][4] == 0 && ($hora > $hora_turno['ini_alm'] || strtotime($data) < strtotime($array[$aux][1])) && $turno->sem_hor_almoco != '1'){ //tipo_2
                                      if(date('D',strtotime($array[$aux][1])) != 'Sun' && date('D',strtotime($array[$aux][1])) != 'Sat'){
                                        if($table_color%2 == 0){
                                            echo '<tr style="background-color:#eee">'; $table_color++;                      
                                        }else{
                                            echo '<tr style="background-color:#dedede">'; $table_color++;
                                        }
                                      }else{
                                              echo '<tr style="background-color:rgba(250,10,10,0.3)">'; 
                                      }
                                      echo '<td class="rows-content"><a href="principal?desc=sem_registros&tipo=2&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>'.$nome_turno_funcionario[0].'</b></a></td><td class="rows-content"><a href="principal?desc=sem_registros&tipo=2&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>Inicio Almoço</b></a></td>';
                                      if($tipo == 1 || $tipo == 3){
                                          echo '<td class="rows-content"><a href="principal?desc=sem_registros&tipo=2&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>'.date('d/m/Y',strtotime($array[$aux][1])).'</b></a></td>';
                                      }
                                      echo '</tr>';
                                      $total_registros++;
                                }
                                if($array[$aux][5] == 0 && ($hora > $hora_turno['fim_alm'] || strtotime($data) < strtotime($array[$aux][1])) && $turno->sem_hor_almoco != '1'){ //tipo_3
                                      if(date('D',strtotime($array[$aux][1])) != 'Sun' && date('D',strtotime($array[$aux][1])) != 'Sat'){
                                          if($table_color%2 == 0){
                                              echo '<tr style="background-color:#eee">'; $table_color++;                      
                                          }else{
                                              echo '<tr style="background-color:#dedede">'; $table_color++;
                                          }
                                      }else{
                                              echo '<tr style="background-color:rgba(250,10,10,0.3)">'; 
                                      }
                                      echo '<td class="rows-content"><a href="principal?desc=sem_registros&tipo=3&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>'.$nome_turno_funcionario[0].'</b></a></td><td class="rows-content"><a href="principal?desc=sem_registros&tipo=3&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>Fim Almoço</b></a></td>';
                                      if($tipo == 1 || $tipo == 3){
                                          echo '<td class="rows-content"><a href="principal?desc=sem_registros&tipo=3&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>'.date('d/m/Y',strtotime($array[$aux][1])).'</b></a></td>';
                                      }
                                      echo '</tr>';
                                      $total_registros++;
                                } 
                                if($array[$aux][6] == 0 && ($hora > $hora_turno['fim_exp'] || strtotime($data) < strtotime($array[$aux][1])) ){ //tipo_0
                                      if(date('D',strtotime($array[$aux][1])) != 'Sun' && date('D',strtotime($array[$aux][1])) != 'Sat'){
                                          if($table_color%2 == 0){
                                              echo '<tr style="background-color:#eee">'; $table_color++;                      
                                          }else{
                                              echo '<tr style="background-color:#dedede">'; $table_color++;
                                          }
                                      }else{
                                              echo '<tr style="background-color:rgba(250,10,10,0.3)">'; 
                                      }
                                      echo '<td class="rows-content"><a href="principal?desc=sem_registros&tipo=0&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>'.$nome_turno_funcionario[0].'</b></a></td><td class="rows-content"><a href="principal?desc=sem_registros&tipo=0&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>Fim expediente</b></a></td>';
                                      if($tipo == 1 || $tipo == 3){
                                          echo '<td class="rows-content"><a href="principal?desc=sem_registros&tipo=0&id_func='.$array[$aux][2].'&data='.$array[$aux][1].'"><b>'.date('d/m/Y',strtotime($array[$aux][1])).'</b></a></td>';
                                      }
                                      echo '</tr>';
                                      $total_registros++;
                                }
 
                         }
                         echo '</table>';
                         echo '</div>';
                         echo '</td></tr>';
                         if($total_registros > 0){
                            echo '<tr><td colspan="4" style="text-align: right; padding-top: 5px; color:#555; font-size: 12px;">';
                            if($tipo == 1){
                              echo '<div style="border-radius: 50%; border: 1px solid#555; float:left; height: 11px; width:11px; background-color:rgba(250,10,10,0.3)"></div><div style="float:left; margin-left: 5px;"> Sábados e domingos</div>';
                            }
                            echo 'Clique para corrigir </td></tr>';
                            echo "<script>document.getElementById('content-right').style.display='block'</script>";
                         }else{
                            echo '<tr><td colspan="4" style="padding-top: 15px; color:#555; font-size: 12px;">Nenhum horário registrado!</td></tr>';
                         }
                         echo '<div class="cont" style="color:#f33;font-size:15px;  text-align:left"><b>'.$total_registros.'</b></div>';
                         echo '</table>';
                }else{//fim if count($array) > 0
                  echo '<div class="content-right" id="content-right">
                    <div class="box-atrasos" style="">';
                    echo '<table class="table-atrasos" border="0" style="box-shadow:0px 0px 5px #ccc;">';
                         // echo '<tr><td colspan="4"><img src="../images/rel.png"></td></tr>';
                         // if($tipo == 0){
                              echo '<tr><td colspan="4">';
                              echo '<a href="principal" style="font-size:12px">Ver hoje</a>&nbsp;&nbsp;&nbsp;&nbsp;<a href="principal?desc=mes" style="font-size:12px">Ver mês inteiro</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="exibe_oculta(\'intervalo_datas\')" style="cursor: pointer;font-size:12px">Ver por período</a>&nbsp;&nbsp;&nbsp;&nbsp;<a onclick="exibe_oculta(\'intervalo_datas\')" style="cursor: pointer;font-size:12px">Ver por funcionário</a>';
                              echo '<br />';
                              if($tipo == 0)
                                  echo '<span style="color:#aaa">Exibindo registros de hoje '.date("d/m/Y").'</span><br />';
                              else if($tipo == 1)
                                  echo '<span style="color:#aaa">Exibindo registros para o mês '.date("m/Y").'</span><br />';
                              else
                                  echo '<span style="color:#aaa">Exibindo registros de '.date("d/m/Y",strtotime($data)).' até '.date("d/m/Y",strtotime($data2)).'</span><br />';
                              echo '</td></tr>';

                         $total_registros = 0;
                         echo '<tr>
                         <td colspan="4">';
                        echo 'NENHUM REGISTRO FOI ENCONTRADO NESSE PERÍODO';
                         echo '</td></tr>';
                         echo '<div class="cont" style="color:#f33;font-size:15px;  text-align:left"><b>'.$total_registros.'</b></div>';
                         echo '</table>';
                  echo '</div></div>';
                }
            echo'</div>
            </div>';
        }
 ?>