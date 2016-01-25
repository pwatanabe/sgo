<?php 
                if(validate()){
                     $config = new Config();
                     $config->atualizaConfig('temp_limit_atraso', $_POST['temp_limit_atraso']);
                     echo "<script>alert('Configurações atualizadas com sucesso!');</script>";

                  }
               ?>

<div style="float:left; width: 100%; margin-top:20px; padding-top: 5px; padding-bottom: 5px; text-align: center; background:url(../images/footer_lodyas.png); " ><span style="color: #ddd;" class="title">PONTO</span><input type="button" style="background-color: rgba(000,000,000,0.1); border:0; float:right; color:#cc0000" value="Configurar" onclick="mostraTabela1('ponto')" ></div>
<div id="ponto" hidden="on" style="float:left">
              <form method="POST" action="configuracoes" onsubmit="return valida(this)">
                  <table border="0">
                      <tr>
                        <td >
                            <span><b>Limite de atraso permitido: </b></span>
                        </td>
                        <td><input type="text" id="temp_limit_atraso" name="temp_limit_atraso" value="<?php echo $_SESSION['temp_limit_atraso']; ?>"></td>
                        <td style="width:150px;"><div class="box_atrasos_ico" id="box_atrasos_ico" ><img  onmouseover="info('pop3')" onmouseout="fechar('pop3')" width='15px' src="../images/info-icon.png"></div>
                        <!-- <td> -->
                            <div id="pop3" class="pop" style="display:none">
                                <div id="titulo3" class="title-info-config"><span>Informações</span></div>
                                <div id="content3" class="content-info">Tempo limite de atraso permitido, minimo 1 minuto e máximo 59 minutos.</div>   
                            </div>
                        <!-- </td><td><span style="color:#565656"> (Máximo permitido: 59 minutos)</span></td> -->
                        </td>
                      </tr>
                      <tr>
                        <td ><span><b>Empresa: </b></span></td><td><a href="<?php echo 'add_empresa?tipo=editar&id='.$_SESSION['id_empresa'] ?>"><span>Configurar dados</span></a></td><!-- <td><span style="color:#565656"> (Máximo permitido: 59 minutos)</span></td> -->
                      </tr>
                      <tr>
                        <td colspan="3" style="padding-top:20px; text-align:center"><input type="submit" class="button" value="Salvar"> <input type="button" class="button" value="Cancelar" onclick="window.location='configuracoes'"></td>
                      </tr>
                  
                </table>
              </form>
              <div>
              
              </div>
          
</div>
