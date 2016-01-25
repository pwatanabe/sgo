<?php    // print_r($_SESSION['obra']['cliente']);
        if (isset($_SESSION['obra']['cliente'])){
        $cliente = $_SESSION['obra']['cliente'];
       // print_r($cliente);
        // echo "<br>".$cliente['id_cli'];
        // echo "<br>".$cliente['nome_cli'];
        // echo "<br>".$cliente['cpf_cnpj_cli'];
        // echo "<br>".$cliente['rua'];
        // echo "<br>".$cliente['num'];
        // echo "<br>".$cliente['telefone_com'];
        }else{
          $cliente['id_cli']="...";
          $cliente['nome_cli']="...";
          $cliente['cpf_cnpj_cli']="...";
          $cliente['rua']="...";
          $cliente['num']="...";
          $cliente['telefone_com']="...";
        }
        
?>
<div class="painel-controle">
      
      <div class="colum">
        <div style="float:left;width:100%"><div style="float:left"><img src="../images/user.png" width="50px" style="margin-left:5px; margin-top:-20px;margin-left:-20px;"></div><div style="float:left; margin-top:10px; margin-left:10px; width:35px"><span class="title"><b>Cliente</b></span></div></div>
        <div style="width:100%;"><span style="color: #676767;">Dados do cliente vinculado à obra</span></div>
        <div class="descricao"><span>Nome: </span></div> <div class="descricao"><span type="text" id="nome"><?php echo $cliente['nome_cli']?></span></div>
        <div class="descricao"><span>CPF/CNPJ: </span></div> <div class="descricao"><span type="text" id="cpf_cnpj_cli"><?php echo $cliente['cpf_cnpj_cli']?></span></div>
        <div class="descricao"><span>Telefone: </span></div> <div class="descricao"><span type="text" id="telefone_com"><?php echo $cliente['telefone_com']?></span></div>
        <div class="descricao"><span>Rua: </span></div> <div class="descricao"><span type="text" id="rua" ><?php echo $cliente['rua']?></span></div>
      </div>

</div>