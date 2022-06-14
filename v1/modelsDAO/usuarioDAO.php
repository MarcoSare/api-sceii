<?php
require('connection.php');
require "../vendor/autoload.php";
use Firebase\JWT\JWT;

class usuarioDAO extends baseDatos{
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
	} 

}


?>