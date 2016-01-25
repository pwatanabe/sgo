
<?php
session_start();
if(!isset($_SESSION['logado']) && $_SESSION['logado'] != true){
   header('location:index.php');
}
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_periodicidade_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");
include_once("../model/class_config.php");
include_once("../includes/functions.php");
include_once("../config.php");
include_once("../model/class_solicita_acesso.php");

?>
<html>
<?php 
  function validate(){
      if(isset($_POST['temp_limit_atraso'])){
        if( ($_POST['temp_limit_atraso'] >= 0 && $_POST['temp_limit_atraso'] <= 60) || $_POST['temp_limit_atraso'] != ''){
           $string = $_POST['temp_limit_atraso'];           
           return true;
        }else{
            return false;  
        }
    }
  }
 ?>

<?php Functions::getHead('Permitir acesso'); //busca <head></head> da pagina, $title é o titulo da pagina ?>

 <script type="text/javascript">
     function valida(f){
          var erros = 0;
          var msg = '';
          for(i=0 ; i < f.length; i++){
            
            if(f[i].name == 'mac'){
              if(f[i].value == ''){
                  f[i].style.border = '1px solid #f00';
                  msg += "Insira um mac\n";
                 erros++;
              }else{
                f[i].style.border = '1px solid #eee';
              }
            }
            
          }
          if(erros > 0){
            alert(msg)
            return false;
          }
          return true;
     }
     function mascara(o,f){
              v_obj=o
              v_fun=f
              setTimeout("execmascara()",1)
      }
      function execmascara(){
          v_obj.value=v_fun(v_obj.value)
      }
       function id( el ){
         // alert("id")
         return document.getElementById( el );
       }
      function mnum(v){
           if(v.length >=19){
              v = v.substring(0,(v.length - 1));
              return v;
           }
           v=v.replace(/\D/g,"");
           return v;
       }
       function mac(v){
          if(v.length >=18){
              v = v.substring(0,(v.length - 1));
              return v;
          }
          // v=v.replace(/\D/g,"");
          v=v.replace(/^(\w{2})(\w{2})(\w{2})(\w{2})(\w{2})(\w{2})/,"$1-$2-$3-$4-$5-$6");
          
          return v;
       }
      
      window.onload = function(){
          id('mac').onkeypress = function(){
              mascara( this, mac );
          }
       }
       function exibe(id){
       
          // document.getElementById("back-popup").style.display = "block";
          document.getElementById(id).style.display = "block";
        

        }
        function fecha(id){
            // document.getElementById("back-popup").style.display = "none";
            document.getElementById(id).style.display = "none";
            
        }

 </script>
<body>

         
            <?php include_once("../view/topo.php"); ?>
            
              <div class="formulario" style="text-align:left">
                  <?php
                      if(isset($_GET['excluir'])){
                          if(Solicita_acesso::excluir($_GET['excluir']))
                              echo "<script>alert('Excluido com sucesso!'); window.location='principal.php'</script>";
                          else
                              echo "<script>alert('Falha ao excluir');</script>";

                      }

                      if(isset($_POST['mac']) && $_POST['mac'] != '' && isset($_POST['id_solicitacao']) && $_POST['id_solicitacao'] != ''){
                          if(Solicita_acesso::permitir_acesso($_POST['id_solicitacao'], strtoupper($_POST['mac']), strtoupper($_POST['descricao'])) ){
                              echo "<script>window.location = 'logado.php'</script>";
                          }else{
                              echo "<script>window.location = 'logado.php'</script>";
                          }

                      }
                      /*
                        $return[0] = $result['id'];
                        $return[1] = $result['mac'];
                        $return[2] = $result['nome'];
                        $return[3] = $result['telefone'];
                        $return[4] = $result['descricao'];
                        $return[5] = $result['empresa'];
                      */
                      if(isset($_GET['id_sol_acesso'])){
                          $acesso = Solicita_acesso::get_sol_acesso_id($_GET['id_sol_acesso']);
                          echo '<p>Dados da solicitação</p>';
                          echo '<span><b>Nome: </b>'.$acesso[2];  echo '</span><br />';
                          echo '<span><b>Telefone: </b>'.$acesso[3];  echo '</span><br />';
                          echo '<span><b>Descrição: </b>'.$acesso[4];  echo '</span><br />';
                          echo '<span><b>Empresa: </b>'.$acesso[5];  echo '</span><br />';

                  ?>
                        <form action="permitir_acesso.php" method="POST" onsubmit="return valida(this)">
                            
                            <input type="hidden" name="id_solicitacao" value="<?php echo $acesso[0] ?>">
                            <input type="hidden" name="descricao" value="<?php echo $acesso[2] ?>">
                            <span>Por favor, insira o MAC do computador que terá acesso ao sistema (Com traços)</span><br />
                            <input type="text" name="mac" id="mac" placeholder="Digite o MAC" style="text-transform: uppercase;"><br /><br />
                            <input type="submit" class="button" value="Permitir"> <input onclick="window.location = 'permitir_acesso.php?excluir=<?php echo  $acesso[0] ?>'" type="button" class="button" value="Excluir">
                        </form>
                        <?php } ?>
                </div>
              

</body>
</html>