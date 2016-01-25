<script>
    function info(id){
      
      var divPop = document.getElementById(id);
      divPop.style.display = "";
    }
    function fechar(id){
      var divPop = document.getElementById(id);
      divPop.style.display = "none";
    }
</script>
<?php 
        
           if(isset($_FILES["logo_upload"]["name"])){
                    
                    $target_dir = "../images/".$_SESSION['id_empresa']."/";
                    
                    if(!is_dir($target_dir)){
                        mkdir($target_dir, 0777);
                    }
                    
                    
                    $target_file = $target_dir . basename($_FILES["logo_upload"]["name"]);
                    
                    $error = 0;
                    $imageFileType = pathinfo($target_file,PATHINFO_EXTENSION);
                    $msg = '';
                    // Check if image file is a actual image or fake image
                    if(isset($_POST["submit"])) {
                        
                        $check = getimagesize($_FILES["logo_upload"]["tmp_name"]);
                        if($check !== false) {                          
                            
                        } else {
                            $msg .= "Arquivo não suportado\\n";
                            $error++;
                        }
                    }
                    // Check if file already exists
                    // if (file_exists($target_file)) {
                    //     $msg .= "Arquivo já existe\\n";
                    //     $error++;
                    // }
                    // Check file size
                    if ($_FILES["logo_upload"]["size"] > 500000) {
                        $msg .= "Tamanho não suportado\\n";
                        $error++;
                    }
                    // Allow certain file formats
                    if($imageFileType != "jpg" && $imageFileType != "JPG" && $imageFileType != "PNG" && $imageFileType != "png" && $imageFileType != "jpeg" &&$imageFileType != "JPEG"
                    && $imageFileType != "gif") {
                        $error++;
                         $msg .= "Formato de arquivo não suportado\\n";
                    }   

                                    // Check if $error is set to 0 by an error
                    if($error == 0) {
                        if (move_uploaded_file($_FILES["logo_upload"]["tmp_name"], $target_file)){
                                 require_once("../model/class_config.php");
                                 $config = new Config();
                                 $config->atualizaConfig("caminho_logo", $_FILES["logo_upload"]["name"]);
                                 echo '<script>window.location="configuracoes"</script>';
                        } 
                    }else{
                        echo "<script>alert('Por favor, verifique os seguintes erros: \\n".$msg."');</script>";
                    }
                }

        if(isset($_POST['aux']) && $_POST['aux'] == 'atualizar'){
             $config = new Config();
             $config->atualizaConfig('exibe_box_atrasos', $_POST['exibe_box_atrasos']);
             $config->atualizaConfig('exibe_box_sem_registros', $_POST['exibe_box_sem_registros']);
             echo "<script>alert('Configurações atualizadas com sucesso!');</script>";
             
          }
       ?>
<div class="separador" ><span style="color: #ddd;" class="title">LAYOUT</span><input type="button" style="background-color: rgba(000,000,000,0.1); border:0; float:right; color:#cc0000" value="Configurar" onclick="mostraTabela1('style')" ></div>
<div id="style" hidden="on" style="float:left; width:100%">
    
      <div>   
            
      </div>
              
      <table border="0" style="width:100%">
      <form action="configuracoes" method="post" enctype="multipart/form-data">
                
          <tr >
                <td colspan="3" style="border-bottom: 1px solid #aaa"><span><b>GERAL</b></span></td>
          </tr>
          <tr >
                <td style="padding-left:10px;"><span>Logo: </span></td>
                <td><span><input type="file" name="logo_upload" id="logo-upload"></span></td>
                <td>
                    <span><input type="submit" value="Enviar" name="submit" style="background-color:#3a3; border-radius:5px; cursor: pointer"></span><img onmouseover="info('pop4')" onmouseout="fechar('pop4')" width='15px' src="../images/info-icon.png">
                    <div id="pop4" class="pop" style="display:none">
                        <div id="titulo4" class="title-info-config"><span>Atenção</span></div>
                        <div id="content4" class="content-info">
                              &bull; Os arquivos não devem ultra- passar 500Kb<br />
                              &bull; Os formatos aceitos são jpg, jpeg, png e gif<br />
                        </div>   
                    </div>
                </td>
          </tr>
                <!-- <span><b>Logo:</b></span>
                <input type="file" name="logo_upload" id="logo-upload">
                <input type="submit" value="Enviar" name="submit">
                </div> -->
      </form>


      <form method="POST" action="configuracoes">
          <input name="aux" type="hidden" value="atualizar">
         
              <tr>
                <td colspan="3" style="border-bottom: 1px solid #aaa"><span><b>TELA INICIAL </b></span></td>
              </tr>
              <tr>
                <td style="width:150px; padding-left:10px;"><span>Box Atrasos: </span></td>
                <td style="padding: 0">
                  <select style="width:100%" name="exibe_box_atrasos">
                    <option value="1">Exibir</option>
                    <option value="0" <?php (Config::get_config("exibe_box_atrasos", $_SESSION['id_empresa'])) == 0 ? print "selected" : print "" ?> >Ocultar</option>
                  </select>
                </td>
                <td style="width:150px;"><div class="box_atrasos_ico" id="box_atrasos_ico" ><img onmouseover="info('pop1')" onmouseout="fechar('pop1')" width='15px' src="../images/info-icon.png"></div>
                <!-- <td> -->
                    <div id="pop1" class="pop" style="display:none">
                        <div id="titulo1" class="title-info-config"><span>Informações</span></div>
                        <div id="content1" class="content-info">Exibe um bloco com dados dos funcionários que registraram o ponto com atraso.</div>   
                    </div>
                <!-- </td><td><span style="color:#565656"> (Máximo permitido: 59 minutos)</span></td> -->
                </td>
              </tr>
              <tr>
                <td style="padding-left:10px;"><span>Box Sem Registros: </span></td>
                <td style="padding: 0">
                    <select style="width:100%" name="exibe_box_sem_registros">
                         <option value="1">Exibir</option>
                         <option value="0" <?php (Config::get_config("exibe_box_sem_registros", $_SESSION['id_empresa'])) == 0 ? print "selected" : print "" ?> >Ocultar</option>
                    </select>
                </td>
                <td ><div ><img onmouseover="info('pop2')" onmouseout="fechar('pop2')" width='15px' src="../images/info-icon.png"></div>
                
                      <div id="pop2" class="pop" style="display:none">
                        <div id="titulo2" class="title-info-config"><span>Informações</span></div>
                        <div id="content2" class="content-info">Exibe um bloco com dados dos funcionários que esqueceram e não registraram o ponto.</div>   
                    </div>
                </td><!-- <td><span style="color:#565656"> (Máximo permitido: 59 minutos)</span></td> -->
              </tr>
            
              <tr>
                <td colspan="3" style="padding-top:20px; text-align:center"><input type="submit" class="button" value="Salvar"> <input type="button" class="button" value="Cancelar" onclick="window.location='configuracoes'"></td>
              </tr>
          
          </table>
          
      </form>

</div>