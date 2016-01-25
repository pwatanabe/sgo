<?php 
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
    function desabilitaDiv1(){        
        document.getElementById("box-login1").style.display = "none";
        alert("chamouDIV1");
    } 
    function desabilitaDiv2(){
        document.getElementById("box-login2").style.display = "none";
        alert("chamouDIV2");
    }
	function exibe_error(){
        // document.getElementById("popup").style.display = "block";
        var windowWidth = window.innerWidth;
        var windowHeight = window.innerHeight;
      
        var screenWidth = screen.width;
        var screenHeight = screen.height;
        // alert(windowWidth+" x "+windowHeight)
		document.getElementById("back-popup").style.display = "block";
        if(windowWidth > 1200){
          document.getElementById("popup-erro").style.marginLeft = "35%";
        }else if(windowWidth > 1000){
          document.getElementById("popup-erro").style.marginLeft = "30%";
        }else if(windowWidth > 500){
          document.getElementById("popup-erro").style.marginLeft = "20%";
        }else{
          document.getElementById("popup-erro").style.marginLeft = "0%";
        }

    }
    function fecha_error(){
    	document.getElementById("back-popup").style.display = "none";
        document.getElementById("popup-erro").style.marginLeft = "-800px";
    }
 </script>

<div class="topo" style="width:100%; float:left; min-width:600px;">
        <?php $id_empresa = $_SESSION['id_empresa']; ?>
        <?php echo '<input type="hidden" value='.$id_empresa.'>'?>
        <?php 
        require_once("../model/class_config.php");
        $config = new Config();        
        $logo = $config->get_config("caminho_logo", $_SESSION['id_empresa']);                       
        $dir_logo = '../images/'.$_SESSION['id_empresa'].'/'.$logo;
        ?>
    <div class="img" style="float:left">  
        <?php if($logo != "" && file_exists($dir_logo)){ ?> 
                <img style="height: 90px;" src=<?php echo '../images/'.$_SESSION['id_empresa'].'/'.$logo.'' ?>> 
        <?php  }else{ ?>
                <img style="height: 90px;" src=<?php echo '../images/logo-sgo.png' ?>> 
        <?php } ?>

    </div>
	<div class="box-login" style="">
		<div style="float:left"><img src="../images/user.png" width="40px"></div>
		<div class="nome-box-login" style=""><span style="">Usuário:<br /></span><?php echo $_SESSION["user"]; ?><br /><span style="">Empresa:<br /></span><?php echo $_SESSION['empresa']."<span> (".$nivel_acesso.")</span>" ?></div>
		<div style="float:right;"><a title="Clique para sair" href="logout"><img src="../images/fechar.png" width="20px"></a></div>
                <div style="clear:right;"><a title="Clique para editar a empresa" <?php echo 'href="add_empresa?tipo=editar&id='.$id_empresa.'"'; ?> ><img src="../images/edit2.png" width="20px"></a></div>
	</div>
    <?php include_once("finalizarcadastro.php");?>
</div>
<div style="float:right; padding-right:10px; ">
    <a onclick="exibe_error()" style="cursor:pointer"><span>Reportar um Erro</span></a>
</div>
<div style="float:left; width:100%; min-width:630px;">
 	<div class="menu">
		<div class="menu">
	         <?php include_once("../view/menu_admin.php"); ?>
	    </div>
	</div>
</div>
<div class="back-popup" id="back-popup" style="position:fixed; z-index: 1; margin-top:-10px; margin-left: -10px;">
</div>
<div id="popup-erro" class="popup-erro" style=" position: fixed; margin-top:100px; margin-left: -800px; width:500px; z-index: 5">
	<?php include_once("reportError.php"); ?>
</div>

