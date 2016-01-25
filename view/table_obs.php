<?php
echo '<div class="observacao">';
   echo "<form method='post' action='index' onsubmit='return validate(this)'>";
   	echo '<input type="hidden" id="table_obs" name="table_obs" value="1">';
   	echo '<input type="hidden" id="id_func" name="id_func" value="'.$id_funcionario.'">';
      echo '<input type="hidden" id="hora" name="hora" value="'.$hora.'">';
      echo '<input type="hidden" id="data" name="data" value="'.$data.'">';
      echo '<input type="hidden" id="msg" name="msg" value="'.$msg_email.'">';
      echo '<input type="hidden" id="tipo_ordem" name="tipo_ordem" value="'.$tipo.'">';// tipo que esta na ordem 1 2 3 0
      // echo '<input type="hidden" id="tipo" name="tipo" value="'.$tipo.'">';
      echo '<input type="hidden" id="situacao_tempo" name="situacao_tempo" value="'.$situacao_tempo.'">';
      echo '<input type="hidden" id="atrasado_ou_adiantado" name="atrasado_ou_adiantado" value="'.$atrasado_ou_adiantado.'">';
      echo '<div style="border: 1px solid; padding: 10px; width: 600px; background-color:rgba(255,255,255,0.7); margin: 0 auto">'. $msg. '</div><br />';
   	echo "<table border='0' style='margin: 0 auto'>";
   		echo '<tr><td style="text-align:center" ><span class="alerta-msg">Motivo do atraso</span> <span class="alerta-msg" style="color:#565656;">(Em 10 minutos essa mensagem sera fechada)</span>:</td><td style="text-align:center"> </td></tr>';
   		echo '<tr><td colspan="2" style="text-align:center"><textarea id="observacao" name="observacao"></textarea> </td></tr>';
   		
   		// echo '<textarea id="obs"></textarea><br />';
   	echo "</table><br />";
      echo '<input type="submit"  id="btn_entrar" style="width:100px; color:#232323; background-color:#5a5; font-size:18px; cursor: pointer; border: 1px solid#343434;" title="Clique para concluir" value="Concluir"><br />';
      echo '<a href="index" style="text-decoration: none; font-size:12px; color:#565656" title="Clique para cancelar">Cancelar</a>';
   echo "</form>";
echo '</div>';
// <input onclick="reload()" type="button" id="n_inf" name="n_inf" value="Não Informar">

?>