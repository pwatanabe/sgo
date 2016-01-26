<?php 
      // error_reporting(E_ALL);
      if(isset($_POST['observacao']) && isset($_POST['atualiza']) && $_POST['atualiza'] == 'box_atrasos'){// salva observação no banco de dados
         
            $id = $_POST['id_horario'];
            $observacao = $_POST['observacao'];
            $g = new Glob();

            $id_supervisor = $_SESSION['id'];

            $obs = new ObsSupervisor();

            $obs->add_obs($id_supervisor, $observacao);

            $id_obs = $obs->add_obs_bd();

            $g->tratar_query("UPDATE horarios SET id_obs_supervisor = '%s' WHERE id = '%s'", $id_obs, $id);

             echo "<script>window.location='principal';</script>";
  
      }
  
      if(isset($_GET['id_horario']) && $_GET['id_horario'] != ""){
          $horario = new Horarios();
          $horario = $horario->get_horario_by_id($_GET['id_horario'] );
          
          $data_inicio = date('Y-m').'-01';
          $data_final = date('Y-m-d');
          $id_funcionario = $horario->id_funcionario;
          $historico_atrasos =  $horario->get_atrasos_intervalo_func($data_inicio, $data_final, $id_funcionario);
          
          $funcionario = new Funcionario();
          $funcionario = $funcionario->get_func_id($horario->id_funcionario);
          
          $string = $funcionario->nome.', ';
          if($horario->tipo == 1){
              $string .= ' iniciou o expediente ';
          }else if($horario->tipo == 2){
              $string .= ' iniciou o almoço ';
          }else if($horario->tipo == 3){
              $string .= ' encerrou o almoço ';
          }else{
              $string .= ' encerrou o expediente ';
          }
          $string .= substr($horario->situacao, 1). " atrasado";
          echo '<div class="content-right" >
                <div class="box-atrasos" style="">';

          echo '<form method="POST" action="principal" onsubmit="return validate(this)">';
              echo '<input type="hidden" name="atualiza" value="box_atrasos">';
              echo '<input type="hidden" id="id_horario" name="id_horario" value="'.$_GET['id_horario'].'">';
              echo '<table class="table-aniversariantes" border="0" style="background-color:#dedede; box-shadow:0px 0px 5px #ccc; border: 1px solid#cecece">';
                  echo '<tr><td colspan="5"><b>HISTÓRICO DE ATRASOS</b></td></tr>';
                  echo '<tr><td colspan="5" ><div style="border: 1px solid#cdcdcd; height: 100px; overflow-y: scroll">';
                        echo '<table style="width:100%; text-align:center">';
                        echo '<tr><td>Data</td> <td>Hora</td> <td>Tipo</td><td>Atrasado</td><td>Observacao</td> </tr>';
                        $total_reg = 0;
                        if(count($historico_atrasos) > 0){
                            for ($i=0; $i < count($historico_atrasos); $i++) {
                                $data = explode('-', $historico_atrasos[$i][6]);
                                $data = $data[2].'/'.$data[1].'/'.$data[0];
                                if($i%2 == 0)
                                  echo '<tr style="background-color:#eee;">';
                                else
                                  echo '<tr style="background-color:#ddd">';
                                  echo '<td style="padding:0px 3px 0px 3px"><span>'.$data.'</span></td><td><span>'.$historico_atrasos[$i][1].'</span></td><td><span>'.$historico_atrasos[$i][4].'</span></td><td><span>'.$historico_atrasos[$i][2].'</span></td><td><span><a onclick="exibePopAtrasos(\'popup2'.$i.'\')" style="cursor:pointer">'.((strlen($historico_atrasos[$i][7]) > 17) ? substr($historico_atrasos[$i][7], 0, 17).'...' : $historico_atrasos[$i][7]).'</a></span></td></tr>';
                               
                              echo '<div id="popup2'.$i.'" class="popup2" style="float:left">
                                      <div class="formulario" style="width:385px; min-width:385px">
                                          <div style="float:right"><a onclick="fecharPopAtrasos(\'popup2'.$i.'\')" style="cursor:pointer"><img src="../images/icon-fechar.png"></a></div>
                                          <div><b>Data: </b>'.$data.' <b>Hora do registro: </b>'.$historico_atrasos[$i][1].'</div>
                                          <div>'.$historico_atrasos[$i][4].' '.substr($historico_atrasos[$i][2],1).' atrasado</div><br />
                                          <b>Observação do funcionário:</b><br />
                                          <div style="max-height:140px; overflow-y: scroll">'.$historico_atrasos[$i][7].'</div>
                                          
                                      </div>
                                    </div>';
                                $total_reg++;
                             }
                         }
                         echo '</table>';
                   echo '</div></td></tr>';
                   echo '<tr><td colspan="5" style="text-align:right; color: #9a9a9a"><span>Total de registros: '.$total_reg.'</span></td></tr>';
                   echo '</table>';
                   echo '<table  class="table-aniversariantes" border="0">';
                   echo '<tr><td colspan="5"><b>Hoje</b><br /><span>'.date("d/m/Y").'</span></td></tr>';
                   // echo '<tr><td colspan="4"><b>Justificar atraso</b></td></tr>';
                   echo '<tr><td colspan="5">'.$string.'</td></tr>';
                   echo '<tr><td colspan="5" style="text-align:left; padding-left:10px; padding-top: 10px;"><b>Motivo do atraso:</b></td></tr>';
                   echo '<tr><td colspan="5" style="text-align:left; padding-left:30px; color:#454545; "><div style="max-height:50px; height:50px; overflow-y:scroll">'.$horario->observacao_funcionario.'</div></td></tr>';
                   echo '<tr><td colspan="5" style="text-align:left; padding-left:10px; padding-top: 10px;"><b>Justifique esse atraso:*</b></td></tr>';
                   echo '<tr><td colspan="5"> <textarea id="observacao" name="observacao" style="width: 450px; height:50px; resize:none;"></textarea> </td></tr>';
                   echo '<tr><td colspan="5" style="padding-top:5px"> <input type="submit" class="button" value="Salvar"> <input class="button" type="button" value="Cancelar" onclick="window.location.href=\'principal\'"> </td></tr>';
               echo '</table>';
          echo '</form>';
          echo '</div>
            </div> ';
          
      }else{
          $horario = new Horarios();
          $array = $horario->get_atrasos(date("Y-m-d"));

          if(count($array) > 0){
              echo '<div class="content-right" >
                <div class="box-atrasos" style="">';
                  echo '<div class="cont" style="margin-left:480px;"><a name="exibe_box_atrasos" onclick="oculta(this.name)"><img width="20px" src="../images/icon-fechar.png" onmouseover="info(\'pop2\')" onmouseout="fecharInfo(\'pop2\')"></a>
                              <div id="pop2" class="pop" style="display:none">
                                  <div id="titulo2" class="title-info-config"><span>Informações</span></div>
                                  <div id="content2" class="content-info">Clique para ocultar esse bloco, você pode exibi-lo novamente a qualquer momento em:<br /><b>Configurações > Layout</b></div>   
                              </div>
                         </div>';
                 echo '<div class="cont" style="color:#f33;font-size:15px;  text-align:left"><b>'.count($array).'</b></div>';
                 
                 echo '<table class="table-atrasos" style="box-shadow:0px 0px 5px #ccc;">';
                 echo '<tr>
                          <td colspan="4">
                            <div class="time">
                                  <input type="text" id="txtRelogio" disabled name="relogio" size="10" style="font-size:26px;height:45px;"> 
                            </div>
                          </td>
                      </tr>';
                 echo '<tr><td colspan="4">'.date("d/m/Y").'</td></tr>';
                 echo '<tr><td colspan="4"><b>Atrasos</b></td></tr>';
                 echo '</table>';
                 if(count($array) >= 3){// exibe com scroll
                    echo '<div  style="height: 188px; overflow-x: hidden; overflow-y: ">';
                 }else{//exibe sem scroll
                    echo '<div class="table-atrasos"  style="height: 188px;">';
                 }
                 
                 echo '<table class="table-atrasos scroll" style="box-shadow:0px 0px 5px #ccc;">';
                 echo '<tr><td>Funcionário</td><td>Tipo</td><td>Hora</td><td>Tempo de atraso</td></tr>';
                 $title = 'Clique para justificar o atraso';
                 for($aux = 0; $aux < count($array); $aux++){
                    if($array[$aux][5] == 0){// se não existe observação do supervisor
                      if($aux%2 == 0){
                          echo '<tr style="background-color:#eee">';
                      }else{
                          echo '<tr style="background-color:#dedede">';
                      }
                         echo '<td class="rows-content"><a title="'.$title.'" href="principal?id_horario='.$array[$aux][0].'"><b>'.$array[$aux][3][0].'</b></a></td><td class="rows-content"><a title="'.$title.'" href="principal?id_horario='.$array[$aux][0].'"><b>'.$array[$aux][4].'</b></a></td><td class="rows-content"><a title="'.$title.'" href="principal?id_horario='.$array[$aux][0].'"><b>'.$array[$aux][1] .'</b></a></td><td class="rows-content"> <a title="'.$title.'" href="principal?id_horario='.$array[$aux][0].'"><b>'. substr($array[$aux][2], 1).'</b></a></td><td><img title="Não justificado" width="20px;" src="../images/aviso.png"></td>';
                       echo '</tr>';
                    }else{ // se existe observação do supervisor
                       if($aux%2 == 0){
                          echo '<tr style="background-color:#eee">';
                        }else{
                            echo '<tr style="background-color:#dedede">';
                        }
                         echo '<td class="rows-content">'.$array[$aux][3][0].'</td><td class="rows-content">'.$array[$aux][4].'</td><td class="rows-content">'.$array[$aux][1] .'</td><td class="rows-content"> '. substr($array[$aux][2], 1).'</td><td><a><img title="Justificado" width="20px;" src="../images/check.png"><a></td>';
                       echo '</tr>';
                    }
                 }
                 echo '</table>';
                 echo '</div>';
                 if(count($array) > 0){
                    echo '<div style="text-align: right; padding-top: 5px; color:#555; font-size: 12px;">Clique para justificar o atraso </div>';
                 }else{
                    echo '<div style="text-align: right; padding-top: 5px; color:#555; font-size: 12px;">Nenhum horário registrado </div>';
                 }
                 echo '</div>
            </div> ';
            }
      }
?>