<?php

include_once("class_sql.php");
include_once("class_funcionario_bd.php");
require_once(dirname(__FILE__) . "/../global.php");

class Horarios{
	public $id;
	public $hora;
    public $data;
	public $tipo;
	public $id_funcionario;
	public $observacao_funcionario;
	public $id_obs_supervisor;
	public $situacao;
	public $tipo_1;
	public $tipo_2;
	public $tipo_3;
	public $tipo_0;

	//retorna a diferenca entr um intervalo de horas
	public function dif_horario($horario1, $horario2) {
	    $horario1 = strtotime("1/1/1980 $horario1");
	    $horario2 = strtotime("1/1/1980 $horario2");
	         
		if ($horario2 < $horario1) {
		   $horario2 = $horario2 + 86400;
		}
	  
		$hora = ($horario2 - $horario1) / 3600;

		$hora_minutos = explode('.', $hora);
		
		$return = '';
		// if(isset($hora_minutos[0])){
			$return .= isset($hora_minutos[0])?$hora_minutos[0]:'0';
			$return .= 'h';
		// }
		// if(isset($hora_minutos[1])){
			$minuto = '0.';
			$minuto .= isset($hora_minutos[1]) ? $hora_minutos[1] : '0';
			$minuto_final = $minuto * 60;
			$return .= (round($minuto_final)).'m'	;
		// }

		return $return;
	}

	public function cadHorario($hora, $data, $tipo, $id_funcionario, $observacao_funcionario, $situacao){
		// $this->id = $id;
		$this->situacao = $situacao;
	    $this->data = $data;
		$this->hora = $hora;
		$this->tipo = $tipo;
		$this->id_funcionario = $id_funcionario;
		$this->observacao_funcionario = $observacao_funcionario;

	}

	public function cadHorariosEsquecidos($data, $id_funcionario){
		
	    $this->data = $data;
		$this->id_funcionario = $id_funcionario;

	}

