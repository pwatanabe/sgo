<?php
session_start();
include_once("../model/class_sql.php");
include_once("../model/class_material_bd.php");
include_once("../model/class_unidade_medida_bd.php");
include_once("../model/class_produto_bd.php");

	
	$id = $_GET['id'];  //codigo do material passado por parametro
	$param_id = explode(":", $id);
	$whatarray = isset($_GET['whatarray']) ? $_GET['whatarray'] : null;

	//se cadastro de produto na obra
	if(isset($_GET['whatarray']) && $_GET['whatarray'] == 'obra' ){
					$total = 0;
				
					$id = $param_id[1];
					if(!isset($_SESSION['obra']['produto'])){// se ainda não possui dados, adiciona a concatenação de id + qtd no indice 0
						$_SESSION['obra']['produto'][0] = $id.':1';

					}else{// se ja tem algo cadastrado adiciona no final do array
						$total = count( $_SESSION['obra']['produto'] );
						$_SESSION['obra']['produto'][$total] = $id.':1';
					}

				echo '<table style="width:95%">';
				//percorre o array de produto
			  	for($aux = 0; $aux < count($_SESSION['obra']['produto']); $aux++){
			  		$id_qtd = explode(':', $_SESSION['obra']['produto'][$aux]);

			  		if($aux%2==0)// para tabela ficar zebrada
			               echo '<tr style="background-color:#ccc;">';
			        else
			               echo '<tr style="background-color:#ddd;">';
			          	
			  		$res = new Produto();
				  	$res = $res->get_produto_id($id_qtd[0]);
				  	echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd[1].'" onchange="increment(this.id,\'produto\')" style="background-color: rgba(230,230,230,0.5); width:70px" type="number" value="'.$id_qtd[1].'"></td><td><a name="'.$res->id.'" title="Clique aqui para ver os materiais desse produto" onclick="exibe(this.name)" style="cursor:pointer"><span>Ver materiais</span></a></td><td><a name="'.$res->id.':'.$id_qtd[1].'" style="cursor:pointer"  onclick="apagar(this.name,\'produto\')"><img style="width:15px" src="../images/delete.png"></a></td>';
			  			
			  		echo '</tr>';
			  	}
			  	echo '</table>';
	}else if(isset($_GET['whatarray']) && $_GET['whatarray'] == 'addproduto'){
				
				$total = 0;
				if($param_id[0] == 'm'){// se for material
					$id = $param_id[1];
					if(!isset($_SESSION['produto']['material'])){
						$_SESSION['produto']['material'][0] = $id.':1'.':m';

					}else{
						$total = count( $_SESSION['produto']['material'] );
						$_SESSION['produto']['material'][$total] = $id.':1'.':m';
						
					}
				}else{// se for produto
					$id = $param_id[1];
					if(!isset($_SESSION['produto']['material'])){
						
						$_SESSION['produto']['material'][0] = $id.':1'.':p';
						
					}else{
						$total = count( $_SESSION['produto']['material'] );
						$_SESSION['produto']['material'][$total] = $id.':1'.':p';
						
					}
				}

				echo '<table style="width:95%">';
			  	for($aux = 0; $aux < count($_SESSION['produto']['material']); $aux++){
			  		
			  		$id_qtd_tipo = explode(':', $_SESSION['produto']['material'][$aux]);
			  	    

			  		if($aux%2==0)// para tabela ficar zebrada
			               echo '<tr style="background-color:#ccc;">';
			        else
			              echo '<tr style="background-color:#ddd;">';
			          	if($id_qtd_tipo[2] == 'm'){// se for material
				  		     $res = new Material();
				  			 $res = Material::get_material_id($id_qtd_tipo[0]);
				         	 $uni = new Unidade_medida();
							 $uni = $uni->get_unidade_medida_by_id($res->id_unidade_medida);
				  			 echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id)" style="width:70%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"> <span>'.$uni->sigla.'</span></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\',\'cadastrar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
			  			}else if($id_qtd_tipo[2] == 'p'){// se for produto
			  				 $res = new Produto();
				  			 $res = $res->get_produto_id($id_qtd_tipo[0]);
				  			 echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id)" style="width:70%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\',\'cadastrar\')"><img style="width:15px" src="../images/delete.png"></a></td>';
			  			}
			  		echo '</tr>';
			  		// if(count($patrimonio)>1)
			  		// 	for($aux = 0; $aux < count($patrimonio); $aux++ ){
			  		// 			echo 'id '. $patrimonio[$aux][1].'<br />';
			  		// 	}
			  		// else
			  		// 	echo 'id '. $patrimonio[0][1].'<br />';
			  	}
			  	echo '</table>';
			      // echo 'ID: '.$id.' TIPO: '.$tipo.'<br />';
  		
	  }else if(isset($_GET['whatarray']) && $_GET['whatarray'] == 'editaproduto'){
	  		
	  		$total = 0;
				if($param_id[0] == 'm'){// se for material
					$id = $param_id[1];
					if(!isset($_SESSION['produto']['editar']['material'])){
						$_SESSION['produto']['editar']['material'][0] = $id.':1'.':m';

					}else{
						$total = count( $_SESSION['produto']['editar']['material'] );
						$_SESSION['produto']['editar']['material'][$total] = $id.':1'.':m';
						
					}
				}else{// se for produto
					$id = $param_id[1];
					if(!isset($_SESSION['produto']['editar']['material'])){
						
						$_SESSION['produto']['editar']['material'][0] = $id.':1'.':p';
						
					}else{
						$total = count( $_SESSION['produto']['editar']['material'] );
						$_SESSION['produto']['editar']['material'][$total] = $id.':1'.':p';
						
					}
				}

				echo '<table style="width:100%">';
			  	for($aux = 0; $aux < count($_SESSION['produto']['editar']['material']); $aux++){
			  		
			  		$id_qtd_tipo = explode(':', $_SESSION['produto']['editar']['material'][$aux]);
			  	    

			  		if($aux%2==0)// para tabela ficar zebrada
			               echo '<tr style="background-color:#ccc;">';
			        else
			              echo '<tr style="background-color:#ddd;">';
			          	if($id_qtd_tipo[2] == 'm'){// se for material
				  		     $res = new Material();
				  			 $res = Material::get_material_id($id_qtd_tipo[0]);
				         	 $uni = new Unidade_medida();
							 $uni = $uni->get_unidade_medida_by_id($res->id_unidade_medida);
				  			 echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id,\'editar\')" style="width:30%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"> <span>'.$uni->sigla.'</span></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\')"><img style="width:15px" src="../images/delete.png"></a></td>';
			  			}else if($id_qtd_tipo[2] == 'p'){// se for produto
			  				 $res = new Produto();
				  			 $res = $res->get_produto_id($id_qtd_tipo[0]);
				  			 echo '<td ><span>'.$res->nome.': </span></td><td><input  id="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" onchange="increment(this.id,\'editar\')" style="width:30%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$id_qtd_tipo[1].'"></td><td><a name="'.$res->id.':'.$id_qtd_tipo[1].':'.$id_qtd_tipo[2].'" style="cursor:pointer"  onclick="apagar(this.name,\'material\')"><img style="width:15px" src="../images/delete.png"></a></td>';
			  			}
			  		echo '</tr>';
			  		// if(count($patrimonio)>1)
			  		// 	for($aux = 0; $aux < count($patrimonio); $aux++ ){
			  		// 			echo 'id '. $patrimonio[$aux][1].'<br />';
			  		// 	}
			  		// else
			  		// 	echo 'id '. $patrimonio[0][1].'<br />';
			  	}
			  	echo '</table>';
			      // echo 'ID: '.$id.' TIPO: '.$tipo.'<br />';
	  }	
	
?>



