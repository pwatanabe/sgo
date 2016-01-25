<?php 
    $func = new Funcionario();
    $array = $func->aniversariantes_mes(date("d/m/Y"));
    switch(count($array)){
      case 0:
              echo '<img class="cont" src="../images/0.png">';
              break;
      case 1:
              echo '<img class="cont" src="../images/1.png">';
              break;
      case 2:
              echo '<img class="cont" src="../images/2.png">';
              break;
      case 3:
              echo '<img class="cont" src="../images/3.png">';
              break;
      case 4:
              echo '<img class="cont" src="../images/4.png">';
              break;
      case 5:
              echo '<img class="cont" src="../images/5.png">';
              break;
      case 6:
              echo '<img class="cont" src="../images/6.png">';
              break;
      case 7:
              echo '<img class="cont" src="../images/7.png">';
              break;
      case 8:
              echo '<img class="cont" src="../images/8.png">';
              break;
      case 9:
              echo '<img class="cont" src="../images/9.png">';
              break;
      default:
              echo '<img class="cont" src="../images/10.png">';
              break;
    }     
    
    echo '<table class="table-aniversariantes">';
    echo '<tr><td colspan="2"><img src="../images/aniversario.png"></td></tr>';
    echo '<tr><td colspan="2">'.date("m/Y").'</td></tr>';
    echo '<tr><td colspan="2"><b>Aniversáriantes do mês</b></td></tr>';
    for($aux = 0; $aux < count($array); $aux++){
        $padrao_bra = explode("-", $array[$aux][2]);
        $padrao_bra = $padrao_bra[2].'/'.$padrao_bra[1].'/'.$padrao_bra[0];
        echo '<tr>';
          echo '<td class="rows-content">'.$array[$aux][1] .'</td><td class="rows-content"> '.$padrao_bra.'</td>';
        echo '</tr>';
    }
    echo '</table>';
?>