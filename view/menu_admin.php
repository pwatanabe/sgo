<ul class="menu-list">  
    <li style="border-left: 1px solid#565656;"><a href='/viacampos/administrator/principal'>Início</a></li>
    <li>
      <!-- color:#000; text-shadow: 0px 0px 5px #000; font-size: 13px; padding-left:3px;padding-right:3px; background-color:rgba(255,255,255,0.5) -->
      <a style=""><span style="float:left">Cadastrar </span><img style="float:left; margin-top:-2px; margin-left:2px;" src="../images/downarrow_1246.png" width="15px;"></a>
       <ul class="sub-menu">
        <li><a href="/viacampos/administrator/add_func">Funcionário</a></li>
        <?php if($_SESSION['nivel_acesso'] == 0 || $_SESSION['nivel_acesso'] == 1){ ?>
                  <li><a href="/viacampos/administrator/add_cliente">Cliente / Fornecedor</a></li>
                  <li><a href="/viacampos/administrator/add_epi">Equipamentos</a></li>                  
                  <li><a href="/viacampos/administrator/add_epiXfunc">Equipamentos por funcionario</a></li>
                  <li><a href="/viacampos/administrator/add_patrimonio">Patrimonio</a></li>
                  <li><a href="/viacampos/administrator/add_contas">Contas</a></li>
                  <li><a href="/viacampos/administrator/add_produto">Produto</a></li>
                  <li><a href="/viacampos/administrator/add_material">Material</a></li>
        <?php } ?>

        <li><a href="/viacampos/administrator/add_turno">Turno</a></li>
        <li><a href="/viacampos/administrator/add_cbo">CBO</a></li>
        <li><a href="/viacampos/administrator/add_exames">Exames</a></li>
        <?php //echo '<li><a href="/viacampos/administrator/add_empresa.php?tipo=editar&id='.$_SESSION['id_empresa'].'">Empresa</a></li>'; ?>
        <li><a href="/viacampos/administrator/add_filial">Posto de Trabalho</a></li>

      </ul>
    </li>
    <li>
      <a style=""><span style="float:left">Pesquisar </span><img style="float:left; margin-left:2px; margin-top:-2px;" src="../images/downarrow_1246.png" width="15px;"></a>
       <ul class="sub-menu">
        <li><a href="/viacampos/administrator/pesquisa_func">Funcionário</a></li>
        <li><a href="/viacampos/administrator/pesquisa_empresa">Empresa</a></li>
        <li><a href="/viacampos/administrator/pesquisa_turno">Turno</a></li>
        <li><a href="/viacampos/administrator/pesquisa_cbo">CBO</a></li>
         <?php if($_SESSION['nivel_acesso'] == 0 || $_SESSION['nivel_acesso'] == 1){ ?>
          <li><a href="/viacampos/administrator/pesquisa_cli">Cliente</a></li>
          <li><a href="/viacampos/administrator/pesquisa_patrimonio">Patrimonio</a></li>
          <li><a href="/viacampos/administrator/pesquisa_epi">Equipamentos</a></li>
        <?php } ?>

        <li><a href="/viacampos/administrator/pesquisa_filial">Posto de Trabalho</a></li>

        <li><a href="/viacampos/administrator/pesquisa_exames">Exames</a></li>
      </ul>
    </li>
    <?php if($_SESSION['nivel_acesso'] == 0 || $_SESSION['nivel_acesso'] == 1){ ?>
      <li>
        <a style=""><span style="float:left">Obras </span><img style="float:left; margin-left:2px; margin-top:-2px;" src="../images/downarrow_1246.png" width="15px;"></a>
         <ul class="sub-menu">
          <li><a href="/viacampos/administrator/add_obra?t=a_c_o">Nova</a></li>
          <li><a href="/viacampos/administrator/visualizar_obras?action=edita">Editar</a></li>
          <li><a href="/viacampos/administrator/visualizar_obras">Exibir</a></li>
        </ul>
      </li>
    <?php } ?>
    <li><a href="/viacampos/administrator/define_relatorio">Relatórios</a></li>
    <li><a href="/viacampos/administrator/configuracoes">Configurações</a></li>
</ul>


