<?php 
// ATENÇÃO 
// ARQUIVO USADO SOMENTE COMO BACKUP DE CODIGO, PODENDO SER APAGADO A QUALQUER MOMENTO SEM AFETAR
// O FUNCIONAMENTO DO SISTEMA.
//for($e = 0; $e < $_SESSION['obra']['etapas']; $e++){ 
//echo '<div style="text-align:center"><b>ETAPA '.($e+1).'</b></div>';
?>
<table cellpadding="0" cellspacing="0" border="0" style="width:100%; text-align:center; margin-bottom:20px;">
      <tr>
            <td>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
            <?php
              
              
                   $data = $_SESSION['obra']['dados']['data_inicio_previsto'];
                   montaCabecalho($data, 15);
              
            ?>
      </tr>
      
      <?php 
        
            for($p = 0; $p < count($_SESSION['obra']['produto']); $p++){
                $id_qtd = explode(':', $_SESSION['obra']['produto'][$p]);
                $res = new Produto();
                $res = $res->get_produto_id($id_qtd[0]);
                ?>
                  <tr <?php echo 'id="tr-'.$res->id.'"'; ?> class="row-table" title="">
                      <td><span><?php echo $res->nome ?> </span></td>
                      

                      <?php
                      
                           $data = $_SESSION['obra']['dados']['data_inicio_previsto'];
                           $arrayData = explode("-", $data);
                           // echo "<script>alert('$data');</script>";
                           $dia = $arrayData[2];
                           $mes = $arrayData[1];
                           $ano = $arrayData[0];
                           for($aux = 0; $aux <= 100; $aux++) {
                               echo '<td id="'.$res->id.'-'.date('Y-m-d', strtotime("$data +$aux days")).'" style="';
                               echo 'padding:0px; margin: 0; border-right: 1px solid #cdcdcd"><span style="color:#cdcdcd; font-size: 10px">'.date('d/m/Y', strtotime("$data +$aux days")).'</span></td>';
                           }
                      
                      ?>
                  </tr>
          <?php }//fim for 

        ?>
      
</table>
<?php //} ?>