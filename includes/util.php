<?php 

function data_padrao_americano($data){
      if(strpos($data, '/') === false){
          return $data;
      }else{
          $d = explode('/', $data);
          return $d[2] .'-'.$d[1].'-'.$d[0];
      }
}

function data_padrao_brasileiro($data){
      if(strpos($data, '-') === false){
          return $data;
      }else{
          $d = explode('-', $data);
          return $d[2] .'/'.$d[1].'/'.$d[0];
      }
}
//monta cabeçalho do cronograma em obras
function montaCabecalho($data_ini, $dias){
      for($aux = 0; $aux <= $dias; $aux++) {
          echo '<td  style="padding:5px; border-right: 1px solid #cdcdcd"><span><b>'.date('d/m/Y', strtotime("$data_ini +$aux days")).'</b></span></td>';
      }

  }
function transformaLabel($text){
  
  $text = str_replace('_', ' ', $text);
  $text = str_replace('-', ' ', $text);
  $text = str_replace('id ', '', $text);
  $text = str_replace('ID ', '', $text);

  return ucfirst(strtolower($text));
}

 ?>