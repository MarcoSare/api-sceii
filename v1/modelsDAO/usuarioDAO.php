<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});

require_once('connection.php');
require_once "../vendor/autoload.php";
use Firebase\JWT\JWT;

class usuarioDAO extends baseDatos{

	function login($usuario){
		try{
			$parms="";
			$parms.="'".$usuario['correo']."'";
			$parms.=",'".$usuario['clave']."'";
			$registro =	$this->saca_registro("CALL login(".$parms.");");
			$token = $registro->token;
			$array = array (
				"status" => true,
				"data" => array(
					"token" => $token
				));
			return $array;
			}
			catch (Exception $e){
			$array = [
				"status" => false,
				"error" => $e->getMessage(),
				];
			return $array;
			}
	}

	function getIdTypeUser($id){
		try{
			$registro =	$this->saca_registro("CALL get_id_tipo_Usuario('".$id."');");
			return $registro->id;
			}
			catch (Exception $e){
			return null;
			}
	}



    function creaToken($id,$correo, $typeUser){
		$time = time();
		$token = array(
			"iat" => $time,
			"exp" => $time + (86400*180),
			"data" => [
				"id" => $id,
				"correo" => $correo,
				"typeUser" => $typeUser
			]
			);
			$jwt = JWT::encode($token,"sceiiv199","HS256");
			return $jwt;
	}
	
	function insertToken($correo){
		$registro = $this->saca_registro("select id, tipoUsuario from usuario where correo = '".$correo."'");
        $id = $registro->id;
		$typeUser = $registro->tipoUsuario;
        $token = $this->creaToken($id,$correo,$typeUser);
        $this->consulta("CALL insert_token('".$correo."','".$token."')");
		return $token;
	} 

}


?>