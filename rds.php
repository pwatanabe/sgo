<script type="text/javascript">
  function submeter(){
      document.getElementById('dados').submit();
  }
</script>
<?php 
include_once("model/class_sql.php");
include_once("model/class_token.php");

unset($_SESSION['ac_lib_a_cp']);//limpa a session

echo '<body onload="submeter()">';
    if(isset($_GET['MaSPo']) && Token::validar_mac($_GET['MaSPo']) ){
        if( isset($_GET['ToSPo']) && Token::validar_token($_GET['ToSPo']) ){
          if( Token::add_token_acesso($_GET['ToSPo'], date('Y-m-d'), '0' ) ){
              echo '<form name="dados" id="dados" method="POST" action="index.php">
                <input type="hidden" name="ToSPo" value="'.$_GET['ToSPo'].'">
                <input type="hidden" name="MaSPo" value="'.$_GET['MaSPo'].'">
              </form>';
              
          }else{
              echo "<script> window.location = 'view/erro.php'</script>";
          }
        }else{
              echo "<script> window.location = 'view/erro.php'</script>";
        }
    }else{
        echo "<script> window.location = 'view/erro.php'</script>";
    }

echo '</body>';
 ?>