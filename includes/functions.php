<?php 
/**
* Scripts
*
*/
Class Functions{
	function getHead($title){
		echo '<head>
			 	  <meta charset="UTF-8">
				  <link rel="icon" href="../images/ico-sgo.png" type="image/x-icon">
				  <!-- <meta HTTP-EQUIV="refresh" CONTENT="590"> -->
				 	<title>'.$title.'</title>
				 	
				 	<script src="../javascript/jquery-2.1.4.min.js"></script>
				 	<script src="../javascript/moment.js"></script>
				 	<script src="../javascript/selectbox.js" type="text/javascript"></script>
				 	<link rel="stylesheet" type="text/css" href="styles/style.css">
				 	<!--<script src="../javascript/jquery_mobile/jquery.mobile-1.4.5.min.js"></script>-->
				 	<!-- <link rel="stylesheet" type="text/css" href="../javascript/jquery_mobile/jquery.mobile-1.4.5.min.css"> -->
				    <!-- <link rel="stylesheet" type="text/css" href="../sistemaponto/styles/style.css"> -->
                                    <script>
                                               $(document).ready(function(){
                                                    $("#mostraForm").click(function(){
                                                        $("#form").fadeToggle("slow");
                                //                      
                                                    });
                                                });
                                    </script>
				 </head>';
	}
        
        

	function getScriptFuncionario(){
			?>
			<script type="text/javascript">
                            
				    function exibe(){
				        // document.getElementById("popup").style.display = "block";
				        var windowWidth = window.innerWidth;
				        var windowHeight = window.innerHeight;
				      
				        var screenWidth = screen.width;
				        var screenHeight = screen.height;
				        // alert(windowWidth+" x "+windowHeight)
				        if(windowWidth > 1200){
				          document.getElementById("popup").style.marginLeft = "35%";
				        }else if(windowWidth > 1000){
				          document.getElementById("popup").style.marginLeft = "30%";
				        }else if(windowWidth > 500){
				          document.getElementById("popup").style.marginLeft = "20%";
				        }else{
				          document.getElementById("popup").style.marginLeft = "0%";
				        }
				    }
				    function fechar(){
				        document.getElementById("popup").style.marginLeft = "-500px";
				    }
				    function confirma(id,nome){
				       if(confirm("Excluir funcionario "+nome+" , tem certeza?")){
				          var url = '../ajax/ajax_excluir_funcionario.php?id='+id+'&nome='+nome;
				          $.get(url, function(dataReturn) {
				            $('#result').html(dataReturn);
				            window.location.href='add_func.php';
				          });
				       }
				    }
				      function valida(f){
				        var erros = 0;
				        var msg = "";
				          for (var i = 0; i < f.length; i++) {
				              if(f[i].name == "codigo"){
				                  if(f[i].value == ""){
				                     msg += "Insira um Codigo!\n";
				                     f[i].style.border = "1px solid #FF0000";
				                     erros++;
				                  }else{
				                      f[i].style.border = "1px solid #898989";
				                  }
				              }
				              if(f[i].name == "nome" && f[i].value == ""){
				                msg += "Insira um Nome!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "nome" && f[i].value != ""){
				                f[i].style.border = "1px solid #898989";
				              }
				              if(f[i].name == "valor_custo" && f[i].value == ""){
				                msg += "Insira o valor de custo do funcionario!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "valor_custo" && f[i].value != ""){
				                f[i].style.border = "1px solid #898989";
				              }
				              
				              if(f[i].name == "tipo_custo" && f[i].value == "no_sel"){
				                msg += "Insira tip de custo!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "tipo_custo" && f[i].value != "no_sel"){
				                f[i].style.border = "1px solid #898989";
				              }
				              
				              if(f[i].name == "cpf"){
				                if(f[i].value == ""){
				                  msg += "Insira um CPF!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  if(!validarCPF(f[i].value)){
				                    msg += "Insira um CPF válido!\n";
				                    f[i].style.border = "1px solid #FF0000";
				                    erros++;
				                  }
				                }
				                if(f[i].value != "" && validarCPF(f[i].value)){
				                  f[i].style.border = "1px solid #898989";
				                }
				               
				              }

				              if(f[i].name == "email_emp"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo Email empresarial!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }
				              if(f[i].name == "data_admissao"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo Data de Admissão!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }
				              if(f[i].name == "sal_base"){
				                if(f[i].value == ""){
				                  msg += "Preencha corretamente o campo Salário Base!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                    var salario = f[i].value;
				                    var realAnCent = salario.replace(/[\R\$\,\.\ ]/g , "");
				                    if(realAnCent <= 0){
				                        msg += "Preencha corretamente o campo Salário Base!\n";
				                        f[i].style.border = "1px solid #FF0000";
				                        erros++;
				                    }else{
				                        f[i].style.border = "1px solid #898989"; 
				                    }
				                }
				              }
				              
				              if(f[i].name == "qtd_horas_sem"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo Quant. de Horas Semanais!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  if(f[i].value <= 0){
				                      msg += "Insira um valor acima de 0 em Quant. de Horas Semanais!\n";
				                      f[i].style.border = "1px solid #FF0000";
				                      erros++;
				                  }else{
				                      f[i].style.border = "1px solid #898989"; 
				                  }
				                }
				                
				              }


				              if(f[i].name == "data_nasc" && f[i].value == ""){
				                msg += "Insira uma Data de Nascimento!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "data_nasc" && f[i].value != ""){
				                f[i].style.border = "1px solid #898989";
				              }

				              if(f[i].name == "telefone" && f[i].value == ""){
				                msg += "Insíra um Telefone!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "telefone" && f[i].value != ""){
				                f[i].style.border = "1px solid #898989";
				              }

				              if(f[i].name == "email" && f[i].value == ""){
				                msg += "Insira um Email!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "email" && f[i].value != ""){
				                f[i].style.border = "1px solid #898989";
				              }

				              if(f[i].name == "senha"){
				                  if(f[i].value == "" && document.getElementById('tipo').value == "cadastrar"){
				                    msg += "Insira uma Senha!\n";
				                    f[i].style.border = "1px solid #FF0000";
				                    erros++;
				                  }
				              }
				              if(f[i].name == "senha" && f[i].value != ""){
				                f[i].style.border = "1px solid #898989";
				              }
				              if(f[i].name == "empresa"){
				                if(f[i].value == "no_sel"){
				                  msg += "Selecione uma empresa!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989";
				                }
				              }
				              

				              if(f[i].name == "turno" && f[i].value == "Selecione um turno"){
				                msg += "Selecione um Turno!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "turno" && f[i].value != "Selecione um turno"){
				                f[i].style.border = "1px solid #898989";
				              }

				              if(f[i].name == "cbo" && f[i].value == "Selecione um cbo"){
				                msg += "Selecione um CBO!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "cbo" && f[i].value != "Selecione um cbo"){
				                f[i].style.border = "1px solid #898989";
				              }

				              if(f[i].name == "rua" && f[i].value == ""){
				                msg += "Preencha o campo Rua\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "rua" && f[i].value != ""){
				                f[i].style.border = "1px solid #898989";
				              }

				              if(f[i].name == "num"){
					                if(f[i].value == ""){
					                  msg += "Preencha o campo Número!\n";
					                  f[i].style.border = "1px solid #FF0000";
					                  erros++;
					                }else{
					                    if(f[i].value <= 0){
					                        msg += "Insira um valor acima de 0 no campo Número!\n";
					                        f[i].style.border = "1px solid #FF0000";
					                        erros++;
					                    }else{
					                        f[i].style.border = "1px solid #898989";
					                    }
					                }
				              }

				              if(f[i].name == "cidade"){
					                if(f[i].value == "no_sel"){
					                  msg += "Escolha uma cidade!\n";
					                  f[i].style.border = "1px solid #FF0000";
					                  erros++;
					                }else{
					                   f[i].style.border = "1px solid #898989";                  
					                }
				              }

				              if(f[i].name == "estado" && f[i].value == "no_sel"){
				                msg += "Selecione um Estado\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "estado" && f[i].value != "no_sel"){
				                f[i].style.border = "1px solid #898989";
				              }
				              if(f[i].name == "superv"){
				                
				                if(!document.getElementById("is_admin").checked && f[i].value == "Selecione um supervisor"){
				                  msg += "Selecione um Supervisor\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989";  
				                }

				              }
				              if(f[i].name == "bairro"){
				                  if(f[i].value == ""){
				                     f[i].style.border = "1px solid #FF0000";
				                     msg += "Selecione um bairro\n";
				                     erros++;
				                  }else{
				                     f[i].style.border = "1px solid #898989";
				                  }
				               }

				          }
				          if(erros>0){            
				              alert(msg);
				            return false;
				          }
				      }
				    
				    function carrega_postos(){
				      var empresa = document.getElementById("empresa").value;
				      if(empresa){
				          var url = '../ajax/ajax_buscar_postos.php?empresa='+empresa;
				          $.get(url, function(dateReturn){
				            $('#load_postos').html(dateReturn);
				          });
				      }
				    }
				    
				    function carregaTipo_custo(tc){
				          
				     var combo = document.getElementById("tipo_custo");
				     for (var i = 0; i < combo.options.length; i++)
				     {
				       if (combo.options[i].value == tc)
				       {
				         combo.options[i].selected = true;
				         
				         break;
				       }
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
				    function mnum(v){
				              v=v.replace(/\D/g,"");                                      //Remove tudo o que não é dígito
				              return v;
				    }
				    function mvalor(v){
				              v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
				              v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
				              v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares

				              v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
				           return v;
				    }

				   function mtel(v){
				       if(v.length >=16){
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
				    function dnasc(v){
				       if(v.length >=10){      
				         v = v.substring(0,(v.length - 1));
				         return v;
				       }
				       v=v.replace(/\D/g,""); 
				       v=v.replace(/^(\d{2})(\d{2})(\d{4})/,"$1/$2/$3");  
				       return v;
				   }
				    function mrg(v){
				       if(v.length >=13){
				         v = v.substring(0,(v.length - 1));
				         return v;
				       }
				       v=v.replace(/^(\d{2})(\d{3})(\d{3})(\d{1})/,"$1.$2.$3-$4");
				       return v;
				   }
				   function id( el ){
				     return document.getElementById( el );
				   }
				   function carregaMascaras(){
				
				      id('cpf').onkeypress = function(){ 
				          mascara( this, mcpf );
				      };      
				      id('telefone').onkeypress = function(){
				          mascara( this, mtel );
				      };
				      id('data_em_rg').onkeypress = function(){
				          mascara( this, dnasc );
				      };
				      id('data_nasc').onkeypress = function(){
				          mascara( this, dnasc );
				      };
				      id('data_admissao').onkeypress = function(){
				          mascara( this, dnasc );
				      };
				      
				   }
				   
				   // fim Mask

				   function validarCPF(cpf) {  
				    cpf = cpf.replace(/[^\d]+/g,'');    
				    if(cpf == '') return false; 
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
				    add = 0;    
				    for (i=0; i < 9; i ++)       
				        add += parseInt(cpf.charAt(i)) * (10 - i);  
				        rev = 11 - (add % 11);  
				        if (rev == 10 || rev == 11)     
				            rev = 0;    
				        if (rev != parseInt(cpf.charAt(9)))     
				            return false;       
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
				function buscar_cidades(){
	      
					var estado = document.getElementById("estado").value;  //codigo do estado escolhido
					
					//se encontrou o estado
					if(estado){
					  var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
					  $.get(url, function(dataReturn) {
					    $('#load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
					  });
					}
				}

				function buscar_cid(id_est){
				      var estado = id_est;
				      
				      if(estado){
				        var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;
				        $.get(url, function(dataReturn) {
				          $('#load_cidades').html(dataReturn);
				        });
				      }
				    }
				function buscar_postos(id_empresa){
				      
				      if(id_empresa){
				        var url = '../ajax/ajax_buscar_postos.php?empresa='+id_empresa;
				        $.get(url, function(dataReturn) {
				          $('#load_postos').html(dataReturn);
				        });
				      }
				    }
				function carregaUf_CartTrab(uf){
				      var combo = document.getElementById("uf_cart_trab");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == uf)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				  function carregaUf(uf){
				      var combo = document.getElementById("estado");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == uf)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				    function carregaSuperv(sup){
				      var combo = document.getElementById("superv");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == sup)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				  function carregaEmpresa(empresa){
				      
				      var combo = document.getElementById("empresa");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == empresa)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				    function carregaSuperv(sup){
				      var combo = document.getElementById("superv");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == sup)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				  function carregaPostosTrabalho(){
				      var combo = document.getElementById("empresa_filial");
				      var posto = document.getElementById("id_posto").value;

				      for (var i = 0; i < combo.length; i++)
				      {

				        if (combo.options[i].value == posto)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				    function carregaTurno(turno){
				      var combo = document.getElementById("turno");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == turno)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				    function carregaCBO(cbo){
				      var combo = document.getElementById("cbo");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == cbo)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				     function carregaCidade(){
				        var combo = document.getElementById("cidade");
				        var cidade = document.getElementById("id_cidade").value;
				  
				        for (var i = 0; i < 1000; i++)
				         {
				           if (combo.options[i].value == cidade)
				               {
				               combo.options[i].selected = true;
				               break;
				             }
				           } 
				      }
				  	function disparaLoadCidade(){
				      carrega_postos();
				      setTimeout(function() {
				         carregaCidade();
				        }, 500);
				      }

				  function mudaValor(){
				        if(document.getElementById("estagiario").value == 0){
				          $('#salario').html("Bolsa: ");
				          document.getElementById("estagiario").value = 1;
				          document.getElementById("cpf").required = false;
				        }else{
				          $('#salario').html("Salário Base: ");
				          document.getElementById("estagiario").value = 0;
				          document.getElementById("cpf").required = true;
				        }
				    }
		</script>
		<?php
	}// fim getScriptFuncionario()

	function getScriptCBO(){
		?>
		<script type="text/javascript">
			   function selectAll(){
			      var select = document.getElementById("selecionados");
			      for(i=0; i<select.length; i++){
			         select[i].selected = true;
			      }
			   }
			   function validate(f){ 
			      var erros=0;   
			      for(i=0; i<f.length; i++){
			         if(f[i].name == "codigo"){
			            if(f[i].value == ""){
			               f[i].style.border = "1px solid #f00";
			               erros++;
			            }else{
			              f[i].style.border = "1px solid #898989";
			            }
			         }
			         if(f[i].name == "descricao"){
			            if(f[i].value == ""){
			               f[i].style.border = "1px solid #f00";
			               erros++;
			            }else{
			              f[i].style.border = "1px solid #898989";
			            }
			         }
			      }
			      if(erros>0){
			         return false;
			      }else{
			         return true;
			      }

			   }
			</script>

		<?php
	}// fim getScriptCBO()

	function getScriptCliente(){
		?>
		<script type="text/javascript">

				function confirma(id,nome, tipopess){
			       if(confirm("Excluir cliente "+nome+" , tem certeza?") ){
			          var url = '../ajax/ajax_excluir_cliente.php?id='+id+'&nome='+nome+'&tipopess='+tipopess;  //caminho do arquivo php que irá buscar as cidades no BD
			          
			          $.get(url, function(dataReturn) {
			            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
			            window.location.href='add_cliente.php';
			          });
			       }
			    }
				
				function tipo_form(){
					
					// if(document.getElementById("fornecedor").checked){
					// 	document.getElementById("fornecedor").value=0;
					// }else{
					// 	document.getElementById("fornecedor").value=1;
					// }

					if(document.getElementById("pessoa_fisica").checked == true){
						document.getElementById("razao_nome").innerHTML = "<span>Nome:</span>";
						document.getElementById("data_nasc").value = "0000-00-00";
						document.getElementById("data_fun_data_nasc").innerHTML = "<span>Data de Nascimento:</span>";
						document.getElementById("cnpj_cpf").innerHTML = "<span>CPF:</span>";
						document.getElementById("data_nasc").disabled = false;
						document.getElementById("cnpj").type = "hidden";
						document.getElementById("cnpj").value ="";
						document.getElementById("cpf").type="text";
						document.getElementById("inscricao_estadual_rg").innerHTML = "<span>RG:</span>";			
						document.getElementById("inscricao_estadual").type="hidden";
						document.getElementById("inscricao_estadual").value="";
						document.getElementById("rg").type="text";			
						document.getElementById("inscricao_municipal").type="hidden";
						document.getElementById("inscricao_municipal").value="";
						document.getElementById("inscricao_municipal_nulo").innerHTML = "";
					}

					if(document.getElementById("pessoa_juridica").checked == true){
						document.getElementById("razao_nome").innerHTML = "<span>Razao Social:</span>";
						document.getElementById("data_fun_data_nasc").innerHTML = "<span>Data registro:</span>";
						document.getElementById("data_nasc").value = document.getElementById('today').value;
						document.getElementById("data_nasc").disabled = true;
						document.getElementById("cnpj_cpf").innerHTML = "<span>CNPJ:</span>";
						document.getElementById("cnpj").type = "text";
						document.getElementById("cpf").value ="";
						document.getElementById("cpf").type="hidden";	
						document.getElementById("inscricao_estadual_rg").innerHTML = "<span>Inscrição Estadual:</span>";
						document.getElementById("inscricao_estadual").name= "inscricao_estadual";
						document.getElementById("inscricao_estadual").type="text";
						document.getElementById("rg").type = "hidden";
						document.getElementById("rg").value = "";
						document.getElementById("inscricao_municipal").type="number";
						document.getElementById("inscricao_municipal_nulo").innerHTML="<span>Inscrição Municipal:</span>";
						document.getElementById("inscricao_municipal").name="inscricao_municipal";		
					}
				}

					

				 	function valida(f){
				        var erros = 0;
				        var msg = "";
				          for (var i = 0; i < f.length; i++) {

				          	//Dados Empresa ou dados Pessoais
				      

				         	if(document.getElementById("pessoa_fisica").checked == true) //
				         	{
				         		
				         	}else{
				         		      if(f[i].name == "nome"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "data_nasc"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "cpf" && document.getElementById("pessoa_juridica").checked != true){
					            if(f[i].value == ""){
					               alert("Digite um cpf");
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
					            if(!validarCPF(f[i].value)){
					               alert("Digite um cpf valido");
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	
				         	if(f[i].name == "com"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					            	      if(f[i].name == "nome"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "data_nasc"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "cpf" && document.getElementById("pessoa_juridica").checked != true){
					            if(f[i].value == ""){
					               alert("Digite um cpf");
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
					            if(!validarCPF(f[i].value)){
					               alert("Digite um cpf valido");
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "cel"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "com"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

					               f[i].style.border = "1px solid #898989";
			                                }
			                            }
				        	}

				         	//Dados de endereço 

				         	if(f[i].name == "bairro"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "rua"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "numero"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "cidade"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}

				         	if(f[i].name == "cep"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
			                            }
						}
						if(erros>0){
							return false;
						}else{
							return true;
						}
				 }

				 	    // inicio mascaras
			    function mascara(o,f){
			          v_obj=o
			          v_fun=f
			          setTimeout("execmascara()",1)
			      }
			      function execmascara(){
			          v_obj.value=v_fun(v_obj.value)
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
			   function mtel(v){
			       if(v.length >=15){                                          // alert("mtel")
			         v = v.substring(0,(v.length - 1));
			         return v;
			       }
			       v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
			       v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
			       v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
			       
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
			    function dnasc(v){
			       if(v.length >=10){      
			         v = v.substring(0,(v.length - 1));
			         return v;
			       }
			       v=v.replace(/\D/g,""); 
			       v=v.replace(/^(\d{2})(\d{2})(\d{4})/,"$1/$2/$3");  
			       return v;
			   }
			    function mrg(v){
			       if(v.length >=13){
			         v = v.substring(0,(v.length - 1));
			         return v;
			       }
			       v=v.replace(/^(\d{2})(\d{3})(\d{3})(\d{1})/,"$1.$2.$3-$4");
			       return v;
			   }
			   function id( el ){
			     // alert("id")
			     return document.getElementById( el );
			   }

			   function validarCPF(cpf) {
			   
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

			   function carregaMascaras(){ 

			   	  if($("#cnpj").length)  		
				   	  id('cnpj').onkeypress = function(){
				              mascara( this, mcnpj );
				      }
			      if($("#cpf").length)
				      id('cpf').onkeypress = function(){
				           mascara( this, mcpf );
				      }
			      id('cpf_resp').onkeypress = function(){
			          mascara( this, mcpf );
			      }
			      id('com').onkeypress = function(){
			          mascara( this, mtel );
			      }
			      id('cel').onkeypress = function(){
			          mascara( this, mtel );
			      }
			      id('datanasc_resp').onkeypress = function(){
			          mascara( this, dnasc );
			      }  
			     
			   }
			   	function buscar_cidades(){
	      
					var estado = document.getElementById("estado").value;  //codigo do estado escolhido
					
					//se encontrou o estado
					if(estado){
					  var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
					  $.get(url, function(dataReturn) {
					    $('#load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
					  });
					}
				}

			   
				function carregaCidade(){
			      var combo = document.getElementById("cidade");
			      var cidade = document.getElementById("id_cidade").value;
			      
			      for (var i = 0; i < combo.length; i++)
			      {
			         
			        if (combo.options[i].value == cidade)
			        {
			          combo.options[i].selected = true;
			          break;
			        }
			      }
			      
			    }
			    function buscar_cid(id_est){
			      var estado = id_est;  //codigo do estado escolhido
			      //se encontrou o estado
			      if(estado){
			        var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
			        $.get(url, function(dataReturn) {
			          $('#load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
			        });
			      }
			    }

				function disparaLoadCidade(){
			      setTimeout(function() {
			         carregaCidade();
			         carregaPostosTrabalho();
			        }, 500);
			    }

				function carregaUf(uf){
			      var combo = document.getElementById("estado");
			      for (var i = 0; i < combo.options.length; i++)
			      {
			        if (combo.options[i].value == uf)
			        {
			          combo.options[i].selected = true;
			          
			          break;
			        }
			      }
			    }  

			</script>

		<?php

	}// fim getScriptCliente()

	function getScriptEmpresa(){
		?>
		<script type="text/javascript"> 
			 function confirma(id,nome){

			       if(confirm("Excluir Empresa "+nome+" , tem certeza?")){
			          var url = '../ajax/ajax_excluir_Empresa.php?id='+id+'&nome='+nome;  //caminho do arquivo php que irá buscar as cidades no BD
			          $.get(url, function(dataReturn) {
			            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
			          });
			       }
			    }


			    function valida(f){
			        var erros = 0;
			        var msg = "";
			          for (var i = 0; i < f.length; i++) {
			              if(f[i].name == "nome_fantasia" && f[i].value == ""){
			                msg += "Insira um Nome Fantasia para add_empresa_bd!\n";
			                f[i].style.border = "1px solid #FF0000";
			                erros++;
			              }
			              if(f[i].name == "nome Fantasia" && f[i].value != ""){
			                f[i].style.border = "1px solid #898989";
			              }

			              if(f[i].name == "tel"){
			                if(f[i].value == ""){
			                  msg += "Preencha o campo de telefone!\n";
			                  f[i].style.border = "1px solid #FF0000";
			                  erros++;
			                }else{
			                  f[i].style.border = "1px solid #898989"; 
			                }
			              }
			              if(f[i].name == "cnpj"){
			                if(f[i].value == ""){
			                  msg += "Preencha o do cnpj!\n";
			                  f[i].style.border = "1px solid #FF0000";
			                  erros++;
			                }else{
			                  f[i].style.border = "1px solid #898989"; 
			                }
			              }
			              if(f[i].name == "numero"){
			                if(f[i].value == ""){
			                  msg += "Preencha o campo de telefone!\n";
			                  f[i].style.border = "1px solid #FF0000";
			                  erros++;
			                }if(f[i].value <= 0){
			                        msg += "Insira um valor acima de 0 no campo Número!\n";
			                        f[i].style.border = "1px solid #FF0000";
			                        erros++;
			                    }else{
			                        f[i].style.border = "1px solid #898989";
			                    }
			                  }
			              if(f[i].name == "razao_social"){
			                if(f[i].value == ""){
			                  msg += "Preencha o campo de Razão Social!\n";
			                  f[i].style.border = "1px solid #FF0000";
			                  erros++;
			                }else{
			                  f[i].style.border = "1px solid #898989"; 
			                }
			              }
			              if(f[i].name == "responsavel"){
			                if(f[i].value == "no_res"){
			                  msg += "Escolha uma opção no campo Responsavel!\n";
			                  f[i].style.border = "1px solid #FF0000";
			                  erros++;
			                }else{
			                  f[i].style.border = "1px solid #898989"; 
			                }
			              }
			               if(f[i].name == "estado" && f[i].value == "Selecione um estado"){
			                msg += "Selecione um Estado\n";
			                f[i].style.border = "1px solid #FF0000";
			                erros++;
			              }
			              if(f[i].name == "estado" && f[i].value != "Selecione um estado"){
			                f[i].style.border = "1px solid #898989";
			              }

			              if(f[i].name == "cidade"){
			                if(f[i].value == ""){
			                  msg += "Escolha uma cidade!\n";
			                  f[i].style.border = "1px solid #FF0000";
			                  erros++;
			                }else{
			                  f[i].style.border = "1px solid #898989"; 
			                }
			              }
			              if(f[i].name == "telefone" && f[i].value == ""){
			                msg += "Insíra um Telefone!\n";
			                f[i].style.border = "1px solid #FF0000";
			                erros++;
			              }
			              if(f[i].name == "telefone" && f[i].value != ""){
			                f[i].style.border = "1px solid #898989";
			              }

			              if(f[i].name == "rua" && f[i].value == ""){
			                msg += "Preencha o campo Rua\n";
			                f[i].style.border = "1px solid #FF0000";
			                erros++;
			              }
			              if(f[i].name == "rua" && f[i].value != ""){
			                f[i].style.border = "1px solid #898989";
			              }

			              if(f[i].name == "bairro"){
			                  if(f[i].value == ""){
			                     f[i].style.border = "1px solid #FF0000";
			                     msg += "Selecione um bairro\n";
			                     erros++;
			                  }else{
			                     f[i].style.border = "1px solid #898989";
			                  }
			               }
			               if(f[i].name == "cep"){
			                  if(f[i].value == ""){
			                      msg += "Selecione um cep\n";
			                     f[i].style.border = "1px solid #FF0000";
			                     erros++;
			                  }else{
			                     f[i].style.border = "1px solid #898989";
			                  }
			               }
			          }
			          if(erros>0){
			            
			              alert(msg);
			            
			            return false;
			          }
			      }
				// mascaras
			      function mascara(o,f){
			          v_obj=o
			          v_fun=f
			          setTimeout("execmascara()",1)
			      }
			      function execmascara(){
			          v_obj.value=v_fun(v_obj.value)
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
			       function mtel(v){
			           if(v.length >=15){                                          // alert("mtel")
			             v = v.substring(0,(v.length - 1));
			             return v;
			           }
			           v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
			           v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
			           v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
			           
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
			       function mnum(v){
			          if(v.length >=19){                                          // alert("mtel")
			             v = v.substring(0,(v.length - 1));
			             return v;
			          }
			          v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
			          return v;
			       }
			        
			       function id( el ){
			         // alert("id")
			         return document.getElementById( el );
			       }
			       function mcep(v){
			          if(v.length >= 10){
			            v=v.substring(0,(v.length - 1));
			            return v;
			          }
			          v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
			          v=v.replace(/^(\d{5})(\d{3})$/,"$1-$2");

			          return v;
			       }
			       window.onload = function(){
			          
			          id('tel').onkeypress = function(){
			              mascara( this, mtel );
			          }
			          id('cnpj').onkeypress = function(){
			              mascara( this, mcnpj );
			          }
			          id('numero').onkeypress = function(){
			              mascara( this, mnum );
			          }
			          id('cep').onkeypress = function(){
			            mascara( this, mcep );
			          }         
			        }
			      //fim mascaras

			function buscar_cidades(){
					      
					var estado = document.getElementById("estado").value;  //codigo do estado escolhido
					//se encontrou o estado

					if(estado){

					  var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD

					  $.get(url, function(dataReturn) {
					    $('#load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
					  });
					}
				}
				    function carregaCidade(){
			        var combo = document.getElementById("cidade");
			        var cidade = document.getElementById("id_cidade").value;
			  
			        for (var i = 0; i < 1000; i++)
			         {
			           if (combo.options[i].value == cidade)
			               {
			               combo.options[i].selected = true;
			               break;
			             }
			           } 
			      }
			  function disparaLoadCidade(){
			      setTimeout(function() {
			         carregaCidade();
			        }, 500);
			      }

			    function carregaUf(uf){
			      var combo = document.getElementById("estado");
			      for (var i = 0; i < combo.options.length; i++)
			      {
			        if (combo.options[i].value == uf)
			        {
			          combo.options[i].selected = true;
			          
			          break;
			        }
			      }
			      buscar_cidades();
			    } 
			    function carregaResponsavel(id_resp){
			      var combo = document.getElementById("responsavel");
			      for (var i = 0; i < combo.options.length; i++)
			      {
			        if (combo.options[i].value == id_resp)
			        {
			          combo.options[i].selected = true;
			          
			          break;
			        }
			      }
			    }
			   
			 </script>
		<?php
		}//fim getScriptEmpresa()

		
		function getScriptEPI(){
		?>
			<script type="text/javascript">

			     function confirma(id,nome){
			          
			          if(confirm("Excluir EPI "+nome+" , tem certeza?")){
			             var url = '../ajax/ajax_excluir_epi.php?id='+id+'&nome='+nome;  //caminho do arquivo php que irá buscar as cidades no BD
			             $.get(url, function(dataReturn) {
			               $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
			             });
			          }
			       }
			           
			    function carregaEmpresa(empresa){
			      
			      var combo = document.getElementById("empresa");
			      for (var i = 0; i < combo.options.length; i++)
			      {
			        if (combo.options[i].value == empresa)
			        {
			          combo.options[i].selected = true;
			          break;
			        }
			      }
			    }
			     function validate(f){
			        var erros = 0;
			        var msg = "";

			              for (var i = 0; i < f.length; i++) {
			               
			                  if(f[i].name == "codigo"){
			                  if(f[i].value == ""){
			                      msg += "Digite um codigo para o equipamento\n";
			                     f[i].style.border = "1px solid #FF0000";
			                     erros++;
			                  }else{
			                     f[i].style.border = "1px solid #898989";
			                  }
			               }
			               if(f[i].name == "nome" && f[i].value == ""){
			                msg += "Insira um Nome!\n";
			                f[i].style.border = "1px solid #FF0000";
			                erros++;
			              }
			              if(f[i].name == "nome" && f[i].value != ""){
			                f[i].style.border = "1px solid #898989";
			              }
			                if(f[i].name == "empresa"){
			                if(f[i].value == "no_sel"){
			                  msg += "Selecione uma empresa!\n";
			                  f[i].style.border = "1px solid #FF0000";
			                  erros++;
			                }else{
			                  f[i].style.border = "1px solid #898989";
			                }

			              }
			              
			             if(erros>0){
			                    
			                      alert(msg);
			                    
			                    return false;
			                  }
			                 }
			               }
			</script>


		<?php
		}//fim getScriptEPI()

		
		function getScriptEPI_FUNC(){
		?>
			<script type="text/javascript">
			      function validate(f){ 
			            var erros=0;   
			            for(i=0; i<f.length; i++){
			               if(f[i].name == "data"){
			                  if(f[i].value == ""){
			                     f[i].style.border = "1px solid #f00";
			                     erros++;
			                  }else{
			                    f[i].style.border = "1px solid #898989";
			                  }
			               }

			               if(f[i].name == "selecionados[]"){
			                  if(f[i].selectedIndex == -1){
			                     f[i].style.border = "1px solid #f00";
			                     erros++;
			                  }else{
			                    f[i].style.border = "1px solid #898989";
			                  }
			               }
			            }
			            if(erros>0){
			               return false;
			            }else{
			               return true;
			            }

			         }

			    // function avanca(tipo){
			    //       html = '<td>Preencha a quantidade dos equipamentos<br />';
			    //       for(i=0; i<document.getElementById("selecionados").options.length; i++)
			            
			    //         html += document.getElementById("selecionados").options[i].text+": <input type='text' name="+document.getElementById("selecionados").options[i].value+"><br />";
			    //       html += "</td>";
			              
			        
			    //       $('#equipamentos').html(html);  //coloco na div o retorno da requisicao
			    //       $('#btnAvancar').html('<input style="width:80px;" type="button" name="button" class="button" id="buttonAvancar" onclick="selectAll(), submit()" value="Cadastrar">');  //coloco na div o retorno da requisicao
			          
			          
			    //       // document.getElementById("add_epiXfunc").submit();
			    // }
			    // function submit(){
			    //     document.getElementById("add_epiXfunc").submit(); 
			    // }
			    function selectAll(){
			        var select = document.getElementById("selecionados");
			        for(i=0; i<select.length; i++){
			          
			           select[i].selected = true;
			        }
			    }
			   
			</script>
		<?php
		}//fim getScriptEPI_FUNC()

		
		function getScriptExames(){
		?>
			<script type="text/javascript">
				    function confirma(id,nome){
				       if(confirm("Excluir cliente "+nome+" , tem certeza?") ){
				          var url = '../ajax/ajax_excluir_exame.php?id='+id+'&nome='+nome;  //caminho do arquivo php que irá buscar as cidades no BD
				          
				          $.get(url, function(dataReturn) {
				            
				            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
				          });
				       }
				    }

				    function carregaPeriodo(per){
				      var combo = document.getElementById("periodo");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == per)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }

				   function validate(f){
				      var erros=0;
				      for(i=0; i < f.length; i++){
				        if(f[i].name == "descricao"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "periodo"){
				            if(f[i].value == "no_sel"){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				      }
				      if(erros>0){
				         return false;
				      }else{
				         return true;
				      }
				   }
				</script>
		<?php
		}//fim getScriptExames()


		function getScriptFilial(){
		?>
			<script type="text/javascript">

				    function confirma(id,nome){
				       if(confirm("Excluir Filial "+nome+" , tem certeza?")){
				          var url = '../ajax/ajax_excluir_filial.php?id='+id+'&nome='+nome;  //caminho do arquivo php que irá buscar as cidades no BD
				          $.get(url, function(dataReturn) {
				            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
				          });
				       }
				    }

				   function validate(f){
				    var erros=0;
				      for(i=0; i < f.length; i++){
				     
				        if(f[i].name == "cod_posto"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "nome"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "telefone"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "rua"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "num"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "bairro"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "estado"){
				            if(f[i].value == "no_sel"){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "cidade"){
				            if(f[i].value == "no_sel"){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "cep"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "empresa"){
				            if(f[i].value == "no_sel"){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "responsavel"){
				            if(f[i].value == "no_sel"){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }

				      }
				      if(erros > 0 ){
				        return false;
				      }else{
				        return true; 
				      }
				      
				   }

				   // mascaras
				      function mascara(o,f){
				          v_obj=o
				          v_fun=f
				          setTimeout("execmascara()",1)
				      }
				      function execmascara(){
				          v_obj.value=v_fun(v_obj.value)
				      }

				       function mtel(v){
				           if(v.length >=15){                                          // alert("mtel")
				             v = v.substring(0,(v.length - 1));
				             return v;
				           }
				           v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
				           v=v.replace(/^(\d{2})(\d)/g,"($1) $2"); //Coloca parênteses em volta dos dois primeiros dígitos
				           v=v.replace(/(\d)(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
				           
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
				       function mnum(v){
				          if(v.length >=19){                                          // alert("mtel")
				             v = v.substring(0,(v.length - 1));
				             return v;
				          }
				          v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
				          return v;
				       }
				        
				       function id( el ){
				         // alert("id")
				         return document.getElementById( el );
				       }
				       function mcep(v){
				          if(v.length >= 10){
				            v=v.substring(0,(v.length - 1));
				            return v;
				          }
				          v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
				          v=v.replace(/^(\d{5})(\d{3})$/,"$1-$2");

				          return v;
				       }
				       window.onload = function(){
				          
				          id('telefone').onkeypress = function(){
				              mascara( this, mtel );
				          }
				          // id('cnpj').onkeypress = function(){
				          //     mascara( this, mcnpj );
				          // }
				          id('num').onkeypress = function(){
				              mascara( this, mnum );
				          }
				          id('cep').onkeypress = function(){
				            mascara( this, mcep );
				          }
				       }
				      //fim mascaras
				   function selectAll(){
				      var select = document.getElementById("selecionados");
				      for(i=0; i<select.length; i++){
				         select[i].selected = true;
				      }
				   }
				       function carregaCidade(){
				          var combo = document.getElementById("cidade");
				          var cidade = document.getElementById("id_cidade").value;

				          for (var i = 0; i < 1000; i++)
				          {
				            if (combo.options[i].value == cidade)
				            {
				              combo.options[i].selected = true;
				              break;
				            }
				          }
				        
				      }
				      function buscar_cid(id_est){
				      var estado = id_est;  //codigo do estado escolhido
				      //se encontrou o estado
				      if(estado){
				        var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
				        $.get(url, function(dataReturn) {
				          $('#load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
				        });
				      }
				    }
				   function carregaEmpresa(id_emp){
				          var combo = document.getElementById("empresa");
				          for (var i = 0; i < combo.options.length; i++)
				          {
				            if (combo.options[i].value == id_emp)
				            {
				              combo.options[i].selected = true;
				              
				              break;
				            }
				          }
				      }
				      
				   
				    function buscar_cid(id_est){
				      var estado = id_est;  //codigo do estado escolhido
				      //se encontrou o estado
				      if(estado){
				        var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
				        $.get(url, function(dataReturn) {
				          $('#load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
				        });
				      }
				    }
				   
				      function buscar_cidades(){         
				          var estado = document.getElementById("estado").value;  //codigo do estado escolhido

				          //se encontrou o estado
				          if(estado){

				            var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD

				            $.get(url, function(dataReturn) {
				              $('#load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
				            });
				          }
				        }
				          function disparaLoadCidade(){
				      setTimeout(function() {
				         carregaCidade();
				        }, 500);
				      }
				    
				    function carregaUF(uf){
				        var combo = document.getElementById("estado");

				        for(i = 0; i < combo.options.length ;  i++){
				            if(combo.options[i].value == uf){ 
				              combo.options[i].selected = true;
				              break;
				            }
				        }
				        buscar_cidades();
				      }
				      function carregaUf(uf){
				        var combo = document.getElementById("estado");

				        for(i = 0; i < combo.options.length ;  i++){
				            if(combo.options[i].value == uf){ 
				              combo.options[i].selected = true;
				              break;
				            }
				        }
				        buscar_cidades();
				      }
				       function carregaResponsavel(id_resp){
				        var combo = document.getElementById("responsavel");
				        for (var i = 0; i < combo.options.length; i++)
				        {
				          if (combo.options[i].value == id_resp)
				          {
				            combo.options[i].selected = true;
				            
				            break;
				          }
				        }
				      }
				</script>
		<?php
		}//fim getScriptFilial()


		function getScriptMaterial(){
		?>
			<script type="text/javascript">
			        function valida(f){
				        var erros = 0;
				        var msg = "";
				          for (var i = 0; i < f.length; i++) {
			                      if(f[i].name == "empresa"){
					            if(f[i].value == "no_sel"){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}
			                        if(f[i].name == "nome"){
					            if(f[i].value == ""){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}
			                        if(f[i].name == "medida"){
					            if(f[i].value == "no_sel"){
					               f[i].style.border = "1px solid #FF0000";
					               erros++;
					            }else{
					               f[i].style.border = "1px solid #898989";
					            }
				         	}
			         
			                    if(erros>0){
			                        return false;
						}else{
			                    return true;
						}
			                     }
			                 }
				function confirma(id,nome){
			            
			       if(confirm("Excluir Material "+nome+" , tem certeza?") ){
			          var url = '../ajax/ajax_excluir_material.php?id='+id+'&nome='+nome;  //caminho do arquivo php que irá buscar as cidades no BD
			          
			          $.get(url, function(dataReturn) {
			          	
			            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
			          });
			       }
			    }
			    function carregaU_M(uf){

			          var combo = document.getElementById("medida");
			          for (var i = 0; i < combo.options.length; i++)
			          {
			            if (combo.options[i].value == uf)
			            {
			              combo.options[i].selected = true;

			              break;
			            }
			          }
			        }
			    function carregaEmp(emp,j){
			          var combo = document.getElementById(j+":empresa");
			          for (var i = 0; i < combo.options.length; i++)
			          {
			            if (combo.options[i].value == emp)
			            {
			              combo.options[i].selected = true;

			              break;
			            }
			          }
			        }    
			    function carregaTipo_custo(tc){
			           
			      var combo = document.getElementById("tipo_custo");
			      for (var i = 0; i < combo.options.length; i++)
			      {
			        if (combo.options[i].value == tc)
			        {
			          combo.options[i].selected = true;
			          
			          break;
			        }
			      }
			    }    
			        function mascara(o,f){
			          v_obj=o
			          v_fun=f
			          setTimeout("execmascara()",1)
			      }
			      function execmascara(){
			          v_obj.value=v_fun(v_obj.value)
			      }
			    function mmoney(v){
			       if(v.length >=18){                                          // alert("mtel")
			         v = v.substring(0,(v.length - 1));
			         return v;
			       }
			       v=v.replace(/\D/g,"");             //Remove tudo o que não é dígito
			       v=v.replace(/(\d)(\d{11})$/,"$1.$2");    //Coloca hífen entre o quarto e o quinto dígitos
			       v=v.replace(/(\d)(\d{8})$/,"$1.$2");    //Coloca hífen entre o quarto e o quinto dígitos
			       v=v.replace(/(\d)(\d{5})$/,"$1.$2");    //Coloca hífen entre o quarto e o quinto dígitos
			       v=v.replace(/(\d)(\d{2})$/,"$1,$2");    //Coloca hífen entre o quarto e o quinto dígitos
			       
			       return 'R$ '+v;
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
			    function dnasc(v){
			       if(v.length >=10){      
			         v = v.substring(0,(v.length - 1));
			         return v;
			       }
			       v=v.replace(/\D/g,""); 
			       v=v.replace(/^(\d{2})(\d{2})(\d{4})/,"$1/$2/$3");  
			       return v;
			   }
			    function mrg(v){
			       if(v.length >=13){
			         v = v.substring(0,(v.length - 1));
			         return v;
			       }
			       v=v.replace(/^(\d{2})(\d{3})(\d{3})(\d{1})/,"$1.$2.$3-$4");
			       return v;
			   }
			   function id( el ){
			     return document.getElementById( el );
			   }
			   window.onload = function(){
			      mascara( id('custo'), mmoney );
			      
			      id('sal_base').onkeypress = function(){ 
			          mascara( this, mmoney );
			      }
			      id('custo').onkeypress = function(){ 
			          mascara( this, mmoney );
			      }
			      id('cpf').onkeypress = function(){ 
			          mascara( this, mcpf );
			      }
			      
			      id('telefone').onkeypress = function(){
			          mascara( this, mtel );
			      }
			      
			   }

			    
			    function carregaUf(uf){
			         data = uf.split(" ");
			          var aux = data[0];
			         
			          var aux2 = data[1];
			        
			        
			      var combo = document.getElementById(aux2+"xestado");
			      for (var i = 0; i < combo.options.length; i++)
			      {
			        if (combo.options[i].value == aux)
			        {
			          combo.options[i].selected = true;
			          
			          break;
			        }
			      }
			      buscar_cidades(aux2+"xestado");
			    } 
			    
			    function buscar_cidades(x){ 
			          
			          var estado = document.getElementById(x).value;  //codigo do estado escolhido
			          data = x.split("x");
			          var aux = data[0];
			          var aux2 = data[1];
			         
			          //se encontrou o estado
			          if(estado){
			            var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
			            $.get(url, function(dataReturn) {
			              $('#'+aux+'load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
			            });
			          }
			    }
			    
			    function carregaCidade(){
			                
			                
			                var combo = document.getElementById("cidade");
			                var cidade = document.getElementById("id_cidade").value;
			                
			                for (var i = 0; i < combo.length; i++)
			                {

			                  if (combo.options[i].value == cidade)
			                  {
			                    combo.options[i].selected = true;
			                    break;
			                  }
			                }      
			    }
			          function hideall(x){
			            if(document.getElementById(x).hidden == true){
			                document.getElementById(x).hidden = false;
			            }else{
			                document.getElementById(x).hidden = true;
			                document.getElementById(1).hidden = true;
			                document.getElementById(2).hidden = true;
			                document.getElementById(3).hidden = true;
			                document.getElementById(4).hidden = true;
			                document.getElementById("opcoes-materiais").hidden = true;
			            }
			        }
			     
			     function ocultaTabela(x){
			          if(document.getElementById(x).hidden == true){
			                document.getElementById(x).hidden = false;
			            }else{
			                document.getElementById(x).hidden = true;
			            }
			     }
			     function mostraTabela1(x){
			            
			            if(document.getElementById(2).hidden == false){
			                document.getElementById(2).hidden = true;
			            }
			            
			            
			            if(document.getElementById(x).hidden == true){
			                document.getElementById(x).hidden = false;
			            }else{
			                document.getElementById(x).hidden = true;
			            }
			            
			     }
			   
			     function mostraTabela2(x){
			            if(document.getElementById(1).hidden == false){
			                document.getElementById(1).hidden = true;
			            }
			            
			            if(document.getElementById(x).hidden == true){
			                document.getElementById(x).hidden = false;
			            }else{
			                document.getElementById(x).hidden = true;
			            }
			            
			     }
                  
			</script>
		<?php
		}//fim getScriptMaterial()

		
		function getScriptObra(){
		?>
			<script type="text/javascript">





					function ajusta(id, tipo){

						if(tipo == '+'){//aumenta
							document.getElementById(id).style.width = '95%';
						}else{
							document.getElementById(id).style.width = '43%';
						}
					}
				    function info(id){
				      
				      var divPop = document.getElementById(id);
				      divPop.style.display = "";
				    }
				    function fecharInfo(id){
				      var divPop = document.getElementById(id);
				      divPop.style.display = "none";
				    }
				    function oculta(t){
				        var opc = confirm("Ocultar esse bloco, tem certeza?");
				        if(opc){
				            window.location = 'principal.php?oculta=yes&bloco='+t;
				        }
				    }

				    function novo_produto(){
				                    
				        window.open("add_produto.php", 'janela','width=800, height=800, scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');
				    }
				    
				    function carregaF_O(f_o){
				          
				      var combo = document.getElementById("responsavel_obra");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == f_o)
				        {
				          combo.options[i].selected = true;
				          
				          break;
				        }
				      }
				    }

				    function mostraLocal(){ // FUNCAO QUE MOSTRA OCULTA OU MOSTRA A DIV DO MAPA
				        document.getElementById('fundo').hidden = false;
				        var windowWidth = window.innerWidth;
				        var windowHeight = window.innerHeight;
				        var screenWidth = screen.width;        
				        var screenHeight = screen.height;
				        
				        if(windowWidth > 1200){
				         
				          document.getElementById("map").style.marginLeft = "28%";
				          document.getElementById("map").style.marginTop = "12%";
				           
				            }else if(windowWidth > 1000){
				          document.getElementById("map").style.marginLeft = "10%";
				             }else if(windowWidth > 500){
				          document.getElementById("map").style.marginLeft = "10%";
				             }else{
				          document.getElementById("map").style.marginLeft = "10%";
				        }
				             // INICIA O INTMAP DE NOVO POR QUE SE NAO FICA PAGINA EM BRANCO
				     }

				    
				    
				    
				    function expand(id_obg, id_btn){
				        if(document.getElementById(id_obg).className == 'form-input colapse'){
				            // document.getElementById(id_obg).style.display = 'none';
				            document.getElementById(id_obg).className = 'form-input expand';
				            document.getElementById(id_btn).text = '(Ocultar)';
				            document.getElementById(id_btn).style.color = "#773333";
				        }else{
				            // document.getElementById(id_obg).style.display = 'block';
				            document.getElementById(id_obg).className = 'form-input colapse';
				            document.getElementById(id_btn).text = '(Expandir)';
				            document.getElementById(id_btn).style.color = "#337733";
				        }
				        
				    }
				    function exibe(id){
				        
				        var url = '../ajax/ajax_buscar_materiais.php?id_produto='+id; 
				            
				         $.get(url, function(dataReturn) {
				              
				              $('#popup').html(dataReturn);  
				         });

				        var windowWidth = window.innerWidth;
				        var windowHeight = window.innerHeight;
				      
				        var screenWidth = screen.width;
				        var screenHeight = screen.height;
				        // alert(windowWidth+" x "+windowHeight)
				        if(windowWidth > 1200){
				          document.getElementById("popup").style.marginLeft = "35%";
				        }else if(windowWidth > 1000){
				          document.getElementById("popup").style.marginLeft = "30%";
				        }else if(windowWidth > 500){
				          document.getElementById("popup").style.marginLeft = "20%";
				        }else{
				          document.getElementById("popup").style.marginLeft = "0%";
				        }
				    }
				    function fechar(){
				        document.getElementById("fundo").hidden = "false";
				        document.getElementById("map").style.marginLeft = "-800px";
				        document.getElementById("popup").style.marginLeft = "-450px";
				    }
				    function increment(nome, whatarray){//chama a pagina que vai incrementar a quantidade no patrimonio
				           var parametros = nome.split(":");
				                
				           var quantidade = document.getElementById(nome).value;

				           if(quantidade > 0){
				               if(whatarray == 'patrimonio'){
				                    
				                    var url = '../ajax/ajax_incrementa_quantidade.php?id='+parametros[1]+'&qtd='+quantidade+'&tipo='+parametros[2]+'&whatarray='+whatarray; 
				                    
				                    $.get(url, function(dataReturn) {
				                      
				                    });
				                }else if(whatarray == 'produto'){
				                    
				                    var url = '../ajax/ajax_incrementa_quantidade.php?id='+parametros[0]+'&qtd='+quantidade+'&whatarray='+whatarray; 
				                    
				                    $.get(url, function(dataReturn) {
				                      
				                    });
				                }
				          }else{
				             alert("Insira um valor maior que 0")
				          }
				    }
				  	function buscarClientes(){

				            var nome = document.getElementById("nome").value;
				            var url = '../ajax/ajax_buscar_clientes.php?nome='+nome; 
				            
				            $.get(url, function(dataReturn) {
				            	
				              $('#form-input-select').html(dataReturn);  
				            });
				         
				    }

				    function buscarPatrimonios(){
				      
				        if(document.getElementById("veiculo").checked == true){
				            tipo = 2;
				            document.getElementById("tipo").value = "2";
				        }else if(document.getElementById("maquinario").checked == true){
				            tipo = 1;
				            document.getElementById("tipo").value = "1";
				        }else{
				            tipo = 0;
				            document.getElementById("tipo").value = "0";
				        }
				        var nome = document.getElementById("nome").value;
				        var url = '../ajax/ajax_buscar_patrimonios.php?nome='+nome+'&tipo='+tipo;  

				         $.get(url, function(dataReturn) {
				            $('#form-input-select').html(dataReturn);
				          });
				    }
				    function selecionaCliente(retorno){
				          var id = retorno;
				        
				          var url = '../ajax/ajax_buscar_dados_cliente.php?id='+id;  
				          
				          $.get(url, function(dataReturn) {
				            
				            $('#form-input-dados').html(dataReturn); 
				          });
				    }
				    function selecionaPatrimonio(id){
				          var tipo = document.getElementById("tipo").value;
				          
				          var url = '../ajax/ajax_montar_patrimonio.php?id='+id+'&tipo='+tipo;  

				          $.get(url, function(dataReturn) {
				            
				            $('#form-input-dados').html(dataReturn); 
				          });
				    }
				    function buscarFuncionario(){
				        var nome = document.getElementById("nome").value;
				        var url = "../ajax/ajax_buscar_funcionarios.php?nome="+nome;

				        $.get(url, function(dataReturn) {
				            
				            $('#form-input-select').html(dataReturn);
				        });
				    }
				    function selecionaFuncionarios(id){
				      
				        var url = '../ajax/ajax_montar_funcionarios.php?id='+id; 
				        
				        $.get(url, function(dataReturn) {
				          
				          $('#form-input-dados').html(dataReturn);  
				        });
				    }
				    function apagar(id, whatarray){

				        var url = '../ajax/ajax_apagar.php?id='+id+'&whatarray='+whatarray; 
				        
				        $.get(url, function(dataReturn) {
				          
				          $('#form-input-dados').html(dataReturn);  
				        });
				    }
				    function buscarProdutos(){
				        var nome = document.getElementById("nome").value;
				        
				        var url = '../ajax/ajax_buscar_materiais.php?nome='+nome+'&tipo=p';  
				        $.get(url, function(dataReturn) {
				            $('#form-input-select').html(dataReturn);
				        });
				    }
				    function selecionaProduto(id){
				            
				          var url = '../ajax/ajax_montar_material.php?id='+id+'&whatarray=obra';
				          
				          $.get(url, function(dataReturn) {
				            
				            $('#form-input-dados').html(dataReturn); 
				          });
				    }
				    function cancel(){
				      opc = confirm("Tem certeza que deseja cancelar?");
				      if(opc)
				        window.location.href='add_obra.php?t=c';
				    }

				    var map;
				    function initMap() {
				      
				      var zoom = 4; // zoom original para aparecer o mapa longe 
				      var originalMapCenter = new google.maps.LatLng(-14.2392976, -53.1805017) // PONTO iNICIAL COM A LAT E LONG DO BRASIL
				      var lat = document.getElementById('lat').value;  //RECEBE O VALOR DA LAT PELO INPUT
				      var long = document.getElementById('long').value;// RECEBE O VALOR DA LONG PELO INPUT      
				      
				      if(lat !== "" && long !==""){
				        var originalMapCenter = new google.maps.LatLng(lat, long);
				        zoom = 16;
				      }
				      var map = new google.maps.Map(document.getElementById('map'),{
				        mapTypeId: google.maps.MapTypeId.SATELLITE,/*ROADMAP*/
				        scrollwheel: false,
				        zoom: zoom,
				        center: originalMapCenter
				      });
				      

				      var infowindow = new google.maps.InfoWindow({
				        content: 'Aqui é sua Obra',
				        position: originalMapCenter
				      });
				      infowindow.open(map);

				      map.addListener('zoom_changed', function() {
				        infowindow.setContent('Zoom: ' + map.getZoom());
				      });
				     
				    }
				    function buscar_cidades(estado){    

				      if(estado){
				        var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;
				        $.get(url, function(dataReturn) {
				          $('#load_cidades').html(dataReturn);
				        });
				      }
				    }
				    function mudaTipo(t){
				        document.getElementById("tipo").value = t;
				    }
				</script>
		<?php
		}//fim getScriptObra()

		//Modelo
		function getScriptPatrimonio(){
		?>
			<script type="text/javascript">
  
				  function carregaTipo_custo(tc){
				           
				      var combo = document.getElementById("tipo_custo");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == tc)
				        {
				          combo.options[i].selected = true;
				          
				          break;
				        }
				      }
				    }    
				  function confirma2(id, nome, tipopess){
				   
				       if(confirm("Excluir Veículo "+nome+" , tem certeza?") ){
				          var url = '../ajax/ajax_excluir_veiculo.php?id='+id+'&nome='+nome+'&tipopess='+tipopess;  //caminho do arquivo php que irá buscar as cidades no BD
				          
				          $.get(url, function(dataReturn) {
				            
				            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
				          });
				       }
				       }

				    function confirma0(id, nome, tipopess){  
				    if(confirm("Excluir Patrimonio "+nome+" , tem certeza?") ){
				       var url = '../ajax/ajax_excluir_patrimonio_geral.php?id='+id+'&nome='+nome+'&tipopess='+tipopess;  //caminho do arquivo php que irá buscar as cidades no BD
				       
				       $.get(url, function(dataReturn) {
				         
				         $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
				       });
				    }
				    }
				    function confirma1(id, nome, tipopess){  
				    if(confirm("Excluir Maquinario "+nome+" , tem certeza?") ){
				       var url = '../ajax/ajax_excluir_maquinario.php?id='+id+'&nome='+nome+'&tipopess='+tipopess;  //caminho do arquivo php que irá buscar as cidades no BD
				       
				       $.get(url, function(dataReturn) {
				         
				         $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
				       });
				    }
				    }

				   function mascara(o,f){
				          v_obj=o
				          v_fun=f
				          setTimeout("execmascara()",1)
				      }
				      function execmascara(){
				          v_obj.value=v_fun(v_obj.value)
				      }

				   
				    function mvalor(v){
				            v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
				            v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
				            v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares
				            v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
				            return v;
				    }

				    function mplaca(v){
				      
				       if(v.length >=8){                                          // alert("mtel")
				         v = v.substring(0,(v.length - 1));
				         
				         return v;
				       }
				       v=v.replace('-',"");             //Remove tudo o que não é dígito
				       v=v.replace(/(\D{3})(\d{4})$/,"$1-$2");    //Coloca hífen entre o quarto e o quinto dígitos
				       
				       
				       return v;
				      
				    }
				    
				   function id( el ){
				     // alert("id")
				     return document.getElementById( el );
				   }
				   window.onload = function(){
				   
				      id('placa').onkeypress = function(){
				        mascara(this, mplaca);
				      }
				    }

				      function validate(f){
				        var erros = 0;
				        var msg = "";
				          for (var i = 0; i < f.length; i++) {
				              if(f[i].name == "matricula"){
				                  if(f[i].value == ""){
				                     msg += "Insira codigo no campo matricula!\n";
				                     f[i].style.border = "1px solid #FF0000";
				                     erros++;
				                  }else{
				                      f[i].style.border = "1px solid #898989";
				                  }
				              }
				              if(f[i].name == "chassi_nserie" && f[i].value == ""){
				                msg += "Insira um código no campo chassi Nº Serie!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "modelo"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo modelo!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }
				              if(f[i].name == "fabricante"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo fabricante!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }
				              
				              if(f[i].name == "data_compra"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo Data de Compra!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }
				              if(f[i].name == "responsavel"){
				                if(f[i].value == "no_sel"){
				                  msg += "Selecione uma Forncedor!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989";
				                }
				              }
				               if(f[i].name == "fornecedor"){
				                if(f[i].value == "no_sel"){
				                  msg += "Selecione uma Forncedor!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989";
				                }
				              }
				              if(f[i].name == "hr_inicial"){
				                if(f[i].value ==""){
				                  msg += "Preencha o campo Horimetro!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }
				               if(f[i].name == "valor_custo" && f[i].value == ""){
				                msg += "Insira o valor de custo do funcionario!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "valor_custo" && f[i].value != ""){
				                f[i].style.border = "1px solid #898989";
				              }
				              
				              if(f[i].name == "tipo_custo" && f[i].value == "no_sel"){
				                msg += "Insira tip de custo!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "tipo_custo" && f[i].value != "no_sel"){
				                f[i].style.border = "1px solid #898989";
				              }
				            
				              if(f[i].name == "nome"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo de Nome!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }
				              if(f[i].name == "descricao"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo de descricao!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }

				              if(f[i].name == "marca"){
				                if(f[i].value == ""){
				                  msg += "Preencha o campo Marca!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989"; 
				                }
				              }

				              if(f[i].name == "placa" && f[i].value == ""){
				                msg += "Preencha o campo de Placa!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				           

				              if(f[i].name == "renavam" && f[i].value == ""){
				                msg += "Preencha o campo renavam\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				             

				              if(f[i].name == "chassi" && f[i].value == ""){
				                msg += "Preencha o campo de Chassi!\n";
				                f[i].style.border = "1px solid #FF0000";
				                erros++;
				              }
				              if(f[i].name == "empresa"){
				                if(f[i].value == "no_sel"){
				                  msg += "Selecione uma empresa!\n";
				                  f[i].style.border = "1px solid #FF0000";
				                  erros++;
				                }else{
				                  f[i].style.border = "1px solid #898989";
				                }
				              }
				              

				         }
				          if(erros>0){            
				              alert(msg);
				            return false;
				          }
				      }

				   function tipo_form(){
				    if(document.getElementById("seguro").checked == true){
				        document.getElementById("seguro").value = 1;
				        document.getElementById("data_ini_seg").disabled = false;
				        document.getElementById("data_fim_seg").disabled = false;
				     }else{
				         document.getElementById("seguro").value = 0;
				         document.getElementById("data_ini_seg").disabled = true;
				         document.getElementById("data_fim_seg").disabled = true;
				     }
				   }

					 function carregaEmpresa(empresa){
				      
				      var combo = document.getElementById("empresa");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == empresa)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				   function carregaCor(cor){
				      
				      var combo = document.getElementById("cor");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == cor)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				    function carregaAno(ano){
				      
				      var combo = document.getElementById("ano");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == ano)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				    function carregaMarca(marca){
				      
				      var combo = document.getElementById("marca");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == marca)
				        {
				          combo.options[i].selected = true;
				          break;
				        }
				      }
				    }
				      function carregaFornecedor(fornecedor){
				           
				      var combo = document.getElementById("fornecedor");
				     
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == fornecedor)
				        {
				          combo.options[i].selected = true;
				          
				          break;
				        }
				      }
				    }

				    function buscar_responsavel(){         
				          var empresa = document.getElementById("empresa").value;  //codigo do estado escolhido

				          //se encontrou o estado
				          if(empresa){

				            var url = '../ajax/ajax_buscar_responsavel.php?empresa='+empresa;  //caminho do arquivo php que irá buscar as cidades no BD

				            $.get(url, function(dataReturn) {
				              $('#load_responsavel').html(dataReturn);  //coloco na div o retorno da requisicao
				            });
				          }
				        }
	 	</script>
		<?php
		}//fim getScriptPatrimonio()

		//Modelo
		function getScriptProduto(){
		?>
			<script type="text/javascript">
				    function info(id){
				      
				      var divPop = document.getElementById(id);
				      divPop.style.display = "";
				    }
				    function fecharInfo(id){
				      var divPop = document.getElementById(id);
				      divPop.style.display = "none";
				    }
				    function increment(nome, acao){//chama a pagina que vai incrementar a quantidade no patrimonio
				            // alert("chamou: "+acao)
				            var parametros = nome.split(":");
				            
				            var quantidade = document.getElementById(nome).value;
				            
				            var url = '../ajax/ajax_incrementa_quantidade_material.php?id='+parametros[0]+'&qtd='+quantidade+'&tipo='+parametros[2]+'&acao='+acao; 
				            
				            $.get(url, function(dataReturn) {
				                $('#apagar').html(dataReturn);  
				            });
				    }
				    
				    function buscarMateriais(acao){
				      
				        var nome = document.getElementById("nome_pesquisa").value;
				        if(document.getElementById("m").checked == true){
				            var url = '../ajax/ajax_buscar_materiais.php?nome='+nome+'&tipo=m&acao='+acao;  
				            $.get(url, function(dataReturn) {
				                $('#form-input-select').html(dataReturn);
				            });
				        }else if(document.getElementById("p").checked == true){
				            var url = '../ajax/ajax_buscar_materiais.php?nome='+nome+'&tipo=p&acao='+acao;  
				            $.get(url, function(dataReturn) {
				                $('#form-input-select').html(dataReturn);
				            });
				        }
				        
				        
				    }

				    function selecionaProduto(id, whatarray){
				            
				          var url = '../ajax/ajax_montar_material.php?id='+id+'&whatarray='+whatarray;  
				          
				          $.get(url, function(dataReturn) {
				            
				            $('#form-input-dados').html(dataReturn); 
				          });
				    }

				    function apagar(id, whatarray, acao){
				        
				        var url = '../ajax/ajax_apagar.php?id='+id+'&whatarray='+whatarray+'&acao='+acao; 
				        
				        $.get(url, function(dataReturn) {
				          
				          $('#form-input-dados').html(dataReturn);  
				        });
				    }
				    function cancel(){
				      opc = confirm("Tem certeza que deseja cancelar?");
				      if(opc)
				        window.location.href='add_produto.php?t=c';

				    }
				</script>
		<?php
		}//fim getScriptProduto()

		//Modelo
		function getScriptTurno(){
		?>
			<script type="text/javascript">
				     function validate(f){
				      var erros=0;
				      for(i=0; i < f.length; i++){
				         if(f[i].name == "nome"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "ini_exp_h"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "ini_exp_m"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "ini_alm_h"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "ini_alm_m"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "fim_alm_m"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "fim_alm_h"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "fim_exp_h"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				        if(f[i].name == "fim_exp_m"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				        }
				      }
				      if(erros>0){
				         return false;
				      }else{
				         return true;
				      }
				   }

				   //mascaras
				      function mascara(o,f){
				          v_obj=o
				          v_fun=f
				          setTimeout("execmascara()",1)
				      }
				      function execmascara(){
				          v_obj.value=v_fun(v_obj.value)
				      }
				       function id( el ){
				         // alert("id")
				         return document.getElementById( el );
				       }
				      function mnum(v){
				           if(v.length >=19){
				              v = v.substring(0,(v.length - 1));
				              return v;
				           }
				           v=v.replace(/\D/g,"");
				           return v;
				       }
				       
				      window.onload = function(){
				         id('ini_exp_h').onkeypress = function(){
				             mascara( this, mnum );
				         }
				         id('ini_exp_m').onkeypress = function(){
				             mascara( this, mnum );
				         }
				         id('ini_alm_h').onkeypress = function(){
				             mascara( this, mnum );
				         }
				         id('ini_alm_m').onkeypress = function(){
				             mascara( this, mnum );
				         }
				         id('fim_alm_h').onkeypress = function(){
				             mascara( this, mnum );
				         }
				         id('fim_alm_m').onkeypress = function(){
				             mascara( this, mnum );
				         }
				         id('fim_exp_h').onkeypress = function(){
				             mascara( this, mnum );
				         }
				         id('fim_exp_m').onkeypress = function(){
				             mascara( this, mnum );
				         }
				      }
				   //fim mascaras
                                        $(document).ready(function(){
                                          $("#mostracbo").click(function(){
                                              $("#divcbo").fadeToggle();       
                                          });  
                                            $("#mostraturno").click(function(){
                                              $("#divturno").fadeToggle();       
                                          });  

                                          $("#sem_hor_almoco").click(function(){
                                              $("#almoco").fadeToggle();
                                              $("#ini_alm_h").val("");
                                              $("#ini_alm_m").val("");
                                              $("#fim_alm_h").val("");
                                              $("#fim_alm_m").val("");
                                              $("#almoco2").fadeToggle();
                                          });  

                                      });
 
				</script>
		<?php
		}//fim getScriptTurno()

		//Modelo
		function getScriptConfiguracoes(){
		?>
			<script type="text/javascript">
     
				     
				    function confirma(teste){
				        data = teste.split(" ");
				        id = data[0];
				        nome = data[1];
				        pesq = data[2];
				        
				        
				       if(confirm("Excluir unidade "+nome+" , tem certeza?") ){
				          var url = '../ajax/ajax_excluir_unidade_medida.php?id='+id+'&nome='+nome;  //caminho do arquivo php que irá buscar as cidades no BD
				          
				          $.get(url, function(dataReturn) {
				            $('#result').html(dataReturn);  //coloco na div o retorno da requisicao
				            window.location.href='configuracoes.php?nome='+pesq;
				          });
				       }
				    }
				    
				   
				    function busca(){
				        
				       if(document.getElementById('nome_e').value !=0 ){
				           var nome = document.getElementById('nome_e').value;
				         
				       }
				       window.location = 'configuracoes.php?nome='+nome;

				    }
				    function atualizar(unidade){
				        data = unidade.split(" ");
				       
				        alert("A unidade de medida "+ data[1] +" será alterada");
				               
				    }
				    function valida(f){ 
				      var erros=0;   
				      for(i=0; i<f.length; i++){
				        
				         if(f[i].name == "temp_limit_atraso"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				         }
				         if(f[i].name == "nome"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				         }
				         if(f[i].name == "sigla"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				         }
				         if(f[i].name == "grandeza"){
				            if(f[i].value == ""){
				               f[i].style.border = "1px solid #f00";
				               erros++;
				            }else{
				              f[i].style.border = "1px solid #898989";
				            }
				         }
				      }
				      if(erros>0){
				         return false;
				      }else{
				         return true;
				      }

				   }
				     
				     function carregaU_M(um){
				          data = um.split(":");
				          var aux = data[0];          
				          var aux2 = data[1];
				         
				          var combo = document.getElementById(aux2+":medida");
				          for (var i = 0; i < combo.options.length; i++)
				          {
				            if (combo.options[i].value == aux)
				            {
				              combo.options[i].selected = true;

				              break;
				            }
				          }
				        }
				        
				      function hideall(x){
				            if(document.getElementById(x).hidden == true){
				                document.getElementById(x).hidden = false;
				            }else{
				                document.getElementById(x).hidden = true;
				                document.getElementById(1).hidden = true;
				                document.getElementById(2).hidden = true;
				                document.getElementById(3).hidden = true;
				                document.getElementById(4).hidden = true;
				                document.getElementById("opcoes-materiais").hidden = true;
				            }
				        }
				     
				     function ocultaTabela(x){
				          if(document.getElementById(x).hidden == true){
				                document.getElementById(x).hidden = false;
				            }else{
				                document.getElementById(x).hidden = true;
				            }
				     }
				     function mostraTabela1(x){
				            
				            if(document.getElementById(2).hidden == false){
				                document.getElementById(2).hidden = true;
				            }
				            
				            
				            if(document.getElementById(x).hidden == true){
				                document.getElementById(x).hidden = false;
				            }else{
				                document.getElementById(x).hidden = true;
				            }
				            
				     }
				   
				     function mostraTabela2(x){
				            if(document.getElementById(1).hidden == false){
				                document.getElementById(1).hidden = true;
				            }
				            
				            if(document.getElementById(x).hidden == true){
				                document.getElementById(x).hidden = false;
				            }else{
				                document.getElementById(x).hidden = true;
				            }
				            
				     }
				     
				     function mascara(o,f){
				              v_obj=o
				              v_fun=f
				              setTimeout("execmascara()",1)
				      }
				      function execmascara(){
				          v_obj.value=v_fun(v_obj.value)
				      }
				       function id( el ){
				         // alert("id")
				         return document.getElementById( el );
				       }
				      function mnum(v){
				           if(v.length >=19){
				              v = v.substring(0,(v.length - 1));
				              return v;
				           }
				           v=v.replace(/\D/g,"");
				           return v;
				       }
				       
				        window.onload = function(){
				          id('temp_limit_atraso').onkeypress = function(){
				              mascara( this, mnum );
				          }
				       }
				       
				    function carregaUf(uf){
				         data = uf.split(" ");
				          var aux = data[0];
				         
				          var aux2 = data[1];
				        
				        
				      var combo = document.getElementById(aux2+"xestado");
				      for (var i = 0; i < combo.options.length; i++)
				      {
				        if (combo.options[i].value == aux)
				        {
				          combo.options[i].selected = true;
				          
				          break;
				        }
				      }
				      buscar_cidades(aux2+"xestado");
				    } 
				    
				    function buscar_cidades(x){ 
				          
				          var estado = document.getElementById(x).value;  //codigo do estado escolhido
				          data = x.split("x");
				          var aux = data[0];
				          var aux2 = data[1];
				         
				          //se encontrou o estado
				          if(estado){
				            var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
				            $.get(url, function(dataReturn) {
				              $('#'+aux+'load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
				            });
				          }
				    }
				       function buscar_cidades(){ 
				          
				          var estado = document.getElementById("estado").value;  //codigo do estado escolhido
				          
				          //se encontrou o estado
				          if(estado){
				            var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;  //caminho do arquivo php que irá buscar as cidades no BD
				            $.get(url, function(dataReturn) {
				              $('#load_cidades').html(dataReturn);  //coloco na div o retorno da requisicao
				            });
				          }
				    }
				    
				    function carregaCidade(){
				                
				                
				                var combo = document.getElementById("cidade");
				                var cidade = document.getElementById("id_cidade").value;
				                
				                for (var i = 0; i < combo.length; i++)
				                {

				                  if (combo.options[i].value == cidade)
				                  {
				                    combo.options[i].selected = true;
				                    break;
				                  }
				                }      
				    }
				   
				   
				 </script>
		<?php
		}//fim getScriptConfiguracoes()

		//Modelo
		function getScriptContas(){
		?>
                                 <script>
                                    function mascara(o,f){
				        v_obj=o
				        v_fun=f
				        setTimeout("execmascara()",1)
				    }
				    function execmascara(){
				        v_obj.value=v_fun(v_obj.value)
				    }
				    function mnum(v){
				              v=v.replace(/\D/g,"");                                      //Remove tudo o que não é dígito
				              return v;
				    }
				    function mvalor(v){
				              v=v.replace(/\D/g,"");//Remove tudo o que não é dígito
				              v=v.replace(/(\d)(\d{8})$/,"$1.$2");//coloca o ponto dos milhões
				              v=v.replace(/(\d)(\d{5})$/,"$1.$2");//coloca o ponto dos milhares

				              v=v.replace(/(\d)(\d{2})$/,"$1,$2");//coloca a virgula antes dos 2 últimos dígitos
				           return v;
				    }

				   function mtel(v){
				       if(v.length >=16){
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
				    function dnasc(v){
				       if(v.length >=10){      
				         v = v.substring(0,(v.length - 1));
				         return v;
				       }
				       v=v.replace(/\D/g,""); 
				       v=v.replace(/^(\d{2})(\d{2})(\d{4})/,"$1/$2/$3");  
				       return v;
				   }
				    function mrg(v){
				       if(v.length >=13){
				         v = v.substring(0,(v.length - 1));
				         return v;
				       }
				       v=v.replace(/^(\d{2})(\d{3})(\d{3})(\d{1})/,"$1.$2.$3-$4");
				       return v;
				   }
				   function id( el ){
				     return document.getElementById( el );
				   }
				   function carregaMascaras(){
				
				      id('cpf').onkeypress = function(){ 
				          mascara( this, mcpf );
				      };      
				      id('telefone').onkeypress = function(){
				          mascara( this, mtel );
				      };
				      id('data_em_rg').onkeypress = function(){
				          mascara( this, dnasc );
				      };
				      id('data_nasc').onkeypress = function(){
				          mascara( this, dnasc );
				      };
				      id('data_admissao').onkeypress = function(){
				          mascara( this, dnasc );
				      };
				      
				   }
                                   
                                   
                                   
                       
                                 </script>
		<?php
		}//fim getScript()

		//Modelo
		function getPaginacao(){
		?>
            <script>
                function paginar(max,limite){   
                
                    var ultimov = 0; // ultima div mostrada na tela
                    var primeirov = 0; // primeira div mostrada na tela
                    if(max <= limite){                       
                        document.getElementById('back').hidden = true;
                        document.getElementById('next').hidden = true;
                    }                   // quantidade de div por paginação
                    if(max > limite){
                  
                    document.getElementById('back').hidden = true;   // inicia com next desativado 
                    var ocultos = new Array(); // array para guardar valores das divs ocultas
                    var visiveis = new Array(); // array para guardar valores das divs visiveis
                    var y = 0;                  // contador das divs ocultas
                        for(var i = 1 ; i < max+1 ; i++){ // condição que varre todas divs e verifica se ultrapassou o numero maximo de valores na tela para ocultar
                            if(i <= limite ){
                             
                            visiveis[i] = i ;
                            
                            }

                            if(i > limite){                                     
                             document.getElementById(i).hidden = true; // ocultando divs fora do valor maximo
                                        ocultos[y] = i; 
                                         y++;
                             }
                            
                         }

                       ultimov  = visiveis[limite]; // recebe qual é A PRIMEIRA  ultima div visivel
                       

                        $(document).ready(function(){
                            $("#next").click(function(){
                              
                                    document.getElementById('back').hidden = false; 
                                    
                                    for(i = 1 ; i < max+1; i++){ // array que varre doas as divs
                                
                                        prox = ultimov + limite;      // prox é o valor até onde deve ser mostradas as divs                               
                                        if(i > ultimov && i <= prox ){                            
                                                document.getElementById(i).hidden = false;                    // mostando as divs                   
                                        }else if(i <= ultimov){
                                                document.getElementById(i).hidden = true;                       // mostrando as divs               
                                        }
                                    }      
                                    
                                    if(document.getElementById(max).hidden === false){                          // condição que verifica se a ultima div esta sendo mostrada na tela para ocultar o botao next
                                                document.getElementById('next').hidden = true;
                                    }
                                    
                                    ultimov = ultimov + limite;                                                    // mantendo na variavel ultimo valor, o ultimo valor mostrado
                            });

                            $("#back").click(function(){

                                    document.getElementById('next').hidden = false;                             // mostrando botao next quando voltar
                                    
                                     for(i = 1 ; i < max+1; i++){

                                        primeirov = ultimov - limite;
                                        ant = primeirov - limite;

                                        if(i <= primeirov && i > ant){    
                                            
                                                document.getElementById(i).hidden = false;                                       
                                        }else{
                                                document.getElementById(i).hidden = true;  
                                        }
                                    }       
                                    
                                    if(document.getElementById(1).hidden === false){
                                            document.getElementById('back').hidden = true;
                                    }
                                     ultimov = primeirov;
                            });

                        });

                    }                     
                }                                                                            
    	</script>
		<?php
		}//fim getScript()

		//Modelo
		function getScriptVisualizarObra(){
		?>
			<script type="text/javascript">
					

				  	function buscarClientes(tipo, valor, acao){
				  			
				            var nome = document.getElementById("nome").value;
				            if(tipo == 1)
				            	nome = valor;
				            
				            var url = '../ajax/ajax_buscar_obras.php?nome='+nome+'&tipo='+tipo+'&acao='+acao; 
				            
				            $.get(url, function(dataReturn) {
				            	
				              $('#form-input-select').html(dataReturn);  
				            });
				         
				    }

				    function buscarPatrimonios(){
				      
				        if(document.getElementById("veiculo").checked == true){
				            tipo = 2;
				            document.getElementById("tipo").value = "2";
				        }else if(document.getElementById("maquinario").checked == true){
				            tipo = 1;
				            document.getElementById("tipo").value = "1";
				        }else{
				            tipo = 0;
				            document.getElementById("tipo").value = "0";
				        }
				        var nome = document.getElementById("nome").value;
				        var url = '../ajax/ajax_buscar_patrimonios.php?nome='+nome+'&tipo='+tipo;  

				         $.get(url, function(dataReturn) {
				            $('#form-input-select').html(dataReturn);
				          });
				    }
				    function selecionaCliente(retorno){
				          var id = retorno;
				        
				          var url = '../ajax/ajax_buscar_dados_cliente.php?id='+id;  
				          
				          $.get(url, function(dataReturn) {
				            
				            $('#form-input-dados').html(dataReturn); 
				          });
				    }
				    function selecionaPatrimonio(id){
				          var tipo = document.getElementById("tipo").value;
				          
				          var url = '../ajax/ajax_montar_patrimonio.php?id='+id+'&tipo='+tipo;  

				          $.get(url, function(dataReturn) {
				            
				            $('#form-input-dados').html(dataReturn); 
				          });
				    }
				    function buscarFuncionario(){
				        var nome = document.getElementById("nome").value;
				        var url = "../ajax/ajax_buscar_funcionarios.php?nome="+nome;

				        $.get(url, function(dataReturn) {
				            
				            $('#form-input-select').html(dataReturn);
				        });
				    }
				    function selecionaFuncionarios(id){
				      
				        var url = '../ajax/ajax_montar_funcionarios.php?id='+id; 
				        
				        $.get(url, function(dataReturn) {
				          
				          $('#form-input-dados').html(dataReturn);  
				        });
				    }
				    function apagar(id, whatarray){

				        var url = '../ajax/ajax_apagar.php?id='+id+'&whatarray='+whatarray; 
				        
				        $.get(url, function(dataReturn) {
				          
				          $('#form-input-dados').html(dataReturn);  
				        });
				    }
				    function buscarProdutos(){
				        var nome = document.getElementById("nome").value;
				        
				        var url = '../ajax/ajax_buscar_materiais.php?nome='+nome+'&tipo=p';  
				        $.get(url, function(dataReturn) {
				            $('#form-input-select').html(dataReturn);
				        });
				    }
				    function selecionaProduto(id){
				            
				          var url = '../ajax/ajax_montar_material.php?id='+id+'&whatarray=obra';
				          
				          $.get(url, function(dataReturn) {
				            
				            $('#form-input-dados').html(dataReturn); 
				          });
				    }
				    function cancel(){
				      opc = confirm("Tem certeza que deseja cancelar?");
				      if(opc)
				        window.location.href='add_obra.php?t=c';
				    }

				    var map;
				    function initMap() {
				      
				      var zoom = 4; // zoom original para aparecer o mapa longe 
				      var originalMapCenter = new google.maps.LatLng(-14.2392976, -53.1805017) // PONTO iNICIAL COM A LAT E LONG DO BRASIL
				      var lat = document.getElementById('lat').value;  //RECEBE O VALOR DA LAT PELO INPUT
				      var long = document.getElementById('long').value;// RECEBE O VALOR DA LONG PELO INPUT      
				      
				      if(lat !== "" && long !==""){
				        var originalMapCenter = new google.maps.LatLng(lat, long);
				        zoom = 16;
				      }
				      var map = new google.maps.Map(document.getElementById('map'),{
				        mapTypeId: google.maps.MapTypeId.SATELLITE,/*ROADMAP*/
				        scrollwheel: false,
				        zoom: zoom,
				        center: originalMapCenter
				      });
				      

				      var infowindow = new google.maps.InfoWindow({
				        content: 'Aqui é sua Obra',
				        position: originalMapCenter
				      });
				      infowindow.open(map);

				      map.addListener('zoom_changed', function() {
				        infowindow.setContent('Zoom: ' + map.getZoom());
				      });
				     
				    }
				    function buscar_cidades(estado){    

				      if(estado){
				        var url = '../ajax/ajax_buscar_cidades.php?estado='+estado;
				        $.get(url, function(dataReturn) {
				          $('#load_cidades').html(dataReturn);
				        });
				      }
				    }
				    function mudaTipo(t){
				        document.getElementById("tipo").value = t;
				    }
				</script>
		<?php
		}//fim getScript()

		//Modelo
		function getScriptModelo8(){
		?>
			<!-- Code -->
		<?php
		}//fim getScript()


}
?>