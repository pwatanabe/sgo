<?php
include("restrito.php");
include_once("../model/class_funcionario_bd.php");
include_once("../model/class_horarios_bd.php");
include_once("../model/class_turno_bd.php");
include_once("../model/class_sql.php");
include_once("../model/class_filial_bd.php");
include_once("../model/class_cbo_bd.php");
include_once("../model/class_cidade_bd.php");
include_once("../model/class_estado_bd.php");
include_once("../model/class_endereco_bd.php");
include_once("../model/class_exame_bd.php");
include_once("../model/class_cboXexames.php");
include_once("../model/class_rend_double_select.php"); 
include_once("../includes/functions.php");

function validate(){
   if(!isset($_POST['cod_posto']) || $_POST['cod_posto'] == ""){
         return false;
   }
   return true;
}

 ?>


<?php Functions::getHead('Adicionar'); //busca <head></head> da pagina, $title é o titulo da pagina ?>
<!-- <head>
	
   <script type="text/javascript" language="javascript" src="../javascript/jquery-2.1.4.min.js"></script>
   <script src="../javascript/selectbox.js" type="text/javascript"></script>
   <link rel="stylesheet" type="text/css" href="styles/style.css">
   
</head> -->

<?php Functions::getScriptFilial(); ?>

<body onload="disparaLoadCidade()">	
<?php include_once("../view/topo.php"); ?>		
	<div class="formulario">
			

			<?php if(isset($_GET['tipo']) && $_GET['tipo'] == 'editar'){ ?>
				      <?php 
                        $id = $_GET['id'];
                        $filial = new Filial();
                        $filial = $filial->get_filial_id($id);
                        $endereco = new Endereco();
                        $endereco = $endereco->get_endereco($filial->id_endereco);
                        
                         echo '<input type="hidden" id="id_cidade" value="'.$endereco[0][2].'">';
                      ?>
			
				<div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Adicionar Posto de trabalho</span></div></div>
				<form method="POST" id="add_cbo" action="add_filial.php" onsubmit="return validate(this)">
                  <table border="0" style="width:100%">
                    <input type="hidden" id="id" name="id" value="<?php echo $id; ?>">
                    <input type="hidden" id="id_endereco" name="id_endereco" value="<?php echo $filial->id_endereco; ?>">
                    <input type="hidden" id="tipo" name="tipo" value="editar">
                 
                     <!-- <tr> <td ><span>CNPJ:</span></td> <td colspan="2"><input type="text" id="cnpj" name="cnpj" style="width:100%"></td></tr> <!- cnpj --> 
                     <tr> <td ><span>Código Posto:</span></td> <td colspan="2"><input type="text" id="cod_posto" name="cod_posto" style="width:100%; text-transform:uppercase;" value="<?php echo $filial->cod_posto; ?>"></td></tr> <!-- cod_posto -->
                     <tr> <td ><span>Nome:</span></td> <td colspan="2"><input type="text" id="nome" name="nome" style="width:100%"value="<?php echo $filial->nome; ?>"></td></tr> <!-- nome -->
                     <tr> <td ><span>Telefone:</span></td > <td colspan="2"><input type="text" id="telefone" name="telefone" style="width:100%" value="<?php echo $filial->telefone; ?>"></td></tr> <!-- nome -->
                     <tr> <td ><span>Rua:</span></td> <td><input value="<?php echo $endereco[0][0]; ?>" type="text" id="rua" name="rua"><span> Nº: </span><input value="<?php echo $endereco[0][1]; ?>" style="width:60px" type="text" id="num" name="num"></td></tr> <!-- rua -->
                     <tr> <td ><span>Complemento:</span> </td><td><input  style="width:50%" value="<?php echo $endereco[0][6]; ?>" type="text" id="complemento" name="complemento" ></td></tr> 
                     <tr> <td ><span>Bairro:</span></td> <td colspan="2"><input value="<?php echo $endereco[0][4]; ?>" type="text" id="bairro" name="bairro" style="width:100%"></td></tr> <!-- bairro -->
                     <tr> 
                        <tr>
                        <td><span>Estado:</span></td>
                        <td>
                           <?php //buscar array de CBO
                              $estado = new Estado();
                              $estados = $estado->get_name_all_uf();
                                
                           ?>
                           <select name="estado" id="estado" onchange="buscar_cidades()">
                              <option value="0">Selecione um estado</option>
                              <?php 
                                 foreach($estados as $key => $estado){
                                    echo '<option value="'.$estados[$key][0].'">'.$estados[$key][1].'</option>';
                                 }
                              ?>
                           </select>                           <!-- <a href="">Pesquisar</a> -->
                        </td>
                        <?php echo "<script> carregaUf('".$endereco[0][3]."') </script>";  ?>
                     </tr>
                     <tr>
                        <td><span>Cidades:</span></td>
                        <td colspan="3">
                           <div id="load_cidades">
                             <select name="cidade" id="cidade">
                               <option value="0">Selecione um estado</option>
                             </select>
                           </div>
                        </td>
                        <?php echo "<script> buscar_cid('".$endereco[0][3]."'); </script>";  ?>
                      </tr>

                     <tr> <td ><span>CEP:</span></td> <td colspan="2"><input type="text" id="cep" name="cep" value="<?php echo $endereco[0][5]; ?>" style="width:50%"></td></tr> <!-- cep -->                     
                     <tr> 
                        <td ><span>Empresa:</span></td>
                        <td colspan="2">
                           <select id="empresa" name="empresa"  style="width:100%">
                              <?php 
                                 $empresa = new Empresa();
                                 $empresa = $empresa->get_all_empresa();
                                 for ($i=0; $i < count($empresa) ; $i++) { 
                                    echo '<option value="'.$empresa[$i][0].'">'.$empresa[$i][2].'</option>';
                                 }
                               ?>
                           </select>
                        </td>
                        <?php echo '<script> carregaEmpresa("'.$filial->id_empresa.'"); </script>'; ?>
                     </tr>
                     
                     <tr> 
                        <td ><span>Responsável:</span></td>
                        <td colspan="2">
                           <select id="responsavel" name="responsavel"  style="width:100%">
                              <option value="no_sel">Selecione o Responsável</option>
                              <?php 
                                 $func = new Funcionario();
                                 $func = $func->get_admin();
                                 for ($i=0; $i < count($func) ; $i++) { 
                                    echo '<option value="'.$func[$i][0].'">'.$func[$i][1].'</option>';
                                 }
                               ?>
                           </select>
                        </td>
                        <?php echo '<script> carregaResponsavel("'.$filial->id_responsavel.'"); </script>'; ?>
                     </tr>
                     
                     <!-- <tr><td colspan="2"><span style="color:#898989">Segure Ctrl para múltiplas seleções</span></td></tr>   -->
                     <tr>
                          <td colspan="3" style="text-align:center">
                              <input class="button" type="submit" onclick="selectAll()" name="button" id="button" value="Editar">
                              <input class="button" name="button" onclick="window.location.href='add_filial.php'" id="button" value="Cancelar">
                          </td>
                      </tr>
                  </table>
               </form>
               <?php }else{ ?>
               		<div class="title-box" style="float:left"><div style="float:left"><img src="../images/edit-icon.png" width="35px"></div><div style="float:left; margin-top:10px; margin-left:10px;"><span class="title">Adicionar Posto de trabalho</span></div></div>
				<form method="POST" id="add_cbo" action="add_filial.php" onsubmit="return validate(this)">
                  <table border="0" style="width:100%" >
                     <input type="hidden" id="tipo" name="tipo" value="cadastrar">
                     <!-- <tr> <td ><span>CNPJ:</span></td> <td colspan="2"><input type="text" id="cnpj" name="cnpj" style="width:100%"></td></tr> <!- cnpj --> 
                     <tr> <td ><span>Código Posto:</span></td> <td colspan="2"><input type="text" id="cod_posto" name="cod_posto" style="width:100%; text-transform:uppercase;"></td></tr> <!-- cod_posto -->
                     <tr> <td ><span>Nome:</span></td> <td colspan="2"><input type="text" id="nome" name="nome" style="width:100%"></td></tr> <!-- nome -->
                     <tr> <td ><span>Telefone:</span></td > <td colspan="2"><input type="text" id="telefone" name="telefone" style="width:100%"></td></tr> <!-- nome -->
                     <tr> <td ><span>Rua:</span></td> <td><input type="text" id="rua" name="rua"><span> Nº: </span><input style="width:60px" type="text" id="num" name="num"></td></tr> <!-- rua -->
                     <tr> <td><span>Complemento:</span></td><td><input type="text" id="complemento" name="complemento"></td></tr>
                     <tr> <td ><span>Bairro:</span></td> <td colspan="2"><input type="text" id="bairro" name="bairro" style="width:100%"></td></tr> <!-- bairro -->
                     
                     <tr> 
                        <td><span >UF:</span></td>
                        <td colspan="2">
                           <?php //buscar array de CBO
                              $estado = new Estado();
                              $estados = $estado->get_name_all_uf();
                           ?>
                           <select style="width:50%" name="estado" id="estado" onchange="buscar_cidades()" style="width:100%">
                              <option value="no_sel">Selecione um estado</option>
                              <?php 
                                 foreach($estados as $key => $estado){
                                    echo '<option value="'.$estados[$key][0].'">'.$estados[$key][1].'</option>';
                                 } 
                              ?>
                           </select>
                       </td>
                     </tr>
                     <tr>
                        <td><span> Cidade: </span></td>
                        <td colspan="2">
                           <div id="load_cidades">
                             <select style="width:50%" name="cidade" id="cidade" style="width:100%">
                               <option value="no_sel">Selecione um estado</option>
                             </select>
                           </div>
                        </td>
                     </tr>

                     <tr> <td ><span>CEP:</span></td> <td colspan="2"><input type="text" id="cep" name="cep" style="width:50%"></td></tr> <!-- cep -->
                     
                     <tr> 
                        <td ><span>Empresa:</span></td>
                        <td colspan="2">
                           <select style="width:50%" id="empresa" name="empresa"  style="width:100%">
                              <?php 
                                 $empresa = new Empresa();
                                 $empresa = $empresa->get_all_empresa();
                                 for ($i=0; $i < count($empresa) ; $i++) { 
                                    echo '<option value="'.$empresa[$i][0].'">'.$empresa[$i][2].'</option>';
                                 }
                               ?>
                           </select>
                        </td>
                     </tr>
                     
                     <tr> 
                        <td ><span>Responsável:</span></td>
                        <td colspan="2">
                           <select id="responsavel" name="responsavel"  style="width:100%">
                              <option value="no_sel">Selecione o Responsável</option>
                              <?php 
                                 $func = new Funcionario();
                                 $func = $func->get_admin();
                                 for ($i=0; $i < count($func) ; $i++) { 
                                    echo '<option value="'.$func[$i][0].'">'.$func[$i][1].'</option>';
                                 }
                               ?>
                           </select>
                        </td>
                     </tr>
                     
                     <!-- <tr><td colspan="2"><span style="color:#898989">Segure Ctrl para múltiplas seleções</span></td></tr>   -->
                     <tr>
                        <td colspan="3" style="text-align:center">
                            <input class="button" type="submit" onclick="selectAll()" name="button" id="button" value="Cadastrar">
                            <input class="button" name="button" onclick="window.location.href='principal.php'" id="button" value="Cancelar">
                         </td>
                    </tr>
                  </table>
               </form>
               <?php }?>
               <?php 
                if(isset($_POST['tipo']) && $_POST['tipo'] == "cadastrar"){
                		if(validate()){
                      $endereco = new Endereco();
                      $nome = $_POST['nome'];
                      // $cnpj = $_POST['cnpj'];
                      $cod_posto = $_POST['cod_posto'];
                      $telefone = $_POST['telefone'];
                      $id_responsavel = $_POST['responsavel'];
                      $id_empresa = $_POST['empresa'];
  
                      $rua = $_POST['rua'];
                      $num = $_POST['num'];
                      $id_cidade = $_POST['cidade'];
                      $bairro = $_POST['bairro'];
                      $cep = $_POST['cep'];
                      $complemento = $_POST['complemento'];
                      $endereco->add_endereco($rua, $num, $id_cidade, $bairro, $cep, $complemento);
                      // $endereco->bairro = $bairro;
                      // $endereco->cep = $cep;
  
                      $id_endereco = $endereco->add_endereco_bd();
  
  
                      $filial = new Filial();
                      $filial->add_filial($nome, $cod_posto, $telefone, $id_endereco, $id_responsavel, $id_empresa);
    
                      if($filial->add_filial_bd()){
                        echo '<div class="msg">Posto de trabalho adicionado com sucesso!</div>';
                      }else{
                        echo '<div class="msg">Falha ao adicionar posto de trabalho!</div>';
                      }                      
                      }
                }else{
                	 if(isset($_POST['tipo']) && $_POST['tipo'] == "editar"){
                            if(validate()){
                                $filial = new Filial();
                                $endereco = new Endereco();

                                $id = $_POST['id'];
                                $nome = $_POST['nome'];
                                // $cnpj = $_POST['cnpj'];
                                $cod_posto = $_POST['cod_posto'];
                                $telefone = $_POST['telefone'];
                                $id_responsavel = $_POST['responsavel'];
                                $id_empresa = $_POST['empresa'];
            
                                $rua = $_POST['rua'];
                                $num = $_POST['num'];
                                $id_cidade = $_POST['cidade'];
                                $bairro = $_POST['bairro'];
                                $cep = $_POST['cep'];
                                $complemento = $_POST['complemento'];
                                $existe_endereco = $endereco->verifica_endereco($_POST['id_endereco']);
                                
                                if($existe_endereco){
                                    $endereco->atualiza_endereco($rua, $num, $id_cidade, $_POST['id_endereco'], $bairro, $cep, $complemento );
                                    $id_endereco = $_POST['id_endereco'];
                                }else{
                                    $endereco->add_endereco($rua, $num, $id_cidade, $bairro, $cep, $complemento);
                                    $id_endereco = $endereco->add_endereco_bd();
                                }
                                
                                if($filial->atualiza_filial($id, $nome, $cod_posto, $telefone, $id_endereco, $id_responsavel, $id_empresa)){
                                      echo '<div class="msg">Atualizado com sucesso!</div>';
                                      echo '<script>alert("Filial atualizado com sucesso")</script>';
                                }else{
                                   echo '<div class="msg">Falha na atualização!</div>';
                                }
                              
                            }                          

                	 }
                  }
                ?>                
			</div>
			<?php include("informacoes_filial.php") ?>
	 
</body>
</html>