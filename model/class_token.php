<?php 
include_once("class_sql.php");

class token{

	public $id;
	public $token;
	public $data;
	public $invalido;

	public function add_token($token, $data, $invalido){
		$this->token = $token;
		$this->data = $data;
		$this->invalido = $invalido;
	}

	public function add_token_bd(){
		$sql = new Sql();
		$sql->conn_bd();

		$sql = "INSERT INTO token (token, data, invalido) VALUES ('".$this->token."','".$this->data."','".$this->invalido."')";

		if(mysql_query($sql)){
			return true;
		}else{
			return false;
		}
	}

	public function verifica_email($email){
		$sql = new Sql();
		$sql->conn_bd();

		$sqlFun = "SELECT count(id) as cont FROM funcionario WHERE email = '".$email."' && oculto = 0";

		$resultFun = mysql_query($sqlFun);

		$rowFun = mysql_fetch_array($resultFun);

		if($rowFun['cont'] == 0){
			return false;
		}else{
			return true;
		}
	}

	public function verificaToken($token){
		$sql = new Sql();
		$sql->conn_bd();

		$sqlFun = "SELECT count(id) as cont FROM funcionario WHERE md5(concat_ws('',email, CURRENT_DATE)) = '".$token."' && oculto = 0";

		$resultFun = mysql_query($sqlFun);

		$rowFun = mysql_fetch_array($resultFun);

		if($rowFun['cont'] == 0){
			return false;
		}

		$sql = "SELECT count(id) as cont FROM token WHERE token = '".$token."' && invalido = 0";

		$result = mysql_query($sql);

		$row = mysql_fetch_array($result);

		if($row['cont'] > 0){
			return true;
		}else{
			return false;
		}
	}


	// TOKEN SISTEMA PONTO

	public function validar($token, $mac){
        $c_sql = new Sql();
        $c_sql->conn_bd();

        $sql = "SELECT COUNT(id) AS cont FROM mac_validos WHERE md5(mac) = '".$mac."' && status_mac = 0";

        $result = mysql_query($sql);

        $row_mac = mysql_fetch_array($result);

        if($row_mac['cont'] == 0){
            return false;
        }


        $sql = "SELECT COUNT(id) AS cont FROM token WHERE token = '".$token."' && invalido = 0";

        $result = mysql_query($sql);

        $row_token = mysql_fetch_array($result);

        if($row_token['cont'] == 0){
            // echo "<script>alert('False');</script>";
            return false;
        }

        $_SESSION['ac_lib_a_cp'] = true;

        return true;
    }

    public function validar_mac($mac){
        $c_sql = new Sql();
        $c_sql->conn_bd();

        $sql = "SELECT COUNT(id) AS cont FROM mac_validos WHERE md5(mac) = '".$mac."' && status_mac = 0";

        $result = mysql_query($sql);

        $row_mac = mysql_fetch_array($result);

        if($row_mac['cont'] == 0){
            return false;
        }


        return true;
    }

    public function validar_token($token){
        $c_sql = new Sql();
        $c_sql->conn_bd();



        $ultimo_id = Token::ult_id_token();

        $token_valido = "control:".$ultimo_id;
        //b9ee0aab4a07f4b062182214a82758c
        // echo "<script>alert('".md5($token_valido)." - $token');</script>";
        if(md5($token_valido) == $token){
            return true;
        }

        return false;
    }

    public function ult_id_token(){
        $c_sql = new Sql();
        $c_sql->conn_bd();

        $sql = "SELECT id FROM token ORDER BY id DESC";

        $result = mysql_query($sql);

        $row_token = mysql_fetch_array($result);

        if($row_token['id'] != 0){
            // echo "<script>alert('False');</script>";
            return $row_token['id']+1;
        }
        
        return false;
    }

    public function add_token_acesso($token){
        $c_sql = new Sql();
        $c_sql->conn_bd();

        $sql = "SELECT COUNT(id) AS cont FROM token WHERE token = '".$token."'"; // verifica se ja existe esse token, se existe não cria

        $result = mysql_query($sql);

        $row_t = mysql_fetch_array($result);

        if($row_t['cont'] > 0){
            return false;
        }

        $sql = "INSERT INTO token (token, invalido) VALUES ('".$token."', 0 )";

        if(mysql_query($sql)){
            return true;
        }

        return false;

        // $sql = "SELECT COUNT(id) AS cont FROM token WHERE token = '".$token."' && status = 0";

        // $result = mysql_query($sql);

        // $row_token = mysql_fetch_array($result);

        // if($row_token['cont'] == 0){
        //     return false;
        // }

        
    }

    public function invalidar_token($token){
        $c_sql = new Sql();
        $c_sql->conn_bd();

        $sql = "UPDATE token SET invalido = '1' WHERE token = '".$token."'";

        if(mysql_query($sql)){
            return true;
        }

        return false;
        
    }


}

 ?>