

<?php 
    if (isset($_GET['cadastro'])== 'ok') {
            $nome = $_GET['nome'];      ;
        ?>
        <div class="content-section-a" style="background-color:rgba(255,255,255,0.3);">
            <div class="container">
                <div class="section-heading"><h2>Parabens <i><?php echo $nome ?></i> seu cadastro foi efetuado !!</h2></div>
                <div><h4>Seu login e senha foram enviados para o seu e-mail.</h4></div>
                <div><h4>Clique em ACESSE AGORA para entrar no sistema.</h4></div>

            </div>
        </div>
        <?php 
        
        # code...
    }else{
        ?>
        
        <a  name="cadastro"></a>
        <div class="content-section-a">
            <div class="container" >
                <div class="row" style="text-align:center;">
                        <!-- <div class="clearfix"></div> -->
                        <h2 class="section-heading">Cadastre-se</h2>                       
                                <div style="text-align:center">
                                    <form style="background-color: rgba(150,150,150,0.2); padding-bottom: 40px;" method="POST" action="administrator/registro_parcial.php" onsubmit="return validaTudo(this)">                                    
                                        <table border='0' class="table-footer" style="height:150px; width:500px;">
                                            <tr><td><h4>Usuário</h4></td><td><h4>Empresa</h4></td></tr>
                                            <tr><td><input placeholder="Nome" class="form-control" type="text" name="nome" id="nome"></td><td><input placeholder="Nome Fantasia" class="form-control" type="text" name="nome_fantasia" id="nome_fantasia"></td></tr>
                                            <tr><td><input placeholder="Email" class="form-control" type="text" name="email" id="email"></td><td><input placeholder="Razão Social" class="form-control" type="text" name="razao_soc" id="razao_soc"></td></tr>
                                            <tr><td><input placeholder="CPF" class="form-control" type="text" name="cpf" id="cpf"></td><td><input placeholder="CNPJ" class="form-control" type="text" name="cnpj" id="cnpj"></td></tr>
                                            <tr><td><input placeholder="Senha" class="form-control" type="password"name="senha" id="senha"></td></tr>
                                            <tr><td><input placeholder="Senha" class="form-control" type="password"name="senha1" id="senha1"></td></tr>
                                            <tr><td><input placeholder="Telefone" class="form-control" type="text"name="telefone" id="telefone"></td></tr>
                                            <tr><td colspan="2"><input class="form-control" type="submit" value="Enviar"></td></tr>
                                        </table>
                                    </form>
                                </div>
            
                </div>

            </div>
            <!-- /.container -->
        </div>

    </div>
    <!-- /.content-section-a -->

 

        <?php 
    }
 ?>