	public function insertHorarioBd(){//insere um horario no banco
		$sql = new Sql();
		$sql->conn_bd();
		
		//atualiza a tabela horarios registrados
		if($this->tipo == 1){
			mysql_query("update horarios_registrados set  data = '".$this->data."' , id_funcionario = '".$this->id_funcionario."', tipo_1 = true where id_funcionario = '".$this->id_funcionario."' && data = '".$this->data."'") or print(mysql_error());
		}else  if($this->tipo == 2){
			mysql_query("update horarios_registrados set  data = '".$this->data."' , id_funcionario = '".$this->id_funcionario."', tipo_2 = true where id_funcionario = '".$this->id_funcionario."' && data = '".$this->data."'") or print(mysql_error());
		}else  if($this->tipo == 3){
			mysql_query("update horarios_registrados set  data = '".$this->data."' , id_funcionario = '".$this->id_funcionario."', tipo_3 = true where id_funcionario = '".$this->id_funcionario."' && data = '".$this->data."'") or print(mysql_error());
		}else{
			mysql_query("update horarios_registrados set  data = '".$this->data."' , id_funcionario = '".$this->id_funcionario."', tipo_0 = true where id_funcionario = '".$this->id_funcionario."' && data = '".$this->data."'") or print(mysql_error());
		}

		//insere o registro na tabela horario
		mysql_query("INSERT INTO horarios (hora, data, tipo, situacao, id_funcionario, observacao_funcionario) 
			VALUES ('".$this->hora."',
					'".$this->data."',
				    '".$this->tipo."',
				    '".$this->situacao."',
				    '".$this->id_funcionario."',
				    '".$this->observacao_funcionario."')") or print(mysql_error());
	}
	//adiciona os horarios esquecidos
	public function add_horario_bd(){
		$sql = new Sql();
		$sql->conn_bd();

		$sucesso = mysql_query("INSERT INTO horarios (hora, data, tipo, situacao, id_funcionario, id_obs_supervisor, observacao_funcionario) 
					VALUES ('".$this->hora."',
							'".$this->data."',
						    '".$this->tipo."',
						    '".$this->situacao."',
						    '".$this->id_funcionario."',
						    '".$this->id_obs_supervisor."',
						    '".$this->observacao_funcionario."')") or print(mysql_error());
		return $sucesso;
	}
	public function insertHorariosEsquecidosBd(){//insere um horario no banco
		$sql = new Sql();
		$sql->conn_bd();
		
		mysql_query("INSERT INTO horarios_registrados (data, id_funcionario, tipo_1, tipo_2, tipo_3, tipo_0) 
					VALUES ('".$this->data."',
						    '".$this->id_funcionario."',
						    '0','0','0','0')") or (print mysql_error());
		
	}
	public function corrige_horario($data, $tipo, $hora, $id_funcionario, $observacao_supervisor, $situacao){
		$sql = new Sql();
		$sql->conn_bd();

		$query = 'UPDATE horarios_registrados SET ';

		if($tipo == 1){
			$query .= 'tipo_1';
		}else if($tipo == 2){
			$query .= 'tipo_2';
		}else if($tipo == 3){
			$query .= 'tipo_3';
		}else{
			$query .= 'tipo_0';
		}

		$query .= ' = 1 WHERE id_funcionario = "'.$id_funcionario.'" && data = "'.$data.'"';

		mysql_query($query);

		$this->cadHorario($hora, $data, $tipo, $id_funcionario, '', $situacao);
		$this->id_obs_supervisor = $observacao_supervisor;
		$sucesso = $this->add_horario_bd();

		if($sucesso){
			return true;
		}else{
			return false;
		}

	}


	public function not_exists($data, $id_funcionario){
		
		$query = "SELECT id FROM horarios_registrados WHERE id_funcionario = '".$id_funcionario."' && data = '".$data."'";
		$result = mysql_query($query);
		
		$num_row = mysql_num_rows($result);

		if($num_row == 0){
			return true;
		}else{
			return false;
		}
	}

	public function getTipoUltimoHorarioFunc($id_func, $data){//retorna o ultimo tipo cadastrado
		$sql = new Sql();
		$sql->conn_bd();
		$query = "SELECT * FROM horarios WHERE id_funcionario = ".$id_func." && data = '".$data."' ORDER BY id DESC";
		$result = mysql_query($query);
		if(mysql_num_rows($result) > 0){// se não tem nenhum registro no dia retorna 0 que significa o fim do expediente
			$row = mysql_fetch_array($result, MYSQL_ASSOC);
			
			return $row['tipo'];
		}else{
			return 0;
		}
	}


	public function get_horario_by_func_and_data($id_func, $data){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();

		$query = "SELECT * FROM horarios WHERE id_funcionario = '".$id_func."' && data LIKE '%".$data."%' ORDER BY data DESC";
		// echo '<script> alert("'.$query.'"); </script>';
		$result = mysql_query($query);
		$aux=0;
		while($row = mysql_fetch_array($result) ){
			// echo '<script> alert("ENCONTROU: '.$query.'"); </script>';
			$return[$aux][0] = $row['id'];
			$return[$aux][1] = $row['situacao'];
			$return[$aux][2] = $row['data'];
			$return[$aux][3] = $row['hora'];
			$return[$aux][4] = $row['tipo'];
			$return[$aux][5] = $row['id_funcionario'];
			
			$aux++;
		}
		return $return;
	}

	public function get_horario_by_id($id){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$query = "SELECT * FROM horarios WHERE id = '%s'";
		$result = $g->tratar_query($query, $id);

		if(@mysql_num_rows($result) > 0){
			$row = mysql_fetch_array($result);
			$this->hora = $row['hora'];
			$this->data = $row['data'];
			$this->tipo = $row['tipo'];
			$this->id_funcionario = $row['id_funcionario'];
			$this->id_obs_supervisor = $row['id_obs_supervisor'];
			$this->observacao_funcionario = $row['observacao_funcionario'];
			$this->situacao = $row['situacao'];

			return $this;
		}else{
			return false;
		}



	}

	
	public function verifica_atraso($hora_turno, $hora_login){
		$hora_login = strtotime($hora_login);
		$hora_turno = strtotime($hora_turno);

		if($hora_login > $hora_turno){
			return true;
		}
	}

	public function verifica_antecedencia($hora_turno, $hora_login){
		$hora_login = strtotime($hora_login);
		$hora_turno = strtotime($hora_turno);

		if($hora_turno > $hora_login){
			return true;
		}
	}

	public function get_hora_atraso($hora_turno, $hora_login){//
		//0 h 11m
		$horario = new Horarios();

		$atraso = $horario->dif_horario($hora_turno, $hora_login);//retorna a diferença de horario
		
		$hora = explode("h", $atraso);// explode string para pegar somente a hora
		
		$hora_atraso = $hora[0];
		
		return $hora_atraso;
	}

	public function get_min_atraso($hora_turno, $hora_login){//
		//0 h 11m
		$horario = new Horarios();
		
		$atraso = $horario->dif_horario($hora_turno, $hora_login);//retorna a diferença de horario
		
		$hora = explode("h", $atraso);// explode string para pegar somente o minuto
		
		$hora_atraso = $hora[1];

		$minuto = explode("m", $hora_atraso);
		
		
		return $minuto[0];
	}



	public function get_hora_ant($hora_turno, $hora_login){
		//0 h 11m
		$horario = new Horarios();

		$ant = $horario->dif_horario($hora_login, $hora_turno); //retorna a diferença de horario
		
		$hora = explode("h", $ant); // explode string para pegar hora
		
		$hora_ant = $hora[0];
		
		return $hora_ant;
	}

	public function get_minutos_ant($hora_turno, $hora_login){
			
		$horario = new Horarios();
		
		$atraso = $horario->dif_horario($hora_login, $hora_turno);//retorna a diferença de horario
		
		$hora = explode("h", $atraso);// explode string para pegar minuto
		
		$hora_atraso = $hora[1];

		$minuto = explode("m", $hora_atraso);
		
		return $minuto[0];
	}
	public function get_atrasos($data){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$func = new Funcionario();
		$aux=0;
		$return = array();
		$query = "SELECT * FROM horarios WHERE data = '".$data."' && situacao LIKE '%+%' ORDER BY id_funcionario, hora ASC";

		$query_ex = mysql_query($query);
		
		while($result =  mysql_fetch_array($query_ex) ){
			// echo '<script> alert("'.$query.'") </script>';
			$hora = $result['situacao'];
			$minuto = $hora[3];
			if(preg_match("/^([0-9]+)$/i", $hora[4])){
				$minuto.=$hora[4];
			}
			if($hora[1] > 0 || $minuto > $_SESSION['temp_limit_atraso']){
				$return[$aux][0] = $result['id'];
				$return[$aux][1] = $result['hora'];
				$return[$aux][2] = $result['situacao'];
				$return[$aux][3] = $func->get_nome_by_id($result['id_funcionario']);
				if($result['tipo'] == 1){
					$return[$aux][4] = "Iniciou o expediente";
				}else if($result['tipo'] == 2){
					$return[$aux][4] = "Saiu para almoço";
				}else if($result['tipo'] == 3){
					$return[$aux][4] = "Encerrou o almoço";
				}else{
					$return[$aux][4] = "Encerrou o expediente";
				}
				$return[$aux][5] = $result['id_obs_supervisor'];
				$aux++;
			}
			
		}
		return $return;
	}
	public function get_atrasos_intervalo_func($data_inicio, $data_final, $id_funcionario){
		$sql = new Sql();
		$sql->conn_bd();
		$g = new Glob();
		$func = new Funcionario();
		$aux=0;
		$return = array();

		$query = "SELECT * FROM horarios WHERE data >= '".$data_inicio."' && data <= '".$data_final."' && id_funcionario = '".$id_funcionario."' && situacao LIKE '%+%' ORDER BY data, hora ASC";
		 // echo '<script> alert("'.$query.'") </script>';

		// $query_tra = $g->tratar_query($query, $data);
		$query_ex = mysql_query($query);
		
		while($result =  mysql_fetch_array($query_ex) ){
			// echo '<script> alert("'.$query.'") </script>';
			$hora = $result['situacao'];
			$minuto = $hora[3];
			if(preg_match("/^([0-9]+)$/i", $hora[4])){
				$minuto.=$hora[4];
			}
			if($hora[1] > 0 || $minuto > $_SESSION['temp_limit_atraso']){
				$return[$aux][0] = $result['id'];
				$return[$aux][1] = $result['hora'];
				$return[$aux][2] = $result['situacao'];
				$return[$aux][3] = $func->get_nome_by_id($result['id_funcionario']);
				if($result['tipo'] == 1){
					$return[$aux][4] = "Iniciou o expediente";
				}else if($result['tipo'] == 2){
					$return[$aux][4] = "Saiu para almoço";
				}else if($result['tipo'] == 3){
					$return[$aux][4] = "Encerrou o almoço";
				}else{
					$return[$aux][4] = "Encerrou o expediente";
				}
				$return[$aux][5] = $result['id_obs_supervisor'];
				$return[$aux][6] = $result['data'];
				$return[$aux][7] = $result['observacao_funcionario'];
				$aux++;
			}
			
		}
		return $return;
	}
	public function get_registros_esquecidos($data, $tipo, $data2){
			$sql = new Sql();
			$sql->conn_bd();
			$g = new Glob();
			$func = new Funcionario();
			$return = array();
			$aux = 0;
			// $query = "SELECT * FROM horarios_registrados WHERE data = '".$data."' and (tipo_1 = 0 or tipo_2 = 0 or tipo_3 = 0 or tipo_0 = 0)";
			if($tipo == 0){//busca uma data
					$query = "SELECT horarios.* FROM horarios_registrados as horarios inner join funcionario as func WHERE horarios.data = '".$data.
						"' and (horarios.tipo_1 = 0 or horarios.tipo_2 = 0 or horarios.tipo_3 = 0 or horarios.tipo_0 = 0) and func.oculto = 0 and
						 horarios.id_funcionario = func.id && id_empresa = '".$_SESSION['id_empresa']."' ORDER BY data ASC";
			}else if($tipo == 1){//busca um mes
					$query = "SELECT horarios.* FROM horarios_registrados as horarios inner join funcionario as func WHERE horarios.data LIKE '%".$data.
					"%' and data <= '".date('Y-m-d')."' and (horarios.tipo_1 = 0 or horarios.tipo_2 = 0 or horarios.tipo_3 = 0 or horarios.tipo_0 = 0) 
					and func.oculto = 0 and horarios.id_funcionario = func.id && id_empresa = '".$_SESSION['id_empresa']."' ORDER BY data ASC";
			}else if($tipo == 2){//busca por funcionario
					$query = "SELECT horarios.* FROM horarios_registrados as horarios inner join funcionario as func WHERE func.nome LIKE '%".$data."%' and (horarios.tipo_1 = 0 or horarios.tipo_2 = 0 or horarios.tipo_3 = 0 or horarios.tipo_0 = 0) 
					and func.oculto = 0 and horarios.id_funcionario = func.id && id_empresa = '".$_SESSION['id_empresa']."' ORDER BY data ASC";
			}else{// busca por intervalo de datas
					$query = "SELECT horarios.* FROM horarios_registrados as horarios inner join funcionario as func WHERE horarios.data BETWEEN date('".$data."') 
					AND date('".$data2."') AND horarios.data <= '".date('Y-m-d')."' AND (horarios.tipo_1 = 0 or horarios.tipo_2 = 0 or horarios.tipo_3 = 0 or horarios.tipo_0 = 0) 
					and func.oculto = 0 and horarios.id_funcionario = func.id && id_empresa = '".$_SESSION['id_empresa']."' ORDER BY data ASC";
			}

			$query_ex = mysql_query($query);
			
			while( $row = mysql_fetch_array($query_ex) ){
				$return[$aux][0] = $row['id'];
				$return[$aux][1] = $row['data'];
				$return[$aux][2] = $row['id_funcionario'];
				$return[$aux][3] = $row['tipo_1'];
				$return[$aux][4] = $row['tipo_2'];
				$return[$aux][5] = $row['tipo_3'];
				$return[$aux][6] = $row['tipo_0'];
				$aux++;
			}
			
			return $return;

	}
	public function inicia_horarios_esquecidos(){

		$horarios_esquecidos = new Horarios();
		//echo '<script> del(); limCamp();</script>';//limpando campos login e senha							
		$date = strtotime('+30 days');
		// echo "<script>alert('".date('d/m/Y', $date)."');</script>";
		$data_30 = date('Y/m/d', $date);
		$dias = explode('/', $data_30);
		$funcionarios = new Funcionario();
		$funcionarios = $funcionarios->get_all_id_func();
		
		$data = date('Y-m-d');

		for($dia=0; $dia <= 10; $dia++){// conta 10 dias pra frente, e adiciona os registros na tabela
			$date_mais_um = strtotime($data.'+'.$dia.' days');
			$data_atual = date('Y-m-d', $date_mais_um);

			for($aux = 0 ; $aux < count($funcionarios) ; $aux++){
				if( $horarios_esquecidos->not_exists($data_atual, $funcionarios[$aux][0])){
					$horarios_esquecidos->cadHorariosEsquecidos($data_atual,  $funcionarios[$aux][0]);
					$horarios_esquecidos->insertHorariosEsquecidosBd();
					// echo "<script>alert('Não Existe,\\n****** ATENÇÃO ******\\nAVISAR CASO APAREÇA ESSA MENSAGEM!!!!');</script>";
				}else{
					// echo "<script>alert('existe: ".$data_atual."');</script>";
				}
			}
			// echo "<script>alert('".$dia."');</script>";
			
		}
	}
	

}

 ?>
