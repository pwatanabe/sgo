<?php 
    @session_start();
    if(isset($_SESSION["id"]) && isset($_SESSION["user"]) && isset($_SESSION["id_empresa"]) && isset($_SESSION['logado']) && $_SESSION['logado'] == md5($_SESSION["id"])   ){
    }else{
      header("location:index.php?falha=session");
    }

 ?>