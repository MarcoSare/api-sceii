<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
require_once('../modelsDao/connection.php');
include_once "../vendor/autoload.php";
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    class authorization extends baseDatos{
        function authorizationByTypeUSer($tipoUsuario){
            try{
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                //$jwt = new jsonWebToken();
                $this->consulta("CALL veri_token('".$token."');");
                $jwt_decode = $this->decode_jwt($token);
                $array = json_decode(json_encode($jwt_decode, true),true);
                if(isset($array['data']['typeUser']))
                    if($array['data']['typeUser']==$tipoUsuario)
                    return $array;
                    else{
                        $this->status401('Usted no tiene permisos');
                        exit;
                    }
                   
                    else {
                        $this->status401('Usted no tiene permisos');
                    }
                    
            }
            catch(Exception $e){
                $this->status401('Usted no tiene permisos');
                exit;
            }

        }
        function decode_jwt($token){
            $jwt_decode = JWT::decode($token, new Key("sceiiv199", 'HS256'));
            return  $jwt_decode;
        }

        function status401($message, $data=null){
            http_response_code(201);
            if(isset($data))
            $array = [
                "message" => $message,
                "data" => $data
            ];
            
            else
            $array = [
                "message" => $message,
            ];
            echo json_encode($array);
        }


    }
        


?>