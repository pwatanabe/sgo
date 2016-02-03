<?php  if($_GET['tipo'] == 1){
    

echo '<div style="position: absolute; z-index: 2;  background-color: rgb(240, 245, 230); border: 1px solid#aaa; border-radius: 10px; margin-bottom: 20px; transition: all 2s; padding: 20px; box-shadow: 0px 0px 10px #aaa; float: left; " id="tipo_data">';
   echo '<a style="float: right" href="add_contas#formulario-apagar" onclick="fechaParcela()">X</a>';
   echo '<table><tr>';
  
    $parcelas = 1; 
    
        echo "<td><span>Parcela-".$parcelas."</span></td><td><input type='date' id='parcela".$parcelas."' name='parcela".$parcelas."' ></td>";
        
       
    }echo '</tr></table>';
    
?>

<?php if($_GET['tipo'] == 2){?>

    <div id="tipo_data">
        <input type="date" id="data_quinzena" name="data_quinzena">
    </div>
    
<?php }if($_GET['tipo'] == 3){
    
   echo '<div style="position: absolute; z-index: 2;  background-color: rgb(240, 245, 230); border: 1px solid#aaa; border-radius: 10px; margin-bottom: 20px; transition: all 2s; padding: 20px; box-shadow: 0px 0px 10px #aaa; float: left; " id="tipo_data">';
   echo '<a style="float: right" href="add_contas#formulario-apagar" onclick="fechaParcela()">X</a>';
   echo '<table><tr>';
   $j = 0;
    for($parcelas = 1; $parcelas <= $_GET['parcelas']; $parcelas ++){
        echo "<td><span>Parcela-".$parcelas."</span></td><td><input type='date' id='parcela".$parcelas."' name='parcela".$parcelas."' ></td>";
        $j ++;
        if($j == 4 ){
            echo "</tr><tr>";
            $j = 0;
        }
    }
    echo '</table>';
}




