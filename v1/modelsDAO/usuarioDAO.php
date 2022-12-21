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
use Firebase\JWT\Key;

class usuarioDAO extends baseDatos{

	function login($usuario){
		try{
			$parms="";
			$parms.="'".$usuario['correo']."'";
			$parms.=",'".$usuario['clave']."'";
			$this->consulta("CALL login(".$parms.");");
			$asoc = $this->get_array_query();
			$array = array (
				"status" => true,
				"data" => $asoc);
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

	function dar_alta(){
		try{
			$headers = apache_request_headers();
			$token = "";
                if(isset($headers['Authorization']))
                $token = $headers['Authorization'];
                if(isset($headers['authorization']))
                $token = $headers['authorization'];
                if($token===""){
				$array = [
					"status" => false,
					"error" => "Usted no tiene permisos",
					];
				return $array;

			}
			$jwt_decode = $this->decode_jwt($token);
			$array = json_decode(json_encode($jwt_decode, true),true);
			$id = $array['data']['id'];
			
			$registro = $this->saca_registro("CALL alta_cuenta('".$id."');");
			$nombre = $registro->nombre;
			$array = array (
				"status" => true,
				"data" => array(
					"nombre" => $nombre
				)
				);
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


    
	function editUsuario($data, $id){
		try{
			$parms="";
			$parms.="'".$id."'";
			$parms.=",'".$data['nombre']."'";
            $parms.=",'".$data['apellidos']."'";
            $parms.=",'".$data['clave']."'";
            $parms.=",'".$data['genero']."'";
            $parms.=",'".$data['fecha_nacimiento']."'";
			$parms.=",'".$data['foto_perfil']."'";
			$parms.=",'".$data['claveConfirm']."'";
			$this->consulta("CALL edit_usuario(".$parms.");");
			$array = array (
				"status" => true,
			);
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

	function deleteUsuario($data, $id){
		try{
			$parms="";
			$parms.="'".$id."'";
			$parms.=",'".$data['claveConfirm']."'";
			$this->consulta("CALL delete_usuario(".$parms.");");
			$array = array (
				"status" => true,
			);
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

	function getUsuario($id){
		try{
			$this->consulta("CALL get_usuario(".$id.");");
			$asoc = $this->get_array_query();
			$array = array (
				"status" => true,
				"data" => $asoc 
			);
			return $array;
			}
			catch (Exception $e){
			    echo($e);
			$array = [
				"status" => false,
				"error" => $e->getMessage(),
				];
			return $array;
			}

	}


	function getCodigoForgetPass($data){
		try{
			$codigo = $this->getCodigo();
			$this->consulta("CALL get_codigo_forget_pass('".$data['correo']."','".$codigo."');");
			$array = array (
				"status" => true,
				"data" => array(
					"codigo" => $codigo
				)
				);
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

	function veriCodigoForgetPass($data){
		try{
			$this->consulta("CALL veri_codigo_forget_pass('".$data['correo']."','".$data['codigo']."');");
			$array = array (
				"status" => true,
				);
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

	function cambiaPassword($data){
		try{
			$this->consulta("CALL cambia_password('".$data['correo']."','".$data['clave']."');");
			$array = array (
				"status" => true,
				);
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

	function getIdUser($id,$tipoUsuario){
		try{
			$registro =	$this->saca_registro("CALL get_id_user('".$id."','".$tipoUsuario."');");
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

	function getCodigo(){
		$codigo="";
		for($i=0;4>$i;$i++)
		$codigo.=chr(rand(48,57)); //numero del 0 al 9	
		return $codigo;
	}
	
	function insertToken($correo){
		$registro = $this->saca_registro("select id, tipoUsuario from usuario where correo = '".$correo."'");
        $id = $registro->id;
		$typeUser = $registro->tipoUsuario;
        $token = $this->creaToken($id,$correo,$typeUser);
        $this->consulta("CALL insert_token('".$correo."','".$token."')");
		return $token;
	}
	
	function decode_jwt($token){
		$jwt_decode = JWT::decode($token, new Key("sceiiv199", 'HS256'));
		return  $jwt_decode;
	}

}


?>