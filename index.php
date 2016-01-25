<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <link rel="icon" href="images/ico-sgo.png" type="image/x-icon">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Viacampos</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom CSS -->
    <link href="css/landing-page.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
    <link href="http://fonts.googleapis.com/css?family=Lato:300,400,700,300italic,400italic,700italic" rel="stylesheet" type="text/css">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <script type="text/javascript">
        function validaTudo(f){
            err = 0;
            if(validarSenha(f)== false){
                alert("Confirme suas senhas !");
                err++;
            }
            
            for (var i = 0; i < f.length; i++) { 
                 if(f[i].name == "cpf" && f[i].value != ""){
                         if(validarCPF(f[i].value) == false){
                                 err++;
                                               }
                }
             }
            if(valida(f)== false){
                err++;
            }
            
            
            
            if(err != 0){
                return false;
            }
        }
        
        
        function validarSenha(f){
            var s1;
            var s2;
            for (var i = 0; i < f.length; i++) {
                
                if(f[i].name == 'senha'){
                    if(f[i].value ==""){
                        return false;
                    }
                }
                
                if(f[i].name == 'senha1'){
                    if(f[i].value ==""){
                        return false;
                    }
                }
                if (f[i].name == 'senha'){                    
                    var s1=f[i].value;
                    
                }
                if(f[i].name=='senha1'){                    
                    var s2=f[i].value;
                    
                }                
            }
            
            if (s1 == s2)
                return true;
            
            else 
            return false;
                 
            }

        function valida(f){
              var erros = 0;
              var msg = "";

             for (var i = 0; i < f.length; i++) { 
              if(f[i].name == "nome" && f[i].value == ""){
                      msg += "Insira um Nome!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "nome" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }
              if(f[i].name == "nome_fantasia" && f[i].value == ""){
                      msg += "Insira o nome fantasia da empresa!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "nome_fantasia" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }
              if(f[i].name == "email" && f[i].value == ""){
                      msg += "Insira o email!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "email" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }
              if(f[i].name == "razao_soc" && f[i].value == ""){
                      msg += "Insira a Razão social da empresa!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "razao_soc" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }
              if(f[i].name == "cpf" && f[i].value == ""){
                      msg += "Preencha o CPF!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "cpf" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }

              if(f[i].name == "cnpj" && f[i].value == ""){
                      msg += "Preencha o cnpj!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "cnpj" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }
              if(f[i].name == "telefone" && f[i].value == ""){
                      msg += "Insira o telefone!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "telefone" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }              
              if(f[i].name == "senha" && f[i].value == ""){
                      msg += "Preencha o campo senha!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "senha" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }
              if(f[i].name == "senha1" && f[i].value == ""){
                      msg += "Preencha senha no campo repetir senha!\n";
                      
                      f[i].style.border = "1px solid #FF0000";
                      erros++;
                    }
                    if(f[i].name == "senha1" && f[i].value != ""){
                      f[i].style.border = "1px solid #898989";
                    }

              }
                 if(erros>0){            
                    alert(msg);
                    return false;
                }
        }
            // Mask
        function mascara(o,f){
          v_obj=o
          v_fun=f
          setTimeout("execmascara()",1)
        }
          function execmascara(){
              v_obj.value=v_fun(v_obj.value)
        }
        
        function mtel(v){
       if(v.length >=15){
         v = v.substring(0,(v.length - 1));
         return v;
       }
       v=v.replace(/\D/g,"");
       v=v.replace(/^(\d{2})(\d)/g,"($1) $2");
       v=v.replace(/(\d)(\d{4})$/,"$1-$2");
       return v;
        }
        function mcpf(v){
       if(v.length >=15){  
         v = v.substring(0,(v.length - 1));
         return v;
       }
       v=v.replace(/\D/g,""); 
       v=v.replace(/^(\d{3})(\d{3})(\d{3})(\d{2})/,"$1.$2.$3-$4");
       return v;
        }
        function mcnpj(v){
           if(v.length >=19){                                          // alert("mtel")
             v = v.substring(0,(v.length - 1));
             return v;
           }
           v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
           v=v.replace(/^(\d{2})(\d{3})/g,"$1.$2."); 
           v=v.replace(/(\d{3})(\d{4})/,"$1/$2"); 
           v=v.replace(/(\d)(\d{2})$/,"$1-$2"); 
           
           return v;
        }
    
        function id( el ){
         return document.getElementById( el );
        }
         window.onload = function(){
     
        id('cpf').onkeypress = function(){ 
          mascara( this, mcpf );
      }
      
        id('telefone').onkeypress = function(){
          mascara( this, mtel );
      }
        id('cnpj').onkeypress = function(){
              mascara( this, mcnpj );
      }          
        }
   // fim Mask
      function validarCPF(cpf){
          
        cpf = cpf.replace(/[^\d]+/g,'');    
        if(cpf == '') return false; 
        // Elimina CPFs invalidos conhecidos    
        if (cpf.length != 11 || 
            cpf == "00000000000" || 
            cpf == "11111111111" || 
            cpf == "22222222222" || 
            cpf == "33333333333" || 
            cpf == "44444444444" || 
            cpf == "55555555555" || 
            cpf == "66666666666" || 
            cpf == "77777777777" || 
            cpf == "88888888888" || 
            cpf == "99999999999")
                return false;       
        // Valida 1o digito 
        add = 0;    
        for (i=0; i < 9; i ++)       
            add += parseInt(cpf.charAt(i)) * (10 - i);  
            rev = 11 - (add % 11);  
            if (rev == 10 || rev == 11)     
                rev = 0;    
            if (rev != parseInt(cpf.charAt(9)))     
                return false;       
        // Valida 2o digito 
        add = 0;    
        for (i = 0; i < 10; i ++)        
            add += parseInt(cpf.charAt(i)) * (11 - i);  
        rev = 11 - (add % 11);  
        if (rev == 10 || rev == 11) 
            rev = 0;    
        if (rev != parseInt(cpf.charAt(10)))
            return false;

        return true;   
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
          document.getElementById("popup").style.marginLeft = "40%";
        }else if(windowWidth > 1000){
          document.getElementById("popup").style.marginLeft = "30%";
        }else if(windowWidth > 500){
          document.getElementById("popup").style.marginLeft = "20%";
        }else{
          document.getElementById("popup").style.marginLeft = "0%";
        }

    }
    function fecha_error(){
        document.getElementById("back-popup").style.display = "none";
        document.getElementById("popup").style.marginLeft = "-600px";
        setTimeout(function() {
           window.location.href='index.php';
        }, 500);
    }

    </script>
</head>
<style type="text/css">
.popup{
    display:block;  padding: 10px; position:absolute;  z-index: 100; width:370px; margin-top: 150px; height:250px; margin-left:-450px; float:left;  background-color:#eee; box-shadow: 0px 0px 10px #000; border-radius:10px;
    transition: all 1s;
}
.popup-erro{
  transition: all 1s;
}
.back-popup{
  height: 100%;
  width: 100%;
  background-color: rgba(0,0,0,0.7);
  display: none;
}
.fechar{
  float: right;
}
.fechar a{
  cursor: pointer;
}
</style>

<body>

    <!-- Navigation -->
    <?php include_once("view/site/navigation.php") ?>

    <div class="back-popup" id="back-popup" style="position:absolute; z-index: 1">
    </div>
    <div id="popup" class="popup">
        <div style="float:left; margin-left:-30px;margin-top:-40px; "><img src="img/sucesso.png"></div>
        <div class="fechar"><a onclick='fecha_error()' style=""><img src="img/icon-fechar.png"></a></div>
        <div style=" font-size:18px; float:left; margin-top:10px; width:100%">Obrigado <?php echo $_GET['nome']; ?></div><br />
        <div style=" text-align: justify; float:left; margin-top:10px;">Seu cadastro foi efetuado com sucesso no Sistema de Gerenciamento de Obras! Verifique seu email para mais informações ou <a href="administrator/"><b>Clique Aqui</b></a> para acessar o sistema!</div><br /><br />
        <div style=" text-align: justify; float:left;">Usuario: <b><?php isset($_GET['login'])? print $_GET['login']:'' ?></b></div>
    </div>

    <!-- Header -->
    <?php include_once("view/site/header.php") ?>    
    
    <!-- Page Content -->
    <?php include_once("view/site/services.php") ?>    
    
    <!-- /.content-section-a -->

    <!-- Cadastro -->
     <?php include_once("view/site/cadastro.php") ?> 

    <?php include_once("view/site/contact.php") ?>

    <!-- Footer -->
    <?php include_once("view/site/footer.php"); ?>

    <!-- jQuery -->
    <script src="js/jquery.js"></script>

    <!-- Bootstrap Core JavaScript -->
    <script src="js/bootstrap.min.js"></script>

</body>
<?php 
    if(isset($_GET['cadastro']) && $_GET['cadastro'] == 'ok'){
        echo "<script>exibe_error();</script>";

    }
 ?>


</html>
