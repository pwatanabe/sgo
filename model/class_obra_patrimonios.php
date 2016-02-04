<?php 
include_once("class_patrimonio_geral_bd.php");
include_once("class_veiculo_bd.php");
include_once("class_maquinario_bd.php");

include_once("class_obra_patrimoniogerais.php");
include_once("class_obra_maquinarios.php");
include_once("class_obra_veiculos.php");


class Obra_patrimonios{

	public function add_patrimonio_bd($id_obra){
		$listPatrimonioGeral = array();
		$listVeiculos = array();
		$listMaquinarios = array();
		$lista = array();
		if(isset($_SESSION['obra']['patrimonio']))
			for($aux = 0; $aux < count($_SESSION['obra']['patrimonio']); $aux++){
				$tipo_id_qtd = explode(':', $_SESSION['obra']['patrimonio'][$aux]);
				if($tipo_id_qtd[0] == 0){
					// $listPatrimonioGeral[] = Obra_patrimoniogerais::add_patrimoniogeral($id_obra, $tipo_id_qtd[1]);
	               	$patrimonioGeral = Obra_patrimoniogerais::add_patrimoniogeral($id_obra, $tipo_id_qtd[1], $tipo_id_qtd[2]);
	               	echo '<br />patrimonioGeral: '.$patrimonioGeral->add_patrimoniogeral_bd();
	               //patrimonio geral
	            }else if($tipo_id_qtd[0] == 1){
					// $listMaquinarios[] = Obra_maquinarios::add_maquinarios($id_obra, $tipo_id_qtd[1]);
					$maquinario = Obra_maquinarios::add_maquinarios($id_obra, $tipo_id_qtd[1]);
					echo '<br />maquinario: '.$maquinario->add_maquinario_bd();
	            }else{
	            	// $listVeiculos[] = Obra_veiculos::add_veiculo($id_obra, $tipo_id_qtd[1]);
	            	$veiculo = Obra_veiculos::add_veiculo($id_obra, $tipo_id_qtd[1]);
	            	echo '<br />veiculo: '.$veiculo->add_veiculo_bd();
	               //Veiculo
	            }

			}

		(count($listPatrimonioGeral) > 0) ? $lista[] = $listPatrimonioGeral : null;
		(count($listMaquinarios) > 0) ? $lista[] = $listMaquinarios : null;
		(count($listVeiculos) > 0) ? $lista[] = $listVeiculos : null;
		
		return $lista;
	}

	public function get_patrimonios($id_obra){
		
		$maquinarios = Obra_maquinarios::get_maquinarios_obra($id_obra);
		$patrimonioGeral = Obra_patrimoniogerais::get_patrimoniosGerais($id_obra);
		$veiculos = Obra_veiculos::get_veiculos($id_obra);
		$return = array();
		$return = array_merge($maquinarios, $patrimonioGeral, $veiculos);

		return $return;

	}
	public function imprimePatrimonios($tipo_id_qtd){
		
           if($tipo_id_qtd[0] == 0){
              $res = Patrimonio_geral::get_patrimonio_geral_id($tipo_id_qtd[1]);
              echo '<td title="Descrição: '.$res->descricao.'"><span>'.$res->nome.': </span></td><td><input  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'" onchange="increment(this.id, \'patrimonio\')" style="width:30%; background-color: rgba(230,230,230,0.5)" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
           }else if($tipo_id_qtd[0] == 1){
              $res = Maquinario::get_maquinario_id($tipo_id_qtd[1]);
              echo '<td ><span>'.$res->modelo.': </span></td><td><input readonly  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'"  onchange="increment(this.id, \'patrimonio\')" style="width:30%" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].':'.$res->id_responsavel.'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
           }else{
              $res = Veiculo::get_veiculo_id($tipo_id_qtd[1]);
              echo '<td title="Matricula: '.$res->matricula.' | Placa: '.$res->placa.'"><span>'.$res->modelo.': </span></td><td><input readonly  id="qtd:'.$res->id.':'.$tipo_id_qtd[0].'"  onchange="increment(this.id, \'patrimonio\')" style="width:30%" type="number" value="'.$tipo_id_qtd[2].'"></td><td><a style="cursor:pointer" name="'.$tipo_id_qtd[0].':'.$res->id.':'.$tipo_id_qtd[2].':'.$res->id_responsavel.'" id="'.$res->id.'" onclick="apagar(this.name,\'patrimonio\')"><img style="width:15px" src="../images/delete.png"></a></td>';
           }
                
	}
	
}

 ?>