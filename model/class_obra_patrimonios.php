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
	
}

 ?>