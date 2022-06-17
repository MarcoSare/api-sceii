<?php

set_error_handler(function($errno, $errstr, $errfile, $errline) {
    // error was suppressed with the @-operator
    if (0 === error_reporting()) {
        return false;
    }
    
    throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
});
require_once('../modelsDao/connection.php');
require_once('../controllers/responseHttp.php');
include_once "../vendor/autoload.php";
    use Firebase\JWT\JWT;
    use Firebase\JWT\Key;
    class authorization extends baseDatos{

        function authorizationByTypeUSer($tipoUsuario){
            try{
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                $this->consulta("CALL veri_token('".$token."');");
                $jwt_decode = $this->decode_jwt($token);
                $array = json_decode(json_encode($jwt_decode, true),true);
                    if($array['data']['typeUser']==$tipoUsuario)
                    return $array;
                    else{
                        $http = new responseHttp();
                        $http->status401('Usted no tiene permisos');
                        exit;
                    }
            }
            catch(Exception $e){
                $http = new responseHttp();
                $http->status401('Usted no tiene permisos');
                exit;
            }

        }

        function authorizationById($id){
            try{
                $headers = apache_request_headers();
                $token = $headers['Authorization'];
                $this->consulta("CALL veri_token('".$token."');");
                $jwt_decode = $this->decode_jwt($token);
                $array = json_decode(json_encode($jwt_decode, true),true);
                
                    if($array['data']['id']==$id)
                    return $array;
                    else{
                        $http = new responseHttp();
                        $http->status401('Usted no tiene permisos');
                        exit;
                    }
            }
            catch(Exception $e){
                $http = new responseHttp();
                $http->status401('Usted no tiene permisos');
                exit;
            }

        }




        function decode_jwt($token){
            $jwt_decode = JWT::decode($token, new Key("sceiiv199", 'HS256'));
            return  $jwt_decode;
        }

        


    }
        


?>