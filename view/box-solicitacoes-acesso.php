<?php 
      
          $solicitacoes = new Solicita_acesso();
          $array = $solicitacoes->get_solicitacoes();

          if(count($array) > 0){
              echo '<div class="content-right" >
                <div class="box-atrasos" style="width:96%">';
                 echo '<div class="cont" style="color:#f33;font-size:15px;  text-align:center"><b>'.count($array).'</b></div>';
                 
                 echo '<table class="table-atrasos" style="box-shadow:0px 0px 5px #ccc;">';
                 echo '<tr><td colspan="4"><b>Solicitações de acesso</b></td></tr>';
                 echo '</table>';
                 if(count($array) > 6){// exibe com scroll
                    echo '<div  style="height: 165px; overflow-x: hidden; overflow-y: scroll;">';
                 }else{//exibe sem scroll
                    echo '<div class="table-atrasos"  style="height: 165px;">';
                 }
                 
                 echo '<table class="table-atrasos scroll" style="box-shadow:0px 0px 5px #ccc;">';
                 echo '<tr><td>Nome</td><td>Empresa</td><td>Telefone</td></tr>';
                 $title = 'Clique para permitir esse acesso';
                 for($aux = 0; $aux < count($array); $aux++){
                    if($array[$aux][5] == 0){// se não existe observação do supervisor
                      if($aux%2 == 0){
                          echo '<tr style="background-color:#eee">';
                      }else{
                          echo '<tr style="background-color:#dedede">';
                      }
                         echo '<td class="rows-content"><a title="'.$title.'" href="permitir_acesso?id_sol_acesso='.$array[$aux][0].'"><b>'.$array[$aux][2].'</b></a></td><td class="rows-content"><a title="'.$title.'" href="permitir_acesso?id_sol_acesso='.$array[$aux][0].'"><b>'.$array[$aux][5].'</b></a></td><td class="rows-content"><a title="'.$title.'" href="permitir_acesso?id_sol_acesso='.$array[$aux][0].'"><b>'.$array[$aux][3] .'</b></a></td><td><img title="Não justificado" width="20px;" src="../images/aviso.png"></td>';
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
?>