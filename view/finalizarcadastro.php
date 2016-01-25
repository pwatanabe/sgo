<?php
include_once("../model/class_empresa_bd.php");
include_once("../model/class_empresa_bd.php");
	if($_SESSION['nivel_acesso'] == 0){
		$nivel_acesso = "Acesso Total";
	}else if($_SESSION['nivel_acesso'] == 1){
		$nivel_acesso = "Acesso ViaCampos";
	}else{
		$nivel_acesso = "Acesso ControlPonto";
	}
 ?>
 <script type="text/javascript">
 	function submitForm(form){
 		var url = 'reportMailError.php?pag='+form[0].value+'&descricao='+form[1].value; 
 		$.get(url, function(dataReturn) {
            alert("Erro reportado com sucesso, Obrigado");
            document.getElementById("back-popup").style.display = "none";
        	document.getElementById("popup-erro").style.marginLeft = "-600px";
        });
    }
 </script>
 <!-- Código para verificação se a empresa ja foi totalmente cadastrada -->
            <?php 
                $id_empresa = $_SESSION['id_empresa']; /* Recebe o id da empresa na seção*/

                $empresa = new Empresa();
                $empresa = $empresa->get_empresa_by_id($id_empresa); /*Busca dados da empresa no banco de dados*/
                     
                $i = 0; /*Verificador de quantiade de dados*/
                foreach ($empresa as $key => $value) { /* codigo para correr a empresa e encrementar o verficador de quantidade*/

                    if($value == "" or $value==0){
                        
                        if($key == "id_endereco"){
                            $i++;
                        }               
                    }
                }
                
        if ($i != 0){ 
        ?>
        <div  id="box-login1" class="box-login" style="background-color: rgba(255, 0, 0, 0.7); width:30%; margin-right:10px;">
            <div style="float:left;margin-top:5px;"><img src="../images/alerta.png" width="40px"></div>
            <div class="nome-box-login"></div><br>
                <div style="float:left; padding-left: 10px">
                    <span>
                    <?php  
                    echo 'Você tem '.$i.' dados importantes para serem cadastrados em Empresa';
                     ?>
                    </span>
                </div>
            <div style="float:right;"><span style='float:left; margin-top:2px;'>Cadastrar  </span><a style="float:left; margin-left:10px;"title="Cadastrar agora" <?php echo 'href="add_empresa.php?tipo=editar&id='.$id_empresa.'"' ?>><img src="../images/ir.png" width="20px"></a></div>    
        </div>
        <?php 
        }
        ?>

	<!-- Janela do topo referente a empresa -->
	


    <!-- janela do topo referente ao usuario -->





     <?php 
        
        $id_funcionario = $_SESSION['id_funcionario'];
        $func = new Funcionario();
        $func = $func->get_func_id($id_funcionario);       
        $i = 0;      
       
        foreach ($func as $key => $value) {
            if(!isset($value) or $value==0){
                
                // if($key == "rg"){
                //      $i = $i +1;
                // }
                if($key == "id_endereco"){
                     $i = $i +1;
                }
                if($key == "data_nasc"){
                     $i = $i +1;
                }
                         
                if($key == "id_cbo"){
                     $i = $i +1;
                }
                if($key == "id_endereco"){
                     $i = $i +1;
                }
                if($key == "id_turno"){
                     $i = $i +1;
                }
                
                if($key == "salario_base"){
                     $i = $i +1;
                }
                if($key == "data_adm"){
                     $i = $i +1;
                }
                if($key == "cod_serie"){
                    if($value !=""){
                        $i = $i +0;
                    }else{
                        $i = $i +1;
                    }
                }
            }
        }

       
          if ($i != 0){
                ?>

            <div id="box-login2" class="box-login" style="background-color: rgba(255, 0, 0, 0.7); width:30%; margin-right:10px;">
                <div style="float:left; margin-top:5px;"><img src="../images/alerta.png" width="40px"></div>
                <div class="nome-box-login" style=""></div><br>
                    <div style="float:left; padding-left: 10px">
                        <span>
                            <?php
                             echo 'Você tem '.$i.' dados importantes para serem cadastrados em Funcionário!'; 
                             ?>
                        </span>
                    </div>
                <div style="float:right;"><span style='float:left; margin-top:2px;'>Cadastrar  </span><a style="float:left; margin-left:10px;"title="Cadastrar agora" <?php echo 'href="add_func.php?tipo=editar&id='.$id_funcionario.'"' ?>><img src="../images/ir.png" width="20px"></a></div>    
            </div>

        <?php 
        }
        ?>








    


